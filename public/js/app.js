/**
 * Pendaftaran CPNS 2025
 * Main JavaScript File
 * ================================
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ================================
    // Initialize AOS (Animate On Scroll)
    // ================================
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50
        });
    }
    
    // ================================
    // Mobile Menu Toggle
    // ================================
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            const isOpen = mobileMenu.style.maxHeight !== '0px' && mobileMenu.style.maxHeight !== '';
            
            if (isOpen) {
                mobileMenu.style.maxHeight = '0px';
                if (menuIcon) menuIcon.classList.remove('hidden');
                if (closeIcon) closeIcon.classList.add('hidden');
            } else {
                mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
                mobileMenu.classList.remove('hidden');
                if (menuIcon) menuIcon.classList.add('hidden');
                if (closeIcon) closeIcon.classList.remove('hidden');
            }
        });
        
        // Close mobile menu when clicking a link
        document.querySelectorAll('.mobile-nav-link').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.style.maxHeight = '0px';
                if (menuIcon) menuIcon.classList.remove('hidden');
                if (closeIcon) closeIcon.classList.add('hidden');
            });
        });
    }
    
    // ================================
    // Navbar Scroll Effect
    // ================================
    const navbar = document.getElementById('navbar');
    const navLinks = document.querySelectorAll('.nav-link:not([href="#daftar"])');
    const logoText = document.querySelector('#navbar a span');
    
    if (navbar) {
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 50) {
                // Scrolled - show glass background
                navbar.classList.add('shadow-xl', 'scrolled');
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
                navbar.style.backdropFilter = 'blur(20px)';
                
                // Change nav link colors to dark
                navLinks.forEach(link => {
                    link.classList.remove('text-white/90', 'hover:text-white', 'hover:bg-white/10');
                    link.classList.add('text-gray-700', 'hover:text-blue-600', 'hover:bg-blue-50');
                });
                
                // Change logo text color
                if (logoText) {
                    logoText.classList.remove('text-white', 'drop-shadow-md');
                    logoText.classList.add('bg-gradient-to-r', 'from-blue-600', 'to-indigo-700', 'bg-clip-text', 'text-transparent');
                }
                
                // Mobile button
                const mobileBtn = document.getElementById('mobile-menu-btn');
                if (mobileBtn) {
                    mobileBtn.classList.remove('text-white', 'hover:bg-white/10');
                    mobileBtn.classList.add('text-gray-700', 'hover:bg-gray-100');
                }
            } else {
                // At top - transparent with white text
                navbar.classList.remove('shadow-xl', 'scrolled');
                navbar.style.backgroundColor = 'transparent';
                navbar.style.backdropFilter = 'blur(12px)';
                
                // Change nav link colors to white
                navLinks.forEach(link => {
                    link.classList.remove('text-gray-700', 'hover:text-blue-600', 'hover:bg-blue-50');
                    link.classList.add('text-white/90', 'hover:text-white', 'hover:bg-white/10');
                });
                
                // Change logo text color
                if (logoText) {
                    logoText.classList.remove('bg-gradient-to-r', 'from-blue-600', 'to-indigo-700', 'bg-clip-text', 'text-transparent');
                    logoText.classList.add('text-white', 'drop-shadow-md');
                }
                
                // Mobile button
                const mobileBtn = document.getElementById('mobile-menu-btn');
                if (mobileBtn) {
                    mobileBtn.classList.remove('text-gray-700', 'hover:bg-gray-100');
                    mobileBtn.classList.add('text-white', 'hover:bg-white/10');
                }
            }
        });
        
        // Trigger scroll event on load
        window.dispatchEvent(new Event('scroll'));
    }
    
    // ================================
    // Active Nav Link on Scroll
    // ================================
    const sections = document.querySelectorAll('section[id]');
    const allNavLinks = document.querySelectorAll('.nav-link');
    
    if (sections.length && allNavLinks.length) {
        window.addEventListener('scroll', () => {
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                const sectionHeight = section.offsetHeight;
                
                if (window.pageYOffset >= sectionTop && window.pageYOffset < sectionTop + sectionHeight) {
                    current = section.getAttribute('id');
                }
            });
            
            allNavLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });
    }
    
    // ================================
    // Smooth Scroll for Anchor Links
    // ================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const target = document.querySelector(targetId);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // ================================
    // FAQ Accordion
    // ================================
    document.querySelectorAll('.faq-header').forEach(header => {
        header.addEventListener('click', () => {
            const faqItem = header.parentElement;
            const isActive = faqItem.classList.contains('active');
            
            // Close all FAQ items
            document.querySelectorAll('.faq-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Toggle current item
            if (!isActive) {
                faqItem.classList.add('active');
            }
        });
    });
    
    // ================================
    // Stats Counter Animation
    // ================================
    function animateCounter(element, target, duration = 2000) {
        if (!element) return;
        
        let start = 0;
        const increment = target / (duration / 16);
        
        function updateCounter() {
            start += increment;
            if (start < target) {
                element.textContent = Math.floor(start).toLocaleString('id-ID');
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target.toLocaleString('id-ID') + '+';
            }
        }
        
        updateCounter();
    }
    
    // Start counter animation when visible
    const statFormasi = document.getElementById('stat-formasi');
    if (statFormasi) {
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(document.getElementById('stat-formasi'), 15000);
                    animateCounter(document.getElementById('stat-instansi'), 89);
                    animateCounter(document.getElementById('stat-pendaftar'), 250000);
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        statsObserver.observe(statFormasi);
    }
    
    // ================================
    // Upload Zone Drag & Drop
    // ================================
    const uploadZone = document.querySelector('.upload-zone');
    if (uploadZone) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadZone.addEventListener(eventName, () => {
                uploadZone.classList.add('dragover');
            }, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, () => {
                uploadZone.classList.remove('dragover');
            }, false);
        });
        
        uploadZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            handleFiles(files);
        }, false);
        
        uploadZone.addEventListener('click', () => {
            const input = document.createElement('input');
            input.type = 'file';
            input.multiple = true;
            input.accept = '.jpg,.jpeg,.png,.pdf';
            input.onchange = (e) => {
                handleFiles(e.target.files);
            };
            input.click();
        });
    }
    
    function handleFiles(files) {
        console.log('Files uploaded:', files);
        // Add your file handling logic here
    }
    
});

// ================================
// jQuery AJAX Functions (if jQuery is loaded)
// ================================
if (typeof jQuery !== 'undefined') {
    jQuery(document).ready(function($) {
        
        // Setup CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // ================================
        // Load Pengumuman via AJAX
        // ================================
        function loadPengumuman() {
            $.ajax({
                url: '/api/pengumuman',
                method: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $('#pengumuman-list').html('<div class="col-span-3 text-center py-8"><div class="loading-spinner mx-auto"></div><p class="mt-4 text-gray-500">Memuat pengumuman...</p></div>');
                },
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        let html = '';
                        const icons = ['bi-calendar-event', 'bi-file-earmark-check', 'bi-info-circle'];
                        const colors = [
                            { bg: 'from-blue-500 to-indigo-600', badge: 'text-blue-600 bg-blue-50' },
                            { bg: 'from-green-500 to-emerald-600', badge: 'text-green-600 bg-green-50' },
                            { bg: 'from-purple-500 to-violet-600', badge: 'text-purple-600 bg-purple-50' }
                        ];
                        
                        response.data.forEach(function(item, index) {
                            const colorSet = colors[index % colors.length];
                            const icon = icons[index % icons.length];
                            
                            html += `
                                <div class="glass-card rounded-2xl p-6 card-hover" data-aos="fade-up" data-aos-delay="${(index + 1) * 100}">
                                    <div class="w-14 h-14 bg-gradient-to-br ${colorSet.bg} rounded-2xl flex items-center justify-center mb-5 shadow-lg">
                                        <i class="bi ${icon} text-white text-2xl"></i>
                                    </div>
                                    <span class="text-xs font-medium ${colorSet.badge} px-3 py-1 rounded-full">${item.date || 'Terbaru'}</span>
                                    <h3 class="text-xl font-bold text-gray-900 mt-3 mb-2">${item.title}</h3>
                                    <p class="text-gray-600">${item.description}</p>
                                </div>
                            `;
                        });
                        
                        $('#pengumuman-list').html(html);
                        
                        // Refresh AOS for new elements
                        if (typeof AOS !== 'undefined') {
                            AOS.refresh();
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log('API not available, using static content');
                    // Keep static content if API fails
                }
            });
        }
        
        // Uncomment to enable API loading
        // loadPengumuman();
        
        // ================================
        // Button Daftar Click Handler
        // ================================
        $('#btn-daftar').on('click', function() {
            const btn = $(this);
            const originalHtml = btn.html();
            
            // Show loading state
            btn.prop('disabled', true).html('<div class="loading-spinner mx-auto"></div>');
            
            // Simulate API call (replace with actual API)
            setTimeout(function() {
                // Reset button
                btn.prop('disabled', false).html(originalHtml);
                
                // Show alert or redirect
                alert('Fitur pendaftaran akan segera tersedia!');
                
                // Or redirect to registration page
                // window.location.href = '/pendaftaran';
            }, 1500);
            
            // Example actual AJAX call:
            /*
            $.ajax({
                url: '/api/daftar/check',
                method: 'GET',
                success: function(response) {
                    if (response.open) {
                        window.location.href = '/pendaftaran';
                    } else {
                        alert('Pendaftaran belum dibuka');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalHtml);
                }
            });
            */
        });
        
        // ================================
        // Newsletter Subscribe (if exists)
        // ================================
        $('#newsletter-form').on('submit', function(e) {
            e.preventDefault();
            const email = $(this).find('input[type="email"]').val();
            
            $.ajax({
                url: '/api/newsletter/subscribe',
                method: 'POST',
                data: { email: email },
                success: function(response) {
                    alert('Terima kasih telah berlangganan!');
                },
                error: function() {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });
        
    });
}

// ================================
// Utility Functions
// ================================

/**
 * Format number with Indonesian locale
 */
function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

/**
 * Format date with Indonesian locale
 */
function formatDate(dateString) {
    const options = { day: 'numeric', month: 'long', year: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

/**
 * Show toast notification
 */
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-xl shadow-lg z-50 transform translate-y-full opacity-0 transition-all duration-300`;
    
    switch(type) {
        case 'success':
            toast.classList.add('bg-green-500', 'text-white');
            break;
        case 'error':
            toast.classList.add('bg-red-500', 'text-white');
            break;
        case 'warning':
            toast.classList.add('bg-yellow-500', 'text-white');
            break;
        default:
            toast.classList.add('bg-blue-500', 'text-white');
    }
    
    toast.innerHTML = `<i class="bi bi-info-circle me-2"></i>${message}`;
    document.body.appendChild(toast);
    
    // Show
    setTimeout(() => {
        toast.classList.remove('translate-y-full', 'opacity-0');
    }, 100);
    
    // Hide after 3 seconds
    setTimeout(() => {
        toast.classList.add('translate-y-full', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

/**
 * Debounce function for performance
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Check if element is in viewport
 */
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}
