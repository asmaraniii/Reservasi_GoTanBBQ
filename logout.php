<!DOCTYPE html>
<?php
	session_start();
	if (empty($_SESSION['username'])) {
		header("location: login.php"); 
	} else {
?>
<html>
<head>
<title>DASHBOARD</title>
<link rel='stylesheet' type='text/css' href='css/navbar-style.css'>
<link rel='stylesheet' type='text/css' href='css/tes.css'>
<link rel='stylesheet' type='text/css' href='css/sidebar.css'>
<link rel='stylesheet' type='text/css' href='css/form.css'>
<script type='text/javascript' src='ajax/ajax.js'></script>
</head>
<body>

<ul>
  <li><a href="#home"></a></li>
  <li><a href="#"> </a></li>
  <li><a href="#"> </a></li>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn"><?php 
														include ("connection.php"); 
														$sql = mysqli_query($conn, "SELECT * FROM register");
														
														if ($_SESSION['username']){
															$user_login = $_SESSION['username']; 
														}
														echo $user_login;
														?></a>
    <div class="dropdown-content">
    
      <a href="#">Profile</a>
      <a href="logout.php"><?php
					session_start(); 
					session_destroy(); 
					echo "<script>
							window.alert('Terima Kasih :)');
							window.location.href='login.php';
						  </script>";
					?>Logout</a>
    </div>
  </li>
</ul>
<hr>
<div class="sidebar">
    <h3 align ="center" color= "white">Dashboard</h3>
	<ul>
      <li><a href="index.php">Reservation</a></li>
    </ul>
  </div>
  <div class="reservasi">
				<form method = "get" action = "insert_data.php">
						<label for = "cname"> Name Customer	</label><br>
							<input type = "text" name = "namacust" placeholder= "Input Customer Name"><br>
							<label for = "restoran"> Restaurant </label><br>
								<select name = "nrestaurant" id="restaurant" onChange="showMeja(this.value)">
								<option>-- Choose Restaurant--</option><br>
								<?php
									include 'connection.php';
									$sql = mysqli_query($conn, "SELECT * FROM restoran");
									while($data = mysqli_fetch_array($sql)){
										echo "<option value='".$data['id_restoran']."'>(".$data['id_restoran'].")".$data['nama_restoran']."</option>";
									}
								?>
</select><br>
<div id = "meja">
</div>
  		<input type = "submit" name = "reservasi" value = "Reserve" class="btn btn=small btn-primary">
	</form>		
	</div>
</body>
</html>
<?php
}
?>