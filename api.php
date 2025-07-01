<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = "202312035"; // Ganti dengan password database Anda
$dbname = "angel_beauty";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fungsi untuk mendapatkan semua produk
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'getProducts') {
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    
    $sql = "SELECT * FROM products";
    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $sql .= " WHERE title LIKE '%$search%' OR brand LIKE '%$search%'";
    }
    
    $result = $conn->query($sql);
    
    $products = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    
    echo json_encode($products);
    exit;
}

$conn->close();
?>