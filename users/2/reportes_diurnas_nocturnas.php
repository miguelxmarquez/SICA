<?php

//require_once('../../includes/tcpdf/config/lang/spa.php');
//require_once('../../includes/tcpdf/tcpdf.php');
//include '/../../conex.php';

require ('../../includes/tcpdf/config/lang/spa.php');
require ('../../includes/tcpdf/tcpdf.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF {
    
}

// create new PDF document

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Miguel Márquez');
$pdf->SetTitle('Reporte Todos');
$pdf->SetSubject('Asunto');
$pdf->SetKeywords('SICA');

$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
$pdf->SetFont('courier', 'N', 9);
$pdf->AddPage();

$hoy = date("Y-m-d");
//Data loading
@include '../../conex.php';
$sql = "SELECT p.ci, p.nombre, p.apellido, p.fecha_n, SUM(a.h_trabajadas) AS suma, e.especialidad
FROM personas AS p, escuelas AS e, asistencias AS a
WHERE a.id_persona = p.id 
AND p.escuela = e.codigo
AND a.fecha = '$hoy'
GROUP BY p.id
ORDER BY p.ci ASC";

$tbl = '<table style="width: 638px;" cellspacing="1">
<tr>
    <td colspan="5">Reporte de todos los registros de marcaje el día de hoy (Por Escuela)</td>
</tr>
    </table>';
$tbl .= '<table style="width: 638px;">';
$tbl .= '<thead>
            <tr style="background-color:#efefef;font-weight: bold;" >
                <th style="border: 0px solid #000000; width: 80px; text-align: center;">CI</th>
                <th style="border: 0px solid #000000; width: 140px; text-align: center;">NOMBRE</th>
                <th style="border: 0px solid #000000; width: 144px; text-align: center;">APELLIDO</th>
                <th style="border: 0px solid #000000; width: 80px; text-align: center;">FECHA N.</th>
                <th style="border: 0px solid #000000; width: 40px; text-align: center;">HT</th>
                <th style="border: 0px solid #000000; width: 174px; text-align: center;">ESCUELA</th>
            </tr>
        </thead>';
if ($result = @mysql_query($sql)) {
    $num_rw = @mysql_num_rows($result);

    if ($num_rw > 0) {
        while ($A = @mysql_fetch_array($result)) {
            $ci = $A["ci"];
            $nombre = $A["nombre"];
            $apellido = $A["apellido"];
            $fecha = $A["fecha_n"];
            $sexo = $A["suma"];
            $dpto = $A["especialidad"];
// -----------------------------------------------------------------------------
            $tbl .= '
                    <tr>
                        <td style="border: 0px solid #000000; width: 80px;">' . $ci . '</td>
                        <td style="border: 0px solid #000000; width: 140px;text-align:center">' . $nombre . '</td>
                        <td style="border: 0px solid #000000; width: 144px;text-align:center ">' . $apellido . '</td>
                        <td style="border: 0px solid #000000; width: 80px;text-align:center">' . $fecha . '</td>
                        <td style="border: 0px solid #000000; width: 40px;text-align:center">' . $sexo . '</td>
                        <td style="border: 0px solid #000000; width: 174px; text-align:center">' . $dpto . '</td>
                    </tr>';
        }
    } else {
        $tbl = 'No existen registros que mostrar, notifique al personal de sistemas si el error persiste';
        $pdf->writeHTML($tbl, true, false, false, false, '');
    }
}
$tbl .= '</table>';
$pdf->writeHTML($tbl, true, false, false, false, '');

// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('docentes_escuelas.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>