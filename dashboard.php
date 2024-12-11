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
                       -- Assuming id is available in the 'reservasiadmin' table
        restaurant_name,  -- Assuming restaurant_name is available in the 'reservasiadmin' table
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
                       -- Assuming id is available in the 'reservations' table
        place,  -- Assuming restaurant_name is available in the 'reservations' table
        booking_time AS booking_date, 
        booking_time AS booking_time, 
        people_count AS number_of_people, 
        full_name AS name, 
        phone_number AS phone, 
        email AS email, 
        notes AS notes 
    FROM reservations
    ORDER BY booking_date ASC
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
    <title>Reservation Schedule</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            display: flex;
            height: 100vh;
            background-color: #f8f9fa;
            color: #333;
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

        /* Main Content Styles */
        .main-content {
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
            color: #1a3e72;
        }

        .header .date-picker {
            display: flex;
            align-items: center;
        }

        .header .date-picker button {
            background-color: #ffffff;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            margin-right: 10px;
            cursor: pointer;
        }

        .header .date-picker button:hover {
            background-color: #e9ecef;
        }

        .header .available-seat {
            display: flex;
            align-items: center;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 5px;
        }

        .header .available-seat i {
            margin-left: 5px;
        }

        .header .create-button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 20px;
        }

        .header .create-button:hover {
            background-color: #0056b3;
        }

        .header .create-button:active {
            background-color: #007bff;
            box-shadow: none;
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

        /* Schedule Table Styles */
        .schedule {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .schedule th, .schedule td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: center;
        }

        .schedule th {
            background-color: #f1f3f5;
        }

        .schedule td.highlight {
            background-color: #d1ecf1;
        }

        /* Legend Styles */
        .legend {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .legend div {
            display: flex;
            align-items: center;
            margin: 0 10px;
        }

        .legend div span {
            width: 20px;
            height: 20px;
            display: inline-block;
            margin-right: 5px;
            border-radius: 50%;
        }

        .legend .pending span { background-color: #ffc107; }
        .legend .deposited span { background-color: #17a2b8; }
        .legend .waiting span { background-color: #ffc107; }
        .legend .finished span { background-color: #28a745; }
        .legend .cancelled span { background-color: #dc3545; }

        /* Media Query for Responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .header h1 {
                font-size: 22px;
            }

            .schedule th, .schedule td {
                font-size: 12px;
            }

            .profile {
                flex-direction: column;
                align-items: flex-start;
            }

            .create-button {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="img/LOGO_GoTan.png" alt="GoTan Logo">
        <p class="role">Admin</p>
        <a href="index.php"class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="menu-a.php"><i class="fas fa-utensils"></i> Menu</a>
        <a href="rekap.php"><i class="fas fa-file-alt"></i> Rekap</a>
        <a href="login.php"><i class="fas fa-sign-out-alt"></i>Log Out</a>

    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>RESERVATION SCHEDULE</h1>
            <div class="date-picker">
                <button><i class="fas fa-calendar-alt"></i> Mon 05/12</button>
                <div class="available-seat">
                    <span>0</span> Available seat <i class="fas fa-user"></i>
                </div>
                <form action="create-onsite.php" method="POST">
                <button type="submit" class="create-button"><i class="fas fa-plus"></i> CREATE</button>
                </form>
            </div>
            <div class="profile">
                <img src="https://via.placeholder.com/40" alt="Admin Profile">
                <span class="profile-name">Admin Name</span>
            </div>
        </div>

        <!-- Schedule Table -->
        <table class="schedule">
            <thead>
                <tr>
                    
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Restaurant Name</th>
                    <th>Booking Date</th>
                    <th>Booking Time</th>
                    <th>People</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                <tr>
                    
                    <td><?= htmlspecialchars($reservation['name']); ?></td>
                    <td><?= htmlspecialchars($reservation['phone']); ?></td>
                    <td><?= htmlspecialchars($reservation['email']); ?></td>
                    <td><?= htmlspecialchars($reservation['restaurant_name']); ?></td>
                    <td><?= htmlspecialchars($reservation['booking_date']); ?></td>
                    <td><?= htmlspecialchars($reservation['booking_time']); ?></td>
                    <td><?= htmlspecialchars($reservation['number_of_people']); ?></td>
                    <td><?= htmlspecialchars($reservation['notes']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Legend -->
        <div class="legend">
            <div class="pending"><span></span> Pending</div>
            <div class="deposited"><span></span> Deposited</div>
            <div class="waiting"><span></span> Waiting payment</div>
            <div class="finished"><span></span> Finished</div>
            <div class="cancelled"><span></span> Cancelled</div>
        </div>
    </div>
</body>
</html>
