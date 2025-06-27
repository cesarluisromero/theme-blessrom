<div x-data="productGallery()" class="swiper-container product-swiper block lg:hidden mb-6">
    {{-- Encabezado móvil con título del producto --}}
    <div class="text-center text-lg font-semibold text-gray-800">
        {{ $product->get_name() }}
    </div>
    <div class="swiper-wrapper">
        @php $ids = array_merge([$main_image], $attachment_ids); @endphp
        @foreach ($ids as $id)
            <div class="swiper-slide">
                <img src="{{ wp_get_attachment_image_url($id, 'large') }}" class="w-full h-auto object-contain">
            </div>
        @endforeach
    </div>
    <div class="swiper-pagination mt-2"></div>

    <div class="px-4 py-4 space-y-3">
        {{-- Precio --}}
        <div class="text-center text-xl font-bold text-blue-600">
            {!! $product->get_price_html() !!}
        </div>

        {{-- Atributos --}}
        <div class="text-sm text-center text-gray-700">
            @if($product->get_attribute('pa_talla'))
                <div><strong>Talla:</strong> {{ $product->get_attribute('pa_talla') }}</div>
            @endif
            @if($product->get_attribute('pa_color'))
                <div><strong>Color:</strong> {{ $product->get_attribute('pa_color') }}</div>
            @endif
        </div>

        <div class="flex flex-col gap-2">
            @php
                $colorMap = [
                    'azul' => '#165DFF', 'rojo' => '#FF0000', 'verde' => '#00AA00',
                    'negro' => '#000000', 'blanco' => '#FFFFFF', 'gris' => '#888888',
                    'amarillo' => '#FFFF00', 'rosado' => '#FFC0CB', 'camell' => '#cfa781',
                    'marron' => '#7B3F00', 'verde-oli' => '#556B2F', 'gris-claro' => '#ccc',
                ];

                $alpineProps = [
                    'colorMap' => $colorMap,
                    'availableVariations' => array_values($filtered_variations),
                    'cartQuantities' => $cart_quantities,
                    'selected_pa_talla' => '',
                    'selected_pa_color' => '',
                ];
            @endphp

            <form
                x-data='alpineCart(@json($alpineProps))'
                x-ref="form"
                x-init="setTimeout(() => updateMaxQty(), 50)"
                method="post"
                @submit.prevent="addToCartAjax($refs.form)"
                class="space-y-4"
            >
                @csrf
                <input type="hidden" name="_wpnonce" value="{{ wp_create_nonce('woocommerce-add-to-cart') }}">
                <input type="hidden" name="add-to-cart" value="{{ $product->get_id() }}">
                <input type="hidden" name="variation_id" :value="selectedVariationId()">
                <input type="hidden" name="attribute_pa_talla" :value="selected_pa_talla">
                <input type="hidden" name="attribute_pa_color" :value="selected_pa_color">

                <!-- Talla -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 text-center">Talla</label>
                    <div class="flex flex-wrap gap-2 justify-center mt-2">
                        @php $tallas = array_map('trim', explode(',', $product->get_attribute('pa_talla'))); @endphp
                        @foreach ($tallas as $talla)
                            <button
                                type="button"
                                @click="selected_pa_talla = '{{ strtolower(trim($talla)) }}'; selected_pa_color = ''; updateMaxQty()"
                                :class="selected_pa_talla === '{{ strtolower(trim($talla)) }}'
                                    ? 'bg-blue-600 text-white border-blue-600'
                                    : 'bg-white text-gray-700 border-gray-300'"
                                class="min-w-[48px] px-3 py-2 border rounded-lg font-medium text-sm shadow-sm transition-all duration-150 text-center">
                                {{ trim($talla) }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Color -->
                <div x-show="selected_pa_talla" class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-700 text-center">Color</label>
                    <div class="flex justify-center gap-3">
                        <template x-for="color in validColors()" :key="color">
                            <div class="relative group">
                                <button type="button"
                                    @click="selected_pa_color = color; updateMaxQty()"
                                    :class="selected_pa_color === color ? 'ring-2 ring-offset-2 ring-blue-500' : ''"
                                    :style="'background-color:' + (colorMap[color] ?? '#ccc')"
                                    class="w-9 h-9 rounded-full border border-gray-300 transition-all duration-200">
                                </button>
                                <div class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 text-xs bg-gray-700 text-white px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span x-text="color"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Cantidad y Botón -->
                <div x-show="selected_pa_talla && selected_pa_color">
                    <input
                        type="number"
                        x-model="quantity"
                        :max="maxQty"
                        min="1"
                        class="w-full border border-gray-300 rounded px-3 py-2 text-center"
                    />
                    <button
                        type="submit"
                        class="w-full py-2 rounded font-semibold"
                        :class="maxQty <= 0 ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-blue-600 text-white'"
                        :disabled="maxQty <= 0">
                        <template x-if="maxQty > 0">Agregar al carrito</template>
                        <template x-if="maxQty <= 0">Sin stock disponible</template>
                    </button>
                </div>

                <p x-show="errorMessage" class="text-red-600 font-semibold" x-text="errorMessage"></p>
            </form>

            <a href="#" @click.prevent="buyNow()" class="w-full text-center bg-green-600 text-white py-2 rounded font-semibold">
                Comprar ahora
            </a>
        </div>
    </div>
</div>