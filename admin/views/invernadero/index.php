<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Invernaderos - Crops</title>
</head>

<body>
    <h1>Invernaderos</h1>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Area</th>
                <th scope="col">Latitud</th>
                <th scope="col">Longitud</th>
                <th scope="col">Fecha Creacion</th>
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

                </tr>
            <? endforeach; ?>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>