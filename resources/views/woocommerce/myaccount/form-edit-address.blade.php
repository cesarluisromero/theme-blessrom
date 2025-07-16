@php
  defined('ABSPATH') || exit;
@endphp

<form method="POST" class="space-y-6">
  @php do_action('woocommerce_before_edit_address_form_' . $load_address); @endphp

  {{-- Iterar campos --}}
  @foreach ($address as $key => $field)
    <div class="mb-4">
      <?php
        if (function_exists('woocommerce_form_field')) {
          echo woocommerce_form_field(
            $key,
            $field,
            wc_get_post_data_by_key($key, $field['value'])
          );
        }
      ?>
    </div>
  @endforeach

  @php do_action('woocommerce_after_edit_address_form_' . $load_address); @endphp

  <button type="submit"
    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200">
    Guardar dirección
  </button>
</form>

