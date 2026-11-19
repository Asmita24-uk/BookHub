<?php
session_start();
require 'db.php';

/* User must be logged in */
if (!isset($_SESSION['user_id'])) {
    die("Please login before adding a review.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $book_id = $_POST['book_id'];
    $rating = $_POST['rating'];
    $review = trim($_POST['review']);
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare(
        "INSERT INTO reviews
        (book_id, user_id, rating, review_text)
        VALUES (?, ?, ?, ?)"
    );

    $stmt->execute([
        $book_id,
        $user_id,
        $rating,
        $review
    ]);

    header("Location: book_details.php?id=" . $book_id);
    exit();
}
?>
