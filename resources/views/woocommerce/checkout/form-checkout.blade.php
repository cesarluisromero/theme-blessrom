@php
  if (!defined('ABSPATH')) exit;
  do_action('woocommerce_before_checkout_form', $checkout);
@endphp

<section class="max-w-6xl mx-auto py-10 px-4 lg:px-0 grid grid-cols-1 lg:grid-cols-2 gap-8">

  {{-- Columna izquierda: Datos de facturación y notas --}}
  <div class="space-y-6">

    {{-- Datos de facturación --}}
    <div class="bg-white p-6 rounded-2xl shadow">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Datos de facturación</h2>
      <div class="space-y-4">
        {!! woocommerce_checkout_billing() !!}
      </div>
    </div>

    {{-- Información adicional --}}
    <div class="bg-white p-6 rounded-2xl shadow">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Información adicional</h2>
      <div class="space-y-4">
        @php do_action('woocommerce_before_order_notes', $checkout); @endphp
        {!! woocommerce_order_notes() !!}
        @php do_action('woocommerce_after_order_notes', $checkout); @endphp
      </div>
    </div>
  </div>

  {{-- Columna derecha: Resumen del pedido y métodos de pago --}}
  <div class="bg-white p-6 rounded-2xl shadow">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Resumen del pedido</h2>

    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="{{ esc_url(wc_get_checkout_url()) }}" enctype="multipart/form-data">
      @csrf
      @php do_action('woocommerce_checkout_before_order_review_heading'); @endphp

      <div id="order_review" class="woocommerce-checkout-review-order">
        {!! woocommerce_checkout_payment() !!}
      </div>

      @php do_action('woocommerce_checkout_after_order_review'); @endphp
    </form>
  </div>
</section>

@php
  do_action('woocommerce_after_checkout_form', $checkout);
@endphp
