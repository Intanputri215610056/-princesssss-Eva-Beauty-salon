<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Database connection settings
$host = 'localhost';
$dbname = 'tugas';
$username = 'root';
$password = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_sewa = $_POST['id_sewa'];
    $id_customer = $_POST['id_customer'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
    $total_biaya = $_POST['total_biaya'];
    $status = $_POST['status'];
    $jumlah = $_POST['jumlah'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO penyewaan (id_sewa, id_customer, tanggal_pinjam, tanggal_pengembalian, total_biaya, status, jumlah) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id_sewa, $id_customer, $tanggal_pinjam, $tanggal_pengembalian, $total_biaya, $status, $jumlah]);

        header('Location: data_penyewaan.php');
        exit();
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query('SELECT id, nama FROM customers');
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penyewaan</title>
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
        input[type="text"], input[type="date"], input[type="number"], select {
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
        <h1>Tambah Penyewaan</h1>
        <form method="POST">
            <div class="form-group">
                <label for="id_sewa">ID Sewa:</label>
                <input type="text" id="id_sewa" name="id_sewa" required>
            </div>
            <div class="form-group">
                <label for="id_customer">ID Customer:</label>
                <select id="id_customer" name="id_customer" required>
                    <option value="">Pilih Customer</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?php echo htmlspecialchars($customer['id']); ?>"><?php echo htmlspecialchars($customer['nama']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tanggal_pinjam">Tanggal Pinjam:</label>
                <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" required>
            </div>
            <div class="form-group">
                <label for="tanggal_pengembalian">Tanggal Pengembalian:</label>
                <input type="date" id="tanggal_pengembalian" name="tanggal_pengembalian" required>
            </div>
            <div class="form-group">
                <label for="total_biaya">Total Biaya:</label>
                <input type="number" id="total_biaya" name="total_biaya" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Pending">Pending</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah:</label>
                <input type="number" id="jumlah" name="jumlah" required>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
