<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");


require_once "usuarios.php";


$username   = $_POST['username']   ?? null;
$password  = $_POST['password']  ?? null;



$users = login($username, $password);
//$users = json_decode($usersJson, true); 
//var_dump($users);
if (isset($users)) {

    $_SESSION['user_id']   = $users['id'];
    $_SESSION['username']  = $users['username'];
    $_SESSION['role']      = $users['role'];   
    $_SESSION['logged_in'] = true;
 

    echo json_encode([
        'success' => true,
        'session' => $_SESSION 
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario o contraseña incorrectos'
    ]);
}
?>
