<?php

// Eliminacion de materias 
session_start();
$id = $_GET["id"];

include '../../conex.php';

$sql_buscar = "SELECT * FROM materias WHERE id = '$id'";
$sql_eliminar = "DELETE FROM materias WHERE id = '$id'";
if ($result_buscar = mysql_query($sql_buscar)) {

    $A = mysql_fetch_array($result_buscar);
    $nombre = $A["materia"];
    $seccion = $A["seccion"];
    $especialidad = $A["especialidad"];
    $semestre = $A["semestre"];

    // Datos de actualizacion para el log
    $descripcion = "Actualización de la tabla Materias (Eliminación del registro en la base de datos)";
    $cambios = "Campos eliminados: materia=" . $nombre . ", seccion=" . $seccion . ", especialidad=" . $especialidad . ", semestre=" . $semestre;
    $fecha = date("D d-m-Y h:i:s A");
    $updated_by = $_SESSION["usuario"];
    
    // Consulta SQL
    $sql_log = "INSERT INTO logs VALUES(NULL,'$descripcion','$cambios','$fecha','$updated_by')";

    if (@mysql_query($sql_eliminar)) {
        if (@mysql_query($sql_log)) {
            header("Location: materias.php?deleted=yes&log=yes");
        }
        header("Location: materias.php?deleted=yes&log=no");
    }
}
?>

