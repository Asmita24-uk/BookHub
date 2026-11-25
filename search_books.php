<?php
require 'db.php';

$search = $_GET['search'] ?? '';

$stmt = $pdo->prepare("
    SELECT *
    FROM books
    WHERE book_name LIKE ?
");

$stmt->execute(["%$search%"]);

$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

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
            <a class="btn" href="book_details.php?id=<?php echo $book['book_id']; ?>">
                View Details
            </a>
        </td>

    </tr>
    <?php endforeach; ?>

</table>
