<?php

// Actualizacion de Materias *****************

session_start();


// Datos de actualizacion para la materia
$id_materia = $_POST["materia"];
$nombre = $_POST["nombre"];
$seccion = $_POST["seccion"];
$especialidad = $_POST["escuelas"];
$semestre = $_POST["semestre"];
$created_by = $_POST["created_by"];


// Datos de actualizacion para el log
$descripcion = "Actualización de la tabla Materias (Modificacion de los campos)";
$cambios = "Campos insertados: materia=" . $nombre . ", seccion=" . $seccion . ", especialidad=" . $especialidad . ", semestre=" . $semestre;
$fecha = $_POST["fecha"];
$updated_by = $_SESSION["usuario"];

//Abrir Conexion
include '../../conex.php';
//Consulta SQL
$sql_materia = "UPDATE materias 
                SET materia='$nombre', seccion='$seccion', especialidad='$especialidad', semestre='$semestre'
                WHERE id='$id_materia';";

$sql_log = "INSERT INTO logs VALUES(NULL,'$descripcion','$cambios','$fecha','$updated_by')";

if ($result_materia = @mysql_query($sql_materia)) {

    if ($result_log = @mysql_query($sql_log)) {
        header("Location: materias.php?saved=yes");
    } else {
        $log = "Materia Agregado correctamente en la base de datos";
        header("Location: index.php?log=no");
    }
} else {
//    header("Location: nuevo_materia.php?id=" . $id . "&saved=no");
    $log = "Error inesperado en la insercion de la Materia en la base de datos";
    header("Location: materias.php?saved=no");
}
//echo $log;
@mysql_close($conexion); // Close db
?>