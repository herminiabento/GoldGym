@extends('layouts.blank')

@section('title', 'Página no encontrada')

@section('content')

<div class="text-center py-5 container page-404">
    <h1 class="display-1 text-primary mb-5">404</h1>
    <p class="h4 fw-normal mb-2 lh-lg">Oops. esta página se cayó.</p>
    <p class="h4 noto-serif fw-normal mb-5">¡Pero que nada te detenga!</p>
    <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Volvé al Gym</a>
</div>
@endsection

