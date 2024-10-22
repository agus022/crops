<?php require('views/header.php'); ?>

<div class="card cards-aling " style=" width: 600px;">

    <form class="p-4" method="post" action="login.php?accion=login">
        <div class="form-group">
            <label for="exampleInputEmail1">Correo Electronico</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingresa tu email" name="data[correo]">
            <small id="emailHelp" class="form-text text-muted">Nunca compartiremos tu correo electrónico con nadie más.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Contraseña</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Ingresa la contraseña" name="data[contrasena]">
        </div>
        <div class="form-group form-check">
            <a class="form-check-label" href="login.php?acciopn=forgot">Crear cuenta.</a>
            <a class="form-check-label" href="login.php?acciopn=forgot">Recuperar contraseña.</a>
        </div>
        <input type="submit" class="btn btn-primary" value="Entrar" name="enviar" name="data[enviar]" />
    </form>
</div>