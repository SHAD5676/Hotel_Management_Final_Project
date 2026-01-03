<?php
include_once('db_config.php');
session_start();

if(!isset($_SESSION['full_name'])){
    header('location:index.php');
    exit;
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header('location:users.php');
    exit;
}

$id = (int)$_GET['id'];

$conn->query("DELETE FROM users WHERE user_id=$id");

$_SESSION['success'] = "User deleted!";
header("Location: users.php");
exit;
