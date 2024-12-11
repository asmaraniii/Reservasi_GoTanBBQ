<?php
session_start(); // Mulai sesi

// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pbo";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek apakah form dikirim menggunakan metode POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil data dari form
    $tempat = isset($_POST['place']) ? $conn->real_escape_string($_POST['place']) : '';
    $waktu = isset($_POST['booking_time']) ? $conn->real_escape_string($_POST['booking_time']) : '';
    $jumlah = isset($_POST['people_count']) ? intval($_POST['people_count']) : 0;
    $nama_lengkap = isset($_POST['full_name']) ? $conn->real_escape_string($_POST['full_name']) : '';
    $no_hp = isset($_POST['phone_number']) ? $conn->real_escape_string($_POST['phone_number']) : '';
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
    $notes = isset($_POST['notes']) ? $conn->real_escape_string($_POST['notes']) : '';

    // Validasi apakah semua field wajib sudah diisi
    if (empty($tempat) || empty($waktu) || empty($jumlah) || empty($nama_lengkap) || empty($no_hp) || empty($email)) {
        die("Error: All fields are required.");
    }

    // Query SQL untuk menyimpan data
    $sql = "INSERT INTO reservations (place, booking_time, people_count, full_name, phone_number, email, notes)
            VALUES ('$tempat', '$waktu', $jumlah, '$nama_lengkap', '$no_hp', '$email', '$notes')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = "Reservation successful!";
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
    }

    $conn->close();

    // Redirect kembali ke booking.php
    header("Location: bukti_reservasi.php");
    exit;
}
?>
