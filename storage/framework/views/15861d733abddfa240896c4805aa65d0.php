<?php $__env->startSection('title', 'Student Details - ' . $student->name); ?>

<?php $__env->startSection('content'); ?>
<style>
    .student-detail-container {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .page-header {
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(5, 150, 105, 0.2);
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(-15deg);
    }

    .header-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
    }

    .student-profile {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .student-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 2rem;
        border: 3px solid rgba(255, 255, 255, 0.3);
    }

    .student-info {
        flex: 1;
    }

    .student-name {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .student-meta {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
        opacity: 0.9;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        flex-shrink: 0;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
    }

    .btn-primary {
        background: white;
        color: #059669;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: #059669;
        text-decoration: none;
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Content Sections */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .info-section {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .info-section:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px var(--shadow-color);
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border-color);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .info-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 500;
    }

    .info-value {
        font-size: 0.875rem;
        color: var(--text-primary);
        font-weight: 500;
    }

    /* Academic Performance Section */
    .academic-section {
        grid-column: 1 / -1;
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        margin-bottom: 2rem;
    }

    .academic-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: var(--bg-secondary);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px var(--shadow-color);
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Grades Table */
    .grades-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .grades-table th,
    .grades-table td {
        padding: 0.75rem 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }

    .grades-table th {
        background: var(--bg-secondary);
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .grades-table td {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .grade-score {
        font-weight: 600;
        color: var(--text-primary);
    }

    .grade-letter {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.75rem;
    }

    .grade-a {
        background: rgba(5, 150, 105, 0.1);
        color: #059669;
        border: 1px solid rgba(5, 150, 105, 0.2);
    }

    .grade-b {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .grade-c {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-active {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-inactive {
        background: rgba(107, 114, 128, 0.1);
        color: #374151;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }

    /* Progress Bar */
    .progress-bar {
        width: 100%;
        height: 8px;
        background: var(--bg-tertiary);
        border-radius: 4px;
        overflow: hidden;
        margin-top: 0.5rem;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(135deg, #059669, #10b981);
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .student-detail-container {
            padding: 1rem;
        }

        .header-content {
            flex-direction: column;
            gap: 1rem;
        }

        .student-profile {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .student-meta {
            justify-content: center;
        }

        .header-actions {
            width: 100%;
            justify-content: center;
        }

        .content-grid {
            grid-template-columns: 1fr;
        }

        .academic-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .grades-table {
            font-size: 0.75rem;
        }

        .grades-table th,
        .grades-table td {
            padding: 0.5rem 0.75rem;
        }
    }

    @media (max-width: 576px) {
        .academic-stats {
            grid-template-columns: 1fr;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Animation */
    .info-section {
        animation: slideUp 0.5s ease-out;
    }

    .info-section:nth-child(2) {
        animation-delay: 0.1s;
    }

    .info-section:nth-child(3) {
        animation-delay: 0.2s;
    }

    .info-section:nth-child(4) {
        animation-delay: 0.3s;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="student-detail-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="student-profile">
                <div class="student-avatar-large">
                    <?php echo e(strtoupper(substr($student->name, 0, 2))); ?>

                </div>
                <div class="student-info">
                    <h1 class="student-name"><?php echo e($student->name); ?></h1>
                    <div class="student-meta">
                        <div class="meta-item">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            NIS: <?php echo e($student->nis); ?>

                        </div>
                        <div class="meta-item">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Class: <?php echo e($student->class); ?>

                        </div>
                        <div class="meta-item">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Enrolled: <?php echo e(\Carbon\Carbon::parse($student->enrollment_date)->format('M Y')); ?>

                        </div>
                        <div class="status-badge status-<?php echo e($student->status); ?>">
                            <?php if($student->status == 'active'): ?>
                                🟢 Active Student
                            <?php else: ?>
                                ⚫ Inactive
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <a href="<?php echo e(route('teacher.students.edit', $student->id)); ?>" class="btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit Student
                </a>
                <a href="<?php echo e(route('teacher.students.index')); ?>" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Students
                </a>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Personal Information -->
        <div class="info-section">
            <h2 class="section-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Personal Information
            </h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Full Name</div>
                    <div class="info-value"><?php echo e($student->name); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Gender</div>
                    <div class="info-value"><?php echo e($student->gender == 'L' ? 'Male' : 'Female'); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Birth Date</div>
                    <div class="info-value"><?php echo e(\Carbon\Carbon::parse($student->birth_date)->format('d F Y')); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Birth Place</div>
                    <div class="info-value"><?php echo e($student->birth_place); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Religion</div>
                    <div class="info-value"><?php echo e($student->religion); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Blood Type</div>
                    <div class="info-value"><?php echo e($student->blood_type); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Height</div>
                    <div class="info-value"><?php echo e($student->height); ?> cm</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Weight</div>
                    <div class="info-value"><?php echo e($student->weight); ?> kg</div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="info-section">
            <h2 class="section-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Contact Information
            </h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Phone Number</div>
                    <div class="info-value"><?php echo e($student->phone); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email Address</div>
                    <div class="info-value"><?php echo e($student->email); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Home Address</div>
                    <div class="info-value"><?php echo e($student->address); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Emergency Contact</div>
                    <div class="info-value"><?php echo e($student->emergency_contact ?? 'Not specified'); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Emergency Phone</div>
                    <div class="info-value"><?php echo e($student->emergency_phone ?? 'Not specified'); ?></div>
                </div>
            </div>
        </div>

        <!-- Parent Information -->
        <div class="info-section">
            <h2 class="section-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Parent Information
            </h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Parent Name</div>
                    <div class="info-value"><?php echo e($student->parent_name); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Parent Phone</div>
                    <div class="info-value"><?php echo e($student->parent_phone); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Parent Email</div>
                    <div class="info-value"><?php echo e($student->parent_email ?? 'Not specified'); ?></div>
                </div>
            </div>
        </div>

        <!-- Academic Information -->
        <div class="info-section">
            <h2 class="section-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Academic Information
            </h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Student ID (NIS)</div>
                    <div class="info-value"><?php echo e($student->nis); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Current Class</div>
                    <div class="info-value"><?php echo e($student->class); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Enrollment Date</div>
                    <div class="info-value"><?php echo e(\Carbon\Carbon::parse($student->enrollment_date)->format('d F Y')); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Previous School</div>
                    <div class="info-value"><?php echo e($student->previous_school ?? 'Not specified'); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Hobbies</div>
                    <div class="info-value"><?php echo e($student->hobbies ?? 'Not specified'); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Achievements</div>
                    <div class="info-value"><?php echo e($student->achievements ?? 'None recorded'); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Academic Performance Section -->
    <div class="academic-section">
        <h2 class="section-title">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Academic Performance
        </h2>

        <!-- Academic Statistics -->
        <div class="academic-stats">
            <div class="stat-card">
                <div class="stat-value"><?php echo e($academicData['current_semester']); ?></div>
                <div class="stat-label">Current Semester</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo e(number_format($academicData['average_score'], 1)); ?></div>
                <div class="stat-label">Average Score</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">#<?php echo e($academicData['rank_in_class']); ?></div>
                <div class="stat-label">Class Rank</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo e($academicData['attendance_percentage']); ?>%</div>
                <div class="stat-label">Attendance</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo e($academicData['total_subjects']); ?></div>
                <div class="stat-label">Total Subjects</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo e($academicData['total_absences']); ?></div>
                <div class="stat-label">Total Absences</div>
            </div>
        </div>

        <!-- Attendance Progress -->
        <div style="margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <span style="font-weight: 500; color: var(--text-primary);">Attendance Progress</span>
                <span style="font-weight: 600; color: #059669;"><?php echo e($academicData['attendance_percentage']); ?>%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: <?php echo e($academicData['attendance_percentage']); ?>%"></div>
            </div>
        </div>

        <!-- Recent Grades -->
        <h3 style="font-size: 1rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">Recent Grades</h3>
        <table class="grades-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Score</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $academicData['recent_grades']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($grade['subject']); ?></td>
                    <td><span class="grade-score"><?php echo e($grade['score']); ?></span></td>
                    <td>
                        <span class="grade-letter grade-<?php echo e(strtolower(substr($grade['grade'], 0, 1))); ?>">
                            <?php echo e($grade['grade']); ?>

                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Card hover effects
    const infoSections = document.querySelectorAll('.info-section');
    infoSections.forEach(section => {
        section.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        section.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.05)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.teacher', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/teacher/students/show.blade.php ENDPATH**/ ?>