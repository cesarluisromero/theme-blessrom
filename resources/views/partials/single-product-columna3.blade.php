{{-- Columna 3: Acciones y Descripción --}}
<div class="space-y-4">
    <p class="text-sm text-gray-700 leading-relaxed">
        {!! wpautop($product->get_short_description()) !!}
    </p>

    <form method="post" enctype="multipart/form-data">
        @php
        do_action('woocommerce_before_add_to_cart_button');
        do_action('woocommerce_before_add_to_cart_quantity');
        @endphp

       

        @php do_action('woocommerce_after_add_to_cart_button'); @endphp
    </form>

    <button class="w-full bg-yellow-500 text-white py-2 rounded hover:bg-yellow-600 transition font-semibold">
        Comprar ahora
    </button>
</div>