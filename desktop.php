<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish connection to your database
    $conn = new mysqli("localhost", "root", "", "ict");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Set parameters
    $desktopmodel = $_POST['desktopmodel'];
    $desktopserial = $_POST['desktopserial'];
    $desktopspec = $_POST['desktopspec'];
    $staffNumber = $_POST['staffNumber'];

    // Check if the asset is registered
    $check_asset_stmt = $conn->prepare("SELECT * FROM asset_registration WHERE assetSerial = ?");
    $check_asset_stmt->bind_param("s", $desktopserial);
    $check_asset_stmt->execute();
    $check_asset_result = $check_asset_stmt->get_result();

    if ($check_asset_result->num_rows == 0) {
        echo "<script>alert('This asset has not been registered.');</script>";
        echo "<script>window.location.href = 'home.html';</script>";
    } else {
        // Check if the asset is already issued
        $check_stmt = $conn->prepare("SELECT * FROM desktop WHERE desktopserial = ?");
        $check_stmt->bind_param("s", $desktopserial);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo "<script>alert('This Desktop has already issued to a staff member.');</script>";
            echo "<script>window.location.href = 'home.html';</script>";
        } else {
            // Check if the staff member already has a desktop
            $staff_check_stmt = $conn->prepare("SELECT * FROM desktop WHERE staffNumber = ?");
            $staff_check_stmt->bind_param("i", $staffNumber);
            $staff_check_stmt->execute();
            $staff_check_result = $staff_check_stmt->get_result();

            if ($staff_check_result->num_rows > 0) {
                echo "<script>alert('This staff member already has a laptop assigned.');</script>";
                echo "<script>window.location.href = 'home.html';</script>";
            } else {
                // Prepare and bind parameters for insertion
                $stmt = $conn->prepare("INSERT INTO desktop (desktopmodel, desktopserial, desktopspec, staffNumber) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sssi", $desktopmodel, $desktopserial, $desktopspec, $staffNumber);

                // Execute the insert statement
                if ($stmt->execute() === TRUE) {
                    echo "<script>alert('Desktop Issued Successfully');</script>";
                    echo "<script>window.location.href = 'home.html';</script>";
                } else {
                    echo "<script>alert('Desktop Issuing Failed: " . $stmt->error . "');</script>";
                    echo "<script>window.location.href = 'home.html';</script>";
                }

                $stmt->close();
            }
            $staff_check_stmt->close();
        }
        $check_stmt->close();
    }

    $check_asset_stmt->close();
    $conn->close();
}
?>