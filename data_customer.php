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

// Membuat koneksi ke database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

// Function to delete customer from the database
function deleteCustomer($id, $pdo) {
    $sql = "DELETE FROM customers WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// Check if delete action is triggered
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    // Call deleteCustomer function
    deleteCustomer($_GET['id'], $pdo);
    // Redirect back to this page to refresh data after deletion
    header('Location: data_customer.php');
    exit();
}

// Function to redirect to edit customer page
function editCustomer($id) {
    header("Location: edit_customer.php?id=$id");
    exit();
}

// Check if edit action is triggered
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    // Call editCustomer function
    editCustomer($_GET['id']);
}

// Retrieve data from the database
try {
    if(isset($_GET['search'])) {
        $search = $_GET['search'];
        $stmt = $pdo->prepare("SELECT id, nama, alamat, telepon, email, jenis_kelamin, tanggal_lahir FROM customers WHERE nama LIKE :search OR alamat LIKE :search OR telepon LIKE :search OR email LIKE :search");
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->execute();
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $stmt = $pdo->query('SELECT id, nama, alamat, telepon, email, jenis_kelamin, tanggal_lahir FROM customers');
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Customer</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <!-- HTML content -->
    <div class="container">
        <h1>Data Customer</h1>
		<div class="search-container">
    <form method="GET" action="data_customer.php">
        <input type="text" name="search" placeholder="Search...">
        <button type="submit">Search</button>
    </form>
</div>

        <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Action</th>
            </tr>
            <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?php echo htmlspecialchars($customer['id']); ?></td>
                <td><?php echo htmlspecialchars($customer['nama']); ?></td>
                <td><?php echo htmlspecialchars($customer['alamat']); ?></td>
                <td><?php echo htmlspecialchars($customer['telepon']); ?></td>
                <td><?php echo htmlspecialchars($customer['email']); ?></td>
                <td><?php echo htmlspecialchars($customer['jenis_kelamin']); ?></td>
                <td><?php echo htmlspecialchars($customer['tanggal_lahir']); ?></td>
                <td>
                    <a href="data_customer.php?action=edit&id=<?php echo $customer['id']; ?>" class="edit-btn">Edit</a>
                    <a href="data_customer.php?action=delete&id=<?php echo $customer['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this customer?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class="btn-container">
            <a href="tambah_customer.php" class="btn">Tambah Customer</a>
            <a href="dashboard.php" class="btn">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
