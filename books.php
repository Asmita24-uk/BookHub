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
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<body>

<header>
    <h1>BookHub</h1>

    <nav>
        <a href="books.php">Home</a>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">

    <p>
        Welcome,
        <strong>
            <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>
        </strong>
    </p>

    <h2>Available Books</h2>

    <?php if (isset($_SESSION['user_id'])): ?>

        <input
            type="text"
            id="search"
            onkeyup="searchBooks()"
            placeholder="Search by book name..."
        >

        <br><br>

        <div id="results">

            <table>
                <tr>
                    <th>ID</th>
                    <th>Book Name</th>
                    <th>Genre</th>
                    <th>Price (£)</th>
                    <th>View</th>
                </tr>

                <?php foreach ($books as $book): ?>
                <tr>

                    <td><?php echo $book['book_id']; ?></td>

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
                        <a class="btn" href="book_details.php?id=<?php echo $book['book_id']; ?>">
                            View Details
                        </a>
                    </td>

                </tr>
                <?php endforeach; ?>

            </table>

        </div>

    <?php else: ?>

        <div class="book-card">

            <h3>Please Login First</h3>

            <p>
                You must be logged in to view the book catalogue.
            </p>

            <a class="btn" href="login.php">
                Login
            </a>

        </div>

    <?php endif; ?>

</div>

<footer>
    <p>BookHub Library System</p>
</footer>

</body>
</html>
