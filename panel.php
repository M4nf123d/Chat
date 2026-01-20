<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = mysqli_prepare($conn, "SELECT username, email FROM users WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['delete_account'])) {
        $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE user_id = ?");
        if (!$stmt) {
            die(mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "i", $userId);

        if (mysqli_stmt_execute($stmt)) {
            session_destroy();
            header('Location: register.php');
            exit;
        } else {
            $error = 'Nie udało się usunąć konta.';
        }

        mysqli_stmt_close($stmt);
    }

    $newUsername = trim($_POST['username'] ?? '');
    $newPassword = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    if ($newUsername === '') {
        $error = 'Nazwa użytkownika nie może być pusta.';
    } elseif ($newPassword !== '') {
        if (strlen($newPassword) < 8) {
            $error = 'Hasło musi mieć co najmniej 8 znaków.';
        } elseif ($newPassword !== $confirmPassword) {
            $error = 'Hasła nie są identyczne.';
        }
    }

    if ($error === '') {
        if ($newPassword !== '') {
            $hash = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, "UPDATE users SET username = ?, password_hash = ? WHERE user_id = ?");
            mysqli_stmt_bind_param($stmt, "ssi", $newUsername, $hash, $userId);
        } else {
            $stmt = mysqli_prepare($conn, "UPDATE users SET username = ? WHERE user_id = ?");
            mysqli_stmt_bind_param($stmt, "si", $newUsername, $userId);
        }

        if (mysqli_stmt_execute($stmt)) {
            $success = 'Dane zostały zaktualizowane.';
            $user['username'] = $newUsername;
        } else {
            $error = 'Wystąpił błąd przy aktualizacji danych.';
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Mój panel</title>
<link rel="stylesheet" href="panel.css">
</head>
<body>

<div class="panel-container">
    <div class="panel-box">
        <h2>Mój panel</h2>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
            <input type="text" value="<?= htmlspecialchars($user['email']) ?>" readonly>
            <input type="password" name="password" placeholder="Nowe hasło (min. 8 znaków)">
            <input type="password" name="confirm_password" placeholder="Potwierdź hasło">
            <button type="submit">Zapisz zmiany</button>
        </form>

        <form method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć konto?');">
            <button type="submit" name="delete_account" class="danger">Usuń konto</button>
        </form>
    </div>
</div>

</body>
</html>
