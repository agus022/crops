<?php
header("Content-type: application/json; charset=utf-8");
require_once('rol.class.php');
$app = new Rol();
$accion = $_SERVER['REQUEST_METHOD'];
$id = (isset($_GET['id'])) ? $_GET['id'] : null;
$data =[];
switch ($accion) {
    case 'POST':
        $datos=$_POST;
        $resultado = $app->create($datos);
        echo $resultado;
        if($resultado==1){
            $data['mensaje']="Se creo correctamente";

        }else{
            $data['mensaje'] = "Ocurrio algun error";
        }
    break;
    case 'modificar':
        $data = $_POST['data'];
        $resultado = $app->update($id, $data);
        if ($resultado) {
            $mensaje = "El rol se actualizó correctamente! :)";
            $tipo = "success";
        } else {
            $mensaje = "ERROR!, el rol no fue actualizado :(";
            $tipo = "danger";
        }
        $roles = $app->readAll();
        break;
    case 'DELETE':
        if (!is_null($id)) {
            if (is_numeric($id)) {
                $resultado = $app->delete($id);
                if ($resultado) {
                    $mensaje = "El rol se ha eliminado correctamente :)";
                } else {
                    $mensaje = "ERROR! :(";
                }
            }
        }
        $data['mensaje']=$mensaje;
        break;
    default:
        if(!is_null($id) && is_numeric($id)){
            $roles =$app->readOne($id);
        }else{
            $roles = $app->readAll();
        }
        $data = $roles;
}
echo json_encode($data);
?>