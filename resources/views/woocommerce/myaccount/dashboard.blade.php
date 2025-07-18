{{-- resources/views/woocommerce/myaccount/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
  @php
  $current_user = wp_get_current_user();
@endphp

<div class="bg-white shadow-md rounded-xl p-8 border border-gray-200 max-w-3xl mx-auto mt-10">

  <h2 class="text-2xl font-bold text-gray-800 mb-4">
    {{ __('Welcome back,', 'woocommerce') }} <span class="text-primary">{{ $current_user->display_name }}</span> 👋
  </h2>

  <p class="text-gray-600 mb-6 text-sm">
    {!! sprintf(
      wp_kses(
        __('Not %1$s? <a class="text-primary underline" href="%2$s">Log out</a>', 'woocommerce'),
        ['a' => ['href' => []]]
      ),
      '<strong>' . esc_html($current_user->display_name) . '</strong>',
      esc_url(wc_logout_url())
    ) !!}
  </p>

  <div class="space-y-4 text-gray-700 text-base leading-relaxed">
    {!! sprintf(
      wp_kses(
        wc_shipping_enabled()
          ? __('From your account dashboard you can view your <a class="text-primary underline" href="%1$s">recent orders</a>, manage your <a class="text-primary underline" href="%2$s">shipping and billing addresses</a>, and <a class="text-primary underline" href="%3$s">edit your password and account details</a>.', 'woocommerce')
          : __('From your account dashboard you can view your <a class="text-primary underline" href="%1$s">recent orders</a>, manage your <a class="text-primary underline" href="%2$s">billing address</a>, and <a class="text-primary underline" href="%3$s">edit your password and account details</a>.', 'woocommerce'),
        ['a' => ['href' => [], 'class' => []]]
      ),
      esc_url(wc_get_endpoint_url('orders')),
      esc_url(wc_get_endpoint_url('edit-address')),
      esc_url(wc_get_endpoint_url('edit-account'))
    ) !!}
  </div>

</div>

@php
  do_action('woocommerce_account_dashboard');
  do_action('woocommerce_before_my_account'); // deprecated
  do_action('woocommerce_after_my_account');  // deprecated
@endphp

@endsection
