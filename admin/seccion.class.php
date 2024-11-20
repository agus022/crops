<?php
require_once('../sistema.class.php');
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

class Seccion extends Sistema{
    //INSERTAR A LA BASE DE DATOS
    function create($data){
        $result = [];
        $this->conexion();
        $sql = "INSERT INTO seccion (seccion,area,id_invernadero) 
        VALUES (:seccion,:area,:id_invernadero);";
        $insertar = $this -> conn -> prepare($sql);
        //bindParam para evitar las inyecciones de SQL
        $insertar -> bindParam(':seccion',$data['seccion'],PDO::PARAM_STR);
        $insertar->bindParam(':area', $data['area'], PDO::PARAM_INT);
        $insertar->bindParam(':id_invernadero', $data['id_invernadero'], PDO::PARAM_INT);
        $insertar->execute();
        $result =$insertar->rowCount();
        return $result;
    }

    function update ($id,$data){
        $result = [];
        $this->conexion();
        $sql="UPDATE seccion SET seccion=:seccion,area=:area,id_invernadero=:id_invernadero 
        where id_seccion=:id_seccion;";
        $modificar = $this->conn->prepare($sql);
        $modificar->bindParam(':id_seccion', $id, PDO::PARAM_INT);
        $modificar->bindParam(':seccion', $data['seccion'], PDO::PARAM_STR);
        $modificar->bindParam(':area', $data['area'], PDO::PARAM_INT);
        $modificar->bindParam(':id_invernadero', $data['id_invernadero'], PDO::PARAM_INT);
        $modificar->execute();
        $result = $modificar->rowCount();
        return $result;
    }

    function delete ($id){
        $result = [];
        $this->conexion();
        $sql = "DELETE FROM seccion WHERE id_seccion=:id_seccion;";
        $eliminar = $this->conn->prepare($sql);
        $eliminar->bindParam(':id_seccion',$id,PDO::PARAM_INT);
        $eliminar->execute();
        $result=$eliminar->rowcount();
        return $result;
    }

    function readOne($id){
        $result = [];
        $this->conexion();
        $sql ='SELECT * from seccion where id_seccion = :id_seccion;';
        $update =$this->conn->prepare($sql);
        $update->bindParam(':id_seccion',$id,PDO::PARAM_INT);
        $update->execute();
        $result = $update->fetch(PDO::FETCH_ASSOC);
        return $result;        
    }

    function readAll (){
        $this-> conexion();
        $result = [];
        $consulta = 'select s.*,i.invernadero from seccion s join invernadero i on s.id_invernadero=i.id_invernadero;';
        $sql = $this->conn->prepare($consulta);
        $sql ->execute();
        $result = $sql ->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function reporte(){
        require_once '../vendor/autoload.php';
        $this->conexion();
        $sql= 'select * from vseccionesinvernadero';
        $view=$this->conn->prepare($sql);
        $view->execute();
        $result=$view->fetchAll(PDO::FETCH_ASSOC);

        try {
            include('../libs/phpqrcode/qrlib.php');
            $id_factura=rand(1,1000);
            $file_name = '../qr_image/'.$id_factura.'.png';
            QRcode::png('http://localhost/crops/facturas/'.$id_factura, $file_name, 2, 3, 4);
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
                                <th>Sección</th>
                                <th>Invernadero</th>
                            </tr>
                        </thead>
                        <tbody>';

                    foreach ($result as $seccion) {
                        $content .= '<tr>
                        <td>' . htmlspecialchars($seccion['Seciones']) . '</td>
                        <td>' . htmlspecialchars($seccion['Invernaderos']) . '</td>
                    </tr>';
                    }

                    $content .= '</tbody>
                    </table>
                    <div class="footer">
                        Ubicación: Calle Ficticia 123, Ciudad Ejemplo, País
                        <br><img src="../qr_image/' . $id_factura . '.png">
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
?>