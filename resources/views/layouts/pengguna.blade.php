@extends('layouts.app')

@section('header-nav')
    {{-- Custom navbar for pengguna beranda - rendered inside content --}}
@endsection

@section('content')
    @yield('pengguna-content')
@endsection
