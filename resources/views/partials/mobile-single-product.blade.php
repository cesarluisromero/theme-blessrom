{{-- Imagen principal + galería táctil en móvil --}}
        <div x-data="productGallery()" class="swiper-container product-swiper block lg:hidden mb-6">
            {{-- Encabezado móvil con título del producto --}}
            <div class="text-center text-lg font-semibold text-gray-800">
                {{ $product->get_name() }}
            </div>
            <div class="swiper-wrapper">
                @php
                    $ids = array_merge([$main_image], $attachment_ids);
                @endphp
                @foreach ($ids as $id)
                    <div class="swiper-slide">
                        <img src="{{ wp_get_attachment_image_url($id, 'large') }}"
                             class="w-full h-auto object-contain">
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination mt-2"></div>
            <div class="px-4 py-4 space-y-3">
                 {{-- Precio --}}
                <div class="text-center text-xl font-bold text-blue-600">
                {!! $product->get_price_html() !!}
                </div>
                {{-- Atributos del producto --}}
                <div class="text-sm text-center text-gray-700">
                    @if($product->get_attribute('pa_talla'))
                        <div><strong>Talla:</strong> {{ $product->get_attribute('pa_talla') }}</div>
                    @endif
                    @if($product->get_attribute('pa_color'))
                        <div><strong>Color:</strong> {{ $product->get_attribute('pa_color') }}</div>
                    @endif
                </div>
                <div class="flex flex-col gap-2">
                    <form
                        x-data="alpineCart()"
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
                            <label>Talla</label>
                            <div class="flex gap-2">
                                @foreach ($product->get_attribute('pa_talla') ? explode('|', $product->get_attribute('pa_talla')) : [] as $talla)
                                    <button type="button"
                                        @click="selected_pa_talla = '{{ trim($talla) }}'; selected_pa_color = ''; updateMaxQty()"
                                        :class="selected_pa_talla === '{{ trim($talla) }}' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300'"
                                        class="px-3 py-1 border rounded font-semibold text-sm transition">
                                        {{ trim($talla) }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Color -->
                        <div x-show="selected_pa_talla">
                            <label>Color</label>
                           <div class="flex gap-3 mt-2">
                                <template x-for="color in validColors()" :key="color">
                                    <button type="button"
                                        @click="selected_pa_color = color; updateMaxQty()"
                                        :class="selected_pa_color === color ? 'ring-2 ring-offset-2 ring-blue-500' : ''"
                                        :style="'background-color:' + (colorMap[color] ?? '#ccc')"
                                        class="w-8 h-8 rounded-full border border-gray-300 transition-all duration-200">
                                    </button>
                                </template>
                            </div>
                        </div>

                        <!-- Cantidad y botón -->
                        <div x-show="selected_pa_talla && selected_pa_color">
                            <input
                                type="number"
                                x-model="quantity"
                                :max="maxQty"
                                min="1"
                                class="w-full border border-gray-300 rounded px-3 py-2 text-center"
                                />
                            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">
                                Agregar al carrito
                            </button>
                        </div>

                        <!-- Error -->
                        <p x-show="errorMessage" class="text-red-600 font-semibold" x-text="errorMessage"></p>
                    </form>

                    <a href="#"
                        @click.prevent="buyNow()"
                        class="w-full text-center bg-green-600 text-white py-2 rounded font-semibold">
                        Comprar ahora
                    </a>
                </div>
            </div>
        </div>