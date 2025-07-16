@extends('layouts.app')

@section('content')
<div class="bg-[#f0f0f0] py-10">
  <div class="max-w-4xl mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">📍 Mis direcciones</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      {{-- Dirección de facturación --}}
      <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Dirección de facturación</h2>
        @php do_action('woocommerce_before_edit_account_address_form') @endphp
        {!! wc_get_account_address( 'billing' ) !!}
        <a href="{{ esc_url( wc_get_endpoint_url( 'edit-address', 'billing' ) ) }}"
          class="mt-4 inline-block text-blue-600 hover:underline font-medium">
          ✏️ Editar Dirección de facturación
        </a>
      </div>

      {{-- Dirección de envío --}}
      <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Dirección de envío</h2>
        {!! wc_get_account_address( 'shipping' ) !!}
        <a href="{{ esc_url( wc_get_endpoint_url( 'edit-address', 'shipping' ) ) }}"
          class="mt-4 inline-block text-blue-600 hover:underline font-medium">
          ✏️ Editar Dirección de envío
        </a>
      </div>
    </div>

    @php do_action('woocommerce_after_edit_account_address_form') @endphp
  </div>
</div>
@endsection
