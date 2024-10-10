<?php
require_once('../sistema.class.php');
$app=new Sistema;
$roles=$app->getRol('l20031296@celaya.tecnm.mx');
print_r($roles);
$privilegio=$app->getPrivilegio('l20031296@celaya.tecnm.mx');
print_r($privilegio);
?>
