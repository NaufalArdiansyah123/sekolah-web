/**
 * Submissions Management JavaScript
 * Handles all interactions for attendance submission confirmation
 */

// Configuration
const CONFIG = {
    routes: {
        base: '/guru-piket/attendance/submissions',
        getDetail: (id) => `/guru-piket/attendance/submissions/${id}/detail`,
        updateStudent: (id) => `/guru-piket/attendance/submissions/${id}/update-student`,
        confirm: (id) => `/guru-piket/attendance/submissions/${id}/confirm`
    },
    refreshInterval: 30000 // 30 seconds
};

// State management
const STATE = {
    currentFilter: 'all',
    currentSubmissionData: null,
    csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
};

/**
 * Initialize the application
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('Submissions page initialized');
    initializeEventListeners();
});

/**
 * Initialize event listeners
 */
function initializeEventListeners() {
    // Close modal on overlay click
    const modalOverlay = document.querySelector('.modal-overlay');
    if (modalOverlay) {
        modalOverlay.addEventListener('click', closeSubmissionModal);
    }
    
    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeSubmissionModal();
        }
    });
}

/**
 * Filter submissions by status
 */
function filterSubmissions(status) {
    STATE.currentFilter = status;
    
    // Update filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    const activeBtn = document.querySelector(`[data-filter="${status}"]`);
    if (activeBtn) {
        activeBtn.classList.add('active');
    }
    
    // Filter submission items
    const items = document.querySelectorAll('.submission-item');
    let visibleCount = 0;
    
    items.forEach(item => {
        if (status === 'all' || item.classList.contains(status)) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });
    
    // Update count
    const countElement = document.getElementById('submission-count');
    if (countElement) {
        countElement.textContent = visibleCount;
    }
}

/**
 * Apply date filter
 */
function applyDateFilter() {
    const dateInput = document.getElementById('filterDate');
    if (!dateInput) return;
    
    const date = dateInput.value;
    if (!date) return;
    
    const url = new URL(window.location.href);
    url.searchParams.set('date', date);
    url.searchParams.set('status', STATE.currentFilter);
    
    window.location.href = url.toString();
}

/**
 * Refresh submissions list
 */
function refreshSubmissions(triggerEl) {
    if (triggerEl) {
        const originalContent = triggerEl.innerHTML;
        triggerEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';
        triggerEl.disabled = true;
    }
    
    setTimeout(() => {
        location.reload();
    }, 300);
}

/**
 * View submission detail
 */
function viewSubmissionDetail(submissionId) {
    console.log('Loading submission detail for ID:', submissionId);
    
    showSubmissionModal({
        id: submissionId,
        loading: true
    });
    
    fetchSubmissionDetail(submissionId);
}

/**
 * Fetch submission detail from server
 */
function fetchSubmissionDetail(submissionId) {
    const url = CONFIG.routes.getDetail(submissionId);
    
    console.log('Fetching from URL:', url);
    
    fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': STATE.csrfToken
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showSubmissionModal(data.submission);
        } else {
            alert('Gagal memuat detail: ' + (data.message || 'Unknown error'));
            closeSubmissionModal();
        }
    })
    .catch(error => {
        console.error('Error loading submission detail:', error);
        alert('Terjadi kesalahan: ' + error.message);
        closeSubmissionModal();
    });
}

/**
 * Show submission modal
 */
function showSubmissionModal(submission) {
    const modal = document.getElementById('submissionModal');
    const content = document.getElementById('submissionDetailContent');
    
    if (!modal || !content) return;
    
    if (submission.loading) {
        content.innerHTML = `
            <div style="text-align: center; padding: 3rem;">
                <div style="width: 3rem; height: 3rem; border: 3px solid var(--gray-200); border-top: 3px solid var(--primary); border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 1rem;"></div>
                <p style="color: var(--gray-600);">Memuat detail submission...</p>
            </div>
        `;
    } else {
        STATE.currentSubmissionData = JSON.parse(JSON.stringify(submission));
        content.innerHTML = createSubmissionDetailHtml(submission);
    }
    
    modal.classList.remove('hidden');
}

/**
 * Close submission modal
 */
function closeSubmissionModal() {
    const modal = document.getElementById('submissionModal');
    if (modal) {
        modal.classList.add('hidden');
    }
    STATE.currentSubmissionData = null;
}

/**
 * Create submission detail HTML
 */
function createSubmissionDetailHtml(submission) {
    const attendanceData = submission.attendance_data || [];
    const statusClass = submission.status.toLowerCase();
    const canEdit = submission.status === 'pending';
    
    const studentsHtml = createStudentsListHtml(attendanceData, canEdit);
    const submissionInfoHtml = createSubmissionInfoHtml(submission);
    const statisticsHtml = createStatisticsHtml(submission);
    const actionsHtml = canEdit ? createActionsHtml(submission.id) : '';
    const notesHtml = submission.notes ? createNotesHtml(submission.notes) : '';
    
    return `
        <div style="space-y: 1.5rem;">
            ${submissionInfoHtml}
            ${statisticsHtml}
            ${createStudentsContainerHtml(studentsHtml, attendanceData.length, canEdit)}
            ${notesHtml}
            ${actionsHtml}
        </div>
    `;
}

/**
 * Create submission info HTML
 */
function createSubmissionInfoHtml(submission) {
    const statusBadge = getStatusBadge(submission.status);
    
    return `
        <div style="background: var(--gray-50); border-radius: var(--radius); padding: 1.5rem; margin-bottom: 1.5rem;">
            <h3 style="font-weight: 600; margin-bottom: 1rem; color: var(--gray-900);">Informasi Submission</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">Guru</div>
                    <div style="font-weight: 600; color: var(--gray-900);">${submission.teacher.name}</div>
                </div>
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">Kelas</div>
                    <div style="font-weight: 600; color: var(--gray-900);">${submission.class ? submission.class.name : '-'}</div>
                </div>
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">Mata Pelajaran</div>
                    <div style="font-weight: 600; color: var(--gray-900);">${submission.subject}</div>
                </div>
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">Waktu</div>
                    <div style="font-weight: 600; color: var(--gray-900);">${submission.session_time}</div>
                </div>
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">Tanggal</div>
                    <div style="font-weight: 600; color: var(--gray-900);">${formatDate(submission.submission_date)}</div>
                </div>
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">Status</div>
                    <span class="status-badge ${statusBadge.class}">${statusBadge.text}</span>
                </div>
            </div>
        </div>
    `;
}

/**
 * Create statistics HTML
 */
function createStatisticsHtml(submission) {
    return `
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
            <div style="text-align: center; padding: 1rem; background: white; border-radius: var(--radius); border: 1px solid var(--gray-200);">
                <div style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900);">${submission.total_students}</div>
                <div style="font-size: 0.875rem; color: var(--gray-600);">Total Siswa</div>
            </div>
            <div style="text-align: center; padding: 1rem; background: white; border-radius: var(--radius); border: 1px solid var(--gray-200);">
                <div style="font-size: 1.5rem; font-weight: 700; color: var(--success);">${submission.present_count}</div>
                <div style="font-size: 0.875rem; color: var(--gray-600);">Hadir</div>
            </div>
            <div style="text-align: center; padding: 1rem; background: white; border-radius: var(--radius); border: 1px solid var(--gray-200);">
                <div style="font-size: 1.5rem; font-weight: 700; color: var(--warning);">${submission.late_count}</div>
                <div style="font-size: 0.875rem; color: var(--gray-600);">Terlambat</div>
            </div>
            <div style="text-align: center; padding: 1rem; background: white; border-radius: var(--radius); border: 1px solid var(--gray-200);">
                <div style="font-size: 1.5rem; font-weight: 700; color: var(--danger);">${submission.absent_count}</div>
                <div style="font-size: 0.875rem; color: var(--gray-600);">Tidak Hadir</div>
            </div>
        </div>
    `;
}

/**
 * Create students container HTML
 */
function createStudentsContainerHtml(studentsHtml, count, canEdit) {
    return `
        <div style="margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h3 style="font-weight: 600; color: var(--gray-900); margin: 0;">Daftar Kehadiran Siswa</h3>
                <div style="background: var(--gray-100); color: var(--gray-600); padding: 0.375rem 0.75rem; border-radius: var(--radius); font-size: 0.75rem; font-weight: 500;">
                    <i class="fas fa-users" style="margin-right: 0.25rem;"></i>${count} Siswa
                    ${canEdit ? ' • <i class="fas fa-edit" style="margin-left: 0.5rem; margin-right: 0.25rem;"></i>Dapat diedit' : ''}
                </div>
            </div>
            <div style="max-height: 400px; overflow-y: auto; border: 1px solid var(--gray-200); border-radius: var(--radius); padding: 1rem; background: var(--gray-50);">
                ${studentsHtml}
            </div>
        </div>
    `;
}

/**
 * Create students list HTML
 */
function createStudentsListHtml(attendanceData, canEdit) {
    if (!attendanceData || attendanceData.length === 0) {
        return `
            <div style="text-align: center; padding: 2rem; color: var(--gray-500);">
                <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <p>Tidak ada data siswa</p>
            </div>
        `;
    }
    
    return attendanceData.map((student, index) => {
        const studentId = student.student_id || student.id || index;
        const statusBadge = getStatusBadge(student.status);
        
        return createStudentCardHtml(student, studentId, statusBadge, canEdit);
    }).join('');
}

/**
 * Create student card HTML
 */
function createStudentCardHtml(student, studentId, statusBadge, canEdit) {
    const editFormHtml = canEdit ? createEditFormHtml(student, studentId) : '';
    const notesHtml = student.notes ? `
        <div style="padding: 0.75rem; padding-top: 0; font-size: 0.75rem; color: var(--gray-600); font-style: italic;">${student.notes}</div>
    ` : '';
    
    return `
        <div id="student-${studentId}" style="background: white; border: 1px solid var(--gray-200); border-radius: var(--radius); margin-bottom: 0.75rem; overflow: hidden;">
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, var(--primary) 0%, #6366f1 100%); border-radius: var(--radius); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.875rem;">
                        ${student.student_name ? student.student_name.charAt(0).toUpperCase() : 'S'}
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--gray-900); font-size: 0.875rem;">${student.student_name || 'Nama tidak tersedia'}</div>
                        <div style="font-size: 0.75rem; color: var(--gray-600);">NIS: ${student.nis || studentId || '-'}</div>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <span class="status-badge ${statusBadge.class}" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">${statusBadge.text}</span>
                    ${student.scan_time ? `<span style="font-size: 0.75rem; color: var(--gray-500);">${student.scan_time}</span>` : ''}
                    ${canEdit ? `
                        <button onclick="toggleEditStudent('${studentId}')" style="padding: 0.25rem 0.5rem; background: var(--primary); color: white; border: none; border-radius: var(--radius); font-size: 0.75rem; cursor: pointer; transition: all 0.15s ease;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='var(--primary)'">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    ` : ''}
                </div>
            </div>
            ${editFormHtml}
            ${notesHtml}
        </div>
    `;
}

/**
 * Create edit form HTML
 */
function createEditFormHtml(student, studentId) {
    const showFileUpload = student.status === 'sakit' || student.status === 'izin';
    
    return `
        <div id="edit-form-${studentId}" class="edit-form" style="display: none;">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Status Kehadiran</label>
                    <select id="status-${studentId}" onchange="handleStatusChange('${studentId}')" class="form-input">
                        <option value="hadir" ${student.status === 'hadir' ? 'selected' : ''}>Hadir</option>
                        <option value="terlambat" ${student.status === 'terlambat' ? 'selected' : ''}>Terlambat</option>
                        <option value="sakit" ${student.status === 'sakit' ? 'selected' : ''}>Sakit</option>
                        <option value="izin" ${student.status === 'izin' ? 'selected' : ''}>Izin</option>
                        <option value="alpha" ${student.status === 'alpha' ? 'selected' : ''}>Alpha</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Waktu</label>
                    <input type="time" id="time-${studentId}" value="${student.scan_time || ''}" class="form-input">
                </div>
            </div>
            
            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label">Catatan</label>
                <textarea id="notes-${studentId}" placeholder="Tambahkan catatan..." class="form-input" style="resize: vertical; min-height: 60px;">${student.notes || ''}</textarea>
            </div>
            
            <div id="file-upload-${studentId}" style="display: ${showFileUpload ? 'block' : 'none'}; margin-bottom: 1rem;">
                <label class="form-label">
                    <i class="fas fa-paperclip"></i> Lampiran Surat ${student.status === 'sakit' ? 'Sakit' : 'Izin'}
                </label>
                <div class="file-upload-area">
                    <input type="file" id="file-${studentId}" accept="image/*" onchange="handleFileUpload('${studentId}')" style="display: none;">
                    <div id="file-preview-${studentId}" class="file-preview">
                        ${student.attachment ? `
                            <img src="${student.attachment}" alt="Surat">
                            <div style="font-size: 0.75rem; color: var(--gray-600);">File sudah dilampirkan</div>
                        ` : `
                            <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: var(--gray-400); margin-bottom: 0.5rem;"></i>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">Klik untuk upload foto surat</div>
                        `}
                    </div>
                    <button type="button" onclick="document.getElementById('file-${studentId}').click()" class="btn btn-primary" style="font-size: 0.875rem;">
                        <i class="fas fa-upload"></i> Pilih File
                    </button>
                </div>
            </div>
            
            <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                <button onclick="cancelEditStudent('${studentId}')" class="btn btn-secondary" style="font-size: 0.875rem;">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button onclick="saveStudentEdit('${studentId}', this)" class="btn btn-success" style="font-size: 0.875rem;">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </div>
    `;
}

/**
 * Create notes HTML
 */
function createNotesHtml(notes) {
    return `
        <div style="background: #fef3c7; border: 1px solid #fbbf24; border-radius: var(--radius); padding: 1rem; margin-bottom: 1.5rem;">
            <h4 style="font-weight: 600; color: #92400e; margin-bottom: 0.5rem; font-size: 0.875rem;">
                <i class="fas fa-sticky-note" style="margin-right: 0.5rem;"></i>Catatan Guru
            </h4>
            <p style="color: #92400e; margin: 0; font-size: 0.875rem;">${notes}</p>
        </div>
    `;
}

/**
 * Create actions HTML
 */
function createActionsHtml(submissionId) {
    return `
        <div style="display: flex; gap: 0.75rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid var(--gray-200);">
            <button onclick="confirmSubmission(${submissionId}, 'confirm')" class="btn btn-success">
                <i class="fas fa-check" style="margin-right: 0.5rem;"></i>Konfirmasi
            </button>
            <button onclick="confirmSubmission(${submissionId}, 'reject')" class="btn btn-danger">
                <i class="fas fa-times" style="margin-right: 0.5rem;"></i>Tolak
            </button>
        </div>
    `;
}

/**
 * Toggle edit student form
 */
function toggleEditStudent(studentId) {
    const editForm = document.getElementById(`edit-form-${studentId}`);
    if (editForm) {
        editForm.style.display = editForm.style.display === 'none' ? 'block' : 'none';
    }
}

/**
 * Cancel edit student
 */
function cancelEditStudent(studentId) {
    const editForm = document.getElementById(`edit-form-${studentId}`);
    if (editForm) {
        editForm.style.display = 'none';
    }
}

/**
 * Handle status change
 */
function handleStatusChange(studentId) {
    const statusSelect = document.getElementById(`status-${studentId}`);
    const fileUpload = document.getElementById(`file-upload-${studentId}`);
    
    if (!statusSelect || !fileUpload) return;
    
    const status = statusSelect.value;
    
    if (status === 'sakit' || status === 'izin') {
        fileUpload.style.display = 'block';
        const label = fileUpload.querySelector('label');
        if (label) {
            label.innerHTML = `<i class="fas fa-paperclip"></i> Lampiran Surat ${status === 'sakit' ? 'Sakit' : 'Izin'}`;
        }
    } else {
        fileUpload.style.display = 'none';
    }
}

/**
 * Handle file upload
 */
function handleFileUpload(studentId) {
    const fileInput = document.getElementById(`file-${studentId}`);
    const preview = document.getElementById(`file-preview-${studentId}`);
    
    if (!fileInput || !preview) return;
    
    const file = fileInput.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 150px; border-radius: var(--radius); margin-bottom: 0.5rem;">
                <div style="font-size: 0.75rem; color: var(--gray-600);">${file.name}</div>
            `;
        };
        reader.readAsDataURL(file);
    }
}

/**
 * Save student edit
 */
function saveStudentEdit(studentId, btnEl) {
    const status = document.getElementById(`status-${studentId}`)?.value;
    const time = document.getElementById(`time-${studentId}`)?.value;
    const notes = document.getElementById(`notes-${studentId}`)?.value;
    const fileInput = document.getElementById(`file-${studentId}`);
    
    if (!STATE.currentSubmissionData) {
        alert('Data submission tidak ditemukan');
        return;
    }
    
    // Prepare form data
    const formData = new FormData();
    formData.append('student_id', studentId);
    formData.append('status', status);
    formData.append('time', time);
    formData.append('notes', notes);
    
    if (fileInput && fileInput.files[0]) {
        formData.append('attachment', fileInput.files[0]);
    }
    
    // Show loading
    const originalContent = btnEl ? btnEl.innerHTML : '';
    if (btnEl) {
        btnEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btnEl.disabled = true;
    }
    
    // Send update request
    const url = CONFIG.routes.updateStudent(STATE.currentSubmissionData.id);
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': STATE.csrfToken
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('✅ Data siswa berhasil diperbarui!');
            // Refresh modal content
            fetchSubmissionDetail(STATE.currentSubmissionData.id);
        } else {
            alert('❌ Gagal memperbarui data: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error updating student:', error);
        alert('⚠️ Terjadi kesalahan: ' + error.message);
    })
    .finally(() => {
        if (btnEl) {
            btnEl.innerHTML = originalContent;
            btnEl.disabled = false;
        }
    });
}

/**
 * Confirm submission
 */
function confirmSubmission(submissionId, action) {
    const isConfirm = action === 'confirm';
    const title = isConfirm ? '✅ Konfirmasi Submission' : '❌ Tolak Submission';
    const message = isConfirm ? 
        'Dengan mengkonfirmasi, submission akan diselesaikan dan tidak dapat diedit lagi.' :
        'Submission akan dikembalikan ke guru untuk diperbaiki.';
    
    if (!confirm(`${title}\n\n${message}\n\nLanjutkan?`)) {
        return;
    }
    
    const notes = prompt(isConfirm ? 
        '📝 Catatan konfirmasi (opsional):' : 
        '📝 Alasan penolakan (wajib):'
    );
    
    if (!isConfirm && !notes) {
        alert('❌ Alasan penolakan harus diisi');
        return;
    }
    
    const url = CONFIG.routes.confirm(submissionId);
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': STATE.csrfToken
        },
        body: JSON.stringify({
            action: action,
            notes: notes
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const actionText = isConfirm ? 'dikonfirmasi' : 'ditolak';
            alert(`✅ Submission berhasil ${actionText}!`);
            closeSubmissionModal();
            refreshSubmissions(null);
        } else {
            alert('❌ Gagal memproses: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error confirming submission:', error);
        alert('⚠️ Terjadi kesalahan: ' + error.message);
    });
}

/**
 * Get status badge configuration
 */
function getStatusBadge(status) {
    const badges = {
        'hadir': { class: 'status-confirmed', text: 'Hadir' },
        'terlambat': { class: 'status-pending', text: 'Terlambat' },
        'izin': { class: 'bg-blue-100', text: 'Izin' },
        'sakit': { class: 'bg-purple-100', text: 'Sakit' },
        'alpha': { class: 'status-rejected', text: 'Alpha' },
        'pending': { class: 'status-pending', text: 'Menunggu' },
        'confirmed': { class: 'status-confirmed', text: 'Dikonfirmasi' },
        'rejected': { class: 'status-rejected', text: 'Ditolak' }
    };
    
    return badges[status] || { class: 'bg-gray-100', text: status };
}

/**
 * Format date
 */
function formatDate(dateString) {
    if (!dateString) return '-';
    
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    } catch (e) {
        return dateString;
    }
}

/**
 * Add spin animation
 */
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);