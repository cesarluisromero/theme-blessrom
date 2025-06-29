@php
  if (!defined('ABSPATH')) exit;
  $checkout = WC()->checkout();
  do_action('woocommerce_before_checkout_form', $checkout);
@endphp

<section class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
  <h1 class="text-2xl font-bold mb-8 text-center">Finalizar compra</h1>

  <form name="checkout" method="post" class="grid grid-cols-1 lg:grid-cols-2 gap-8"
        action="{{ esc_url(wc_get_checkout_url()) }}" enctype="multipart/form-data">

    {{-- Columna izquierda: Datos del cliente --}}
    <div class="space-y-6">
      {{-- Facturación --}}
      <div>
        <h2 class="text-xl font-semibold mb-4">Datos de facturación</h2>
        @php do_action('woocommerce_checkout_billing'); @endphp
      </div>

      {{-- Envío --}}
      <div>
        <h2 class="text-xl font-semibold mb-4">Datos de envío</h2>
        @php do_action('woocommerce_checkout_shipping'); @endphp
      </div>
    </div>

    {{-- Columna derecha: Resumen del pedido --}}
    <div class="bg-gray-50 p-6 rounded-lg shadow-md">
      <h2 class="text-xl font-semibold mb-4">Resumen del pedido</h2>

      <div class="text-sm border-t border-b divide-y divide-gray-200 mb-6">
        @foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item)
          @php $product = $cart_item['data']; @endphp
          <div class="py-4 flex justify-between items-start">
            <div>
              <div class="font-medium text-gray-800">{{ $product->get_name() }}</div>
              <div class="text-gray-500 text-xs">x{{ $cart_item['quantity'] }}</div>
            </div>
            <div class="font-semibold text-gray-700">
              {{ wc_price($product->get_price() * $cart_item['quantity']) }}
            </div>
          </div>
        @endforeach
      </div>

      <div class="text-sm space-y-2 mb-6">
        <div class="flex justify-between">
          <span>Subtotal</span>
          <span>{{ wc_price(WC()->cart->get_subtotal()) }}</span>
        </div>
        <div class="flex justify-between">
          <span>Envío</span>
          <span>{{ WC()->cart->get_cart_shipping_total() }}</span>
        </div>
        <div class="flex justify-between font-semibold text-lg">
          <span>Total</span>
          <span>{{ WC()->cart->get_total() }}</span>
        </div>
      </div>

      {{-- Campos adicionales y métodos de pago --}}
      <div class="space-y-4">
        @php do_action('woocommerce_checkout_after_order_review'); @endphp

        {{-- Métodos de pago --}}
        <div id="payment" class="woocommerce-checkout-payment">
          @php do_action('woocommerce_checkout_payment'); @endphp
        </div>

        {{-- Botón de pagar --}}
        <div class="mt-4">
          @php do_action('woocommerce_checkout_before_submit'); @endphp
          <button type="submit"
                  class="w-full py-3 px-6 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition"
                  name="woocommerce_checkout_place_order" id="place_order"
                  value="{{ esc_attr($checkout->get_value('terms')) }}"
                  data-value="{{ esc_attr($checkout->get_value('terms')) }}">
            Realizar pedido
          </button>
          @php do_action('woocommerce_checkout_after_submit'); @endphp
        </div>
      </div>
    </div>
  </form>
</section>

@php do_action('woocommerce_after_checkout_form', $checkout); @endphp
