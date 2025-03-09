<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "lapor_padang";

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$nama      = $_POST['nama'];
$email     = $_POST['email'];
$kategori  = $_POST['kategori'];
$deskripsi = $_POST['deskripsi'];
$pesan     = $_POST['pesan'];
$tanggal   = date("Y-m-d");

// Query untuk menyimpan data (menggunakan prepared statement)
$query = "INSERT INTO laporan (nama, email, kategori, deskripsi, pesan, tanggal_lapor) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssss", $nama, $email, $kategori, $deskripsi, $pesan, $tanggal);

if ($stmt->execute()) {
    echo "<script>alert('Laporan berhasil dikirim!'); window.location.href='index.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>
