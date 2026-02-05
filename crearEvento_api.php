<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

require_once "crearEvento.php";

// 🔐 Comprobar que el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario no autenticado'
    ]);
    exit;
}

// (Opcional pero recomendado) Solo ADMIN
if ($_SESSION['role'] !== 'ADMIN') {
    echo json_encode([
        'success' => false,
        'message' => 'No autorizado'
    ]);
    exit;
}

// --------------------
// OBTENER DATOS DEL FORMULARIO
// --------------------
$titulo      = $_POST['titulo'] ?? null;
$tipo        = $_POST['tipo'] ?? null;
$fecha       = $_POST['fecha'] ?? null;
$hora        = $_POST['hora'] ?? null;
$plazas      = $_POST['plazas'] ?? null;
$descripcion = $_POST['descripcion'] ?? null;
$imagenFile  = $_FILES['imagen'] ?? null;

// 🔐 Datos desde la sesión
$createdby = $_SESSION['user_id'];
$createdat = date('Y-m-d H:i:s');

// --------------------
// VALIDACIONES
// --------------------
if (!$titulo || !$tipo || !$fecha || !$hora || !$plazas) {
    echo json_encode([
        'success' => false,
        'message' => 'Faltan campos obligatorios'
    ]);
    exit;
}

// --------------------
// SUBIDA DE IMAGEN
// --------------------
$imagenRuta = null;

if ($imagenFile && $imagenFile['error'] === UPLOAD_ERR_OK) {
    $dir = __DIR__ . '/img/eventos'; // Ajusta la ruta según tu proyecto

    if (!file_exists($dir)) {
        mkdir($dir, 0755, true); // crea la carpeta si no existe
    }

    // Validar MIME real
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $imagenFile['tmp_name']);
    $permitidos = ['image/jpeg','image/png','image/webp','image/gif'];

    if (!in_array($mime, $permitidos)) {
        echo json_encode([
            'success' => false,
            'message' => 'Tipo de imagen no permitido'
        ]);
        exit;
    }

    $ext = pathinfo($imagenFile['name'], PATHINFO_EXTENSION);
    $nuevoNombre = bin2hex(random_bytes(8)) . "." . $ext;
    $destino = $dir . '/' . $nuevoNombre;

    if (!move_uploaded_file($imagenFile['tmp_name'], $destino)) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al guardar la imagen'
        ]);
        exit;
    }

    $imagenRuta = $nuevoNombre; // ruta relativa para usar en BD o mostrar
}
// --------------------
// CREAR EVENTO
// --------------------
$resultado = crearEvento(
    $titulo,
    $tipo,
    $fecha,
    $hora,
    $plazas,
    $imagenRuta,  // pasa la ruta final de la imagen
    $descripcion,
    $createdby,
    $createdat
);

// --------------------
// RESPUESTA
// --------------------
if ($resultado) {
    echo json_encode([
        'success' => true,
        'message' => 'Evento creado correctamente',
        'imagen'  => $imagenRuta // opcional, útil para mostrar en Vue
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al crear el evento'
    ]);
}

exit;

?>

