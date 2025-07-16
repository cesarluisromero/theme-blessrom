@extends('layouts.app')

@section('content')
<?php defined('ABSPATH') || exit; ?>

<div class="max-w-4xl mx-auto px-6 py-10 bg-white rounded-2xl shadow-xl">
  <h2 class="text-3xl font-bold text-gray-900 mb-8">Dirección de facturación</h2>

  <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
    <?php do_action('woocommerce_before_edit_address_form_' . $load_address); ?>

    <?php if (is_array($address)) : ?>
      <?php foreach ($address as $key => $field) : ?>
        <?php
          // Estilo con Tailwind
          $field['input_class'] = ['w-full', 'rounded-lg', 'border-gray-300', 'shadow-sm', 'focus:border-blue-500', 'focus:ring-blue-500'];
          $field['label_class'] = ['block', 'text-sm', 'font-medium', 'text-gray-700', 'mb-1'];
          $field['class'] = ['w-full'];

          // Verificar si 'value' existe
          $field_value = isset($field['value']) ? wc_get_post_data_by_key($key, $field['value']) : '';

          // Algunos campos deben ocupar toda la fila
          $full_width_fields = ['company', 'address_1', 'address_2', 'country', 'state'];
          $col_class = in_array($key, $full_width_fields) ? 'col-span-2' : '';
        ?>
        <div class="<?php echo esc_attr($col_class); ?>">
          <?php echo woocommerce_form_field($key, $field, $field_value); ?>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p class="col-span-2 text-red-500 text-sm">No se pudieron cargar los campos de dirección.</p>
    <?php endif; ?>

    <?php do_action('woocommerce_after_edit_address_form_' . $load_address); ?>

    <div class="col-span-2 flex justify-end">
      <button type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl text-sm transition duration-200">
        Guardar dirección
      </button>
    </div>
  </form>
</div>
@endsection

