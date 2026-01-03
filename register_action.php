<?php
// register_action.php
include("db_config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Collect & sanitize
  $full_name = trim($_POST['full_name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $password = $_POST['password'] ?? '';
  $confirm_password = $_POST['confirm_password'] ?? '';

  // Validation
  if (!$full_name || !$email || !$phone || !$password || !$confirm_password) {
    header("Location: register.php?error=All fields are required");
    exit;
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: register.php?error=Invalid email");
    exit;
  }

  if ($password !== $confirm_password) {
    header("Location: register.php?error=Passwords do not match");
    exit;
  }

  // Check duplicate email
  $stmt = $conn->prepare("SELECT 1 FROM users WHERE email=? LIMIT 1");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows > 0) {
    $stmt->close();
    header("Location: register.php?error=Email already exists");
    exit;
  }
  $stmt->close();

  // Hash password (MD5)
  $password_hashed = md5($password);
  $role = 'user';

  // Insert user
  $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
  $stmt->bind_param("sssss", $full_name, $email, $phone, $password_hashed, $role);

  if ($stmt->execute()) {
    $stmt->close();
    // ✅ Success → go to home page
    header("Location: index.php");
    exit;
  } else {
    $stmt->close();
    header("Location: register.php?error=Failed to register: " . $conn->error);
    exit;
  }
} else {
  // Block direct access
  header("Location: register.php");
  exit;
}
