@extends('layouts.app')

@section('content')
    <section class="max-w-4xl mx-auto py-12 text-center">
        <h1 class="text-3xl font-bold text-green-600 mb-4">¡Gracias por tu compra!</h1>
        <p class="text-lg text-gray-700 mb-6">Tu pedido se ha procesado correctamente y estamos preparando el envío.</p>
        
        <div class="bg-white p-6 rounded-lg shadow-md text-left max-w-md mx-auto">
            <h2 class="text-xl font-semibold mb-2">Resumen de tu pedido:</h2>
            <ul>
                <li><strong>Número de pedido:</strong> {{ $order->get_order_number() }}</li>
                <li><strong>Fecha:</strong> {{ $order->get_date_created()->date('d/m/Y H:i') }}</li>
                <li><strong>Total:</strong> {{ $order->get_formatted_order_total() }}</li>
                <li><strong>Método de pago:</strong> {{ $order->get_payment_method_title() }}</li>
            </ul>
        </div>

        <a href="{{ home_url('/') }}" class="mt-6 inline-block text-blue-600 hover:underline">Volver al inicio</a>
    </section>
@endsection
