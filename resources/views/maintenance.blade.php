<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mode Maintenance - {{ $school_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .maintenance-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .pulse-slow {
            animation: pulse 3s infinite;
        }
        
        .maintenance-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .maintenance-icon {
            background: linear-gradient(135deg, #ffeaa7, #fab1a0);
            box-shadow: 0 10px 30px rgba(255, 234, 167, 0.3);
        }
    </style>
</head>
<body class="maintenance-bg">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full">
            <!-- Maintenance Card -->
            <div class="maintenance-card rounded-2xl p-8 text-center shadow-2xl">
                <!-- School Logo -->
                @if($school_logo)
                    <div class="mb-6">
                        <img src="{{ asset('storage/' . $school_logo) }}" 
                             alt="Logo {{ $school_name }}" 
                             class="w-20 h-20 mx-auto rounded-xl shadow-lg">
                    </div>
                @endif
                
                <!-- Maintenance Icon -->
                <div class="maintenance-icon w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 floating">
                    <i class="fas fa-tools text-3xl text-white"></i>
                </div>
                
                <!-- Title -->
                <h1 class="text-3xl font-bold text-white mb-4">
                    Mode Maintenance
                </h1>
                
                <!-- School Name -->
                <h2 class="text-xl font-semibold text-blue-100 mb-6">
                    {{ $school_name }}
                </h2>
                
                <!-- Message -->
                <div class="bg-white bg-opacity-20 rounded-xl p-6 mb-6">
                    <p class="text-white text-lg leading-relaxed">
                        <i class="fas fa-info-circle text-blue-200 mr-2"></i>
                        Website sedang dalam tahap pemeliharaan untuk meningkatkan kualitas layanan.
                    </p>
                </div>
                
                <!-- Status -->
                <div class="flex items-center justify-center mb-6">
                    <div class="flex items-center bg-yellow-500 bg-opacity-20 rounded-full px-4 py-2">
                        <div class="w-3 h-3 bg-yellow-400 rounded-full pulse-slow mr-3"></div>
                        <span class="text-yellow-100 font-medium">Sedang Maintenance</span>
                    </div>
                </div>
                
                <!-- Expected Time -->
                <div class="bg-white bg-opacity-10 rounded-lg p-4 mb-6">
                    <p class="text-blue-100 text-sm">
                        <i class="fas fa-clock mr-2"></i>
                        Estimasi selesai: Segera
                    </p>
                </div>
                
                <!-- Contact Information -->
                @if($school_email || $school_phone)
                    <div class="border-t border-white border-opacity-20 pt-6">
                        <p class="text-blue-100 text-sm mb-3">
                            Untuk informasi lebih lanjut, hubungi:
                        </p>
                        <div class="space-y-2">
                            @if($school_email)
                                <div class="flex items-center justify-center text-white">
                                    <i class="fas fa-envelope mr-2 text-blue-200"></i>
                                    <a href="mailto:{{ $school_email }}" 
                                       class="hover:text-blue-200 transition-colors">
                                        {{ $school_email }}
                                    </a>
                                </div>
                            @endif
                            @if($school_phone)
                                <div class="flex items-center justify-center text-white">
                                    <i class="fas fa-phone mr-2 text-blue-200"></i>
                                    <a href="tel:{{ $school_phone }}" 
                                       class="hover:text-blue-200 transition-colors">
                                        {{ $school_phone }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                
                <!-- Admin Access -->
                <div class="mt-8 pt-6 border-t border-white border-opacity-20">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-lg transition-all duration-200 text-sm">
                        <i class="fas fa-user-shield mr-2"></i>
                        Akses Admin
                    </a>
                </div>
            </div>
            
            <!-- Refresh Button -->
            <div class="text-center mt-6">
                <button onclick="location.reload()" 
                        class="inline-flex items-center px-6 py-3 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-xl transition-all duration-200 backdrop-blur-sm">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Refresh Halaman
                </button>
            </div>
        </div>
    </div>
    
    <!-- Auto Refresh -->
    <script>
        // Auto refresh every 30 seconds
        setTimeout(function() {
            location.reload();
        }, 30000);
        
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add click effect to maintenance icon
            const icon = document.querySelector('.maintenance-icon');
            if (icon) {
                icon.addEventListener('click', function() {
                    this.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 200);
                });
            }
        });
    </script>
</body>
</html>