<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['store'] = 'Tienda';
$lang['cart'] = 'Carrito';

$lang['my_orders'] = 'Mis Órdenes';
$lang['product'] = 'Producto';
$lang['products'] = 'Productos';
$lang['order'] = 'Orden';
$lang['orders'] = 'Órdenes';
$lang['order_details'] = 'Detalles de la orden';
$lang['commands'] = 'Comandos';
$lang['custom'] = 'Personalizado';
$lang['products_sold'] = 'Productos vendidos';

$lang['top_products'] = 'Productos destacados';
$lang['view_product'] = 'Ver producto';
$lang['add_cart'] = 'Añadir al carro';

$lang['latest_purchases'] = 'Últimas compras';
$lang['categories_added'] = 'Categorías agregadas';
$lang['products_added'] = 'Productos agregados';
$lang['total_purchases'] = 'Compras totales';

$lang['store_settings_list'] = 'Lista de configuraciones relacionadas con el módulo store.';
$lang['products_per_page'] = 'Productos por página';
$lang['mail_subject'] = 'Asunto del correo';
$lang['mail_body'] = 'Cuerpo del correo';

$lang['enter_products_per_page'] = 'Ingrese un límite de productos por cada página.';
$lang['enter_mail_subject'] = 'Ingrese un asunto dek correo.';
$lang['enter_mail_body'] = 'Ingrese un cuerpo del correo.';

$lang['product_commands'] = 'Comandos del producto';
$lang['variables_command'] = 'Variables para comando';
$lang['character_variable_command'] = '- Reemplazar automáticamente con el nombre del personaje';
$lang['subject_variable_command'] = '- Reemplazar automáticamente con la configuración del asunto del correo';
$lang['body_variable_command'] = '- Reemplazar automáticamente con la configuración del cuerpo del correo';

$lang['catalog'] = 'Catálogo';
$lang['add_category'] = 'Agregar categoría';
$lang['edit_category'] = 'Editar categoría';
$lang['add_product'] = 'Agregar producto';
$lang['edit_product'] = 'Editar producto';
$lang['add_command'] = 'Agregar comando';
$lang['edit_command'] = 'Editar comando';

/**
 * Form validation
*/
$lang['form_validation_valid_product_name'] = "El campo {field} sólo puede contener caracteres alfanuméricos, espacios y los caracteres ' - _ . : [ ]";
$lang['form_validation_valid_custom_command'] = 'El campo {field} sólo puede contener caracteres alfanuméricos, espacios y los caracteres . : { }';
$lang['form_validation_valid_mail_body'] = 'El campo {field} no puede contener los caracteres " $ { }';

/**
 * Alerts
*/
$lang['alert_character_not_exist'] = 'El personaje seleccionado no existe.';
$lang['alert_character_not_related'] = 'El personaje no está relacionado con tu cuenta.';
$lang['alert_user_not_dp'] = 'Tú no tienes los puntos de donación requeridos para completar la compra.';
$lang['alert_user_not_vp'] = 'Tú no tienes los puntos de votos requeridos para completar la compra.';
$lang['alert_cart_empty'] = 'Tu carrito esta vacío.';
$lang['alert_cart_product_added'] = 'El producto ha sido añadido a su carrito.';
$lang['alert_cart_product_deleted'] = 'El producto ha sido eliminado de su carrito.';
$lang['alert_cart_product_failed'] = 'La solicitud de eliminación del producto no se pudo procesar.';
$lang['alert_product_quantity_updated'] = 'La cantidad de productos en el carrito ha sido actualizado.';
$lang['alert_product_quantity_invalid'] = 'La cantidad no es válida.';
$lang['alert_checkout_success'] = '¡La compra se ha realizado! por favor revisa tu correo en el juego. Si aún no recibe su compra, comuníquese con nuestro equipo de soporte.';

$lang['alert_category_added'] = 'La nueva categoría ha sido agregada.';
$lang['alert_category_updated'] = 'Los datos de la categoría se han actualizado.';
$lang['alert_category_deleted'] = 'La categoría ha sido eliminada.';
$lang['alert_category_moved'] = 'La categoría seleccionada ha sido movida.';
$lang['alert_category_not_dropdown'] = 'No se permite un elemento desplegable dentro de otro.';
$lang['alert_product_added'] = 'El nuevo producto ha sido agregado.';
$lang['alert_product_updated'] = 'Los datos del producto se han actualizado.';
$lang['alert_product_deleted'] = 'El producto ha sido eliminado.';
