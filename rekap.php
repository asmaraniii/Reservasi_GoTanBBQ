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

// Ambil data dari tabel reservasiadmin dan reservations
$reservations = [];
try {
    $stmt = $conn->prepare("
        SELECT 
            booking_date, 
            booking_time, 
            number_of_people, 
            name, 
            phone, 
            email, 
            notes 
        FROM reservasiadmin 
        UNION ALL 
        SELECT 
            booking_time AS booking_date, 
            booking_time AS booking_time, 
            people_count AS number_of_people, 
            full_name AS name, 
            phone_number AS phone, 
            email AS email, 
            notes AS notes 
        FROM reservations
        ORDER BY booking_date, booking_time
    ");
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Gagal mengambil data: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rekap</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    /* General Body Styles */
      body {
          font-family: 'Roboto', sans-serif;
          margin: 0;
          padding: 0;
          background-color: #f5f5f5;
      }

      /* Sidebar Styles */
      .sidebar {
          width: 250px;
          background-color: white;
          position: fixed;
          height: 100%;
          box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
          padding: 20px;
          display: flex;
          flex-direction: column;
          align-items: center;
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

      .sidebar a:hover,
      .sidebar a.active {
          background-color: #e9ecef;
          font-weight: bold;
      }

      .sidebar a i {
          margin-right: 10px;
      }

      .sidebar h2 {
          text-align: center;
          color: #d9534f;
          font-size: 18px;
      }

      .sidebar h3 {
          text-align: center;
          color: #333;
          font-size: 16px;
          margin-top: 5px;
      }

      /* Profile in Top Right */
      .profile {
          position: absolute;
          top: 10px;
          right: 20px;
          display: flex;
          align-items: center;
          gap: 10px;
          cursor: pointer;
          background-color: #f5f5f5;
          padding: 10px;
      }

      .profile-name {
          font-size: 16px;
          font-weight: 700;
      }

      .profile i {
          font-size: 16px;
      }

      /* Content Styles */
      .content {
          flex: 1;
          margin-left: 290px;
          padding: 20px;
      }

      .content h1 {
          color: #1a3e6e;
          font-size: 36px;
      }

      /* Search Box Styles */
      .search-box {
          background-color: white;
          padding: 20px;
          border-radius: 10px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          margin-bottom: 20px;
      }

      .search-box p {
          color: #1a3e6e;
          font-size: 14px;
      }

      .search-box input,
      .search-box select,
      .search-box button {
          padding: 10px;
          margin: 10px 0;
          border: 1px solid #ccc;
          border-radius: 5px;
          width: calc(100% - 22px);
      }

      .search-box button {
          background-color: #007bff;
          color: white;
          border: none;
          cursor: pointer;
      }

      /* Table Styles */
      .table {
          width: 100%;
          border-collapse: collapse;
          background-color: white;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      .table th,
      .table td {
          padding: 10px;
          border: 1px solid #ccc;
          text-align: left;
      }

      .table th {
          background-color: #f5f5f5;
      }

      /* Pagination Styles */
      .pagination {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-top: 20px;
      }

      .pagination div {
          display: flex;
          align-items: center;
      }

      .pagination div span {
          margin: 0 5px;
      }

      .pagination div a {
          text-decoration: none;
          color: #007bff;
          margin: 0 5px;
      }

      .pagination div a:hover {
          text-decoration: underline;
      }

      /* Flexbox Styles for Search Inputs */
      .search-box div {
          display: flex;
          flex-wrap: wrap;
          gap: 10px;
          align-items: center;
          margin-top: 10px;
      }

      .search-box label {
          flex: 1;
          min-width: 50px;
          font-size: 14px;
      }

      .search-box input,
      .search-box button {
          flex: 1;
          min-width: 200px;
      }

      .search-box button {
          min-width: 100px;
      }

      /* Button Styling */
      button {
          padding: 10px 20px;
          background-color: #007bff;
          color: white;
          border: none;
          border-radius: 5px;
          cursor: pointer;
      }

      button:hover {
          background-color: #0056b3;
      }
      /* Flexbox Layout for the Form Row */
      .form-row {
          display: flex;
          flex-wrap: wrap;
          gap: 20px; /* Jarak antar form-group */
          margin-top: 10px;
      }

      /* Styling each form group */
      .form-group {
          flex: 1;
          min-width: 200px;
          max-width: 330px; /* Membatasi lebar input */
      }

      /* Label Styling */
      .form-group label {
          font-size: 14px;
          font-weight: 500;
          margin-bottom: 5px;
          display: block;
      }

      /* Input Styling */
      .form-group input {
          width: 100%;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 5px;
          font-size: 14px;
          margin-top: 5px;
      }

      /* Input Focus Styling */
      .form-group input:focus {
          border-color: #007bff;
          outline: none;
      }
  </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="img/LOGO_GoTan.png" alt="GoTan Logo">
        <p class="role">Admin</p>
        <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="menu.php"><i class="fas fa-utensils"></i> Menu</a>
        <a href="rekap.php" class="active"><i class="fas fa-file-alt"></i> Rekap</a>
        <a href="login.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
    </div>
    <!-- Profile in Top Right -->
    <div class="profile">
        <span class="profile-name">Admin Name</span>
    </div>
    <div class="content">
        <h1>REKAP</h1>
        <div class="profile">
                <span class="profile-name">Admin Name</span>
            </div>
        <div class="search-box">
            <p>* You can search/view reservation(s) by typing one or more of these information</p>
            <div class="form-row">
            <div class="form-group">
                <label for="search-name">Full Name:</label>
                <input id="search-name" placeholder="Full name" type="text" />
            </div>
            <div class="form-group">
                <label for="search-phone">Phone Number:</label>
                <input id="search-phone" placeholder="Phone number" type="text" />
            </div>
            <div class="form-group">
                <label for="search-email">Email:</label>
                <input id="search-email" placeholder="Email" type="text" />
            </div>
        </div>
        <div class="form-row">
        <div class="form-group">
            <label for="start-date">From:</label>
            <input id="start-date" type="date" />
        </div>
        <div class="form-group">
            <label for="end-date">To:</label>
            <input id="end-date" type="date" />
        </div>
        </div>
            <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-top: 10px;">
                <button onclick="filterReservations()" style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; min-width: 100px;">
                  VIEW
                </button>
            </div>
        </div>
        <table class="table" id="reservation-table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Timeslots</th>
                <th>Number of people</th>
                <th>Full name</th>
                <th>Phone number</th>
                <th>Email</th>
                <th>Notes</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($reservations as $reservation): ?>
              <tr>
                <td><?= htmlspecialchars($reservation['booking_date']) ?></td>
                <td><?= htmlspecialchars($reservation['booking_time']) ?></td>
                <td><?= htmlspecialchars($reservation['number_of_people']) ?></td>
                <td><?= htmlspecialchars($reservation['name']) ?></td>
                <td><?= htmlspecialchars($reservation['phone']) ?></td>
                <td><?= htmlspecialchars($reservation['email']) ?></td>
                <td><?= htmlspecialchars($reservation['notes']) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
