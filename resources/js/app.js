import './bootstrap';

/**
 * CPNS 2025 - Custom JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // ========================================
    // Navbar Scroll Effect
    // ========================================
    const navbar = document.getElementById('navbar');
    
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
    }
    
    // ========================================
    // Mobile Menu Toggle
    // ========================================
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            if (menuIcon) menuIcon.classList.toggle('hidden');
            if (closeIcon) closeIcon.classList.toggle('hidden');
        });
    }
    
    // ========================================
    // Flash Messages Auto-hide
    // ========================================
    const flashMessages = document.querySelectorAll('[id^="flash-"]');
    flashMessages.forEach(function(flash) {
        setTimeout(function() {
            flash.style.transition = 'opacity 0.5s ease-out';
            flash.style.opacity = '0';
            setTimeout(function() {
                flash.remove();
            }, 500);
        }, 5000);
    });
    
    // ========================================
    // User Dropdown Toggle
    // ========================================
    const userDropdownBtn = document.querySelector('[onclick*="user-dropdown"]');
    const userDropdown = document.getElementById('user-dropdown');
    
    if (userDropdown) {
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('[onclick*="user-dropdown"]') && 
                !e.target.closest('#user-dropdown')) {
                userDropdown.classList.add('hidden');
            }
        });
    }
    
    // ========================================
    // Accessibility - Font Size Controls
    // ========================================
    window.increaseFontSize = function() {
        const currentSize = parseInt(document.documentElement.style.fontSize) || 100;
        if (currentSize < 150) {
            document.documentElement.style.fontSize = (currentSize + 10) + '%';
            updateFontSizeIndicator(currentSize + 10);
        }
    };
    
    window.decreaseFontSize = function() {
        const currentSize = parseInt(document.documentElement.style.fontSize) || 100;
        if (currentSize > 70) {
            document.documentElement.style.fontSize = (currentSize - 10) + '%';
            updateFontSizeIndicator(currentSize - 10);
        }
    };
    
    function updateFontSizeIndicator(size) {
        const indicator = document.getElementById('fontSizeIndicator');
        if (indicator) {
            indicator.textContent = size + '%';
        }
    }
    
    // ========================================
    // Accessibility - High Contrast Toggle
    // ========================================
    window.toggleContrast = function() {
        document.body.classList.toggle('high-contrast');
        const toggle = document.getElementById('contrastToggle');
        if (toggle) {
            toggle.classList.toggle('active');
        }
        // Save preference
        localStorage.setItem('highContrast', document.body.classList.contains('high-contrast'));
    };
    
    // Load saved contrast preference
    if (localStorage.getItem('highContrast') === 'true') {
        document.body.classList.add('high-contrast');
        const toggle = document.getElementById('contrastToggle');
        if (toggle) toggle.classList.add('active');
    }
    
    // ========================================
    // Smooth Scroll for Anchor Links
    // ========================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // ========================================
    // Form Validation Helper
    // ========================================
    window.validateForm = function(formId) {
        const form = document.getElementById(formId);
        if (!form) return true;
        
        let isValid = true;
        const inputs = form.querySelectorAll('[required]');
        
        inputs.forEach(function(input) {
            if (!input.value.trim()) {
                input.classList.add('border-red-500');
                isValid = false;
            } else {
                input.classList.remove('border-red-500');
            }
        });
        
        return isValid;
    };
    
    // ========================================
    // Loading Spinner Helper
    // ========================================
    window.showLoading = function(buttonId) {
        const button = document.getElementById(buttonId);
        if (button) {
            button.disabled = true;
            button.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span> Loading...';
        }
    };
    
    window.hideLoading = function(buttonId, originalText) {
        const button = document.getElementById(buttonId);
        if (button) {
            button.disabled = false;
            button.innerHTML = originalText;
        }
    };
    
    // ========================================
    // Confirm Dialog Helper
    // ========================================
    window.confirmAction = function(message, callback) {
        if (confirm(message)) {
            callback();
        }
    };
});
