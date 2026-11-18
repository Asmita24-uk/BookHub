<?php

session_start();
require 'db.php';

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
</head>
<body>

<h1><?php echo htmlspecialchars($book['book_name']); ?></h1>

<p>
    <strong>Welcome:</strong>
    <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>
</p>

<hr>

<p>
    <strong>Genre:</strong>
    <?php echo htmlspecialchars($book['Genre']); ?>
</p>

<p>
    <strong>Price:</strong>
    £<?php echo number_format($book['price'], 2); ?>
</p>

<p>
    <strong>Total Reviews:</strong>
    <?php echo $totalReviews; ?>
</p>

<hr>

<h2>Reviews</h2>

<?php if ($totalReviews > 0): ?>

    <?php while ($review = $reviews->fetch(PDO::FETCH_ASSOC)): ?>

        <div style="margin-bottom:20px;">

            <strong>
                <?php echo htmlspecialchars($review['username']); ?>
            </strong>

            (<?php echo $review['rating']; ?>/5)

            <br>

            <?php echo htmlspecialchars($review['review_text']); ?>

            <br>

            <small>
                <?php echo $review['review_date']; ?>
            </small>

        </div>

    <?php endwhile; ?>

<?php else: ?>

    <p>No reviews yet.</p>

<?php endif; ?>

<hr>

<h2>Add Review</h2>

<form action="add_review.php" method="POST">

    <input
        type="hidden"
        name="book_id"
        value="<?php echo $book['book_id']; ?>">

    <p>
        Rating:
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

<hr>

<p>
    <a href="books.php">← Back to Books</a>
</p>

<p>
    <a href="logout.php">Logout</a>
</p>

</body>
</html>