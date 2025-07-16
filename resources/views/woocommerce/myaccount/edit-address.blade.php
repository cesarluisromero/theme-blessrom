@extends('layouts.app')

@section('content')
<div class="bg-[#F0F0F0] py-10 min-h-screen">
  <div class="max-w-5xl mx-auto px-4">
    <h1 class="text-2xl font-bold mb-8 text-gray-800">Mis direcciones</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      {{-- Dirección de facturación --}}
      <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Dirección de facturación</h2>

        @php do_action('woocommerce_before_edit_account_address_form') @endphp

        @php
          $billing_address = wc_get_account_address('billing');
          echo wp_kses_post($billing_address);
        @endphp

        <a 
          href="{{ esc_url(wc_get_endpoint_url('edit-address', 'billing')) }}"
          class="inline-block mt-4 text-sm text-blue-600 hover:underline font-medium"
        >
          ✏️ Editar dirección de facturación
        </a>
      </div>

      {{-- Dirección de envío --}}
      <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Dirección de envío</h2>

        @php
          $shipping_address = wc_get_account_address('shipping');
          echo wp_kses_post($shipping_address);
        @endphp

        <a 
          href="{{ esc_url(wc_get_endpoint_url('edit-address', 'shipping')) }}"
          class="inline-block mt-4 text-sm text-blue-600 hover:underline font-medium"
        >
          ✏️ Editar dirección de envío
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
