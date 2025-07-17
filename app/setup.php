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

// Redirige si recibe ?key=...&login=...
add_action('template_redirect', function () {
    global $wp;
    if (
        isset($wp->query_vars['lost-password']) &&
        isset($_GET['key']) &&
        isset($_GET['login'])
    ) {
        $key = sanitize_text_field($_GET['key']);
        $login = sanitize_text_field($_GET['login']);
        $id = isset($_GET['id']) ? intval($_GET['id']) : null; // opcional, si lo usas
        $url = wc_get_account_endpoint_url('reset-password') . "?key={$key}&login={$login}";
        if ($id) {
            $url .= "&id={$id}";
        }
        wp_redirect($url);
        exit;
    }
});

// Registro de endpoint reset-password
add_action('init', function () {
    add_rewrite_endpoint('reset-password', EP_ROOT | EP_PAGES);
});

// WooCommerce login redirect
add_filter('woocommerce_login_redirect', function($redirect, $user) {
    // Si hay una redirección almacenada en la URL (por ejemplo, checkout), redirige allí
    if (isset($_GET['redirect_to']) && !empty($_GET['redirect_to'])) {
        return esc_url($_GET['redirect_to']);
    }
    // Por defecto, redirige al checkout si el carrito no está vacío
    if (WC()->cart && !WC()->cart->is_empty()) {
        return wc_get_checkout_url();
    }
    // Si no hay nada en el carrito, redirige a la cuenta
    return wc_get_page_permalink('myaccount');
}, 10, 2);

//carga la página del producto
add_filter('template_include', function ($template) {
        if (is_singular('product')) {
            $blade_template = locate_template('resources/views/woocommerce/single-product.blade.php');
            if ($blade_template) {
                echo \Roots\view('woocommerce.single-product')->render();
                exit; // Evita que cargue otras plantillas
            }
        }
        return $template;
}, 99);

//redirige al checkout
add_filter('template_include', function ($template) {
    if (is_checkout() && !is_order_received_page()) {
        $blade_template = locate_template('resources/views/woocommerce/checkout/form-checkout.blade.php');
        if ($blade_template) {
            echo \Roots\view('woocommerce.checkout.form-checkout')->render();
            exit; // Detiene el flujo de carga de otras plantillas
        }
    }
    return $template;
}, 99);


//redirige a la página de ordenes
add_filter('template_include', function ($template) {
    if (is_order_received_page()) {
        $order_id = absint(get_query_var('order-received'));
        $order = wc_get_order($order_id);

        if ($order) {
            echo \Roots\view('woocommerce.thankyou', [
                'order' => $order,
            ])->render();
            exit;
        }
    }

    return $template;
}, 99);



//página para editar direccion
add_filter('template_include', function ($template) {
    if (is_account_page() && is_wc_endpoint_url('edit-address')) {
        echo \Roots\view('woocommerce.myaccount.edit-address')->render();
        exit;
    }
    return $template;
}, 100);

//página para editar direccion
add_filter('template_include', function ($template) {
    if (is_wc_endpoint_url('edit-address')) {
        $blade_template = locate_template('resources/views/woocommerce/myaccount/form-edit-address.blade.php');
        if ($blade_template) {
            echo \Roots\view('woocommerce.myaccount.form-edit-address', [
                'load_address' => isset($_GET['address']) ? sanitize_text_field($_GET['address']) : 'billing',
                'address' => WC()->countries->get_address_fields(WC()->customer->get_billing_country(), 'billing')
            ])->render();
            exit;
        }
    }
    return $template;
}, 99);

//pagina para editar cuenta
add_filter('template_include', function ($template) {
    if (is_wc_endpoint_url('edit-account')) {
        $blade_template = locate_template('resources/views/woocommerce/myaccount/form-edit-account.blade.php');

        if ($blade_template) {
            echo \Roots\view('woocommerce.myaccount.form-edit-account', [
                'user' => wp_get_current_user(),
                'nonce_value' => wp_create_nonce('save_account_details'),
            ])->render();
            exit;
        }
    }

    return $template;
}, 99);

//página de ordenes
add_filter('template_include', function ($template) {
    if (is_wc_endpoint_url('orders')) {
        $blade_template = locate_template('resources/views/woocommerce/myaccount/orders.blade.php');

        if ($blade_template) {
            $current_page = max(1, get_query_var('paged'));
            $customer_orders = wc_get_orders([
                'customer_id' => get_current_user_id(),
                'paginate' => true,
                'paged' => $current_page,
                'limit' => 10,
            ]);

            echo \Roots\view('woocommerce.myaccount.orders', [
                'orders' => $customer_orders,
                'current_page' => $current_page,
            ])->render();
            exit;
        }
    }

    return $template;
}, 99);

//página para ver toddas las ordenes
add_filter('template_include', function ($template) {
    if (is_wc_endpoint_url('view-order')) {
        $blade_template = locate_template('resources/views/woocommerce/myaccount/view-order.blade.php');
        if ($blade_template) {
            global $wp;
            $order_id = absint($wp->query_vars['view-order']);
            $order = wc_get_order($order_id);

            if ($order) {
                echo \Roots\view('woocommerce.myaccount.view-order', [
                    'order' => $order,
                ])->render();
                exit;
            }
        }
    }
    return $template;
}, 99);


//página para loguearse
add_filter('template_include', function ($template) {
    // Mostrar solo en la página "Mi cuenta" (login/register)
    if (is_account_page() && !is_user_logged_in()) {
        echo \Roots\view('woocommerce.myaccount.form-login')->render();
        exit;
    }

    return $template;
}, 99);

//pagina logueada
add_filter('template_include', function ($template) {
    if (is_account_page() && !is_wc_endpoint_url()) {
        $blade_template = locate_template('resources/views/woocommerce/myaccount/dashboard.blade.php');
        if ($blade_template) {
            echo \Roots\view('woocommerce.myaccount.dashboard')->render();
            exit;
        }
    }
    return $template;
}, 99);

//página cuando se olvida contraseña
add_action('template_redirect', function () {
    global $wp;

    if (is_account_page() && isset($wp->query_vars['lost-password'])) {

        // Si el link es para confirmar que se envió el correo
        if (isset($_GET['reset-link-sent'])) {
            echo \Roots\view('woocommerce.myaccount.form-lost-password')->render();
            exit;
        }

        // Si el link es para mostrar el formulario de restablecimiento de contraseña
        if (isset($_GET['show-reset-form'])) {
            echo \Roots\view('woocommerce.myaccount.form-reset-password')->render();
            exit;
        }

        // Por defecto, mostrar formulario para ingresar el correo
        echo \Roots\view('woocommerce.myaccount.form-lost-password')->render();
        exit;
    }
});




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








