# Admin Dark Mode Compatible Components

This documentation explains how to create dark mode compatible admin create and edit pages using the reusable components.

## Overview

The admin interface now includes a set of reusable components that automatically adapt to dark mode. These components use CSS variables defined in the main admin layout to ensure consistent theming.

## Available Components

### 1. Form Container (`x-admin.form-container`)

The main wrapper for admin forms with a beautiful header and consistent styling.

```blade
<x-admin.form-container 
    title="Create New Article" 
    subtitle="Write and publish engaging content"
    icon="fas fa-edit"
    header-color="blue"
    back-url="{{ route('admin.posts.index') }}"
    :show-back="true">
    
    <!-- Form content goes here -->
    
</x-admin.form-container>
```

**Props:**
- `title` (string): Main page title
- `subtitle` (string, optional): Descriptive subtitle
- `icon` (string): FontAwesome icon class
- `header-color` (string): blue, green, purple, orange, red, indigo
- `back-url` (string): URL for the back button
- `show-back` (boolean): Whether to show the back button

### 2. Form Section (`x-admin.form-section`)

Organizes form fields into logical sections with headers and colored borders.

```blade
<x-admin.form-section 
    title="Basic Information" 
    subtitle="Enter the essential details"
    icon="fas fa-info-circle"
    border-color="blue">
    
    <!-- Form fields go here -->
    
</x-admin.form-section>
```

**Props:**
- `title` (string): Section title
- `subtitle` (string, optional): Section description
- `icon` (string): FontAwesome icon class
- `border-color` (string): blue, green, purple, orange, red, indigo

### 3. Form Group (`x-admin.form-group`)

Individual form fields with labels, validation, and help text.

```blade
<!-- Text Input -->
<x-admin.form-group 
    label="Article Title"
    icon="fas fa-heading"
    :required="true"
    name="title"
    placeholder="Enter a descriptive title"
    help="Use a clear and engaging title" />

<!-- Textarea -->
<x-admin.form-group 
    label="Content"
    icon="fas fa-edit"
    type="textarea"
    name="content"
    :rows="8"
    placeholder="Write your content here..."
    help="Use rich text formatting" />

<!-- Select Dropdown -->
<x-admin.form-group 
    label="Status"
    icon="fas fa-toggle-on"
    type="select"
    name="status"
    :options="[
        'published' => '✅ Published',
        'draft' => '📝 Draft',
        'archived' => '📁 Archived'
    ]" />

<!-- File Upload -->
<x-admin.form-group 
    label="Featured Image"
    icon="fas fa-image"
    type="file"
    name="featured_image"
    accept="image/*"
    help="PNG, JPG, JPEG up to 2MB" />
```

**Props:**
- `label` (string): Field label
- `icon` (string, optional): FontAwesome icon class
- `required` (boolean): Whether field is required
- `help` (string, optional): Help text
- `error` (string, optional): Error message
- `type` (string): input, textarea, select, file, custom
- `name` (string): Field name attribute
- `value` (string, optional): Field value
- `placeholder` (string, optional): Placeholder text
- `rows` (integer): Textarea rows (default: 4)
- `options` (array): Select options (value => label)
- `accept` (string, optional): File input accept attribute

### 4. Form Actions (`x-admin.form-actions`)

Standardized action buttons for forms with consistent styling.

```blade
<x-admin.form-actions 
    back-url="{{ route('admin.posts.index') }}"
    :show-back="true"
    submit-text="Create Article"
    submit-icon="fas fa-plus-circle"
    submit-color="success"
    :show-draft="true"
    draft-text="Save as Draft"
    :extra-actions="[
        [
            'text' => 'Preview',
            'icon' => 'fas fa-eye',
            'class' => 'admin-btn-secondary',
            'type' => 'button',
            'onclick' => 'openPreview()'
        ]
    ]" />
```

**Props:**
- `back-url` (string): URL for back button
- `show-back` (boolean): Whether to show back button
- `submit-text` (string): Submit button text
- `submit-icon` (string): Submit button icon
- `submit-color` (string): primary, success, warning, danger
- `show-draft` (boolean): Whether to show draft button
- `draft-text` (string): Draft button text
- `extra-actions` (array): Additional action buttons

## Dark Mode Features

### Automatic Theme Adaptation

All components automatically adapt to dark mode using CSS variables:

```css
/* Light Mode */
--bg-primary: #ffffff;
--bg-secondary: #f8fafc;
--text-primary: #1f2937;
--border-color: #e5e7eb;

/* Dark Mode */
--bg-primary: #1f2937;
--bg-secondary: #111827;
--text-primary: #f9fafb;
--border-color: #374151;
```

### Theme-Aware Styling

Components include specific dark mode adjustments:

```css
.dark .admin-form-section {
    background: var(--bg-tertiary);
}

.dark .admin-upload-area {
    background: var(--bg-primary);
}
```

### JavaScript Theme Detection

Components can respond to theme changes:

```javascript
window.addEventListener('theme-changed', function(e) {
    console.log('Theme changed to:', e.detail.darkMode ? 'dark' : 'light');
    // Update theme-specific elements
});
```

## Complete Example

Here's a complete example of a dark mode compatible create page:

```blade
@extends('layouts.admin')

@section('title', 'Create Article')

@section('content')
<x-admin.form-container 
    title="Create New Article" 
    subtitle="Write and publish engaging content for your readers"
    icon="fas fa-edit"
    header-color="blue"
    back-url="{{ route('admin.posts.index') }}">
    
    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <x-admin.form-section 
            title="Basic Information" 
            subtitle="Enter the essential article details"
            icon="fas fa-info-circle"
            border-color="blue">
            
            <div class="row">
                <div class="col-md-8">
                    <x-admin.form-group 
                        label="Article Title"
                        icon="fas fa-heading"
                        :required="true"
                        name="title"
                        placeholder="Enter a descriptive title"
                        help="Use a clear and engaging title" />
                </div>
                <div class="col-md-4">
                    <x-admin.form-group 
                        label="Status"
                        icon="fas fa-toggle-on"
                        type="select"
                        name="status"
                        :options="[
                            'published' => '✅ Published',
                            'draft' => '📝 Draft'
                        ]" />
                </div>
            </div>
        </x-admin.form-section>
        
        <x-admin.form-section 
            title="Content" 
            subtitle="Write your article content"
            icon="fas fa-edit"
            border-color="green">
            
            <x-admin.form-group 
                label="Article Content"
                icon="fas fa-file-alt"
                type="textarea"
                name="content"
                :rows="10"
                :required="true"
                placeholder="Write your article content here..."
                help="Use rich text formatting to enhance your content" />
        </x-admin.form-section>
        
        <x-admin.form-section 
            title="Featured Image" 
            subtitle="Upload the main image for your article"
            icon="fas fa-image"
            border-color="purple">
            
            <x-admin.form-group 
                label="Upload Image"
                icon="fas fa-camera"
                type="file"
                name="featured_image"
                accept="image/*"
                help="PNG, JPG, JPEG up to 2MB" />
        </x-admin.form-section>
        
        <x-admin.form-actions 
            back-url="{{ route('admin.posts.index') }}"
            submit-text="Create Article"
            submit-icon="fas fa-plus-circle"
            submit-color="success"
            :show-draft="true" />
    </form>
</x-admin.form-container>
@endsection
```

## Best Practices

### 1. Consistent Color Schemes

Use consistent header and border colors throughout your admin interface:

- **Blue**: General content (articles, pages)
- **Green**: Success actions, publishing
- **Purple**: Media and files
- **Orange**: SEO and metadata
- **Red**: Dangerous actions, deletion

### 2. Logical Section Organization

Group related fields into sections:

```blade
<!-- Basic Info -->
<x-admin.form-section title="Basic Information" border-color="blue">
    <!-- Title, slug, status -->
</x-admin.form-section>

<!-- Content -->
<x-admin.form-section title="Content" border-color="green">
    <!-- Main content, description -->
</x-admin.form-section>

<!-- Media -->
<x-admin.form-section title="Media" border-color="purple">
    <!-- Images, files -->
</x-admin.form-section>

<!-- SEO -->
<x-admin.form-section title="SEO" border-color="orange">
    <!-- Meta title, description, keywords -->
</x-admin.form-section>
```

### 3. Responsive Design

Use Bootstrap grid classes for responsive layouts:

```blade
<div class="row">
    <div class="col-md-8">
        <x-admin.form-group label="Title" name="title" />
    </div>
    <div class="col-md-4">
        <x-admin.form-group label="Status" type="select" name="status" />
    </div>
</div>
```

### 4. Validation Integration

Components automatically integrate with Laravel validation:

```blade
<x-admin.form-group 
    label="Email"
    name="email"
    type="email"
    :required="true" />

{{-- Error will automatically display if validation fails --}}
```

### 5. Custom JavaScript

Add page-specific functionality:

```blade
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-generate slug from title
        const titleInput = document.querySelector('input[name="title"]');
        const slugInput = document.querySelector('input[name="slug"]');
        
        if (titleInput && slugInput) {
            titleInput.addEventListener('input', function() {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .trim('-');
                slugInput.value = slug;
            });
        }
    });
</script>
```

## Migration Guide

To convert existing admin pages to use these components:

1. **Replace form wrapper:**
   ```blade
   <!-- Old -->
   <div class="card">
       <div class="card-header">Create Item</div>
       <div class="card-body">
   
   <!-- New -->
   <x-admin.form-container title="Create Item">
   ```

2. **Group fields into sections:**
   ```blade
   <!-- Old -->
   <div class="form-group">
       <label>Title</label>
       <input type="text" name="title" class="form-control">
   </div>
   
   <!-- New -->
   <x-admin.form-section title="Basic Information">
       <x-admin.form-group label="Title" name="title" />
   </x-admin.form-section>
   ```

3. **Update action buttons:**
   ```blade
   <!-- Old -->
   <div class="form-group">
       <button type="submit" class="btn btn-primary">Save</button>
       <a href="..." class="btn btn-secondary">Cancel</a>
   </div>
   
   <!-- New -->
   <x-admin.form-actions 
       back-url="..." 
       submit-text="Save" />
   ```

## Troubleshooting

### Component Not Found

If you get "Component not found" errors, ensure the component files are in the correct location:

```
resources/views/components/admin/
├── form-container.blade.php
├── form-section.blade.php
├── form-group.blade.php
└── form-actions.blade.php
```

### Dark Mode Not Working

Ensure your layout includes the dark mode CSS variables and Alpine.js setup:

```blade
<!-- In layouts/admin.blade.php -->
<html x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" 
      :class="{ 'dark': darkMode }">
```

### Styling Issues

Components inherit from the main admin layout. Ensure your layout includes the CSS variable definitions for proper theming.

## Support

For issues or questions about these components, refer to the example template at `resources/views/admin/templates/create-edit-example.blade.php` or check the component source files for detailed implementation.