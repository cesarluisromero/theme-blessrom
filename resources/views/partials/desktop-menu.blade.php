{{-- Botón de categorías --}}
        @php
            $product_categories = get_terms([
                'taxonomy'   => 'product_cat',
                'orderby'    => 'name',
                'order'      => 'ASC',
                'hide_empty' => true,
            ]);
$categories_by_parent = collect($product_categories)->groupBy('parent');
@endphp
        <div x-data="{ showMenu: false }" class="relative">
            <button @click="showMenu = !showMenu" class="bg-[#165DFF] border border-white text-white px-4 py-2 rounded inline-flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span>Todas las categorías</span>
                <svg class="h-4 w-4 ml-2 transform transition-transform duration-200" :class="{ 'rotate-180': showMenu }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="showMenu" x-cloak @click.away="showMenu = false" class="absolute bg-white text-black rounded shadow-lg mt-2 w-64 p-4 z-50 max-h-[80vh] overflow-y-auto">
                @if ($categories_by_parent->has(0))
                    @foreach ($categories_by_parent[0] as $parent)
                        @php $has_children = $categories_by_parent->has($parent->term_id); @endphp

                        <div x-data="{ open: false }" class="mb-1">
                            <div class="flex justify-between items-center">
                                <a href="{{ url()->current() }}?categorias[]={{ $parent->slug }}" class="block py-1 hover:text-blue-600">
                                {{ $parent->name }}
                                </a>
                                @if ($has_children)
                                <button @click="open = !open" class="text-sm focus:outline-none">
                                    <svg :class="{ 'rotate-90': open }" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                                @endif
                            </div>

                            {{-- Subcategorías --}}
                            @if ($has_children)
                                <div x-show="open" x-collapse class="pl-4 mt-1">
                                @foreach ($categories_by_parent[$parent->term_id] as $child)
                                    <a href="{{ url()->current() }}?categorias[]={{ $child->slug }}" class="block py-1 hover:text-blue-600">
                                    {{ $child->name }}
                                    </a>
                                @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-sm text-gray-500">No hay categorías disponibles</p>
                @endif
            </div>
        </div>