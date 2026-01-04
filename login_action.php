<?php
// login_action.php
session_start();
include("db_config.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: login.php");
  exit;
}

// Get inputs (MATCHES FORM)
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

// Validation
if ($username === '' || $password === '') {
  header("Location: login.php?error=All fields are required");
  exit;
}

// Hash password (MD5 — for existing DB)
$password_hashed = md5($password);

// Prepare query
$sql = "SELECT id, full_name, role 
        FROM users 
        WHERE (email = ? OR full_name = ?) 
        AND password = ? 
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $username, $password_hashed);
$stmt->execute();
$result = $stmt->get_result();

// Check user
if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();

  // Store session
  $_SESSION['user_id']   = $user['id'];
  $_SESSION['full_name'] = $user['full_name'];
  $_SESSION['role']      = $user['role'];

  // Redirect by role
  if ($user['role'] === 'admin') {
    header("Location: admin/index.php");
  } else {
    header("Location: index.php");
  }
  exit;
}

// Login failed
header("Location: login.php?error=Invalid email/name or password");
exit;
