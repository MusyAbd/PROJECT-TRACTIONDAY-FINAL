<?php
session_start();
	require 'config/koneksi.php' 

	header('Location: /api/dashboard_with_qr_copy.php');


include 'qr_secure.php';
