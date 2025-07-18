<?php
echo \Roots\view('woocommerce.myaccount.my-orders', [
    'my_orders_columns' => apply_filters('woocommerce_my_account_my_orders_columns', [
        'order-number'  => esc_html__('Order', 'woocommerce'),
        'order-date'    => esc_html__('Date', 'woocommerce'),
        'order-status'  => esc_html__('Status', 'woocommerce'),
        'order-total'   => esc_html__('Total', 'woocommerce'),
        'order-actions' => '&nbsp;',
    ]),
    'customer_orders' => get_posts(apply_filters('woocommerce_my_account_my_orders_query', [
        'numberposts' => $order_count ?? 5,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => wc_get_order_types('view-orders'),
        'post_status' => array_keys(wc_get_order_statuses()),
    ])),
])->render();
