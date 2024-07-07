<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleted Assets Log</title>
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
            color: #4CAF50;
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
            background-color: #4CAF50;
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
    <h1>Deleted Assets Log</h1>
    <table id="deleteLogTable">
        <thead>
            <tr>
                <th>Asset Serial</th>
                <th>Delete Date</th>
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

            // Fetch data from delete_log table
            $sql = "SELECT assetSerial, Deletedate, description FROM delete_log";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row["assetSerial"]) . "</td>
                            <td>" . htmlspecialchars($row["Deletedate"]) . "</td>
                            <td>" . htmlspecialchars($row["description"]) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No records found</td></tr>";
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
        $('#deleteLogTable').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>

</body>
</html>
