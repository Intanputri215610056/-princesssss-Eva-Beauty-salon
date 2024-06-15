<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Jika ada pengiriman form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari form
    $no = $_POST['no'];
    $id_pengembalian = $_POST['id_pengembalian'];
    $id_sewa = $_POST['id_sewa'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
    $denda = $_POST['denda'];

    // Database connection settings
    $host = 'localhost'; // Sesuaikan dengan host database Anda
    $dbname = 'tugas'; // Sesuaikan dengan nama database Anda
    $username = 'root'; // Sesuaikan dengan username database Anda
    $password = ''; // Sesuaikan dengan password database Anda

    try {
        // Buat koneksi ke database
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL untuk memasukkan data pengembalian baru ke database
        $sql = "INSERT INTO pengembalian (no, id_pengembalian, id_sewa, tanggal_pengembalian, denda) 
                VALUES (:no, :id_pengembalian, :id_sewa, :tanggal_pengembalian, :denda)";
        $stmt = $pdo->prepare($sql);

        // Bind parameter ke statement
        $stmt->bindParam(':no', $no, PDO::PARAM_STR);
        $stmt->bindParam(':id_pengembalian', $id_pengembalian, PDO::PARAM_STR);
        $stmt->bindParam(':id_sewa', $id_sewa, PDO::PARAM_STR);
        $stmt->bindParam(':tanggal_pengembalian', $tanggal_pengembalian, PDO::PARAM_STR);
        $stmt->bindParam(':denda', $denda, PDO::PARAM_INT);

        // Eksekusi statement
        $stmt->execute();

        // Redirect ke halaman data_pengembalian setelah berhasil memasukkan data
        header('Location: data_pengembalian.php');
        exit();
    } catch (PDOException $e) {
        // Tangani kesalahan jika ada
        echo 'Connection failed: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengembalian</title>
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
        input[type="text"], input[type="date"], input[type="number"] {
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
        <h1>Tambah Pengembalian</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Form input fields -->
            <input type="text" name="id_pengembalian" placeholder="ID Pengembalian"><br>
            <input type="text" name="id_sewa" placeholder="ID Sewa"><br>
            <input type="date" name="tanggal_pengembalian" placeholder="Tanggal Pengembalian"><br>
            <input type="number" name="denda" placeholder="Denda"><br>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>