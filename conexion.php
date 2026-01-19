<?php

function conexionBBDD(){
    define('SERVIDOR', 'localhost');
    define('BBDD', 'gamefest');
    define('USUARIO', 'root');
    define('CLAVE', '');

    $mysqli = new mysqli(SERVIDOR, USUARIO, CLAVE, BBDD);

    $mysqli->set_charset('utf8');

    $sql= "SELECT * FROM user_events";
    $resultado = $mysqli->query($sql);

     print "<table>\n";
    while($fila = $resultado->fetch_assoc()){
        print "<tr>\n";
        print "<td>$fila[user_id]</td>\n";
        print "<td>$fila[event_id]</td>\n";
        print "<td>$fila[created_at]</td>\n";

        print "</tr>\n";
    }
    print "</table>\n";
    $resultado->free();
    $mysqli->close();
}

conexionBBDD();


?>
