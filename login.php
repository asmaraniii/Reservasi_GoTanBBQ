<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
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

        .login-box {
            background: #FFFFFF;
            border-radius: 50px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 500px;
        }

        h1 {
            text-align: center;
            font-family: 'Alegreya', serif;
            font-size: 40px;
            font-weight: 700;
            color: #0A376E;
            margin-bottom: 30px;
        }

        label {
            display: block;
            font-size: 15px;
            font-weight: 700;
            color: #333333;
            margin-bottom: 5px;
        }

        input[type="text"],
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

        button {
            width: 100%;
            height: 41px;
            background: #1473E6;
            border: none;
            border-radius: 50px;
            color: #FFFFFF;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 20px;
            text-align: center;
        }

        .register-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }

        .register-link a {
            color: #1473E6;
            text-decoration: none;
            font-weight: 700;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
        .logo {
            width: 150px;  /* Adjust the width as needed */
            height: auto;  /* Maintain aspect ratio */
            display: block;
            margin: 0 auto 20px;  /* Center the logo and add space below */
        }
    </style>
</head>
<body>
    <div class="login-box">
	<img src="img/latargotan.png" alt="Logo" class="logo">
        <h1>LOGIN</h1>
        <form method="post" action="sessionlogin.php">
            <label for="usern">Username</label>
            <input type="text" id="usern" name="usern" placeholder="Input Your Username">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Input Your Password">

            <button type="submit" name="login">LOG IN</button>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>
</html>