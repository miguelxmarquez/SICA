<?php

//Abro la base de datos
include 'conex.php';
//primero tengo que ver si el usuario está memorizado en una cookie
if ($_SESSION["id_sesion"] != session_id()) {

    if (isset($_COOKIE["id_usuario"]) && isset($_COOKIE["id_session"])) {
        //Tengo cookies memorizadas
        //además voy a comprobar que esas variables no estén vacías
        if (($_COOKIE["id_usuario"] != "") && ($_COOKIE["id_session"] != "")) {
            //Voy a ver si corresponden con algún usuario
            $sql = "SELECT * FROM usuarios WHERE id=" . $_COOKIE["id_usuario"] . " AND cookie='" . $_COOKIE["id_session"] . "' AND cookie <> '' ";
            $rs = mysql_query($sql);
            if (mysql_num_rows($rs) == "1") {
                // Creo un objeto con el resultado de la consulta sql
                $persona = mysql_fetch_object($rs);
                // inicio la sesión 
                session_start();
                //asigno un nombre a la sesión para poder guardar diferentes datos 
                session_name($persona->usuario);
                //defino la sesión que demuestra que el usuario está autorizado 
                $_SESSION["id_sesion"] = session_id();
                $_SESSION["id"] = $persona->id;
                $_SESSION["nombre"] = $persona->nombre;
                $_SESSION["apellido"] = $persona->apellido;
                $_SESSION["usuario"] = $persona->usuario;
                $_SESSION["ultimo_acceso"] = $persona->ultimo_acceso;
                $_SESSION["rol"] = $persona->rol;
                // Redirecciono a la app
                header("Location: index.php");
            }
            mysql_free_result($rs);
            mysql_close($conexion);
        } else {
            header("Location: /users/".$_SESSION["rol"].".php");
        }
    }
} else {
    header("Location: /users/".$_SESSION["rol"]);
}
?>