<?php
session_start();

// Generate a random 4-digit CAPTCHA code
$captchaCode = rand(1000, 9999);

// Store the CAPTCHA code in the session
$_SESSION['captcha_code'] = $captchaCode;

// Create a simple image displaying the code
$image = imagecreate(100, 40);
$bgColor = imagecolorallocate($image, 255, 255, 255);
$textColor = imagecolorallocate($image, 142, 142, 142);
imagestring($image, 5, 15, 12, $captchaCode, $textColor);
header("Content-type: image/png");
imagepng($image);
imagedestroy($image);
?>
