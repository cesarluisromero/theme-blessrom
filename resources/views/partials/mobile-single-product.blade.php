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
                    <form method="post" action="{{ esc_url( $product->add_to_cart_url() ) }}">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded font-semibold">Agregar al carrito</button>
                    </form>
                    <a href="#" class="w-full text-center bg-green-600 text-white py-2 rounded font-semibold">Comprar ahora</a>
                </div>
            </div>
        </div>