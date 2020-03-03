<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="/public/images/favicon.png" type="image/png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
	<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<link href="../../../public/styles/style.css" rel="stylesheet" type="text/css" media="all" />
	<title><?php echo $title; ?></title>

</head>
<script>
	function openNav() {
		document.getElementById("mySidebar").style.width = "60%";
		document.getElementById("mySidebar").style.display = "block";
	}

	function closeNav() {
		document.getElementById("mySidebar").style.display = "none";
	}
</script>
<body>
	<?php if (!empty($_GET['alert']) && isset($_GET['alert'])): ?>
		<script>alert("<?php echo $_GET['alert']; ?>");</script>
	<?php endif; ?>
	<?php if (isset($_SESSION['users']['id'])): ?>
		<nav class="w3-sidebar w3-black w3-animate-right w3-xxlarge" style="display:none;padding-top:150px;right:0;z-index:2" id="mySidebar">
			<a href="javascript:void(0)" onclick="closeNav()" class="w3-button w3-black w3-xxxlarge w3-display-topright" style="padding:0 12px;">
				<i class="fa fa-remove"></i>
			</a>
			<div class="w3-bar-block w3-center">
				<a href="/" class="w3-bar-item w3-button w3-text-grey w3-hover-black" onclick="closeNav()">Home</a>
				<a href="/recovery" class="w3-bar-item w3-button w3-text-grey w3-hover-black" onclick="closeNav()">Recovering password</a>
				<a href="/camera" class="w3-bar-item w3-button w3-text-grey w3-hover-black" onclick="closeNav()">Camera</a>
				<a href="/profile/<?php echo $_SESSION['users']['id'] ?>" class="w3-bar-item w3-button w3-text-grey w3-hover-black" onclick="closeNav()">PROFILE</a>
				<a href="/logout" class="w3-bar-item w3-button w3-text-grey w3-hover-black">EXIT</a>
			</div>
		</nav>
		<div class="w3-main w3-padding-large" style="margin-left:40%">
			<span class="w3-button w3-top w3-white w3-xxlarge w3-text-grey w3-hover-text-black" style="width:auto;right:0;" onclick="openNav()"><i class="fa fa-bars"></i></span>
		</div>
	<?php else: ?>
		<nav class="w3-sidebar w3-black w3-animate-right w3-xxlarge" style="display:none;padding-top:150px;right:0;z-index:2" id="mySidebar">
			<a href="javascript:void(0)" onclick="closeNav()" class="w3-button w3-black w3-xxxlarge w3-display-topright" style="padding:0 12px;">
				<i class="fa fa-remove"></i>
			</a>
			<div class="w3-bar-block w3-center">
				<a href="/" class="w3-bar-item w3-button w3-text-grey w3-hover-black" onclick="closeNav()">Home</a>
				<a href="/register" class="w3-bar-item w3-button w3-text-grey w3-hover-black" onclick="closeNav()">REGISTER</a>
				<a href="/login" class="w3-bar-item w3-button w3-text-grey w3-hover-black" onclick="closeNav()">LOGIN</a>
				<a href="/recovery" class="w3-bar-item w3-button w3-text-grey w3-hover-black" onclick="closeNav()">Recovering password</a>
			</div>
		</nav>
		<div class="w3-main" style="margin-left:40%">
			<span class="w3-button w3-top w3-white w3-xxlarge w3-text-grey w3-hover-text-black" style="width:auto;right:0;" onclick="openNav()"><i class="fa fa-bars"></i></span>
		</div>
	<?php endif; ?>
	<?php echo $content; ?>
	</div>
	<div class="footer w3-container w3-theme-d5">
		<h2 align="center">Camagru 2020 - @vpozniak</h2>
	</div>

</body>

</html>