<?php
$host = 'localhost';
$db   = 'chat';
$user = 'root';
$pass = '';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    exit('Błąd połączenia z bazą danych: ' . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8mb4');
