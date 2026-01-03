<?php
// login_action.php
include("db_config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  // Basic validation
  if (!$username || !$password) {
    header("Location: login.php?error=All fields are required");
    exit;
  }

  // Hash the password to match your database (MD5)
  $password_hashed = md5($password);

  // Fetch user by username/email and password
  $stmt = $conn->prepare("SELECT id, full_name, role FROM users WHERE (email = ? OR full_name = ?) AND password = ? LIMIT 1");
  $stmt->bind_param("sss", $username, $username, $password_hashed);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows === 1) {
    $stmt->bind_result($user_id, $full_name, $role);
    $stmt->fetch();

    // Set session
    $_SESSION['user_id'] = $user_id;
    $_SESSION['full_name'] = $full_name;
    $_SESSION['role'] = $role;

    $stmt->close();

    // Redirect based on role
    if ($role === 'admin') {
      header("Location: admin/index.php");
    } else {
      header("Location: index.php");
    }
    exit;
  } else {
    $stmt->close();
    header("Location: login.php?error=Invalid username or password");
    exit;
  }
} else {
  header("Location: login.php");
  exit;
}
