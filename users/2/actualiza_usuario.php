<?php

// Registro de Usuarios

if ($_POST["pass"] == $_POST["repass"]) {

    // Datos por post
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $username = $_POST["username"];
    $pass = md5($_POST["pass"]);
    $email = $_POST["email"];
    $rol = $_POST["rol"];
    $estado = $_POST["estado"];
    $id = $_POST["id"];

//Abrir Conexion
    include '../../conex.php';
//Consulta SQL
    $sql = "UPDATE usuarios SET clave='$pass', nombre='$nombre', apellido='$apellido', email='$email', estado='$estado' WHERE id='$id'";

    if (@$agregar = @mysql_query($sql)) { // Execute
        $log = "Usuario Agregado correctamente en la base de datos";
        header("Location: usuarios.php?saved=yes");
    } else {
        $log = "Error inesperado en la insercion del Usuario en la base de datos";
//    header("Location: usuarios.php?saved=no");
    }
//echo $log;
    @mysql_close($conexion); // Close db
} else {
    $id = $_POST["id"];
    header("Location: edita_usuario.php?id=" . $id."&claves=no");
}
?>

