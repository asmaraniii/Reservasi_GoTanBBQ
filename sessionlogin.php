<?php
include('connection.php');

// Ambil data dari form
$usern = $_POST['usern'];
$password = md5($_POST['password']); // Enkripsi password

// Query untuk memeriksa username dan password
$select = "SELECT * FROM register WHERE username = '$usern' AND password = '$password'";
$query = mysqli_query($conn, $select);
$row = mysqli_fetch_array($query);

// Validasi input kosong
if (empty($usern) || empty($password)) {
    echo "<script>
            window.alert('Silakan membuat akun terlebih dahulu.');
            window.location.href='register.php';
          </script>";
} else if ($row) {
    // Jika username dan password cocok
    session_start();
    $_SESSION['username'] = $row['username'];
    $_SESSION['role_user'] = $row['role_user']; // Simpan role user

    if ($row['role_user'] == 'admin') {
        // Jika role adalah admin
        echo "<script>
                window.alert('Selamat Datang Admin ".strtoupper($usern)."');
                window.location.href='dashboard.php';
              </script>";
    } else if ($row['role_user'] == 'user') {
        // Jika role adalah user
        echo "<script>
                window.alert('Selamat Datang User ".strtoupper($usern)."');
                window.location.href='index.php';
              </script>";
    } else {
        // Role tidak valid
        echo "<script>
                window.alert('Role tidak valid!');
                window.location.href='login.php';
              </script>";
    }
} else {
    // Jika login gagal
    echo "<script>
            window.alert('Anda gagal login!');
            window.location.href='login.php';
          </script>";
}
?>