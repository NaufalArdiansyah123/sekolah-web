# Dark Mode Implementation Guide

## Overview
This document describes the comprehensive dark mode implementation across the school management system, ensuring consistent theming and user experience across all modules.

## Implementation Strategy

### 1. CSS Variables Approach
We use CSS custom properties (variables) to define color schemes that can be dynamically switched:

```css
:root {
    --bg-primary: #ffffff;
    --bg-secondary: #f8fafc;
    --bg-tertiary: #f1f5f9;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --text-tertiary: #9ca3af;
    --border-color: #e5e7eb;
    --shadow-color: rgba(0, 0, 0, 0.05);
}

.dark {
    --bg-primary: #1f2937;
    --bg-secondary: #111827;
    --bg-tertiary: #374151;
    --text-primary: #f9fafb;
    --text-secondary: #d1d5db;
    --text-tertiary: #9ca3af;
    --border-color: #374151;
    --shadow-color: rgba(0, 0, 0, 0.3);
}
```

### 2. JavaScript Toggle Implementation
Dark mode state is managed through localStorage and applied globally:

```javascript
let darkMode = localStorage.getItem('darkMode') === 'true';

function toggleDarkMode() {
    darkMode = !darkMode;
    localStorage.setItem('darkMode', darkMode);
    applyTheme();
}

function applyTheme() {
    if (darkMode) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
}
```

## Module Coverage

### ✅ Completed Modules

#### 1. **Assessment Management System**
- **Files**: `resources/views/teacher/assessment/*.blade.php`
- **Features**: 
  - Dashboard with statistics cards
  - Grades table with color-coded performance
  - Reports with charts and analytics
- **Implementation**: Full CSS variables with dark mode support

#### 2. **Teacher Dashboard**
- **Files**: `resources/views/teacher/dashboard.blade.php`
- **Features**: Statistics, quick actions, charts
- **Implementation**: Complete dark mode compatibility

#### 3. **Admin Dashboard**
- **Files**: `resources/views/admin/dashboard/*.blade.php`
- **Features**: System overview, user management
- **Implementation**: Full dark mode support

#### 4. **Student Dashboard**
- **Files**: `resources/views/student/dashboard.blade.php`
- **Features**: Academic progress, assignments
- **Implementation**: Dark mode compatible

#### 5. **Layout Components**
- **Files**: 
  - `resources/views/layouts/admin.blade.php`
  - `resources/views/layouts/teacher.blade.php`
  - `resources/views/layouts/student.blade.php`
- **Features**: Navigation, sidebar, toast notifications
- **Implementation**: Complete dark mode integration

#### 6. **Extracurricular Management**
- **Files**: `resources/views/admin/extracurriculars/*.blade.php`
- **Features**: CRUD operations, member management
- **Implementation**: Dark mode compatible

#### 7. **QR Attendance System**
- **Files**: `resources/views/admin/qr-attendance/*.blade.php`
- **Features**: QR generation, attendance tracking
- **Implementation**: Dark mode support

#### 8. **Blog & Content Management**
- **Files**: `resources/views/admin/posts/blog/*.blade.php`
- **Features**: Content creation, editing
- **Implementation**: Dark mode compatible

#### 9. **Calendar System**
- **Files**: `resources/views/admin/calendar/*.blade.php`
- **Features**: Event management, scheduling
- **Implementation**: Dark mode support

#### 10. **Public Pages**
- **Files**: `resources/views/public/*.blade.php`
- **Features**: Homepage, announcements, gallery
- **Implementation**: Dark mode compatible

## Color Scheme Standards

### Light Mode Colors
- **Primary Background**: `#ffffff` (White)
- **Secondary Background**: `#f8fafc` (Gray 50)
- **Tertiary Background**: `#f1f5f9` (Gray 100)
- **Primary Text**: `#1f2937` (Gray 800)
- **Secondary Text**: `#6b7280` (Gray 500)
- **Border**: `#e5e7eb` (Gray 200)

### Dark Mode Colors
- **Primary Background**: `#1f2937` (Gray 800)
- **Secondary Background**: `#111827` (Gray 900)
- **Tertiary Background**: `#374151` (Gray 700)
- **Primary Text**: `#f9fafb` (Gray 50)
- **Secondary Text**: `#d1d5db` (Gray 300)
- **Border**: `#374151` (Gray 700)

## Implementation Guidelines

### 1. For New Components
When creating new components, always use CSS variables:

```css
.my-component {
    background: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    box-shadow: 0 2px 10px var(--shadow-color);
}
```

### 2. For Existing Components
Update existing components to use the variable system:

```css
/* Before */
.card {
    background: #ffffff;
    color: #1f2937;
    border: 1px solid #e5e7eb;
}

/* After */
.card {
    background: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
}
```

### 3. For Interactive Elements
Ensure hover and focus states work in both modes:

```css
.button {
    background: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.button:hover {
    background: var(--bg-secondary);
    transform: translateY(-1px);
}
```

## Toggle Button Implementation

### HTML Structure
```html
<button onclick="toggleDarkMode()" class="dark-mode-btn" title="Toggle Dark Mode">
    <svg x-show="!darkMode" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
        <!-- Moon icon for light mode -->
    </svg>
    <svg x-show="darkMode" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
        <!-- Sun icon for dark mode -->
    </svg>
</button>
```

### CSS Styling
```css
.dark-mode-btn {
    background: transparent;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 0.5rem;
    color: var(--text-secondary);
    transition: all 0.3s ease;
}

.dark-mode-btn:hover {
    background: var(--bg-secondary);
    color: var(--text-primary);
}
```

## Testing Checklist

### Visual Testing
- [ ] All text is readable in both modes
- [ ] Contrast ratios meet accessibility standards
- [ ] Hover states work correctly
- [ ] Focus indicators are visible
- [ ] Icons and graphics adapt properly

### Functional Testing
- [ ] Toggle button works on all pages
- [ ] Theme preference persists across sessions
- [ ] No flash of unstyled content (FOUC)
- [ ] Smooth transitions between modes
- [ ] Charts and graphs adapt colors

### Browser Testing
- [ ] Chrome/Chromium
- [ ] Firefox
- [ ] Safari
- [ ] Edge
- [ ] Mobile browsers

## Performance Considerations

### 1. CSS Variables Performance
- CSS variables are efficiently handled by modern browsers
- Minimal performance impact compared to class-based switching
- Better than JavaScript-based color manipulation

### 2. Transition Optimization
```css
* {
    transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
}
```

### 3. Avoiding FOUC
```javascript
// Apply theme immediately on page load
document.addEventListener('DOMContentLoaded', function() {
    applyTheme();
});
```

## Accessibility Features

### 1. Respect System Preferences
```css
@media (prefers-color-scheme: dark) {
    :root {
        /* Apply dark mode by default if user prefers it */
    }
}
```

### 2. High Contrast Support
```css
@media (prefers-contrast: high) {
    :root {
        --border-color: #000000;
        --text-primary: #000000;
    }
    
    .dark {
        --border-color: #ffffff;
        --text-primary: #ffffff;
    }
}
```

### 3. Reduced Motion Support
```css
@media (prefers-reduced-motion: reduce) {
    * {
        transition: none !important;
        animation: none !important;
    }
}
```

## Future Enhancements

### 1. Theme Variants
- Add support for multiple themes (blue, green, purple)
- Implement theme customization options
- Add seasonal themes

### 2. Advanced Features
- Automatic theme switching based on time
- Per-module theme preferences
- Theme preview mode

### 3. Performance Optimizations
- Lazy load theme-specific assets
- Optimize CSS variable usage
- Implement theme caching

## Troubleshooting

### Common Issues

#### 1. Colors Not Switching
**Problem**: Some elements don't change color when toggling
**Solution**: Ensure all color properties use CSS variables

#### 2. Flash of Unstyled Content
**Problem**: Brief flash of wrong theme on page load
**Solution**: Apply theme in `<head>` before body renders

#### 3. Chart Colors Not Updating
**Problem**: Chart.js charts don't adapt to theme
**Solution**: Update chart colors programmatically on theme change

### Debug Tools
```javascript
// Check current theme state
console.log('Dark mode:', darkMode);
console.log('HTML classes:', document.documentElement.classList);

// Test theme switching
toggleDarkMode();
```

## Conclusion

The dark mode implementation provides a comprehensive, accessible, and performant theming solution across the entire school management system. The CSS variables approach ensures maintainability and consistency while the JavaScript toggle provides smooth user experience.

All major modules have been updated to support dark mode, and the implementation follows modern web standards and accessibility guidelines.