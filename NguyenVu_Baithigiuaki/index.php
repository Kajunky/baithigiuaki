<?php
$mysqli = new mysqli("localhost", "root", "", "thuvien");

$sort_order = isset($_GET['sort']) ? $_GET['sort'] : null;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$results_per_page = 5;
$offset = ($page - 1) * $results_per_page;

$total_query = "SELECT COUNT(*) as total FROM books 
                LEFT JOIN authors ON books.author_id = authors.id 
                LEFT JOIN categories ON books.category_id = categories.id";

$total_result = $mysqli->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $results_per_page);

$query = "SELECT books.id, books.title, authors.author_name, categories.category_name, books.publisher, books.publish_year, books.quantity 
          FROM books 
          LEFT JOIN authors ON books.author_id = authors.id 
          LEFT JOIN categories ON books.category_id = categories.id";

if (!empty($search)) {
    $query .= " WHERE books.title LIKE '%$search%' 
                OR authors.author_name LIKE '%$search%' 
                OR categories.category_name LIKE '%$search%'";
}

if ($sort_order === 'asc') {
    $query .= " ORDER BY authors.author_name ASC";
} elseif ($sort_order === 'desc') {
    $query .= " ORDER BY authors.author_name DESC";
}

$query .= " LIMIT $results_per_page OFFSET $offset";
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="styless.css">
</head>

<body class="idex-body">
<div class="container mt-5">
    <h1 class="text-center text-warning">Library Management</h1><br>
    <div class="row">
        <div class="col-2">
            <form method="GET" action="index.php">
                <div class="input-group">
                    <select style="max-width: 100% !important;" class="form-select" id="sort" name="sort" onchange="this.form.submit()">
                        <option disabled selected>Sort by</option>
                        <option value="asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'asc') echo 'selected'; ?>>Low to High</option>
                        <option value="desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'desc') echo 'selected'; ?>>High to Low</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="col-6">
            <button class="custom-btn btn-10"><a href="add_book.php" class="btn">Add Book</a></button>
            <button class="custom-btn btn-10"><a href="add_authors.php" class="btn">Authors</a></button>
            <button class="custom-btn btn-10"><a href="add_categories.php" class="btn">Categories</a></button>
        </div>
        <div class="col-4"></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4"></div>
        <div class="col-4">
            <form method="GET" action="index.php" class="d-flex" role="search">
                <div class="input-group">
                    <input type="text" aria-label="Search" name="search" class="form-control me-2" placeholder="Search..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                    <button class="btn btn-primary " type="submit">Search</button>        
                </div>
            </form>
        </div>
    </div> 

    <div class="row pt-3">
        <div class="col-12">
            <table class="table table-dark table-hover ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Book Title</th>
                        <th>Authors</th>
                        <th>Categories</th>
                        <th>Publisher</th>
                        <th>Year</th>
                        <th>Number</th>
                        <th>Edit</th> 
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $mysqli->set_charset("utf8");

                    $search = isset($_GET['search']) ? $mysqli->real_escape_string($_GET['search']) : '';
                    $query = "SELECT books.id, books.title, authors.author_name, categories.category_name, books.publisher, books.publish_year, books.quantity 
                            FROM books 
                            LEFT JOIN authors ON books.author_id = authors.id 
                            LEFT JOIN categories ON books.category_id = categories.id";

                    if (!empty($search)) {
                        $query .= " WHERE books.title LIKE '%$search%' 
                                    OR authors.author_name LIKE '%$search%' 
                                    OR categories.category_name LIKE '%$search%'";
                    }

                    if ($sort_order) {
                        if ($sort_order === 'asc') {
                            $query .= " ORDER BY authors.author_name ASC";
                        } elseif ($sort_order === 'desc') {
                            $query .= " ORDER BY authors.author_name DESC";
                        }
                    }

                    $query .= " LIMIT $results_per_page OFFSET $offset";
                    $result = $mysqli->query($query);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['title']}</td>
                                    <td>{$row['author_name']}</td>
                                    <td>{$row['category_name']}</td>
                                    <td>{$row['publisher']}</td>
                                    <td>{$row['publish_year']}</td>
                                    <td>{$row['quantity']}</td>
                                    <td>
                                        <button class='bt-sua'>
                                            <a href='edit_book.php?id={$row['id']}' class='btn'>Edit</a>
                                        </button>
                                    </td>
                                    <td>
                                        <button class='bt-xoa'>
                                            <span><a href='delete.php?id={$row['id']}&page=$page&sort=$sort_order' class='btn' onclick=\"return confirm('Are you sure you want to delete this book?');\">Delete</a></span>
                                        </button>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>No books found</td></tr>";
                    }
                    $mysqli->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?page=<?php echo $page - 1; ?>&sort=<?php echo $sort_order; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                    <a class="page-link" href="index.php?page=<?php echo $i; ?>&sort=<?php echo $sort_order; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?page=<?php echo $page + 1; ?>&sort=<?php echo $sort_order; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav><br><br><br>

</div>

<script>

    $('#resetSearch').click(function() {
        window.location.href = 'index.php';
    });
</script>
</body>
</html>
