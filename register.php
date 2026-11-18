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

    $stmt = $pdo->prepare(
        "INSERT INTO users (username, email, password)
         VALUES (?, ?, ?)"
    );

    $stmt->execute([
        $username,
        $email,
        $password
    ]);

    $message = "Registration successful!";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h1>Create Account</h1>

<p><?php echo $message; ?></p>

<form method="POST">

    <p>
        Username:<br>
        <input type="text" name="username" required>
    </p>

    <p>
        Email:<br>
        <input type="email" name="email" required>
    </p>

    <p>
        Password:<br>
        <input type="password" name="password" required>
    </p>

    <button type="submit">Register</button>

</form>

<br>

<a href="books.php">Back to Books</a>

</body>
</html>