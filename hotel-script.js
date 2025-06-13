document.addEventListener('DOMContentLoaded', function() {
    // Modal elements
    const modal = document.getElementById('booking-modal');
    const bookBtns = document.querySelectorAll('.book-btn');
    const closeBtn = document.querySelector('.close');
    const cancelBtn = document.getElementById('cancel-booking');
    
    // Form elements
    const bookingForm = document.getElementById('booking-form');
    const checkinInput = document.getElementById('checkin');
    const checkoutInput = document.getElementById('checkout');
    const guestsSelect = document.getElementById('guests');
    const roomsSelect = document.getElementById('rooms');
    
    // Filter elements
    const priceFilter = document.getElementById('price-range');
    const locationFilter = document.getElementById('location-filter');
    const resetFilterBtn = document.getElementById('reset-filter');
    
    // Initialize
    initializeFilters();
    setupEventListeners();
    
    function initializeFilters() {
        // Populate location filter
        const locations = new Set();
        document.querySelectorAll('.hotel-card').forEach(card => {
            const location = card.dataset.location;
            if (location) {
                locations.add(location);
            }
        });
        
        locations.forEach(location => {
            const option = document.createElement('option');
            option.value = location;
            option.textContent = location;
            locationFilter.appendChild(option);
        });
    }
    
    function setupEventListeners() {
        // Modal events
        bookBtns.forEach(btn => {
            btn.addEventListener('click', openBookingModal);
        });
        
        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        
        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
        
        // Form events
        checkinInput.addEventListener('change', updateBookingSummary);
        checkoutInput.addEventListener('change', updateBookingSummary);
        roomsSelect.addEventListener('change', updateBookingSummary);
        
        // Filter events
        priceFilter.addEventListener('change', applyFilters);
        locationFilter.addEventListener('change', applyFilters);
        resetFilterBtn.addEventListener('click', resetFilters);
        
        // Form submission
        bookingForm.addEventListener('submit', handleBookingSubmit);
        
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        checkinInput.min = today;
        checkoutInput.min = today;
        
        // Update checkout min date when checkin changes
        checkinInput.addEventListener('change', function() {
            const nextDay = new Date(this.value);
            nextDay.setDate(nextDay.getDate() + 1);
            checkoutInput.min = nextDay.toISOString().split('T')[0];
            if (checkoutInput.value && checkoutInput.value <= this.value) {
                checkoutInput.value = '';
            }
        });
    }
    
    function openBookingModal(e) {
        const btn = e.target.closest('.book-btn');
        const hotelId = btn.dataset.hotelId;
        const hotelName = btn.dataset.hotelName;
        const hotelPrice = parseInt(btn.dataset.hotelPrice);
        
        // Set form values
        document.getElementById('hotel-id').value = hotelId;
        document.getElementById('hotel-price').value = hotelPrice;
        document.getElementById('selected-hotel').textContent = hotelName;
        document.getElementById('price-per-night').textContent = `Rp${hotelPrice.toLocaleString('id-ID')}/malam`;
        
        // Reset form
        bookingForm.reset();
        document.getElementById('hotel-id').value = hotelId;
        document.getElementById('hotel-price').value = hotelPrice;
        document.getElementById('selected-hotel').textContent = hotelName;
        
        // Reset summary
        document.getElementById('duration').textContent = '- malam';
        document.getElementById('total-cost').textContent = 'Rp -';
        
        // Show modal
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
    
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    function updateBookingSummary() {
        const checkin = new Date(checkinInput.value);
        const checkout = new Date(checkoutInput.value);
        const rooms = parseInt(roomsSelect.value) || 1;
        const pricePerNight = parseInt(document.getElementById('hotel-price').value) || 0;
        
        if (checkin && checkout && checkout > checkin) {
            const duration = Math.ceil((checkout - checkin) / (1000 * 60 * 60 * 24));
            const totalCost = duration * pricePerNight * rooms;
            
            document.getElementById('duration').textContent = `${duration} malam`;
            document.getElementById('total-cost').textContent = `Rp${totalCost.toLocaleString('id-ID')}`;
        } else {
            document.getElementById('duration').textContent = '- malam';
            document.getElementById('total-cost').textContent = 'Rp -';
        }
    }
    
    function applyFilters() {
        const priceRange = priceFilter.value;
        const selectedLocation = locationFilter.value;
        const hotelCards = document.querySelectorAll('.hotel-card');
        
        hotelCards.forEach(card => {
            let showCard = true;
            
            // Price filter
            if (priceRange) {
                const [minPrice, maxPrice] = priceRange.split('-').map(Number);
                const cardPrice = parseInt(card.dataset.price);
                
                if (cardPrice < minPrice || cardPrice > maxPrice) {
                    showCard = false;
                }
            }
            
            // Location filter
            if (selectedLocation && card.dataset.location !== selectedLocation) {
                showCard = false;
            }
            
            card.style.display = showCard ? 'block' : 'none';
        });
    }
    
    function resetFilters() {
        priceFilter.value = '';
        locationFilter.value = '';
        
        document.querySelectorAll('.hotel-card').forEach(card => {
            card.style.display = 'block';
        });
    }
    
    function handleBookingSubmit(e) {
        e.preventDefault();
        
        // Basic validation
        const checkin = new Date(checkinInput.value);
        const checkout = new Date(checkoutInput.value);
        const today = new Date();
        
        if (!checkin || !checkout) {
            alert('Silakan pilih tanggal check-in dan check-out');
            return;
        }
        
        if (checkin < today.setHours(0, 0, 0, 0)) {
            alert('Tanggal check-in tidak boleh sebelum hari ini');
            return;
        }
        
        if (checkout <= checkin) {
            alert('Tanggal check-out harus setelah tanggal check-in');
            return;
        }
        
        // Submit form
        bookingForm.submit();
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});