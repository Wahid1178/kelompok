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

// Ambil data dari database
$query = "SELECT * FROM laporan ORDER BY tanggal_lapor DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2 class="text-center">Daftar Laporan</h2>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Pesan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['nama']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['kategori']}</td>
                        <td>{$row['deskripsi']}</td>
                        <td>{$row['pesan']}</td>
                        <td>{$row['tanggal_lapor']}</td>
                    </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>

</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>
