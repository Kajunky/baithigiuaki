<?php
$mysqli = new mysqli("localhost", "root", "", "thuvien");

$id = $_GET['id'];
$mysqli->query("DELETE FROM books WHERE id=$id");

$mysqli->query("SET @autoid = 0");
$mysqli->query("UPDATE books SET id = @autoid := (@autoid + 1)");
$mysqli->query("ALTER TABLE books AUTO_INCREMENT = 1");

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : '';

header("Location: index.php?page=$page&sort=$sort_order&deleted=true");
exit();
?>
