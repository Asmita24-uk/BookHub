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

$stmt = $pdo->prepare("SELECT * FROM books WHERE book_id = ?");
$stmt->execute([$id]);

$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    die("Book not found.");
}

$reviews = $pdo->prepare("
    SELECT
        r.rating,
        r.review_text,
        u.username
    FROM reviews r
    JOIN users u ON r.user_id = u.id
    WHERE r.book_id = ?
    ORDER BY r.review_id DESC
");

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
    <link rel="stylesheet" href="style.css?v=900">
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
            <?php echo $totalReviews; ?>
        </p>

    </div>

    <h2>⭐ Reviews</h2>

    <?php if ($totalReviews > 0): ?>

        <?php while ($review = $reviews->fetch(PDO::FETCH_ASSOC)): ?>

            <div class="review">

                <strong>
                    <?php echo htmlspecialchars($review['username']); ?>
                </strong>

                (<?php echo $review['rating']; ?>/5)

                <p>
                    <?php echo htmlspecialchars($review['review_text']); ?>
                </p>

            </div>

        <?php endwhile; ?>

    <?php else: ?>

        <p>No reviews yet.</p>

    <?php endif; ?>

    <h2>Add Review</h2>

    <form action="add_review.php" method="POST">

        <input
            type="hidden"
            name="book_id"
            value="<?php echo $book['book_id']; ?>">

        <label for="rating">Rating</label>

        <select id="rating" name="rating" required>
            <option value="1">1 Star</option>
            <option value="2">2 Stars</option>
            <option value="3">3 Stars</option>
            <option value="4">4 Stars</option>
            <option value="5">5 Stars</option>
        </select>

        <label for="review">Review</label>

        <textarea
            id="review"
            name="review"
            rows="4"
            required></textarea>

        <button type="submit">
            Submit Review
        </button>

    </form>

    <br>

    <a class="btn" href="books.php">
        Back to Books
    </a>

    <a class="btn" href="logout.php">
        Logout
    </a>

</div>

<footer>
    <p>BookHub Library System</p>
</footer>

</body>
</html>
