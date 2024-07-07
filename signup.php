<?php

// Establishing database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'ict';

// Create a connection
$mysqli = new mysqli($host, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Assuming you have received form data via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $User_name = $_POST['User_name'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $staffNumber = $_POST['staffNumber'];
    $department = $_POST['department'];
    $subDepartment = $_POST['subDepartment'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $gender = $_POST['gender'];

    // Determine role based on User_name
    $role = ($User_name == 'admin') ? 'admin' : 'user';

    // Check if the user already exists
    $checkQuery = "SELECT * FROM signup WHERE staffNumber = ?";
    if ($stmt = $mysqli->prepare($checkQuery)) {
        $stmt->bind_param('i', $staffNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // User already exists
            $stmt->close();
            echo "<script>alert('This user is already registered.');</script>";
            echo "<script>window.location.href = 'home.html';</script>";
            exit;
        }
        $stmt->close();
    }

    // Prepare and execute the insert query
    $insertQuery = "INSERT INTO signup (User_name, firstName, lastName, staffNumber, department, subDepartment, email, username, password, confirmPassword, gender, role)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = $mysqli->prepare($insertQuery)) {
        $stmt->bind_param('sssissssssss', $User_name, $firstName, $lastName, $staffNumber, $department, $subDepartment, $email, $username, $password, $confirmPassword, $gender, $role);
        if ($stmt->execute()) {
            $stmt->close();
            echo "<script>alert('New User registered successfully.');</script>";
            echo "<script>window.location.href = 'home.html';</script>";
            exit;
        } else {
            echo "<script>alert('User registration failed: " . $stmt->error . "');</script>";
            echo "<script>window.location.href = 'home.html';</script>";
        }
    } else {
        echo "<script>alert('Prepare statement failed: " . $mysqli->error . "');</script>";
        echo "<script>window.location.href = 'home.html';</script>";
    }
}

// Close the database connection
$mysqli->close();
?>
