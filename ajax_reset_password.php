<?php
ob_start();
session_start();
//echo $_SESSION['Idioma']."**";
require 'vendor/autoload.php';
require_once 'config.php';
require_once 'functions.php';

// Encabezado para responder estrictamente en formato JSON
header('Content-Type: application/json; charset=utf-8');

$api_url = URL_API."Traducciones_web_sales";
$data = json_encode(['program' => "ajax_reset_password"]);
$Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => Trd(1)]);
    exit;
}

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$token = isset($_POST['token']) ? htmlspecialchars($_POST['token'], ENT_QUOTES, 'UTF-8') : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';

// 1. Validaciones básicas
if (!$email || empty($token)) {
    echo json_encode(['success' => false, 'message' => Trd(2)]);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode(['success' => false, 'message' => Trd(3)]);
    exit;
}

if ($password !== $password_confirm) {
    echo json_encode(['success' => false, 'message' => Trd(4)]);
    exit;
}

try {

    $api_url = URL_API."password_resets";
    $data = json_encode(["email" => $email,"token" => $token,"password" => $password]);
    $data = json_decode(API($jwt,$api_url,$data,'POST'), true);   
    //print_r($data);
    if ($data['success']){
        echo json_encode([
            'success' => true, 
            'message' => $data['message']
        ]);
    }
    else{
        echo json_encode([
            'success' => false, 
            'message' => $data['message']
        ]);
    }


} catch (Exception $e) {
    // Si algo falla, revertimos los cambios pendientes
    
    echo json_encode([
        'success' => false, 
        'message' => Trd(5)
    ]);
}
