<?php
include ('libs/phpqrcode/qrlib.php');
$file_name= './qr_image/ejemplo.png';
QRcode::png('https://sii.itcelaya.edu.mx/sii/?r=alumno/aplicacionesAlumno/aplicaciones',$file_name,2,3,4);

?>