<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Database connection settings
$host = 'localhost'; // Sesuaikan dengan host database Anda
$dbname = 'tugas'; // Sesuaikan dengan nama database Anda
$username = 'root'; // Sesuaikan dengan username database Anda
$password = ''; // Sesuaikan dengan password database Anda

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $ukuran = $_POST['ukuran'];
    $harga_sewa = $_POST['harga_sewa'];
    $stok = $_POST['stok'];
    $ketersediaan = $_POST['ketersediaan'];

    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Insert new baju data into the database
        $stmt = $pdo->prepare('INSERT INTO baju (nama, deskripsi, ukuran, harga_sewa, stok, ketersediaan) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$nama, $deskripsi, $ukuran, $harga_sewa, $stok, $ketersediaan]);

        // Redirect to data_baju.php after adding
        header('Location: data_baju.php');
        exit();
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Baju</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .container h1 {
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="tel"], input[type="email"], select, input[type="number"], input[type="date"], textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #0066ff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0051cc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Baju</h1>
        <form method="POST">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="ukuran">Ukuran:</label>
                <input type="text" id="ukuran" name="ukuran" required>
            </div>
            <div class="form-group">
                <label for="harga_sewa">Harga Sewa:</label>
                <input type="number" id="harga_sewa" name="harga_sewa" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" id="stok" name="stok" required>
            </div>
            <div class="form-group">
                <label for="ketersediaan">Ketersediaan:</label>
                <select id="ketersediaan" name="ketersediaan" required>
                    <option value="Tersedia">Tersedia</option>
                    <option value="Tidak Tersedia">Tidak Tersedia</option>
                </select>
            </div>
            <button type="submit">Tambah Baju</button>
        </form>
    </div>
</body>
</html>
