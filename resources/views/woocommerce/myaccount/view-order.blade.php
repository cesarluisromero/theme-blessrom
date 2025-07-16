@extends('layouts.app')

@section('content')


<div class="container max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">

@php
    $status = $order->get_status();

    $steps = [
        'pending' => ['label' => 'Pendiente', 'color' => 'gray', 'icon' => '⏳'],
        'processing' => ['label' => 'Procesando', 'color' => 'blue', 'icon' => '🔄'],
        'completed' => ['label' => 'Completado', 'color' => 'green', 'icon' => '✅'],
        'failed' => ['label' => 'Fallido', 'color' => 'red', 'icon' => '⚠️'],
        'cancelled' => ['label' => 'Cancelado', 'color' => 'red', 'icon' => '❌'],
        'refunded' => ['label' => 'Reembolsado', 'color' => 'purple', 'icon' => '💸'],
        'on-hold' => ['label' => 'En espera', 'color' => 'yellow', 'icon' => '⏸️'],
    ];

    $mainFlow = ['pending', 'processing', 'completed']; // solo para barra de progreso

    $currentIndex = array_search($status, $mainFlow) !== false ? array_search($status, $mainFlow) : 0;
@endphp

<div class="w-full mt-8">
    <h2 class="text-lg font-semibold mb-4">Seguimiento del pedido</h2>
    <div class="flex items-center justify-between">
        @foreach ($mainFlow as $index => $step)
            @php
                $color = $steps[$step]['color'];
                $label = $steps[$step]['label'];
                $icon = $steps[$step]['icon'];
                $active = $index <= $currentIndex;
            @endphp
            <div class="flex-1 flex items-center">
                <div class="flex flex-col items-center text-xs font-medium text-center w-full">
                    <div class="w-8 h-8 flex items-center justify-center rounded-full {{ $active ? 'bg-' . $color . '-600 text-white' : 'bg-gray-300 text-gray-500' }}">
                        {{ $icon }}
                    </div>
                    <span class="mt-2 text-{{ $active ? $color . '-700' : 'gray-400' }}">{{ $label }}</span>
                </div>
                @if (!$loop->last)
                    <div class="flex-1 h-1 mx-2 {{ $active ? 'bg-' . $color . '-500' : 'bg-gray-300' }}"></div>
                @endif
            </div>
        @endforeach
    </div>
</div>

  <h1 class="text-2xl font-bold mb-4">Detalles del pedido</h1>

  <p class="mb-6 text-gray-700">
    El pedido <span class="font-semibold">#{{ $order->get_order_number() }}</span> se realizó el
    <span class="font-semibold">{{ $order->get_date_created()->date_i18n('d/m/Y') }}</span> y está actualmente
    <span class="font-semibold capitalize">{{ wc_get_order_status_name($order->get_status()) }}</span>.
  </p>

  <div class="mb-6">
    <h2 class="font-bold text-lg mb-2">Productos</h2>
    <ul class="space-y-2">
      @foreach ($order->get_items() as $item)
        @php $product = $item->get_product(); @endphp
        <li class="flex justify-between border-b py-2">
          <div>
            <p class="font-semibold">{{ $item->get_name() }}</p>
            <p class="text-sm text-gray-600">Talla: {{ $item->get_meta('pa_talla') }} | Color: {{ $item->get_meta('pa_color') }}</p>
          </div>
          <div class="text-right">           
            <p>{{ $item->get_quantity() }} × {{ str_replace('&nbsp;', ' ', strip_tags($order->get_formatted_line_subtotal($item))) }}</p>
          </div>
        </li>
      @endforeach
    </ul>
  </div>

  <div class="grid grid-cols-2 gap-4 text-sm text-gray-700 mb-6">
    <div>
      <h3 class="font-bold text-base mb-1">Método de pago</h3>
      <p>{{ $order->get_payment_method_title() }}</p>
    </div>
    <div class="text-right">
      <h3 class="font-bold text-base mb-1">Total</h3>
      <p>{{ str_replace('&nbsp;', ' ', strip_tags($order->get_formatted_order_total())) }}</p>
    </div>
  </div>

  @if ($order->get_formatted_billing_address())
    <div class="mb-4">
      <h3 class="font-bold text-base mb-1">Dirección de facturación</h3>
                               
      <p class="text-gray-700">{!! $order->get_formatted_billing_address() !!}</p>
    </div>
  @endif

  {{-- Acciones como pagar o cancelar --}}
  <div class="mt-6 flex space-x-4">
    @foreach (wc_get_account_orders_actions($order) as $action)
        @if ($action['name'] !== 'Ver')
            <a href="{{ esc_url($action['url']) }}"
            class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition text-sm font-medium">
            {{ esc_html($action['name']) }}
            </a>
      @endif
    @endforeach
    </div>
</div>
@endsection
