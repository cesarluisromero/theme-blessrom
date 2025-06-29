@extends('layouts.app')

@section('content')
  @if (function_exists('do_action') && isset($checkout))
  {!! do_action('woocommerce_before_checkout_form', $checkout) !!}
@endif

  <div class="container mx-auto px-4 py-6">
  <h1 class="text-2xl font-bold mb-6">Finalizar compra</h1>

  <form name="checkout" method="post" class="grid grid-cols-1 lg:grid-cols-[60%_40%] gap-8" action="{{ esc_url(wc_get_checkout_url()) }}" enctype="multipart/form-data">

    {{-- Column: Facturación y Envío --}}
    <div class="space-y-8">

      {{-- Detalles de facturación --}}
      <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-semibold mb-4">Detalles de facturación</h2>
        {!! woocommerce_checkout_billing() !!}
      </div>

      {{-- Detalles de envío --}}
      <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-semibold mb-4">Datos de envío</h2>
        {!! woocommerce_checkout_shipping() !!}
      </div>

      {{-- Notas del pedido --}}
      <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-semibold mb-4">Información adicional</h2>
        {!! woocommerce_checkout_order_review(['order_review' => false, 'checkout' => $checkout]) !!}
      </div>

    </div>

    {{-- Column: Resumen del pedido --}}
    <div class="bg-white p-6 rounded-xl shadow border border-gray-300">
      {!! do_action('woocommerce_checkout_order_review') !!}
    </div>

  </form>
</div>


  @if (function_exists('do_action') && isset($checkout))
  {!! do_action('woocommerce_after_checkout_form', $checkout) !!}
@endif
@endsection
