<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2022, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends BS_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_module_installed('store', true);

        require_login();

        require_permission('view.store');

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
            'categories' => $this->store_category_model->categories()
        ];

        $this->template->title(lang('store'), config_item('app_name'));

        $this->template->build('index', $data);
    }

    /**
     * View store category
     *
     * @param string $slug
     * @return string
     */
    public function category($slug = null)
    {
        $category = $this->store_category_model->find(['slug' => $slug]);

        if (empty($category)) {
            show_404();
        }

        $inputPage = $this->input->get('page');
        $page      = ctype_digit((string) $inputPage) ? (int) $inputPage : 0;

        $perPage = config_item('store_products_per_page') ?? 25;
        $offset  = $page > 1 ? ($page - 1) * $perPage : $page; // Calculate offset for paginate
        $filters = ['category' => $category->id, 'visible' => true];

        $this->pagination->initialize([
            'base_url'   => site_url('store/category/' . $slug),
            'total_rows' => $this->store_product_model->total_paginate($filters),
            'per_page'   => $perPage
        ]);

        $data = [
            'category'   => $category,
            'categories' => $this->store_category_model->categories(),
            'products'   => $this->store_product_model->paginate($perPage, $offset, $filters),
            'pagination' => $this->pagination->create_links()
        ];

        $this->template->title(lang('store'), config_item('app_name'));

        $this->template->build('category', $data);
    }

    /**
     * View product
     *
     * @param int $productId
     * @return string
     */
    public function product($productId = null)
    {
        $product = $this->store_product_model->find([
            'id'      => $productId,
            'visible' => 1
        ]);

        if (empty($product)) {
            show_404();
        }

        $userId = $this->session->userdata('id');
        $data   = [
            'categories' => $this->store_category_model->categories(),
            'characters' => $this->server_characters_model->all_characters($product->realm_id, $userId),
            'product'    => $product,
            'category'   => $this->store_category_model->find(['id' => $product->category_id])
        ];

        $this->template->title(lang('store'), config_item('app_name'));

        $this->form_validation->set_rules('guid', lang('character'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('qty', lang('quantity'), 'trim|required|is_natural_no_zero');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            $guid = $this->input->post('guid');
            $qty  = $this->input->post('qty');

            if (! $this->server_characters_model->character_linked($product->realm_id, $guid, $userId)) {
                $this->session->set_flashdata('error', lang('alert_character_not_related'));
                redirect(site_url('store/product/' . $productId));
            }

            $this->cart->insert([
                'id'      => $productId,
                'name'    => $product->name,
                'qty'     => $qty,
                'dp'      => in_array($product->currency, [CURRENCY_DP, CURRENCY_BOTH], true) ? (int) $product->dp : 0,
                'vp'      => in_array($product->currency, [CURRENCY_VP, CURRENCY_BOTH], true) ? (int) $product->vp : 0,
                'options' => [
                    'guid'     => (int) $guid,
                    'realm'    => (int) $product->realm_id,
                    'currency' => $product->currency
                ]
            ]);

            $this->session->set_flashdata('success', lang('alert_cart_product_added'));
            redirect(site_url('store/product/' . $productId));
        } else {
            $this->template->build('product', $data);
        }
    }

    public function cart()
    {
        $data = [
            'contents' => $this->cart->contents()
        ];

        $this->template->title(lang('cart'), config_item('app_name'));

        $this->template->build('cart', $data);
    }
 
    /**
     * Remove product from cart
     *
     * @param string $id
     * @return void
     */
    public function remove_product($id = null)
    {
        if (empty($id)) {
            show_404();
        }

        if ($this->cart->remove($id)) {
            $this->session->set_flashdata('success', lang('alert_cart_product_deleted'));
            redirect(site_url('store/cart'));
        }

        $this->session->set_flashdata('error', lang('alert_cart_product_failed'));
        redirect(site_url('store/cart'));
    }

    public function update_quantity()
    {
        $this->form_validation->set_rules('id', lang('id'), 'trim|required');
        $this->form_validation->set_rules('qty', lang('quantity'), 'trim|required|is_natural_no_zero');

        if ($this->form_validation->run()) {
            $this->cart->update([
                'rowid' => $this->input->post('id', true),
                'qty'   => $this->input->post('qty')
            ]);

            $this->session->set_flashdata('success', lang('alert_product_quantity_updated'));
            redirect(site_url('store/cart'));
        }

        $this->session->set_flashdata('error', lang('alert_product_quantity_invalid'));
        redirect(site_url('store/cart'));
    }

    public function checkout()
    {
        $totalDp    = $this->cart->total_dp();
        $totalVp    = $this->cart->total_vp();
        $totalItems = $this->cart->total_items();
        $user       = user();

        if ($totalItems === 0) {
            $this->session->set_flashdata('warning', lang('alert_cart_empty'));
            redirect(site_url('store/cart'));
        }

        if ((int) $user->dp < $totalDp) {
            $this->session->set_flashdata('error', lang('alert_user_not_dp'));
            redirect(site_url('store/cart'));
        }

        if ((int) $user->vp < $totalVp) {
            $this->session->set_flashdata('error', lang('alert_user_not_vp'));
            redirect(site_url('store/cart'));
        }

        $this->user_model->set([
            'dp' => 'dp-' . $totalDp,
            'vp' => 'vp-' . $totalVp
        ], ['id' => $user->id], false);

        $this->store_order_model->insert([
            'user_id'       => $user->id,
            'products_sold' => $totalItems,
            'total_dp'      => $totalDp,
            'total_vp'      => $totalVp,
            'ip'            => $this->input->ip_address()
        ]);

        $orderId = $this->db->insert_id();
        $cart    = $this->cart->contents();
        $content = [];
        $ids     = [];

        foreach ($cart as $item) {
            // Create a realm array if it doesn't exist
            if (! array_key_exists($item['options']['realm'], $content)) {
                $content[$item['options']['realm']] = [];
            }

            // Create a character guid array if it doesn't exist
            if (! array_key_exists($item['options']['guid'], $content[$item['options']['realm']])) {
                $content[$item['options']['realm']][$item['options']['guid']] = [];
            }

            // If product id exists increase quantity or adds the id to the character GUID array
            if (array_key_exists($item['id'], $content[$item['options']['realm']][$item['options']['guid']])) {
                $content[$item['options']['realm']][$item['options']['guid']][$item['id']]['qty'] += $item['qty'];
            } else {
                $content[$item['options']['realm']][$item['options']['guid']][$item['id']] = [
                    'id'  => $item['id'],
                    'qty' => $item['qty']
                ];
            }

            // Add id to the array if it doesn't exist
            if (! in_array($item['id'], $ids)) {
                $ids[] = $item['id'];
            }

            // Add purchased product to the order
            $this->store_order_product_model->insert([
                'order_id'   => $orderId,
                'product_id' => $item['id'],
                'realm_id'   => $item['options']['realm'],
                'guid'       => $item['options']['guid'],
                'name'       => $item['name'],
                'quantity'   => $item['qty'],
                'dp'         => $item['dp'],
                'vp'         => $item['vp']
            ]);
        }

        $this->cart->destroy();

        // Get all product commands
        $commands = $this->store_command_model->find_in('product_id', $ids);

        // Process content
        foreach ($content as $realm => $characters) {
            foreach ($characters as $character => $products) {
                $placeholders = [
                    '{character}' => $this->server_characters_model->character_name($realm, $character),
                    '{subject}'   => '"' . config_item('store_mail_subject') . '"',
                    '{body}'      => '"' . config_item('store_mail_body') . '"'
                ];

                foreach ($products as $i => $detail) {
                    // Filter commands by product id
                    $filtered = array_filter($commands, fn($command) => $command->product_id == $i);

                    for ($i = 1; $i <= $detail['qty']; $i++) {
                        foreach ($filtered as $command) {
                            $this->realm_model->execute_command($realm, strtr(trim($command->command), $placeholders));
                        }
                    }
                }
            }
        }

        $this->store_order_model->update([
            'status' => Store_order_model::STATUS_COMPLETED
        ], ['id' => $orderId]);

        $this->session->set_flashdata('success', lang('alert_checkout_success'));
        redirect(site_url('store/cart'));
    }
}
