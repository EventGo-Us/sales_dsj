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
$data = json_encode(['program' => "api_recover"]);
$Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => Trd(1)]);
    exit;
}

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if (!$email) {
    echo json_encode(['status' => 'error', 'message' => Trd(2)]);
    exit;
}

try {
    $api_url = URL_API."password_recover";
    $data = json_encode(["email" => $email ]);
    $data = json_decode(API($jwt,$api_url,$data,'POST'), true);  
    //echo $api_url = URL_API."password_recover";
    echo json_encode(['status' => $data['status'], 'message' => $data['message']]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => Trd(3) . $e->getMessage()]);
}