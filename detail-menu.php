<?php
// Mulai sesi
session_start();

// Database connection parameters
$host = 'localhost';
$db_name = 'pbo';
$username = 'root';
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Logika Logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Menangani Form Submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_menu = $_POST['menu'];
    $harga = $_POST['harga'];
    $tipe_menu = $_POST['tipe'];
    $gambar = $_FILES['image']['name']; // Mengambil nama file gambar yang diupload
    $target_dir = "uploads/"; // Folder tempat gambar akan disimpan
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Proses upload gambar
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Masukkan data ke database
        $sql = "INSERT INTO menu (nama_menu, harga, tipe_menu, gambar) VALUES (:nama_menu, :harga, :tipe_menu, :gambar)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nama_menu', $nama_menu);
        $stmt->bindParam(':harga', $harga);
        $stmt->bindParam(':tipe_menu', $tipe_menu);
        $stmt->bindParam(':gambar', $gambar);
        $stmt->execute();

        // Redirect ke halaman menu.php setelah data disimpan
        header("Location: menu.php");
        exit();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        .sidebar img {
            width: 80%;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .sidebar .role {
            margin-top: 15px;
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            text-align: center;
        }

        .sidebar a {
            width: 100%;
            color: #007bff;
            text-decoration: none;
            margin: 10px 0;
            padding: 12px 20px;
            text-align: left;
            border-radius: 5px;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        /* Header Styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header .profile {
            display: flex;
            align-items: center;
        }

        .header .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-left: 10px;
            cursor: pointer;
        }

        /* Content Styles */
        .content {
            flex: 1;
            padding: 20px;
        }

        .content h2 {
            font-size: 24px;
            color: #1a3e5e;
            margin-bottom: 20px;
        }

        .content form {
            padding: 20px;
            border: 2px solid #007bff;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 550px;
            margin: 0 auto;
        }

        .content form label {
            font-size: 16px;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
        }

        .content form input[type="text"], 
        .content form input[type="file"], 
        .content form select {
            padding: 10px; /* Ruang di dalam input */
            font-size: 16px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box; /* Agar padding tidak mengubah ukuran lebar elemen */
            transition: all 0.3s ease;
        }

        .content form input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Image Upload Styles */
        .image-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 30px;
        }

        .image-upload img {
            width: 350px;
            height: 230px;
            background-color: #ccc;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .image-upload label {
            padding: 12px 25px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .image-upload label:hover {
            background-color: #218838;
        }

        /* Save Button Styles */
        .save-button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .save-button {
            padding: 15px 30px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .save-button:hover {
            background-color: #218838;
        }

        .save-button:active {
            background-color: #1e7e34;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="img/LOGO_GoTan.png" alt="GoTan Logo">
        <p class="role">Admin</p>
        <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="menu.php" class="active"><i class="fas fa-utensils"></i> Menu</a>
        <a href="rekap.php"><i class="fas fa-file-alt"></i> Rekap</a>
        <a href="login.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
    </div>

    <div class="content">
        <div class="header">
            <h2>DETAIL MENU</h2>
            <div class="profile">
                <img src="https://via.placeholder.com/40" alt="Admin Profile">
                <span class="profile-name">Admin Name</span>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data">
            <label for="menu">Nama Menu</label>
            <input type="text" id="menu" name="menu" placeholder="Masukkan menu" required>

            <label for="harga">Harga</label>
            <input type="text" id="harga" name="harga" placeholder="Masukkan harga" required>

            <label for="tipe">Tipe Menu</label>
            <select id="tipe" name="tipe" required>
                <option value="makanan">Makanan</option>
                <option value="minuman">Minuman</option>
            </select>

            <label for="image">Gambar Menu</label>
            <input type="file" id="image" name="image" required>

            <div class="save-button-container">
                <button type="submit" class="save-button">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>
