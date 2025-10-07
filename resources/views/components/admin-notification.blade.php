@props([
    'type' => 'info',
    'title' => '',
    'message' => '',
    'details' => [],
    'dismissible' => true,
    'timeout' => 5000
])

@php
    $typeClasses = [
        'success' => 'bg-green-50 border-green-200 text-green-800 dark:bg-green-900/20 dark:border-green-800 dark:text-green-200',
        'error' => 'bg-red-50 border-red-200 text-red-800 dark:bg-red-900/20 dark:border-red-800 dark:text-red-200',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800 dark:bg-yellow-900/20 dark:border-yellow-800 dark:text-yellow-200',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800 dark:bg-blue-900/20 dark:border-blue-800 dark:text-blue-200'
    ];
    
    $iconClasses = [
        'success' => 'text-green-400',
        'error' => 'text-red-400',
        'warning' => 'text-yellow-400',
        'info' => 'text-blue-400'
    ];
    
    $icons = [
        'success' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'error' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
        'warning' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z',
        'info' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    ];
@endphp

<div 
    x-data="{ 
        show: true, 
        init() { 
            if ({{ $timeout }} > 0) {
                setTimeout(() => this.show = false, {{ $timeout }});
            }
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-2"
    class="rounded-lg border p-4 {{ $typeClasses[$type] ?? $typeClasses['info'] }}"
    role="alert"
>
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 {{ $iconClasses[$type] ?? $iconClasses['info'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icons[$type] ?? $icons['info'] }}" />
            </svg>
        </div>
        <div class="ml-3 flex-1">
            @if($title)
                <h3 class="text-sm font-medium">{{ $title }}</h3>
            @endif
            
            @if($message)
                <div class="mt-1 text-sm">{{ $message }}</div>
            @endif
            
            @if(!empty($details))
                <div class="mt-2 text-xs opacity-75">
                    @if(isset($details['time']))
                        <div class="flex items-center gap-1 mb-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ $details['time'] }}</span>
                        </div>
                    @endif
                    
                    @if(isset($details['action']))
                        <div class="flex items-center gap-1 mb-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span>Aksi: {{ ucfirst($details['action']) }}</span>
                        </div>
                    @endif
                    
                    @if(isset($details['status']))
                        <div class="flex items-center gap-1 mb-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Status: {{ $details['status'] }}</span>
                        </div>
                    @endif
                    
                    @if(isset($details['facilities_count']))
                        <div class="flex items-center gap-1 mb-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h3m3 0h3M7 11h3m3 0h3m-6 4h3"/>
                            </svg>
                            <span>{{ $details['facilities_count'] }} fasilitas</span>
                        </div>
                    @endif
                    
                    @if(isset($details['deleted_files']) && !empty($details['deleted_files']))
                        <div class="flex items-center gap-1 mb-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>File dihapus: {{ implode(', ', $details['deleted_files']) }}</span>
                        </div>
                    @endif
                    
                    @if(isset($details['changes']) && !empty($details['changes']))
                        <div class="mt-1">
                            <span class="font-medium">Perubahan:</span>
                            <ul class="list-disc list-inside ml-2 mt-1">
                                @foreach($details['changes'] as $field => $change)
                                    <li class="text-xs">
                                        @if(is_array($change) && isset($change['from'], $change['to']))
                                            {{ ucfirst(str_replace('_', ' ', $field)) }}: "{{ $change['from'] }}" → "{{ $change['to'] }}"
                                        @elseif(is_array($change) && isset($change['count']))
                                            {{ ucfirst(str_replace('_', ' ', $field)) }}: {{ $change['count'] }} item
                                        @else
                                            {{ ucfirst(str_replace('_', ' ', $field)) }}: {{ $change }}
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endif
            
            {{ $slot }}
        </div>
        
        @if($dismissible)
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button 
                        @click="show = false"
                        class="inline-flex rounded-md p-1.5 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors"
                        :class="{
                            'focus:ring-green-600 focus:ring-offset-green-50': '{{ $type }}' === 'success',
                            'focus:ring-red-600 focus:ring-offset-red-50': '{{ $type }}' === 'error',
                            'focus:ring-yellow-600 focus:ring-offset-yellow-50': '{{ $type }}' === 'warning',
                            'focus:ring-blue-600 focus:ring-offset-blue-50': '{{ $type }}' === 'info'
                        }"
                    >
                        <span class="sr-only">Tutup</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>