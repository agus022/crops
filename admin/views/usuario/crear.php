<?php require('views/headeradministrador.php'); ?>

    <h1 class="p-4 cards-aling"><?php if($accion == "crear"):echo('Nuevo');else: echo('Modicar');endif;?> Usuario</h1>
    
    <div class="card cards-aling " style=" width: 600px;">
        <form method="post" action="usuario.php?accion=<?php if($accion=="crear"):echo('nuevo');else:echo('modificar&id='.$id);endif;?>" class="p-4">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="text" name="data[correo] " placeholder="Ingrese el correo" value="<?php if(isset($usuario['correo'])):echo($usuario['correo']);endif;?>" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" name="data[contrasena]" placeholder="Ingrese su contraseña" class="form-control" />
            </div>
            <div class="mb-3">
                <label>Rol</label>                
                <?php foreach($roles as $rol): ?>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" 
                    <?php $checked=''; if(in_array($rol['id_rol'], $misRoles)):$checked='checked'; endif; echo($checked);?> role="switch" id="flexSwitchCheckChecked" name="rol[<?php echo($rol['id_rol']);?>]">
                    <label class="form-check-label" for="flexSwitchCheckChecked"><?php echo($rol['rol']);?></label>
                </div>
                 <?php endforeach;?>
            </div>

            <input type="submit" name="data[enviar]" value="Guardar" class="btn btn-success border-radius-cards" />
        </form>
    </div>
<?php require('views/footer.php'); ?>