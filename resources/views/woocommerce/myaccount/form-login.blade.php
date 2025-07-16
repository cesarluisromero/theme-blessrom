{{-- resources/views/woocommerce/myaccount/form-login.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="bg-[#f0f0f0] py-12">
  <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 bg-white rounded-xl shadow-md p-8">
    {{-- Login --}}
    <div>
      <h2 class="text-xl font-bold mb-4">Acceder</h2>
      @php do_action('woocommerce_before_customer_login_form'); @endphp
      <form method="post" class="woocommerce-form woocommerce-form-login login space-y-4">
        @php do_action('woocommerce_login_form_start'); @endphp

        <p class="form-row">
          <label for="username">Correo electrónico&nbsp;<span class="text-red-500">*</span></label>
          <input type="text" class="input-text w-full rounded border px-4 py-2" name="username" id="username" autocomplete="username" value="{{ old('username') ?? '' }}" />
        </p>

        <p class="form-row">
          <label for="password">Contraseña&nbsp;<span class="text-red-500">*</span></label>
          <input class="input-text w-full rounded border px-4 py-2" type="password" name="password" id="password" autocomplete="current-password" />
        </p>

        @php do_action('woocommerce_login_form'); @endphp

        <p class="form-row flex items-center justify-between">
          <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
            <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> Recordarme
          </label>
          <a class="text-sm text-blue-600" href="{{ esc_url(wp_lostpassword_url()) }}">¿Olvidaste tu contraseña?</a>
        </p>

        <p class="form-row">
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Acceder
          </button>
        </p>

        @php do_action('woocommerce_login_form_end'); @endphp
        @php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); @endphp
        <input type="hidden" name="login" value="Acceder" />
      </form>
    </div>

    {{-- Registro --}}
    <div>
      <h2 class="text-xl font-bold mb-4">Registrarse</h2>
      <form method="post" class="woocommerce-form woocommerce-form-register register space-y-4">
        @php do_action('woocommerce_register_form_start'); @endphp

        <p class="form-row">
          <label for="reg_email">Correo electrónico&nbsp;<span class="text-red-500">*</span></label>
          <input type="email" class="input-text w-full rounded border px-4 py-2" name="email" id="reg_email" autocomplete="email" value="{{ old('email') ?? '' }}" />
        </p>

        @php do_action('woocommerce_register_form'); @endphp

        <p class="form-row">
          <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            Registrarse
          </button>
        </p>

        @php do_action('woocommerce_register_form_end'); @endphp
        @php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); @endphp
        <input type="hidden" name="register" value="Registrarse" />
      </form>
    </div>
  </div>
</div>
@endsection
