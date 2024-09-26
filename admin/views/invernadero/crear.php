<?php require('views/header.php'); ?>

    <h1 class="p-4 cards-aling"><?php if($accion == "crear"):echo('Nuevo');else: echo('Modicar');endif;?> Invernadero</h1>
    <div class="card cards-aling " style=" width: 600px;">
        <form method="post" action="invernadero.php?accion=<?php if($accion=="crear"):echo('nuevo');else:echo('modificar&id='.$id);endif;?>" class="p-4">
            <div class="mb-3">
                <label for="invernadero" class="form-label">Nombre Invernadero</label>
                <input type="text" name="data[invernadero] " placeholder="Ingrese el nombre" value="<?php if(isset($invernaderos['invernadero'])):echo($invernaderos['invernadero']);endif;?>" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="latitud" class="form-label">Latitud</label>
                <input type="text" name="data[latitud]" placeholder="Ingrese la latitud" value="<?php if(isset($invernaderos['latitud'])):echo($invernaderos['latitud']);endif;?>" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="latitud" class="form-label">Longitud</label>
                <input type="text" name="data[longitud]" placeholder="Ingrese la longitud" value="<?php if(isset($invernaderos['longitud'])):echo($invernaderos['longitud']);endif;?>" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="area" class="form-label">Area m²</label>
                <input type="number" name="data[area]" placeholder="Ingrese el area"  value="<?php if(isset($invernaderos['area'])):echo($invernaderos['area']);endif;?>"class="form-control" />
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha creacion</label>
                <input type="date" name="data[fecha_creacion]" placeholder="Ingrese la fecha"  value="<?php if(isset($invernaderos['fecha_creacion'])):echo($invernaderos['fecha_creacion']);endif;?>"class="form-control" />
            </div>
            <input type="submit" name="data[enviar]" value="Guardar" class="btn btn-success border-radius-cards" />
        </form>
    </div>
<?php require('views/footer.php'); ?>