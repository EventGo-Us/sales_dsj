<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

ob_start();
session_start(); 

// Permitir cualquier origen (puedes cambiar el * por tu dominio específico si estás en producción)


// Si el navegador hace una petición de pre-vuelo (OPTIONS), terminamos el script aquí
//if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
//    exit(0);
//}

if (isset($_POST['lang'])) {
    $nuevo_idioma = $_POST['lang'];
    if (in_array($nuevo_idioma, ['es', 'en'])) {
        $_SESSION['Idioma'] = $nuevo_idioma;
        //echo $_SESSION['Idioma'];
        echo json_encode(['status' => 'success']);
        exit;
    }
}
echo json_encode(['status' => 'error']);
?>