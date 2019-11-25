<?php

echo '
<!doctype html>
<html class="h-100" lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>' . $TITLE . '</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="' . $HTTP . $HTTP_HOST . 'assets/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="' . $HTTP . $HTTP_HOST . 'assets/css/bootstrap/bootstrap-select.css" />
	<link rel="stylesheet" href="' . $HTTP . $HTTP_HOST . 'assets/css/style.css">
	<link rel="stylesheet" href="' . $HTTP . $HTTP_HOST . 'assets/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="' . $HTTP . $HTTP_HOST . 'assets/css/bootstrap-datepicker.min.css">
		' . $CSS . '
	<!-- JavaScript -->
	<script src="' . $HTTP . $HTTP_HOST . 'assets/js/jquery-3.4.1.js"></script>
	<script src="' . $HTTP . $HTTP_HOST . 'assets/js/sort_table.js"></script>
		' . $JS . '
</head>
<body class="d-flex flex-column h-100">';