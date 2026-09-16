<?php
// Clave secreta que DEBE ser exactamente la misma en ambos servidores
define('SHARED_KEY', 'TuClaveSecretaSuperSegura123!'); 

// 1. Generar código aleatorio
$chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
$captcha_code = '';
for ($i = 0; $i < 5; $i++) { $captcha_code .= $chars[rand(0, strlen($chars) - 1)]; }

// 2. Crear un token cifrado con el código y el tiempo de expiración (Ej: 3 minutos)
$payload = json_encode([
    'code' => strtoupper($captcha_code),
    'expires' => time() + 180 
]);

// Cifrado simple AES-128
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-cbc'));
$encrypted = openssl_encrypt($payload, 'aes-128-cbc', SHARED_KEY, 0, $iv);
// Combinamos IV y datos cifrados en Base64 para transportarlo fácil por HTTP
$captcha_token = base64_encode($iv . '::' . $encrypted);

// 3. Crear la imagen (Librería GD)
$width = 140; $height = 45;
$image = imagecreatetruecolor($width, $height);
$bg_color = imagecolorallocate($image, 245, 247, 250);
imagefill($image, 0, 0, $bg_color);

// Ruido de fondo
for ($i = 0; $i < 4; $i++) {
    $line_color = imagecolorallocate($image, rand(180, 220), rand(180, 220), rand(180, 220));
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $line_color);
}

// Dibujar caracteres
for ($i = 0; $i < strlen($captcha_code); $i++) {
    $text_color = imagecolorallocate($image, rand(20, 80), rand(20, 80), rand(20, 80));
    imagechar($image, 5, 15 + ($i * 24), rand(10, 20), $captcha_code[$i], $text_color);
}

imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);

// 4. Enviar cabeceras especiales para pasar el token al Front-end mediante AJAX/Fetch
header('X-Captcha-Token: ' . $captcha_token);
header('Content-Type: image/png');
header('Cache-Control: no-store, no-cache, must-revalidate');
imagepng($image);
imagedestroy($image);