<?php require('views/headeradministrador.php'); ?>

    <h1 class="p-4 cards-aling"><?php if($accion == "crear"):echo('Nuevo');else: echo('Modicar');endif;?> Empleado</h1>
    
    <div class="card cards-aling " style=" width: 600px;">
        <form method="post" action="empleado.php?accion=<?php if($accion=="crear"):echo('nuevo');else:echo('modificar&id='.$id);endif;?>" class="p-4">
            <div class="mb-3">
                <label for="primer_apellido" class="form-label">Primer Apellido</label>
                <input type="text" name="data[primer_apellido] " placeholder="Ingrese su primer apellido" value="<?php if(isset($empleados['primer_apellido'])):echo($empleados['primer_apellido']);endif;?>" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                <input type="text" name="data[segundo_apellido]" placeholder="Ingrese su segundo apellido" value="<?php if(isset($empleados['segundo_apellido'])):echo($empleados['segundo_apellido']);endif;?>" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="data[nombre]" placeholder="Ingrese su nombre" value="<?php if(isset($empleados['nombre'])):echo($empleados['nombre']);endif;?>" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="rfc" class="form-label">RFC</label>
                <input type="text" name="data[rfc]" placeholder="Ingrese su RFC" value="<?php if(isset($empleados['rfc'])):echo($empleados['rfc']);endif;?>" class="form-control" />
            </div>
            <div class="mb-3">
                <label>Usuarios</label>
                <select name="data[id_usuario]" class="form-select">
                    <?php foreach ($usuarios as $usuario):?>
                    <?php
                        $selected = "";
                        if ($empleados['id_usuario'] == $usuario['id_usuario']){
                            $selected = "selected";
                        }
                            
                    ?>
                    <option value="<?php echo($usuario['id_usuario']);?>" <?php echo($selected)?> ><?php echo($usuario['correo']);?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <input type="submit" name="data[enviar]" value="Guardar" class="btn btn-success border-radius-cards" />
        </form>
    </div>
<?php require('views/footer.php'); ?>