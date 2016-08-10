<?php

class MySQL {

    // Variables de Conexion
    var $Servidor;
    var $Usuario;
    var $Clave;
    var $BaseDatos;
    // Identificador de conexión y consulta
    var $Conexion_ID = 0;
    var $Consulta_ID = 0;
    // Número de error y Texto del error
    var $Errno = 0;
    var $Error = "";

    /**
     * Conecta a la Base de Datos
     */
    function conectar($basedatos, $servidor, $usuario, $clave) {

        $this->BaseDatos = $basedatos;
        $this->Usuario = $usuario;
        $this->Clave = $clave;
        $this->BaseDatos = $basedatos;

        $this->Conexion_ID = mysql_connect($this->Servidor, $this->Usuario, $this->Clave);

        if (!$this->Conexion_ID) {
            $this->Error = "No se ha podido conectar a " . $this->Servidor;
        }
        if (!mysql_select_db($this->BaseDatos, $this->Conexion_ID)) {
            $this->Error = "Imposible abrir " . $this->BaseDatos;
        }
        return $this->Conexion_ID;
    }

    /**
     *  Ejecuta consultas SQL
     */
    function consulta($sql = "") {

        if ($sql == "") {
            $this->Error = "No ha especificado una consulta SQL";
            return 0;
        }

        $this->Consulta_ID = mysql_query($sql, $this->Conexion_ID);

        if (!$this->Consulta_ID) {
            $this->Errno = mysql_errno();
            $this->Error = mysql_error();
        }

        return $this->Consulta_ID;
    }

    /**
     * Devuelve el número de campos de una consulta
     */
    function numcampos() {
        return mysql_num_fields($this->Consulta_ID);
    }

    /**
     * Devuelve el número de registros de una consulta
     */
    function numregistros() {
        return mysql_num_rows($this->Consulta_ID);
    }

    /**
     * Devuelve el nombre de un campo de una consulta
     */
    function nombrecampo($numcampo) {
        return mysql_field_name($this->Consulta_ID, $numcampo);
    }

    /**
     * Muestra los datos de una consulta
     */
    function verconsulta() {
        echo "<table width=\"100%\" border=\"1\" align=\"center\" cellpadding=\"2\" cellspacing=\"1\">\n\r";
        // mostramos los nombres de los campos
        echo "<tr valign=\"top\" class=\"head\">\n\r";
        for ($i = 0; $i < $this->numcampos(); $i++) {
            echo "<td>" . $this->nombrecampo($i) . "</td>\n";
        }
        echo "</tr>\n";
        // mostrarmos los registros
        while ($row = mysql_fetch_row($this->Consulta_ID)) {
            ($index % 2 == 0) ? $class = "bar1" : $class = "bar2";
            $index++;

            echo "<tr valign=\"top\" class=\"$class\">\n\r";
            for ($i = 0; $i < $this->numcampos(); $i++) {
                echo "<td>" . $row[$i] . "</td>\n\r";
            }
            echo "</tr>\n\r";
        }
        echo "</table>\n\r";
    }

}

function CalculaEdad($fecha) {
    list($d, $m, $Y) = explode("/", $fecha);
    return( date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y );
}

?>
