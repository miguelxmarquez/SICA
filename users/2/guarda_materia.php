<?php

// Registro de Usuarios
$nombre = $_POST["nombre"];
$seccion = $_POST["seccion"];
$especialidad = $_POST["especialidad"];
$semestre = $_POST["semestre"];
$created_by = $_POST["created_by"];


//Abrir Conexion
include '../../conex.php';
//Consulta SQL
$sql = "INSERT INTO materias VALUES('','$nombre','$seccion','$especialidad','$semestre','$created_by')";

if ($agregar = @mysql_query($sql)) { // Execute
    $log = "Materia Agregado correctamente en la base de datos";
    header("Location: materias.php?saved=yes");
} else {
    header("Location: nuevo_materia.php?nombre=" . $nombre . "&saved=no");
    $log = "Error inesperado en la insercion de la Materia en la base de datos";
    header("Location: materias.php?saved=no");
}
//echo $log;
@mysql_close($conexion); // Close db
?>




