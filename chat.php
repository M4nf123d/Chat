<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

$usersResult = mysqli_query($conn, "SELECT user_id, username FROM users WHERE user_id != $userId");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Chat</title>
<link rel="stylesheet" href="chat.css">
</head>
<body>

<div class="chat-wrapper">
    <div class="sidebar">
        <button onclick="window.location.href='panel.php'">Mój panel</button>
        <div class="users">
            <?php while ($u = mysqli_fetch_assoc($usersResult)): ?>
                <a href="#" onclick="openChat(<?php echo $u['user_id']; ?>)"><?php echo htmlspecialchars($u['username']) ?></a>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="chat-box">
        <div class="messages" id="messages"></div>
        <div class="send-box">
            <form id="chatForm" onsubmit="return sendMessage();">
                <input type="hidden" id="chatUser">
                <input type="text" id="messageInput" placeholder="Napisz wiadomość">
                <button type="submit">Wyślij</button>
            </form>
        </div>
    </div>
</div>

<script>
let currentUser = null;

function openChat(userId) {
    currentUser = userId;
    document.getElementById('chatUser').value = userId;
    loadMessages();
}

function loadMessages() {
    if (!currentUser) return;
    fetch('load_messages.php?user=' + currentUser)
        .then(res => res.text())
        .then(html => {
            document.getElementById('messages').innerHTML = html;
            document.getElementById('messages').scrollTop = 999999;
        });
}

function sendMessage() {
    const input = document.getElementById('messageInput');
    if (!currentUser || input.value.trim() === '') return false;

    const formData = new FormData();
    formData.append('user', currentUser);
    formData.append('message', input.value.trim());

    fetch('send_message.php', {
        method: 'POST',
        body: formData
    }).then(() => {
        input.value = '';
        loadMessages();
    });

    return false;
}

function deleteMessage(msgId) {
    const formData = new FormData();
    formData.append('msgId', msgId);

    fetch('delete_message.php', {
        method: 'POST',
        body: formData
    }).then(() => {
        loadMessages();
    });
}

//setInterval(loadMessages, 2000);

</script>

</body>
</html>
