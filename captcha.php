<?php
session_start();

$length = 4;
$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
$code = '';

for ($i = 0; $i < $length; $i++) {
    $code .= $chars[mt_rand(0, strlen($chars) - 1)];
}

$_SESSION['captcha'] = $code;

$width = 100;
$height = 40;

$image = imagecreatetruecolor($width, $height);
$bgColor = imagecolorallocate($image, 255, 255, 255);
$textColor = imagecolorallocate($image, 0, 0, 0);

imagefilledrectangle($image, 0, 0, $width - 1, $height - 1, $bgColor);

$font = 'font/captcha.ttf';
$fontSize = 16;
$x = ($width - $fontSize * $length) / 2;
$y = ($height - $fontSize) / 2 + $fontSize;

for ($i = 0; $i < $length; $i++) {
    $angle = mt_rand(-15, 15);
    imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $font, $code[$i]);
    $x += $fontSize + 5;
}

header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
?>