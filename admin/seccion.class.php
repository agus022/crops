<?php
require_once('../sistema.class.php');
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
                        text-align: center;
                    }
                    .header {
                        margin-bottom: 20px;
                    }
                    .header img {
                        width: 70px;
                        height: 70px;
                    }
                    .header h1 {
                        font-size: 20px;
                        margin: 10px 0;
                    }
                    .header h3 {
                        font-size: 14px;
                        margin: 0;
                        color: #555;
                    }
                    .table-container {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        margin: 20px auto;
                        width: 80%;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        font-size: 14px;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        text-align: left;
                        padding: 12px;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                    td:first-child {
                        width: 60%; /* Define un ancho mayor para la primera columna */
                    }
                    tr:nth-child(even) {
                        background-color: #f9f9f9;
                    }
                    .footer {
                        margin-top: 20px;
                        font-size: 12px;
                        color: #555;
                    }
                    .qr-code {
                        margin-top: 10px;
                    }
                    .qr-code img {
                        width: 120px;
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <img src="../image/invernadero.png" alt="Logo">
                    <h1>Reporte de Secciones e Invernaderos</h1>
                    <h3>Listado actualizado de todos las secciones</h3>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Sección</th>
                                <th>Invernadero</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($result as $seccion) {
                $content .= '
                            <tr>
                                <td>' . htmlspecialchars($seccion['Seciones']) . '</td>
                                <td>' . htmlspecialchars($seccion['Invernaderos']) . '</td>
                            </tr>';
            }

            $content .= '
                        </tbody>
                    </table>
                </div>
                <div class="footer">
                    Ubicación: Instituto Tecnologico de Celaya, Celaya, Gto. 
                </div>
                <div class="qr-code">
                    <img src="../qr_image/' . $id_factura . '.png" alt="Código QR">
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


    function grafico(){
        $data = $this->readAll();
        ob_start();
        ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load("current", {
        packages: ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Element", "Area", {
                role: "style"
            }],
            <?php foreach ($data as $invernadero): ?>["<?php echo ($invernadero['seccion']); ?>", <?php echo ($invernadero['area']); ?>, "#AF1740"],
            <?php endforeach; ?>
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {
                calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"
            },
            2
        ]);

        var options = {
            title: "Área por cada seccion",
            width: 1000,
            height: 500,
            bar: {
                groupWidth: "95%"
            },
            legend: {
                position: "none"
            },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
        }
        </script>
        <div id="columnchart_values" style="width: 900px; height: 300px;"></div>
        <?php
    }

    function excelSeccion(){
        require_once '../vendor/autoload.php';
        $data = $this->readAll();
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        //configura tencabezadso , tipo los titulos de una tabla th 
        $activeWorksheet->setCellValue('A1', '#ID Sección');
        $activeWorksheet->setCellValue('B1', 'Sección');
        $activeWorksheet->setCellValue('C1', 'Área');
        $activeWorksheet->setCellValue('D1', 'Invernadero');
        //estilos a la letra para los encabezados
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        ];
        $activeWorksheet->getStyle('A1:D1')->applyFromArray($headerStyle);
        //llena con los datos obtenidos de la funcion 
        $row = 2; //iniicar en renglon 2 para los datos
        foreach ($data as $item) {
            $activeWorksheet->setCellValue('A' . $row, $item['id_seccion']);
            $activeWorksheet->setCellValue('B' . $row, $item['seccion']);
            $activeWorksheet->setCellValue('C' . $row, $item['area']);
            $activeWorksheet->setCellValue('D' . $row, $item['invernadero']);
            $row++;
        }
        //ajustar celdas 
        foreach (range('A', 'D') as $col) {
            $activeWorksheet->getColumnDimension($col)->setAutoSize(true);
        }
        // archivo excel 
        $filename = 'Secciones_Invernaderos.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        //descarga del archivo
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
    
}
?>