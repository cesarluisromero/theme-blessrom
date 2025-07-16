@php defined('ABSPATH') || exit; @endphp

<form method="POST" class="space-y-6">
  @php do_action('woocommerce_before_edit_address_form_' . $load_address); @endphp

  {{-- Iterar campos del formulario --}}
  @foreach ($address as $key => $field)
    <div class="mb-4">
      @if (function_exists('woocommerce_form_field'))
        {!! woocommerce_form_field(
          $key,
          $field,
          wc_get_post_data_by_key($key, $field['value'])
        ) !!}
      @else
        <p class="text-red-500 text-sm">No se puede mostrar el campo: función no disponible.</p>
      @endif
    </div>
  @endforeach

  @php do_action('woocommerce_after_edit_address_form_' . $load_address); @endphp

  <button type="submit"
    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all duration-200">
    Guardar dirección
  </button>
</form>
