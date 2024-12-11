<?php
session_start(); // Mulai sesi

// Periksa apakah ada notifikasi di sesi
$success_message = isset($_SESSION['success']) ? $_SESSION['success'] : null;
$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$reservation_id = uniqid();

// Hapus notifikasi setelah ditampilkan
unset($_SESSION['success']);
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Form</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        /* Tambahan styling untuk notifikasi */
        .notification {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 16px;
            display: block; /* Default tampil jika ada pesan */
        }

        .notification.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .notification.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Styling lainnya tetap sama */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8e8d0;
            margin: 0;
            padding: 0;
            display: flex;
        }
        
        .sidebar {
            position: fixed;
            width: 250px;
            height: 100vh;
            background-color: #fbe7c6;
            padding: 20px 15px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar img {
            width: 80%;
            display: block;
            margin: 0 auto 15px;
        }

        .store-name {
            text-align: center;
            font-size: 20px;
            color: #914d24;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: #914d24;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #f2d1a9;
            font-weight: bold;
        }

        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding: 20px;
        }

        .container {
            width: calc(100% - 270px);
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color:  #f8e8d0;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 700px;
            width: 100%;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        h2 {
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 18px;
            color: #333;
        }

        select, input, textarea {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            resize: none;
            height: 80px;
        }

        label {
            font-size: 14px;
            margin-bottom: 15px;
            display: flex;
            align-items: center; /* Ensures the checkbox and text are aligned horizontally */
            gap: 10px; /* Adds space between the checkbox and the text */
        }

        label input {
            margin: 0; /* Removes the default margin around the checkbox */
            width: 18px; /* Adjusts the size of the checkbox */
            height: 18px; /* Adjusts the size of the checkbox */
        }

        button {
            padding: 12px;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #c9302c;
        }

        a {
            color: #d9534f;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
        .image-container img {
            max-width: 100%;    /* Make the image fit within its container */
            max-height: 300px;  /* Limit the height of the images to 300px */
            object-fit: cover;  /* Ensures the image maintains its aspect ratio without stretching */
            margin-top: 10px;    /* Adds a little space at the top */
            display: block;     /* Ensures images are block elements */
            margin-left: auto;
            margin-right: auto; /* Centers the images horizontally */
        }


        /* Styling untuk modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
            max-width: 100%;
        }
        .modal-header {
            font-size: 20px;
            color: #a33b3b;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .checkmark {
            font-size: 50px;
            color: #4caf50;
            margin-bottom: 10px;
        }
        .modal-info {
            font-size: 16px;
            margin-bottom: 20px;
            color: #4caf50;
        }
        .date {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-weight: bold;
            font-size: 22px;
        }
        .details {
            margin-bottom: 15px;
            color: #a33b3b;
        }
        .details i {
            margin-right: 5px;
        }
        .detail {
            margin-bottom: 15px;
            color: #a33b3b;
            border: 2px solid #a33b3b; 
            border-radius: 0px; 
            padding: 10px; 
            background-color: #fff; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        }
        .detail i {
            margin-right: 5px;
        }
        .detail strong {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #a33b3b;
        }
        .information {
            font-size: 14px;
            color: #a33b3b;
            margin-bottom: 20px;
        }
        .cancel-btn, .close-btn {
            padding: 8px 12px;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .cancel-btn:hover, .close-btn:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="img/gotan.png" alt="AN BBQ Logo">
        <p class="store-name">GoTan BBQ</p>
        <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="menu.php"><i class="fas fa-utensils"></i> Menu</a>
        <a href="booking.php" class="active"><i class="fas fa-calendar-alt"></i> Booking</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
    </div>
    <div class="main-content">
        <div class="container">
            <header>
                <img src="img/buking.png" alt="Logo" class="logo">
            </header>

            <!-- Notifikasi -->
            <?php if ($success_message): ?>
                <div class="notification success">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            <?php if ($error_message): ?>
                <div class="notification error">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <!-- Form Booking -->
            <form id="bookingForm">
                <h2>Pilih Tempat</h2>
                <select name="place" required>
                    <option value="" disabled selected>-- Pilih Tempat --</option>
                    <option value="Indoor">Indoor</option>
                    <option value="Outdoor">Outdoor</option>
                </select>

                <div class="image-container">
                    <img id="indoor-image" src="img/indoor.jpg" alt="Indoor Area" style="display: none;">
                    <img id="outdoor-image" src="img/outdoor.jpg" alt="Outdoor Area" style="display: none;">
                </div>

                <h2>Pilih Waktu Booking</h2>
                <input type="datetime-local" name="booking_time" required>

                <h2>Jumlah Orang</h2>
                <input type="number" name="people_count" min="1" max="10" value="2" required>

                <h2>Silahkan Masukkan Data Diri</h2>
                <input type="text" name="full_name" placeholder="Full Name" required>
                <input type="tel" name="phone_number" placeholder="Phone Number" required>
                <input type="email" name="email" placeholder="Email" required>
                <textarea name="notes" placeholder="Additional Notes"></textarea>

                <label>
                    <input type="checkbox" name="terms" required>
                    I agree with restaurant terms of service
                </label>

                <button type="submit">RESERVE</button>
            </form>
        </div>
    </div>

    <!-- Modal untuk bukti reservasi -->
    <div id="reservationModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">YOUR RESERVATION</div>
            <div class="reservation-id">ID: <?php echo $reservation_id; ?></div>
            <div class="checkmark"><i class="fas fa-check-circle"></i></div>
            <div class="modal-info">Your reservation is confirmed!</div>
            <div class="details">
            <i class="fas"></i>
            <span class="date">
                <span id="modalDate"></span>
                <span id="modalMonth"></span>
                <span id="modalYear"></span>
                <span id="modalDay"></span>
            </span><br>
            <div class="location"><i class="fas fa-map-marker-alt"></i> GoTan BBQ<br>Semarang, Jawa Tengah</div><br>
                <i class="fas fa-clock"></i><span id="modalTime"></span>&nbsp;&nbsp;
                <i class="fas fa-concierge-bell"></i><span id="modalLocation"></span>&nbsp;&nbsp;
                <i class="fas fa-user-friends"></i><span id="modalPeopleCount"></span>
            </div>
            <div class="detail">
                <strong>Customer Info:</strong>
                <span id="modalName"></span><br>
                <span id="modalPhone"></span><br>
                <span id="modalEmail"></span>
            </div>
            <div class="information">
                <strong>Information</strong><br>
                Note: Screenshot bukti ini dan tunjukkan pada saat melakukan pembayaran.
            </div>
            <button class="close-btn" onclick="closeModal()">Close</button>
            <button class="cancel-btn">Payment</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
    // Get the select element for the place and the image elements
    const placeSelect = document.querySelector('select[name="place"]');
    const indoorImage = document.getElementById('indoor-image');
    const outdoorImage = document.getElementById('outdoor-image');
    
    // Event listener for place selection
    placeSelect.addEventListener('change', function() {
        // Hide both images initially
        indoorImage.style.display = 'none';
        outdoorImage.style.display = 'none';
        
        // Show the corresponding image based on the selected option
        if (placeSelect.value === 'Indoor') {
            indoorImage.style.display = 'block';
        } else if (placeSelect.value === 'Outdoor') {
            outdoorImage.style.display = 'block';
        }
    });

    // Form submission handling
    document.getElementById('bookingForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent form submission

        const formData = new FormData(this);
        const fullName = formData.get('full_name');
        const phoneNumber = formData.get('phone_number');
        const email = formData.get('email');
        const place = formData.get('place');
        const bookingTime = formData.get('booking_time');
        const peopleCount = formData.get('people_count');
        const notes = formData.get('notes');

        // Format the booking date to "tanggal bulan, hari"
        const bookingDate = new Date(bookingTime);
        const options = { year: 'numeric', month: 'long', day: 'numeric', weekday: 'long' };
        const formattedDate = bookingDate.toLocaleDateString('id-ID', options); // Format for Indonesian locale

        // Display reservation details in the modal
        document.getElementById('modalName').innerText = fullName;
        document.getElementById('modalPhone').innerText = phoneNumber;
        document.getElementById('modalEmail').innerText = email;
        document.getElementById('modalLocation').innerText = place;
        document.getElementById('modalDate').innerText = formattedDate; // Display formatted date
        document.getElementById('modalTime').innerText = bookingDate.toLocaleTimeString();
        document.getElementById('modalPeopleCount').innerText = peopleCount;

        // Show the modal
        document.getElementById('reservationModal').style.display = 'flex';
    });

    document.querySelector('.cancel-btn').addEventListener('click', function() {
        console.log('Cancel button clicked');
        window.location.href = 'payment.php';
    });
});

function closeModal() {
    document.getElementById('reservationModal').style.display = 'none';
}
    </script>
</body>
</html>