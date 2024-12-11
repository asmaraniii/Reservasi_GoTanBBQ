<?php
// Start session
session_start();

// Database connection parameters
$host = 'localhost';
$db_name = 'pbo';
$username = 'root';
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch reservations data for display
    $stmt = $conn->prepare("
        SELECT 
            restaurant_name, 
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
            place AS restaurant_name, 
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

    // Handle reservation creation
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ensure all expected keys exist in the $_POST array before using them
        $name = $_POST['name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'] ?? '';
        $restaurant_name = $_POST['restaurant_name'] ?? '';
        $booking_date = $_POST['booking_date'] ?? '';
        $booking_time = $_POST['booking_time'] ?? '';
        $number_of_people = $_POST['number_of_people'] ?? '';
        $notes = $_POST['notes'] ?? '';

        // Insert query
        $query = "INSERT INTO reservasiadmin 
                   (name, phone, email, restaurant_name, booking_date, booking_time, number_of_people, notes)
                  VALUES (:name, :phone, :email, :restaurant_name, :booking_date, :booking_time, :number_of_people, :notes)";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':name' => $name,
            ':phone' => $phone,
            ':email' => $email,
            ':restaurant_name' => $restaurant_name,
            ':booking_date' => $booking_date,
            ':booking_time' => $booking_time,
            ':number_of_people' => $number_of_people,
            ':notes' => $notes,
        ]);

        // Redirect to avoid form resubmission
        header("Location: create-onsite.php");
        exit();
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
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
            font-size: 26px;
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

       /* Reservation Form Styles (Hidden by default) */
        .reservation-form {
            display: none;
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Popup Modal */
        .modal {
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Darker overlay */
            padding-top: 80px;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            position: relative; /* Ensure close button is inside modal */
            background-color: #fff;
            margin: auto;
            padding: 20px;
            border-radius: 12px;
            width: 30%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            max-height: 70%;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 13px;
            color: #333;
            text-align: center;
        }

        .modal-body {
            margin-top: 10px;
            padding-top: 20px;
            font-size: 10px;
            display: flex; /* Menggunakan flexbox */
            flex-direction: column; /* Tata letak vertikal untuk semua elemen */
            gap: 10px; /* Jarak antar elemen */
        }

        .modal-body label {
            font-size: 10px;
            color: #666;
            flex: 1; /* Memberikan ruang yang cukup untuk label */
            text-align: right; /* Menyelaraskan teks ke kanan */
        }

        .modal-body input, .modal-body select, .modal-body textarea {
            width: 65%; /* Menentukan lebar input/textarea */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 8px;
        }

        .modal-body .form-group {
            display: flex; /* Mengatur tata letak label dan input secara horizontal */
            align-items: center; /* Vertikal tengah */
            gap: 10px; /* Jarak antara label dan input/textarea */
        }

        .modal-footer {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .modal-footer button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
        }

        .modal-footer button:hover {
            background-color: #0056b3;
        }

        /* Tombol close */
        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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

        /* Notification Popup */
        .notification-popup {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            font-size: 14px;
            font-weight: bold;
            animation: fadeInOut 3s;
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            10%, 90% {
                opacity: 1;
                transform: translateY(0);
            }
            100% {
                opacity: 0;
                transform: translateY(20px);
            }
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

    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="img/LOGO_GoTan.png" alt="GoTan Logo">
        <p class="role">Admin</p>
        <a href="index.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="menu-a.php"><i class="fas fa-utensils"></i> Menu</a>
        <a href="rekap.php"><i class="fas fa-file-alt"></i> Rekap</a>
        <a href="login.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
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
                <button class="create-button"><i class="fas fa-plus"></i> CREATE</button>
            </div>
            <div class="profile">
                <img src="https://via.placeholder.com/40" alt="Admin Profile">
                <span class="profile-name">Admin Name</span>
            </div>
        </div>

         <!-- Modal (Popup) -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                <form id="reservation-form" method="POST">
                    <div class="form-group">
                        <label for="full-name">Full Name:</label>
                        <input type="text" id="full-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone-number">Phone Number:</label>
                        <input type="text" id="phone-number" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="restaurant-name">Restaurant Name:</label>
                        <select name="restaurant_name" required>
                            <option value="GoTan: Savor The Flavor">GoTan: Savor The Flavor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Booking Date:</label>
                        <input type="date" id="date" name="booking_date" required>
                    </div>
                    <div class="form-group">
                        <label for="time">Booking Time:</label>
                        <input type="time" id="time" name="booking_time" required>
                    </div>
                    <div class="form-group">
                        <label for="people">Number of People:</label>
                        <input type="number" id="people" name="number_of_people" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="notes">Additional Notes:</label>
                        <textarea id="notes" name="notes"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submit-btn">Submit</button>
                    </div>
                </form>
                </div>
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

    </div>
    <script>
        // Modal Logic
        const modal = document.getElementById("myModal");
        const btn = document.querySelector(".create-button");
        const span = document.querySelector(".close");
        const submitBtn = document.getElementById("submit-reservation");

        // Open modal when "CREATE" button is clicked
        btn.onclick = function () {
            modal.style.display = "block";
        };

        // Close modal when "X" is clicked
        span.onclick = function () {
            modal.style.display = "none";
        };

        // Close modal if clicked outside the modal
        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };

        submitBtn.onclick = function () {
        // Validasi formulir
        const fullName = document.getElementById("full-name").value.trim();
        const phoneNumber = document.getElementById("phone-number").value.trim();
        const email = document.getElementById("email").value.trim();
        const branch = document.getElementById("branch").value.trim();
        const date = document.getElementById("date").value;
        const time = document.getElementById("time").value;
        const people = document.getElementById("people").value;

        if (!fullName || !phoneNumber || !email || !branch || !date || !time || !people) {
            alert("Please fill out all fields before submitting!");
            return;
        }

        // Jika validasi berhasil
        modal.style.display = "none";

        // Tampilkan notifikasi
        const notification = document.createElement("div");
        notification.className = "notification-popup";
        notification.innerText = `Reservation for ${fullName} created successfully!`;

        // Tambahkan notifikasi ke halaman
        document.body.appendChild(notification);

        // Hapus notifikasi setelah 3 detik
        setTimeout(() => {
            notification.remove();
        }, 3000);
    };
    </script>
</body>
</html>