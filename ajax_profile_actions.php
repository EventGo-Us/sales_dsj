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
$data = json_encode(['program' => "ajax_profile_actions"]);
$Traducciones = json_decode(API($jwt,$api_url,$data,'GET'), true);


// Middleware de autenticación básico
if (!isset($_SESSION['customer_id']) || !isset($_SESSION['logged_in'])) {
    echo json_encode(['success' => false, 'message' => Trd(1)]);
    exit;
}

$customerId = $_SESSION['customer_id'];
$action = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : '';

//if (!isset($pdo) && isset($db)) { $pdo = $db; }

try {
    switch ($action) {
        
        case 'get_profile':
            //$stmt = $pdo->prepare("SELECT firstname, lastname, email, phone FROM customers WHERE id = :id LIMIT 1");
            //$stmt->execute([':id' => $customerId]);
            //$user = $stmt->fetch(PDO::FETCH_ASSOC);
            $user['customer_id']  = $_SESSION['customer_id'];
            $user['firstname']  = $_SESSION['customer_name'];
            $user['lastname']   = $_SESSION['customer_last'];
            $user['email']      = $_SESSION['customer_email'];
            $user['phone']      =$_SESSION['customer_phone'];
            echo json_encode(['success' => true, 'data' => $user]);
            break;

        case 'update_profile':
            $firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
            $lastname  = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
            $phone     = isset($_POST['phone']) ? preg_replace('/\s+/', '', $_POST['phone']) : '';

            if(empty($firstname) || empty($lastname) || empty($phone)) {
                echo json_encode(['success' => false, 'message' => Trd(2)]);
                exit;
            }

            $api_url = URL_API."update_profile";
            $data = json_encode(["customerId" => $customerId, "firstname" => $firstname ,"lastname" => $lastname ,"phone" => $phone ]);
            $data = json_decode(API($jwt,$api_url,$data,'POST'), true);              

            // Actualizar variables globales vigentes de sesión
            $_SESSION['customer_name'] = $firstname;
            $_SESSION['customer_last'] = $lastname;
            $_SESSION['customer_phone'] = $phone;
            echo json_encode(['success' => true, 'message' => Trd(3)]);
            break;

        case 'get_orders':
            $type = isset($_GET['type']) ? trim($_GET['type']) : 'process';

            $api_url = URL_API."get_orders";

            //echo $api_url = URL_API."get_orders";
            $data = json_encode(["customerId" => $customerId, "type" => $type ]);
            $data = json_decode(API($jwt,$api_url,$data,'POST'), true);                          

            $orders = $data['data'];            
            echo json_encode(['success' => true, 'data' => $orders]);
            break;

        case 'get_addresses':

            $api_url = URL_API."get_addresses";
            $data = json_encode(["customerId" => $customerId ]);
            $data = json_decode(API($jwt,$api_url,$data,'POST'), true);
            echo json_encode([
                'success' => true, 
                'data' => $data['data'],
                'customer_name' =>  $_SESSION['customer_name'] . ' ' . $_SESSION['customer_last']
            ]);
            break;

        case 'create_address':
        case 'update_address':
            $alias   = isset($_POST['alias']) ? trim($_POST['alias']) : '';
            $country   = isset($_POST['country']) ? trim($_POST['country']) : '';
            $state   = isset($_POST['state']) ? trim($_POST['state']) : '';
            $city    = isset($_POST['city']) ? trim($_POST['city']) : '';
            $street  = isset($_POST['street']) ? trim($_POST['street']) : '';
            $colonia = isset($_POST['colonia']) ? trim($_POST['colonia']) : '';
            $zip     = isset($_POST['zip']) ? trim($_POST['zip']) : '';
            $refs    = isset($_POST['references']) ? trim($_POST['references']) : '';
            $addrId  = isset($_POST['address_id']) ? (int)$_POST['address_id'] : 0;

            if(empty($alias) || empty($state) || empty($city) || empty($street) || empty($colonia) || empty($zip)) {
                echo json_encode(['success' => false, 'message' => Trd(4)]);
                exit;
            }

            $api_url = URL_API."create_address";
            $data = json_encode(["customerId" => $customerId,"action" => $action ,"alias" => $alias ,"country" => $country, "state" => $state ,"city" => $city,"street" => $street ,"colonia" => $colonia ,"zip" => $zip ,"refs" => $refs ,"addrId" => $addrId  ]);
            $data = json_decode(API($jwt,$api_url,$data,'POST'), true);                 

            echo json_encode(['success' => true, 'message' => $data['message']]);
            break;

        case 'delete_address':
            $addrId = isset($_POST['address_id']) ? (int)$_POST['address_id'] : 0;

            $api_url = URL_API."delete_address";
            $data = json_encode(["customerId" => $customerId,"addrId" => $addrId  ]);
            $data = json_decode(API($jwt,$api_url,$data,'POST'), true);                

            echo json_encode(['success' => true, 'message' => Trd(5)]);
            break;

        default:
            echo json_encode(['success' => false, 'message' => Trd(6)]);
            break;
    }

} catch (PDOException $e) {
    error_log("Error crítico en modulo Perfil/PDO: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => Trd(7)]);
}
