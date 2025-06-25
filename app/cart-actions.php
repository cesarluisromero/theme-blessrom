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

// AJAX para agregar producto variable al carrito
add_action('wp_ajax_add_to_cart_custom', 'blessrom_add_to_cart_custom');
add_action('wp_ajax_nopriv_add_to_cart_custom', 'blessrom_add_to_cart_custom');

function blessrom_add_to_cart_custom() {
    if (!isset($_POST['product_id'], $_POST['variation_id'], $_POST['quantity'])) {
        wp_send_json_error(['message' => 'Datos incompletos.']);
    }

    if (!wp_verify_nonce($_POST['_wpnonce'], 'woocommerce-add-to-cart')) {
        wp_send_json_error(['message' => 'Nonce inválido']);
    }

    $product_id   = absint($_POST['product_id']);
    $variation_id = absint($_POST['variation_id']);
    $quantity     = absint($_POST['quantity']);

    if (!$variation_id || !$product_id || !$quantity) {
        wp_send_json_error(['message' => 'Datos inválidos.']);
    }

    // Sanitizar atributos de variación
    $variation = [];
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'attribute_') === 0) {
            $variation[$key] = sanitize_text_field($value);
        }
    }

    // ✅ Revisión: ¿ya está este producto en el carrito?
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        if (
            $cart_item['product_id'] === $product_id &&
            $cart_item['variation_id'] === $variation_id &&
            $cart_item['variation'] === $variation
        ) {
            WC()->cart->set_quantity($cart_item_key, $cart_item['quantity'] + $quantity);
            wp_send_json_success(['message' => 'Cantidad actualizada en el carrito.']);
            return;
        }
    }

    // ✅ Intentar agregar
    $added = WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation);

    if ($added) {
        wp_send_json_success(['message' => 'Producto agregado correctamente.']);
    } else {
        wp_send_json_error(['message' => 'No se pudo agregar el producto al carrito.']);
    }
}
