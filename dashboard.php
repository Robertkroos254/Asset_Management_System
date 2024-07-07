<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Container Layout</title>
    <style>
        .dash {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        .row {
            display: flex;
            justify-content: center;
            width: 100%;
            max-width: 900px;
            margin-bottom: 20px;
        }
        .container, .wide-container, .graph-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            background-color: brown;
            transition: transform 0.3s ease;
        }
        .container {
            width: 250px;
            height: 150px;
            margin: 0 10px;
            border-radius: 15px;
        }
        .wide-container {
            width: 790px;
            height: 200px;
            border-radius: 15px;
        }
        .graph-container {
            width: 675px;
            height: 500px;
            border-radius: 15px;
            background-color: transparent;
            margin: 20px;
        }
        .container:hover, .wide-container:hover, .graph-container:hover {
            transform: scale(1.1);
        }
        h2, p {
            margin: 5px 0;
            font-size: 25px;
        }
        .graph-row {
            margin-top: 30px;
            justify-content: space-between;
        }
        .parent-container {
            width: 100%;
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            border: 2px solid brown;
            border-radius: 15px;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body class="dash">
    <div class="parent-container">
        <div class="row">
        <?php
            // Establish connection to your database
            $conn = new mysqli("localhost", "root", "", "ict");
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            // Function to fetch data from a table
            function fetch_data($conn, $table_name) {
                $sql = "SELECT * FROM $table_name";
                $result = $conn->query($sql);
                $data = [];
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                return $data;
            }
            // Fetch data for each table
            $laptop_data = fetch_data($conn, "laptop");
            $desktop_data = fetch_data($conn, "desktop");
            $tablet_data = fetch_data($conn, "tablet");
            $otherasset_data = fetch_data($conn, "otherasset");

            // Fetch number of faulty assets
            $sql = "SELECT COUNT(*) as totalFaulty FROM faulty";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $totalFaulty = $row['totalFaulty'];

            // Close the connection
            $conn->close();

            // Calculate percentages
            $total_assets = count($laptop_data) + count($desktop_data) + count($tablet_data) + count($otherasset_data);
            $laptop_percentage = count($laptop_data) / $total_assets * 100;
            $desktop_percentage = count($desktop_data) / $total_assets * 100;
            $tablet_percentage = count($tablet_data) / $total_assets * 100;
            $otherasset_percentage = count($otherasset_data) / $total_assets * 100;

            // Data for pie chart
            $asset_distribution_data = [
                'Laptop' => $laptop_percentage,
                'Desktop' => $desktop_percentage,
                'Tablet' => $tablet_percentage,
                'Other Assets' => $otherasset_percentage
            ];
            // Data for linear chart (count of assets over time)
            // Assuming you have a timestamp column in your tables
            $asset_count_over_time = [
                'Laptop' => count($laptop_data),
                'Desktop' => count($desktop_data),
                'Tablet' => count($tablet_data),
                'Other Assets' => count($otherasset_data)
            ];

            // Convert PHP arrays to JSON for use in JavaScript
            $asset_distribution_json = json_encode($asset_distribution_data);
            $asset_count_over_time_json = json_encode($asset_count_over_time);
        ?>
            <div class="container">
                <h2>Total Assets</h2>
                <p><?php echo $total_assets; ?></p>
            </div>
            <div class="container">
                <h2>Faulty Assets</h2>
                <p><?php echo $totalFaulty; ?></p>
            </div>
            <div class="container">
                <h2>Total Cost</h2>
                <p>50</p>
            </div>
        </div>
        <div class="row">
            <div class="wide-container">
                <h2>Total Employees</h2>
                <p>50</p>
            </div>
        </div>
        <div class="row">
            <div class="graph-container">
                <h2 style="color: black;">Asset Distribution</h2>
                <canvas id="assetDistributionChart"></canvas>
            </div>
            <div class="graph-container">
                <h2 style="color: black;">Assets Over Time</h2>
                <canvas id="assetCountChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Get the data from PHP
        const assetDistributionData = <?php echo $asset_distribution_json; ?>;
        const assetCountOverTimeData = <?php echo $asset_count_over_time_json; ?>;

        // Pie Chart for Asset Distribution
        const ctx1 = document.getElementById('assetDistributionChart').getContext('2d');
        new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: Object.keys(assetDistributionData),
                datasets: [{
                    label: 'Asset Distribution',
                    data: Object.values(assetDistributionData),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                }]
            }
        });

        // Bar Chart for Asset Count Over Time
        const ctx2 = document.getElementById('assetCountChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: Object.keys(assetCountOverTimeData),
                datasets: [{
                    label: 'Asset Count',
                    data: Object.values(assetCountOverTimeData),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                }]
            }
        });
    </script>
</body>
</html>
