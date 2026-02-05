<?php
$dir = __DIR__ . '/img'; // carpeta donde subes imágenes

echo "<h2>Test de permisos de subida</h2>";

if (!file_exists($dir)) {
    die("❌ La carpeta 'img' no existe");
}

if (is_writable($dir)) {
    echo "✅ La carpeta img ES escribible<br><br>";
} else {
    echo "❌ La carpeta img NO es escribible<br><br>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['imagen'])) {
        die("No se envió ningún archivo");
    }

    $file = $_FILES['imagen'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Error en la subida: " . $file['error']);
    }

    // Verificar que sea imagen real
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);

    $permitidos = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

    if (!in_array($mime, $permitidos)) {
        die("❌ El archivo no es una imagen válida ($mime)");
    }

    // Nombre aleatorio seguro
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $nuevoNombre = bin2hex(random_bytes(8)) . "." . $ext;

    $destino = $dir . '/' . $nuevoNombre;

    if (move_uploaded_file($file['tmp_name'], $destino)) {
        echo "✅ Imagen subida correctamente<br>";
        echo "Ruta: img/$nuevoNombre<br>";
        echo "<img src='img/$nuevoNombre' style='max-width:300px;margin-top:10px;'>";
    } else {
        echo "❌ No se pudo mover el archivo a la carpeta img";
    }
}
?>
