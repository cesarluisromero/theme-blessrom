@php
    $checkout = WC()->checkout();
@endphp

<div class="space-y-4">
    {{-- Nombre --}}
    <div>
        <label for="billing_first_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
        <input type="text" name="billing_first_name" id="billing_first_name"
            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
            value="{{ $checkout->get_value('billing_first_name') }}" required>
    </div>
    
    {{-- Apellidos --}}
    <div>
        <label for="billing_last_name" class="block text-sm font-medium text-gray-700 mb-1">Apellidos *</label>
        <input type="text" name="billing_last_name" id="billing_last_name"
            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
            value="{{ $checkout->get_value('billing_last_name') }}" required>
    </div>

    {{-- País / Región --}}
    <div>
        <label for="billing_country" class="block text-sm font-medium text-gray-700 mb-1"></label>
        {!! woocommerce_form_field('billing_country', $checkout->get_checkout_fields()['billing']['billing_country'], $checkout->get_value('billing_country')) !!}
    </div>

    {{-- Provincia / Departamento --}}
    <div>
        <label for="billing_state" class="block text-sm font-medium text-gray-700 mb-1"> </label>
        {!! woocommerce_form_field('billing_state', $checkout->get_checkout_fields()['billing']['billing_state'], $checkout->get_value('billing_state')) !!}
    </div>

    {{-- Ciudad --}}
    <div>
        <label for="billing_city" class="block text-sm font-medium text-gray-700 mb-1">Ciudad *</label>
        <input type="text" name="billing_city" id="billing_city"
            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
            value="{{ $checkout->get_value('billing_city') }}" required>
    </div>

    {{-- Dirección --}}
    <div>
        <label for="billing_address_1" class="block text-sm font-medium text-gray-700 mb-1">Dirección *</label>
        <input type="text" name="billing_address_1" id="billing_address_1"
            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
            value="{{ $checkout->get_value('billing_address_1') }}" required>
    </div>

    {{-- Código postal --}}
    <div>
        <label for="billing_postcode" class="block text-sm font-medium text-gray-700 mb-1">Código postal *</label>
        <input type="text" name="billing_postcode" id="billing_postcode"
            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
            value="{{ $checkout->get_value('billing_postcode') }}" required>
    </div>

    {{-- Teléfono --}}
    <div>
        <label for="billing_phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono *</label>
        <input type="tel" name="billing_phone" id="billing_phone"
            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
            value="{{ $checkout->get_value('billing_phone') }}" required>
    </div>

    {{-- Correo electrónico --}}
    <div>
        <label for="billing_email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico *</label>
        <input type="email" name="billing_email" id="billing_email"
            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
            value="{{ $checkout->get_value('billing_email') }}" required>
    </div>
</div>
