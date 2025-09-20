{{-- 
    TEMPLATE: Admin Create/Edit Page - Dark Mode Compatible
    
    This is an example template showing how to create dark mode compatible
    admin create/edit pages using the reusable components.
    
    Copy this template and modify as needed for your specific forms.
--}}

@extends('layouts.admin')

@section('title', 'Create/Edit Example')

@section('content')
<x-admin.form-container 
    title="Create New Item" 
    subtitle="Fill in the details to create a new item"
    icon="fas fa-plus-circle"
    header-color="blue"
    back-url="{{ route('admin.items.index') }}"
    :show-back="true">
    
    <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        {{-- Basic Information Section --}}
        <x-admin.form-section 
            title="Basic Information" 
            subtitle="Enter the basic details for this item"
            icon="fas fa-info-circle"
            border-color="blue">
            
            <div class="row">
                <div class="col-md-8">
                    <x-admin.form-group 
                        label="Title"
                        icon="fas fa-heading"
                        :required="true"
                        name="title"
                        placeholder="Enter a descriptive title"
                        help="Use a clear and descriptive title" />
                </div>
                <div class="col-md-4">
                    <x-admin.form-group 
                        label="Status"
                        icon="fas fa-toggle-on"
                        type="select"
                        name="status"
                        :options="[
                            'active' => '✅ Active',
                            'inactive' => '❌ Inactive',
                            'draft' => '📝 Draft'
                        ]" />
                </div>
            </div>
            
            <x-admin.form-group 
                label="Description"
                icon="fas fa-align-left"
                type="textarea"
                name="description"
                :rows="4"
                placeholder="Enter a detailed description"
                help="Provide a comprehensive description of the item" />
        </x-admin.form-section>
        
        {{-- Content Section --}}
        <x-admin.form-section 
            title="Content" 
            subtitle="Add the main content for this item"
            icon="fas fa-edit"
            border-color="green">
            
            <x-admin.form-group 
                label="Main Content"
                icon="fas fa-file-alt"
                type="textarea"
                name="content"
                :rows="8"
                placeholder="Write your content here..."
                help="Use rich text formatting to enhance your content" />
        </x-admin.form-section>
        
        {{-- Media Section --}}
        <x-admin.form-section 
            title="Media & Files" 
            subtitle="Upload images and files"
            icon="fas fa-images"
            border-color="purple">
            
            <div class="row">
                <div class="col-md-6">
                    <x-admin.form-group 
                        label="Featured Image"
                        icon="fas fa-image"
                        type="file"
                        name="featured_image"
                        accept="image/*"
                        help="PNG, JPG, JPEG up to 2MB" />
                </div>
                <div class="col-md-6">
                    <x-admin.form-group 
                        label="Gallery Images"
                        icon="fas fa-images"
                        type="file"
                        name="gallery[]"
                        accept="image/*"
                        multiple
                        help="Multiple images allowed" />
                </div>
            </div>
        </x-admin.form-section>
        
        {{-- SEO Section --}}
        <x-admin.form-section 
            title="SEO & Meta" 
            subtitle="Optimize for search engines"
            icon="fas fa-search"
            border-color="orange">
            
            <div class="row">
                <div class="col-md-6">
                    <x-admin.form-group 
                        label="Meta Title"
                        icon="fas fa-tag"
                        name="meta_title"
                        placeholder="SEO optimized title"
                        help="Recommended: 50-60 characters" />
                </div>
                <div class="col-md-6">
                    <x-admin.form-group 
                        label="Meta Keywords"
                        icon="fas fa-hashtag"
                        name="meta_keywords"
                        placeholder="keyword1, keyword2, keyword3"
                        help="Separate keywords with commas" />
                </div>
            </div>
            
            <x-admin.form-group 
                label="Meta Description"
                icon="fas fa-align-left"
                type="textarea"
                name="meta_description"
                :rows="3"
                placeholder="Brief description for search engines"
                help="Recommended: 150-160 characters" />
        </x-admin.form-section>
        
        {{-- Advanced Settings --}}
        <x-admin.form-section 
            title="Advanced Settings" 
            subtitle="Additional configuration options"
            icon="fas fa-cogs"
            border-color="red">
            
            <div class="row">
                <div class="col-md-4">
                    <x-admin.form-group 
                        label="Category"
                        icon="fas fa-folder"
                        type="select"
                        name="category_id"
                        :options="[
                            '1' => 'Category 1',
                            '2' => 'Category 2',
                            '3' => 'Category 3'
                        ]" />
                </div>
                <div class="col-md-4">
                    <x-admin.form-group 
                        label="Priority"
                        icon="fas fa-star"
                        type="select"
                        name="priority"
                        :options="[
                            'low' => '🔵 Low',
                            'normal' => '🟡 Normal',
                            'high' => '🟠 High',
                            'urgent' => '🔴 Urgent'
                        ]" />
                </div>
                <div class="col-md-4">
                    <x-admin.form-group 
                        label="Sort Order"
                        icon="fas fa-sort-numeric-up"
                        name="sort_order"
                        type="number"
                        placeholder="0"
                        help="Higher numbers appear first" />
                </div>
            </div>
        </x-admin.form-section>
        
        {{-- Form Actions --}}
        <x-admin.form-actions 
            back-url="{{ route('admin.items.index') }}"
            :show-back="false"
            submit-text="Create Item"
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
    </form>
</x-admin.form-container>

{{-- Custom JavaScript for this page --}}
<script>
    function openPreview() {
        // Custom preview functionality
        alert('Preview functionality would go here');
    }
    
    // Auto-generate slug from title
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.querySelector('input[name="title"]');
        const slugInput = document.querySelector('input[name="slug"]');
        
        if (titleInput && slugInput) {
            titleInput.addEventListener('input', function() {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim('-');
                slugInput.value = slug;
            });
        }
    });
</script>

{{-- Custom Styles for this page --}}
<style>
    /* Page-specific styles can go here */
    .custom-section {
        /* Custom styling */
    }
</style>
@endsection

{{--
    USAGE INSTRUCTIONS:
    
    1. Copy this template to your desired location
    2. Update the @extends directive if needed
    3. Modify the form action and method
    4. Update the form fields to match your model
    5. Customize the sections as needed
    6. Add any custom JavaScript or CSS
    
    COMPONENT PROPS:
    
    x-admin.form-container:
    - title: Page title
    - subtitle: Page subtitle
    - icon: FontAwesome icon class
    - header-color: blue, green, purple, orange, red, indigo
    - back-url: URL for back button
    - show-back: boolean
    
    x-admin.form-section:
    - title: Section title
    - subtitle: Section subtitle
    - icon: FontAwesome icon class
    - border-color: blue, green, purple, orange, red, indigo
    
    x-admin.form-group:
    - label: Field label
    - icon: FontAwesome icon class
    - required: boolean
    - help: Help text
    - error: Error message
    - type: input, textarea, select, file, custom
    - name: Field name
    - value: Field value
    - placeholder: Placeholder text
    - rows: Textarea rows
    - options: Array for select options
    - accept: File input accept attribute
    
    x-admin.form-actions:
    - back-url: URL for back button
    - show-back: boolean
    - submit-text: Submit button text
    - submit-icon: Submit button icon
    - submit-color: primary, success, warning, danger
    - show-draft: boolean
    - draft-text: Draft button text
    - extra-actions: Array of additional actions
--}}