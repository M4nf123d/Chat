<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$msgId = (int)$_POST['msgId'];

$stmt = mysqli_prepare($conn, "DELETE FROM messages WHERE message_id = ?");
mysqli_stmt_bind_param($stmt, "i", $msgId);
mysqli_stmt_execute($stmt);
?>
