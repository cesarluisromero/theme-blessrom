@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow">
  <h1 class="text-xl font-bold mb-4 flex items-center gap-2">
    🔒 Restablecer contraseña
  </h1>

  @if ( wc_notice_count() )
    <div class="mb-4">
      {!! do_action('woocommerce_before_reset_password_form') !!}
    </div>
  @endif

  <form method="post" class="space-y-4">
    @php do_action('woocommerce_reset_password_form_start') @endphp

    <input type="hidden" name="reset_key" value="{{ request()->get('key') }}">
    <input type="hidden" name="reset_login" value="{{ request()->get('login') }}">

    <div>
      <label for="password_1" class="block text-sm font-medium mb-1">Nueva contraseña</label>
      <input type="password" name="password_1" id="password_1" class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
      <label for="password_2" class="block text-sm font-medium mb-1">Confirmar nueva contraseña</label>
      <input type="password" name="password_2" id="password_2" class="w-full border rounded px-3 py-2" required>
    </div>

    @php do_action('woocommerce_reset_password_form') @endphp

    <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition">
      Cambiar contraseña
    </button>

    @php wp_nonce_field('reset_password', 'woocommerce-reset-password-nonce') @endphp
  </form>

  @php do_action('woocommerce_after_reset_password_form') @endphp
</div>
@endsection
