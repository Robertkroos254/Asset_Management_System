<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Status</title>
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container-status {
            max-width: 90%;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #4CAF50; /* Changed color to green */
            font-size: 35px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4CAF50; /* Changed background color to green */
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: coral;
            color: coral;
        }
    </style>
</head>
<body>

<div class="container-status">
    <h1>Asset Status</h1>
    <table id="assetTable">
        <thead>
            <tr>
                <th>Staff Number</th>
                <th>Asset Type</th>
                <th>Asset Model</th>
                <th>Asset Serial Number</th>
                <th>Asset Specification</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "ict";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch staff data
            $staffSql = "SELECT firstName, lastName, staffNumber FROM signup";
            $staffResult = $conn->query($staffSql);

            if ($staffResult) {
                if ($staffResult->num_rows > 0) {
                    while($staff = $staffResult->fetch_assoc()) {
                        // Fetch laptop data
                        $laptopSql = "SELECT 'Laptop' AS assetType, laptopmodel AS assetModel, laptopserial AS assetSerial, laptopspec AS assetSpec 
                                      FROM laptop WHERE staffNumber = '". $staff["staffNumber"] ."'";
                        $laptopResult = $conn->query($laptopSql);
                        if ($laptopResult && $laptopResult->num_rows > 0) {
                            while($laptop = $laptopResult->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($staff["staffNumber"]) . "</td>
                                        <td>" . htmlspecialchars($laptop["assetType"]) . "</td>
                                        <td>" . htmlspecialchars($laptop["assetModel"]) . "</td>
                                        <td>" . htmlspecialchars($laptop["assetSerial"]) . "</td>
                                        <td>" . htmlspecialchars($laptop["assetSpec"]) . "</td>
                                      </tr>";
                            }
                        }
                        // Fetch desktop data
                        $desktopSql = "SELECT 'Desktop' AS assetType, desktopmodel AS assetModel, desktopserial AS assetSerial, desktopspec AS assetSpec 
                                       FROM desktop WHERE staffNumber = '". $staff["staffNumber"] ."'";
                        $desktopResult = $conn->query($desktopSql);
                        if ($desktopResult && $desktopResult->num_rows > 0) {
                            while($desktop = $desktopResult->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($staff["staffNumber"]) . "</td>
                                        <td>" . htmlspecialchars($desktop["assetType"]) . "</td>
                                        <td>" . htmlspecialchars($desktop["assetModel"]) . "</td>
                                        <td>" . htmlspecialchars($desktop["assetSerial"]) . "</td>
                                        <td>" . htmlspecialchars($desktop["assetSpec"]) . "</td>
                                      </tr>";
                            }
                        }
                        // Fetch tablet data
                        $tabletSql = "SELECT 'Tablet' AS assetType, tabletmodel AS assetModel, tabletserial AS assetSerial, tabletspec AS assetSpec 
                                      FROM tablet WHERE staffNumber = '". $staff["staffNumber"] ."'";
                        $tabletResult = $conn->query($tabletSql);
                        if ($tabletResult && $tabletResult->num_rows > 0) {
                            while($tablet = $tabletResult->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($staff["staffNumber"]) . "</td>
                                        <td>" . htmlspecialchars($tablet["assetType"]) . "</td>
                                        <td>" . htmlspecialchars($tablet["assetModel"]) . "</td>
                                        <td>" . htmlspecialchars($tablet["assetSerial"]) . "</td>
                                        <td>" . htmlspecialchars($tablet["assetSpec"]) . "</td>
                                      </tr>";
                            }
                        }
                        // Fetch other assets data
                        $otherAssetSql = "SELECT 'Other' AS assetType, assetmodel AS assetModel, assetserial AS assetSerial, assetspec AS assetSpec 
                                          FROM otherasset WHERE staffNumber = '". $staff["staffNumber"] ."'";
                        $otherAssetResult = $conn->query($otherAssetSql);
                        if ($otherAssetResult && $otherAssetResult->num_rows > 0) {
                            while($otherAsset = $otherAssetResult->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($staff["staffNumber"]) . "</td>
                                        <td>" . htmlspecialchars($otherAsset["assetType"]) . "</td>
                                        <td>" . htmlspecialchars($otherAsset["assetModel"]) . "</td>
                                        <td>" . htmlspecialchars($otherAsset["assetSerial"]) . "</td>
                                        <td>" . htmlspecialchars($otherAsset["assetSpec"]) . "</td>
                                      </tr>";
                            }
                        }
                    }
                } else {
                    echo "<tr><td colspan='5'>No results found</td></tr>";
                }
            } else {
                echo "Error: " . $conn->error;
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<!-- Include jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#assetTable').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>

</body>
</html>
