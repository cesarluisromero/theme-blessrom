<?php defined('ABSPATH') || exit; ?>

<div class="max-w-3xl mx-auto p-6 bg-white rounded-2xl shadow-xl">
  <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Editar dirección de facturación</h2>

  <form method="post" class="space-y-5">
    <?php do_action('woocommerce_before_edit_address_form_' . $load_address); ?>

    <?php if (is_array($address)) : ?>
      <?php foreach ($address as $key => $field) : ?>
        <div>
          <?php
          if (function_exists('woocommerce_form_field')) {
            echo woocommerce_form_field(
              $key,
              array_merge($field, [
                'input_class' => ['w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500'],
                'label_class' => ['block text-sm font-medium text-gray-700 mb-1'],
              ]),
              wc_get_post_data_by_key($key, $field['value'])
            );
          } else {
            echo '<p class="text-red-500 text-sm">No se puede mostrar el campo: función no disponible.</p>';
          }
          ?>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p class="text-red-500 text-sm">No se pudieron cargar los campos de dirección.</p>
    <?php endif; ?>

    <?php do_action('woocommerce_after_edit_address_form_' . $load_address); ?>

    <div>
      <button type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl text-sm transition-all duration-200">
        Guardar dirección
      </button>
    </div>
  </form>
</div>
