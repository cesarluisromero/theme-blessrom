@php defined('ABSPATH') || exit; @endphp

<form method="post" class="space-y-6">
  @php do_action('woocommerce_before_edit_address_form_' . $load_address); @endphp

  {{-- Iterar campos del formulario --}}
  @if (!empty($address) && is_array($address))
    @foreach ($address as $key => $field)
      <div class="mb-4">
        <label for="{{ $key }}" class="block font-medium text-gray-700 mb-1">
          {{ $field['label'] ?? ucfirst($key) }}
          @if (!empty($field['required']))
            <span class="text-red-500">*</span>
          @endif
        </label>

        <input
          type="{{ $field['type'] ?? 'text' }}"
          name="{{ $key }}"
          id="{{ $key }}"
          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 p-2"
          value="{{ old($key, $field['value'] ?? '') }}"
          @if (!empty($field['required'])) required @endif
        >

        @if (!empty($field['description']))
          <p class="text-sm text-gray-500 mt-1">{{ $field['description'] }}</p>
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
