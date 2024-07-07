<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Report</title>
    <link rel="stylesheet" href="repo.css">
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
            max-width: 90%;
            margin: 0 auto 20px;
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
            background-color: white;
            color: coral;
        }
        .print_button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #0078d4;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .print_button:hover {
            background-color: #005bb5;
        }
        a {
            color: white;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>General Asset Report</h1>
    <div class="container-dep" data-aos="fade-up">
        <?php
        // Establish connection to your database
        $conn = new mysqli("localhost", "root", "", "ict");
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Function to fetch and display data from a table
        function fetch_and_display_data($conn, $table_name) {
            $sql = "SELECT * FROM $table_name";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<h2>" . ucfirst($table_name) . " Table</h2>";
                echo "<table id='" . $table_name . "Table'>";
                echo "<tr>";
                // Fetch field names and display as table headers
                $fields = $result->fetch_fields();
                foreach ($fields as $field) {
                    echo "<th>" . ucfirst($field->name) . "</th>";
                }
                echo "</tr>";
                // Fetch rows and display as table data
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $data) {
                        echo "<td>" . htmlspecialchars($data) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No records found in the " . ucfirst($table_name) . " table.</p>";
            }
        }
        // Fetch and display data for each table
        fetch_and_display_data($conn, "laptop");
        fetch_and_display_data($conn, "desktop");
        fetch_and_display_data($conn, "tablet");
        fetch_and_display_data($conn, "otherasset");
        // Close the connection
        $conn->close();
        ?>
    </div>
    <button id="print_button" class="print_button" onclick="window.print()" >Print Report</button>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- AOS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        $(document).ready(function() {
            AOS.init();
            $('.container-dep').addClass('visible');
            $('#laptopTable').DataTable({
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false
            });
            $('#desktopTable').DataTable({
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false
            });
            $('#tabletTable').DataTable({
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false
            });
            $('#otherassetTable').DataTable({
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false
            });

            $('#print_button').on('click', function() {
                var printContents = $(".container-dep").html();
                var originalContents = $('body').html();
                $('body').html(printContents);
                window.print();
                $('body').html(originalContents);
                location.reload();
            });
        });
    </script>
</body>
</html>