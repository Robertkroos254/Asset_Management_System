<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Asset Details</title>
    
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Include AOS CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 10px;
            background-color: #f4f4f4;
            position: relative;
            min-height: 100vh;
            margin: 0;
        }
        .container-dep {
            max-width: 90%;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
        }
        .container-dep.visible {
            opacity: 1;
            transform: translateY(0);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #0078d4;
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
            background-color: #0078d4;
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

<div class="container-dep" data-aos="fade-up">
    <h1>Employee Asset Details</h1>
    <table id="assetTable">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
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
                                        <td>" . htmlspecialchars($staff["firstName"]) . "</td>
                                        <td>" . htmlspecialchars($staff["lastName"]) . "</td>
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
                                        <td>" . htmlspecialchars($staff["firstName"]) . "</td>
                                        <td>" . htmlspecialchars($staff["lastName"]) . "</td>
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
                                        <td>" . htmlspecialchars($staff["firstName"]) . "</td>
                                        <td>" . htmlspecialchars($staff["lastName"]) . "</td>
                                        <td>" . htmlspecialchars($staff["staffNumber"]) . "</td>
                                        <td>" . htmlspecialchars($tablet["assetType"]) . "</td>
                                        <td>" . htmlspecialchars($tablet["assetModel"]) . "</td>
                                        <td>" . htmlspecialchars($tablet["assetSerial"]) . "</td>
                                        <td>" . htmlspecialchars($tablet["assetSpec"]) . "</td>
                                      </tr>";
                            }
                        }
                    }
                } else {
                    echo "<tr><td colspan='7'>No results found</td></tr>";
                }
            } else {
                echo "Error: " . $conn->error;
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    $(document).ready(function() {
        AOS.init();

        $('#assetTable').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "autoWidth": false
        });

        $(window).on('load', function() {
            $('.container-dep').addClass('visible');
        });
    });
</script>

</body>
</html>
