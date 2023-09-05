<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- css para usar Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
              integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!--Fontawesome CDN-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
              integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <title>@yield('titulo')</title>
    </head>
    <body style="background:silver;">
        @section('cabecera')
        <div class="float float-end d-inline-flex m-3">
            <i class="fas fa-user mr-3 fa-2x"></i>
            <input type="text" size='10px' value='{{$nombreUsuario}}' class="form-control mr-2 bg-transparent text-white" disabled>
            <a href='index.php?logout' class='btn btn-danger mr-2'>Salir</a>
        </div>
        <br><br>
        @show 
        <div class="container mt-3">
            <h3 class="text-center mt-3 mb-3">@yield('encabezado')</h3>
            @yield('contenido')
        </div>
    </body>
</html>
