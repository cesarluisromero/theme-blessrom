<div class="bg-gray-50 p-6 rounded-xl shadow space-y-4">
  <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Resumen del pedido</h2>

  {{-- Cabecera --}}
  <div class="flex justify-between text-sm font-semibold text-gray-600">
    <span>Producto</span>
    <span>Subtotal</span>
  </div>

  {{-- Productos --}}
  @foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item)
    @php
      $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
      $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
    @endphp

    @if ($_product && $_product->exists() && $cart_item['quantity'] > 0)
      <div class="flex justify-between text-sm text-gray-800 py-1 border-b">
        <span>
          {{ $_product->get_name() }}
          @if ($_product->get_attribute_summary())
            <span class="block text-xs text-gray-500">{{ $_product->get_attribute_summary() }}</span>
          @endif
          <span class="block text-xs text-gray-500">× {{ $cart_item['quantity'] }}</span>
        </span>
        <span>{{ wc_price($_product->get_price() * $cart_item['quantity']) }}</span>
      </div>
    @endif
  @endforeach

  {{-- Subtotal --}}
  <div class="flex justify-between text-sm text-gray-700 pt-2">
    <span>Subtotal</span>
    <span>{{ WC()->cart->get_cart_subtotal() }}</span>
  </div>

  {{-- Envío (si aplica) --}}
  @if (WC()->cart->needs_shipping())
    @foreach (WC()->shipping->get_packages() as $i => $package)
      @foreach ($package['rates'] as $method)
        <div class="flex justify-between text-sm text-gray-700">
          <span>Envío</span>
          <span>{{ wc_price($method->cost) }}</span>
        </div>
        @break
      @endforeach
    @endforeach
  @endif

  {{-- Total --}}
  <div class="flex justify-between text-base font-bold text-gray-900 border-t pt-3">
    <span>Total</span>
    <span>{{ WC()->cart->get_total() }}</span>
  </div>
</div>
