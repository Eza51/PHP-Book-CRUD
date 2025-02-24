<?php
// edit.php - Edit Book

include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the book data to edit
    $sql = "SELECT * FROM books WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['update'])) {
    // Update book details
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publication_year = $_POST['publication_year'];
    $genre = $_POST['genre'];

    $sql = "UPDATE books SET title = :title, author = :author, publication_year = :publication_year, genre = :genre WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id, 'title' => $title, 'author' => $author, 'publication_year' => $publication_year, 'genre' => $genre]);
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
</head>
<body>
    <h1>Edit Book</h1>

    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required><br>
        <label for="author">Author:</label>
        <input type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required><br>
        <label for="publication_year">Publication Year:</label>
        <input type="number" name="publication_year" value="<?php echo htmlspecialchars($book['publication_year']); ?>" required><br>
        <label for="genre">Genre:</label>
        <input type="text" name="genre" value="<?php echo htmlspecialchars($book['genre']); ?>"><br>
        <button type="submit" name="update">Update Book</button>
    </form>
</body>
</html>
