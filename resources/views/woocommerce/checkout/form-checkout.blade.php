@php
  if (!defined('ABSPATH')) exit;
  $checkout = WC()->checkout();
@endphp

@extends('layouts.app')

@section('content')

  <section class="bg-gray-100 py-10">
    <div class="container mx-auto px-4">
      <h1 class="text-2xl font-bold text-center mb-8">Finalizar compra</h1>

      <form name="checkout" method="post" class="woocommerce-checkout grid grid-cols-1 lg:grid-cols-2 gap-8"
            action="{{ esc_url(wc_get_checkout_url()) }}" enctype="multipart/form-data">
        
        {{-- Columna izquierda: Datos del cliente --}}
        <div class="space-y-8">

          {{-- Detalles de facturación --}}
          <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Datos de facturación</h2>
            @php do_action('woocommerce_checkout_billing'); @endphp
          </div>

          {{-- Detalles de envío --}}
          <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Datos de envío</h2>
            @php do_action('woocommerce_checkout_shipping'); @endphp
          </div>

          {{-- Información adicional --}}
          <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Información adicional</h2>
            @php do_action('woocommerce_before_order_notes', $checkout); @endphp
            @php woocommerce_form_field('order_comments', [
                'type'        => 'textarea',
                'class'       => ['form-row-wide'],
                'label'       => __('Notas del pedido'),
                'placeholder' => __('Notas sobre tu pedido, por ejemplo, notas especiales para la entrega.'),
              ], $checkout->get_value('order_comments')); @endphp
            @php do_action('woocommerce_after_order_notes', $checkout); @endphp
          </div>

        </div>

        {{-- Columna derecha: Resumen del pedido y pago --}}
        <div class="bg-white p-6 rounded-lg shadow">
          <h2 class="text-xl font-semibold mb-4">Resumen del pedido</h2>

          @php do_action('woocommerce_checkout_before_order_review_heading'); @endphp

          <div id="order_review" class="woocommerce-checkout-review-order">
            @php do_action('woocommerce_checkout_order_review'); @endphp
          </div>

          @php do_action('woocommerce_checkout_after_order_review'); @endphp
        </div>
      </form>
    </div>
  </section>

  @php do_action('woocommerce_after_checkout_form', $checkout); @endphp
@endsection
