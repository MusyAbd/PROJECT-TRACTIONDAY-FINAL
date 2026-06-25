<?php
session_start();

// Redirect to login if user is not authenticated
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
	header('Location: PHP/login.php');
	exit;
}

include 'qr_secure.php';
