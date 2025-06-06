<div x-data="{ showMenu: false }" class="relative">
    @include('partials.desktop-boton-menu')

    <div x-show="showMenu" x-cloak @click.away="showMenu = false"
         class="absolute bg-white text-black rounded shadow-lg mt-2 w-64 p-4 z-50 max-h-[80vh] overflow-y-auto">

        @if ($categories_by_parent->has(0))
            @foreach ($categories_by_parent[0] as $parent)
                @php $has_children = $categories_by_parent->has($parent->term_id); @endphp

                <div x-data="{ open: false }" class="mb-1">
                    <div class="flex justify-between items-center">
                        <a href="{{ url('/') }}/tienda/?categorias[]={{ $parent->slug }}" 
                           class="block py-1 hover:text-blue-600">
                            {{ $parent->name }}
                        </a>
                        @if ($has_children)
                            @include('partials.desktop-boton-sub-menu')
                        @endif
                    </div>

                    @if ($has_children)
                        @include('partials.desktop-subcategorias', ['children' => $categories_by_parent[$parent->term_id]])
                    @endif
                </div>
            @endforeach
        @else
            <p class="text-sm text-gray-500">No hay categorías disponibles</p>
        @endif

    </div>
</div>
