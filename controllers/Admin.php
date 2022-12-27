<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2022, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_module_installed('store', true);

        $this->load->model([
            'store_category_model',
            'store_command_model',
            'store_order_model',
            'store_order_product_model',
            'store_product_model'
        ]);

        $this->load->language('store');
    }

    public function index()
    {
        $data = [
            'total_categories' => $this->store_category_model->count_all(),
            'total_products'   => $this->store_product_model->count_all(),
            'total_purchases'  => $this->store_order_model->count_all(),
            'latest_orders'    => $this->store_order_model->latest()
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->template->build('admin/index', $data);
    }

    public function settings()
    {
        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('products_per_page', lang('products_per_page'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('mail_subject', lang('mail_subject'), 'trim|required|alpha_numeric_spaces|max_length[100]');
        $this->form_validation->set_rules('mail_body', lang('mail_body'), 'trim|required|alpha_numeric_spaces|max_length[250]');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            $this->setting_model->update_batch([
                [
                    'key'   => 'store_products_per_page',
                    'value' => $this->input->post('products_per_page')
                ],
                [
                    'key'   => 'store_mail_subject',
                    'value' => $this->input->post('mail_subject')
                ],
                [
                    'key'   => 'store_mail_body',
                    'value' => $this->input->post('mail_body')
                ]
            ], 'key');

            $this->log_model->create('store settings', 'edit', 'Edited the settings');

            $this->cache->delete('settings');

            $this->session->set_flashdata('success', lang('alert_settings_updated'));
            redirect(site_url('store/admin/settings'));
        } else {
            $this->template->build('admin/settings/index');
        }
    }

    public function categories()
    {
        $data = [
            'categories' => $this->store_category_model->find_all(['parent' => 0]),
            'last'       => $this->store_category_model->last_item_sort()
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->template->build('admin/categories/index', $data);
    }

    public function add_category()
    {
        require_permission('add.categories');

        $data = [
            'parents' => $this->store_category_model->find_all(['type' => ITEM_DROPDOWN, 'parent' => 0])
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('name', lang('name'), 'trim|required');
        $this->form_validation->set_rules('slug', lang('slug'), 'trim|required|alpha_dash|is_unique[store_categories.slug]');
        $this->form_validation->set_rules('type', lang('type'), 'trim|required|in_list[link,dropdown]');
        $this->form_validation->set_rules('parent', lang('parent'), 'trim|required|is_natural');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            $type   = $this->input->post('type');
            $parent = $this->input->post('parent');

            // Prevent create dropdown item inside another
            if ($type === ITEM_DROPDOWN && (int) $parent > 0) {
                $this->session->set_flashdata('error', lang('alert_category_not_dropdown'));
                redirect(site_url('store/admin/categories/add'));
            }

            $this->store_category_model->insert([
                'name'   => $this->input->post('name'),
                'slug'   => strtolower($this->input->post('slug')),
                'type'   => $type,
                'parent' => $parent,
                'sort'   => $this->store_category_model->last_item_sort($parent) + 1
            ]);

            $categoryId = $this->db->insert_id();

            $this->log_model->create('store category', 'add', 'Added a category', [
                'category' => $this->input->post('name')
            ], 'store/admin/categories/edit/' . $categoryId);

            $this->cache->delete('store_categories');

            $this->session->set_flashdata('success', lang('alert_category_added'));
            redirect(site_url('store/admin/categories/edit/' . $categoryId));
        } else {
            $this->template->build('admin/categories/add', $data);
        }
    }

    /**
     * Edit store category
     *
     * @param int $categoryId
     * @return string|void
     */
    public function edit_category($categoryId = null)
    {
        require_permission('edit.categories');

        $category = $this->store_category_model->find(['id' => $categoryId]);

        if (empty($category)) {
            show_404();
        }

        $data = [
            'category' => $category,
            'parents'  => $this->store_category_model->find_all(['type' => ITEM_DROPDOWN, 'parent' => 0])
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('name', lang('name'), 'trim|required');
        $this->form_validation->set_rules('slug', lang('slug'), 'trim|required|alpha_dash|update_unique[store_categories.slug.' . $categoryId . ']');
        $this->form_validation->set_rules('type', lang('type'), 'trim|required|in_list[link,dropdown]');
        $this->form_validation->set_rules('parent', lang('parent'), 'trim|required|is_natural');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            $type   = $this->input->post('type');
            $parent = $this->input->post('parent');

            // Prevent create dropdown item inside another
            if ($type === ITEM_DROPDOWN && (int) $parent > 0) {
                $this->session->set_flashdata('error', lang('alert_category_not_dropdown'));
                redirect(site_url('store/admin/categories/edit/' . $categoryId));
            }

            $set = [
                'name'   => $this->input->post('name'),
                'slug'   => strtolower($this->input->post('slug')),
                'type'   => $type,
                'parent' => $parent
                
            ];

            if ($category->parent !== $parent) {
                $set['sort'] = $this->community_model->last_item_sort($parent) + 1;
            }

            $this->store_category_model->update($set, ['id' => $categoryId]);

            $this->log_model->create('store category', 'edit', 'Edited a category', [
                'category' => $this->input->post('name')
            ], 'store/admin/categories/edit/' . $categoryId);

            $this->cache->delete('store_categories');

            $this->session->set_flashdata('success', lang('alert_category_updated'));
            redirect(site_url('store/admin/categories/edit/' . $categoryId));
        } else {
            $this->template->build('admin/categories/edit', $data);
        }
    }

    /**
     * Move store category order
     *
     * @param int $categoryId
     * @param string $action
     * @return void
     */
    public function move_category($categoryId = null, $action = null)
    {
        require_permission('delete.categories');

        $category = $this->store_category_model->find(['id' => $categoryId]);

        if (empty($category) || ! in_array($action, ['up', 'down'], true)) {
            show_404();
        }

        $last = $this->store_category_model->last_item_sort($category->parent);

        if ($category->sort <= 1 && $action === 'up' || ($category->sort + 1) > $last && $action === 'down') {
            show_404();
        }

        if ($action === 'up') {
            $this->store_category_model->set(['sort' => 'sort+1'], [
                'parent' => $category->parent,
                'sort'   => $category->sort - 1
            ], false);
        } else {
            $this->store_category_model->set(['sort' => 'sort-1'], [
                'parent' => $category->parent,
                'sort'   => $category->sort + 1
            ], false);
        }

        $this->store_category_model->update([
            'sort' => $action === 'up' ? $category->sort - 1 : $category->sort + 1
        ], ['id' => $categoryId]);

        $this->cache->delete('store_categories');

        $this->session->set_flashdata('success', lang('alert_category_moved'));
        redirect(site_url('store/admin/categories'));
    }

    /**
     * Delete store category
     *
     * @param int $categoryId
     * @return void
     */
    public function delete_category($categoryId = null)
    {
        $category = $this->store_category_model->find(['id' => $categoryId]);

        if (empty($category)) {
            show_404();
        }

        $this->store_category_model->delete(['id' => $categoryId]);

        $this->log_model->create('store category', 'delete', 'Deleted a category', [
            'category' => $category->name
        ]);

        $this->session->set_flashdata('success', lang('alert_category_deleted'));
        redirect(site_url('store/admin/categories'));
    }

    public function products()
    {
        $inputSearch = $this->input->get('search');
        $inputPage   = $this->input->get('page');
        $page        = ctype_digit((string) $inputPage) ? (int) $inputPage : 0;

        $perPage = 50;
        $offset  = $page > 1 ? ($page - 1) * $perPage : $page; // Calculate offset for paginate
        $filters = ['search' => trim(xss_clean($inputSearch))];

        $this->pagination->initialize([
            'base_url'   => site_url('store/admin/products'),
            'total_rows' => $this->store_product_model->total_paginate($filters),
            'per_page'   => $perPage
        ]);

        $data = [
            'products'   => $this->store_product_model->paginate($perPage, $offset, $filters),
            'pagination' => $this->pagination->create_links(),
            'search'     => $inputSearch
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->template->build('admin/products/index', $data);
    }

    public function add_product()
    {
        require_permission('add.products');

        $data = [
            'categories' => $this->store_category_model->find_all(['type' => ITEM_LINK]),
            'realms'     => $this->realm_model->find_all()
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->template->body_tags([
            ['script', ['src' => base_url('assets/js/media-preview.js')]]
        ]);

        $this->form_validation->set_rules('name', lang('name'), 'trim|required|callback__valid_product_name');
        $this->form_validation->set_rules('category', lang('category'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('realm', lang('realm'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('description', lang('description'), 'trim');
        $this->form_validation->set_rules('file', lang('file'), 'callback__file_required');
        $this->form_validation->set_rules('currency', lang('currency'), 'trim|required|in_list[dp,vp,both]');
        $this->form_validation->set_rules('dp', lang('dp'), 'trim|is_natural');
        $this->form_validation->set_rules('vp', lang('vp'), 'trim|is_natural');
        $this->form_validation->set_rules('visible', lang('visible'), 'trim');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            $directory = current_date('Y') . '/' . current_date('m') . '/';

            if (! is_dir(FCPATH . 'uploads/' . $directory)) {
                mkdir(FCPATH . 'uploads/' . $directory, 0755, true);
            }

            $this->load->library('upload', [
                'upload_path'   => FCPATH . 'uploads/' . $directory,
                'allowed_types' => 'gif|jpg|jpeg|png',
                'encrypt_name'  => true
            ]);

            if (! $this->upload->do_upload('file')) {
                $this->session->set_flashdata('error_list', $this->upload->display_errors('<li>', '</li>'));
                redirect(site_url('store/admin/products/add'));
            }

            $uploadData = $this->upload->data();
            $currency   = $this->input->post('currency');

            $this->store_product_model->insert([
                'category_id' => $this->input->post('category'),
                'realm_id'    => $this->input->post('realm'),
                'name'        => $this->input->post('name'),
                'description' => $this->input->post('description', true),
                'image'       => $directory . $uploadData['file_name'],
                'currency'    => $currency,
                'dp'          => in_array($currency, [CURRENCY_DP, CURRENCY_BOTH], true) ? $this->input->post('dp') : 0,
                'vp'          => in_array($currency, [CURRENCY_VP, CURRENCY_BOTH], true) ? $this->input->post('vp') : 0,
                'visible'     => empty($this->input->post('visible', true)) ? 0 : 1
            ]);

            $productId = $this->db->insert_id();

            $this->log_model->create('store product', 'add', 'Added a product', [
                'product' => $this->input->post('name')
            ], 'store/admin/products/edit/' . $productId);

            $this->session->set_flashdata('success', lang('alert_product_added'));
            redirect(site_url('store/admin/products/edit/'. $productId));
        } else {
            $this->template->build('admin/products/add', $data);
        }
    }

    /**
     * Edit product
     *
     * @param int $productId
     * @return string|void
     */
    public function edit_product($productId = null)
    {
        require_permission('edit.products');

        $product = $this->store_product_model->find(['id' => $productId]);

        if (empty($product)) {
            show_404();
        }

        $data = [
            'product'    => $product,
            'categories' => $this->store_category_model->find_all(['type' => ITEM_LINK]),
            'realms'     => $this->realm_model->find_all()
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->template->body_tags([
            ['script', ['src' => base_url('assets/js/media-preview.js')]]
        ]);

        $this->form_validation->set_rules('name', lang('name'), 'trim|required|callback__valid_product_name');
        $this->form_validation->set_rules('category', lang('category'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('realm', lang('realm'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('description', lang('description'), 'trim');
        $this->form_validation->set_rules('currency', lang('currency'), 'trim|required|in_list[dp,vp,both]');
        $this->form_validation->set_rules('dp', lang('dp'), 'trim|is_natural');
        $this->form_validation->set_rules('vp', lang('vp'), 'trim|is_natural');
        $this->form_validation->set_rules('visible', lang('visible'), 'trim');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            if (isset($_FILES['file']['name']) && $_FILES['file']['name'] !== '') {
                $directory = current_date('Y') . '/' . current_date('m') . '/';

                if (! is_dir(FCPATH . 'uploads/' . $directory)) {
                    mkdir(FCPATH . 'uploads/' . $directory, 0755, true);
                }

                $this->load->library('upload', [
                    'upload_path'   => FCPATH . 'uploads/' . $directory,
                    'allowed_types' => 'gif|jpg|jpeg|png',
                    'encrypt_name'  => true
                ]);

                if (! $this->upload->do_upload('file')) {
                    $this->session->set_flashdata('error_list', $this->upload->display_errors('<li>', '</li>'));
                        redirect(site_url('store/admin/products/edit/' . $id));
                }

                if (is_readable(FCPATH . 'uploads/' . $product->image)) {
                    unlink(FCPATH . 'uploads/' . $product->image);
                }

                $uploadData = $this->upload->data();

                $this->store_product_model->update([
                    'image' => $directory . $uploadData['file_name']
                ], ['id' => $productId]);
            }

            $currency = $this->input->post('currency');

            $this->store_product_model->update([
                'category_id' => $this->input->post('category'),
                'realm_id'    => $this->input->post('realm'),
                'name'        => $this->input->post('name'),
                'description' => $this->input->post('description', true),
                'currency'    => $currency,
                'dp'          => in_array($currency, [CURRENCY_DP, CURRENCY_BOTH], true) ? $this->input->post('dp') : 0,
                'vp'          => in_array($currency, [CURRENCY_VP, CURRENCY_BOTH], true) ? $this->input->post('vp') : 0,
                'visible'     => empty($this->input->post('visible', true)) ? 0 : 1
            ], ['id' => $productId]);

            $this->log_model->create('store product', 'edit', 'Edited a product', [
                'product' => $this->input->post('name')
            ], 'store/admin/products/edit/' . $productId);

            $this->session->set_flashdata('success', lang('alert_product_updated'));
            redirect(site_url('store/admin/products/edit/' . $productId));
        } else {
            $this->template->build('admin/products/edit', $data);
        }
    }

    /**
     * Delete product
     *
     * @param int $productId
     * @return void
     */
    public function delete_product($productId = null)
    {
        require_permission('delete.products');

        $product = $this->store_product_model->find(['id' => $productId]);

        if (empty($product)) {
            show_404();
        }

        if (is_readable(FCPATH . 'uploads/' . $product->image)) {
            unlink(FCPATH . 'uploads/' . $product->image);
        }

        $this->store_product_model->delete(['id' => $productId]);
        $this->store_command_model->delete(['product_id' => $productId]);

        $this->log_model->create('store product', 'delete', 'Deleted a product', [
            'product' => $product->name
        ]);

        $this->session->set_flashdata('success', lang('alert_product_deleted'));
        redirect(site_url('store/admin/products'));
    }

    /**
     * View product commands
     *
     * @param int $productId
     * @return string
     */
    public function commands($productId = null)
    {
        $product = $this->store_product_model->find(['id' => $productId]);

        if (empty($product)) {
            show_404();
        }

        $data = [
            'product'  => $product,
            'commands' => $this->store_command_model->find_all(['product_id'=> $productId])
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->template->build('admin/products/commands', $data);
    }

    /**
     * Add product command
     *
     * @param int $productId
     * @return string|void
     */
    public function add_command($productId = null)
    {
        require_permission('add.products');

        $product = $this->store_product_model->find(['id' => $productId]);

        if (empty($product)) {
            show_404();
        }

        $data = [
            'product' => $product
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        if ($this->input->method() === 'post') {
            $inputs = $this->input->post();

            $this->form_validation->set_rules('type', lang('type'), 'trim|required|in_list[item,custom]');

            if ($inputs['type'] === 'item') {
                $this->form_validation->set_rules('item', lang('item'), 'trim|required|is_natural_no_zero');
                $this->form_validation->set_rules('quantity', lang('quantity'), 'trim|required|is_natural_no_zero');
            } else {
                $this->form_validation->set_rules('command', lang('command'), 'trim|required|callback__valid_custom_command');
            }

            $this->form_validation->set_data($inputs);

            if ($this->form_validation->run()) {
                $this->store_command_model->insert([
                    'product_id' => $productId,
                    'type'       => $inputs['type'],
                    'item'       => $inputs['type'] === 'item' ? $inputs['item'] : 0,
                    'quantity'   => $inputs['type'] === 'item' ? $inputs['quantity'] : 0,
                    'command'    => $inputs['type'] === 'custom' ? $inputs['command'] : ''
                ]);

                $commandId = $this->db->insert_id();

                $this->session->set_flashdata('success', lang('alert_product_added'));
                redirect(site_url('store/admin/products/' . $productId . '/edit/' . $commandId));
            }
        }

        $this->template->build('admin/products/add_command', $data);
    }

    /**
     * Edit product command
     *
     * @param int $productId
     * @param int $commandId
     * @return string|void
     */
    public function edit_command($productId = null, $commandId = null)
    {
        require_permission('edit.products');

        $command = $this->store_command_model->find(['id' => $commandId]);

        if (empty($productId) || empty($command)) {
            show_404();
        }

        $data = [
            'command' => $command
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        if ($this->input->method() === 'post') {
            $inputs = $this->input->post();

            $this->form_validation->set_rules('type', lang('type'), 'trim|required|in_list[item,custom]');

            if ($inputs['type'] === 'item') {
                $this->form_validation->set_rules('item', lang('item'), 'trim|required|is_natural_no_zero');
                $this->form_validation->set_rules('quantity', lang('quantity'), 'trim|required|is_natural_no_zero');
            } else {
                $this->form_validation->set_rules('command', lang('command'), 'trim|required|callback__valid_custom_command');
            }

            $this->form_validation->set_data($inputs);

            if ($this->form_validation->run()) {
                $this->store_command_model->update([
                    'type'     => $inputs['type'],
                    'item'     => $inputs['type'] === 'item' ? $inputs['item'] : 0,
                    'quantity' => $inputs['type'] === 'item' ? $inputs['quantity'] : 0,
                    'command'  => $inputs['type'] === 'custom' ? $inputs['command'] : ''
                ], ['id' => $commandId]);

                $this->session->set_flashdata('success', lang('alert_product_updated'));
                redirect(site_url('store/admin/products/' . $command->item_id . '/edit/' . $commandId));
            }
        }

        $this->template->build('admin/products/edit_command', $data);
    }

    /**
     * Delete product command
     *
     * @param int $productId
     * @return void
     */
    public function delete_command($productId = null, $commandId = null)
    {
        require_permission('delete.products');

        $command = $this->store_command_model->find(['id' => $commandId]);

        if (empty($command)) {
            show_404();
        }

        $this->store_command_model->delete(['id' => $commandId]);

        $this->session->set_flashdata('success', lang('alert_product_deleted'));
        redirect(site_url('store/admin/products/' . $productId));
    }

    public function orders()
    {
        $inputSearch = $this->input->get('search');
        $inputPage   = $this->input->get('page');
        $page        = ctype_digit((string) $inputPage) ? (int) $inputPage : 0;

        $perPage = 50;
        $offset  = $page > 1 ? ($page - 1) * $perPage : $page; // Calculate offset for paginate
        $filters = ['search' => trim(xss_clean($inputSearch))];

        $this->pagination->initialize([
            'base_url'   => site_url('store/admin/orders'),
            'total_rows' => $this->store_order_model->total_paginate($filters),
            'per_page'   => $perPage
        ]);

        $data = [
            'orders'     => $this->store_order_model->paginate($perPage, $offset, $filters),
            'pagination' => $this->pagination->create_links(),
            'search'     => $inputSearch
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->template->build('admin/orders/index', $data);
    }

    /**
     * View order
     *
     * @param int $id
     * @return string
     */
    public function view_order($id = null)
    {
        $order = $this->store_order_model->find(['id' => $id]);

        if (empty($order)) {
            show_404();
        }

        $data = [
            'order'    => $order,
            'products' => $this->store_order_product_model->find_all(['order_id' => $id])
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->template->build('admin/orders/view', $data);
    }

    /**
     * Validate upload file
     *
     * @return bool
     */
    public function _file_required()
    {
        if (isset($_FILES['file']['name']) && $_FILES['file']['name'] !== '') {
            return true;
        }

        $this->form_validation->set_message('_file_required', lang('form_validation_file_required'));
        return false;
    }

    /**
     * Callback to check if the product name is valid
     *
     * @param string $str
     * @return bool
     */
    public function _valid_product_name($str)
    {
        if (preg_match('/^[\w \'\-\.:\[\]]+$/iu', $str) === 1) {
            return true;
        }

        $this->form_validation->set_message('_valid_product_name', lang('form_validation_valid_product_name'));
        return false;
    }

    /**
     * Callback to check if the custom command is valid
     *
     * @param string $str
     * @return bool
     */
    public function _valid_custom_command($str)
    {
        if (preg_match('/^[a-z0-9 :.\{\}]+$/', $str) === 1) {
            return true;
        }

        $this->form_validation->set_message('_valid_custom_command', lang('form_validation_valid_custom_command'));
        return false;
    }
}
