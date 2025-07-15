{{-- Encabezado MÓVIL --}}


{{-- Encabezado ESCRITORIO --}}
<nav class="hidden lg:flex bg-[#165DFF] text-white shadow-md w-full m-0 p-0">
  <div class="flex flex-col w-full max-w-7xl px-4 py-3 mx-auto">
    <div class="flex items-center justify-between w-full">
      @include('partials.logo-blessrom')
      @include('partials.buscador-principal')
      @include('partials.desktop-cuenta-registro-carrito')
    </div>
    <div class="flex items-center space-x-6 mt-4">
      @include('partials.desktop-menu')
      @include('partials.destok-enlaces-adicionales')
    </div>
  </div>
</nav>





