<?php
require_once("empleado.class.php");
require_once("usuario.class.php");
$appUsuario = new Usuario();
$app = new Empleado;
$app->checkRol('Administrador');

$accion = (isset($_GET['accion'])) ? $_GET['accion'] : null; //if ternario 
$id = (isset($_GET['id'])) ? $_GET['id'] : null;
switch ($accion) {
    case 'crear':
        $usuarios = $appUsuario->readAll();
        include('views/empleado/crear.php');
        break;
    case 'nuevo':
        $data = $_POST['data'];
        $resultado = $app->create($data);
        if ($resultado) {
            $mensaje = "El empleado se agrego correctamente! :)";
            $tipo = "success";
        } else {
            $mensaje = "ERROR! :(";
            $tipo = "danger";
        }
        $empleados = $app->readAll();
        include('views/empleado/index.php');
        break;
    case 'actualizar':
        $usuarios = $appUsuario->readAll();
        $empleados = $app->readOne($id);
        include('views/empleado/crear.php');
        break;
    case 'modificar':
        $data = $_POST['data'];
        $resultado = $app->update($id, $data);
        if ($resultado) {
            $mensaje = "El empleado se actualizo correctamente! :)";
            $tipo = "success";
        } else {
            $mensaje = "No se actualizo :(";
            $tipo = "danger";
        }
        $empleados = $app->readAll();
        include('views/empleado/index.php');
        break;
    case 'eliminar':
        if (!is_null($id)) {
            if (is_numeric($id)) {
                $resultado = $app->delete($id);
                if ($resultado) {
                    $mensaje = 'Se elimino correctamente ';
                    $tipo = 'success';
                } else {
                    $mensaje = 'ERROR ';
                    $tipo = 'danger';
                }
            }
        }
        $empleados = $app->readAll();
        include('views/empleado/index.php');
        break;
    case 'reporte':
        $app->reporte();
        break;
    default:
        $empleados = $app->readAll();
        include('views/empleado/index.php');
}
require_once('views/footer.php');
