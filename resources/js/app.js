import './bootstrap';

import $ from 'jquery';
import Swal from 'sweetalert2';
// import DataTable from 'datatables.net-dt';
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
    // 5. SCROLL TO SEARCH (Tombol "DISINI!")
    // ==========================================
    const hereButton = document.getElementById('here-button');
    const searchSection = document.getElementById('search-food');

    if (hereButton && searchSection) {
        hereButton.addEventListener('click', function(e) {
            e.preventDefault();
            searchSection.scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        });
    }


    // ==========================================
    // 6. LOAD MORE PRODUCTS (Menu Page)
    // ==========================================
    const loadMoreBtn = document.getElementById('load-more-btn');
    
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            let btn = this;
            
            // Ambil data dari atribut HTML
            let page = btn.getAttribute('data-page');
            let url = btn.getAttribute('data-url');
            let category = btn.getAttribute('data-category') || '';
            let search = btn.getAttribute('data-search') || '';

            let container = document.getElementById('product-container');
            let spinner = document.getElementById('loading-spinner');
            let label = btn.querySelector('span');
            
            // UI Loading State
            btn.disabled = true;
            label.textContent = 'Memuat...';
            if(spinner) spinner.classList.remove('hidden');

            // Buat URL lengkap
            let fetchUrl = `${url}?page=${page}&category=${category}&search=${search}`;

            // Request AJAX
            fetch(fetchUrl, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => response.json())
            .then(data => {
                // Tambahkan kartu produk baru
                container.insertAdjacentHTML('beforeend', data.html);
                
                // Cek apakah masih ada halaman berikutnya
                if (data.next_page) {
                    btn.setAttribute('data-page', data.next_page);
                    btn.disabled = false;
                    label.textContent = 'Muat Lebih Banyak';
                    if(spinner) spinner.classList.add('hidden');
                } else {
                    // Hapus tombol jika data habis
                    const btnContainer = document.getElementById('load-more-container');
                    if(btnContainer) btnContainer.remove();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btn.disabled = false;
                label.textContent = 'Coba Lagi';
                if(spinner) spinner.classList.add('hidden');
            });
        });
    }


    // ==========================================
    // 6. PAGE LOADER LOGIC
    // ==========================================
    const loader = document.getElementById('page-loader');

    // Fungsi untuk menampilkan loader
    function showLoader() {
        loader.classList.remove('hidden');
        loader.classList.add('flex');
    }

    // Fungsi untuk menyembunyikan loader (jika user menekan tombol Back browser)
    function hideLoader() {
        loader.classList.add('hidden');
        loader.classList.remove('flex');
    }

    // A. Deteksi Klik Link
    const links = document.querySelectorAll('a');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            const target = this.getAttribute('target');

            // Jangan tampilkan loader jika:
            // 1. Link kosong atau # (biasanya untuk modal/js)
            // 2. Link membuka tab baru (_blank)
            // 3. Link adalah javascript:void(0)
            if (href && href !== '#' && href.substring(0, 4) !== 'java' && target !== '_blank') {
                showLoader();
            }
        });
    });

    // B. Deteksi Submit Form (Simpan, Delete, Login, dll)
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            showLoader();
        });
    });

    // C. Fix untuk Tombol "Back" di Browser (Safari/Chrome Cache)
    // Jika user tekan Back, halaman diambil dari cache, loader harus disembunyikan
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            hideLoader();
        }
    });


    // ==========================================
    // 8. SWEETALERT
    // ==========================================
    const successMessage = $('body').data('success-message');
    const errorMessage = $('body').data('error-message');

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    if (successMessage) {
        Toast.fire({
            icon: 'success',
            title: successMessage
        });
    }

    if (errorMessage) {
        Toast.fire({
            icon: 'error',
            title: errorMessage
        });
    }
});