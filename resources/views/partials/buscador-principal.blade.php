<div x-data="{
    query: '',
    results: [],
    loading: false,
    show: false,
    search() {
        if (this.query.length < 2) {
            this.results = []
            this.show = false
            return
        }
        this.loading = true
        fetch(`<?php echo admin_url('admin-ajax.php'); ?>?action=custom_search&query=${this.query}`)
            .then(res => res.json())
            .then(data => {
                this.results = data
                this.show = true
                this.loading = false
            })
    }
}" @click.away="show = false" class="relative w-full max-w-3xl -ml-1 lg:ml-[120px] lg:mx-0 z-50">

  <!-- Barra de búsqueda estilo Amazon/FiboSearch -->
  <div class="flex w-full bg-white rounded-md overflow-hidden shadow-sm focus-within:ring-2 focus-within:ring-yellow-400">
    <input
      type="text"
      placeholder="Buscar en blessrom.com"
      class="flex-grow px-4 py-2 text-sm text-gray-700 placeholder-gray-400 focus:outline-none"
      x-model="query"
      @input.debounce.300ms="search"
    >
    <button class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 flex items-center justify-center transition" @click.prevent>
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
      </svg>
    </button>
  </div>

  <!-- Resultados desplegables -->
  <div x-show="show" x-cloak class="absolute top-full left-0 w-full bg-white border border-gray-200 rounded-b-md mt-1 shadow-lg z-50">
    <template x-if="loading">
      <div class="p-4 text-gray-500 text-sm">Buscando...</div>
    </template>

    <template x-if="!loading && results.length === 0">
      <div class="p-4 text-gray-500 text-sm">Sin resultados.</div>
    </template>

    <template x-for="item in results" :key="item.id">
      <a :href="item.url" class="block px-4 py-2 hover:bg-gray-100 transition">
        <div class="font-semibold text-gray-800" x-text="item.title"></div>
        <div class="text-xs text-gray-500" x-text="item.type"></div>
      </a>
    </template>
  </div>
</div>
