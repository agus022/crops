<?php require('views/headeradministrador.php'); ?>

<div class="p-3 ">
    <h1>Usuarios</h1>
    <?php if (isset($mensaje)): $app->alerta($tipo, $mensaje);
    endif ?>
    <a href="usuario.php?accion=crear" class="btn btn-success"><i class="bi bi-plus-circle"></i> Nuevo</a>
    <table class="table table-hover">
        <thead>

            <tr>
                <th scope="col">#ID</th>
                <th scope="col">Correo</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <th scope="row"><?php echo $usuario['id_usuario']; ?></th>
                    <td><?php echo $usuario['correo']; ?></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="usuario.php?accion=actualizar&id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Actualizar</a>
                            <a href="usuario.php?accion=eliminar&id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-danger"><i class="bi bi-trash"></i> Eliminar</a>
                        </div>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require('views/footer.php'); ?>