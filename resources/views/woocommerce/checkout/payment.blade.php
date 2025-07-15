<div class="woocommerce-checkout-payment">
    @if (WC()->cart->needs_payment())
        @php
            do_action('woocommerce_review_order_before_payment');
            $available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
        @endphp

        <ul class="space-y-4">
            @foreach ($available_gateways as $gateway)
                <li class="border rounded-lg p-4 w-full {{ $gateway->chosen ? 'border-blue-600' : 'border-gray-300' }}">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="payment_method" value="{{ $gateway->id }}" class="accent-blue-600" {{ $gateway->chosen ? 'checked' : '' }}>
                        <span class="font-medium text-sm text-gray-800">{{ $gateway->get_title() }}</span>
                    </label>

                    @if ($gateway->has_fields() || $gateway->get_description())
                        <div class="mt-4 ml-6 text-sm text-gray-600 w-full">
                            {!! $gateway->get_description() !!}
                            {!! $gateway->payment_fields() !!}
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>

        @php do_action('woocommerce_review_order_after_payment'); @endphp
    @endif
</div>
