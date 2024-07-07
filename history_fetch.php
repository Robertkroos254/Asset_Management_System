<?php
// Database connection details
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

// Fetch data from asset_registration table
$query = "SELECT * FROM asset_registration";
$result = $mysqli->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Registration Data</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Asset Registration History</h1>
    
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>Asset Type</th>
                <th>Asset Serial</th>
                <th>Supplier</th>
                <th>Date Supply</th>
                <th>Asset Condition</th>
                <th>Quantity</th>
              </tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['assetType']) . "</td>";
            echo "<td>" . htmlspecialchars($row['assetSerial']) . "</td>";
            echo "<td>" . htmlspecialchars($row['supplier']) . "</td>";
            echo "<td>" . htmlspecialchars($row['dateSupply']) . "</td>";
            echo "<td>" . htmlspecialchars($row['assetCondition']) . "</td>";
            echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "No data found in the asset_registration table.";
    }
    
    // Close the database connection
    $mysqli->close();
    ?>
</body>
</html>