<?php
session_start();

// Database connection settings
$host = 'localhost'; // Sesuaikan dengan host database Anda
$dbname = 'tugas'; // Sesuaikan dengan nama database Anda
$username = 'root'; // Sesuaikan dengan username database Anda
$password = ''; // Sesuaikan dengan password database Anda

// Function to delete penyewaan from the database
function deletePenyewaan($no, $pdo) {
    $sql = "DELETE FROM penyewaan WHERE no = :no";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':no', $no, PDO::PARAM_INT);
    $stmt->execute();
}

// Check if delete action is triggered
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['no'])) {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Call deletePenyewaan function
    deletePenyewaan($_GET['no'], $pdo);
    // Redirect back to this page to refresh data after deletion
    header('Location: data_penyewaan.php');
    exit();
}

// Function to redirect to edit penyewaan page
function editPenyewaan($no) {
    header("Location: edit_penyewaan.php?no=$no");
    exit();
}

// Check if edit action is triggered
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['no'])) {
    // Call editBaju function
    editPenyewaan($_GET['no']);
}

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query('SELECT no, id_sewa, id_customer, tanggal_pinjam, tanggal_pengembalian, total_biaya, status, jumlah FROM penyewaan');
    $penyewaans = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penyewaan</title>
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
            width: 90%;
            max-width: 1200px;
        }
        .container h1 {
            background-color: #0066ff;
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #0066ff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-container {
            text-align: center;
        }
        .btn {
            background-color: #0066ff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0051cc;
        }
        .edit-btn {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Data Penyewaan</h1>
        <table>
            <tr>
                <th>No</th>
                <th>ID Sewa</th>
                <th>ID Customer</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Pengembalian</th>
                <th>Total Biaya</th>
                <th>Status</th>
                <th>Jumlah</th>
                <th>Action</th>
            </tr>
            <?php foreach ($penyewaans as $penyewaan): ?>
            <tr>
                <td><?php echo htmlspecialchars($penyewaan['no']); ?></td>
                <td><?php echo htmlspecialchars($penyewaan['id_sewa']); ?></td>
                <td><?php echo htmlspecialchars($penyewaan['id_customer']); ?></td>
                <td><?php echo htmlspecialchars($penyewaan['tanggal_pinjam']); ?></td>
                <td><?php echo htmlspecialchars($penyewaan['tanggal_pengembalian']); ?></td>
                <td><?php echo htmlspecialchars($penyewaan['total_biaya']); ?></td>
                <td><?php echo htmlspecialchars($penyewaan['status']); ?></td>
                <td><?php echo htmlspecialchars($penyewaan['jumlah']); ?></td>
                <td>
                    <a href="data_penyewaan.php?action=edit&no=<?php echo $penyewaan['no']; ?>" class="edit-btn">Edit</a>
                    <a href="data_penyewaan.php?action=delete&no=<?php echo $penyewaan['no']; ?>" class="delete-btn" onclick="return confirm('Yakin untuk menghapus penyewaan ini?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class="btn-container">
            <a href="tambah_penyewaan.php" class="btn">Tambah Penyewaan</a>
            <a href="dashboard.php" class="btn">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
