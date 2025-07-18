@extends('layouts.app')

@section('content')
  @php
    do_action('woocommerce_before_edit_account_form');
@endphp

<form class="space-y-6" method="post" action="" {!! do_action('woocommerce_edit_account_form_tag') !!}>

    @php do_action('woocommerce_edit_account_form_start'); @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="account_first_name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="account_first_name" id="account_first_name" autocomplete="given-name"
                   value="{{ old('account_first_name', $user->first_name) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary" required>
        </div>
        <div>
            <label for="account_last_name" class="block text-sm font-medium text-gray-700">Apellido</label>
            <input type="text" name="account_last_name" id="account_last_name" autocomplete="family-name"
                   value="{{ old('account_last_name', $user->last_name) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary" required>
        </div>
    </div>

    <div>
        <label for="account_display_name" class="block text-sm font-medium text-gray-700">Nombre público</label>
        <input type="text" name="account_display_name" id="account_display_name"
               aria-describedby="account_display_name_description"
               value="{{ old('account_display_name', $user->display_name) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary" required>
        <p class="text-xs text-gray-500 mt-1" id="account_display_name_description">
            Este nombre se mostrará en tu cuenta y en reseñas.
        </p>
    </div>

    <div>
        <label for="account_email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
        <input type="email" name="account_email" id="account_email" autocomplete="email"
               value="{{ old('account_email', $user->user_email) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary" required>
    </div>

    @php do_action('woocommerce_edit_account_form_fields'); @endphp

    <fieldset class="border-t pt-6 space-y-4">
        <legend class="text-sm font-semibold text-gray-700 mb-4">Cambiar contraseña</legend>

        <div>
            <label for="password_current" class="block text-sm font-medium text-gray-700">Contraseña actual</label>
            <input type="password" name="password_current" id="password_current" autocomplete="off"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary">
        </div>

        <div>
            <label for="password_1" class="block text-sm font-medium text-gray-700">Nueva contraseña</label>
            <input type="password" name="password_1" id="password_1" autocomplete="off"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary">
        </div>

        <div>
            <label for="password_2" class="block text-sm font-medium text-gray-700">Confirmar nueva contraseña</label>
            <input type="password" name="password_2" id="password_2" autocomplete="off"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary">
        </div>
    </fieldset>

    @php do_action('woocommerce_edit_account_form'); @endphp

    <div class="pt-4">
        @php wp_nonce_field('save_account_details', 'save-account-details-nonce'); @endphp
        <input type="hidden" name="action" value="save_account_details">
        <button type="submit"
                class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition">
            Guardar cambios
        </button>
    </div>

    @php do_action('woocommerce_edit_account_form_end'); @endphp
</form>

@php do_action('woocommerce_after_edit_account_form'); @endphp

@endsection
