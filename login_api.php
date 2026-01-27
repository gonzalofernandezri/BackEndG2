<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");


require_once "usuarios.php";


$username   = $_GET['username']   ?? null;
$password  = $_GET['password']  ?? null;


// Llamamos a login
$usersJson = login($username, $password);
$users = json_decode($usersJson, true); // convertimos a array
//var_dump($users);
if (count($users) > 0) {
    // Guardamos datos en la sesión
    $_SESSION['user_id']   = $users['id'];
    $_SESSION['username']  = $users['username'];
    $_SESSION['role']      = $users['role'];   // <-- admin o user
    $_SESSION['logged_in'] = true;


    // Devolvemos JSON indicando éxito con ID y rol
    echo json_encode([
        'success' => true,
        'user_id' => $users['id'],
        'username' => $users['username'],
        'role' => $users['role']  // <-- pasamos el rol al frontend
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario o contraseña incorrectos'
    ]);
}
?>
