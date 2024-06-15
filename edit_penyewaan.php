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

// Function to update penyewaan data in the database
function updatePenyewaan($no, $id_sewa, $id_customer, $tanggal_pinjam, $tanggal_pengembalian, $total_biaya, $status, $jumlah, $pdo) {
    $sql = "UPDATE penyewaan SET id_sewa = :id_sewa, id_customer = :id_customer, tanggal_pinjam = :tanggal_pinjam, tanggal_pengembalian = :tanggal_pengembalian, total_biaya = :total_biaya, status = :status, jumlah = :jumlah WHERE no = :no";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':no', $no, PDO::PARAM_INT);
    $stmt->bindParam(':id_sewa', $id_sewa, PDO::PARAM_INT);
    $stmt->bindParam(':id_customer', $id_customer, PDO::PARAM_INT);
    $stmt->bindParam(':tanggal_pinjam', $tanggal_pinjam);
    $stmt->bindParam(':tanggal_pengembalian', $tanggal_pengembalian);
    $stmt->bindParam(':total_biaya', $total_biaya);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':jumlah', $jumlah);
    $stmt->execute();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $no = $_POST['no'];
    $id_sewa = $_POST['id_sewa'];
    $id_customer = $_POST['id_customer'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
    $total_biaya = $_POST['total_biaya'];
    $status = $_POST['status'];
    $jumlah = $_POST['jumlah'];

    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Update penyewaan data in the database
        updatePenyewaan($no, $id_sewa, $id_customer, $tanggal_pinjam, $tanggal_pengembalian, $total_biaya, $status, $jumlah, $pdo);

        // Redirect to data_penyewaan.php after editing
        header('Location: data_penyewaan.php');
        exit();
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}

// If form is not submitted or if there's an error, fetch penyewaan data for editing
$no = $_GET['no'];
try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare('SELECT no, id_sewa, id_customer, tanggal_pinjam, tanggal_pengembalian, total_biaya, status, jumlah FROM penyewaan WHERE no = :no');
    $stmt->bindParam(':no', $no, PDO::PARAM_INT);
    $stmt->execute();
    $penyewaan = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penyewaan</title>
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
        <h1>Edit Penyewaan</h1>
        <form method="POST">
            <input type="hidden" name="no" value="<?php echo htmlspecialchars($penyewaan['no']); ?>">
            <div class="form-group">
                <label for="id_sewa">ID Sewa:</label>
                <input type="text" id="id_sewa" name="id_sewa" value="<?php echo htmlspecialchars($penyewaan['id_sewa']); ?>">
            </div>
            <div class="form-group">
                <label for="id_customer">ID Customer:</label>
                <input type="text" id="id_customer" name="id_customer" value="<?php echo htmlspecialchars($penyewaan['id_customer']); ?>">
            </div>
            <div class="form-group">
                <label for="tanggal_pinjam">Tanggal Pinjam:</label>
                <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="<?php echo htmlspecialchars($penyewaan['tanggal_pinjam']); ?>">
            </div>
            <div class="form-group">
                <label for="tanggal_pengembalian">Tanggal Pengembalian:</label>
                <input type="date" id="tanggal_pengembalian" name="tanggal_pengembalian" value="<?php echo htmlspecialchars($penyewaan['tanggal_pengembalian']); ?>">
            </div>
            <div class="form-group">
                <label for="total_biaya">Total Biaya:</label>
                <input type="text" id="total_biaya" name="total_biaya" value="<?php echo htmlspecialchars($penyewaan['total_biaya']); ?>">
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($penyewaan['status']); ?>">
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah:</label>
                <input type="text" id="jumlah" name="jumlah" value="<?php echo htmlspecialchars($penyewaan['jumlah']); ?>">
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
