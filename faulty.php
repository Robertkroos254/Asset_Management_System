<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish connection to your database
    $conn = new mysqli("localhost", "root", "", "ict");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the parameters
    $assetSerial = $_POST['assetSerial'];
    $faultDate = $_POST['faultDate'];
    $description = $_POST['description'];

    // Check if the asset exists in the laptop, desktop, tablet, or asset_registration tables
    $assetExists = false;

    // Check in the laptop table
    $laptopCheckSql = "SELECT * FROM laptop WHERE laptopserial = ?";
    $stmt = $conn->prepare($laptopCheckSql);
    $stmt->bind_param("s", $assetSerial);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $assetExists = true;
    }

    // Check in the desktop table
    if (!$assetExists) {
        $desktopCheckSql = "SELECT * FROM desktop WHERE desktopserial = ?";
        $stmt = $conn->prepare($desktopCheckSql);
        $stmt->bind_param("s", $assetSerial);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $assetExists = true;
        }
    }

    // Check in the tablet table
    if (!$assetExists) {
        $tabletCheckSql = "SELECT * FROM tablet WHERE tabletserial = ?";
        $stmt = $conn->prepare($tabletCheckSql);
        $stmt->bind_param("s", $assetSerial);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $assetExists = true;
        }
    }

    // Check in the asset_registration table
    if (!$assetExists) {
        $assetRegistrationCheckSql = "SELECT * FROM asset_registration WHERE assetSerial = ?";
        $stmt = $conn->prepare($assetRegistrationCheckSql);
        $stmt->bind_param("s", $assetSerial);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $assetExists = true;
        }
    }

    // If the asset exists, insert into the faulty table
    if ($assetExists) {
        $insertFaultySql = "INSERT INTO faulty (assetSerial, faultDate, description) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertFaultySql);
        if ($stmt === false) {
            die("Error in preparing the statement: " . $conn->error);
        }
        $stmt->bind_param("sss", $assetSerial, $faultDate, $description);

        if ($stmt->execute() === TRUE) {
            echo "<script>alert('Faulty Asset Registered Successfully.');</script>";
            echo "<script>window.location.href = 'home.html';</script>";
            exit;
        } else {
            echo "<script>alert('Faulty Registration Failed: " . $stmt->error . "');</script>";
            echo "<script>window.location.href = 'home.html';</script>";
        }
    } else {
        echo "<script>alert('Asset Doesn't Exist.');</script>";
        echo "<script>window.location.href = 'home.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>