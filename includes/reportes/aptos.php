<?php
require('class.ezpdf.php');
$pdf = & new Cezpdf('a4');
$pdf->selectFont('../fonts/courier.afm');
$pdf->ezSetCmMargins(1, 1, 1.5, 1.5);

$conexion = mysql_connect(localhost, root, 1234);
mysql_select_db(SICA, $conexion);
$queEmp = "SELECT r.id, r.ci, r.p_nombre, r.p_apellido, r.fecha_n 
FROM registros as r,eva_general as g, eva_odonto as o, eva_psico as p 
WHERE (g.apto=1 AND o.apto=1 AND p.apto=1) AND (r.ci=g.ci AND r.ci=o.ci AND r.ci=p.ci)
ORDER BY r.ci ASC";
$resEmp = mysql_query($queEmp, $conexion) or die(mysql_error());
$totEmp = mysql_num_rows($resEmp);

$ixx = 0;
while ($datatmp = mysql_fetch_assoc($resEmp)) {
    $ixx = $ixx + 1;
    $data[] = array_merge($datatmp, array('id' => $ixx));
}
$titles = array(
    'id' => '<b>ID Registro</b>',
    'ci' => '<b>C.I</b>',
    'p_nombre' => '<b>Nombre</b>',
    'p_apellido' => '<b>Apellido</b>',
    'fecha_n' => '<b>Fecha Nacimiento</b>',
);
$options = array(
    'shadeCol' => array(0.9, 0.9, 0.9),
    'xOrientation' => 'center',
    'width' => 500
);
$txttit = "<b>SICA</b>\n";
$txttit.= "Listado de Registros de la Circunscripcion Militar del Edo. Nueva Espara\n";

$pdf->ezText($txttit, 12);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>Fecha: </b> " . date("d/m/Y"), 10);
$pdf->ezText("<b>Hora: </b> " . date("H:i:s") . "\n\n", 10);
$pdf->ezStream();
?>