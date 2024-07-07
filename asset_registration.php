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
    $assetType = $_POST['assetType'];
    $assetSerial = $_POST['assetSerial'];
    $supplier = $_POST['supplier'];
    $dateSupply = $_POST['dateSupply'];
    $assetCondition = $_POST['assetCondition'];
    $quantity = $_POST['quantity'];

    // Check if the asset already exists
    $checkQuery = "SELECT * FROM asset_registration WHERE assetSerial = ?";
    if ($stmt = $mysqli->prepare($checkQuery)) {
        $stmt->bind_param('s', $assetSerial);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Asset already exists
            $stmt->close();
            echo "<script>alert('This asset is already registered.');</script>";
            echo "<script>window.location.href = 'asset_registration.html';</script>";
            exit;
        }
        $stmt->close();
    }

    // Prepare and execute the insert query
    $insertQuery = "INSERT INTO asset_registration (assetType, assetSerial, supplier, dateSupply, assetCondition, quantity)
                    VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt = $mysqli->prepare($insertQuery)) {
        $stmt->bind_param('sssssi', $assetType, $assetSerial, $supplier, $dateSupply, $assetCondition, $quantity);
        if ($stmt->execute()) {
            $stmt->close();
            echo "<script>alert('Asset registered successfully.');</script>";
            echo "<script>window.location.href = 'home.html';</script>";
            exit;
        } else {
            echo "<script>alert('Asset registration failed: " . $stmt->error . "');</script>";
            echo "<script>window.location.href = 'asset_registration.html';</script>";
        }
    } else {
        echo "<script>alert('Prepare statement failed: " . $mysqli->error . "');</script>";
        echo "<script>window.location.href = 'asset_registration.html';</script>";
    }
}

// Close the database connection
$mysqli->close();
?>