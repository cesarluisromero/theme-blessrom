@php
  $filtros_activados = 0;

  if (!empty($_GET['categorias'])) {
    $filtros_activados += count((array) $_GET['categorias']);
  }

  if (!empty($_GET['talla'])) {
    $filtros_activados += count((array) $_GET['talla']);
  }

  if (!empty($_GET['marcas'])) {
    $filtros_activados += count((array) $_GET['marcas']);
  }

  if (!empty($_GET['min_price']) || !empty($_GET['max_price'])) {
    $filtros_activados++;
  }
@endphp

{{-- Contenedor principal --}}
<div class="relative">
  {{-- Fondo oscuro detrás del panel en móvil --}}
  <div id="mobile-overlay"
       class="fixed inset-0 bg-white bg-opacity-40 z-80 hidden lg:hidden"
       onclick="document.getElementById('mobile-filters').classList.add('hidden'); this.classList.add('hidden')">
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    {{-- Sidebar de filtros (visible en móvil y escritorio) --}}
    <aside id="mobile-filters"
        class="fixed top-[80px] left-0 w-full h-[calc(100vh-80px)] bg-white z-80 lg:z-0 p-6 overflow-y-auto hidden 
        lg:static lg:block lg:col-span-1 lg:h-auto lg:overflow-visible lg:p-0 border-r border-gray-200">


      {{-- Encabezado del panel de filtros solo visible en móvil --}}
      <div class="flex justify-between items-center mb-4 lg:hidden">
        <h2 class="text-lg font-bold text-gray-800">Filtros</h2>
        <button onclick="document.getElementById('mobile-filters').classList.add('hidden'); document.getElementById('mobile-overlay').classList.add('hidden');" class="text-2xl text-gray-500 hover:text-gray-700">
          &times;
        </button>
      </div>

      @include('partials.filtros-productos')
    </aside>

    {{-- Contenido de productos --}}
    <div class="lg:col-span-3">
      {{-- Botón Filtros solo en móvil --}}
      
      {{-- Fila superior de control de filtros en móvil --}}
        @if ($filtros_activados > 0)
        <div class="lg:hidden px-4 pt-4 pb-2 bg-white flex justify-between items-center space-x-2">
            {{-- Botón Filtros --}}
            <button
            onclick="document.getElementById('mobile-filters').classList.remove('hidden'); document.getElementById('mobile-overlay').classList.remove('hidden');"
            class="flex items-center gap-2 text-sm font-semibold text-gray-800 border border-gray-300 bg-white px-4 py-2 rounded-lg shadow hover:bg-gray-100 transition"
            >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 019 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
            </svg>
            Filtros ({{ $filtros_activados }})
            </button>

            {{-- Botón Limpiar --}}
            <a href="{{ url()->current() }}"
            class="flex items-center gap-2 text-sm text-gray-600 border border-gray-200 px-3 py-2 rounded-lg hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Limpiar filtros
            </a>
        </div>
        @else
        {{-- Solo botón Filtros sin contador --}}
        <div class="lg:hidden px-4 pt-4 pb-2 bg-white flex justify-end">
            <button
                onclick="document.getElementById('mobile-filters').classList.remove('hidden'); document.getElementById('mobile-overlay').classList.remove('hidden');"
                class="flex items-center gap-2 text-sm font-semibold text-gray-800 border border-gray-300 bg-white px-4 py-2 rounded-lg shadow hover:bg-gray-100 transition"
                >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 019 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                </svg>
                Filtros
            </button>
            {{-- Chips de filtros aplicados --}}
                @if ($filtros_activados > 0)
                <div class="lg:hidden px-4 pb-2 flex flex-wrap gap-2 mt-2">
                    @php
                    // Función para generar la URL sin un filtro específico
                    function remove_filter_url($param, $value) {
                        $query = $_GET;
                        if (isset($query[$param])) {
                            $items = (array) $query[$param];
                            $items = array_filter($items, fn($v) => $v !== $value);
                            if (empty($items)) {
                                unset($query[$param]);
                            } else {
                                $query[$param] = $items;
                            }
                        }
                        return url()->current() . '?' . http_build_query($query);
                    }
                    @endphp

                    {{-- Categorías --}}
                    @if (!empty($_GET['categorias']))
                    @foreach ((array) $_GET['categorias'] as $slug)
                        @php
                        $term = get_term_by('slug', $slug, 'product_cat');
                        @endphp
                        @if ($term)
                        <a href="{{ remove_filter_url('categorias', $slug) }}"
                            class="flex items-center gap-1 bg-gray-100 text-sm text-gray-800 px-3 py-1 rounded-full border border-gray-300 hover:bg-gray-200 transition">
                            {{ $term->name }}
                            <span class="text-gray-500 hover:text-red-500 font-bold text-xs">&times;</span>
                        </a>
                        @endif
                    @endforeach
                    @endif

                    {{-- Tallas --}}
                    @if (!empty($_GET['talla']))
                    @foreach ((array) $_GET['talla'] as $slug)
                        <a href="{{ remove_filter_url('talla', $slug) }}"
                        class="flex items-center gap-1 bg-gray-100 text-sm text-gray-800 px-3 py-1 rounded-full border border-gray-300 hover:bg-gray-200 transition">
                        {{ ucfirst($slug) }}
                        <span class="text-gray-500 hover:text-red-500 font-bold text-xs">&times;</span>
                        </a>
                    @endforeach
                    @endif

                    {{-- Marcas --}}
                    @if (!empty($_GET['marcas']))
                    @foreach ((array) $_GET['marcas'] as $slug)
                        @php
                        $term = get_term_by('slug', $slug, 'product_brand');
                        @endphp
                        @if ($term)
                        <a href="{{ remove_filter_url('marcas', $slug) }}"
                            class="flex items-center gap-1 bg-gray-100 text-sm text-gray-800 px-3 py-1 rounded-full border border-gray-300 hover:bg-gray-200 transition">
                            {{ $term->name }}
                            <span class="text-gray-500 hover:text-red-500 font-bold text-xs">&times;</span>
                        </a>
                        @endif
                    @endforeach
                    @endif

                    {{-- Precio --}}
                    @if (!empty($_GET['min_price']) || !empty($_GET['max_price']))
                    <a href="{{ remove_filter_url('min_price', $_GET['min_price'] ?? '') }}"
                        class="flex items-center gap-1 bg-gray-100 text-sm text-gray-800 px-3 py-1 rounded-full border border-gray-300 hover:bg-gray-200 transition">
                        Precio
                        <span class="text-gray-500 hover:text-red-500 font-bold text-xs">&times;</span>
                    </a>
                    @endif
                </div>
                @endif

        </div>
        @endif
      @include('partials.grid-productos')
    </div>
  </div>
</div>
