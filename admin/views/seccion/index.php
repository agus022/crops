<?php require('views/headeradministrador.php'); ?>

<div class="p-3 ">
    <h1>Secciones</h1>
    <?php if (isset($mensaje)): $app->alerta($tipo, $mensaje);
    endif ?>
    <a href="seccion.php?accion=crear" class="btn btn-success"><i class="bi bi-plus-circle"></i> Nuevo</a>
    <table class="table table-hover">
        <thead>

            <tr>
                <th scope="col">#ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Area</th>
                <th scope="col">Invernadero</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($secciones as $seccion): ?>
                <tr>
                    <th scope="row"><?php echo $seccion['id_seccion']; ?></th>
                    <td><?php echo $seccion['seccion']; ?></td>
                    <td><?php echo $seccion['area']; ?></td>
                    <td><?php echo $seccion['invernadero']; ?></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="seccion.php?accion=actualizar&id=<?php echo $seccion['id_seccion']; ?>" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Actualizar</a>
                            <a href="seccion.php?accion=eliminar&id=<?php echo $seccion['id_seccion']; ?>" class="btn btn-danger"><i class="bi bi-trash"></i> Eliminar</a>
                        </div>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require('views/footer.php'); ?>