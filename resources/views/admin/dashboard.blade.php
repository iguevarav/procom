@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Bienvenido al panel de administración</h1>
@stop

@section('content')
    <p>Este es el contenido principal del dashboard.</p>
@stop

@section('css')
    <link rel="stylesheet" href="/css/custom.css">
@stop

@section('js')
    <script> console.log('Dashboard cargado'); </script>
@stop