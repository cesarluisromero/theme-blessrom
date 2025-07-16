{{-- resources/views/woocommerce/myaccount/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
  <div class="max-w-4xl mx-auto py-10 px-4 bg-[#f0f0f0] min-h-screen">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Hola {{ wp_get_current_user()->display_name }}</h1>

    <div class="bg-white p-6 rounded-xl shadow">
      <p class="text-gray-700 mb-4">
        Desde el panel de tu cuenta puedes ver tus pedidos recientes, gestionar tus direcciones y editar tu contraseña y los detalles de tu cuenta.
      </p>

      <div class="grid gap-4 grid-cols-1 md:grid-cols-2">
        <a href="{{ esc_url( wc_get_endpoint_url('orders') ) }}" class="block bg-blue-600 hover:bg-blue-700 text-white text-center font-medium py-3 px-5 rounded-xl transition-all">
          🧾 Ver pedidos
        </a>
        <a href="{{ esc_url( wc_get_endpoint_url('edit-address') ) }}" class="block bg-blue-600 hover:bg-blue-700 text-white text-center font-medium py-3 px-5 rounded-xl transition-all">
          🏠 Direcciones
        </a>
        <a href="{{ esc_url( wc_get_endpoint_url('edit-account') ) }}" class="block bg-blue-600 hover:bg-blue-700 text-white text-center font-medium py-3 px-5 rounded-xl transition-all">
          ⚙️ Detalles de la cuenta
        </a>
       <a 
            href="{{ wc_logout_url() }}"
            class="block bg-red-600 hover:bg-red-700 text-white text-center font-medium py-3 px-5 rounded-xl transition-all"
            >
            🚪 Cerrar sesión
        </a>


      </div>
    </div>
  </div>
@endsection
