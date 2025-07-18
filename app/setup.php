<?php

/**
 * Theme setup.
 */

namespace App;

use Illuminate\Support\Facades\Vite;

require_once get_theme_file_path('app/cart-actions.php');

/**
 * Editor styles
 * @return array
 */
add_filter('block_editor_settings_all', function ($settings) {
    $style = Vite::asset('resources/styles/editor.css');

    $settings['styles'][] = [
        'css' => "@import url('{$style}')",
    ];

    return $settings;
});

/**
 * Editor scripts
 *
 * @return void
 */
add_filter('admin_head', function () {
    if (! get_current_screen()?->is_block_editor()) {
        return;
    }

    $dependencies = json_decode(Vite::content('editor.deps.json'));

    foreach ($dependencies as $dependency) {
        if (! wp_script_is($dependency)) {
            wp_enqueue_script($dependency);
        }
    }

    echo Vite::withEntryPoints([
        'resources/scripts/editor.js',
    ])->toHtml();
});

/**
 * Use the generated theme.json file.
 *
 * @return string
 */
add_filter('theme_file_path', function ($path, $file) {
    return $file === 'theme.json'
        ? public_path('build/assets/theme.json')
        : $path;
}, 10, 2);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    
    remove_theme_support('block-templates');
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
    ]);
    remove_theme_support('core-block-patterns');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');  
    add_theme_support('responsive-embeds');
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('woocommerce');   

}, 20);


// WooCommerce login redirect

add_filter('woocommerce_locate_template', function ($template, $template_name, $template_path) {
    $render = function ($view, $data = []) {
        echo \Roots\view($view, $data)->render();
        exit;
    };

    switch ($template_name) {
        // Mi cuenta: Login
        case 'myaccount/form-login.php':
            $render('woocommerce.myaccount.form-login');
            break;

        // Olvidaste tu contraseña
        case 'myaccount/form-lost-password.php':
            $render('woocommerce.myaccount.form-lost-password');
            break;

        // Restablecer contraseña (desde enlace con key/login)
        case 'myaccount/form-reset-password.php':
            $render('woocommerce.myaccount.form-reset-password', [
                'reset_key' => $_GET['key'] ?? '',
                'reset_login' => $_GET['login'] ?? '',
            ]);
            break;

        // Panel de cuenta (dashboard)
        case 'myaccount/dashboard.php':
            $render('woocommerce.myaccount.dashboard');
            break;

        // Editar cuenta
        case 'myaccount/form-edit-account.php':
            $render('woocommerce.myaccount.form-edit-account', [
                'user' => wp_get_current_user(),
                'nonce_value' => wp_create_nonce('save_account_details'),
            ]);
            break;

        // Editar dirección
        case 'myaccount/form-edit-address.php':
            $render('woocommerce.myaccount.form-edit-address', [
                'load_address' => $_GET['address'] ?? 'billing',
                'address' => WC()->countries->get_address_fields(WC()->customer->get_billing_country(), 'billing'),
            ]);
            break;

        // Listado de pedidos
        case 'myaccount/orders.php':
            $current_page = max(1, get_query_var('paged'));
            $orders = wc_get_orders([
                'customer_id' => get_current_user_id(),
                'paginate' => true,
                'paged' => $current_page,
                'limit' => 10,
            ]);
            $render('woocommerce.myaccount.orders', [
                'orders' => $orders,
                'current_page' => $current_page,
            ]);
            break;

        // Detalle de pedido
        case 'myaccount/view-order.php':
            global $wp;
            $order_id = absint($wp->query_vars['view-order']);
            $order = wc_get_order($order_id);
            if ($order) {
                $render('woocommerce.myaccount.view-order', ['order' => $order]);
            }
            break;

        // Página del producto individual
        case 'single-product.php':
            $render('woocommerce.single-product');
            break;

        // Página de checkout
        case 'checkout/form-checkout.php':
            $render('woocommerce.checkout.form-checkout');
            break;

        // Página de agradecimiento (pedido recibido)
        case 'checkout/thankyou.php':
            $order_id = absint(get_query_var('order-received'));
            $order = wc_get_order($order_id);
            if ($order) {
                $render('woocommerce.thankyou', ['order' => $order]);
            }
            break;

        // Página del carrito
        case 'cart/cart.php':
            $render('woocommerce.cart.cart');
            break;
    }

    return $template;
}, 100, 3);



/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary',
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer',
    ] + $config);
});


require_once get_theme_file_path('app/ajax.php');

add_filter('template_include', function ($template) {
    if (is_woocommerce()) {
        $theme_template = locate_template('woocommerce.blade.php');
        if ($theme_template) {
            return $theme_template;
        }
    }

    return $template;
}, 99);








