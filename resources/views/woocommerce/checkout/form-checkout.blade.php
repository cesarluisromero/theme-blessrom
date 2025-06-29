{{-- resources/views/woocommerce/checkout/form-checkout.blade.php --}}
@extends('layouts.app')

@section('content')
    @php if (!defined('ABSPATH')) exit; @endphp

    {!! do_action('woocommerce_before_checkout_form', WC()->checkout()) !!}

    <form name="checkout" method="post" class="checkout" action="{{ esc_url(wc_get_checkout_url()) }}" enctype="multipart/form-data">
        <div class="container mx-auto py-12 px-4">
            <h1 class="text-2xl font-bold text-center mb-8 text-gray-800">Finalizar compra</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Columna izquierda --}}
                <div class="space-y-8">
                    {{-- Datos de facturación --}}
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-lg font-semibold mb-4 text-gray-800">Datos de facturación</h2>
                        <div class="woocommerce-billing-fields">
                            {!! do_action('woocommerce_checkout_billing') !!}
                        </div>
                    </div>

                    {{-- Datos de envío --}}
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-lg font-semibold mb-4 text-gray-800">Datos de envío</h2>
                        <div class="woocommerce-shipping-fields">
                            {!! do_action('woocommerce_checkout_shipping') !!}
                        </div>
                    </div>

                    {{-- Información adicional --}}
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-lg font-semibold mb-4 text-gray-800">Información adicional</h2>
                        <div class="woocommerce-additional-fields">
                            {!! do_action('woocommerce_before_order_notes', WC()->checkout()) !!}
                            {!! do_action('woocommerce_after_order_notes', WC()->checkout()) !!}
                        </div>
                    </div>
                </div>

                {{-- Columna derecha: resumen del pedido --}}
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Resumen del pedido</h2>

                    {!! do_action('woocommerce_checkout_before_order_review') !!}

                    <div id="order_review" class="woocommerce-checkout-review-order">
                        {!! do_action('woocommerce_checkout_order_review') !!}
                    </div>

                    {!! do_action('woocommerce_checkout_after_order_review') !!}
                </div>
            </div>
        </div>
    </form>

    {!! do_action('woocommerce_after_checkout_form', WC()->checkout()) !!}
@endsection
