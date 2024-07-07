<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ict";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $assetSerial = $_POST["assetSerial"];
    $Deletedate = $_POST["Deletedate"];
    $description = $_POST["description"];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Delete from faulty table
        $deleteSql = "DELETE FROM faulty WHERE assetSerial = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param('s', $assetSerial);
        $deleteStmt->execute();

        // Insert into delete_log table
        $logSql = "INSERT INTO delete_log (assetSerial, Deletedate, description) VALUES (?, ?, ?)";
        $logStmt = $conn->prepare($logSql);
        $logStmt->bind_param("sss", $assetSerial, $Deletedate, $description);
        $logStmt->execute();

        // Commit transaction
        $conn->commit();

        echo "<script>alert('Deleted Successful.');</script>";
        echo "<script>window.location.href = 'home.html';</script>";
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo 'error';
    }

    $deleteStmt->close();
    $logStmt->close();
    exit(); // Exit to prevent further HTML output
}
?>