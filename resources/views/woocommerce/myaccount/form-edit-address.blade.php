@php defined('ABSPATH') || exit; @endphp

<form method="post" class="space-y-6 bg-white p-8 rounded-2xl shadow-xl max-w-3xl mx-auto">
  <h2 class="text-xl font-semibold text-gray-800 mb-6">Editar dirección de facturación</h2>

  @php do_action('woocommerce_before_edit_address_form_' . $load_address); @endphp

  @if (!empty($address) && is_array($address))
    @foreach ($address as $key => $field)
      <div>
        <label for="{{ $key }}" class="block text-sm font-medium text-gray-700 mb-1">
          {{ $field['label'] ?? ucfirst($key) }}
          @if (!empty($field['required']))
            <span class="text-red-500">*</span>
          @endif
        </label>

        <input
          type="{{ $field['type'] ?? 'text' }}"
          name="{{ $key }}"
          id="{{ $key }}"
          class="w-full border border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 p-3 text-sm"
          value="{{ old($key, $field['value'] ?? '') }}"
          @if (!empty($field['required'])) required @endif
        >

        @if (!empty($field['description']))
          <p class="text-xs text-gray-500 mt-1">{{ $field['description'] }}</p>
        @endif
      </div>
    @endforeach
  @else
    <p class="text-red-500">No se pudieron cargar los campos del formulario.</p>
  @endif

  @php do_action('woocommerce_after_edit_address_form_' . $load_address); @endphp

  <button type="submit"
    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all duration-200">
    Guardar dirección
  </button>
</form>
