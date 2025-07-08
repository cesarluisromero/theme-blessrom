{{-- resources/views/woocommerce/checkout/payment.blade.php --}}
<div class="woocommerce-checkout-payment">
    @php
        if (WC()->cart->needs_payment()) {
            do_action('woocommerce_review_order_before_payment');
            $available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
        }
    @endphp

    <ul class="space-y-4">
        @foreach ($available_gateways as $gateway)
            <li class="border rounded-lg p-4 @if($gateway->chosen) border-blue-600 @else border-gray-300 @endif">
                <label class="flex items-center space-x-2">
                    <input type="radio" name="payment_method" value="{{ $gateway->id }}" class="accent-blue-600" @if($gateway->chosen) checked @endif>
                    <span class="font-medium text-sm text-gray-800">{{ $gateway->get_title() }}</span>
                </label>

                @if ($gateway->has_fields() || $gateway->get_description())
                    <div class="mt-4 ml-6 text-sm text-gray-600">
                        {!! $gateway->get_description() !!}
                        @php $gateway->payment_fields(); @endphp
                    </div>
                @endif
            </li>
        @endforeach
    </ul>

    @php do_action('woocommerce_review_order_after_payment'); @endphp
</div>
