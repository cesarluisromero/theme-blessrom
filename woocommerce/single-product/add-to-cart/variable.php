<?php
/**
 * Variable product add to cart template con validación unificada
 */
defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

$attr_states = [];
foreach ($attributes as $attribute_name => $options) {
    $slug = sanitize_title($attribute_name);
    $attr_states[] = "selected_{$slug}: " . (count($options) === 1 ? "'" . esc_attr($options[0]) . "'" : "''");
}
$alpine_state = implode(",\n        ", $attr_states);
?>

<form
    x-data="{
        <?= $alpine_state ?>,
        errorMessage: '',
        validateAndSubmit(event) {
            this.errorMessage = '';
            let valid = true;
<?php foreach ($attributes as $attribute_name => $options): 
    if (count($options) > 1):
        $slug = sanitize_title($attribute_name); ?>
            if (!this.selected_<?= $slug ?>) {
                this.errorMessage = 'Por favor selecciona <?= wc_attribute_label($attribute_name) ?>.';
                valid = false;
                return;
            }
<?php endif; endforeach; ?>
            if (valid) {
                event.target.submit();
            }
        }
    }"
    @submit.prevent="validateAndSubmit"
    class="variations_form cart"
    action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>"
    method="post"
    enctype="multipart/form-data"
    data-product_id="<?php echo absint( $product->get_id() ); ?>"
    data-product_variations="<?php echo $variations_attr; ?>"
>

    <?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
        <p class="stock out-of-stock"><?php echo esc_html__( 'Este producto está agotado y no disponible.', 'woocommerce' ); ?></p>
    <?php else : ?>
        <div class="space-y-6">
            <?php foreach ( $attributes as $attribute_name => $options ) :
                $terms = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'all' ) );
                $is_color = strpos( $attribute_name, 'color' ) !== false || strpos( $attribute_name, 'pa_color' ) !== false;
                $slug = sanitize_title( $attribute_name );
                $is_single = count($options) === 1;
                $default = $is_single ? esc_attr($options[0]) : '';
            ?>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2 text-gray-800">
                        <?php echo wc_attribute_label( $attribute_name ); ?>
                    </label>
                    <div class="flex flex-wrap gap-2">
                        <?php
                        $color_map = [
                            'azul'     => '#165DFF',
                            'rojo'     => '#FF0000',
                            'verde'    => '#00AA00',
                            'negro'    => '#000000',
                            'blanco'   => '#FFFFFF',
                            'gris'     => '#888888',
                            'amarillo' => '#FFFF00',
                            'rosado'   => '#FFC0CB',
                        ];

                        foreach ( $terms as $term ) :
                            $label = $term->name;
                            $slug_value = $term->slug;
                            $real_color = $color_map[ $slug_value ] ?? '#ccc';
                            $extra_border = strtolower($real_color) === '#ffffff' ? 'border border-gray-300' : '';
                        ?>
                            <button
                                type="button"
                                @click="selected_<?= $slug ?> = '<?= esc_js( $slug_value ) ?>'; errorMessage = ''"
                                :class="selected_<?= $slug ?> === '<?= esc_js( $slug_value ) ?>'
                                    ? 'ring-2 ring-blue-500 border-blue-500 text-white <?= $is_color ? '' : 'bg-blue-600' ?>'
                                    : 'bg-white text-gray-800 border-gray-300'"
                                class="transition text-sm border rounded px-3 py-1 duration-150 ease-in-out
                                    <?= $is_color ? 'w-8 h-8 rounded-full ' . $extra_border : '' ?>"
                                style="<?= $is_color ? 'background-color:' . esc_attr( $real_color ) . ';' : '' ?>">
                                <?= !$is_color ? esc_html( $label ) : '' ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" name="attribute_<?php echo esc_attr( $slug ); ?>" :value="selected_<?php echo esc_attr( $slug ); ?>" required>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="single_variation_wrap mt-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <div>
                    <label for="quantity" class="sr-only">Cantidad</label>
                    <input
                        type="number"
                        id="quantity"
                        class="w-20 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        name="quantity"
                        value="1"
                        min="1"
                    >
                </div>

                <div class="w-full">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 text-white bg-blue-600 hover:bg-blue-700 rounded-xl text-sm font-medium shadow transition duration-300 ease-in-out w-full sm:w-auto"
                        name="add-to-cart"
                        value="<?php echo esc_attr( $product->get_id() ); ?>"
                    >
                        <img src="<?php echo get_template_directory_uri(); ?>/resources/images/cart-icon.png" alt="Carrito" class="w-5 h-5 mr-2">
                        Agregar al carrito
                    </button>
                </div>
            </div>

            <div x-show="errorMessage" x-text="errorMessage" class="text-red-600 text-sm mt-4" x-transition></div>
        </div>
    <?php endif; ?>
</form>