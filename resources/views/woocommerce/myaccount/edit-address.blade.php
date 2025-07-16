@extends('layouts.app')

@section('content')
<div class="bg-[#F0F0F0] py-10">
  <div class="max-w-5xl mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Direcciones guardadas</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      {{-- Dirección de facturación --}}
      <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Dirección de facturación</h2>
        @php
          do_action('woocommerce_before_edit_account_address_form');
          echo wp_kses_post(wc_get_account_address('billing'));
        @endphp
        <a href="{{ esc_url(wc_get_endpoint_url('edit-address', 'billing')) }}"
           class="mt-4 inline-block text-blue-600 hover:underline font-medium">
          ✏️ Editar Dirección de facturación
        </a>
      </div>

      {{-- Dirección de envío --}}
      <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Dirección de envío</h2>
        @php
          echo wp_kses_post(wc_get_account_address('shipping'));
        @endphp
        <a href="{{ esc_url(wc_get_endpoint_url('edit-address', 'shipping')) }}"
           class="mt-4 inline-block text-blue-600 hover:underline font-medium">
          ✏️ Editar Dirección de envío
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
