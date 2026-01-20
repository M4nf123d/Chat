<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$sender = $_SESSION['user_id'];
$receiver = (int)$_POST['receiver_id'];
$message = trim($_POST['message']);

if ($message !== '') {
    $stmt = mysqli_prepare($conn, "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iis", $sender, $receiver, $message);
    mysqli_stmt_execute($stmt);
}

header("Location: chat.php?user=$receiver");
exit;
