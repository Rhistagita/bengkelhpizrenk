<?php
$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$dbname = "bengkel_hape"; 

$conn = new mysqli($host, $user, $pass, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    echo "Koneksi berhasil!"; // Debugging
}
?>
