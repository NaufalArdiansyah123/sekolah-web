/* Public Template JavaScript - Consistent animations and interactions */

document.addEventListener('DOMContentLoaded', function () {
    // Counter Animation Function
    function animateCounter(element, target, duration = 2000) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;
        
        element.classList.add('counting');
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            
            const displayValue = Math.floor(current).toLocaleString();
            element.textContent = displayValue;
        }, 16);
    }
    
    // Enhanced Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe all animated elements
    const animatedElements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right, .fade-in, .scale-in, .slide-in-bottom');
    animatedElements.forEach(element => {
        observer.observe(element);
    });
    
    // Stats counter animation with intersection observer
    const statsObserverOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const statsObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statsNumbers = entry.target.querySelectorAll('.stats-number');
                
                statsNumbers.forEach((numberElement, index) => {
                    const target = parseInt(numberElement.dataset.target);
                    
                    setTimeout(() => {
                        animateCounter(numberElement, target, 2000);
                    }, index * 200);
                });
                
                statsObserver.unobserve(entry.target);
            }
        });
    }, statsObserverOptions);
    
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        statsObserver.observe(statsSection);
    }
    
    // Enhanced card hover effects
    const cards = document.querySelectorAll('.card, .content-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            if (!this.style.transform.includes('scale')) {
                this.style.transform = this.style.transform + ' scale(1.02)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = this.style.transform.replace(' scale(1.02)', '');
        });
    });
    
    // Smooth scroll for internal links
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
    
    // Add loading animation to buttons
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.href && !this.href.includes('#') && !this.type === 'submit') {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 3000);
            }
        });
    });
    
    // Parallax effect for hero section
    let ticking = false;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero-section');
        if (hero) {
            hero.style.transform = `translateY(${scrolled * 0.3}px)`;
        }
        ticking = false;
    }
    
    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    });
    
    // Page load animation sequence
    setTimeout(() => {
        document.body.classList.add('page-loaded');
    }, 100);
    
    // Add stagger effect to multiple elements
    const staggerElements = document.querySelectorAll('.fade-in-up');
    staggerElements.forEach((element, index) => {
        element.style.animationDelay = `${index * 0.1}s`;
    });
    
    console.log('Public template animations loaded successfully!');
});

// Utility functions for specific pages
window.PublicTemplate = {
    // Initialize form filters
    initializeFilters: function(formId) {
        const form = document.getElementById(formId);
        if (form) {
            form.addEventListener('submit', function(e) {
                console.log('Form submitted:', formId);
            });
        }
    },
    
    // Initialize search functionality
    initializeSearch: function(searchInputId, resultsContainerId) {
        const searchInput = document.getElementById(searchInputId);
        const resultsContainer = document.getElementById(resultsContainerId);
        
        if (searchInput && resultsContainer) {
            let timeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    // Implement search logic here
                    console.log('Search query:', this.value);
                }, 500);
            });
        }
    },
    
    // Initialize pagination
    initializePagination: function() {
        const paginationLinks = document.querySelectorAll('.pagination .page-link');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.href) {
                    e.preventDefault();
                    // Add loading state
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    // Navigate after short delay
                    setTimeout(() => {
                        window.location.href = this.href;
                    }, 300);
                }
            });
        });
    },
    
    // Show loading state
    showLoading: function(element) {
        if (element) {
            element.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
        }
    },
    
    // Hide loading state
    hideLoading: function(element, originalText) {
        if (element) {
            element.innerHTML = originalText;
        }
    }
};