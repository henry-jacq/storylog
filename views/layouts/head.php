<?php

use App\Core\Session;

?>

<head>
	<meta data-n-head="1" charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/x-icon" href="/assets/brand/photogram-icon.png">
	<meta name="author" content="Henry">
	<meta property="og:image" content="<?= URL_ROOT ?>assets/brand/photogram-icon.png">
	<meta property="site_name" content="Photogram">
	<meta property="og:title" content="Photogram · Gallery of Memories">
	<meta property="og:site_name" content="<?= DOMAIN_NAME ?>">
	<meta property="og:type" content="website">
	<meta property="og:image" content="<?= URL_ROOT ?>assets/brand/photogram-icon.png">
	<meta property="og:image:alt" content="Photogram • Created by Henry">
	<meta property="description" content="Create an account or log in to Photogram. Share photos &amp; videos with friends, family and other people you know.">

	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="Photogram">
	<meta name="twitter:description" content="Photogram is an easy-to-use web app for sharing photos with a clean and uncluttered interface.">
	<meta name="twitter:image" content="https://iphotogram.selfmade.one/assets/screenshot-2.png">

	<?php if (Session::isAuthenticated()) { ?>
		<?php if (Session::currentScript() == "index") { ?>
			<title>Home · Photogram</title>
		<?php } elseif (Session::currentScript() == "profile") { ?>
			<title>Profile · Photogram</title>
		<?php } elseif (Session::currentScript() == "settings") { ?>
			<title>Settings · Photogram</title>
		<?php } else { ?>
			<title>Photogram</title>
		<?php }
	} elseif (Session::currentScript() == "forgot-password") { ?>
		<title>Forgot password</title>
	<?php } elseif (Session::$isError) { ?>
		<title>404 Page not found!</title>
	<? } else { ?>
		<title>Sign in/up · Photogram</title>
	<?php } ?>

	<!-- Favicon for photogram -->
	<link rel="shortcut icon" href="<?= URL_ROOT ?>assets/brand/favicon.ico">
	<!-- Custom-compiled bootstrap CSS -->
	<link href="<?= URL_ROOT ?>css/main.min.css" rel="stylesheet">

	<!-- App CSS -->
	<link rel="stylesheet" href="<?= URL_ROOT ?>css/app.min.css">

	<!-- Hover CSS -->
	<link rel="stylesheet" href="<?= URL_ROOT ?>css/hover.css">
	<!-- Bootstrap Icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

	<!-- Dropzone CSS -->
	<link rel="stylesheet" href="<?= URL_ROOT ?>css/dropzone.css" type="text/css" />

	<?php
	// Load the CSS file if the current script matches the following
	if (Session::currentScript() == "login" or Session::currentScript() == "register" or Session::currentScript() == "forgot-password") {
		if (file_exists(($_SERVER['DOCUMENT_ROOT'] . URL_ROOT . "css/entry.css"))) { ?>
			<link rel="stylesheet" href="<?= URL_ROOT . "css/entry.css" ?>">
	<?php }
	} ?>

</head>