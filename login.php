<?php
session_start();
require 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare(
        "SELECT * FROM users WHERE email = ?"
    );

    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header("Location: books.php");
        exit();

    } else {

        $message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>BookHub Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>BookHub</h1>

    <nav>
        <a href="books.php">Home</a>
        <a href="register.php">Register</a>
    </nav>
</header>

<div class="auth-box">

    <h2>Login</h2>

    <?php if (!empty($message)): ?>
        <div class="error">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST">

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
            Login
        </button>

    </form>

    <br>

    <a class="btn" href="register.php">
        Register Here
    </a>

    <a class="btn" href="books.php">
        View Books
    </a>

</div>

<footer>
    <p>BookHub Library System</p>
</footer>

</body>
</html>
