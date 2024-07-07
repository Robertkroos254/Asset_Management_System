<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Management Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }

        .chart {
            width: 45%;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .info {
            width: calc(30% - 20px);
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .summary {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .summary-item {
            text-align: center;
        }



        .dropdown-menu {
            display: none;
            /* position: absolute; */
            top: 60px;
            /* Adjust as needed */
            right: 0;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 0;
            list-style: none;
        }

        /* Show the dropdown on hover */
        .profile-dropdown:hover .dropdown-menu {
            display: block;
        }

        /* Style the dropdown links */
        .dropdown-menu li {
            padding: 10px;
        }

        .dropdown-menu a {
            text-decoration: none;
            color: #333;
        }

        .dropdown-menu a:hover {
            background-color: #ddd;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>


    <div class="profile-dropdown">
        <img src="./icons/profile.png" alt="profile" style="width: 50px; height:50px; float: right;" class="profile">
        <ul class="dropdown-menu">
            <li><a href="#">Logout</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Settings</a></li>
        </ul>
    </div>




    <div class="container">
        <?php
        // Establish connection to your database
        $conn = new mysqli("localhost", "root", "", "ict");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Function to fetch data from a table
        function fetch_data($conn, $table_name)
        {
            $sql = "SELECT * FROM $table_name";
            $result = $conn->query($sql);
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }

        // Fetch data for each table
        $laptop_data = fetch_data($conn, "laptop");
        $desktop_data = fetch_data($conn, "desktop");
        $tablet_data = fetch_data($conn, "tablet");

        // Close the connection
        $conn->close();

        // Calculate percentages
        $total_assets = count($laptop_data) + count($desktop_data) + count($tablet_data);
        $laptop_percentage = count($laptop_data) / $total_assets * 100;
        $desktop_percentage = count($desktop_data) / $total_assets * 100;
        $tablet_percentage = count($tablet_data) / $total_assets * 100;

        // Data for pie chart
        $asset_distribution_data = [
            'Laptop' => $laptop_percentage,
            'Desktop' => $desktop_percentage,
            'Tablet' => $tablet_percentage
        ];

        // Data for linear chart (count of assets over time)
        // Assuming you have a timestamp column in your tables
        $asset_count_over_time = [
            'Laptop' => count($laptop_data),
            'Desktop' => count($desktop_data),
            'Tablet' => count($tablet_data)
        ];

        // Convert PHP arrays to JSON for use in JavaScript
        $asset_distribution_json = json_encode($asset_distribution_data);
        $asset_count_over_time_json = json_encode($asset_count_over_time);
        ?>
        <div class="info">
            <h2>Total Assets</h2>
            <p style="font-size: 36px; font-weight: bold; text-align: center;"><?php echo $total_assets; ?></p>
        </div>
        <div class="info">
            <h2>Asset Categories</h2>
            <div class="summary">
                <div class="summary-item">
                    <h3>Laptops</h3>
                    <p><?php echo count($laptop_data); ?></p>
                </div>
                <div class="summary-item">
                    <h3>Desktops</h3>
                    <p><?php echo count($desktop_data); ?></p>
                </div>
                <div class="summary-item">
                    <h3>Tablets</h3>
                    <p><?php echo count($tablet_data); ?></p>
                </div>
            </div>
        </div>
        <div class="chart">
            <h2>Asset Distribution</h2>
            <canvas id="assetPieChart"></canvas>
        </div>
        <div class="chart">
            <h2>Assets Over Time</h2>
            <canvas id="assetLineChart"></canvas>
        </div>
    </div>

    <script>
        // Parse JSON data from PHP
        const assetDistributionData = JSON.parse('<?php echo $asset_distribution_json; ?>');
        const assetCountOverTimeData = JSON.parse('<?php echo $asset_count_over_time_json; ?>');

        // Create pie chart
        new Chart(document.getElementById('assetPieChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: Object.keys(assetDistributionData),
                datasets: [{
                    label: 'Asset Distribution',
                    data: Object.values(assetDistributionData),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });

        // Create linear chart
        new Chart(document.getElementById('assetLineChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: Object.keys(assetCountOverTimeData),
                datasets: [{
                    label: 'Assets Over Time',
                    data: Object.values(assetCountOverTimeData),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Time'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>