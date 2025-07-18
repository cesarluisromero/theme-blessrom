<?php
echo \Roots\view('woocommerce.myaccount.orders', [
    'order_count' => $order_count ?? 10,
])->render();
