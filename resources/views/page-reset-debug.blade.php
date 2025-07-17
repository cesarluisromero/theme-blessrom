@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow text-center">
  <h1 class="text-2xl font-bold text-green-600 mb-4">✅ ¡La vista Blade se carga correctamente!</h1>
  <p class="text-gray-700 mb-4">Estás viendo <code>page-reset-debug.blade.php</code> desde el tema Blade.</p>

  <a href="{{ wc_get_page_permalink('myaccount') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
    Volver a Mi Cuenta
  </a>
</div>
@endsection
