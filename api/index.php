<?php
session_start();

// Redirect to login if user is not authenticated
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
	header('Location: /dashboard_with_qr_copy.php');
	exit;
}
else {
	header('Location: /dashboard_with_qr_copy.php');
}

include 'qr_secure.php';
