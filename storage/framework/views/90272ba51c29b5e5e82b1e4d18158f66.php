<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\GuestLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        .login-container {
            min-height: 100vh;
            width: 100vw;
            background: linear-gradient(
                135deg, 
                rgba(26, 32, 44, 0.8) 0%, 
                rgba(49, 130, 206, 0.7) 50%, 
                rgba(26, 32, 44, 0.8) 100%
            ),
            url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2032&q=80') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            width: 90%;
            max-width: 400px;
            padding: 30px;
            position: relative;
            z-index: 10;
        }

        .school-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .school-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #1565c0, #1976d2, #2196f3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            box-shadow: 0 8px 25px rgba(21, 101, 192, 0.3);
        }

        .school-logo i {
            font-size: 2.2rem;
            color: white;
        }

        .school-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
            line-height: 1.3;
        }

        .school-subtitle {
            color: var(--dark-gray);
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: var(--primary-color);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 14px 45px 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
            background: white;
        }

        .form-input::placeholder {
            color: #a0aec0;
        }

        .input-icon {
            position: absolute;
            right: 14px;
            top: 32px;
            color: var(--dark-gray);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .form-group:focus-within .input-icon {
            color: var(--secondary-color);
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .custom-checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid #e2e8f0;
            border-radius: 4px;
            margin-right: 10px;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .custom-checkbox input {
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            position: absolute;
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
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .checkmark::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 1px;
            width: 4px;
            height: 8px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg) scale(0);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .checkbox-label {
            font-size: 0.85rem;
            color: var(--dark-gray);
            cursor: pointer;
            user-select: none;
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(49, 130, 206, 0.3);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(49, 130, 206, 0.4);
        }

        .login-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 16px;
            color: var(--secondary-color);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        .error-message {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #dc3545;
            padding: 10px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            margin-top: 6px;
        }

        .success-message {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745;
            padding: 10px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            margin-bottom: 20px;
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
            border-radius: 20px;
            z-index: 100;
        }

        .spinner {
            width: 30px;
            height: 30px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--secondary-color);
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
                padding: 25px 20px;
                max-width: none;
                width: calc(100% - 40px);
            }

            .school-title {
                font-size: 1.2rem;
            }

            .school-logo {
                width: 70px;
                height: 70px;
            }

            .school-logo i {
                font-size: 2rem;
            }
        }
    </style>

    <div class="login-container">
        <div class="login-card">
            <!-- Loading Overlay -->
            <div class="loading-overlay" id="loadingOverlay">
                <div class="spinner"></div>
            </div>

            <!-- School Header -->
            <div class="school-header">
                <div class="school-logo">
                    <i class="fas fa-industry"></i>
                </div>
                <h1 class="school-title">SMK PGRI 2 Ponorogo</h1>
                <p class="school-subtitle">Portal Akademik</p>
            </div>

            <!-- Session Status -->
            <?php if(session('status')): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>" id="loginForm">
                <?php echo csrf_field(); ?>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label"><?php echo e(__('Email')); ?></label>
                    <input id="email" 
                           class="form-input" 
                           type="email" 
                           name="email" 
                           value="<?php echo e(old('email')); ?>" 
                           required 
                           autofocus 
                           autocomplete="username"
                           placeholder="Masukkan email Anda" />
                    <i class="fas fa-envelope input-icon"></i>
                    <?php if($errors->get('email')): ?>
                        <div class="error-message">
                            <i class="fas fa-exclamation-triangle"></i> <?php echo e(implode(', ', $errors->get('email'))); ?>

                        </div>
                    <?php endif; ?>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label"><?php echo e(__('Password')); ?></label>
                    <input id="password" 
                           class="form-input" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           placeholder="Masukkan password Anda" />
                    <i class="fas fa-lock input-icon toggle-password" onclick="togglePassword()"></i>
                    <?php if($errors->get('password')): ?>
                        <div class="error-message">
                            <i class="fas fa-exclamation-triangle"></i> <?php echo e(implode(', ', $errors->get('password'))); ?>

                        </div>
                    <?php endif; ?>
                </div>

                <!-- Remember Me -->
                <div class="checkbox-container">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="remember" id="remember_me">
                        <span class="checkmark"></span>
                    </label>
                    <label for="remember_me" class="checkbox-label"><?php echo e(__('Remember me')); ?></label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> <?php echo e(__('Log in')); ?>

                </button>

                <!-- Forgot Password Link -->
                <?php if(Route::has('password.request')): ?>
                    <a class="forgot-password" href="<?php echo e(route('password.request')); ?>">
                        <i class="fas fa-key"></i> <?php echo e(__('Forgot your password?')); ?>

                    </a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form submission with loading animation
            const form = document.getElementById('loginForm');
            const loadingOverlay = document.getElementById('loadingOverlay');

            form.addEventListener('submit', function(e) {
                // Show loading overlay
                loadingOverlay.style.display = 'flex';
                
                // Change button text
                const submitBtn = form.querySelector('.login-btn');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
                submitBtn.disabled = true;
            });

            // Email validation
            const emailInput = document.getElementById('email');
            emailInput.addEventListener('input', function() {
                const isValid = this.checkValidity();
                const icon = this.parentElement.querySelector('.input-icon');
                
                if (isValid && this.value.includes('@')) {
                    this.style.borderColor = '#28a745';
                    icon.className = 'fas fa-check input-icon';
                    icon.style.color = '#28a745';
                } else if (this.value.length > 0) {
                    this.style.borderColor = '#dc3545';
                    icon.className = 'fas fa-envelope input-icon';
                    icon.style.color = '#dc3545';
                } else {
                    this.style.borderColor = '#e2e8f0';
                    icon.className = 'fas fa-envelope input-icon';
                    icon.style.color = '#718096';
                }
            });

            // Password strength indicator
            const passwordInput = document.getElementById('password');
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
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/auth/login.blade.php ENDPATH**/ ?>