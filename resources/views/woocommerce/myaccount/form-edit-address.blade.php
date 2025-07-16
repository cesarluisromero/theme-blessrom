@php defined('ABSPATH') || exit; @endphp

<form method="post" class="bg-white p-8 rounded-2xl shadow-xl max-w-4xl mx-auto space-y-6">
  <h2 class="text-2xl font-semibold text-gray-800 mb-4">Editar dirección de facturación</h2>

  @php do_action('woocommerce_before_edit_address_form_' . $load_address); @endphp

  @if (!empty($address) && is_array($address))
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
            class="w-full border border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none p-3 text-sm transition duration-200 ease-in-out"
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

  <div class="pt-4">
    <button type="submit"
      class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all duration-200 relative group">
      <span class="group-disabled:opacity-50">Guardar dirección</span>
      <svg class="animate-spin h-5 w-5 text-white absolute right-5 top-1/2 -translate-y-1/2 hidden group-disabled:inline"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
      </svg>
    </button>
  </div>
</form>
