{{-- resources/views/woocommerce/checkout/form-checkout.blade.php --}}
@php
    defined('ABSPATH') || exit;
    $checkout = WC()->checkout();
@endphp

<section class="container mx-auto max-w-4xl px-4 py-8">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-8">Finalizar compra</h1>

    <form name="checkout" method="post" class="grid lg:grid-cols-2 gap-8" action="{{ esc_url(wc_get_checkout_url()) }}" enctype="multipart/form-data">
        @csrf

        {{-- CAMPOS DE FACTURACIÓN --}}
        <div class="space-y-6">
            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Datos de facturación</h2>

            @php do_action('woocommerce_before_checkout_billing_form', $checkout); @endphp

            <div class="space-y-4">
                @foreach ($checkout->get_checkout_fields('billing') as $key => $field)
                    <div class="w-full">
                        {!! woocommerce_form_field($key, $field, $checkout->get_value($key)) !!}
                    </div>
                @endforeach
            </div>

            @php do_action('woocommerce_after_checkout_billing_form', $checkout); @endphp
        </div>

        {{-- RESUMEN DEL PEDIDO --}}
        <div class="bg-white shadow rounded-lg p-6 space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Resumen del pedido</h2>

            <div class="space-y-4">
                @foreach (WC()->cart->get_cart() as $cart_item)
                    @php
                        $product = $cart_item['data'];
                        $product_permalink = $product->is_visible() ? $product->get_permalink($cart_item) : '';
                    @endphp
                    <div class="flex items-center gap-4 border-b pb-4">
                        <img src="{{ wp_get_attachment_image_url($product->get_image_id(), 'thumbnail') }}" class="w-16 h-16 object-cover rounded">
                        <div class="flex-1">
                            <a href="{{ $product_permalink }}" class="font-medium text-gray-900">{{ $product->get_name() }}</a>
                            <div class="text-sm text-gray-600">Cantidad: {{ $cart_item['quantity'] }}</div>
                        </div>
                        <div class="text-right font-semibold text-gray-800">
                            {{ wc_price($product->get_price() * $cart_item['quantity']) }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="border-t pt-4 mt-4 text-sm text-gray-700 space-y-2">
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span>{{ WC()->cart->get_cart_subtotal() }}</span>
                </div>
                @if (WC()->cart->get_discount_total() > 0)
                    <div class="flex justify-between text-green-600 font-medium">
                        <span>Descuento:</span>
                        <span>-{{ wc_price(WC()->cart->get_discount_total()) }}</span>
                    </div>
                @endif
                <div class="flex justify-between font-semibold text-base text-gray-900">
                    <span>Total:</span>
                    <span>{{ WC()->cart->get_total() }}</span>
                </div>
            </div>

            {{-- MÉTODOS DE PAGO + ENVIAR --}}
            <div id="payment" class="woocommerce-checkout-payment mt-6">
                @php do_action('woocommerce_checkout_order_review'); @endphp
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                Realizar pedido
            </button>
        </div>
    </form>
</section>
