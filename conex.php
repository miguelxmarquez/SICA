<?php

/**
 * Conexion al Servidor de Base de Datos
 * (BaseDatos, Servidor, Usuario, Contraseña)
 */

require_once 'includes/funciones.php';
$connection = new MySQL();
$connection->conectar('sica','localhost','root','1234');

?>