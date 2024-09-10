<?php
$mysqli = new mysqli("localhost", "root", "", "thuvien");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author_id = $_POST['author_id'];
    $category_id = $_POST['category_id'];
    $publisher = $_POST['publisher'];
    $publish_year = $_POST['publish_year'];
    $quantity = $_POST['quantity'];

    if (!empty($title) && !empty($author_id) && !empty($category_id) && !empty($publisher) && !empty($publish_year) && !empty($quantity)) {
        $stmt = $mysqli->prepare("UPDATE books SET title=?, author_id=?, category_id=?, publisher=?, publish_year=?, quantity=? WHERE id=?");
        $stmt->bind_param("siissii", $title, $author_id, $category_id, $publisher, $publish_year, $quantity, $id);
        $stmt->execute();
        $success_message = "You've successfully updated your books";
    } else {
        $error_message = "Please fill in all the information";
    }
}

$id = $_GET['id'];
$query = $mysqli->prepare("SELECT * FROM books WHERE id=?");
$query->bind_param("i", $id);
$query->execute();
$book = $query->get_result()->fetch_assoc();

$authors = $mysqli->query("SELECT * FROM authors");
$categories = $mysqli->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="styless.css">
</head>
<body class="edit-book">
<div class="container mt-5">
    <div class="edit-book-full">
    <h1 class="text-center text-warning">Edit Book Information</h1>

    <button type="button" class=" custom-btn btn-10" id="resetPage"><i class="bi bi-arrow-left"></i></button>
    <hr>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="edit_book.php?id=<?php echo $id; ?>">
        <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
        
        <div class="mb-3">
            <label for="title" class="form-label">Book Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $book['title']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="author_id" class="form-label">Authors</label>
            <select class="form-select" id="author_id" name="author_id" required>
                <?php while($author = $authors->fetch_assoc()): ?>
                    <option value="<?php echo $author['id']; ?>" <?php echo ($author['id'] == $book['author_id']) ? 'selected' : ''; ?>><?php echo $author['author_name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Categories</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <?php while($category = $categories->fetch_assoc()): ?>
                    <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $book['category_id']) ? 'selected' : ''; ?>><?php echo $category['category_name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="publisher" class="form-label">Publisher</label>
            <input type="text" class="form-control" id="publisher" name="publisher" value="<?php echo $book['publisher']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="publish_year" class="form-label">Year</label>
            <input type="number" class="form-control" id="publish_year" name="publish_year" value="<?php echo $book['publish_year']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Number</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $book['quantity']; ?>" required>
        </div>
        <button class="custom-btn btn-10"><span>Update</span></button>
    </form>
    </div>
</div>
<script>
    $('#resetPage').click(function() {
        window.location.href = 'index.php';
    });
</script>
</body>
</html>
