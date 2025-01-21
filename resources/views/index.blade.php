@extends('layouts.app')

@section('page-title', 'Peta Indonesia')

@php
    $hasMap = false;
@endphp
@section('content')
    <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
        <div class="text-center">
            <h1 class="text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">
                Jelajahi Peta Indonesia</h1>
            <p class="mt-8 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">Temukan informasi
                geografis lengkap seperti data provinsi, kabupaten/kota, gempa bumi terkini, hingga peta
                tematik untuk berbagai analisis.</p>
        </div>
    </div>
@endsection
