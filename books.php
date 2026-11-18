<?php

session_start();

require 'db.php';

$stmt = $pdo->query("SELECT * FROM books");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <title>BookHub</title>
</head>
<body>

<h1>BookHub</h1>

<p>
    Welcome,
    <strong>
        <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>
    </strong>
</p>

<p>
    <a href="logout.php">Logout</a>
</p>

<hr>

<h2>Available Books</h2>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Book Name</th>
        <th>Genre</th>
        <th>Price</th>
        <th>View</th>
    </tr>

    <?php foreach ($books as $book): ?>

    <tr>

        <td>
            <?php echo $book['book_id']; ?>
        </td>

        <td>
            <a href="book_details.php?id=<?php echo $book['book_id']; ?>">
                <?php echo htmlspecialchars($book['book_name']); ?>
            </a>
        </td>

        <td>
            <?php echo htmlspecialchars($book['Genre']); ?>
        </td>

        <td>
            £<?php echo number_format($book['price'], 2); ?>
        </td>

        <td>
            <a href="book_details.php?id=<?php echo $book['book_id']; ?>">
                View Details
            </a>
        </td>

    </tr>

    <?php endforeach; ?>

</table>

<br>

<p>
    <a href="register.php">Register New User</a>
</p>

<p>
    <a href="login.php">Login</a>
</p>

</body>
</html>