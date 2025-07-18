{{-- resources/views/page-mi-cuenta.blade.php --}}
@extends('layouts.app')

@section('content')
  {!! \Roots\view('woocommerce.myaccount.form-login')->render() !!}
  {!! \Roots\view('woocommerce.myaccount.form-lost-password')->render() !!}
  {!! \Roots\view('woocommerce.myaccount.form-register')->render() !!}
  {!! \Roots\view('woocommerce.myaccount.form-reset-password')->render() !!}
  {!! \Roots\view('woocommerce.myaccount.form-edit-account')->render() !!}
  {!! \Roots\view('woocommerce.myaccount.form-edit-address')->render() !!}
@endsection