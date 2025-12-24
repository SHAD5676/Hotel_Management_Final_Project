<?php
// delete_category.php
include_once('db_config.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit;
}

// Validate category ID from GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  $_SESSION['error'] = "Invalid category ID.";
  header('Location: categories.php');
  exit;
}

$category_id = intval($_GET['id']);

// Optional: Check if any room uses this category to prevent deletion
$stmt_check = $conn->prepare("SELECT COUNT(*) AS total FROM rooms WHERE category_id = ?");
$stmt_check->bind_param("i", $category_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$row_check = $result_check->fetch_assoc();

if ($row_check['total'] > 0) {
  $_SESSION['error'] = "Cannot delete this category because there are rooms assigned to it.";
  $stmt_check->close();
  header('Location: categories.php');
  exit;
}
$stmt_check->close();

// Delete the category
$stmt = $conn->prepare("DELETE FROM room_categories WHERE category_id = ?");
$stmt->bind_param("i", $category_id);

if ($stmt->execute()) {
  $_SESSION['success'] = "Category deleted successfully.";
} else {
  $_SESSION['error'] = "Failed to delete the category.";
}

$stmt->close();
$conn->close();

header('Location: room_categories.php');
exit;
