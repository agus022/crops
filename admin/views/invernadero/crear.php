<?php require('views/header.php'); ?>
<h1>Nuevo Invernadero</h1>

<form method="post" action="invernadero.php?accion=nuevo">
    <div class="mb-3">
        <label for="invernadero" class="form-label">Nombre Invernadero</label>
        <input type="text" name="data[invernadero] " placeholder="Ingrese el nombre" class="form-control" />
    </div>
    <div class="mb-3">
        <label for="latitud" class="form-label">Latitud</label>
        <input type="text" name="data[latitud]" placeholder="Ingrese la latitud" class="form-control" />
    </div>
    <div class="mb-3">
        <label for="latitud" class="form-label">Longitud</label>
        <input type="text" name="data[longitud]" placeholder="Ingrese la longitud" class="form-control" />
    </div>
    <div class="mb-3">
        <label for="area" class="form-label">Area m²</label>
        <input type="number" name="data[area]" placeholder="Ingrese el area" class="form-control" />
    </div>
    <div class="mb-3">
        <label for="fecha" class="form-label">Fecha creacion</label>
        <input type="date" name="data[fecha_creacion]" placeholder="Ingrese la fecha" class="form-control" />
    </div>

    <input type="submit" name="data[enviar]" value="Guardar" class="btn btn-success" />
</form>

<?php require('views/footer.php'); ?>