<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;

if (!$id) {
    die("No book selected.");
}

$stmt = $pdo->prepare(
    "SELECT * FROM books WHERE book_id = ?"
);

$stmt->execute([$id]);

$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    die("Book not found.");
}

$reviews = $pdo->prepare(
    "SELECT
        r.rating,
        r.review_text,
        r.review_date,
        u.username
     FROM reviews r
     JOIN users u
        ON r.user_id = u.id
     WHERE r.book_id = ?
     ORDER BY r.review_date DESC"
);

$reviews->execute([$id]);

$countStmt = $pdo->prepare(
    "SELECT COUNT(*) FROM reviews WHERE book_id = ?"
);

$countStmt->execute([$id]);
$totalReviews = $countStmt->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($book['book_name']); ?></title>
    <link rel="stylesheet" href="style.css?v=800">
</head>

<body>

<header>
    <h1>📚 <?php echo htmlspecialchars($book['book_name']); ?></h1>

    <nav>
        <a href="books.php">Books</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">

    <p>
        <strong>Welcome:</strong>
        <?php echo htmlspecialchars($_SESSION['username']); ?>
    </p>

    <div class="book-card">

        <p>
            <strong>Genre:</strong>
            <?php echo htmlspecialchars($book['Genre']); ?>
        </p>

        <p>
            <strong>Price:</strong>
            £<?php echo number_format($book['price'], 2); ?>
        </p>

        <p>
            <strong>Author:</strong>
            <?php echo htmlspecialchars($book['author']); ?>
        </p>

        <p>
            <strong>Description:</strong><br>
            <?php echo htmlspecialchars($book['description']); ?>
        </p>

        <p>
            <strong>Date Released:</strong>
            <?php echo htmlspecialchars($book['Date_of_release']); ?>
        </p>

        <p>
            <strong>Total Reviews:</strong>
            <?php echo $totalReviews; ?
