<?php

$created_by = $_POST["id_usuario"];

// Registro de Usuarios
$ci = trim($_POST["ci"]);
$nombre = strtoupper($_POST["nombre"]);
$apellido = strtoupper($_POST["apellido"]);
$fecha_n = strtoupper($_POST["fecha_n"]);
$sexo = $_POST["sexo"];
$edo_n = $_POST["edo_n"];
$g_inst = (strtoupper($_POST["g_inst"]));
$dir = strtoupper($_POST["dir"]);
$email = mb_strtolower($_POST["email"]);
$foto = 0;
$escuela = $_POST["escuela"];
$activo = 1;
$created_by = $_POST["created_by"];

include '../../conex.php';

$sql_valida = "SELECT * FROM personas WHERE ci ='$ci';";
$md5 = md5($ci);

if ($result = @mysql_query($sql_valida)) {

    if (@mysql_num_rows($result) == 0) {
        $sql = "INSERT INTO personas 
        VALUES('','$ci','$md5','$nombre','$apellido','$fecha_n','$sexo','$edo_n','$g_inst','$dir','$email','$escuela','$foto','$activo','$created_by')";
    }else{
        header("Location: index.php?id=existe");
    }
} 
//Abrir Conexion
//Consulta SQL
if ($agregar = @mysql_query($sql)) { // Execute
    $log = "Usuario Agregado correctamente en la base de datos";
    header("Location: tomar.php?id=".$ci);
} else {
    $log = "Error inesperado en la insercion del Usuario en la base de datos";
    header("Location: index.php?id=no");
}
//echo $log;
@mysql_close($conexion); // Close db
?>




