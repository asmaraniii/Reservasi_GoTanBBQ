<?php
session_start(); // Memulai sesi

// Ambil ID reservasi dari parameter GET
$reservation_id = uniqid();

// Membuat kode CAPTCHA jika belum ada
if (!isset($_SESSION['captcha_code'])) {
    $_SESSION['captcha_code'] = rand(10000, 99999); // Membuat CAPTCHA secara acak
}

// Proses form jika metode pengiriman adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $deposit_cost = $_POST['deposit_cost'];
    $service_supplier = $_POST['service_supplier'];
    $payment_method = $_POST['payment_method'];
    $bank = $_POST['bank'];
    $card_number = $_POST['card_number'];
    $captcha_code = $_POST['captcha_code'];

    // Validasi CAPTCHA
    if ($captcha_code !== $_SESSION['captcha_code']) {
        $error_message = "CAPTCHA code salah. Silakan coba lagi.";
    } else {
        // Tampilkan modal untuk pembayaran berhasil
        $success_modal = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #444;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .input-group input,
        .input-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
        }
        button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .cancel-btn {
            background-color: #f44336;
            color: white;
        }
        .payment-btn {
            background-color: #4CAF50;
            color: white;
        }
        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .payment-methods {
            display: flex; /* Gunakan flexbox untuk menyusun elemen secara horizontal */
            gap: 10px;     /* Jarak antar elemen */
            align-items: center; /* Menyelaraskan radio button dengan teks */
        }

        .payment-methods label {
            display: inline-flex; /* Agar label tetap sejajar dengan input */
            align-items: center;
            gap: 5px; /* Jarak antara radio button dan teks */
            cursor: pointer; /* Mengatur agar kursor berubah saat di hover */
        }
        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6); /* Darker background */
            padding-top: 10vh;
        }
        /* CSS untuk mengatur warna dan posisi Reservation Information */
        .reservation-title {
            font-size: 20px;
            color: #a33b3b; /* Warna teks sesuai permintaan */
            font-weight: bold;
            text-align: left; /* Teks berada di kiri */
        }

        /* CSS untuk card informasi reservasi */
        .reservation-card {
            background-color: #fbe7c6; /* Warna latar belakang card */
            padding: 10px;
            border-radius: 8px;
            text-align: left; /* Teks berada di kiri */
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Memperbesar font informasi reservasi */
        .reservation-card p {
            font-size: 18px; /* Perbesar ukuran font */
            margin: 12px 0;
            color: #333;
        }

        .success-message {
            text-align: center;
        }

        .checkmark-icon {
            font-size: 60px;
            color: #4caf50;
            margin-bottom: 15px;
        }

        h4 {
            font-size: 18px;
            color: #4caf50;
            margin-bottom: 10px;
        }

        /* Mengatur ukuran modal agar lebih besar */
        .modal-content {
            background-color: #fff;
            margin: 0 auto;
            padding: 15px;
            border: none;
            width: 90%;
            max-width: 400px; /* Perbesar ukuran modal */
            height: auto;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column; /* Membuat modal memiliki layout vertikal */
            justify-content: space-between; /* Membuat konten modal dan footer terpisah */
            max-height: 80vh; /* Membatasi tinggi modal agar bisa di-scroll jika konten besar */
            overflow-y: auto; /* Mengaktifkan scroll vertikal jika konten melebihi batas */
        }

        .modal-header {
            font-size: 20px;
            color: #444;
            margin-bottom: 10px;
        }

        .modal-body {
            margin: 10px 0;
            flex-grow: 1;
        }

        .success-message {
            text-align: center;
        }

        h4 {
            font-size: 18px;
            color: #4caf50;
            margin-bottom: 10px;
        }

        .modal-footer {
            padding-top: 20px;
            text-align: center;
            padding-bottom: 15px;
        }
        /* Mengatur warna teks "Thank you" */
        .thank-you-text {
            color: #4caf50; /* Warna hijau */
            font-size: 18px; /* Ukuran font */
            font-weight: bold;
        }
        /* Tombol Close di bagian bawah tengah */
        .close-btn {
            background-color: #a33b3b; /* Warna tombol */
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100px;
            display: block;
            margin: 0 auto; /* Tombol di bawah tengah */
            text-align: center;
        }

        .close-btn:hover {
            background-color: #8c3131; /* Warna saat tombol di-hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($error_message)) {
            echo "<p class='error'>$error_message</p>";
        }
        ?>

        <h2>Payment Page</h2>
        <form method="POST">
            <div class="input-group">
            <label>ID Reservation:</label>
            <input type="text" name="reservation_id" value="<?php echo htmlspecialchars($reservation_id); ?>" readonly>
            </div>
            <div class="input-group">
                <label>Deposit Cost:</label>
                <input type="text" name="deposit_cost" value="200,000 IDR" readonly>
            </div>
            <div class="input-group">
                <label>Service Supplier:</label>
                <input type="text" name="service_supplier" value="GoTan BBQ" readonly>
            </div>
            <div class="input-group">
            <label>Payment Methods:</label>
            <div class="payment-methods">
                <label><input type="radio" name="payment_method" value="international_card" required> International Card</label>
                <label><input type="radio" name="payment_method" value="atm_card"> ATM Card</label>
            </div>
            </div>
            <div class="input-group">
                <label>Choose a Bank:</label>
                <select name="bank" required>
                    <option value="">Select Bank</option>
                    <option value="Bank A">Bank A</option>
                    <option value="Bank B">Bank B</option>
                </select>
            </div>
            <div class="input-group">
                <label>Enter Card Number:</label>
                <input type="text" name="card_number" required>
            </div>
            <div class="input-group">
            <label>Enter Code:</label>
            <input type="text" name="captcha_code" placeholder="Enter code" required>
            <img src="captcha.php" alt="CAPTCHA" style="margin-top: 5px; display: block;">
        </div>
            <div class="buttons">
                <button type="button" class="cancel-btn" onclick="window.location.href='booking.php';">CANCEL</button>
                <button type="submit" class="payment-btn">PAYMENT</button>
            </div>
        </form>
    </div>

    <?php if (isset($success_modal) && $success_modal): ?>
        <div id="successModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="reservation-title">Reservation Information</h3>
        </div>
        <div class="modal-body">
            <div class="reservation-card">
                <p><strong>ID Reservation:</strong> <?php echo htmlspecialchars($reservation_id); ?></p>
                <p><strong>Deposit Cost:</strong> IDR 200,000</p>
                <p><strong>Service Supplier:</strong> GoTan BBQ</p>
            </div>
            <div class="success-message">
                <!-- Ikon Checkmark -->
                <i class="fa fa-check-circle checkmark-icon"></i> 
                <h4>SUCCESSFUL PAYMENT TRANSACTION</h4>
                <p class="thank-you-text">Thank you for using our service!</p>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="closeModal()" class="close-btn">OK</button>
        </div>
    </div>
</div>
    <script>
        document.getElementById('successModal').style.display = 'flex';

        function closeModal() {
            document.getElementById('successModal').style.display = 'none';
            window.location.href = 'index.php';
        }
    </script>
    <?php endif; ?>
</body>
</html>