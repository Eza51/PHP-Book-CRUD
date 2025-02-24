<?php
// index.php - Manage Books (CRUD with Pagination and Validation)

include 'db.php';

// Pagination settings
$books_per_page = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $books_per_page;

// Handle Create (Add) Book with Validation
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publication_year = $_POST['publication_year'];
    $genre = $_POST['genre'];

    // Form validation
    if (empty($title) || empty($author) || empty($publication_year)) {
        $error_message = "Title, Author, and Publication Year are required.";
    } elseif (!is_numeric($publication_year) || strlen($publication_year) != 4) {
        $error_message = "Please enter a valid 4-digit publication year.";
    } else {
        // Save the book to the database
        $sql = "INSERT INTO books (title, author, publication_year, genre) VALUES (:title, :author, :publication_year, :genre)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['title' => $title, 'author' => $author, 'publication_year' => $publication_year, 'genre' => $genre]);
        $success_message = "Book added successfully!";
    }
}

// Handle Update Book with Validation
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publication_year = $_POST['publication_year'];
    $genre = $_POST['genre'];

    // Form validation
    if (empty($title) || empty($author) || empty($publication_year)) {
        $error_message = "Title, Author, and Publication Year are required.";
    } elseif (!is_numeric($publication_year) || strlen($publication_year) != 4) {
        $error_message = "Please enter a valid 4-digit publication year.";
    } else {
        // Update the book in the database
        $sql = "UPDATE books SET title = :title, author = :author, publication_year = :publication_year, genre = :genre WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id, 'title' => $title, 'author' => $author, 'publication_year' => $publication_year, 'genre' => $genre]);
        $success_message = "Book updated successfully!";
    }
}

// Handle Delete Book
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM books WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $success_message = "Book deleted successfully!";
}

// Fetch paginated books
$sql = "SELECT * FROM books LIMIT :offset, :books_per_page";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':books_per_page', $books_per_page, PDO::PARAM_INT);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch total books for pagination
$total_books_query = "SELECT COUNT(*) FROM books";
$total_books_stmt = $pdo->query($total_books_query);
$total_books = $total_books_stmt->fetchColumn();
$total_pages = ceil($total_books / $books_per_page);

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

    <!-- Success or Error Messages -->
    <?php if (isset($success_message)): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php elseif (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

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

    <!-- Pagination -->
    <div>
        <h3>Pagination</h3>
        <ul>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
        </ul>
    </div>
</body>
</html>
