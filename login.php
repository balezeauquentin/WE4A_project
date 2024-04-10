<?php
session_start();
require_once ("assets/phptools/connection.php");
require_once ("assets/phptools/databaseFunctions.php");

if (isset($_POST['confirm'])) {
    // Validate user input (server-side)
    $username = validateUserInput($_POST['username']);
    $password = $_POST['password'];
    try {
        $sql = "SELECT * FROM users WHERE Username = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $passwordHash = $result['password'];
            if (password_verify($password, $passwordHash)) {
                $_SESSION['id'] = $result['id'];
                $_SESSION['username'] = $result['username'];
                $_SESSION['Admin'] = $result['admin'];
            } else {
                $error_password = "Wrong password";
            }
        } else {
            $error_user = "User not found";
        }
    } catch (PDOException $e) {
        die('Error: ' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Z</title>

    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="192x192" href="assets/img/favicon/android-icon-192x192.png">
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <div class = "inputs">
            <div class="input-group">
                <input class="input-group__input" type="text" placeholder="&nbsp;" name="username" id="username"
                    autocomplete="off" required />
                <label class="input-group__label" for="username">Username</label>
                <p class="error">
                    <?php echo $error_user; ?>
                </p>
            </div>
            <div class="input-group">
                <input class="input-group__input" type="password" placeholder="&nbsp;" name="password" id="password"
                    autocomplete="off" required />
                <label class="input-group__label" for="username">Password</label>
                <p class="error">
                    <?php echo $error_password; ?>
                </p>
            </div>
            </div>
            <p class="create-account">Don't have account yet ? <a href="register.php" class="register">Create one</a>
            </p>
            <div class="footer">
                <button type="submit" name="confirm">Login</button>
            </div>
        </form>
    </div>
</body>

</html>