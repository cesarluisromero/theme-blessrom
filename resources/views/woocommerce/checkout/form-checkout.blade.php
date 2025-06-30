{{-- resources/views/woocommerce/checkout/form-checkout.blade.php --}}
@extends('layouts.app')
@section('content')
    @php
        if (!defined('ABSPATH')) exit;
    @endphp
    @php 
        if (function_exists('WC') && WC()->checkout()) {
            do_action('woocommerce_before_checkout_form', WC()->checkout());
        }
    @endphp
    <form name="checkout" method="post" class="checkout" action="{{ esc_url(wc_get_checkout_url()) }}" enctype="multipart/form-data">
        <div class="container mx-auto py-12 px-4">
            <h1 class="text-3xl font-bold text-center mb-10 text-gray-800">Finalizar compra</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                {{-- Columna izquierda --}}
                <div class="space-y-10">
                    {{-- Datos de facturación --}}
                    <div class="bg-white rounded-2xl shadow p-6">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700">Datos de facturación</h2>
                        <div class="space-y-4 [&_input]:border [&_input]:rounded-md [&_input]:w-full [&_input]:px-4 [&_input]:py-2 [&_input]:text-sm [&_input]:border-gray-300 [&_input:focus]:outline-none [&_input:focus]:ring-2 [&_input:focus]:ring-blue-500 [&_select]:border [&_select]:rounded-md [&_select]:w-full [&_select]:px-4 [&_select]:py-2 [&_select]:text-sm [&_select]:border-gray-300 [&_select:focus]:outline-none [&_select:focus]:ring-2 [&_select:focus]:ring-blue-500 [&_textarea]:border [&_textarea]:rounded-md [&_textarea]:w-full [&_textarea]:px-4 [&_textarea]:py-2 [&_textarea]:text-sm [&_textarea]:border-gray-300 [&_textarea:focus]:outline-none [&_textarea:focus]:ring-2 [&_textarea:focus]:ring-blue-500">
                            @php
                                if (function_exists('WC') && WC()->checkout()) {
                                    do_action('woocommerce_checkout_billing');
                                }
                            @endphp
                        </div>
                    </div>
                    {{-- Datos de envío --}}
                    <div class="bg-white rounded-2xl shadow p-6">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700">Datos de envío</h2>
                        <div class="space-y-4">
                            @php
                                if (function_exists('WC') && WC()->checkout()) {
                                    do_action('woocommerce_checkout_shipping');
                                }
                            @endphp
                        </div>
                    </div>
                    {{-- Información adicional --}}
                    <div class="bg-white rounded-2xl shadow p-6">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700">Información adicional</h2>
                        <div class="space-y-4">
                            @php
                                if (function_exists('WC') && WC()->checkout()) {
                                    do_action('woocommerce_before_order_notes', WC()->checkout());
                                    do_action('woocommerce_after_order_notes', WC()->checkout());
                                }
                            @endphp
                        </div>
                    </div>
                </div>
                {{-- Columna derecha: Resumen del pedido --}}
                
<div class="bg-white rounded-2xl shadow p-6">
  <h2 class="text-xl font-semibold mb-4 text-gray-700">Resumen del pedido</h2>

  {{-- Tabla del pedido --}}
  <div class="space-y-4">
    @php
      if (function_exists('WC') && WC()->checkout()) {
          do_action('woocommerce_checkout_before_order_review');
      }
    @endphp

    <div id="order_review" class="[&_table]:w-full [&_table]:text-sm [&_th]:text-left [&_td]:py-1 [&_td]:align-top">
      @php
        if (function_exists('WC') && WC()->checkout()) {
            do_action('woocommerce_checkout_order_review');
        }
      @endphp
    </div>

    @php
      if (function_exists('WC') && WC()->checkout()) {
          do_action('woocommerce_checkout_after_order_review');
      }
    @endphp
  </div>

  {{-- Métodos de pago --}}
  <div class="border-t pt-6 mt-6">
    <h3 class="text-lg font-medium mb-4 text-gray-700">Selecciona el método de pago</h3>

    @php
      if (function_exists('WC') && WC()->checkout()) {
          do_action('woocommerce_checkout_payment');
      }
    @endphp
  </div>
</div>

            </div>
        </div>
    </form>
    @php     
        if (function_exists('WC') && WC()->checkout()) {
            do_action('woocommerce_after_checkout_form', WC()->checkout());
        }  
    @endphp
@endsection
