<?php
require_once('usuario.class.php');
include('rol.class.php');
$appRoles = new Rol();
$app = new Usuario();
$app->checkRol('Administrador');
$accion = (isset($_GET['accion'])) ? $_GET['accion'] : null;
$id = (isset($_GET['id'])) ? $_GET['id'] : null;

switch ($accion) {
    case 'crear':
        $roles = $appRoles->readAll();
        $misRoles = $app->readAllRoles($id);
        include('views/usuario/crear.php');
        break;
    case 'nuevo':
        $data = $_POST;

        //print_r($_POST);
        //die();
        $resultado = $app->create($data);
        if ($resultado) {
            $mensaje = "El usuario se agregó CORRECTAMENTE";
            $tipo = "success";
        } else {
            $mensaje = "ERROR al agregar el usuario";
            $tipo = "danger";
        }
        $usuarios = $app->readAll();
        include('views/usuario/index.php');
        break;
    case 'actualizar':
        $usuario = $app->readOne($id);
        $roles = $appRoles->readAll();
        $misRoles=$app->readAllRoles($id);
        // echo("<pre>");
        // print_r($miRoles);
        // die();

        include('views/usuario/crear.php');
        break;
    case 'modificar':
        $data = $_POST;
        
        // print_r($data);
        // die();
        $resultado = $app->update($id, $data);
        if ($resultado) {
            $mensaje = "El usuario se actualizó CORRECTAMENTE";
            $tipo = "success";
        } else {
            $mensaje = "ERROR al actualizar el usuario";
            $tipo = "danger";
        }
        $usuarios = $app->readAll();
        include('views/usuario/index.php');
        break;
    case 'eliminar':
        if (!is_null($id)) {
            if (is_numeric($id)) {
                $resultado = $app->delete($id);
                if ($resultado) {
                    $mensaje = "Se elimino correctamente";
                    $tipo = "success";
                } else {
                    $mensaje = "ERROR al emliminar";
                    $tipo = "danger";
                }
            }
        }
        $usuarios = $app->readAll();
        include("views/usuario/index.php");
        break;
    default:
        $usuarios = $app->readAll();
        include 'views/usuario/index.php';
}

require_once('views/footer.php');
