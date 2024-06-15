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

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

// Function to delete baju from the database
function deleteBaju($id, $pdo) {
    $sql = "DELETE FROM baju WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// Check if delete action is triggered
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    // Call deleteBaju function
    deleteBaju($_GET['id'], $pdo);
    // Redirect back to this page to refresh data after deletion
    header('Location: data_baju.php');
    exit();
}

// Function to redirect to edit baju page
function editBaju($id) {
    header("Location: edit_baju.php?id=$id");
    exit();
}

// Check if edit action is triggered
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    // Call editBaju function
    editBaju($_GET['id']);
}

// Fetch filtered baju data from the database based on search query
try {
    if(isset($_GET['search'])) {
        $search = $_GET['search'];
        $stmt = $pdo->prepare("SELECT id, nama, deskripsi, ukuran, harga_sewa, stok, ketersediaan FROM baju WHERE nama LIKE :search OR deskripsi LIKE :search OR ukuran LIKE :search");
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->execute();
        $bajus = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $stmt = $pdo->query('SELECT id, nama, deskripsi, ukuran, harga_sewa, stok, ketersediaan FROM baju');
        $bajus = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
    exit();
}


// Fetch all baju data from the database
try {
    $stmt = $pdo->query('SELECT id, nama, deskripsi, ukuran, harga_sewa, stok, ketersediaan FROM baju');
    $bajus = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Baju</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Data Baju</h1>
		<div class="search-container">
    <form method="GET" action="data_baju.php">
        <input type="text" name="search" placeholder="Search...">
        <button type="submit">Search</button>
    </form>
</div>

        <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Ukuran</th>
                <th>Harga Sewa</th>
                <th>Stok</th>
                <th>Ketersediaan</th>
                <th>Action</th>
            </tr>
            <?php foreach ($bajus as $baju): ?>
            <tr>
                <td><?php echo htmlspecialchars($baju['id']); ?></td>
                <td><?php echo htmlspecialchars($baju['nama']); ?></td>
                <td><?php echo htmlspecialchars($baju['deskripsi']); ?></td>
                <td><?php echo htmlspecialchars($baju['ukuran']); ?></td>
                <td><?php echo htmlspecialchars($baju['harga_sewa']); ?></td>
                <td><?php echo htmlspecialchars($baju['stok']); ?></td>
                <td><?php echo htmlspecialchars($baju['ketersediaan']); ?></td>
                <td>
                    <a href="data_baju.php?action=edit&id=<?php echo $baju['id']; ?>" class="edit-btn">Edit</a>
                    <a href="data_baju.php?action=delete&id=<?php echo $baju['id']; ?>" class="delete-btn" onclick="return confirm('Yakin untuk menghapus baju ini?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class="btn-container">
            <a href="tambah_baju.php" class="btn">Tambah Baju</a>
            <a href="dashboard.php" class="btn">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
