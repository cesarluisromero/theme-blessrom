@extends('layouts.app')

@section('content')
  @if (function_exists('do_action') && isset($checkout))
  {!! do_action('woocommerce_before_checkout_form', $checkout) !!}
@endif

  <div class="container mx-auto max-w-6xl px-4 py-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Finalizar compra</h1>

    <form name="checkout" method="post" class="grid grid-cols-1 lg:grid-cols-2 gap-10" action="{{ esc_url(wc_get_checkout_url()) }}" enctype="multipart/form-data">
      @csrf

      {{-- Columna izquierda: Detalles de facturación y envío --}}
      <div class="space-y-8">
        <div>
          <h2 class="text-xl font-semibold mb-4">Datos de facturación</h2>
          @php do_action('woocommerce_checkout_billing'); @endphp
        </div>

        <div>
          <h2 class="text-xl font-semibold mb-4">Datos de envío</h2>
          @php do_action('woocommerce_checkout_shipping'); @endphp
        </div>
      </div>

      {{-- Columna derecha: Resumen del pedido --}}
      <div class="bg-white border rounded-lg shadow p-6 space-y-6">
        <h2 class="text-xl font-semibold mb-4">Resumen del pedido</h2>
        @php do_action('woocommerce_checkout_before_order_review'); @endphp

        <div id="order_review">
          @php do_action('woocommerce_checkout_order_review'); @endphp
        </div>

        <div id="payment" class="woocommerce-checkout-payment">
          @php do_action('woocommerce_checkout_payment'); @endphp
        </div>
      </div>
    </form>
  </div>

  @php do_action('woocommerce_after_checkout_form', $checkout); @endphp
@endsection
