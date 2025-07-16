@extends('layouts.app')

@section('content')
<div class="bg-[#F0F0F0] py-10 min-h-screen">
  <div class="max-w-2xl mx-auto px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
      {{ $load_address === 'billing' ? 'Editar dirección de facturación' : 'Editar dirección de envío' }}
    </h1>

    <form method="post" action="{{ esc_url( wc_get_endpoint_url( 'edit-address', $load_address ) ) }}" class="bg-white p-6 rounded-xl shadow space-y-5">
      @csrf
      @method('POST')
      @php do_action('woocommerce_before_edit_address_form_' . $load_address); @endphp

      @foreach ($address as $key => $field)
        <div>
          {!! woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $field['value'])) !!}
        </div>
      @endforeach

      @php do_action('woocommerce_after_edit_address_form_' . $load_address); @endphp

      <button type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 w-full text-center">
        Guardar dirección
      </button>
    </form>
  </div>
</div>
@endsection
