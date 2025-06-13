<?php
require_once 'config.php';

$hotels = [];
if ($conn) {
    $sql = "SELECT id, nama, deskripsi, gambar, lokasi, harga_kamar, fasilitas, kontak FROM hotel WHERE status = 'aktif' ORDER BY tanggal_input DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $hotels[] = $row;
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="hotel-style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Layanan Hotel di Padang - RuangPadang</title>
</head>
<body>
    <header class="header">
        <div class="nav">
            <div class="logo">
                <h2><img src="./img/logo.png" alt="Logo"><a href="./index.php">RuangPadang</a></h2>
            </div>
            <ul class="nav_menu_list">
                <li class="nav_menu_item"><a href="./index.php" class="nav_menu_link">Home</a></li>
                <li class="nav_menu_item"><a href="./transportasi.php" class="nav_menu_link">Transportasi</a></li>
                <li class="nav_menu_item"><a href="./layanan.php" class="nav_menu_link">Layanan</a></li>
                <li class="nav_menu_item"><a href="./kontak.php" class="nav_menu_link">Contact</a></li>
                <li class="nav_menu_item"><a href="./budaya.php" class="nav_menu_link">Event Budaya</a></li>
                <li class="nav_menu_item"><a href="./lapor.php" class="nav_menu_link">Lapor</a></li>
            </ul>
        </div>
        <div class="profile-menu">
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <a href="./profile.php" class="profile-link"><?php echo htmlspecialchars($_SESSION['nama']); ?></a>
                <a href="./logout.php"><img src="./img/profile.webp" alt="Logout"></a>
            <?php else: ?>
                <a href="./login.php" class="profile-link">Login</a>
                <a href="./login.php"><img src="./img/profile.webp" alt="Login"></a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Hotel Terbaik di Padang</h1>
                <p>Temukan pengalaman menginap yang tak terlupakan dengan pelayanan terbaik dan fasilitas lengkap</p>
                <a href="#hotel-list" class="btn-primary">Jelajahi Hotel</a>
            </div>
            <div class="hero-image">
                <img src="./img/hotel/hotel1.webp " alt="Hotel di Padang">
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="filter-section">
        <div class="container">
            <h3><i class="fas fa-filter"></i> Filter Hotel</h3>
            <div class="filter-controls">
                <div class="filter-group">
                    <label for="price-range">Kisaran Harga:</label>
                    <select id="price-range">
                        <option value="">Semua Harga</option>
                        <option value="0-500000">< Rp 500.000</option>
                        <option value="500000-1000000">Rp 500.000 - 1.000.000</option>
                        <option value="1000000-2000000">Rp 1.000.000 - 2.000.000</option>
                        <option value="2000000-999999999">> Rp 2.000.000</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="location-filter">Lokasi:</label>
                    <select id="location-filter">
                        <option value="">Semua Lokasi</option>
                    </select>
                </div>
                <button id="reset-filter" class="btn-secondary">Reset Filter</button>
            </div>
        </div>
    </section>

    <!-- Hotels List -->
    <section class="hotels-section">
        <div class="container">
            <h2 id="hotel-list"><i class="fas fa-hotel"></i> Daftar Hotel Tersedia</h2>
            <div class="hotels-grid">
                <?php if (empty($hotels)): ?>
                    <div class="no-hotels">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>Tidak ada hotel yang tersedia saat ini.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($hotels as $hotel): ?>
                        <div class="hotel-card" data-price="<?php echo $hotel['harga_kamar']; ?>" data-location="<?php echo htmlspecialchars($hotel['lokasi']); ?>">
                            <div class="hotel-image">
                                <img src="./uploads/hotel/<?php echo htmlspecialchars($hotel['gambar']); ?>" alt="<?php echo htmlspecialchars($hotel['nama']); ?>">
                                <div class="price-badge">
                                    Rp<?php echo number_format($hotel['harga_kamar'], 0, ',', '.'); ?>/malam
                                </div>
                            </div>
                            <div class="hotel-content">
                                <h3><?php echo htmlspecialchars($hotel['nama']); ?></h3>
                                <div class="hotel-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?php echo htmlspecialchars($hotel['lokasi']); ?>
                                </div>
                                <p class="hotel-description">
                                    <?php echo htmlspecialchars(substr($hotel['deskripsi'], 0, 120)); ?>...
                                </p>
                                <div class="hotel-facilities">
                                    <i class="fas fa-wifi"></i>
                                    <i class="fas fa-swimming-pool"></i>
                                    <i class="fas fa-parking"></i>
                                    <i class="fas fa-utensils"></i>
                                </div>
                                <div class="hotel-contact">
                                    <i class="fas fa-phone"></i>
                                    <?php echo htmlspecialchars($hotel['kontak']); ?>
                                </div>
                                <div class="hotel-actions">
                                    <a href="./detail_hotel.php?id=<?php echo $hotel['id']; ?>" class="btn-outline">Detail</a>
                                    <button class="btn-primary book-btn" data-hotel-id="<?php echo $hotel['id']; ?>" data-hotel-name="<?php echo htmlspecialchars($hotel['nama']); ?>" data-hotel-price="<?php echo $hotel['harga_kamar']; ?>">
                                        <i class="fas fa-calendar-check"></i> Pesan Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Booking Modal -->
    <div id="booking-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-calendar-alt"></i> Pemesanan Hotel</h3>
                <span class="close">&times;</span>
            </div>
            <form id="booking-form" action="process_booking.php" method="POST">
                <input type="hidden" id="hotel-id" name="hotel_id">
                <input type="hidden" id="hotel-price" name="hotel_price">
                
                <div class="form-group">
                    <label>Hotel yang Dipilih:</label>
                    <div id="selected-hotel" class="selected-info"></div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="checkin">Tanggal Check-in:</label>
                        <input type="date" id="checkin" name="checkin" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="checkout">Tanggal Check-out:</label>
                        <input type="date" id="checkout" name="checkout" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="guests">Jumlah Tamu:</label>
                        <select id="guests" name="guests" required>
                            <option value="1">1 Orang</option>
                            <option value="2">2 Orang</option>
                            <option value="3">3 Orang</option>
                            <option value="4">4 Orang</option>
                            <option value="5">5+ Orang</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="rooms">Jumlah Kamar:</label>
                        <select id="rooms" name="rooms" required>
                            <option value="1">1 Kamar</option>
                            <option value="2">2 Kamar</option>
                            <option value="3">3 Kamar</option>
                            <option value="4">4+ Kamar</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="customer-name">Nama Lengkap:</label>
                    <input type="text" id="customer-name" name="customer_name" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="customer-phone">No. Telepon:</label>
                        <input type="tel" id="customer-phone" name="customer_phone" required>
                    </div>
                    <div class="form-group">
                        <label for="customer-email">Email:</label>
                        <input type="email" id="customer-email" name="customer_email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="special-requests">Permintaan Khusus (Opsional):</label>
                    <textarea id="special-requests" name="special_requests" rows="3" placeholder="Contoh: Kamar lantai atas, late check-in, dll."></textarea>
                </div>

                <div class="booking-summary">
                    <h4>Ringkasan Pemesanan:</h4>
                    <div class="summary-row">
                        <span>Durasi Menginap:</span>
                        <span id="duration">- malam</span>
                    </div>
                    <div class="summary-row">
                        <span>Harga per Malam:</span>
                        <span id="price-per-night">Rp -</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total Biaya:</span>
                        <span id="total-cost">Rp -</span>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-secondary" id="cancel-booking">Batal</button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-credit-card"></i> Konfirmasi Pemesanan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>▼ Balai Kota :</h3>
                <p>
                    Jl. Bagindo Aziz Chan No.1 <br>
                    Aie Pacah - Kota Padang <br>
                    Sumatera Barat <br>
                    Telp. : 0751 4640800 <br>
                    Email : diskominfo@padang.go.id
                </p>
            </div>
            <div class="footer-section">
                <h3>▼ Jam Kerja :</h3>
                <p>
                    Senin - Kamis : 07.30 - 16.00 WIB <br>
                    Jum'at : 07.30 - 16.30 WIB
                </p>
            </div>
            <div class="footer-section">
                <h3>▼ Media Sosial :</h3>
                <div class="social-links">
                    <a href="https://www.facebook.com/share/19htirRw3k/"><img src="./img/footer/fb.png" alt="Facebook"> Facebook</a>
                    <a href="https://x.com/InfoPadang_?t=xa4cL9omKUdF7naWZNfqew&s=09"><img src="./img/footer/twitter.png" alt="Twitter"> Twitter</a>
                    <a href="https://www.instagram.com/infopadang_?igsh=NmlqdXliaTk0NHRt"><img src="./img/footer/ig.jpeg" alt="Instagram"> Instagram</a>
                    <a href="https://youtube.com/@balaikotatv?si=sem1HpLRZDMjxxsd"><img src="./img/footer/yt.jpeg" alt="YouTube"> Youtube</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="hotel-script.js"></script>
</body>
</html>