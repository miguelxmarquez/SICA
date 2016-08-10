<?php

require_once('../config/lang/eng.php');
require_once('../tcpdf.php');
include '../../../conex.php';

// Recojemos las variables por url
$id = $_GET["id"];

setlocale(LC_TIME, 'spanish');
$fecha = utf8_encode(ucfirst(strftime("%A, %d de %B del %Y", time())));

$sql = "SELECT * FROM registros WHERE ci = $id";
$result = mysql_query($sql);
$A = @mysql_fetch_array($result);

$sql2 = "SELECT * FROM eva_general WHERE ci = $id ORDER BY id DESC LIMIT 1";
$result2 = mysql_query($sql2);
$A2 = @mysql_fetch_array($result2);

$p_nombre = $A['p_nombre'];
$s_nombre = $A['s_nombre'];
$p_apellido = $A['p_apellido'];
$s_apellido = $A['s_apellido'];

$ci = $A['ci'];
$edad = $A['edad'];
$lugar_n = $A['lugar_n'];
$fecha_n = $A['fecha_n'];
$sexo = $A['sexo'];
if($sexo=="M"){
    $sexo = "Masculino";
}
if($sexo=="F"){
    $sexo = "Femenino";
}
$instruccion = $A['instruccion'];
$capacitacion = $A['capacitacion'];
$ocupacion = $A['ocupacion'];


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Miguel Márqeuz');
$pdf->SetTitle('Planilla de Alta');
$pdf->SetSubject('Asunto');
$pdf->SetKeywords('CIRCUNSCRIPCION MILITAR DEL ESTADO NUEVA ESPARTA');

// remove default header/footer
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(false);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

 // set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------
// set font
$pdf->SetFont('times', 'N', 11);

// add a page
$pdf->AddPage();

// set some text to print
$txt = <<<EOD
<table cellspacing="1" cellpadding="1" border="0">
    <tr>
        <td style="text-align: center;" >
        REPUBLICA BOLIVARIANA DE VENEZUELA<br />
        MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<br />
        VICEMINISTERIO DE LOS SERVICIOS<br />
        SECRETARIA PERMANENTE DE CONSCRIPCION Y ALISTAMIENTO MILITAR<br />
        JUNTA ESTATAL DE CONSCRIPCION Y ALISTAMIENTO MILITAR<br />
        </td>
    </tr>
    <tr>
        <td width="100" style="text-align:center;">        
            <img src="../../../data/fotos/$id.jpg" class="thumb" width="100" height="90/">
        </td>
        <td width="430" style="text-align: center;">
        CIRCUNSCRIPCION MILITAR DEL ESTADO NUEVA ESPARTA<br />
        FILIACION DE ALTA DEL ALISTADO<br /><br />
        $fecha
        </td>
        <td width="100" height="90" style="text-align:center;border:1px;" >
        Pulgar Derecho
        </td>
    </tr>
</table>

EOD;

// print a block of text using Write()
$pdf->writeHTML($txt, true, false, false, false, '');

$tbl = <<<EOD
<h4>Datos Personales</h4>
<br />
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td>Nombres : $p_nombre $s_nombre</td>
        <td>Apellidos: $p_apellido $s_apellido</td>
        <td>CI: $ci </td>
        <td>Edad: $edad </td>
    </tr>
    <tr>
    	<td>Lugar de Nac.: $lugar_n</td>
    	<td>Fecha de Nac.: $fecha_n</td>
    	<td>Sexo: $sexo</td>
    	<td>Grado de Inst.: $instruccion</td>
    </tr>
    <tr>
       <td>Capacitacion: $capacitacion</td>
       <td>Ocupacion: $ocupacion</td>
    </tr>
</table>
<h4>Evaluación Médica General</h4>
<br />
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td>Nombres : $p_nombre $s_nombre</td>
        <td>Apellidos: $p_apellido $s_apellido</td>
        <td>CI: $ci </td>
        <td>Edad: $edad </td>
    </tr>
    <tr>
    	<td>Lugar de Nac.: $lugar_n</td>
    	<td>Fecha de Nac.: $fecha_n</td>
    	<td>Sexo: $sexo</td>
    	<td>Grado de Inst.: $instruccion</td>
    </tr>
    <tr>
       <td>Capacitacion: $capacitacion</td>
       <td>Ocupacion: $ocupacion</td>
    </tr>
  
</table>
<h4>Evaluación Odontológica</h4>
<br />
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td>Nombres : $p_nombre $s_nombre</td>
        <td>Apellidos: $p_apellido $s_apellido</td>
        <td>CI: $ci </td>
        <td>Edad: $edad </td>
    </tr>
    <tr>
    	<td>Lugar de Nac.: $lugar_n</td>
    	<td>Fecha de Nac.: $fecha_n</td>
    	<td>Sexo: $sexo</td>
    	<td>Grado de Inst.: $instruccion</td>
    </tr>
    <tr>
       <td>Capacitacion: $capacitacion</td>
       <td>Ocupacion: $ocupacion</td>
    </tr>
  
</table>
<h4>Evaluación Psicológica</h4>
<br />
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td>Nombres : $p_nombre $s_nombre</td>
        <td>Apellidos: $p_apellido $s_apellido</td>
        <td>CI: $ci </td>
        <td>Edad: $edad </td>
    </tr>
    <tr>
    	<td>Lugar de Nac.: $lugar_n</td>
    	<td>Fecha de Nac.: $fecha_n</td>
    	<td>Sexo: $sexo</td>
    	<td>Grado de Inst.: $instruccion</td>
    </tr>
    <tr>
       <td>Capacitacion: $capacitacion</td>
       <td>Ocupacion: $ocupacion</td>
    </tr>
  
</table>
<h4>Datos Personales</h4>
<br />
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td>Nombres : $p_nombre $s_nombre</td>
        <td>Apellidos: $p_apellido $s_apellido</td>
        <td>CI: $ci </td>
        <td>Edad: $edad </td>
    </tr>
    <tr>
    	<td>Lugar de Nac.: $lugar_n</td>
    	<td>Fecha de Nac.: $fecha_n</td>
    	<td>Sexo: $sexo</td>
    	<td>Grado de Inst.: $instruccion</td>
    </tr>
    <tr>
       <td>Capacitacion: $capacitacion</td>
       <td>Ocupacion: $ocupacion</td>
    </tr>
  
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');


// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output($id.'.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
