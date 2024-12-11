<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Restoran</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #f8e8d0;
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
            flex: 1;
            padding: 20px;
        }
        .header {
            text-align: center;
        }
        .header img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
        }
        .header h1 {
            font-size: 36px;
            color: #914d24;
            background-color: #ead4c2;
            display: inline-block;
            padding: 10px 20px;
            margin-top: -60px;
            position: relative;
            z-index: 1;
        }
        .section-title {
            text-align: center;
            font-size: 24px;
            margin: 20px 0;
            font-weight: bold;
        }
        .menu-section {
            margin-bottom: 40px;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }
        .menu-item {
            text-align: center;
        }
        .menu-item img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }
        .menu-item span {
            display: block;
            margin-top: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="img/gotan.png" alt="AN BBQ Logo">
        <p class="store-name">GoTan BBQ</p>
        <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="menu.php" class="active"><i class="fas fa-utensils"></i> Menu</a>
        <a href="booking.php" ><i class="fas fa-calendar-alt"></i> Booking</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
    </div>
    <!-- Main Content -->
    <div class="main-content">
    <div class="container">
        <div class="header">
            <h1>TASTE THE AUTHENTIC BBQ</h1>
            <img src="img/latargotan.png" alt="Banner">
        </div>
        <div class="menu-section">
            <div class="section-title">MAKANAN</div>
            <div class="menu-grid">
                <div class="menu-item">
                    <img src="img/ayam panggang.jpg" alt="Makanan 1">
                    <span>Ayam Panggang</span>
                </div>
                <div class="menu-item">
                    <img src="img/sate kambing.jpg" alt="Makanan 2">
                    <span>Sate Kambing</span>
                </div>
                <div class="menu-item">
                    <img src="img/steak daging.jpg" alt="Makanan 3">
                    <span>Steak Daging</span>
                </div>
                <!-- Tambahkan menu lainnya -->
            </div>
        </div>
        <div class="menu-section">
            <div class="section-title">MINUMAN</div>
            <div class="menu-grid">
                <div class="menu-item">
                    <img src="img/es teh.jpg" alt="Minuman 1">
                    <span>Es Teh Manis</span>
                </div>
                <div class="menu-item">
                    <img src="img/jus jeruk.png" alt="Minuman 2">
                    <span>Jus Jeruk</span>
                </div>
                <div class="menu-item">
                    <img src="img/cappuccino.jpg" alt="Minuman 3">
                    <span>Cappuccino</span>
                </div>
                <!-- Tambahkan minuman lainnya -->
            </div>
        </div>
        <div class="menu-section">
            <div class="section-title">DIMSUM</div>
            <div class="menu-grid">
                <div class="menu-item">
                    <img src="img/siomay ayam.jpg" alt="Dimsum 1">
                    <span>Siomay Ayam</span>
                </div>
                <div class="menu-item">
                    <img src="img/hakau udang.jpg" alt="Dimsum 2">
                    <span>Hakau Udang</span>
                </div>
                <div class="menu-item">
                    <img src="img/bapao ayam.jpg" alt="Dimsum 3">
                    <span>Bakpao Ayam</span>
                </div>
                <!-- Tambahkan dimsum lainnya -->
            </div>
        </div>
    </div>
</body>
</html>