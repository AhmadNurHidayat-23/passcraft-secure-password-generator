@extends('layouts.app')

@section('content')
<div class="intro-section">
    <h1 class="main-title">Buat Kata Sandi yang Aman.</h1>
    <p class="main-description">Generator kata sandi acak yang sederhana, cepat, dan mudah digunakan.</p>
</div>

<x-generator 
    :password="$password"
    :strength="$strength"
    :entropy="$entropy"
    :length="$length"
    :uppercase="$uppercase"
    :lowercase="$lowercase"
    :numbers="$numbers"
    :symbols="$symbols"
/>
@endsection
