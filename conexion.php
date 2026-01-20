<?php


function conexionBBDD() {

$nombreServidor = "localhost";
$nombreUser = "root";
$contraseña = "";
$nombreBD = "gamefest";


$conexion = mysqli_connect($nombreServidor, $nombreUser, $contraseña, $nombreBD )
or die("Ha ocurrido un error a la hora de conectar con la bbdd");

// $datos = json_decode($json, true);

// foreach ($datos as $row) {
//     myslqi_query($conexion,"INSERT INTO usuarios (document, firstName, lastName, gender, email, phone, productPurchasedTag) 
//     VALUES ('".$row['document']."',".$row['firstName'].",'".$row['lastName']."','".$row['gender']."','".$row['email']."',".$row['phone']."',".$row['productPurchasedTag'].")");
// }

return $conexion;

}

function cerrarConexion($conexion) {

 mysqli_close($conexion);

}


?>
