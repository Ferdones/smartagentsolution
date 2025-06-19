<?php
$host = 'localhost';
$dbname = 'online_store';
$username = 'root'; // Schimbă dacă ai setat alt user
$password = ''; // Schimbă dacă ai parolă la MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Conexiune eșuată: " . $e->getMessage());
}
?>
