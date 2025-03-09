document.addEventListener('DOMContentLoaded', () => {
    const scrollButtons = document.querySelectorAll('.btn');
    scrollButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            const target = document.querySelector(button.getAttribute('href'));
            if (target) {
                event.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseover', () => {
            card.style.transform = 'scale(1.1)';
            card.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.2)';
            card.style.transition = 'all 0.3s ease';
        });
        card.addEventListener('mouseout', () => {
            card.style.transform = 'scale(1)';
            card.style.boxShadow = 'none';
        });
    });

    const logo = document.querySelector('.logo h2');
    if (logo) {
        logo.addEventListener('mouseover', () => {
            let colors = ['#0097a7', '#ff5722', '#4caf50', '#ff9800'];
            let i = 0;
            const colorInterval = setInterval(() => {
                logo.style.color = colors[i];
                i = (i + 1) % colors.length;
            }, 300);
            logo.addEventListener('mouseout', () => {
                clearInterval(colorInterval);
                logo.style.color = '#0097a7';
            });
        });
    }


    const images = document.querySelectorAll('.content-right img, .card img');
    images.forEach(img => {
        img.style.transition = 'transform 0.5s ease';
        img.addEventListener('mouseover', () => {
            img.style.transform = 'translateY(-10px)';
        });
        img.addEventListener('mouseout', () => {
            img.style.transform = 'translateY(0)';
        });
    });

    cards.forEach(card => {
        card.addEventListener('click', () => {
            card.style.animation = 'shake 0.5s';
            setTimeout(() => {
                card.style.animation = '';
            }, 500);
        });
    });
});

const style = document.createElement('style');
style.innerHTML = `
@keyframes shake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    50% { transform: translateX(5px); }
    75% { transform: translateX(-5px); }
    100% { transform: translateX(0); }
}`;
document.head.appendChild(style);
