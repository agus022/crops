<?php require('views/headeradministrador.php'); ?>

    <h1 class="p-4 cards-aling"><?php if($accion == "crear"):echo('Nuevo');else: echo('Modicar');endif;?> Sección</h1>
    
    <div class="card cards-aling " style=" width: 600px;">
        <form method="post" action="seccion.php?accion=<?php if($accion=="crear"):echo('nuevo');else:echo('modificar&id='.$id);endif;?>" class="p-4">
            <div class="mb-3">
                <label for="seccion" class="form-label">Nombre Sección</label>
                <input type="text" name="data[seccion] " placeholder="Ingrese el nombre" value="<?php if(isset($secciones['seccion'])):echo($secciones['seccion']);endif;?>" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="latitud" class="form-label">Área</label>
                <input type="text" name="data[area]" placeholder="Ingrese el área" value="<?php if(isset($secciones['area'])):echo($secciones['area']);endif;?>" class="form-control" />
            </div>
            <div class="mb-3">
                <label>Invernadero</label>
                <select name="data[id_invernadero]" class="form-select">
                    <?php foreach ($invernaderos as $invernadero):?>
                    <?php
                        $selected = "";
                        if ($secciones['id_invernadero'] == $invernadero['id_invernadero']){
                            $selected = "selected";
                        }
                            
                    ?>
                    <option value="<?php echo($invernadero['id_invernadero']);?>" <?php echo($selected)?> ><?php echo($invernadero['invernadero']);?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <input type="submit" name="data[enviar]" value="Guardar" class="btn btn-success border-radius-cards" />
        </form>
    </div>
<?php require('views/footer.php'); ?>