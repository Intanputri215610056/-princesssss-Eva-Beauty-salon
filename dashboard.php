<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
            margin: 0;
            font-family: Arial, sans-serif;
            position: relative;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .dashboard-container {
            text-align: center;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1000px;
        }
        .dashboard-container h1 {
            background-color: #0066ff;
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 40px;
        }
        .menu {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .menu a {
            text-decoration: none;
        }
        .menu div {
            background-color: #0066ff;
            color: white;
            padding: 20px;
            border-radius: 10px;
            width: 150px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            margin: 0 10px;
        }
        .menu div:hover {
            background-color: #0051cc;
            transform: scale(1.05);
        }
        .menu div:active {
            transform: scale(0.95);
        }
    </style>
</head>
<body>
    <a href="logout.php" class="logout-btn">Logout</a>
    <div class="dashboard-container">
        <h1>SELAMAT DATANG</h1>
        <div class="menu">
            <a href="data_customer.php">
                <div>Data Customer</div>
            </a>
            <a href="data_baju.php">
                <div>Data Baju</div>
            </a>
            <a href="data_penyewaan.php">
                <div>Data Penyewaan</div>
            </a>
            <a href="data_pengembalian.php">
                <div>Data Pengembalian</div>
            </a>
        </div>
    </div>
</body>
</html>