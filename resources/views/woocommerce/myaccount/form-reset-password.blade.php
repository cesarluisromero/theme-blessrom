@extends('layouts.app')

@section('content')

 @php
  do_action('woocommerce_before_reset_password_form');
@endphp

<div class="max-w-md mx-auto mt-12 bg-white border border-gray-200 shadow-xl rounded-2xl p-8">
  <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Restablecer contraseña</h2>

  <form method="post" class="space-y-6" x-data="{ error: '', submitting: false }">
    @csrf

    <input type="hidden" name="reset_key" value="{{ esc_attr($args['key']) }}">
    <input type="hidden" name="reset_login" value="{{ esc_attr($args['login']) }}">

    <div>
      <label for="password_1" class="block text-sm font-medium text-gray-700">Nueva contraseña</label>
      <input
        type="password"
        name="password_1"
        id="password_1"
        required
        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
      >
    </div>

    <div>
      <label for="password_2" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
      <input
        type="password"
        name="password_2"
        id="password_2"
        required
        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
      >
    </div>

    @php do_action('woocommerce_resetpassword_form') @endphp

    <div>
      <button
        type="submit"
        class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-2 px-4 rounded-lg transition"
        x-bind:disabled="submitting"
        @click="submitting = true"
      >
        Guardar nueva contraseña
      </button>
    </div>

    <template x-if="error">
      <p class="text-red-500 text-sm mt-2" x-text="error"></p>
    </template>
  </form>

  <div class="mt-6 text-center">
    <a href="{{ esc_url( wc_get_page_permalink( 'myaccount' ) ) }}" class="text-sm text-gray-600 hover:text-primary underline">
      ¿Recordaste tu contraseña? Inicia sesión
    </a>
  </div>
</div>

@php
  do_action('woocommerce_after_reset_password_form');
@endphp
 
@endsection
