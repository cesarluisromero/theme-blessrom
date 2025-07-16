@extends('layouts.app')

@section('content')
<div class="bg-[#F0F0F0] py-12 min-h-screen">
  <div class="max-w-6xl mx-auto px-4 md:px-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Mi Cuenta</h1>

    <div class="grid grid-cols-1 md:grid-cols-[250px_1fr] gap-6">
      {{-- Menú de navegación --}}
      <aside class="bg-white rounded-xl shadow p-6">
        @include('woocommerce.myaccount.navigation')
      </aside>

      {{-- Contenido del dashboard --}}
      <section class="bg-white rounded-xl shadow p-6">
        <p class="text-gray-700 text-lg">
          Hola <strong>{{ esc_html( $user->display_name ) }}</strong> (¿no eres {{ esc_html( $user->display_name ) }}? <a href="{{ esc_url( wc_logout_url() ) }}" class="text-blue-600 hover:underline">Cerrar sesión</a>)
        </p>
        <p class="text-gray-600 mt-4">
          Desde el panel de tu cuenta puedes ver tus <a href="{{ esc_url( wc_get_endpoint_url( 'orders' ) ) }}" class="text-blue-600 hover:underline">pedidos recientes</a>, administrar tus <a href="{{ esc_url( wc_get_endpoint_url( 'edit-address' ) ) }}" class="text-blue-600 hover:underline">direcciones</a> y <a href="{{ esc_url( wc_get_endpoint_url( 'edit-account' ) ) }}" class="text-blue-600 hover:underline">detalles de la cuenta</a>.
        </p>
      </section>
    </div>
  </div>
</div>
@endsection
