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
</head>
<body>

<h1>Login</h1>

<?php if (!empty($message)): ?>
    <p style="color:red;">
        <?php echo $message; ?>
    </p>
<?php endif; ?>

<form method="POST">

    <label>Email:</label><br>
    <input type="email" name="email" required>
    <br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required>
    <br><br>

    <button type="submit">Login</button>

</form>

<br>

<p>
    Don't have an account?
    <a href="register.php">Register Here</a>
</p>

<p>
    <a href="books.php">View Books</a>
</p>

</body>
</html>