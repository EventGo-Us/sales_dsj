<?php
ob_start();
session_start();
//echo $_SESSION['Idioma']."**";
require 'vendor/autoload.php';
require_once 'config.php';
require_once 'functions.php';

// Encabezado para responder estrictamente en formato JSON
header('Content-Type: application/json; charset=utf-8');


// Recibir y limpiar credenciales
$loginUser = isset($_POST['loginUser']) ? trim($_POST['loginUser']) : '';
$loginPass = isset($_POST['loginPass']) ? $_POST['loginPass'] : '';

if (empty($loginUser) || empty($loginPass)) {
    echo json_encode(['success' => false, 'message' => 'Por favor introduce tu usuario y contraseña.']);
    exit;
}

    $api_url = URL_API."sales_customer_login";
    $data = json_encode(["loginUser" => $loginUser ,"loginPass" => $loginPass ]);
    $data = json_decode(API($jwt,$api_url,$data,'POST'), true);  

    //print_r($data);

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