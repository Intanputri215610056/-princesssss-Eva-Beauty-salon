<?php
session_start();

// Database connection settings
$host = 'localhost'; // Sesuaikan dengan host database Anda
$dbname = 'tugas'; // Sesuaikan dengan nama database Anda
$username = 'root'; // Sesuaikan dengan username database Anda
$password = ''; // Sesuaikan dengan password database Anda

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch data pengembalian
    $stmt = $pdo->query('SELECT no, id_pengembalian, id_sewa, tanggal_pengembalian, denda FROM pengembalian');
    $pengembalians = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengembalian</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Data Pengembalian</h1>
        <table>
            <tr>
                <th>No</th>
                <th>ID Pengembalian</th>
                <th>ID Sewa</th>
                <th>Tanggal Pengembalian</th>
                <th>Denda</th>
            </tr>
            <?php foreach ($pengembalians as $pengembalian): ?>
            <tr>
                <td><?php echo htmlspecialchars($pengembalian['no']); ?></td>
                <td><?php echo htmlspecialchars($pengembalian['id_pengembalian']); ?></td>
                <td><?php echo htmlspecialchars($pengembalian['id_sewa']); ?></td>
                <td><?php echo htmlspecialchars($pengembalian['tanggal_pengembalian']); ?></td>
                <td><?php echo htmlspecialchars($pengembalian['denda']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class="btn-container">
            <a href="tambah_pengembalian.php" class="btn">Tambah Pengembalian</a>
            <a href="dashboard.php" class="btn">Back to Dashboard</a>
            <a href="download_pengembalian.php" class="btn">Download Laporan</a>
        </div>
    </div>
</body>
</html>