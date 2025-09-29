# Animation System Guide

## Overview
Sistem animasi yang komprehensif untuk semua halaman public dengan loading screen, page transitions, dan scroll-based animations.

## Features

### 1. Page Loading Animation
- **Loading Screen**: Gradient background dengan logo sekolah
- **Progress Bar**: Animated progress indicator
- **Scroll Prevention**: Mencegah scrolling selama loading
- **Smooth Transition**: Fade out loading dan fade in content

### 2. Content Animations
- **Fade Animations**: fade-in, fade-in-up, fade-in-down, fade-in-left, fade-in-right
- **Scale Animations**: scale-in, scale-in-center
- **Slide Animations**: slide-in-up, slide-in-down
- **Special Effects**: rotate-in, bounce-in

### 3. Auto-Applied Animations
- **Sections**: Otomatis mendapat fade-in-up
- **Cards**: Otomatis mendapat fade-in-up dengan stagger
- **Headings**: Otomatis mendapat fade-in-up
- **Paragraphs**: Otomatis mendapat fade-in
- **Images**: Otomatis mendapat fade-in-up
- **Buttons**: Otomatis mendapat fade-in-up

### 4. Interactive Features
- **Hover Effects**: hover-lift, hover-scale, hover-rotate
- **Button Loading**: Spinner animation saat navigasi
- **Smooth Scroll**: Untuk anchor links
- **Counter Animation**: Untuk angka statistik

## Usage Examples

### Basic Animation Classes
```html
<!-- Fade animations -->
<div class="fade-in">Content</div>
<div class="fade-in-up">Content</div>
<div class="fade-in-left">Content</div>

<!-- Scale animations -->
<div class="scale-in">Content</div>

<!-- Slide animations -->
<div class="slide-in-up">Content</div>
```

### Staggered Animations
```html
<div class="fade-in-up stagger-1">First item</div>
<div class="fade-in-up stagger-2">Second item</div>
<div class="fade-in-up stagger-3">Third item</div>
```

### Custom Attributes
```html
<!-- Custom stagger delay -->
<div class="fade-in-up" data-stagger="3">Content</div>

<!-- Custom duration -->
<div class="fade-in-up" data-duration="1200">Content</div>

<!-- Counter animation -->
<span class="counter" data-target="1000" data-duration="2000">0</span>
```

### Hover Effects
```html
<div class="card hover-lift">Card with lift effect</div>
<button class="btn hover-scale">Button with scale effect</button>
```

### Disable Animations
```html
<!-- Prevent auto-animation -->
<div class="no-animate">No animation applied</div>

<!-- Prevent hover effects -->
<div class="card no-hover">No hover effect</div>
```

## JavaScript API

### Add Animation Programmatically
```javascript
// Add animation to element
addAnimation(element, 'fadeInUp', {
    stagger: 2,
    duration: 1000
});

// Remove animation
removeAnimation(element);

// Trigger animation manually
triggerAnimation(element);
```

### Animation Controller
```javascript
// Access global controller
window.animationController.addAnimation(element, 'fadeInUp');
window.animationController.removeAnimation(element);
window.animationController.triggerElementAnimation(element);
```

## Performance Features

### Mobile Optimization
- Reduced animation duration pada mobile
- Simplified animations untuk performa
- Disabled complex animations pada device rendah

### Accessibility
- Respect `prefers-reduced-motion`
- Fallback untuk browser tanpa JavaScript
- Progressive enhancement approach

### Browser Support
- Modern browsers dengan Intersection Observer
- Fallback untuk browser lama
- Graceful degradation

## Configuration

### CSS Variables
```css
:root {
    --animation-duration: 0.8s;
    --animation-easing: cubic-bezier(0.4, 0, 0.2, 1);
    --stagger-delay: 0.1s;
}
```

### JavaScript Config
```javascript
const config = {
    observerOptions: {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    },
    staggerDelay: 100,
    animationDuration: 800,
    isMobile: window.innerWidth <= 768
};
```

## Best Practices

1. **Use Semantic Classes**: Pilih animasi yang sesuai dengan konten
2. **Stagger Wisely**: Gunakan stagger untuk grup elemen
3. **Performance First**: Hindari animasi berlebihan pada mobile
4. **Accessibility**: Selalu test dengan reduced motion
5. **Progressive Enhancement**: Pastikan konten tetap accessible tanpa JavaScript

## Troubleshooting

### Animation Not Working
1. Check if element has `no-animate` class
2. Verify CSS and JS files are loaded
3. Check browser console for errors
4. Ensure element is in viewport

### Performance Issues
1. Reduce animation complexity on mobile
2. Use `will-change` CSS property sparingly
3. Avoid animating layout properties
4. Use `transform` and `opacity` for smooth animations

### Accessibility Issues
1. Test with `prefers-reduced-motion`
2. Ensure content is readable without animations
3. Provide alternative navigation methods
4. Test with screen readers