<?php

// Registro de Usuarios
$id = $_POST["id_persona"];
$ci = $_POST["ci"];

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$g_inst = $_POST["g_inst"];
$dir = $_POST["direccion"];
$email = $_POST["email"];
$activo = $_POST["activo"];
$escuela = $_POST["escuela"];

//echo $nombre." ".$apellido." ".$g_inst." ".$dir." ".$email;

//Abrir Conexion
include '../../conex.php';
//Consulta SQL
$sql_profesor = "UPDATE personas 
                 SET nombre='$nombre', apellido='$apellido', g_inst='$g_inst', direccion='$dir',  email='$email', escuela='$escuela', activo='$activo'        
                 WHERE id=$id";

if (@$agregar = @mysql_query($sql_profesor)) { // Execute
    $log = "Registro Actualizado correctamente en la base de datos";
    header("Location: registro.php?id=".$id."&ci=".$ci."&saved=yes");
} else {
    $log = "Error inesperado en la insercion del registro en la base de datos";
    header("Location: registro.php?id=".$id."&saved=no");
}
//echo $log;
@mysql_close($conexion); // Close db
?>

