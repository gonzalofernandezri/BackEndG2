<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "eventosUsuario.php";

$iduser = $_GET['iduser'] ?? null;

echo eventosUsuario($iduser);
exit;
?>