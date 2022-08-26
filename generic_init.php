<!DOCTYPE html>
<html>
	<?php
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	?>

	<head>
		<meta charset="utf-8">

		<noscript><meta http-equiv="refresh" content="0; url=indexstatic.htm" /></noscript>
		
		<meta http-equiv="Strict-Transport-Security" content="max-age=31536000">
		<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
		<meta name="viewport" content="width=device-width, user-scalable=no" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="color-scheme" content="light only" />
		<meta name="mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		
		<link rel="shortcut icon" href="Logic/Graphics/favicon.ico" type="image/x-icon">
		<link rel="icon" href="Logic/Graphics/favicon.ico" type="image/x-icon">
		<link rel="apple-touch-icon" sizes="180x180" href="Logic/Graphics/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="Logic/Graphics/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="Logic/Graphics/favicon-16x16.png">
		<link rel="manifest" href="Logic/Graphics/site.webmanifest">
		
		<!-- https://www.bootstrapcdn.com/ -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
		
		<!-- https://cdnjs.com/libraries/font-awesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
		
		<!-- https://www.osano.com/cookieconsent/download/ -->
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css" />
		
		<!-- https://simplelightbox.com/ -->
		<!-- link rel="stylesheet" type="text/css" href="./Resources/simplelightbox-master/dist/simple-lightbox.css?v2.4.1" /-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.7.2/simple-lightbox.css" integrity="sha512-6iATzDcEv/vBSNyzV8/jiaFGpm6caKphDvt7xNbDPePkWlbaNec/+fdsAJUORA+UB8XmoJ0/8iHsfyb/TSmJNg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

		<link rel="stylesheet" href="index.css?v=21" type="text/css" />
	</head>
	<body class="position-relative">
		<nav class="nav sticky-top navbar-light title justify-content-center">
			<a class="btn btn-success border-white btn-sm m-2 shadow btn-grad text-white me-auto" nohref>MemeSort</a>

			<a class="ms-auto btn btn-info btn-sm m-2 shadow btn-grad text-black" href="upload.php">Upload</a>
			<a class="btn btn-warning btn-sm m-2 shadow text-black" href="index.php">Sort</a>
		</nav>