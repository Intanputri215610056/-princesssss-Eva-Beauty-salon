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

    // Set headers for the CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=data_pengembalian.csv');
    
    // Open the output stream
    $output = fopen('php://output', 'w');
    
    // Write the column headers
    fputcsv($output, ['No', 'ID Pengembalian', 'ID Sewa', 'Tanggal Pengembalian', 'Denda']);
    
    // Write the rows
    foreach ($pengembalians as $pengembalian) {
        fputcsv($output, $pengembalian);
    }
    
    // Close the output stream
    fclose($output);
    exit();
    
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>