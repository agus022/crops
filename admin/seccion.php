<?php
require_once("seccion.class.php");
require_once("invernadero.class.php");
$appInvernadero = new Invernadero();

$app = new Seccion;
$app->checkRol('Administrador');

$accion = (isset($_GET['accion']))?$_GET['accion']:null; //if ternario 
$id = (isset($_GET['id'])) ? $_GET['id'] : null;
switch ($accion){
    case 'crear':
        $invernaderos = $appInvernadero-> readAll();
        include('views/seccion/crear.php');
        break;
    case 'nuevo':
        $data = $_POST['data'];
        $resultado = $app->create($data);
        if ($resultado){
            $mensaje = "La sección se agrego correctamente! :)";
            $tipo = "success";

        }else{
            $mensaje = "ERROR! :(";
            $tipo = "danger";
        }
        $secciones = $app->readAll();
        include('views/seccion/index.php');
        break;
    case 'actualizar':
        $invernaderos = $appInvernadero->readAll();
        
        $secciones = $app-> readOne($id);
        include('views/seccion/crear.php');
        break;
    case 'modificar':
        $data=$_POST['data'];
        $resultado=$app->update($id,$data);
        if ($resultado) {
            $mensaje = "La sección se actualizo correctamente! :)";
            $tipo = "success";
        } else {
            $mensaje = "No se actualizo :(";
            $tipo = "danger";
        }
        $secciones = $app->readAll();
        include('views/seccion/index.php');
        break;
    case 'eliminar':
        if(!is_null($id)){
            if(is_numeric($id)){
                $resultado=$app->delete($id);
                if($resultado){
                    $mensaje='Se elimino correctamente ';
                    $tipo='success';
                }else{
                    $mensaje = 'ERROR ';
                    $tipo = 'danger';
                }
            }
        }
        $secciones = $app->readAll();
        include('views/seccion/index.php');
        break;
    case 'reporte':
        $app->reporte();
        break;
    default:
        $secciones=$app -> readAll();
        include('views/seccion/index.php');
}
require_once('views/footer.php');
?>