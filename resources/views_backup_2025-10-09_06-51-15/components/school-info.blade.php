{{-- School Info Component --}}
<div class="school-info">
    @if($schoolLogo)
        <div class="school-logo mb-3">
            <img src="{{ asset('storage/' . $schoolLogo) }}" 
                 alt="Logo {{ $schoolName }}" 
                 class="img-fluid"
                 style="max-height: 60px;">
        </div>
    @endif
    
    <h5 class="school-name">{{ $schoolName }}</h5>
    
    @if($schoolAddress)
        <p class="school-address mb-2">
            <i class="fas fa-map-marker-alt me-2"></i>
            {{ $schoolAddress }}
        </p>
    @endif
    
    @if($schoolPhone)
        <p class="school-phone mb-2">
            <i class="fas fa-phone me-2"></i>
            {{ $schoolPhone }}
        </p>
    @endif
    
    @if($schoolEmail)
        <p class="school-email mb-2">
            <i class="fas fa-envelope me-2"></i>
            <a href="mailto:{{ $schoolEmail }}" class="text-decoration-none">
                {{ $schoolEmail }}
            </a>
        </p>
    @endif
    
    @if($schoolWebsite)
        <p class="school-website mb-2">
            <i class="fas fa-globe me-2"></i>
            <a href="{{ $schoolWebsite }}" target="_blank" class="text-decoration-none">
                {{ $schoolWebsite }}
            </a>
        </p>
    @endif
    
    @if($principalName)
        <p class="principal-name mb-2">
            <i class="fas fa-user-tie me-2"></i>
            <strong>Kepala Sekolah:</strong> {{ $principalName }}
        </p>
    @endif
    
    @if($schoolAccreditation)
        <p class="school-accreditation mb-0">
            <i class="fas fa-award me-2"></i>
            <strong>Akreditasi:</strong> 
            <span class="badge bg-success">{{ $schoolAccreditation }}</span>
        </p>
    @endif
</div>