<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>


        <?php
        require '../../conex.php';

        echo strtotime($currentDateTime = '18:45:00');
        echo " ". strtotime($newDateTime = date('h:i A', strtotime($currentDateTime)));

        $sql_horario = "SELECT h.id as id_horario, p.id as id_profesor, p.nombre, p.apellido, m.materia, h.1ini, h.1fin
                        FROM horarios as h, personas as p, materias as m
                        WHERE h.id_profesor = p.id
                        AND h.materia = m.id
                        ORDER BY p.id";
        $result_horario = @mysql_query($sql_horario);
        $h_asignadas = 0;
        $h_asignadas = 0;
        echo "<table>
            <thead>
            <tr>
                <th>Id</th>
                <th>Apellido</th>
                <th>Nombre</th>
                <th>Materia</th>
                <th>H. Diurnas </th>
                <th>H. Nocturnas </th>
                <th>Horas Asignadas</th>
            </tr>
            </thead>";
        while ($row = @mysql_fetch_array($result_horario)) {
            $h_entrada = strtotime($row["1ini"]);
            $h_salida = strtotime($row["1fin"]);
            $h_nocturna = strtotime("06:45 PM");
            $h_diurna = strtotime("07:00 AM");
            $h_asignadas = (($h_salida - $h_entrada) / 60) / 45;

            $h_diurna_t = 0;
            $h_nocturna_t = 0;


            $id_profesor = $row["id_profesor"];
            $id_aux = $id_profesor;



            if (($h_entrada >= $h_diurna) && ($h_salida <= $h_nocturna)) {
                $h_diurna_t = $h_diurna_t + $h_asignadas;
            } else {
                $h_nocturna_t = $h_nocturna_t + $h_asignadas;
            }

            $acum_h += $h_asignadas;

            echo "<tr>";
            echo "<td>"
            . $row["id_horario"]
            . " </td><td> "
            . $row["apellido"] . "</td><td>"
            . $row["nombre"] . "</td><td>"
            . $row["materia"] . "</td><td>"
            . $h_diurna_t . "</td><td>"
            . $h_nocturna_t . "</td><td>"
            . $h_asignadas . " </td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </body>
</html>
