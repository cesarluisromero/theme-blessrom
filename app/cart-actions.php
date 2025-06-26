<?php
error_log('✅ cart-actions.php CARGADO');
// Eliminar un ítem del carrito
add_action('template_redirect', function () {
    if (!is_cart() || !isset($_POST['remove_item'], $_POST['cart_item_key'])) {
        return;
    }

    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);

    if (WC()->cart->remove_cart_item($cart_item_key)) {
        wc_add_notice('Producto eliminado del carrito.', 'success');
        wp_safe_redirect(wc_get_cart_url());
        exit;
    }
});

// Actualizar cantidades del carrito manualmente
add_action('template_redirect', function () {
    if (is_cart() && isset($_POST['update_cart'], $_POST['cart']) && is_array($_POST['cart'])) {
        foreach ($_POST['cart'] as $cart_item_key => $item_data) {
            if (isset($item_data['qty'])) {
                $quantity = intval($item_data['qty']);
                WC()->cart->set_quantity($cart_item_key, $quantity, true);
            }
        }
        wc_add_notice('Carrito actualizado correctamente.', 'success');
        wp_safe_redirect(wc_get_cart_url());
        exit;
    }
});

// AJAX para agregar producto variable al carro
add_action('init', function () {
    add_action('wp_ajax_add_to_cart_custom', 'blessrom_add_to_cart_custom');
    add_action('wp_ajax_nopriv_add_to_cart_custom', 'blessrom_add_to_cart_custom');
});

function blessrom_add_to_cart_custom() {
    error_log('✅ Entró a blessrom_add_to_cart_custom');
    die('✅ llamada directa AJAX');
}

