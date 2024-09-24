<?php require('views/header.php'); ?>

    <div class="p-3 ">
        <h1>Invernaderos</h1>
        <a href="invernadero.php?accion=crear" class="btn btn-success"><i class="bi bi-plus-circle"></i> Nuevo</a>
        <table class="table table-hover">
            <thead>

                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Area</th>
                    <th scope="col">Latitud</th>
                    <th scope="col">Longitud</th>
                    <th scope="col">Fecha Creacion</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invernaderos as $invernadero): ?>
                    <tr>
                        <th scope="row"><?php echo $invernadero['id_invernadero']; ?></th>
                        <td><?php echo $invernadero['invernadero']; ?></td>
                        <td><?php echo $invernadero['area']; ?></td>
                        <td><?php echo $invernadero['latitud']; ?></td>
                        <td><?php echo $invernadero['longitud']; ?></td>
                        <td><?php echo $invernadero['fecha_creacion']; ?></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="invernadero.php?accion=actualizar&id=<?php echo $invernadero['id_invernadero']; ?>" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Actualizar</a>
                                <a href="invernadero.php?accion=eliminar&id=<?php echo $invernadero['id_invernadero']; ?>" class="btn btn-danger"><i class="bi bi-trash"></i> Eliminar</a>
                            </div>
                        </td>

                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>
    </div>
<?php require('views/footer.php'); ?>