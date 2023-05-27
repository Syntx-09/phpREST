<?php

$host = 'localhost';
$dbname = 'capstone';
$user = 'paradox';
$dbpass = 'paradox';

try {
	$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $dbpass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// echo "Connection Successful";
} catch (PDOException $e) {
	echo "Connetion failed: <br>" . $e->getMessage();
}

