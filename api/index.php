<?php
session_start();

// Redirect to login if user is not authenticated
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
	header('Location: /api/dashboard_with_qr_copy.php');
	exit;
}

include 'qr_secure.php';
