<div class="woocommerce-checkout-payment w-full">
    @if (WC()->cart->needs_payment())
        @php
            do_action('woocommerce_review_order_before_payment');
            $available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
        @endphp

        <ul class="space-y-4">
            @foreach ($available_gateways as $gateway)
                <li class="border rounded-xl p-5 bg-white shadow-sm transition-all duration-200 {{ $gateway->chosen ? 'border-blue-600 ring-2 ring-blue-100' : 'border-gray-200' }}">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input 
                            type="radio" 
                            name="payment_method" 
                            value="{{ $gateway->id }}" 
                            class="accent-blue-600 focus:ring-0 focus:outline-none"
                            {{ $gateway->chosen ? 'checked' : '' }}>
                        <span class="font-medium text-sm text-gray-800">{{ $gateway->get_title() }}</span>
                    </label>

                    @if ($gateway->has_fields() || $gateway->get_description())
                        <div class="mt-4 text-sm text-gray-600 space-y-2">
                            @if ($gateway->get_description())
                                <div>{!! $gateway->get_description() !!}</div>
                            @endif
                            <div class="mp-checkout-custom-card-input w-full">
                                {!! $gateway->payment_fields() !!}
                            </div>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>

        @php do_action('woocommerce_review_order_after_payment'); @endphp
    @endif
</div>
