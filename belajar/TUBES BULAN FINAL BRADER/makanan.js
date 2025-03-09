document.addEventListener('DOMContentLoaded', () => {

    // Add Animation to Header Logo on Click
    const logo = document.querySelector('.logo h2');
    logo.addEventListener('click', () => {
        logo.style.transform = 'rotate(360deg)';
        logo.style.transition = 'transform 1s';
        setTimeout(() => {
            logo.style.transform = 'rotate(0)';
        }, 1000);
    });

    // Interactive Dendeng Image
    const dendengImage = document.querySelector('.fotoDendeng img');
    dendengImage.addEventListener('mouseover', () => {
        dendengImage.style.transform = 'scale(1.1)';
        dendengImage.style.transition = 'transform 0.3s';
    });
    dendengImage.addEventListener('mouseout', () => {
        dendengImage.style.transform = 'scale(1)';
    });

    // Click on Place Section to Show Alert
    const places = document.querySelectorAll('.tempat1, .tempat2, .tempat3');
    places.forEach((place, index) => {
        place.addEventListener('click', () => {
            const placeNames = [
                'Rumah Makan Lamun Ombak',
                'Rumah Makan Sederhana',
                'Rumah Makan Pagi Sore'
            ];
            alert(` Selamat menikmati makanan lezat.`);
        });
    });
 });