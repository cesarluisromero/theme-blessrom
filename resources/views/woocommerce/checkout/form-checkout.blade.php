{{-- resources/views/woocommerce/checkout/form-checkout.blade.php --}}
@php
  if (!defined('ABSPATH')) exit;
  do_action('woocommerce_before_checkout_form', $checkout);
@endphp

@if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in())
  <div class="woocommerce-info">Debes iniciar sesión para finalizar tu compra.</div>
  @php return; @endphp
@endif

<form name="checkout" method="post" class="checkout w-full max-w-5xl mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-[60%_40%] gap-8" action="{{ esc_url(wc_get_checkout_url()) }}" enctype="multipart/form-data">
  
  {{-- Datos del cliente --}}
  <div class="space-y-6">
    {{-- Facturación --}}
    <div class="bg-white p-6 rounded-lg shadow">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Detalles de facturación</h2>
      @php do_action('woocommerce_checkout_billing'); @endphp
    </div>

    {{-- Envío (si aplica) --}}
    @if (WC()->cart->needs_shipping())
      <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Dirección de envío</h2>
        @php do_action('woocommerce_checkout_shipping'); @endphp
      </div>
    @endif

    {{-- Información adicional --}}
    <div class="bg-white p-6 rounded-lg shadow">
      @php do_action('woocommerce_before_order_notes', $checkout); @endphp
      @if (wc_shipping_enabled())
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Notas del pedido</h2>
      @endif
      @php do_action('woocommerce_after_order_notes', $checkout); @endphp
    </div>
  </div>

  {{-- Resumen del pedido --}}
  <div class="bg-white p-6 rounded-lg shadow space-y-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Tu pedido</h2>

    <div class="border border-gray-200 rounded">
      <table class="w-full text-sm text-gray-700">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-3 text-left">Producto</th>
            <th class="p-3 text-right">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach (WC()->cart->get_cart() as $cart_item)
            @php $product = $cart_item['data']; @endphp
            <tr class="border-t">
              <td class="p-3">
                {{ $product->get_name() }} × {{ $cart_item['quantity'] }}
              </td>
              <td class="p-3 text-right">
                {!! wc_price($product->get_price() * $cart_item['quantity']) !!}
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot class="bg-gray-50 border-t">
          <tr>
            <td class="p-3 font-semibold">Subtotal</td>
            <td class="p-3 text-right">{!! WC()->cart->get_cart_subtotal() !!}</td>
          </tr>
          @foreach (WC()->cart->get_coupons() as $code => $coupon)
            <tr>
              <td class="p-3 font-semibold">Cupón: {{ esc_html($code) }}</td>
              <td class="p-3 text-right">-{!! wc_price($coupon->get_amount()) !!}</td>
            </tr>
          @endforeach
          <tr>
            <td class="p-3 font-semibold">Envío</td>
            <td class="p-3 text-right">
              @php do_action('woocommerce_review_order_shipping'); @endphp
            </td>
          </tr>
          <tr class="text-lg font-bold">
            <td class="p-3">Total</td>
            <td class="p-3 text-right">{!! WC()->cart->get_total() !!}</td>
          </tr>
        </tfoot>
      </table>
    </div>

    {{-- Métodos de pago --}}
    <div class="space-y-4">
      @php do_action('woocommerce_checkout_before_order_review_heading'); @endphp

      <h3 class="text-lg font-semibold text-gray-700">Método de pago</h3>

      <div class="space-y-2">
        @php do_action('woocommerce_checkout_order_review'); @endphp
      </div>
    </div>

    {{-- Botón de finalizar compra --}}
    <div>
      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg text-lg font-semibold transition">
        Finalizar compra
      </button>
    </div>

  </div>
</form>

@php do_action('woocommerce_after_checkout_form', $checkout); @endphp
