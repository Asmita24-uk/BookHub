<?php
require 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );

    // Check if email already exists
    $check = $pdo->prepare(
        "SELECT id FROM users WHERE email = ?"
    );

    $check->execute([$email]);

    if ($check->fetch()) {

        $message = "Email already registered.";

    } else {

        $stmt = $pdo->prepare(
            "INSERT INTO users
            (username, email, password)
            VALUES (?, ?, ?)"
        );

        $stmt->execute([
            $username,
            $email,
            $password
        ]);

        $message = "Registration successful! You can now login.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>BookHub</h1>

    <nav>
        <a href="books.php">Home</a>
        <a href="login.php">Login</a>
    </nav>
</header>

<div class="auth-box">

    <h2>Create Account</h2>

    <?php if (!empty($message)): ?>

        <div class="success">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <label>Username</label>
        <input
            type="text"
            name="username"
            required>

        <label>Email</label>
        <input
            type="email"
            name="email"
            required>

        <label>Password</label>
        <input
            type="password"
            name="password"
            required>

        <button type="submit">
            Register
        </button>

    </form>

    <br>

    <a class="btn" href="login.php">
        Login
    </a>

    <a class="btn" href="books.php">
        Back to Books
    </a>

</div>

<footer>
    <p>BookHub Library System</p>
</footer>

</body>
</html>
</html>
