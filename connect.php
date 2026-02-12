<?php
session_start();

// Hardcoded email dan password
$username = "admin";
$valid_password = "password"; // Ganti sesuai keinginan

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: login.php?error=username atau password salah!");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>