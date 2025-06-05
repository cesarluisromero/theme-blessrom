{{-- Encabezado MÓVIL --}}
<div class="lg:hidden w-full bg-[#165DFF] text-white px-4 py-2">
  <div class="flex justify-between items-center">
    <button @click="open = !open" class="text-white focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
    <a href="{{ home_url('/') }}" class="text-2xl font-bold">Blessrom</a>
    <div class="flex items-center gap-3">
      <a href="#" class="hover:underline text-sm">Mi cuenta</a>
      <a href="#" class="relative">
        🛒
        <span id="cart-count" class="absolute -top-2 -right-2 bg-[#FFB816] text-white text-xs font-bold rounded-full px-1.5">
          {{ WC()->cart->get_cart_contents_count() }}
        </span>
      </a>
    </div>
  </div>

  {{-- Buscador --}}
  <div class="mt-3">
    <div class="bg-white rounded overflow-hidden flex items-center w-full">
      <?php echo do_shortcode('[fibosearch]'); ?>
    </div>
  </div>

  {{-- Menú lateral móvil dinámico --}}
  @include('partials.mobile-menu')
</div>

{{-- Encabezado ESCRITORIO --}}

<nav class="hidden lg:flex bg-[#165DFF] text-white shadow-md w-full m-0 p-0">
  <div class="flex flex-col w-full max-w-7xl px-4 py-3">

    {{-- Fila superior: Logo + Buscador + Íconos --}}
    <div class="flex items-center justify-between w-full">
      {{-- Logo --}}
      <div class="flex items-center gap-4">
        <a href="{{ home_url('/') }}" class="text-white text-2xl font-bold whitespace-nowrap">Blessrom</a>
      </div>

      {{-- Buscador --}}
      @include('partials.desktop-buscador')

      {{-- Íconos --}}
      <div class="flex items-center space-x-3">
        <a href="#" class="hover:underline">Registrate</a>
        <a href="#" class="hover:underline">Mi cuenta</a>
        <a href="#" class="relative hover:underline widget_shopping_cart_content bg-white text-white p-2 rounded-full">
          🛒
          <span id="cart-count" class="absolute -top-2 -right-2 bg-[#FFB816] text-white text-xs font-bold rounded-full px-1.5">
            {{ WC()->cart->get_cart_contents_count() }}
          </span>
        </a>
      </div>
    </div>

    {{-- Fila inferior: Categorías + Enlaces --}}
    <div class="flex items-center space-x-6 mt-4">
      {{--menu para escritorio--}}
      @include('partials.desktop-menu')
      {{-- Enlaces adicionales --}}
      @include('partials.destok-enlaces-adicionales')
    </div>
  </div>
</nav>





