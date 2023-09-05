@extends('app')
@section('content')
    @component('calculadora', ['valor' => $valor])
    @endcomponent
@endsection
