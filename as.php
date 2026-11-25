<?php
session_start();
require 'db.php';

// Get all books
$stmt = $pdo->query("SELECT * FROM books");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookHub</title>

    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<body>

<header>
    <h1>📚 BookHub</h1>

    <nav>
        <a href="books.php">Home</a>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">

    <h2>Welcome,
        <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>
    </h2>

    <h3>Search Books</h3>

    <input
        type="text"
        id="search"
        placeholder="Type a book name..."
        onkeyup="searchBooks()">

    <br><br>

    <div id="results">

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Book Name</th>
                    <th>Genre</th>
                    <th>Price (£)</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($books as $book): ?>

                <tr>

                    <td>
                        <?php echo $book['book_id']; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($book['book_name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($book['Genre']); ?>
                    </td>

                    <td>
                        £<?php echo number_format($book['price'], 2); ?>
                    </td>

                    <td>
                        <a class="btn"
                           href="book_details.php?id=<?php echo $book['book_id']; ?>">
                            View Details
                        </a>
                    </td>

                </tr>

                <?php endforeach; ?>

            </tbody>
        </table>

    </div>

    <br>

    <a class="btn" href="register.php">
        Register User
    </a>

    <a class="btn" href="login.php">
        Login
    </a>

</div>

<footer>
    <p>BookHub Library System © 2026</p>
</footer>

</body>
</html>
