<?php
include ("invernadero.class.php");
$app = new Invernadero;
// $app -> conexion();
// print_r($app);
// $result = $app -> readAll();
// print_r($result);
$accion = (isset($_GET['accion']))?$_GET['accion']:null; //if ternario 
switch ($accion){
    case 'crear':
        include('views/invernadero/crear.php');
        break;
    case 'nuevo':
        $data = $_POST['data'];
        $app->create($data);
        break;
    case 'actualizar':
        break;
    case 'eliminar':
        break;
    default:
        $invernaderos=$app -> readAll();
        include('views/invernadero/index.php');
}

?>