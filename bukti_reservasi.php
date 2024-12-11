<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Reservation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Tetap sesuai tampilan aslinya */
        body {
            font-family: 'Arial', sans-serif;
            background-color: rgba(0, 0, 0, 0.8); /* Latar belakang gelap */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden; /* Nonaktifkan scroll */
        }
        .popup-container {
            position: relative;
            background-color: #ffffff;
            width: 300px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header {
            font-size: 20px;
            color: #a33b3b;
            margin-bottom: 20px;
        }
        .reservation-id {
            font-size: 14px;
            color: #a33b3b;
            margin-bottom: 10px;
        }
        .checkmark {
            font-size: 50px;
            color: #4caf50;
            margin-bottom: 10px;
        }
        .confirmation {
            font-size: 16px;
            color: #4caf50;
            margin-bottom: 20px;
        }
        .date {
            font-size: 30px;
            color: #a33b3b;
            margin-bottom: 10px;
        }
        .location {
            font-size: 16px;
            color: #a33b3b;
            margin-bottom: 20px;
        }
        .details {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .details div {
            text-align: center;
            color: #a33b3b;
        }
        .details i {
            font-size: 20px;
            margin-bottom: 5px;
        }
        .customer-info {
            border: 1px solid #a33b3b;
            padding: 10px;
            margin-bottom: 20px;
            color: #a33b3b;
        }
        .information {
            font-size: 14px;
            color: #a33b3b;
            margin-bottom: 20px;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #a33b3b;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="popup-container">
        <div class="close" onclick="closePopup()">×</div>
        <div class="header">YOUR RESERVATION</div>
        <div class="reservation-id">ID: <?php echo $reservation_id; ?></div>
        <div class="checkmark"><i class="fas fa-check-circle"></i></div>
        <div class="confirmation">Your reservation is confirmed!</div>
        <div class="date"><?php echo $date; ?></div>
        <div class="location"><?php echo $month . ", " . $day; ?></div>
        <div class="location">
            <i class="fas fa-map-marker-alt"></i> GoTan BBQ<br>Semarang, Jawa Tengah
        </div>
        <div class="details">
            <div>
                <i class="fas fa-clock"></i><br><?php echo $time; ?>
            </div>
            <div>
                <i class="fas fa-concierge-bell"></i><br><?php echo $location; ?>
            </div>
            <div>
                <i class="fas fa-user-friends"></i><br><?php echo $people_count; ?> people
            </div>
        </div>
        <div class="customer-info">
            <?php echo $name; ?><br>
            <?php echo $phone; ?><br>
            <?php echo $email; ?>
        </div>
        <div class="information">
            <strong>Information</strong><br>
            Note: If the customer cancels the reservation due to subjective reasons, the restaurant will not be responsible for refunding the deposit.
        </div>
    </div>

    <script>
        // Fungsi untuk menutup popup
        function closePopup() {
            document.querySelector('.popup-container').style.display = 'none';
        }
    </script>
</body>
</html>
