<?php
session_start();
require_once 'db.php';

$error = [];
$username = '';
$success = '';

if (isset($_SESSION['user_id'])) {
    header('Location: chat.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username === '') {
        $error['username'] = 'Podaj login';
    }
    if ($password === '') {
        $error['password'] = 'Podaj hasło';
    }

    if (empty($error)) {
        $stmt = mysqli_prepare($conn, "SELECT user_id, password_hash FROM users WHERE username = ?");
        if (!$stmt) {
            die("Błąd SQL: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $user_id, $password_hash);

        if (mysqli_stmt_num_rows($stmt) === 1) {
            mysqli_stmt_fetch($stmt);
            if (password_verify($password, $password_hash)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $success = 'Zalogowano pomyślnie';
                header('Location: chat.php');
                exit;
            } else {
                $error['password'] = 'Nieprawidłowe hasło';
            }
        } else {
            $error['username'] = 'Nie ma takiego użytkownika';
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>

<div class="container">
    <h1>Logowanie</h1>

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
        <?php if(isset($error['username'])) { echo '<p class="error">' . htmlspecialchars($error['username']) . '</p>'; } ?>

        <input type="password" name="password" placeholder="Hasło" class="<?php echo isset($error['password']) ? 'input-error' : ''; ?>" required>
        <?php if(isset($error['password'])) { echo '<p class="error">' . htmlspecialchars($error['password']) . '</p>'; } ?>

        <button type="submit">Zaloguj się</button>
    </form>

    <p>Nie masz konta? <a href="register.php">Zarejestruj się</a></p>
</div>

</body>
</html>
