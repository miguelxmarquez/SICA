<?php

//require_once('../../includes/tcpdf/config/lang/spa.php');
//require_once('../../includes/tcpdf/tcpdf.php');
//include '/../../conex.php';

require_once('../../includes/tcpdf/config/lang/spa.php');
require_once('../../includes/tcpdf/tcpdf.php');

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


//Data loading
include '../../conex.php';
$sql = "SELECT ci, nombre, apellido, fecha_n, sexo, email
        FROM personas
        WHERE activo = 1
        ORDER BY ci DESC";
$tbl = '<table style="width: 638px;" cellspacing="1">
<tr>
    <td colspan="5">Reporte de todos los docentes del IUPSM registrados en SICA</td>
</tr>
    </table>';
$tbl .= '<table style="width: 638px;">';
$tbl .= '<thead>
            <tr style="height: 20px; background-color:#efefef;font-weight: bold;" >
                <td style="border: 0px solid #000000; width: 70px; text-align: center;">CI</td>
                <td style="border: 0px solid #000000; width: 144px; text-align: center;">NOMBRE</td>
                <td style="border: 0px solid #000000; width: 150px; text-align: center;">APELLIDO</td>
                <td style="border: 0px solid #000000; width: 78px; text-align: center;">FECHA N.</td>
                <td style="border: 0px solid #000000; width: 36px; text-align: center;">SEXO</td>
                <td style="border: 0px solid #000000; width: 180px; text-align: center;">EMAIL</td>
            </tr>
        </thead>';
if ($result = mysql_query($sql)) {
    $num_rw = mysql_num_rows($result);

    if ($num_rw > 0) {
        while ($A = mysql_fetch_array($result)) {
            $ci = $A["ci"];
            $nombre = $A["nombre"];
            $apellido = $A["apellido"];
            $fecha = $A["fecha_n"];
            $sexo = $A["sexo"];
            $email = $A["email"];
// -----------------------------------------------------------------------------
            $tbl .= '
                    <tr>
                        <td style="border: 0px solid #000000; width: 70px;">' . $ci . '</td>
                        <td style="border: 0px solid #000000; width: 144px;text-align:center">' . $nombre . '</td>
                        <td style="border: 0px solid #000000; width: 150px;text-align:center ">' . $apellido . '</td>
                        <td style="border: 0px solid #000000; width: 78px;text-align:center">' . $fecha . '</td>
                        <td style="border: 0px solid #000000; width: 36px;text-align:center">' . $sexo . '</td>
                        <td style="border: 0px solid #000000; width: 180px; text-align:center">' . $email . '</td>
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
$pdf->Output('docentes_activos.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
