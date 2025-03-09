// Tambahkan event listener untuk animasi saat halaman dimuat
document.addEventListener("DOMContentLoaded", function () {
    // Pilih semua elemen yang ingin dianimasikan
    const animatedElements = document.querySelectorAll(".wrapper-home1, .wrapper-home2, .banner, .footer, .header");

    // Tambahkan kelas awal untuk animasi
    animatedElements.forEach((element) => {
        element.style.opacity = "0";
        element.style.transform = "translateY(50px)";
        element.style.transition = "all 0.8s ease-in-out";
    });

    // Aktifkan animasi saat halaman dimuat
    setTimeout(() => {
        animatedElements.forEach((element, index) => {
            setTimeout(() => {
                element.style.opacity = "1";
                element.style.transform = "translateY(0)";
            }, index * 200); // Tunda animasi untuk elemen berikutnya
        });
    }, 200);
});


    function toggleChat() {
        let chatBox = document.getElementById("chatContainer");
        let button = document.querySelector(".chat-button");
        
        if (chatBox.style.display === "none" || chatBox.style.display === "") {
            chatBox.style.display = "block";
            button.style.display = "none";  // Sembunyikan tombol saat chatbox muncul
        } else {
            chatBox.style.display = "none";
            button.style.display = "block"; // Munculkan tombol saat chatbox ditutup
        }
    }

    function sendMessage() {
        let userInput = document.getElementById("userInput").value;
        let chatBody = document.getElementById("chatBody");

        if (userInput.trim() === "") return;

        // Tampilkan pesan pengguna
        chatBody.innerHTML += `<p><strong>Anda:</strong> ${userInput}</p>`;

        // Kirim ke server Flask
        fetch("http://127.0.0.1:5000/chat", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ message: userInput })
        })
        .then(response => response.json())
        .then(data => {
            chatBody.innerHTML += `<p><strong>Bot:</strong> ${data.reply}</p>`;
            chatBody.scrollTop = chatBody.scrollHeight; // Auto-scroll ke bawah
        })
        .catch(error => {
            chatBody.innerHTML += `<p><strong>Bot:</strong> Maaf, ada kesalahan. Coba lagi.</p>`;
        });

        document.getElementById("userInput").value = ""; // Kosongkan input
    }

    function handleKeyPress(event) {
        if (event.key === "Enter") {
            sendMessage();
        }
    }

    function findEmergency() {
        let place = document.getElementById("search").value;
        if (place.trim() !== "") {
            window.open(`https://www.google.com/maps/search/${place}+terdekat`, '_blank');
        } else {
            alert("Silakan masukkan jenis lokasi darurat yang ingin dicari!");
        }
    }

    async function getWeatherByLocation(lat, lon) {
        const apiKey = "4599155898ef5d885fab4d5e70421152"; // Ganti dengan API Key Anda
        const url = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`;
    
        try {
            let response = await fetch(url);
            let data = await response.json();
    
            // Ambil data cuaca
            let kondisi = data.weather[0].description;
            let suhu = data.main.temp;
            let angin = data.wind.speed;
    
            // Tampilkan cuaca
            document.getElementById("weather").innerHTML = `
                📍 Lokasi: ${data.name} <br>
                🌦️ ${kondisi}, Suhu: ${suhu}°C, Angin: ${angin} m/s
            `;
    
            // Kirim notifikasi jika cuaca ekstrem
            if (kondisi.includes("rain") || kondisi.includes("storm")) {
                sendNotification("⚠️ Peringatan Cuaca Buruk", `Saat ini ${kondisi} di ${data.name}. Siapkan payung atau tunda perjalanan!`);
            }
        } catch (error) {
            console.log("Gagal mengambil data cuaca:", error);
        }
    }
    
    // Fungsi mendapatkan lokasi pengguna
    function getUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    let lat = position.coords.latitude;
                    let lon = position.coords.longitude;
                    getWeatherByLocation(lat, lon);
                },
                error => {
                    console.log("Gagal mendapatkan lokasi:", error);
                    document.getElementById("weather").innerHTML = "🌍 Tidak dapat mengambil lokasi.";
                }
            );
        } else {
            document.getElementById("weather").innerHTML = "❌ Geolocation tidak didukung di browser ini.";
        }
    }
    
    // Panggil fungsi untuk mendapatkan cuaca berdasarkan lokasi pengguna
    getUserLocation();
    