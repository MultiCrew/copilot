@extends('layouts.base')

@section('layout')
    <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
        @include('includes.nav')
    </nav>

@yield('content')

@endsection