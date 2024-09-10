<?php
$mysqli = new mysqli("localhost", "root", "", "thuvien");

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $mysqli->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();

   
    // $mysqli->query("SET @categoriesd = 0");
    // $mysqli->query("UPDATE categories SET id = @categoriesd := (@categoriesd + 1)");
    // $mysqli->query("ALTER TABLE categories AUTO_INCREMENT = 1");

    header("Location: add_categories.php?page=".$_GET['page']."&deleted=true");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];

    if (!empty($category_name)) {
        $stmt = $mysqli->prepare("INSERT INTO categories (category_name) VALUES (?)");
        $stmt->bind_param("s", $category_name);
        $stmt->execute();
        $success_message = "You've successfully added a category";
    } else {
        $error_message = "Please fill in the category name";
    }
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$results_per_page = 5;
$offset = ($page - 1) * $results_per_page;

$total_query = "SELECT COUNT(*) as total FROM categories";
$total_result = $mysqli->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $results_per_page);

$query = "SELECT * FROM categories LIMIT $results_per_page OFFSET $offset";
$categories = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="styless.css">
</head>
<body class="add-category">
<div class="container mt-5">
    <div class="add-category-full">
    <h1 class="text-center text-warning">Categories</h1>

    <button type="button" class=" custom-btn btn-10" id="resetPage"><i class="bi bi-arrow-left"></i></button>
    <hr>

    <form method="POST" action="add_categories.php">
        <div class="mb-3">
            <label for="category_name" class="form-label">Categories's Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" required>
        </div>
        <button class="custom-btn btn-10">Add</button>
    </form><br>
    
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <h2 class="mt-5 text-warning">List of Categories</h2>
    <table class="table table table-dark table-hover mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Author's Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($category = $categories->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $category['id']; ?></td>
                    <td><?php echo $category['category_name']; ?></td>
                    <td>
                        <button class='bt-xoa'>
                            <span><a href="add_categories.php?delete_id=<?php echo $category['id']; ?>&page=<?php echo $page; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a></span>
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="add_categories.php?page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                    <a class="page-link" href="add_categories.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="add_categories.php?page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    </div>
</div>

<script>
    $('#resetPage').click(function() {
        window.location.href = 'index.php';
    });
</script>
</body>
</html>
