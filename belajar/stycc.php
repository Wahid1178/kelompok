<?php
include 'sty.php';
$sql = "SELECT * FROM laporan ORDER BY tanggal_lapor DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Laporan</title>
</head>
<body>
    <h2>Daftar Laporan</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Deskripsi</th>
            <th>Tanggal</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><?= $row["nama"] ?></td>
            <td><?= $row["kategori"] ?></td>
            <td><?= $row["deskripsi"] ?></td>
            <td><?= $row["tanggal_lapor"] ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
