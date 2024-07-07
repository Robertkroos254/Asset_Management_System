<?php

// login.php (example)
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "ict");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user credentials from the form
$username = $_POST['username'];
$password = $_POST['password'];

// Check the database for the user's credentials
$sql = "SELECT * FROM signup WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User found, fetch role and other details
    $user = $result->fetch_assoc();
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['User_name'] = $user['User_name'];

    // Check if the user is an admin or a regular user
    if ($user['User_name'] == 'admin') {
        echo "<script>alert('Admin Login Successful');</script>";
        header("Location: home.php"); // Redirect to admin dashboard
    } else {
        echo "<script>alert('User Login Successful');</script>";
        header("Location: home.php"); // Redirect to user dashboard
    }
} else {
    echo "<script>alert('Login Failed: Invalid username or password');</script>";
}


$conn->close();
?>