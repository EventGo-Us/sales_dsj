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
$data = json_encode(['program' => "ajax_register"]);
$Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);

$firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
$lastname  = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
$email     = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) : false;
$phone     = isset($_POST['phone']) ? preg_replace('/\s+/', '', $_POST['phone']) : '';
//$state     = isset($_POST['state']) ? trim($_POST['state']) : '';
$password  = isset($_POST['password']) ? $_POST['password'] : '';
$password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';

// 2. Validaciones estrictas del Backend
if (empty($firstname) || empty($lastname) || empty($phone) ||  empty($password)) {
    echo json_encode(['success' => false, 'message' => Trd(1)]);
    exit;
}

if (!$email) {
    echo json_encode(['success' => false, 'message' => Trd(2)]);
    exit;
}

if (strlen($phone) !== 10 || !ctype_digit($phone)) {
    echo json_encode(['success' => false, 'message' => Trd(3)]);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode(['success' => false, 'message' => Trd(4)]);
    exit;
}

if ($password !== $password_confirm) {
    echo json_encode(['success' => false, 'message' => Trd(5)]);
    exit;
}

$state = '';

$api_url = URL_API."sales_customer_register";
$data = json_encode(["firstname" => $firstname ,"lastname" => $lastname ,"email" => $email ,"phone" => $phone ,"state" => $state ,"password" => $password ,"password_confirm" => $password_confirm]);
$data = json_decode(API($jwt,$api_url,$data,'POST'), true);  


if ($data['success']){

    $_SESSION['customer_id']    = $data['sale_customer']['id'];
    $_SESSION['customer_name']  = $data['sale_customer']['firstname'];
    $_SESSION['customer_last']  = $data['sale_customer']['lastname'];
    $_SESSION['customer_email'] = $data['sale_customer']['email'];
    $_SESSION['customer_phone'] = $data['sale_customer']['phone'];
    $_SESSION['logged_in']      = true;

    // Respuesta exitosa para el Frontend
    echo json_encode([
        'success' => true,
        'message' => $data['message']
    ]);    

}
else{
    echo json_encode(['success' => false, 'message' => $data['message']]);
}
