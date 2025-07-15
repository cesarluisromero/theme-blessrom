<div class="woocommerce-checkout-payment">
    @if (WC()->cart->needs_payment())
        @php
            do_action('woocommerce_review_order_before_payment');
            $available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
        @endphp

        <ul class="space-y-4">
            @foreach ($available_gateways as $gateway)
                
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="payment_method" value="{{ $gateway->id }}" class="accent-blue-600" {{ $gateway->chosen ? 'checked' : '' }}>
                        <span class="font-medium te xt-sm text-gray-800">{{ $gateway->get_title() }}</span>
                    </label>

                    @if ($gateway->has_fields() || $gateway->get_description())
                        <div class="mt-4 ml-6 text-sm text-gray-600">
                            {!! $gateway->get_description() !!}
                            {!! $gateway->payment_fields() !!}
                        </div>
                    @endif
               
            @endforeach
        </ul>

        @php do_action('woocommerce_review_order_after_payment'); @endphp
    @endif
</div>
