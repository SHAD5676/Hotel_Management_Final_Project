<?php
// delete_room.php
include_once('db_config.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit;
}

// Validate room_id from GET
if (!isset($_GET['room_id']) || !is_numeric($_GET['room_id'])) {
  $_SESSION['error'] = "Invalid room ID.";
  header('Location: room.php');
  exit;
}

$room_id = intval($_GET['room_id']);

// Delete associated images from filesystem and database
$img_stmt = $conn->prepare("SELECT image_url FROM room_images WHERE room_id = ?");
$img_stmt->bind_param("i", $room_id);
$img_stmt->execute();
$img_stmt->bind_result($image_url);

while ($img_stmt->fetch()) {
  if (file_exists($image_url)) {
    unlink($image_url); // delete file from server
  }
}
$img_stmt->close();

// Delete images from database
$del_img_stmt = $conn->prepare("DELETE FROM room_images WHERE room_id = ?");
$del_img_stmt->bind_param("i", $room_id);
$del_img_stmt->execute();
$del_img_stmt->close();

// Delete room
$stmt = $conn->prepare("DELETE FROM rooms WHERE room_id = ?");
$stmt->bind_param("i", $room_id);

if ($stmt->execute()) {
  $_SESSION['success'] = "Room and associated images deleted successfully.";
} else {
  $_SESSION['error'] = "Failed to delete the room.";
}

$stmt->close();
$conn->close();

// Redirect back to the rooms list
header('Location: room.php');
exit;
