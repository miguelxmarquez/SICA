<?php
require('class.ezpdf.php');
$pdf = new Cezpdf('a4');
$pdf->selectFont('../fonts/courier.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);

$conexion = mysql_connect(localhost, root, 1234);
mysql_select_db(sica, $conexion);
$queEmp = "SELECT * FROM personas
ORDER BY r.ci ASC";
$resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
$totEmp = mysql_num_rows($resEmp);

$ixx = 0;
while($datatmp = mysql_fetch_assoc($resEmp)) { 
	$ixx = $ixx+1;
	$data[] = array_merge($datatmp, array('id'=>$ixx));
}
$titles = array(
				'id'=>'<b>ID Registro</b>',
				'ci'=>'<b>C.I</b>',
				'nombre'=>'<b>Nombre</b>',
				'apellido'=>'<b>Apellido</b>',
				'fecha_n'=>'<b>Fecha Nacimiento</b>',
			);
$options = array(
				'shadeCol'=>array(0.9,0.9,0.9),
				'xOrientation'=>'center',
				'width'=>500
			);
$txttit = "<b>SIRSEM</b>\n";
$txttit.= "Listado de Registros de la Circunscripcion Militar del Edo. Nueva Espara\n";

$pdf->ezText($txttit, 12);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>Fecha: </b> ".date("d/m/Y"), 10);
$pdf->ezText("<b>Hora: </b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();
?>