<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'], $_POST['user'], $_POST['message'])) exit;

$userId = $_SESSION['user_id'];
$otherId = (int)$_POST['user'];
$content = trim($_POST['message']);
if ($content === '') exit;


$chatResult = mysqli_query($conn, "SELECT * FROM chat_members WHERE user_id IN ($userId, $otherId)");

$userChats = [];
while ($row = mysqli_fetch_assoc($chatResult)) {
    $userChats[$row['chat_id']][] = $row['user_id'];
}

$chatId = 0;
foreach ($userChats as $id => $members) {
    if (in_array($userId, $members) && in_array($otherId, $members)) {
        $chatId = $id;
        break;
    }
}

if ($chatId === 0) {
    mysqli_query($conn, "INSERT INTO chats (created_by) VALUES ($userId)");
    $chatId = mysqli_insert_id($conn);
    mysqli_query($conn, "INSERT INTO chat_members (chat_id, user_id) VALUES ($chatId, $userId), ($chatId, $otherId)");
}


$stmt = mysqli_prepare($conn, "INSERT INTO messages (chat_id, user_id, content) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, "iis", $chatId, $userId, $content);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: chat.php?user=$otherId");
exit;
