@extends('layouts.app')

@section('content')
  <div class="max-w-4xl mx-auto px-6 py-10 bg-white rounded-2xl shadow-xl">
    <h2 class="text-3xl font-bold text-gray-900 mb-8">Editar cuenta</h2>

    <form class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6" action="" method="post">
      @php do_action('woocommerce_edit_account_form_start'); @endphp

      {{-- Nombre --}}
      <div>
        <label for="account_first_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
        <input type="text" name="account_first_name" id="account_first_name"
          value="{{ esc_attr($user->first_name) }}"
          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
      </div>

      {{-- Apellidos --}}
      <div>
        <label for="account_last_name" class="block text-sm font-medium text-gray-700 mb-1">Apellidos *</label>
        <input type="text" name="account_last_name" id="account_last_name"
          value="{{ esc_attr($user->last_name) }}"
          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
      </div>

      {{-- Nombre visible --}}
      <div class="col-span-2">
        <label for="account_display_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre visible *</label>
        <input type="text" name="account_display_name" id="account_display_name"
          value="{{ esc_attr($user->display_name) }}"
          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
        <p class="mt-1 text-sm text-gray-500">
          Así será como se mostrará tu nombre en la sección de tu cuenta y en las valoraciones.
        </p>
      </div>

      {{-- Email --}}
      <div class="col-span-2">
        <label for="account_email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico *</label>
        <input type="email" name="account_email" id="account_email"
          value="{{ esc_attr($user->user_email) }}"
          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
      </div>

      {{-- Contraseña actual --}}
      <div class="col-span-2">
        <label for="password_current" class="block text-sm font-medium text-gray-700 mb-1">Contraseña actual</label>
        <input type="password" name="password_current" id="password_current" autocomplete="off"
          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
      </div>

      {{-- Nueva contraseña --}}
      <div>
        <label for="password_1" class="block text-sm font-medium text-gray-700 mb-1">Nueva contraseña</label>
        <input type="password" name="password_1" id="password_1" autocomplete="off"
          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
      </div>

      {{-- Confirmar contraseña --}}
      <div>
        <label for="password_2" class="block text-sm font-medium text-gray-700 mb-1">Confirmar nueva contraseña</label>
        <input type="password" name="password_2" id="password_2" autocomplete="off"
          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
      </div>

      @php do_action('woocommerce_edit_account_form'); @endphp

      <div class="col-span-2 flex justify-end mt-4">
        @php wp_nonce_field('save_account_details'); @endphp
        <button type="submit"
          class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl text-sm transition duration-200"
          name="save_account_details">
          Guardar cambios
        </button>
        <input type="hidden" name="action" value="save_account_details" />
      </div>

      @php do_action('woocommerce_edit_account_form_end'); @endphp
    </form>
  </div>
@endsection
