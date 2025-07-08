{{-- resources/views/woocommerce/checkout/form-checkout.blade.php --}}
@extends('layouts.app')
@section('content')
<main class="max-w-6xl mx-auto py-10 px-4">
    @php if (!defined('ABSPATH')) exit; @endphp

    @php 
        if (function_exists('WC') && WC()->checkout()) {
            do_action('woocommerce_before_checkout_form', WC()->checkout());
        }
    @endphp

    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="{{ esc_url(wc_get_checkout_url()) }}" enctype="multipart/form-data">
        <div class="container mx-auto py-12 px-4">
            <h1 class="text-3xl font-bold text-center mb-10 text-gray-800">Finalizar compra</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                
                {{-- Columna izquierda --}}
                <div class="space-y-10">
                    {{-- Facturación --}}
                    <div class="bg-white rounded-2xl shadow p-6">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700">Datos de facturación</h2>
                        <div class="space-y-4 [&_input]:form-input [&_select]:form-select [&_textarea]:form-textarea">
                            @php do_action('woocommerce_checkout_billing'); @endphp
                        </div>
                    </div>

                    {{-- Envío --}}
                    <div class="bg-white rounded-2xl shadow p-6">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700">Datos de envío</h2>
                        <div class="space-y-4">
                            @php do_action('woocommerce_checkout_shipping'); @endphp
                        </div>
                    </div>

                    {{-- Información adicional --}}
                    <div class="bg-white rounded-2xl shadow p-6">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700">Información adicional</h2>
                        <div class="space-y-4">
                            @php 
                                do_action('woocommerce_before_order_notes', WC()->checkout());
                                do_action('woocommerce_after_order_notes', WC()->checkout());
                            @endphp
                        </div>
                    </div>
                </div>

                {{-- Columna derecha: Resumen del pedido y pago --}}
                <div x-data="{ loading: false }" class="bg-white rounded-2xl shadow p-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">Resumen del pedido</h2>
                    <div class="space-y-6">
                        
                        {{-- Antes del resumen --}}
                        @php do_action('woocommerce_checkout_before_order_review'); @endphp
                        
                        {{-- Resumen y Totales + botón --}}
                        <div id="order_review" class="...">
                            @php do_action('woocommerce_checkout_order_review'); @endphp

                            {{-- Botón realizar pedido --}}
                            <div class="pt-4">
                                <button
                                    type="submit"
                                    id="place_order"
                                    @click="loading = true"
                                    :disabled="loading"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl text-sm transition-all duration-200 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <template x-if="loading">
                                        <svg class="w-5 h-5 animate-spin mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                        </svg>
                                    </template>
                                    <span x-text="loading ? 'Procesando...' : 'Realizar el pedido'"></span>
                                </button>
                            </div>
                        </div>


                        {{-- Después del resumen --}}
                        @php do_action('woocommerce_checkout_after_order_review'); @endphp
                    </div>
                </div>
            </div>
        </div>
    </form>

    @php do_action('woocommerce_after_checkout_form', WC()->checkout()); @endphp
</main>
@endsection
