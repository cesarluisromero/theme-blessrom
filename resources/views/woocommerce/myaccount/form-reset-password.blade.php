@extends('layouts.app')

@section('content')
@php
  // Capturar los valores de key y login desde GET al cargar la vista
  $reset_key = $_GET['key'] ?? '';
  $reset_login = $_GET['login'] ?? '';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $key = sanitize_text_field($_POST['reset_key'] ?? '');
      $login = sanitize_user($_POST['reset_login'] ?? '');
      $password1 = $_POST['password_1'] ?? '';
      $password2 = $_POST['password_2'] ?? '';

      if (empty($password1) || empty($password2)) {
          wc_add_notice('Por favor completa ambos campos de contraseña.', 'error');
      } elseif ($password1 !== $password2) {
          wc_add_notice('Las contraseñas no coinciden.', 'error');
      } else {
          $user = check_password_reset_key($key, $login);

          echo '<pre style="background: #fee; padding: 10px;">';
          echo "Resultado de check_password_reset_key:\n";
          var_dump($user);
          echo '</pre>';

          if (is_wp_error($user)) {
              wc_add_notice('El enlace de restablecimiento no es válido o ha expirado.', 'error');
          } else {
              reset_password($user, $password1);
              wc_add_notice('¡Contraseña actualizada correctamente! Puedes iniciar sesión ahora.', 'success');

              // Redirigir a la página de "Mi cuenta"
              wp_safe_redirect(wc_get_page_permalink('myaccount'));
              exit;
          }
      }
  }
@endphp

<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow">
  <h1 class="text-xl font-bold mb-4 flex items-center gap-2">
    🔒 Restablecer contraseña
  </h1>

  {{-- Mostrar mensajes --}}
  @if (wc_notice_count())
    <div class="mb-4">
      {!! wc_print_notices() !!}
    </div>
  @endif
    <pre class="bg-gray-100 p-3 rounded">
    Key recibido: {{ request()->get('key') }}
    Login recibido: {{ request()->get('login') }}
    </pre>
  {{-- Formulario de restablecimiento --}}
  <form method="post" class="space-y-4">
    @php do_action('woocommerce_reset_password_form_start') @endphp

    <input type="hidden" name="reset_key" value="{{ $reset_key }}">
    <input type="hidden" name="reset_login" value="{{ $reset_login }}">

    <div class="bg-gray-100 text-sm text-gray-700 p-2 rounded">
      <p><strong>Key recibido:</strong> {{ $reset_key }}</p>
      <p><strong>Login recibido:</strong> {{ $reset_login }}</p>
    </div>

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
