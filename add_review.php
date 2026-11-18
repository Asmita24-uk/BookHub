<?php

session_start();
require 'db.php';

/*
   User must be logged in
*/
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

<!DOCTYPE html>
<html>
<head>
    <title>Add Review</title>
</head>
<body>

<h1>Add Review</h1>

<form method="POST">

    <p>
        Book ID:
        <br>
        <input type="number" name="book_id" required>
    </p>

    <p>
        Rating:
        <br>
        <select name="rating" required>
            <option value="1">1 Star</option>
            <option value="2">2 Stars</option>
            <option value="3">3 Stars</option>
            <option value="4">4 Stars</option>
            <option value="5">5 Stars</option>
        </select>
    </p>

    <p>
        Review:
        <br>
        <textarea
            name="review"
            rows="5"
            cols="50"
            required></textarea>
    </p>

    <button type="submit">
        Submit Review
    </button>

</form>

</body>
</html>