<?php
require_once('../sistema.class.php');
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

class Empleado extends Sistema{
    //INSERTAR A LA BASE DE DATOS
    function create($data)
    {
        $result = [];
        $this->conexion();
        $sql = "INSERT INTO empleado (primer_apellido,segundo_apellido,nombre,rfc,fotografia,id_usuario) 
        VALUES (:primer_apellido,:segundo_apellido,:nombre,:rfc,:fotografia,:id_usuario);";
        $insertar = $this->conn->prepare($sql);
        $fotografia= $this->uploadFoto();

        //bindParam para evitar las inyecciones de SQL
        $insertar->bindParam(':fotografia',$fotografia,PDO::PARAM_STR);
        $insertar->bindParam(':primer_apellido', $data['primer_apellido'], PDO::PARAM_STR);
        $insertar->bindParam(':segundo_apellido', $data['segundo_apellido'], PDO::PARAM_STR);
        $insertar->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
        $insertar->bindParam(':rfc', $data['rfc'], PDO::PARAM_STR);
        $insertar->bindParam(':id_usuario', $data['id_usuario'], PDO::PARAM_INT);
        $insertar->execute();
        $result = $insertar->rowCount();
        return $result;
    }

    function update($id, $data)
    {
        $result = [];
        $this->conexion();
        $tmp="";
        if ($_FILES['fotografia']['error'] != 4) {
            $fotografia = $this->uploadFoto();
            $tmp = "fotografia=:fotografia,";
        }
        $sql = "UPDATE empleado SET primer_apellido=:primer_apellido,segundo_apellido=:segundo_apellido,nombre=:nombre,rfc=:rfc,{$tmp}id_usuario=:id_usuario
        where id_empleado=:id_empleado;";
        $modificar = $this->conn->prepare($sql);
        $modificar->bindParam(':id_empleado', $id, PDO::PARAM_INT);
        $modificar->bindParam(':primer_apellido', $data['primer_apellido'], PDO::PARAM_STR);
        $modificar->bindParam(':segundo_apellido', $data['segundo_apellido'], PDO::PARAM_STR);
        $modificar->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
        $modificar->bindParam(':rfc', $data['rfc'], PDO::PARAM_STR);
        if($_FILES['fotografia']['error']!=4){
            $modificar->bindParam(':fotografia', $fotografia, PDO::PARAM_STR);
        }
        $modificar->bindParam(':id_usuario', $data['id_usuario'], PDO::PARAM_INT);
        $modificar->execute();
        $result = $modificar->rowCount();
        return $result;
    }

    function delete($id)
    {
        $result = [];
        $this->conexion();
        $sql = "DELETE FROM empleado WHERE id_empleado=:id_empleado;";
        $eliminar = $this->conn->prepare($sql);
        $eliminar->bindParam(':id_empleado', $id, PDO::PARAM_INT);
        $eliminar->execute();
        $result = $eliminar->rowcount();
        return $result;
    }

    function readOne($id)
    {
        $result = [];
        $this->conexion();
        $sql = 'SELECT * from empleado where id_empleado = :id_empleado;';
        $update = $this->conn->prepare($sql);
        $update->bindParam(':id_empleado', $id, PDO::PARAM_INT);
        $update->execute();
        $result = $update->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function readAll()
    {
        $this->conexion();
        $result = [];
        $consulta = 'SELECT e.*, u.correo FROM empleado e JOIN usuario u ON e.id_usuario = u.id_usuario;';
        $sql = $this->conn->prepare($consulta);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function uploadFoto(){
        $tipos=array('image/jpeg','image/jpg','image/png','image/gif');
        $data=$_FILES['fotografia'];
        $default= "default.png";
        if($data['error']==0){
            if($data['size']<= 1048576){
                if(in_array($data['type'],$tipos)){
                    $n=rand(1,1000000);
                    $nombre=explode('.',$data['name']);
                    $imagen=md5($n.$nombre[0]).".".$nombre[sizeof($nombre) - 1];
                    $origen=$data['tmp_name'];
                    $destino= "C:\\xampp\\htdocs\\crops\\uploads\\".$imagen;

                    if(move_uploaded_file($origen,$destino)){
                        return $imagen;
                    }
                    return $default;
                }
            }
        }
        return $default;
    }

    function reporte (){
        require_once '../vendor/autoload.php';
        $this->conexion();
        $sql = 'SELECT e.*, u.correo FROM empleado e JOIN usuario u ON e.id_usuario = u.id_usuario;';
        $view = $this->conn->prepare($sql);
        $view->execute();
        $result = $view->fetchAll(PDO::FETCH_ASSOC);

        try {
            include('../libs/phpqrcode/qrlib.php');
            //$id_factura = rand(1, 1000);
            $file_name = '../qr_image/empleados.png';
            QRcode::png('http://localhost/crops/facturas/', $file_name, 2, 3, 4);
            ob_start(); // Inicia el buffer de salida.
            $content =
            '<html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 0;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 20px;
                        }
                        th, td {
                            border: 1px solid black;
                            text-align: left;
                            padding: 8px;
                        }
                        th {
                            background-color: #f2f2f2;
                        }
                    </style>
                </head>
                <body>
                    <img src="../image/invernadero.png" width="50" height="50"/>
                    <h1>Reporte de Secciones e Invernaderos</h1>    
                    <h3>Listado actualizado de todos las secciones</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Fotografia</th>
                                <th>Primer Apellido</th>
                                <th>Segundo Apellido</th>
                                <th>Nombre</th>
                                <th>RFC</th>
                                <th>Usuario</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($result as $empleado) {
                $content .= '<tr>
                        <td>' . htmlspecialchars($empleado['primer_apellido']) . '</td>
                        <td>' . htmlspecialchars($empleado['primer_apellido']) . '</td>
                        <td>' . htmlspecialchars($empleado['segundo_apellido']) . '</td>
                        <td>' . htmlspecialchars($empleado['nombre']) . '</td>
                        <td>' . htmlspecialchars($empleado['rfc']) . '</td>
                        <td>' . htmlspecialchars($empleado['correo']) . '</td>
                    </tr>';
            }

            $content .= '</tbody>
                    </table>
                    <div class="footer">
                        Ubicación: Calle Ficticia 123, Ciudad Ejemplo, País
                    </div>
                </body>
            </html>';

            // Limpia el buffer de salida y escribe el contenido en el PDF.
            ob_end_clean();

            $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'fr');
            $html2pdf->setDefaultFont('Arial');
            $html2pdf->writeHTML($content);
            $html2pdf->output('SeccionesInvernaderos.pdf');
        } catch (\Spipu\Html2Pdf\Exception\Html2PdfException $e) {
            $formatter = new \Spipu\Html2Pdf\Exception\ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }

    }
}
