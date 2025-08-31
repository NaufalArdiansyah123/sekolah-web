<x-guest-layout>
    <style>
        :root {
            --primary-color: #1a202c;
            --secondary-color: #3182ce;
            --accent-color: #4299e1;
            --light-gray: #f7fafc;
            --dark-gray: #718096;
            --glass-bg: rgba(26, 32, 44, 0.95);
            --gradient-primary: linear-gradient(135deg, #1a202c, #3182ce);
            --gradient-light: linear-gradient(135deg, rgba(49, 130, 206, 0.1), rgba(66, 153, 225, 0.05));
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            min-height: 100vh;
            background: linear-gradient(
                135deg, 
                rgba(26, 32, 44, 0.9) 0%, 
                rgba(49, 130, 206, 0.8) 50%, 
                rgba(26, 32, 44, 0.9) 100%
            ),
            url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2032&q=80') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(49, 130, 206, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(66, 153, 225, 0.3) 0%, transparent 50%);
            z-index: 1;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .floating-element {
            position: absolute;
            color: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            top: 10%;
            left: 10%;
            font-size: 3rem;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            top: 20%;
            right: 15%;
            font-size: 2.5rem;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            bottom: 20%;
            left: 15%;
            font-size: 2rem;
            animation-delay: 4s;
        }

        .floating-element:nth-child(4) {
            bottom: 30%;
            right: 10%;
            font-size: 3.5rem;
            animation-delay: 1s;
        }

        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg);
                opacity: 0.1;
            }
            50% { 
                transform: translateY(-20px) rotate(10deg);
                opacity: 0.2;
            }
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 
                0 30px 80px rgba(0, 0, 0, 0.3),
                0 0 50px rgba(49, 130, 206, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            width: 100%;
            max-width: 420px;
            padding: 40px;
            position: relative;
            z-index: 10;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1a202c, #3182ce, #4299e1, #3182ce, #1a202c);
            background-size: 200% 100%;
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { background-position: -200% 0; }
            50% { background-position: 200% 0; }
        }

        .school-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .school-logo {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(49, 130, 206, 0.3);
            position: relative;
        }

        .school-logo::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #3182ce, #4299e1, #3182ce);
            border-radius: 50%;
            z-index: -1;
            animation: logoRotate 4s linear infinite;
        }

        @keyframes logoRotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .school-logo i {
            font-size: 2.5rem;
            color: white;
        }

        .school-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .school-subtitle {
            color: var(--dark-gray);
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--primary-color);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 
                0 0 0 3px rgba(49, 130, 206, 0.1),
                0 4px 15px rgba(49, 130, 206, 0.15);
            background: white;
            transform: translateY(-2px);
        }

        .form-input::placeholder {
            color: #a0aec0;
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dark-gray);
            transition: all 0.3s ease;
        }

        .form-group:focus-within .input-icon {
            color: var(--secondary-color);
            transform: translateY(-50%) scale(1.1);
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }

        .custom-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            margin-right: 12px;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .custom-checkbox input {
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .custom-checkbox input:checked + .checkmark {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .custom-checkbox input:checked + .checkmark::after {
            opacity: 1;
            transform: rotate(45deg) scale(1);
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .checkmark::after {
            content: '';
            position: absolute;
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg) scale(0);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .checkbox-label {
            font-size: 0.9rem;
            color: var(--dark-gray);
            cursor: pointer;
            user-select: none;
        }

        .login-btn {
            width: 100%;
            padding: 16px;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
            position: relative;
            overflow: hidden;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: left 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(49, 130, 206, 0.4);
            background: linear-gradient(135deg, #2d3748, #2b6cb0);
        }

        .login-btn:active {
            transform: translateY(-1px);
        }

        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--secondary-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .forgot-password::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--secondary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .forgot-password:hover::after {
            width: 100%;
        }

        .forgot-password:hover {
            color: var(--primary-color);
            text-decoration: none;
        }

        .error-message {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #dc3545;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-top: 8px;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .success-message {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-bottom: 24px;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            border-radius: 24px;
            z-index: 100;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--secondary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-card {
                margin: 20px;
                padding: 30px 25px;
                max-width: none;
            }

            .school-title {
                font-size: 1.3rem;
            }

            .floating-element {
                display: none;
            }
        }

        /* Animation Classes */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease forwards;
        }

        .fade-in-up:nth-child(2) { animation-delay: 0.2s; }
        .fade-in-up:nth-child(3) { animation-delay: 0.4s; }
        .fade-in-up:nth-child(4) { animation-delay: 0.6s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Input Focus Animation */
        .form-group {
            position: relative;
        }

        .form-group::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--secondary-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-50%);
        }

        .form-group:focus-within::after {
            width: 100%;
        }
    </style>

    <div class="login-container">
        <!-- Floating School Elements -->
        <div class="floating-elements">
            <div class="floating-element">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="floating-element">
                <i class="fas fa-book"></i>
            </div>
            <div class="floating-element">
                <i class="fas fa-pencil-alt"></i>
            </div>
            <div class="floating-element">
                <i class="fas fa-school"></i>
            </div>
        </div>

        <div class="login-card">
            <!-- Loading Overlay -->
            <div class="loading-overlay" id="loadingOverlay">
                <div class="spinner"></div>
            </div>

            <!-- School Header -->
            <div class="school-header fade-in-up">
                <div class="school-logo">
                    <i class="fas fa-school"></i>
                </div>
                <h1 class="school-title">SMA Negeri 1 Balong</h1>
                <p class="school-subtitle">Portal Akademik</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="success-message fade-in-up">
                    <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm" class="fade-in-up">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <div style="position: relative;">
                        <input id="email" 
                               class="form-input" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               autocomplete="username"
                               placeholder="Masukkan email Anda" />
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                    @if ($errors->get('email'))
                        <div class="error-message">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ implode(', ', $errors->get('email')) }}
                        </div>
                    @endif
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <div style="position: relative;">
                        <input id="password" 
                               class="form-input" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="current-password"
                               placeholder="Masukkan password Anda" />
                        <i class="fas fa-lock input-icon toggle-password" 
                           onclick="togglePassword()" 
                           style="cursor: pointer;"></i>
                    </div>
                    @if ($errors->get('password'))
                        <div class="error-message">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ implode(', ', $errors->get('password')) }}
                        </div>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="checkbox-container">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="remember" id="remember_me">
                        <span class="checkmark"></span>
                    </label>
                    <label for="remember_me" class="checkbox-label">{{ __('Remember me') }}</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt me-2"></i>{{ __('Log in') }}
                </button>

                <!-- Forgot Password Link -->
                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        <i class="fas fa-key me-1"></i>{{ __('Forgot your password?') }}
                    </a>
                @endif
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add focus/blur animations to inputs
            const inputs = document.querySelectorAll('.form-input');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.querySelector('.input-icon').style.transform = 'translateY(-50%) scale(1.1)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.querySelector('.input-icon').style.transform = 'translateY(-50%) scale(1)';
                });
            });

            // Form submission with loading animation
            const form = document.getElementById('loginForm');
            const loadingOverlay = document.getElementById('loadingOverlay');

            form.addEventListener('submit', function(e) {
                // Show loading overlay
                loadingOverlay.style.display = 'flex';
                
                // Change button text
                const submitBtn = form.querySelector('.login-btn');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                submitBtn.disabled = true;
            });

            // Add typing animation to placeholders
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            if (emailInput && !emailInput.value) {
                typewriterEffect(emailInput, 'Masukkan email Anda');
            }

            // Email validation animation
            emailInput.addEventListener('input', function() {
                const isValid = this.checkValidity();
                if (isValid && this.value.includes('@')) {
                    this.style.borderColor = '#28a745';
                    this.parentElement.querySelector('.input-icon').className = 'fas fa-check input-icon';
                    this.parentElement.querySelector('.input-icon').style.color = '#28a745';
                } else if (this.value.length > 0) {
                    this.style.borderColor = '#dc3545';
                    this.parentElement.querySelector('.input-icon').className = 'fas fa-envelope input-icon';
                    this.parentElement.querySelector('.input-icon').style.color = '#dc3545';
                } else {
                    this.style.borderColor = '#e2e8f0';
                    this.parentElement.querySelector('.input-icon').className = 'fas fa-envelope input-icon';
                    this.parentElement.querySelector('.input-icon').style.color = '#718096';
                }
            });

            // Password strength indicator
            passwordInput.addEventListener('input', function() {
                const strength = getPasswordStrength(this.value);
                const icon = this.parentElement.querySelector('.input-icon');
                
                if (this.value.length === 0) {
                    this.style.borderColor = '#e2e8f0';
                    icon.style.color = '#718096';
                } else if (strength < 3) {
                    this.style.borderColor = '#dc3545';
                    icon.style.color = '#dc3545';
                } else if (strength < 5) {
                    this.style.borderColor = '#ffc107';
                    icon.style.color = '#ffc107';
                } else {
                    this.style.borderColor = '#28a745';
                    icon.style.color = '#28a745';
                }
            });
        });

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.querySelector('.toggle-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'fas fa-eye-slash input-icon toggle-password';
            } else {
                passwordInput.type = 'password';
                icon.className = 'fas fa-lock input-icon toggle-password';
            }
        }

        function getPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            return strength;
        }

        function typewriterEffect(element, text) {
            let i = 0;
            element.placeholder = '';
            
            function type() {
                if (i < text.length) {
                    element.placeholder += text.charAt(i);
                    i++;
                    setTimeout(type, 100);
                }
            }
            
            setTimeout(type, 1000);
        }

        // Add particle effect on successful login
        function createParticles() {
            const container = document.querySelector('.login-container');
            
            for (let i = 0; i < 20; i++) {
                const particle = document.createElement('div');
                particle.style.cssText = `
                    position: absolute;
                    width: 4px;
                    height: 4px;
                    background: #4299e1;
                    border-radius: 50%;
                    pointer-events: none;
                    z-index: 1000;
                    left: 50%;
                    top: 50%;
                    animation: explode 1s ease-out forwards;
                `;
                
                particle.style.setProperty('--random-x', (Math.random() - 0.5) * 200 + 'px');
                particle.style.setProperty('--random-y', (Math.random() - 0.5) * 200 + 'px');
                
                container.appendChild(particle);
                
                setTimeout(() => particle.remove(), 1000);
            }
        }

        // Add CSS for particle animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes explode {
                0% {
                    transform: translate(-50%, -50%) scale(1);
                    opacity: 1;
                }
                100% {
                    transform: translate(
                        calc(-50% + var(--random-x)), 
                        calc(-50% + var(--random-y))
                    ) scale(0);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</x-guest-layout>