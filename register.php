<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background: #FFFFFF;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-register {
            background: #FFFFFF;
            border-radius: 50px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            font-family: 'Alegreya', serif;
            font-size: 28px;
            font-weight: 700;
            color: #0A376E;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 15px;
            font-weight: 700;
            color: #333333;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            height: 38px;
            margin-bottom: 20px;
            padding: 0 10px;
            border: 1px solid #BCBCBC;
            border-radius: 20px;
            background: #FFFFFF;
            box-sizing: border-box;
        }

        .btn {
            width: 100%;
            height: 41px;
            background: #1473E6;
            border: none;
            border-radius: 50px;
            color: #FFFFFF;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <center>
        <h2>Let's Get Your Account</h2>
        <div class="form-register">
            <form method="post">
                <label for="lname">Name</label>
                <input name="name" type="text" placeholder="Input Your Name">

                <label for="lemail">Email</label>
                <input name="email" type="email" placeholder="Input Your Email">

                <label for="uname">Username</label>
                <input name="uname" type="text" placeholder="Input Your Username">

                <label for="pass">Password</label>
                <input name="pass" type="password" placeholder="Input Your Password">

                <input type="submit" name="submit" value="Create Account" class="btn">
                <input type="submit" name="submit" formaction="login.php" value="I Have Account" class="btn">
            </form>
        </div>
    </center>

    <?php 
        include('connection.php');

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $uname = $_POST['uname'];
            $pass = md5($_POST['pass']);

            if (empty($uname) || empty($pass)) {
                echo "<script>
                    alert('Username Dan Password Harus DISI!!');
                    window.location.href='register.php';
                </script>";
            } else {
                $insert = "INSERT INTO register (nama, email, username, password) VALUES ('$name', '$email', '$uname', '$pass')";
                $query = mysqli_query($conn, $insert);

                if ($query) {
                    echo "<script>
                        alert('Account Anda Sudah Terkonfirmasi');
                        window.location.href='login.php';
                    </script>";
                } else {
                    echo "<script>
                        alert('Gagal membuat akun. Silakan coba lagi.');
                        window.location.href='register.php';
                    </script>";
                }
            }
        }
    ?>
</body>
</html>
