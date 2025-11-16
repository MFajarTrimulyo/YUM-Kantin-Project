import './bootstrap';
import DataTable from 'datatables.net-dt';

import $ from 'jquery';
window.$ = window.jQuery = $;


document.addEventListener('DOMContentLoaded', () => {
    
    // ==========================================
    // 1. SLIDER LOGIC (Reusable)
    // ==========================================
    const setupSlider = (sliderId, leftBtnId, rightBtnId) => {
        const slider = document.getElementById(sliderId);
        const leftBtn = document.getElementById(leftBtnId);
        const rightBtn = document.getElementById(rightBtnId);

        if (slider && leftBtn && rightBtn) {
            leftBtn.addEventListener('click', () => {
                slider.scrollBy({ left: -300, behavior: 'smooth' });
            });

            rightBtn.addEventListener('click', () => {
                slider.scrollBy({ left: 300, behavior: 'smooth' });
            });
        }
    };

    // Initialize Sliders (jika ada di halaman)
    setupSlider('discount-slider', 'discount-scroll-left', 'discount-scroll-right');
    setupSlider('popular-slider', 'popular-scroll-left', 'popular-scroll-right');


    // ==========================================
    // 2. DROPDOWN LOGIC (Reusable)
    // ==========================================
    const setupDropdown = (buttonId, dropdownId) => {
        const btn = document.getElementById(buttonId);
        const dropdown = document.getElementById(dropdownId);

        if (btn && dropdown) {
            btn.addEventListener('click', (event) => {
                event.stopPropagation();
                document.querySelectorAll('[id$="-dropdown"]').forEach(el => {
                    if (el.id !== dropdownId) el.classList.add('hidden');
                });
                dropdown.classList.toggle('hidden');
            });
        }
    };

    // Initialize Dropdowns (jika ada di halaman)
    setupDropdown('user-menu-button', 'user-menu-dropdown');
    setupDropdown('notification-button', 'notification-dropdown');


    // ==========================================
    // 3. GLOBAL CLICK LISTENER (Tutup Dropdown)
    // ==========================================
    window.addEventListener('click', () => {
        const allDropdowns = document.querySelectorAll('[id$="-dropdown"]');
        allDropdowns.forEach(dropdown => {
            if (!dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        });
    });

    // ==========================================
    // 4. PASSWORD TOGGLE
    // ==========================================
    const passwordInput = document.getElementById('password-input');
    const passwordToggle = document.getElementById('password-toggle');
    const eyeIcon = document.getElementById('eye-icon');
    const eyeSlashIcon = document.getElementById('eye-slash-icon');

    if (passwordToggle && passwordInput && eyeIcon && eyeSlashIcon) {
        passwordToggle.addEventListener('click', () => {
            // Cek tipe input saat ini
            if (passwordInput.type === 'password') {
                // Ubah ke teks
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                // Ubah kembali ke password
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        });
    }

    // ==========================================
    // 5. SCROLL TO SEARCH FOOD
    // ==========================================
    const buttonHere = document.getElementById('here-button');
    const searchFoodDiv = document.getElementById('search-food');

    buttonHere.addEventListener('click', function() {
        searchFoodDiv.scrollIntoView({
            behavior: 'smooth'
        });
    });
});