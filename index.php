<?php
// index.php - Manage Books (CRUD)

include 'db.php';

// Handle Create (Add) Book
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publication_year = $_POST['publication_year'];
    $genre = $_POST['genre'];

    $sql = "INSERT INTO books (title, author, publication_year, genre) VALUES (:title, :author, :publication_year, :genre)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['title' => $title, 'author' => $author, 'publication_year' => $publication_year, 'genre' => $genre]);
}

// Handle Update Book
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publication_year = $_POST['publication_year'];
    $genre = $_POST['genre'];

    $sql = "UPDATE books SET title = :title, author = :author, publication_year = :publication_year, genre = :genre WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id, 'title' => $title, 'author' => $author, 'publication_year' => $publication_year, 'genre' => $genre]);
}

// Handle Delete Book
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM books WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
}

// Fetch all books
$sql = "SELECT * FROM books";
$stmt = $pdo->query($sql);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD Book Manager</title>
</head>
<body>
    <h1>Book Manager</h1>

    <!-- Add Book Form -->
    <h2>Add New Book</h2>
    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" name="title" required><br>
        <label for="author">Author:</label>
        <input type="text" name="author" required><br>
        <label for="publication_year">Publication Year:</label>
        <input type="number" name="publication_year" required><br>
        <label for="genre">Genre:</label>
        <input type="text" name="genre"><br>
        <button type="submit" name="add">Add Book</button>
    </form>

    <!-- Books List -->
    <h2>All Books</h2>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Publication Year</th>
            <th>Genre</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($books as $book): ?>
            <tr>
                <td><?php echo htmlspecialchars($book['title']); ?></td>
                <td><?php echo htmlspecialchars($book['author']); ?></td>
                <td><?php echo htmlspecialchars($book['publication_year']); ?></td>
                <td><?php echo htmlspecialchars($book['genre']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $book['id']; ?>">Edit</a> |
                    <a href="?delete=<?php echo $book['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
