<?php
// Konfigurasi koneksi database MySQLi
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'db_aghajaya';

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (! $conn) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8mb4');
