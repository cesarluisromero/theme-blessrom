@php
  $min = isset($_GET['min_price']) ? intval($_GET['min_price']) : 0;
  $max = isset($_GET['max_price']) ? intval($_GET['max_price']) : 1500;
@endphp

<aside class="lg:col-span-1 bg-white p-6 rounded-lg shadow space-y-6 border text-sm text-gray-800">
  <form method="get" class="space-y-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-2">Filtrar por</h2>

    {{-- Rango de Precio con slider --}}
    <div>
      <h3 class="font-semibold mb-1">Precio</h3>
      <div class="text-sm text-gray-600 mb-1">
        <span id="price-min-label">${{ $min }}</span> –
        <span id="price-max-label">${{ $max }}</span>
      </div>
      <div id="price-slider" class="mb-2 h-[8px]"></div>
      <input type="hidden" name="min_price" id="min_price" value="{{ $min }}">
      <input type="hidden" name="max_price" id="max_price" value="{{ $max }}">
    </div>

    {{-- Talla --}}
    <div>
      <h3 class="font-semibold mb-1">Talla</h3>
      <ul class="space-y-1">
        @foreach(['s' => 'S', 'm' => 'M', 'l' => 'L'] as $val => $label)
          <li>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="talla[]" value="{{ $val }}" {{ collect(request('talla'))->contains($val) ? 'checked' : '' }} class="accent-blue-500">
              <span>{{ $label }}</span>
            </label>
          </li>
        @endforeach
      </ul>
    </div>

    {{-- Categorías --}}
    <div>
      <h3 class="font-semibold mb-1">Categorías</h3>
      <ul class="space-y-1 max-h-40 overflow-y-auto pr-1">
        @foreach (get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]) as $cat)
          <li>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="categorias[]" value="{{ $cat->slug }}" class="accent-blue-500"
                {{ collect(request('categorias'))->contains($cat->slug) ? 'checked' : '' }}>
              <span>{{ $cat->name }}</span>
            </label>
          </li>
        @endforeach
      </ul>
    </div>

    {{-- Filtro por marcas --}}
        <div>
        <h3 class="font-semibold mb-1">Marcas</h3>
        <ul class="space-y-1 max-h-40 overflow-y-auto pr-1">
            @foreach (get_terms(['taxonomy' => 'product_brand', 'hide_empty' => false]) as $brand)
            <li>
                <label class="flex items-center space-x-2">
                <input type="checkbox" name="marcas[]" value="{{ $brand->slug }}"
                    {{ collect(request('marcas'))->contains($brand->slug) ? 'checked' : '' }} class="accent-blue-500">
                <span>{{ $brand->name }}</span>
                </label>
            </li>
            @endforeach
        </ul>
        </div>



    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition text-sm font-semibold">
      Aplicar filtros
    </button>
  </form>

  @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.6.1/dist/nouislider.min.css">
  @endpush

  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/nouislider@15.6.1/dist/nouislider.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const minInput = document.getElementById('min_price');
        const maxInput = document.getElementById('max_price');
        const minLabel = document.getElementById('price-min-label');
        const maxLabel = document.getElementById('price-max-label');
        const slider = document.getElementById('price-slider');

        if (!slider || !minInput || !maxInput || !minLabel || !maxLabel) return;

        const min = parseInt(minInput.value) || 0;
        const max = parseInt(maxInput.value) || 1500;

        noUiSlider.create(slider, {
          start: [min, max],
          connect: true,
          step: 1,
          range: {
            min: 0,
            max: 1500
          },
          format: {
            to: value => Math.round(value),
            from: value => parseFloat(value)
          }
        });

        slider.noUiSlider.on('update', function (values, handle) {
          const [minVal, maxVal] = values.map(v => Math.round(v));
          minInput.value = minVal;
          maxInput.value = maxVal;
          minLabel.innerText = `$${minVal}`;
          maxLabel.innerText = `$${maxVal}`;
        });
      });
    </script>
  @endpush
</aside>
