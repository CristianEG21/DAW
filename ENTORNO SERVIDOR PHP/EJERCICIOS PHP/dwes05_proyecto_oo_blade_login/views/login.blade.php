@extends('app')
@section('titulo', "Login")
@section('cabecera')
@endsection
@section('encabezado', "Login")
@section('contenido')
<div style="width:300px;" class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Login</h3>
        </div>
        <div class="card-body">
            <form name='login' method='POST' action='<?= $_SERVER['PHP_SELF'] ?>'>
                <div class="input-group m-3">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="<?= "form-control " . ((isset($errorLoginForm) && (empty($nombreUsuario))) ? "is-invalid" : "") ?> me-2" placeholder="usuario" name='usuario' >
                    <div class="invalid-feedback">
                        <p>Introduce el usuario</p>
                    </div>
                </div>
                <div class="input-group m-3">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                    <input type="password" class="<?= "form-control " . ((isset($errorLoginForm) && (empty($pass))) ? "is-invalid" : "") ?> me-2" placeholder="contraseña" name='pass' >
                    <div class="invalid-feedback">
                        <p>Introduce el password</p>
                    </div>
                </div>
                <?php if (isset($errorCredenciales) && $errorCredenciales): ?>
                    <div class="alert alert-danger" role="alert">
                        Credenciales incorrectos
                    </div>
                <?php endif ?>
                <div class="form-group">
                    <input type="submit" value="Login" class="btn float-right btn-success" name='login'>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
