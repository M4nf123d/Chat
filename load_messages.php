<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'], $_GET['user'])) exit;

$userId = $_SESSION['user_id'];
$otherId = (int)$_GET['user'];

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

$stmtMsg = mysqli_prepare($conn, "SELECT user_id, content, message_id FROM messages WHERE chat_id = ? ORDER BY created_at");
mysqli_stmt_bind_param($stmtMsg, "i", $chatId);
mysqli_stmt_execute($stmtMsg);
$msgResult = mysqli_stmt_get_result($stmtMsg);

while ($m = mysqli_fetch_assoc($msgResult)) {
    $class = $m['user_id'] == $userId ? 'me' : 'other';

    echo '<div class="message-wrapper">';

    if ($m['user_id'] == $userId) {
        echo '<div class="delete-wrapper">
            <button class="delete-btn" onclick="deleteMessage('.$m['message_id'].')">Usuń</button>
          </div>';

    }

    echo '<div class="message '.$class.'">'.htmlspecialchars($m['content']).'</div>';
    echo '</div>';
}
?>
