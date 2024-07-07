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
        .print_button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #0078d4;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }
        .print_button:hover {
            background-color: #005bb5;
        }

        @media print {
            .print_button {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="container-dep" data-aos="fade-up">
    <h1>Faulty Asset Details</h1>
    <table id="assetTable">
        <thead>
            <tr>
                <th>Asset Type</th>
                <th>Asset Model</th>
                <th>Asset Serial Number</th>
                <th>Asset Specification</th>
                <th>Fault Date</th>
                <th>Description</th>
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
            $staffSql = "SELECT staffNumber FROM signup";
            $staffResult = $conn->query($staffSql);

            if ($staffResult) {
                if ($staffResult->num_rows > 0) {
                    while($staff = $staffResult->fetch_assoc()) {
                        // Fetch laptop data
                        $laptopSql = "SELECT 'Laptop' AS assetType, laptopmodel AS assetModel, laptopserial AS assetSerial, laptopspec AS assetSpec,
                                      faultDate, description 
                                      FROM laptop LEFT JOIN faulty ON laptop.laptopserial = faulty.assetSerial 
                                      WHERE staffNumber = '". $staff["staffNumber"] ."' AND faultDate IS NOT NULL AND description IS NOT NULL";
                        $laptopResult = $conn->query($laptopSql);
                        if ($laptopResult && $laptopResult->num_rows > 0) {
                            while($laptop = $laptopResult->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($laptop["assetType"]) . "</td>
                                        <td>" . htmlspecialchars($laptop["assetModel"]) . "</td>
                                        <td>" . htmlspecialchars($laptop["assetSerial"]) . "</td>
                                        <td>" . htmlspecialchars($laptop["assetSpec"]) . "</td>
                                        <td>" . htmlspecialchars($laptop["faultDate"]) . "</td>
                                        <td>" . htmlspecialchars($laptop["description"]) . "</td>
                                      </tr>";
                            }
                        }

                        // Fetch desktop data
                        $desktopSql = "SELECT 'Desktop' AS assetType, desktopmodel AS assetModel, desktopserial AS assetSerial, desktopspec AS assetSpec,
                                       faultDate, description 
                                       FROM desktop LEFT JOIN faulty ON desktop.desktopserial = faulty.assetSerial 
                                       WHERE staffNumber = '". $staff["staffNumber"] ."' AND faultDate IS NOT NULL AND description IS NOT NULL";
                        $desktopResult = $conn->query($desktopSql);
                        if ($desktopResult && $desktopResult->num_rows > 0) {
                            while($desktop = $desktopResult->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($desktop["assetType"]) . "</td>
                                        <td>" . htmlspecialchars($desktop["assetModel"]) . "</td>
                                        <td>" . htmlspecialchars($desktop["assetSerial"]) . "</td>
                                        <td>" . htmlspecialchars($desktop["assetSpec"]) . "</td>
                                        <td>" . htmlspecialchars($desktop["faultDate"]) . "</td>
                                        <td>" . htmlspecialchars($desktop["description"]) . "</td>
                                      </tr>";
                            }
                        }

                        // Fetch tablet data
                        $tabletSql = "SELECT 'Tablet' AS assetType, tabletmodel AS assetModel, tabletserial AS assetSerial, tabletspec AS assetSpec,
                                      faultDate, description 
                                      FROM tablet LEFT JOIN faulty ON tablet.tabletserial = faulty.assetSerial 
                                      WHERE staffNumber = '". $staff["staffNumber"] ."' AND faultDate IS NOT NULL AND description IS NOT NULL";
                        $tabletResult = $conn->query($tabletSql);
                        if ($tabletResult && $tabletResult->num_rows > 0) {
                            while($tablet = $tabletResult->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($tablet["assetType"]) . "</td>
                                        <td>" . htmlspecialchars($tablet["assetModel"]) . "</td>
                                        <td>" . htmlspecialchars($tablet["assetSerial"]) . "</td>
                                        <td>" . htmlspecialchars($tablet["assetSpec"]) . "</td>
                                        <td>" . htmlspecialchars($tablet["faultDate"]) . "</td>
                                        <td>" . htmlspecialchars($tablet["description"]) . "</td>
                                      </tr>";
                            }
                        }
                    }
                } else {
                    echo "<tr><td colspan='6'>No results found</td></tr>";
                }
            } else {
                echo "Error: " . $conn->error;
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<button class="print_button" onclick="window.print()">Print Table</button>

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
