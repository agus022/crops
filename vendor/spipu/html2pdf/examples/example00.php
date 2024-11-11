<?php
/**
 * Html2Pdf Library - example
 *
 * HTML => PDF converter
 * distributed under the OSL-3.0 License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2023 Laurent MINGUET
 */
require_once '../../../autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
    ob_start();
    $content = ob_get_clean();
    $content = '
    <html>
    <body>
    <h1>Hola mundo desde un PDF credo con HTML</h1>
    <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem saepe accusamus perferendis adipisci asperiores exercitationem dolor sint totam! Eligendi ea distinctio ex nemo. Ab exercitationem, saepe excepturi animi ipsam nisi.</p>
    </body>
    ';

    $html2pdf = new Html2Pdf('P', 'A4', 'fr');
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content);
    $html2pdf->output('example00.pdf');
} catch (Html2PdfException $e) {
    $html2pdf->clean();

    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
