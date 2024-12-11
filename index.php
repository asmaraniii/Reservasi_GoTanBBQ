<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoTan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8e8d0;
            color: #333;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            width: 250px;
            height: 100%;
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
            overflow-x: hidden; 
        }

        .header {
            text-align: center;
        }

        .header img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            max-width: 100%;
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

        .features {
            display: flex;
            justify-content: space-between;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .feature-box {
            text-align: center;
            flex: 1;
            min-width: 250px;
            padding: 10px;
            margin: 0 10px;
            background-color: #fce7d6;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .feature-box h3 {
            color: #914d24;
            font-size: 20px;
            min-width: 250px;
        }

        .feature-box p {
            font-size: 14px;
            min-width: 250px;
        }

        .about-us {
            background-color: #d1a175;
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
            line-height: 1.8;
            text-align: justify;
            overflow-x: hidden;
        }

        .about-us h4 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 10px;
            color: #fff;
        }

        .about-us button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #914d24;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .about-us button:hover {
            background-color: #733b1b;
        }

        .address {
            font-size: 14px;
            color: #914d24;
            text-align: center;
            line-height: 1.6;
        }

        .address a {
            color: #914d24;
            text-decoration: none;
        }

        .address a:hover {
            text-decoration: underline;
        }

        footer {
            text-align: center;
            font-size: 12px;
            padding: 10px;
            background-color: #ead4c2;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="img/gotan.png" alt="AN BBQ Logo">
        <p class="store-name">GoTan BBQ</p>
        <a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="menu.php"><i class="fas fa-utensils"></i> Menu</a>
        <a href="booking.php"><i class="fas fa-calendar-alt"></i> Booking</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
    </div>

    <div class="main-content">
        <div class="header">
            <img src="img/latar.png" alt="BBQ Image">
            <h1>TASTE THE AUTHENTIC BBQ</h1>
        </div>

        <div class="features">
            <div class="feature-box">
                <h3>JOYFUL</h3>
                <p>Enjoy happy moments with family</p>
            </div>
            <div class="feature-box">
                <h3>CONVENIENT</h3>
                <p>Online dish reservation</p>
            </div>
            <div class="feature-box">
                <h3>DELICIOUS</h3>
                <p>Enjoy all your great food</p>
            </div>
        </div>

        <div class="about-us">
            <h4>ABOUT US</h4>
            <p>Selamat datang di GoTan Resto BBQ, destinasi utama bagi pecinta kuliner yang ingin menikmati kelezatan BBQ dengan suasana yang hangat dan bersahabat</p>
            <button id="reserveButton">RESERVE YOUR DISH NOW</button>
        </div>

        <div class="address">
            <p>Golden Gate Trading Service Joint Stock Company</p>
            <p>Head Office: No. 60 Pho Duc Chinh Street, District 1, HCMC, Vietnam</p>
            <p>Email: <a href="mailto:support@anbbq.com.vn">support@GoTanbbq.com.vn</a></p>
        </div>
    </div>

    <footer>
        &copy; 2024 GoTan BBQ. All rights reserved.
    </footer>
    <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="45449a8e-3895-4cfa-8289-f6286b9ea141";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
    <script>
    // Menambahkan event listener pada tombol
    document.getElementById('reserveButton').addEventListener('click', function () {
        window.location.href = 'booking.php'; // Redirect ke halaman booking.php
    });
</script>

</body>
</html>
