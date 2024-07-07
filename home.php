<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Example</title>
    <link rel="stylesheet" href="asset.css">
    <link rel="stylesheet" href="repo.css">
    <link rel="stylesheet" href="user.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 70px; /* Adjust sidebar width */
            background-color: #333;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: width 0.3s;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
        }

        .sidebar:hover {
            width: 250px; /* Increase width on hover */
        }

        .sidebar-item {
            width: 100%;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            display: flex;
            align-items: center;
            position: relative;
        }

        .sidebar-item .icon {
            flex: 0 0 50px;
            margin-right: 5px; /* Add margin to the right of the icon */
        }

        .sidebar-item .text {
            flex: 1;
            overflow: hidden;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .sidebar:hover .sidebar-item .text {
            opacity: 1;
        }

        .content {
            margin-left: 70px;
            padding: 20px;
            transition: margin-left 0.3s;
            flex: 1;
            margin-top: 0;
        }

        .sidebar:hover ~ .content {
            margin-left: 250px; /* Adjust content margin when sidebar expands */
        }

        .print-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #0078d4;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .print-button:hover {
            background-color: #005bb5;
        }

        a {
            color: white;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Container for fetched content */
        .fetched-content-container {
            background-color: #fff;
            border-radius: 10px;
            /* padding: 20px; */
            padding: 120px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="sidebar-item">
                <span class="icon">☰</span>
                <span class="text load-content"><a href="dashboard.php">Dashboard</a></span>
            </div>
            <div class="sidebar-item">
                <span class="icon">🛠</span>
                <span class="text">Asset Management ◂</span>
            </div>

            <div class="sidebar-item">
                <span class="icon">📦</span>
                <span class="text load-content"><a href="asset_categories.html">Asset Issuing</a></span>
            </div>
            <div class="sidebar-item">
                <span class="icon">📜</span>
                <span class="text load-content"><a href="history_fetch.php">Asset History</a></span>
            </div>
            <div class="sidebar-item">
                <span class="icon">⚙️</span>
                <span class="text load-content"><a href="status.php">Asset Status</a></span>
            </div>
            <div class="sidebar-item">
                <span class="icon">⚠️</span>
                <span class="text load-content"><a href="faulty_fetch.php">Faulty Asset</a></span>
            </div>
            <div class="sidebar-item">
                <span class="icon">❌ </span>
                <span class="text load-content"><a href="delete_fetch.php">Deleted Asset</a></span>
            </div>
            <div class="sidebar-item">
                <span class="icon">📊</span>
                <span class="text">Report ◂</span>
            </div>
            <div class="sidebar-item">
                <span class="icon">📈</span>
                <span class="text load-content"><a href="general_report.php">General Report</a></span>
            </div>
            <div class="sidebar-item">
                <span class="icon">🔍</span>
                <span class="text load-content"><a href="faulty_report.php">Faulty asset Report</a></span>
            </div>
            <div class="sidebar-item">
                <span class="icon">🔧</span>
                <span class="text">Maintenance</span>
            </div>
            <?php if (isset($_SESSION['User_name']) && $_SESSION['User_name'] == 'admin'): ?>
                <div class="sidebar-item">
                    <span class="icon">🔑</span>
                    <span class="text load-content"><a href="signup.html">Users</a></span>
                </div>
            <?php endif; ?>
        </div>
        <div class="content" id="content">
            <h1>Main Content Area</h1>
            <p>Your main content goes here.</p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    <script src="load_content.js"></script>
    <!-- <script src="dashboard.js"></script> -->
    <!-- <script src="user.js"></script> -->
</body>
</html>
