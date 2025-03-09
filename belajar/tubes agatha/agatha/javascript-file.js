
// Fungsi untuk menampilkan alert ketika artikel destinasi diklik
const destinationLinks = document.querySelectorAll('article h3 a');

destinationLinks.forEach(link => {
    link.addEventListener('click', (event) => {
        alert(`Selamat datang di destinasi ${link.textContent}! Nikmati perjalanan Anda!`);
    });
});

