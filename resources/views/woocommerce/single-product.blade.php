@extends('layouts.app')

@section('content')
  

    <div x-data="{
        currentImage: '{{ wp_get_attachment_image_url($main_image, 'large') }}'
    }" class="container max-w-6xl mx-auto px-2 md:px-4 lg:px-6 py-10">
        
        {{-- Imagen principal + galería táctil en móvil --}}
        @include('partials.mobile-single-product')

        {{-- Galería de escritorio en columnas --}}
        <div class="grid grid-cols-1 lg:grid-cols-[40%_30%_30%] gap-4 desktop-gallery">
            {{-- Columna 1: Imágenes --}}
            @include('partials.single-product-columna1')
            
            {{-- Columna 2: Información --}}
            @include('partials.single-product-columna2')
            
            {{-- Columna 3: Acciones y Descripción --}}
            @include('partials.single-product-columna3')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function productGallery() {
            return {
                init() {
                new Swiper(this.$el, {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    pagination: { el: this.$el.querySelector('.swiper-pagination'), clickable: true },
                    breakpoints: {
                    768: {
                        pagination: false,
                        swipe: false,
                        allowTouchMove: false
                    }
                    }
                });
                }
            }
        }
    </script>
@endpush