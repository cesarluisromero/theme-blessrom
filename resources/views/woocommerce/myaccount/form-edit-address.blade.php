<?php defined('ABSPATH') || exit; ?>

<div class="max-w-4xl mx-auto p-8 bg-white rounded-2xl shadow-xl">
  <h2 class="text-3xl font-bold text-gray-900 mb-8">Dirección de facturación</h2>

  <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
    <?php do_action('woocommerce_before_edit_address_form_' . $load_address); ?>

    <?php if (is_array($address)) : ?>
      <?php foreach ($address as $key => $field) : ?>
        <?php
          $value = isset($field['value']) ? $field['value'] : '';

          // Clases Tailwind para inputs y etiquetas
          $field = array_merge($field, [
            'input_class' => ['w-full rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition'],
            'label_class' => ['block text-sm font-medium text-gray-700 mb-1'],
          ]);

          // Forzar ancho completo en campos que deben ocupar 2 columnas
          $full_width_fields = ['company', 'address_1', 'address_2', 'country', 'state'];

          if (in_array($key, $full_width_fields)) {
            echo '<div class="col-span-2">';
          } else {
            echo '<div>';
          }

          if (function_exists('woocommerce_form_field')) {
            echo woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $value));
          } else {
            echo '<p class="text-red-500 text-sm">No se puede mostrar el campo: función no disponible.</p>';
          }

          echo '</div>';
        ?>
      <?php endforeach; ?>
    <?php else : ?>
      <p class="text-red-500 text-sm col-span-2">No se pudieron cargar los campos de dirección.</p>
    <?php endif; ?>

    <?php do_action('woocommerce_after_edit_address_form_' . $load_address); ?>

    <div class="col-span-2 flex justify-end">
      <button type="submit"
        class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl text-sm transition-all duration-200">
        Guardar dirección
      </button>
    </div>
  </form>
</div>
