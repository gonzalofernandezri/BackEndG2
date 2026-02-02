<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");


require_once "usuarios.php";


$username   = $_GET['username']   ?? null;
$password  = $_GET['password']  ?? null;



$usersJson = login($username, $password);
$users = json_decode($usersJson, true); 
//var_dump($users);
if (count($users) > 0) {

    session_regenerate_id(true);

    $_SESSION['user_id']   = $users['id'];
    $_SESSION['username']  = $users['username'];
    $_SESSION['role']      = $users['role'];   
    $_SESSION['logged_in'] = true;
 

    echo json_encode([
        'success' => true,
        'user_id' => $users['id'],
        'username' => $users['username'],
        'role' => $users['role'], 
        'session' => $_SESSION 
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario o contraseña incorrectos'
    ]);
}
?>
