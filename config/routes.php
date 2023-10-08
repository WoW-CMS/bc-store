<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['store']['get'] = 'store/index';
$route['store/category/(:any)']['get'] = 'store/category/$1';
$route['store/product/(:num)'] = 'store/product/$1';
$route['store/cart']['get'] = 'store/cart';
$route['store/cart/checkout']['get'] = 'store/checkout';
$route['store/cart/delete/(:any)']['get'] = 'store/remove_product/$1';
$route['store/cart/quantity']['post'] = 'store/update_quantity';
$route['store/orders']['get'] = 'store/orders';
$route['store/orders/view/(:num)']['get'] = 'store/view_order/$1';

$route['store/admin']['get'] = 'admin/index';
$route['store/admin/settings'] = 'admin/settings';
$route['store/admin/categories']['get'] = 'admin/categories';
$route['store/admin/categories/add'] = 'admin/add_category';
$route['store/admin/categories/edit/(:num)'] = 'admin/edit_category/$1';
$route['store/admin/categories/delete/(:num)']['get'] = 'admin/delete_category/$1';
$route['store/admin/categories/move/(:num)/(:any)']['get'] = 'admin/move_category/$1/$2';
$route['store/admin/products']['get'] = 'admin/products';
$route['store/admin/products/add'] = 'admin/add_product';
$route['store/admin/products/edit/(:num)'] = 'admin/edit_product/$1';
$route['store/admin/products/delete/(:num)']['get'] = 'admin/delete_product/$1';
$route['store/admin/products/(:num)']['get'] = 'admin/commands/$1';
$route['store/admin/products/(:num)/add'] = 'admin/add_command/$1';
$route['store/admin/products/(:num)/edit/(:num)'] = 'admin/edit_command/$1/$2';
$route['store/admin/products/(:num)/delete/(:num)']['get'] = 'admin/delete_command/$1/$2';
$route['store/admin/orders']['get'] = 'admin/orders';
$route['store/admin/orders/view/(:num)']['get'] = 'admin/view_order/$1';
