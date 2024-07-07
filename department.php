<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Details</title>
    <!-- Include jQuery and DataTables CSS/JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
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
            /* max-width: 800px; */
            max-width: 90%;
            margin: 0 auto;
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
    <div class="container-dep" data-aos="fade-up">
        <h1>Department Details</h1>
        <table id="staffTable">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Staff Number</th>
                    <th>Department</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection
                $server = "localhost";
                $username = "root";
                $password = "";
                $dbname = "ict";
                // Create connection
                $conn = new mysqli($server, $username, $password, $dbname);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                // Fetch data
                $sql = "SELECT firstName, lastName, staffNumber, Department FROM signup";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row["firstName"]) . "</td>
                                <td>" . htmlspecialchars($row["lastName"]) . "</td>
                                <td>" . htmlspecialchars($row["staffNumber"]) . "</td>
                                <td>" . htmlspecialchars($row["Department"]) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No results found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- AOS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        $(document).ready(function() {
            AOS.init();
            $('#staffTable').DataTable({
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
