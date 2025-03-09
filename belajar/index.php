<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];

    // Simpan laporan ke file atau database (bisa disesuaikan)
    $file = fopen("laporan_darurat.txt", "a");
    fwrite($file, "Nama: $nama\nKategori: $kategori\nDeskripsi: $deskripsi\n\n");
    fclose($file);

    echo "Laporan Anda telah dikirim! Terima kasih.";
}
?>
