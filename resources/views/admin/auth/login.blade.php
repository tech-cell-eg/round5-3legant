@extends('adminlte::auth.login')

@section('auth_header', 'Welcome to 3legant Admin 🚀')
@section('auth_form', '@csrf')
@section('auth_footer')
    <p class="text-center text-muted">Contact Admin if you forget your password.</p>
@endsection
