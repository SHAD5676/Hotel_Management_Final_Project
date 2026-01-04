<?php
session_start();
include("db_config.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: register.php");
  exit;
}

$full_name = trim($_POST['full_name'] ?? '');
$email     = trim($_POST['email'] ?? '');
$phone     = trim($_POST['phone'] ?? '');
$password  = $_POST['password'] ?? '';
$confirm   = $_POST['confirm_password'] ?? '';

if ($full_name === '' || $email === '' || $phone === '' || $password === '' || $confirm === '') {
  header("Location: register.php?error=All fields are required");
  exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  header("Location: register.php?error=Invalid email address");
  exit;
}

if ($password !== $confirm) {
  header("Location: register.php?error=Passwords do not match");
  exit;
}

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  $stmt->close();
  header("Location: register.php?error=Email already exists");
  exit;
}
$stmt->close();

$password_hashed = md5($password);
$role = 'user';

$stmt = $conn->prepare(
  "INSERT INTO users (full_name, email, phone, password, role, created_at, updated_at)
   VALUES (?, ?, ?, ?, ?, NOW(), NOW())"
);

$stmt->bind_param("sssss", $full_name, $email, $phone, $password_hashed, $role);

if ($stmt->execute()) {

  $_SESSION['user_id']   = $stmt->insert_id;
  $_SESSION['full_name'] = $full_name;
  $_SESSION['role']      = $role;

  $stmt->close();
  header("Location: index.php");
  exit;
}

$stmt->close();
header("Location: register.php?error=Registration failed");
exit;
