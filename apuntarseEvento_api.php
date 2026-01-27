<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "usuarios.php";
$user_id   = $_GET['user_id'] ?? null;
$evento_id = $_GET['evento_id'] ?? null;
$fecha     = $_GET['fecha'] ?? null;


apuntarseEvento($user_id,$evento_id,$fecha);

?>