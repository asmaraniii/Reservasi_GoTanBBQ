<?php
// Menghubungkan ke database
// Database connection parameters
$host = 'localhost';
$db_name = 'pbo';
$username = 'root';
$password = "";

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $db_name);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
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
            margin-bottom: 10px;
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
        .content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 36px;
            color: #003366;
        }
        .header .search-filter {
            display: flex;
            align-items: center;
        }
        .header .search-filter input {
            padding: 5px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .header .search-filter select {
            padding: 5px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .header .search-filter button {
            padding: 5px 10px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        /* Tombol Tambah */
        .btn-tambah {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            margin-left: 10px;
            transition: background-color 0.3s ease;
        }

        .btn-tambah:hover {
            background-color: #0056b3;
            cursor: pointer;
        }
        /* Tombol Update */
        .btn-update {
            padding: 5px 10px;
            background-color: #b22222;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .btn-update:hover {
            background-color: #e0a800;
            cursor: pointer;
        }

        /* Admin Profile Styles */
        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-name {
            font-size: 16px;
            font-weight: 700;
        }

        .profile i {
            font-size: 16px;
        }
        .table-container {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f2f2f2;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
<div class="sidebar">
    <img src="img/LOGO_GoTan.png" alt="GoTan Logo">
    <p class="role">Admin</p>
    <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="menu.php" class="active"><i class="fas fa-utensils"></i> Menu</a>
    <a href="rekap.php"><i class="fas fa-file-alt"></i> Rekap</a>
    <a href="login.php"><i class="fas fa-sign-out-alt"></i>Log Out</a>
</div>

<div class="content">
    <div class="header">
        <h1>MENU</h1>
        <div class="profile">
            <img src="https://via.placeholder.com/40" alt="Admin Profile">
            <span class="profile-name">Admin Name</span>
        </div>
    </div>

    <div class="actions">
        <a href="detail-menu.php" class="btn-tambah">+ Tambah Menu</a>
    </div>

    <!-- Menambahkan margin bottom pada tabel agar tombol tidak mepet -->
    <div class="table-container" style="margin-top: 20px;">
        <table>
            <!-- Menambahkan kolom "Update" dalam tabel -->
        <thead>
            <tr>
                <th>Nama Menu</th>
                <th>Harga</th>
                <th>Tipe Menu</th>
                <th>Gambar</th>
                <th>Aksi</th> <!-- Kolom untuk tombol Update -->
            </tr>
        </thead>
        <tbody>
        <?php
                    // Mengambil data menu dari database
                    $sql = "SELECT * FROM menu";
                    $result = $conn->query($sql);

                    // Menampilkan data menu dalam tabel
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['nama_menu'] . "</td>";
                            echo "<td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
                            echo "<td>" . $row['tipe_menu'] . "</td>";
                            echo "<td><img src='uploads/" . $row['gambar'] . "' alt='Gambar Menu' width='50'></td>";
                            echo "<td><a href='detail-menu.php?id=" . $row['id_menu'] . "' class='btn-update'>Update</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data menu</td></tr>";
                    }

                    // Menutup koneksi
                    $conn->close();
                    ?>
        </tbody>
        </table>
    </div>
</div>
</body>
</html>
