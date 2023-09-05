@extends('app')
@section('encabezado', "Listado de Productos")
@section('cabecera')
<div class="float float-end d-inline-flex m-3">
    <i class="fas fa-user mr-3 fa-2x"></i>
    <input type="text" size='10px' value="{{ $usuario->getUsuario() }}" 
           class="form-control mr-2 bg-transparent text-white font-weight-bold" disabled>
    <a href="index.php?logout" class="btn btn-warning mr-2">Salir</a>
</div>
@endsection
@section('contenido')
<table class="table table-striped table-dark">
    <thead>
        <tr>
            <th scope="col" class="text-center">Código</th>
            <th scope="col" class="text-center">Nombre</th>
            <th scope="col" class="text-center">Valoración</th>
            <th scpope="col" colspan="2" class="text-center">Valorar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productos as $producto)
        <tr class="text-center">
            <th scope="row">{{ $producto->getId() }}</th>
            <td>{{$producto->getNombre()}}</td>
            <td><div id="votos_{{ $producto->getId() }}" class="float-left">
                    @if ($producto->getVotos() > 0)
                    @php
                    $estrellas = $producto->getPuntos()/$producto->getVotos()
                    @endphp
                    {{ $producto->getVotos() }} {{ ($producto->getVotos() === 1) ? "Valoración" : "Valoraciones" }}                    
                    @for ($i = 1; $i <= $estrellas; $i++)
                    <i class="bi bi-star-fill"></i>
                    @endfor
                    @if ($i - $estrellas <= 0.5)
                    <i class="bi bi-star-half"></i>
                    @endif
                    @else
                    Sin valorar
                    @endif            
                </div></td>
            <td>
                <select name="puntos" class="form-control" id="puntos_{{ $producto->getId() }}">
                    @for ($i = 1; $i <= 5; $i++) 
                    <option>{{ $i }}</option>
                    @endfor
                </select>
            </td>
            <td>
                <button class="btn btn-info boton-votar" data-producto="{{ $producto->getId() }}">Votar</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
@section ('scripts')
<script src="./js/votar.js"></script>
@endsection