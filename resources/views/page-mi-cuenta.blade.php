{{-- resources/views/page-mi-cuenta.blade.php --}}
@extends('layouts.app')

@section('content')
  {{-- Mostrar login y registro si el usuario no está logueado --}}
  @if (!is_user_logged_in())
    {!! \Roots\view('woocommerce.myaccount.form-login')->render() !!}
  @else
    {{-- Si está logueado, redirigir al dashboard de WooCommerce --}}
    @php wp_safe_redirect(get_permalink(get_option('woocommerce_myaccount_page_id'))) @endphp
    @php exit @endphp
  @endif
@endsection