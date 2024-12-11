<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// Set header untuk tipe konten gambar
header('Content-Type: image/png');

// Buat gambar kosong
$width = 100;
$height = 40;
$image = imagecreate($width, $height);

// Warna latar belakang dan teks
$background_color = imagecolorallocate($image, 255, 255, 255); // Putih
$text_color = imagecolorallocate($image, 0, 0, 0); // Hitam

// Buat string CAPTCHA acak
$captcha_code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 5);
$_SESSION['captcha_code'] = $captcha_code;

// Tambahkan teks CAPTCHA ke gambar
imagestring($image, 5, 10, 10, $captcha_code, $text_color);

// Tampilkan gambar
imagepng($image);
imagedestroy($image);
?>