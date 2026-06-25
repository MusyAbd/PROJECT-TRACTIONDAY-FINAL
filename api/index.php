<?php
session_start();

// Redirect to login if user is not authenticated

	header('Location: /api/dashboard_with_qr_copy.php');


include 'qr_secure.php';
