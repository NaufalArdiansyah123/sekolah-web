<style>
/* Dark Mode Styles for Extracurricular Management */

/* Base Dark Mode Classes */
.dark {
    background-color: #1F2937;
    color: #E5E7EB;
}

/* Cards */
.dark .card {
    background-color: #374151;
    border-color: #4B5563;
    color: #E5E7EB;
}

.dark .card-header {
    background-color: #4B5563;
    border-color: #6B7280;
    color: #F9FAFB;
}

.dark .card-body {
    background-color: #374151;
    color: #E5E7EB;
}

/* Tables */
.dark .table {
    color: #E5E7EB;
    background-color: #374151;
}

.dark .table th {
    background-color: #4B5563;
    border-color: #6B7280;
    color: #F9FAFB;
}

.dark .table td {
    border-color: #6B7280;
    color: #E5E7EB;
}

.dark .table-hover tbody tr:hover {
    background-color: #4B5563;
}

/* Forms */
.dark .form-control,
.dark .form-select {
    background-color: #4B5563;
    border-color: #6B7280;
    color: #E5E7EB;
}

.dark .form-control:focus,
.dark .form-select:focus {
    background-color: #4B5563;
    border-color: #60A5FA;
    color: #E5E7EB;
    box-shadow: 0 0 0 0.2rem rgba(96, 165, 250, 0.25);
}

.dark .form-control::placeholder {
    color: #9CA3AF;
}

.dark .form-text {
    color: #9CA3AF;
}

.dark .form-label {
    color: #E5E7EB;
}

/* Buttons */
.dark .btn-outline-primary {
    color: #60A5FA;
    border-color: #3B82F6;
}

.dark .btn-outline-primary:hover {
    background-color: #3B82F6;
    border-color: #3B82F6;
    color: #FFFFFF;
}

.dark .btn-outline-secondary {
    color: #9CA3AF;
    border-color: #6B7280;
}

.dark .btn-outline-secondary:hover {
    background-color: #6B7280;
    border-color: #6B7280;
    color: #FFFFFF;
}

.dark .btn-outline-success {
    color: #34D399;
    border-color: #10B981;
}

.dark .btn-outline-success:hover {
    background-color: #10B981;
    border-color: #10B981;
    color: #FFFFFF;
}

.dark .btn-outline-warning {
    color: #FBBF24;
    border-color: #F59E0B;
}

.dark .btn-outline-warning:hover {
    background-color: #F59E0B;
    border-color: #F59E0B;
    color: #FFFFFF;
}

.dark .btn-outline-danger {
    color: #F87171;
    border-color: #EF4444;
}

.dark .btn-outline-danger:hover {
    background-color: #EF4444;
    border-color: #EF4444;
    color: #FFFFFF;
}

.dark .btn-outline-info {
    color: #60A5FA;
    border-color: #3B82F6;
}

.dark .btn-outline-info:hover {
    background-color: #3B82F6;
    border-color: #3B82F6;
    color: #FFFFFF;
}

/* Badges */
.dark .badge.bg-primary {
    background-color: #3B82F6 !important;
}

.dark .badge.bg-secondary {
    background-color: #6B7280 !important;
}

.dark .badge.bg-success {
    background-color: #10B981 !important;
}

.dark .badge.bg-warning {
    background-color: #F59E0B !important;
}

.dark .badge.bg-danger {
    background-color: #EF4444 !important;
}

.dark .badge.bg-info {
    background-color: #3B82F6 !important;
}

/* Alerts */
.dark .alert-success {
    background-color: #065F46;
    border-color: #10B981;
    color: #D1FAE5;
}

.dark .alert-warning {
    background-color: #92400E;
    border-color: #F59E0B;
    color: #FEF3C7;
}

.dark .alert-danger {
    background-color: #991B1B;
    border-color: #EF4444;
    color: #FEE2E2;
}

.dark .alert-info {
    background-color: #1E3A8A;
    border-color: #3B82F6;
    color: #DBEAFE;
}

/* Modals */
.dark .modal-content {
    background-color: #374151;
    border-color: #4B5563;
}

.dark .modal-header {
    background-color: #4B5563;
    border-color: #6B7280;
    color: #F9FAFB;
}

.dark .modal-body {
    background-color: #374151;
    color: #E5E7EB;
}

.dark .modal-footer {
    background-color: #4B5563;
    border-color: #6B7280;
}

.dark .btn-close {
    filter: invert(1) grayscale(100%) brightness(200%);
}

/* Navigation */
.dark .breadcrumb {
    background-color: #374151;
}

.dark .breadcrumb-item + .breadcrumb-item::before {
    color: #9CA3AF;
}

.dark .breadcrumb-item.active {
    color: #9CA3AF;
}

.dark .breadcrumb-item a {
    color: #60A5FA;
}

/* Tabs */
.dark .nav-tabs {
    border-color: #4B5563;
}

.dark .nav-tabs .nav-link {
    background-color: #374151;
    border-color: #4B5563;
    color: #9CA3AF;
}

.dark .nav-tabs .nav-link:hover {
    background-color: #4B5563;
    border-color: #6B7280;
    color: #E5E7EB;
}

.dark .nav-tabs .nav-link.active {
    background-color: #374151;
    border-color: #4B5563 #4B5563 #374151;
    color: #E5E7EB;
}

/* Text Colors */
.dark .text-muted {
    color: #9CA3AF !important;
}

.dark .text-primary {
    color: #60A5FA !important;
}

.dark .text-success {
    color: #34D399 !important;
}

.dark .text-warning {
    color: #FBBF24 !important;
}

.dark .text-danger {
    color: #F87171 !important;
}

.dark .text-info {
    color: #60A5FA !important;
}

/* Border Colors */
.dark .border {
    border-color: #4B5563 !important;
}

.dark .border-primary {
    border-color: #3B82F6 !important;
}

.dark .border-success {
    border-color: #10B981 !important;
}

.dark .border-warning {
    border-color: #F59E0B !important;
}

.dark .border-danger {
    border-color: #EF4444 !important;
}

/* Custom Components */
.dark .avatar-circle {
    background: linear-gradient(135deg, #3B82F6 0%, #1E40AF 100%);
}

.dark .card.border-left-primary {
    border-left-color: #3B82F6 !important;
}

.dark .card.border-left-success {
    border-left-color: #10B981 !important;
}

.dark .card.border-left-warning {
    border-left-color: #F59E0B !important;
}

.dark .card.border-left-danger {
    border-left-color: #EF4444 !important;
}

.dark .card.border-left-info {
    border-left-color: #3B82F6 !important;
}

/* Pagination */
.dark .page-link {
    background-color: #374151;
    border-color: #4B5563;
    color: #9CA3AF;
}

.dark .page-link:hover {
    background-color: #4B5563;
    border-color: #6B7280;
    color: #E5E7EB;
}

.dark .page-item.active .page-link {
    background-color: #3B82F6;
    border-color: #3B82F6;
    color: #FFFFFF;
}

.dark .page-item.disabled .page-link {
    background-color: #374151;
    border-color: #4B5563;
    color: #6B7280;
}

/* Dropdown */
.dark .dropdown-menu {
    background-color: #374151;
    border-color: #4B5563;
}

.dark .dropdown-item {
    color: #E5E7EB;
}

.dark .dropdown-item:hover {
    background-color: #4B5563;
    color: #F9FAFB;
}

.dark .dropdown-divider {
    border-color: #4B5563;
}

/* Loading States */
.dark .spinner-border {
    color: #60A5FA;
}

.dark .spinner-grow {
    color: #60A5FA;
}

/* Custom Utilities */
.dark .bg-light {
    background-color: #4B5563 !important;
}

.dark .bg-dark {
    background-color: #1F2937 !important;
}

.dark .border-end {
    border-right-color: #4B5563 !important;
}

.dark .border-start {
    border-left-color: #4B5563 !important;
}

.dark .border-top {
    border-top-color: #4B5563 !important;
}

.dark .border-bottom {
    border-bottom-color: #4B5563 !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .dark .card {
        margin-bottom: 1rem;
    }
    
    .dark .table-responsive {
        border-color: #4B5563;
    }
}

/* Animation for dark mode transitions */
.dark * {
    transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease;
}
</style>