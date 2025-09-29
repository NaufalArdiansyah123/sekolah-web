/**
 * Enhanced Animation System for Public Pages
 * Provides comprehensive animation functionality with performance optimization
 */

(function() {
    'use strict';
    
    // Animation configuration
    const config = {
        observerOptions: {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        },
        staggerDelay: 100,
        animationDuration: 800,
        isMobile: window.innerWidth <= 768,
        isReducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches
    };
    
    // Animation classes mapping
    const animationClasses = {
        fadeIn: 'fade-in',
        fadeInUp: 'fade-in-up',
        fadeInDown: 'fade-in-down',
        fadeInLeft: 'fade-in-left',
        fadeInRight: 'fade-in-right',
        scaleIn: 'scale-in',
        slideInUp: 'slide-in-up',
        slideInDown: 'slide-in-down',
        rotateIn: 'rotate-in',
        bounceIn: 'bounce-in'
    };
    
    // Main animation controller
    class AnimationController {
        constructor() {
            this.observer = null;
            this.animatedElements = new Set();
            this.init();
        }
        
        init() {
            if (config.isReducedMotion) {
                this.disableAnimations();
                return;
            }
            
            this.setupIntersectionObserver();
            this.autoApplyAnimations();
            this.setupEventListeners();
            
            // Initialize after DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => this.initializeAnimations());
            } else {
                this.initializeAnimations();
            }
        }
        
        setupIntersectionObserver() {
            this.observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !this.animatedElements.has(entry.target)) {
                        this.triggerAnimation(entry.target);
                        this.animatedElements.add(entry.target);
                        this.observer.unobserve(entry.target);
                    }
                });
            }, config.observerOptions);
        }
        
        triggerAnimation(element) {
            // Add visible class for CSS animations
            element.classList.add('visible');
            
            // Handle staggered animations
            if (element.hasAttribute('data-stagger')) {
                const delay = parseInt(element.getAttribute('data-stagger')) * config.staggerDelay;
                element.style.animationDelay = `${delay}ms`;
            }
            
            // Handle custom animation duration
            if (element.hasAttribute('data-duration')) {
                const duration = parseInt(element.getAttribute('data-duration'));
                element.style.animationDuration = `${duration}ms`;
            }
        }
        
        autoApplyAnimations() {
            // Apply animations to common elements
            this.applyToElements('section', 'fade-in-up');
            this.applyToElements('.card', 'fade-in-up', true);
            this.applyToElements('h1, h2, h3, h4, h5, h6', 'fade-in-up');
            this.applyToElements('p', 'fade-in');
            this.applyToElements('img', 'fade-in-up');
            this.applyToElements('.btn', 'fade-in-up');
            this.applyToElements('.alert', 'fade-in-down');
            this.applyToElements('.badge', 'scale-in');
        }
        
        applyToElements(selector, animationClass, stagger = false) {
            const elements = document.querySelectorAll(selector);
            elements.forEach((element, index) => {
                if (!element.classList.contains('no-animate') && !this.hasAnimationClass(element)) {
                    element.classList.add(animationClass);
                    
                    if (stagger) {
                        element.setAttribute('data-stagger', index);
                    }
                    
                    this.observer.observe(element);
                }
            });
        }
        
        hasAnimationClass(element) {
            return Object.values(animationClasses).some(className => 
                element.classList.contains(className)
            );
        }
        
        initializeAnimations() {
            // Initialize counter animations
            this.initCounters();
            
            // Initialize text reveal animations
            this.initTextReveal();
            
            // Initialize hover effects
            this.initHoverEffects();
            
            // Initialize scroll-based animations
            this.initScrollAnimations();
        }
        
        initCounters() {
            const counters = document.querySelectorAll('.counter[data-target]');
            counters.forEach(counter => {
                this.observer.observe(counter);
                counter.addEventListener('visible', () => this.animateCounter(counter));
            });
        }
        
        animateCounter(element) {
            const target = parseInt(element.getAttribute('data-target'));
            const duration = parseInt(element.getAttribute('data-duration')) || 2000;
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
                element.textContent = Math.floor(current).toLocaleString();
            }, 16);
        }
        
        initTextReveal() {
            const textElements = document.querySelectorAll('.text-reveal');
            textElements.forEach(element => {
                const text = element.textContent;
                const words = text.split(' ');
                element.innerHTML = words.map(word => `<span>${word}</span>`).join(' ');
                
                const spans = element.querySelectorAll('span');
                spans.forEach((span, index) => {
                    span.style.animationDelay = `${index * 0.1}s`;
                });
                
                this.observer.observe(element);
            });
        }
        
        initHoverEffects() {
            // Add hover classes to interactive elements
            const interactiveElements = document.querySelectorAll('.card, .btn, a[href]');
            interactiveElements.forEach(element => {
                if (!element.classList.contains('no-hover')) {
                    element.classList.add('hover-lift');
                }
            });
        }
        
        initScrollAnimations() {
            let ticking = false;
            
            const handleScroll = () => {
                if (!ticking) {
                    requestAnimationFrame(() => {
                        this.updateScrollAnimations();
                        ticking = false;
                    });
                    ticking = true;
                }
            };
            
            window.addEventListener('scroll', handleScroll, { passive: true });
        }
        
        updateScrollAnimations() {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.parallax');
            
            parallaxElements.forEach((element, index) => {
                const speed = element.getAttribute('data-speed') || 0.5;
                const yPos = -(scrolled * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
        }
        
        setupEventListeners() {
            // Handle visibility change
            document.addEventListener('visibilitychange', () => {
                const animatedElements = document.querySelectorAll('[class*=\"fade-in\"], [class*=\"scale-in\"], [class*=\"slide-in\"]');
                animatedElements.forEach(el => {
                    el.style.animationPlayState = document.hidden ? 'paused' : 'running';
                });
            });
            
            // Handle window resize
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    config.isMobile = window.innerWidth <= 768;
                    this.updateMobileAnimations();
                }, 250);
            });
        }
        
        updateMobileAnimations() {
            if (config.isMobile) {
                // Simplify animations for mobile
                const complexAnimations = document.querySelectorAll('.rotate-in, .bounce-in');
                complexAnimations.forEach(element => {
                    element.classList.remove('rotate-in', 'bounce-in');
                    element.classList.add('fade-in-up');
                });
            }
        }
        
        disableAnimations() {
            // Add no-js class to disable animations
            document.documentElement.classList.add('no-js');
            
            // Remove all animation classes
            const animatedElements = document.querySelectorAll('[class*=\"fade-in\"], [class*=\"scale-in\"], [class*=\"slide-in\"]');
            animatedElements.forEach(element => {
                Object.values(animationClasses).forEach(className => {
                    element.classList.remove(className);
                });
                element.style.opacity = '1';
                element.style.transform = 'none';
            });
        }
        
        // Public methods
        addAnimation(element, animationType, options = {}) {
            if (config.isReducedMotion) return;
            
            const animationClass = animationClasses[animationType];
            if (animationClass) {
                element.classList.add(animationClass);
                
                if (options.stagger) {
                    element.setAttribute('data-stagger', options.stagger);
                }
                
                if (options.duration) {
                    element.setAttribute('data-duration', options.duration);
                }
                
                this.observer.observe(element);
            }
        }
        
        removeAnimation(element) {
            Object.values(animationClasses).forEach(className => {
                element.classList.remove(className);
            });
            element.classList.remove('visible');
            this.animatedElements.delete(element);
        }
        
        triggerElementAnimation(element) {
            if (!this.animatedElements.has(element)) {
                this.triggerAnimation(element);
                this.animatedElements.add(element);
            }
        }
    }
    
    // Button loading animation
    class ButtonAnimations {
        static init() {
            const buttons = document.querySelectorAll('.btn[href], .btn[type=\"submit\"]');
            buttons.forEach(btn => {
                btn.addEventListener('click', this.handleButtonClick.bind(this));
            });
        }
        
        static handleButtonClick(e) {
            const button = e.currentTarget;
            
            if (button.href && !button.href.includes('#')) {
                const originalContent = button.innerHTML;
                button.innerHTML = '<i class=\"fas fa-spinner fa-spin me-2\"></i>Loading...';
                button.disabled = true;
                
                // Reset button after 3 seconds if navigation fails
                setTimeout(() => {
                    button.innerHTML = originalContent;
                    button.disabled = false;
                }, 3000);
            }
        }
    }
    
    // Smooth scroll functionality
    class SmoothScroll {
        static init() {
            const anchors = document.querySelectorAll('a[href^=\"#\"]');
            anchors.forEach(anchor => {
                anchor.addEventListener('click', this.handleAnchorClick.bind(this));
            });
        }
        
        static handleAnchorClick(e) {
            const targetId = e.currentTarget.getAttribute('href');
            
            if (targetId && targetId !== '#' && targetId.length > 1) {
                try {
                    const target = document.querySelector(targetId);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start',
                            inline: 'nearest'
                        });
                    }
                } catch (error) {
                    console.warn('Invalid selector:', targetId);
                }
            }
        }
    }
    
    // Initialize everything
    function initializeAnimationSystem() {
        // Create global animation controller
        window.animationController = new AnimationController();
        
        // Initialize button animations
        ButtonAnimations.init();
        
        // Initialize smooth scroll
        SmoothScroll.init();
        
        // Expose public API
        window.addAnimation = (element, type, options) => {
            window.animationController.addAnimation(element, type, options);
        };
        
        window.removeAnimation = (element) => {
            window.animationController.removeAnimation(element);
        };
        
        window.triggerAnimation = (element) => {
            window.animationController.triggerElementAnimation(element);
        };
    }
    
    // Auto-initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeAnimationSystem);
    } else {
        initializeAnimationSystem();
    }
    
})();