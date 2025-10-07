# Scroll Animation System Guide

## Overview
Sistem animasi scroll yang otomatis diterapkan ke semua halaman public untuk memberikan pengalaman visual yang menarik saat user melakukan scroll.

## Animation Types

### 1. Basic Scroll Animations
- **`.scroll-animate`**: Fade in dari bawah (translateY)
- **`.scroll-animate-left`**: Slide in dari kiri (translateX)
- **`.scroll-animate-right`**: Slide in dari kanan (translateX)
- **`.scroll-animate-scale`**: Scale in dari kecil ke normal
- **`.scroll-animate-fade`**: Simple fade in (opacity only)

### 2. Advanced Animations
- **`.scroll-animate-stagger`**: Staggered animation dengan delay
- **`.section-animate`**: Untuk section besar dengan movement lebih besar

## Auto-Applied Elements

### Sections
- Semua `<section>` mendapat `.section-animate`
- Animasi dari bawah dengan jarak 60px

### Cards
- Cards mendapat animasi bergantian:
  - Index 0, 3, 6... → `.scroll-animate-left`
  - Index 1, 4, 7... → `.scroll-animate`
  - Index 2, 5, 8... → `.scroll-animate-right`

### Headings
- Semua `h1, h2, h3, h4, h5, h6` mendapat `.scroll-animate-fade`

### Paragraphs
- Paragraf dengan teks > 50 karakter mendapat `.scroll-animate`

### Images
- Semua `img` mendapat `.scroll-animate-scale`

### Buttons
- Semua `.btn` mendapat `.scroll-animate`

### List Items
- Items dalam `ul, ol` mendapat `.scroll-animate-stagger`
- Dengan delay 0.1s, 0.2s, 0.3s, dst.

### Form Elements
- `.form-group, .mb-3, .form-floating` mendapat `.scroll-animate`

### Alerts
- `.alert, .notification, .toast` mendapat `.scroll-animate-fade`

### Table Rows
- `tbody tr` mendapat `.scroll-animate-stagger`

## Manual Usage

### HTML Classes
```html
<!-- Basic animations -->
<div class="scroll-animate">Fade in from bottom</div>
<div class="scroll-animate-left">Slide in from left</div>
<div class="scroll-animate-right">Slide in from right</div>
<div class="scroll-animate-scale">Scale in</div>
<div class="scroll-animate-fade">Fade in</div>

<!-- Staggered animation -->
<div class="scroll-animate-stagger">Item 1</div>
<div class="scroll-animate-stagger">Item 2</div>
<div class="scroll-animate-stagger">Item 3</div>

<!-- Section animation -->
<section class="section-animate">
    Large section content
</section>
```

### JavaScript API
```javascript
// Add animation to specific element
addScrollAnimation(element, 'scroll-animate-left');

// Refresh animations for dynamically loaded content
refreshScrollAnimations();

// Example usage
const newElement = document.createElement('div');
newElement.textContent = 'New content';
document.body.appendChild(newElement);
addScrollAnimation(newElement, 'scroll-animate-scale');
```

## Configuration

### Observer Options
```javascript
const observerOptions = {
    threshold: 0.1,           // Trigger when 10% visible
    rootMargin: '0px 0px -50px 0px'  // Trigger 50px before entering viewport
};
```

### Animation Timing
- **Duration**: 0.8s (0.6s on mobile)
- **Easing**: cubic-bezier(0.4, 0, 0.2, 1)
- **Stagger Delay**: 0.1s, 0.2s, 0.3s, etc.

## Mobile Optimizations

### Reduced Movement
- Smaller transform distances on mobile
- Faster animation duration (0.6s vs 0.8s)

### Performance
- Hardware-accelerated animations (transform, opacity)
- Efficient intersection observer
- No layout thrashing

## Accessibility

### Reduced Motion Support
```css
@media (prefers-reduced-motion: reduce) {
    /* All animations disabled */
    .scroll-animate,
    .scroll-animate-left,
    .scroll-animate-right,
    .scroll-animate-scale,
    .scroll-animate-fade,
    .scroll-animate-stagger,
    .section-animate {
        transition: none !important;
        opacity: 1 !important;
        transform: none !important;
    }
}
```

## Best Practices

### 1. Performance
- Use transform and opacity for animations
- Avoid animating layout properties
- Use intersection observer for efficiency

### 2. User Experience
- Don't overuse animations
- Respect user preferences (reduced motion)
- Ensure content is accessible without animations

### 3. Implementation
- Test on various devices and screen sizes
- Ensure animations don't interfere with functionality
- Provide fallbacks for older browsers

## Browser Support

### Modern Browsers
- Chrome 51+
- Firefox 55+
- Safari 12.1+
- Edge 15+

### Fallbacks
- Graceful degradation for older browsers
- No JavaScript fallback shows content immediately
- Progressive enhancement approach

## Troubleshooting

### Animation Not Working
1. Check if element has animation class
2. Verify element is in viewport
3. Check browser console for errors
4. Ensure intersection observer is supported

### Performance Issues
1. Reduce number of animated elements
2. Use simpler animations on mobile
3. Check for memory leaks in observers
4. Optimize animation timing

### Accessibility Issues
1. Test with reduced motion preference
2. Ensure keyboard navigation works
3. Verify screen reader compatibility
4. Provide skip animation option if needed

## Examples

### Card Grid with Staggered Animation
```html
<div class="row">
    <div class="col-md-4">
        <div class="card scroll-animate-left">Card 1</div>
    </div>
    <div class="col-md-4">
        <div class="card scroll-animate">Card 2</div>
    </div>
    <div class="col-md-4">
        <div class="card scroll-animate-right">Card 3</div>
    </div>
</div>
```

### Section with Mixed Animations
```html
<section class="section-animate">
    <h2 class="scroll-animate-fade">Section Title</h2>
    <p class="scroll-animate">Section description text...</p>
    <img src="image.jpg" class="scroll-animate-scale" alt="Image">
    <button class="btn btn-primary scroll-animate">Call to Action</button>
</section>
```