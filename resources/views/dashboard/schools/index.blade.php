@extends('dashboard.header')

@section('content')
<div class="schools-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <div class="title-section">
                <h1 class="page-title">
                    <i class="bi bi-building"></i>
                    Schools Management
                </h1>
                <p class="page-subtitle">View and manage all registered schools in the system</p>
            </div>

            <div class="header-actions">
                <button type="button" class="btn btn-primary add-school-btn" data-bs-toggle="modal"
                    data-bs-target="#addSchoolModal">
                    <a href="{{ route('dashboard.schools.create') }}">
                        <i class="bi bi-plus-circle"></i>
                        Add New School
                    </a>
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="stats-bar">
        <div class="stat-item">
            <i class="bi bi-building stat-icon"></i>
            <div class="stat-info">
                <span class="stat-number">{{ $schools->total() }}</span>
                <span class="stat-label">Total Schools</span>
            </div>
        </div>
        <div class="stat-item">
            <i class="bi bi-mortarboard stat-icon"></i>
            <div class="stat-info">
                <span class="stat-number">{{ $stats['elementary'] }}</span>
                <span class="stat-label">Elementary</span>
            </div>
        </div>
        <div class="stat-item">
            <i class="bi bi-book stat-icon"></i>
            <div class="stat-info">
                <span class="stat-number">{{ $stats['middle'] }}</span>
                <span class="stat-label">Middle</span>
            </div>
        </div>
        <div class="stat-item">
            <i class="bi bi-award stat-icon"></i>
            <div class="stat-info">
                <span class="stat-number">{{ $stats['high'] }}</span>
                <span class="stat-label">High School</span>
            </div>
        </div>
        <div class="stat-item">
            <i class="bi bi-award stat-icon"></i>
            <div class="stat-info">
                <span class="stat-number">{{ $stats['secondary'] }}</span>
                <span class="stat-label">Secondary School</span>
            </div>
        </div>
    </div>

    <!-- Schools Grid -->
    <div class="schools-grid" id="schoolsGrid">
        @forelse($schools as $school)
        <div class="school-card" data-type="{{ $school->type }}" data-name="{{ $school->name }}">
            <div class="card-header">
                <div class="school-logo">
                    @if ($school->logo_path)
                    <img src="{{ asset($school->logo_path) }}" alt="{{ $school->name }}" class="logo-img">
                    @else
                    <div class="default-logo">
                        <i class="bi bi-building"></i>
                    </div>
                    @endif
                </div>
                <div class="school-type-badge {{ strtolower($school->type) }}">
                    {{ $school->type }}
                </div>
            </div>

            <div class="card-body">
                <h3 class="school-name">{{ $school->name }}</h3>

                @if ($school->address)
                <div class="school-info">
                    <i class="bi bi-geo-alt"></i>
                    <span>{{ $school->address }}</span>
                </div>
                @endif

                <div class="school-meta">
                    <div class="meta-item">
                        <i class="bi bi-calendar-plus"></i>
                        <span>{{ $school->created_at->format('Y/m/d') }}</span>
                    </div>
                    @if ($school->creator)
                    <div class="meta-item">
                        <i class="bi bi-person"></i>
                        <span>{{ $school->creator->name }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card-actions">
                <button class="action-btn view-btn" onclick="viewSchool({{ $school->id }})" title="View Details">
                    <i class="bi bi-eye"></i>
                </button>
                <button class="action-btn edit-btn" onclick="editSchool({{ $school->id }})" title="Edit">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="action-btn delete-btn" onclick="confirmDeleteSchool({{ $school->id }}, '{{ $school->name }}')" title="Delete">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-building-x"></i>
            </div>
            <h3>No schools registered</h3>
            <p>Add the first school to the system</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($schools->hasPages())
    <div class="pagination-wrapper">
        {{ $schools->links() }}
    </div>
    @endif
</div>

<!-- Hidden Delete Forms for each school -->
@foreach($schools as $school)
<form id="deleteSchoolForm{{ $school->id }}" action="{{ route('dashboard.schools.destroy', $school) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endforeach

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    :root {
        --primary-color: #6366f1;
        --secondary-color: #8b5cf6;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #06b6d4;
        --light-bg: #f8fafc;
        --white: #ffffff;
        --gray-50: #f9fafb;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
        --border-radius: 16px;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        direction: ltr;
        text-align: left;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .schools-container {
        padding: 2rem;
        background: var(--light-bg);
        min-height: 100vh;
    }

    /* Header Styles */
    .page-header {
        margin-bottom: 2rem;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-200);
    }

    .page-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-title i {
        color: var(--primary-color);
    }

    .page-subtitle {
        color: var(--gray-500);
        font-size: 1.125rem;
        margin: 0;
    }

    .add-school-btn {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border: none;
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: var(--transition);
        box-shadow: var(--shadow);
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .add-school-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
    }

    /* Stats Bar */
    .stats-bar {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .stat-item {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
        min-width: 200px;
        transition: var(--transition);
    }

    .stat-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-number {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--gray-800);
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--gray-500);
    }

    /* Schools Grid */
    .schools-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .school-card {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        transition: var(--transition);
        overflow: hidden;
        border: 1px solid var(--gray-200);
    }

    .school-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .card-header {
        position: relative;
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .school-logo {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid var(--white);
        box-shadow: var(--shadow);
    }

    .logo-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .default-logo {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .school-type-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
    }

    .school-type-badge.elementary {
        background: var(--success-color);
    }

    .school-type-badge.middle {
        background: var(--info-color);
    }

    .school-type-badge.high {
        background: var(--warning-color);
    }

    .school-type-badge.secondary {
        background: var(--danger-color);
    }

    .card-body {
        padding: 1.5rem;
    }

    .school-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0 0 1rem 0;
    }

    .school-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--gray-600);
        margin-bottom: 1rem;
    }

    .school-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        color: var(--gray-500);
        font-size: 0.875rem;
    }

    .card-actions {
        padding: 1rem 1.5rem;
        background: var(--gray-50);
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
        border-top: 1px solid var(--gray-200);
    }

    .action-btn {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        color: white;
    }

    .view-btn {
        background: var(--info-color);
    }

    .edit-btn {
        background: var(--warning-color);
    }

    .delete-btn {
        background: var(--danger-color);
    }

    .action-btn:hover {
        transform: scale(1.1);
        opacity: 0.9;
    }

    /* Delete Confirmation Modal */
    .delete-confirmation-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        max-width: 500px;
        width: 90%;
        position: relative;
        z-index: 10000;
        animation: modalSlideIn 0.3s ease-out;
    }

    .modal-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modal-header h3 {
        margin: 0;
        color: var(--gray-800);
        font-size: 1.25rem;
        font-weight: 600;
    }

    .warning-icon {
        font-size: 1.5rem;
        color: var(--danger-color);
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-body p {
        margin-bottom: 1rem;
        color: var(--gray-700);
    }

    .warning-message {
        background: #fef3c7;
        border: 1px solid #fbbf24;
        border-radius: 8px;
        padding: 1rem;
        display: flex;
        gap: 0.75rem;
        margin: 1rem 0;
    }

    .warning-message i {
        color: #d97706;
        font-size: 1.125rem;
        margin-top: 0.125rem;
        flex-shrink: 0;
    }

    .warning-message span {
        color: #92400e;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .danger-text {
        color: var(--danger-color);
        font-weight: 600;
        margin-top: 1rem;
    }

    .modal-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--gray-200);
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-outline-secondary {
        background: var(--white);
        border: 2px solid var(--gray-300);
        color: var(--gray-700);
    }

    .btn-danger {
        background: var(--danger-color);
        color: white;
    }

    .btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px) scale(0.95);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Empty State */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 4rem 2rem;
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--gray-400);
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--gray-500);
        margin-bottom: 2rem;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .schools-container {
            padding: 1rem;
        }

        .header-content {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .schools-grid {
            grid-template-columns: 1fr;
        }

        .stats-bar {
            flex-direction: column;
        }

        .page-title {
            font-size: 1.875rem;
            justify-content: center;
        }

        .modal-content {
            margin: 1rem;
        }

        .modal-footer {
            flex-direction: column;
            gap: 0.75rem;
        }

        .modal-footer .btn {
            width: 100%;
        }
    }

    /* Animation */
    .school-card {
        animation: fadeInUp 0.6s ease-out;
    }

    .school-card:nth-child(odd) {
        animation-delay: 0.1s;
    }

    .school-card:nth-child(even) {
        animation-delay: 0.2s;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    // School Actions
    function viewSchool(id) {
        // Redirect to school details page
        window.location.href = `schools.show/${id}`;
    }

    function editSchool(id) {
        // Redirect to school edit page
        window.location.href = `schools.edit/${id}`;
    }

    // Delete confirmation with better error handling
    function confirmDeleteSchool(schoolId, schoolName) {
        // Create custom confirmation modal
        const confirmModal = document.createElement('div');
        confirmModal.className = 'delete-confirmation-modal';
        confirmModal.innerHTML = `
            <div class="modal-backdrop" onclick="closeDeleteModal()"></div>
            <div class="modal-content">
                <div class="modal-header">
                    <i class="bi bi-exclamation-triangle warning-icon"></i>
                    <h3>Delete School</h3>
                </div>
                <div class="modal-body">
                    <p><strong>Are you sure you want to delete "${schoolName}"?</strong></p>
                    <div class="warning-message">
                        <i class="bi bi-info-circle"></i>
                        <span>If this school has any users, students, teachers, or other data associated with it, you may not be able to delete it. The system will prevent deletion to maintain data integrity and prevent data loss.</span>
                    </div>
                    <p class="danger-text">This action cannot be undone!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" onclick="closeDeleteModal()">
                        <i class="bi bi-x-circle"></i>
                        Cancel
                    </button>
                    <button type="button" class="btn btn-danger" onclick="proceedWithSchoolDelete(${schoolId})">
                        <i class="bi bi-trash"></i>
                        Yes, Delete School
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(confirmModal);
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        const modal = document.querySelector('.delete-confirmation-modal');
        if (modal) {
            document.body.removeChild(modal);
            document.body.style.overflow = '';
        }
    }

    function proceedWithSchoolDelete(schoolId) {
        const deleteForm = document.getElementById(`deleteSchoolForm${schoolId}`);
        if (deleteForm) {
            closeDeleteModal();
            deleteForm.submit();
        }
    }

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Schools management page loaded successfully');

        // Handle success messages
        @if(session('success'))
        showNotification(`{!! addslashes(session('success')) !!}`, 'success');
        @endif

        // Handle error messages
        @if(session('error'))
        showNotification(`{!! addslashes(session('error')) !!}`, 'error');
        @endif
    });

    // Enhanced notification function
    function showNotification(message, type) {
        // Remove any existing notifications first
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());

        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;

        // Create the notification HTML with proper message display
        notification.innerHTML = `
            <div class="notification-content">
                <div class="notification-icon">
                    <i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill'}"></i>
                </div>
                <div class="notification-message">
                    <div class="notification-title">${type === 'success' ? 'Success!' : 'Error!'}</div>
                    <div class="notification-text">${message}</div>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" class="notification-close">
                <i class="bi bi-x"></i>
            </button>
        `;

        // Add enhanced notification styles
        if (!document.querySelector('#notification-styles')) {
            const style = document.createElement('style');
            style.id = 'notification-styles';
            style.textContent = `
                .notification {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: white;
                    padding: 1.25rem;
                    border-radius: 12px;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.1), 0 4px 12px rgba(0,0,0,0.05);
                    display: flex;
                    align-items: flex-start;
                    justify-content: space-between;
                    gap: 1rem;
                    z-index: 10000;
                    max-width: 400px;
                    min-width: 320px;
                    animation: slideInRight 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
                    border: 1px solid rgba(0,0,0,0.05);
                }

                .notification-success {
                    border-left: 4px solid var(--success-color);
                    background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
                }

                .notification-error {
                    border-left: 4px solid var(--danger-color);
                    background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%);
                }

                .notification-content {
                    display: flex;
                    align-items: flex-start;
                    gap: 0.75rem;
                    flex: 1;
                }

                .notification-icon {
                    flex-shrink: 0;
                    margin-top: 0.125rem;
                }

                .notification-success .notification-icon i {
                    color: var(--success-color);
                    font-size: 1.25rem;
                }

                .notification-error .notification-icon i {
                    color: var(--danger-color);
                    font-size: 1.25rem;
                }

                .notification-message {
                    flex: 1;
                    min-width: 0;
                }

                .notification-title {
                    font-weight: 600;
                    font-size: 0.95rem;
                    margin-bottom: 0.25rem;
                    color: var(--gray-800);
                }

                .notification-text {
                    font-size: 0.875rem;
                    line-height: 1.4;
                    color: var(--gray-600);
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                }

                .notification-close {
                    background: none;
                    border: none;
                    color: var(--gray-400);
                    cursor: pointer;
                    padding: 0.25rem;
                    border-radius: 4px;
                    font-size: 1.125rem;
                    flex-shrink: 0;
                    transition: all 0.2s ease;
                    margin-top: -0.125rem;
                }

                .notification-close:hover {
                    color: var(--gray-600);
                    background: rgba(0,0,0,0.05);
                }

                @keyframes slideInRight {
                    from {
                        transform: translateX(100%) scale(0.95);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0) scale(1);
                        opacity: 1;
                    }
                }

                /* Animation for removing notification */
                .notification.removing {
                    animation: slideOutRight 0.3s ease-in forwards;
                }

                @keyframes slideOutRight {
                    to {
                        transform: translateX(100%) scale(0.95);
                        opacity: 0;
                    }
                }
            `;

            document.head.appendChild(style);
        }

        document.body.appendChild(notification);

        // Auto remove after 6 seconds with animation
        setTimeout(() => {
            if (document.body.contains(notification)) {
                notification.classList.add('removing');
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        notification.remove();
                    }
                }, 300);
            }
        }, 6000);
    }

    // Handle ESC key for modals
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endsection
