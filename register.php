<?php
require_once 'db.php';

$error = [];
$success = '';

$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if ($username === '') {
        $error['username'] = 'Login jest wymagany';
    } elseif (strlen($username) > 20) {
        $error['username'] = 'Login może mieć maks. 20 znaków';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error['username'] = 'Login może zawierać tylko litery, cyfry i podkreślenia';
    }

    if ($email === '') {
        $error['email'] = 'Email jest wymagany';
    }

    if ($password === '') {
        $error['password'] = 'Hasło jest wymagane';
    } elseif (strlen($password) < 8) {
        $error['password'] = 'Hasło musi mieć min. 8 znaków';
    }

    if ($password2 === '') {
        $error['password2'] = 'Powtórz hasło';
    } elseif ($password !== $password2) {
        $error['password2'] = 'Hasła nie są takie same';
    }

    if (empty($error)) {
        $stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE username = ? OR email = ? LIMIT 1");
        if (!$stmt) {
            die("Błąd SQL: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error['general'] = 'Login lub email już istnieje';
        }

        mysqli_stmt_close($stmt);
    }

    if (empty($error)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($conn, "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Błąd SQL: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hash);

        if (mysqli_stmt_execute($stmt)) {
            $success = 'Konto utworzone — możesz się zalogować';
            $username = '';
            $email = '';
        } else {
            $error['general'] = 'Login lub email już istnieje';
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>

<div class="container">
    <h1>Rejestracja</h1>

    <?php
    if (!empty($error['general'])) {
        echo '<p class="error">' . htmlspecialchars($error['general']) . '</p>';
    }

    if ($success) {
        echo '<p class="success">' . htmlspecialchars($success) . '</p>';
    }
    ?>

    <form method="post">
        <input type="text" name="username" placeholder="Login" value="<?php echo htmlspecialchars($username); ?>" class="<?php echo isset($error['username']) ? 'input-error' : ''; ?>" required>
        <?php if (isset($error['username'])) echo '<p class="error">' . htmlspecialchars($error['username']) . '</p>'; ?>

        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" class="<?php echo isset($error['email']) ? 'input-error' : ''; ?>" required>
        <?php if (isset($error['email'])) echo '<p class="error">' . htmlspecialchars($error['email']) . '</p>'; ?>

        <input type="password" name="password" placeholder="Hasło" class="<?php echo isset($error['password']) ? 'input-error' : ''; ?>" required>
        <?php if (isset($error['password'])) echo '<p class="error">' . htmlspecialchars($error['password']) . '</p>'; ?>

        <input type="password" name="password2" placeholder="Powtórz hasło" class="<?php echo isset($error['password2']) ? 'input-error' : ''; ?>" required>
        <?php if (isset($error['password2'])) echo '<p class="error">' . htmlspecialchars($error['password2']) . '</p>'; ?>

        <button type="submit">Zarejestruj się</button>
    </form>

    <p>Jeśli masz już konto — <a href="login.php">zaloguj się</a></p>
    <a href="index.php" class="link">← Powrót</a>
</div>

</body>
</html>
