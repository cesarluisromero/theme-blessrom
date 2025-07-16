@php defined('ABSPATH') || exit; @endphp

<form method="post" class="bg-white p-8 rounded-2xl shadow-xl max-w-4xl mx-auto space-y-8">
  <h2 class="text-2xl font-semibold text-gray-800 border-b pb-4">Editar dirección de facturación</h2>

  @php do_action('woocommerce_before_edit_address_form_' . $load_address); @endphp

  @if (!empty($address) && is_array($address))
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      @foreach ($address as $key => $field)
        <div>
          <label for="{{ $key }}" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $field['label'] ?? ucfirst($key) }}
            @if (!empty($field['required']))
              <span class="text-red-500">*</span>
            @endif
          </label>

          <input
            type="{{ $field['type'] ?? 'text' }}"
            name="{{ $key }}"
            id="{{ $key }}"
            class="w-full border border-gray-300 rounded-xl focus:border-indigo-500 focus:ring focus:ring-indigo-200 p-3 text-sm transition"
            value="{{ old($key, $field['value'] ?? '') }}"
            @if (!empty($field['required'])) required @endif
          >

          @if (!empty($field['description']))
            <p class="text-xs text-gray-500 mt-1">{{ $field['description'] }}</p>
          @endif
        </div>
      @endforeach
    </div>
  @else
    <p class="text-red-500">No se pudieron cargar los campos del formulario.</p>
  @endif

  @php do_action('woocommerce_after_edit_address_form_' . $load_address); @endphp

  <div class="pt-6">
    <button type="submit"
      class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all duration-200">
      Guardar dirección
    </button>
  </div>
</form>
