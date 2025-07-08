@if ( ! defined( 'ABSPATH' ) )
    @php exit; @endphp
@endif

<div id="payment" class="woocommerce-checkout-payment">
    @if ( WC()->cart->needs_payment() )
        <ul class="wc_payment_methods payment_methods methods space-y-4">
            @foreach ( WC()->payment_gateways()->get_available_payment_gateways() as $gateway )
                <li class="wc_payment_method payment_method_{{ esc_attr( $gateway->id ) }} border p-4 rounded-md">
                    <input id="payment_method_{{ esc_attr( $gateway->id ) }}" type="radio" class="input-radio accent-blue-600" name="payment_method" value="{{ esc_attr( $gateway->id ) }}" {{ checked( $gateway->chosen, true, false ) }} />
                    <label for="payment_method_{{ esc_attr( $gateway->id ) }}" class="text-sm font-medium text-gray-800">
                        {!! $gateway->get_title() !!}
                        @if ( $gateway->has_fields() || $gateway->get_description() )
                            <span class="text-gray-500 block text-xs">{!! $gateway->get_description() !!}</span>
                        @endif
                    </label>

                    @if ( $gateway->has_fields() )
                        <div class="payment_box payment_method_{{ esc_attr( $gateway->id ) }} p-4 mt-2 bg-gray-50 border rounded hidden">
                            @php $gateway->payment_fields(); @endphp
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p class="woocommerce-notice woocommerce-notice--info woocommerce-info">{{ __( 'No hay métodos de pago disponibles. Por favor, contáctanos si necesitas ayuda.', 'woocommerce' ) }}</p>
    @endif

    <div class="form-row place-order mt-6">
        <noscript>
            <p class="text-sm text-gray-600">{{ __( 'Debes actualizar la página para confirmar tu pedido correctamente. Por favor, haz clic en el botón de abajo.', 'woocommerce' ) }}</p>
            <button type="submit" class="button alt">{{ __( 'Actualizar total', 'woocommerce' ) }}</button>
        </noscript>

        @php do_action( 'woocommerce_review_order_before_submit' ); @endphp

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl text-sm transition-all duration-200">
            {{ __( 'Realizar el pedido', 'woocommerce' ) }}
        </button>

        @php do_action( 'woocommerce_review_order_after_submit' ); @endphp

        @php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); @endphp
    </div>
</div>
