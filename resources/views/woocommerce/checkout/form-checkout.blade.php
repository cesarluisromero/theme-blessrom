@extends('layouts.app') 

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Finalizar compra</h1>

    @php do_action('woocommerce_before_checkout_form', $checkout); @endphp

    @if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in())
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-6 text-center">
            Debes estar <a href="{{ wc_get_page_permalink('myaccount') }}" class="underline font-medium">registrado</a> para finalizar tu compra.
        </div>
    @else
        <form name="checkout" method="post" class="checkout grid grid-cols-1 lg:grid-cols-2 gap-6" action="{{ esc_url( wc_get_checkout_url() ) }}" enctype="multipart/form-data">
            @csrf

            {{-- Detalles de facturación --}}
            <div class="space-y-6">
                <h2 class="text-lg font-semibold text-gray-700">Datos de facturación</h2>
                @php do_action('woocommerce_checkout_billing'); @endphp
            </div>

            {{-- Detalles del pedido --}}
            <div class="space-y-6 bg-gray-50 p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-700">Tu pedido</h2>
                @php do_action('woocommerce_checkout_before_order_review_heading'); @endphp

                <div id="order_review" class="woocommerce-checkout-review-order">
                    @php do_action('woocommerce_checkout_order_review'); @endphp
                </div>
            </div>
        </form>
    @endif

    @php do_action('woocommerce_after_checkout_form', $checkout); @endphp
</div>
@endsection
