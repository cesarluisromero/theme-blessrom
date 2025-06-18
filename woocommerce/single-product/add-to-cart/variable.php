<?php
defined('ABSPATH') || exit;

global $product;

// Filtrar variaciones con disponibilidad válida (no vacía y stock > 0)
$filtered_variations = array_filter($available_variations, function ($variation) {
    if (empty($variation['availability_html'])) return false;
    if (preg_match('/(\d+)/', $variation['availability_html'], $matches)) {
        return intval($matches[1]) > 0;
    }
    return false;
});

// Convertir variaciones a JSON
$filtered_variations_json = wp_json_encode(array_values($filtered_variations));
$variations_attr = function_exists('wc_esc_json') 
    ? wc_esc_json($filtered_variations_json) 
    : _wp_specialchars($filtered_variations_json, ENT_QUOTES, 'UTF-8', true);

// Calcular cantidades en el carrito por variación
$cart_quantities = [];
foreach (WC()->cart->get_cart() as $item) {
    if (!empty($item['variation_id'])) {
        $vid = $item['variation_id'];
        $cart_quantities[$vid] = ($cart_quantities[$vid] ?? 0) + $item['quantity'];
    }
}

// Preparar datos para Alpine
$alpine_data = [
    'maxQty' => 10,
    'quantity' => 1,
    'availableVariations' => json_decode($filtered_variations_json),
    'errorMessage' => '',
    'cartQuantities' => $cart_quantities
];

foreach ($attributes as $attribute_name => $options) {
    $slug = sanitize_title($attribute_name);
    $alpine_data["selected_{$slug}"] = count($options) === 1 ? esc_attr($options[0]) : '';
}
?>

<form
    x-ref="form"
    x-data="alpineCart()"
    x-init="setTimeout(() => updateMaxQty(), 50)"
    class="variations_form cart"
    action="<?php echo esc_url($product->get_permalink()); ?>"
    method="post"
    enctype="multipart/form-data"
    data-product_id="<?php echo absint($product->get_id()); ?>"
    data-product_variations='<?php echo $variations_attr; ?>'
>
    <?php if (empty($filtered_variations)) : ?>
        <p class="stock out-of-stock text-red-600 font-semibold"><?php echo esc_html__('Este producto está agotado y no disponible.', 'woocommerce'); ?></p>
    <?php else : ?>
        <div class="space-y-6">
            <!-- TALLAS -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2 text-gray-800">
                    <?php echo wc_attribute_label('pa_talla'); ?>
                </label>
                <div class="flex flex-wrap gap-2">
                    <?php
                    $terms_talla = wc_get_product_terms($product->get_id(), 'pa_talla', ['fields' => 'all']);
                    foreach ($terms_talla as $term) :
                        $label = $term->name;
                        $slug_value = $term->slug;
                    ?>
                        <button
                            type="button"
                            @click="selected_pa_talla = '<?= esc_js($slug_value) ?>'; selected_pa_color = ''; errorMessage = ''; updateMaxQty()"
                            :class="selected_pa_talla === '<?= esc_js($slug_value) ?>'
                                ? 'ring-2 ring-blue-500 border-blue-500 text-white bg-blue-600'
                                : 'bg-white text-gray-800 border-gray-300'"
                            class="transition text-sm border rounded px-3 py-1 duration-150 ease-in-out"
                        >
                            <?= esc_html($label) ?>
                        </button>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" name="attribute_pa_talla" :value="selected_pa_talla" required>
            </div>

            <!-- COLORES -->
            <div class="mb-4" x-show="selected_pa_talla" x-transition>
                <label class="block text-sm font-semibold mb-2 text-gray-800">
                    <?php echo wc_attribute_label('pa_color'); ?>
                </label>
                <div class="flex flex-wrap gap-2" x-data="{ colorMap: {
                    'azul': '#165DFF', 'rojo': '#FF0000', 'verde': '#00AA00',
                    'negro': '#000000', 'blanco': '#FFFFFF', 'gris': '#888888',
                    'amarillo': '#FFFF00', 'rosado': '#FFC0CB', 'camell': '#cfa781',
                    'marron': '#7B3F00', 'verde-oli': '#556B2F', 'gris-claro': '#ccc',
                } }">
                    <template x-for="color in validColors()" :key="color">
                        <button
                            type="button"
                            @click="selected_pa_color = color; quantity = 1; errorMessage = ''; updateMaxQty()"
                            :class="selected_pa_color === color
                                ? 'ring-2 ring-blue-500 border-blue-500 text-white'
                                : 'bg-white text-gray-800 border-gray-300'"
                            class="transition text-sm border rounded px-3 py-1 duration-150 ease-in-out w-8 h-8 rounded-full"
                            :style="'background-color:' + (colorMap[color] ?? '#ccc')"
                        ></button>
                    </template>
                </div>
                <input type="hidden" name="attribute_pa_color" :value="selected_pa_color" required>
            </div>
        </div>

        <!-- CANTIDAD Y BOTÓN -->
        <div class="single_variation_wrap mt-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <div x-show="maxQty > 0" x-transition>
                    <label for="quantity" class="sr-only">Cantidad</label>
                    <input type="hidden" name="maxQty" value="0" x-ref="maxQty">
                    <input
                        type="number"
                        id="quantity"
                        class="w-20 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        name="quantity"
                        x-model="quantity"
                        :max="maxQty"
                        min="1"
                    >
                </div>

                <?php do_action('woocommerce_before_add_to_cart_button'); ?>
                <div class="w-full">
                    <input type="hidden" name="variation_id" value="0" x-ref="variationId">
                    <button
                        type="submit"
                        :disabled="maxQty === 0"
                        :class="maxQty === 0 ? 'opacity-50 cursor-not-allowed bg-gray-400 hover:bg-gray-400' : 'bg-blue-600 hover:bg-blue-700'"
                        class="inline-flex items-center justify-center px-6 py-3 text-white rounded text-sm font-medium shadow transition duration-300 ease-in-out w-full sm:w-auto"
                        name="add-to-cart"
                        value="<?php echo esc_attr($product->get_id()); ?>"
                    >
                        <img src="<?php echo get_template_directory_uri(); ?>/resources/images/cart-icon.png" alt="Carrito" class="w-5 h-5 mr-2">
                        <span x-text="maxQty === 0 ? 'Stock agotado' : 'Agregar al carrito'"></span>
                    </button>
                </div>
                <?php do_action('woocommerce_after_add_to_cart_button'); ?>
            </div>

            <!-- MENSAJE + BOTONES -->
            <div x-show="errorMessage" class="text-sm mt-4 space-y-3" x-transition>
                <p class="text-red-600 font-semibold" x-text="errorMessage"></p>

                <div class="flex gap-2 flex-col sm:flex-row">
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>"
                       class="bg-gray-800 text-white text-center px-4 py-2 rounded hover:bg-gray-700 transition text-sm font-medium w-full sm:w-auto">
                        Ver carrito
                    </a>
                    <a href="<?php echo esc_url(home_url('/tienda/')); ?>"
                       class="bg-yellow-400 text-gray-900 text-center px-4 py-2 rounded hover:brightness-90 transition text-sm font-medium w-full sm:w-auto">
                        Seguir comprando
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</form>

<script>
function alpineCart() {
    return {
        ...<?= json_encode($alpine_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>,

        updateMaxQty() {
            const match = this.availableVariations.find(v => {
                return Object.entries(v.attributes).every(([key, val]) => {
                    const attr = key.replace('attribute_', '');
                    return this['selected_' + attr] === val;
                });
            });

            if (match) {
                const vid = match.variation_id;
                const stock = parseInt(match.max_qty) || 0;
                const inCart = this.cartQuantities?.[vid] ?? 0;

                this.maxQty = stock - inCart;

                if (inCart >= stock) {
                    this.errorMessage = "Ya tienes en el carrito toda la cantidad disponible de este producto.";
                    this.maxQty = 0;
                    this.quantity = 0;
                } else {
                    this.errorMessage = "";
                    this.quantity = 1;
                }

                if (this.$refs.variationId) {
                    this.$refs.variationId.value = vid;
                    this.$refs.maxQty.value = this.maxQty;
                }
            } else {
                this.maxQty = 10;
                this.quantity = 1;
                this.errorMessage = "";

                if (this.$refs.variationId) {
                    this.$refs.variationId.value = 0;
                    this.$refs.maxQty.value = 0;
                }
            }
        },

        validColors() {
            const talla = this.selected_pa_talla;
            if (!talla) return [];

            const colors = new Set();
            this.availableVariations.forEach(v => {
                if (v.attributes['attribute_pa_talla'] === talla) {
                    const color = v.attributes['attribute_pa_color'];
                    if (color) colors.add(color);
                }
            });

            return Array.from(colors);
        }
    }
}
</script>
