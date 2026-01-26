
<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "usuarios.php";


$data = json_decode(file_get_contents('php://input'), true);





?>