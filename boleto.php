<?php

include('php/conexion.php');

?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="images/airplane_logo.png">
  <title>Airplane</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css'><link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="container">

	<!-- <div class="ticket basic">
		<p>Admit One</p>
	</div> -->

	<div class="ticket airline">
		<div class="top">
			<h1>boarding pass</h1>
			<div class="big">
				<img src="images/airplane_logo.png" alt="" style="width: 50%;">
			</div>
			<div class="top--side">
				<i class="fas fa-plane"></i>
				<p><?=$_SESSION['vuelo']['norigen']?></p>
				<p><?=$_SESSION['vuelo']['ndestino']?></p>
			</div>
		</div>
		<div class="bottom">
			<div class="column">
				<div class="row row-1">
					<p><span>Flight</span><?=$_SESSION['vuelo']['id']?></p>
					<p class="row--right"><span>Amount</span>A<?=$_SESSION['vuelo']['adulto']?> M<?=$_SESSION['vuelo']['menor']?> N<?=$_SESSION['vuelo']['niño']?></p>
				</div>
				<div class="row row-2">
					<p><span>Passenger</span><?=$_SESSION['usuario']['nombre']?></p>
					<p><span>Boards</span><?=$_SESSION['vuelo']['hora']?></p>
				</div>
			</div>
			<div class="bar--code"></div>
		</div>
	</div>

</div>
<!-- partial -->
  <script  src="./script.js"></script>

</body>
</html>
