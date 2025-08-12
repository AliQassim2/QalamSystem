@extends('dashboard.header')
@section('content')
<div class="school-detail-container">
    <!-- Back Button -->
    <div class="back-section">
        <a href="{{ route('dashboard.schools') }}" class="back-btn">
            <i class="bi bi-arrow-left"></i>
            Back to Schools
        </a>
    </div>

    <!-- School Info Header -->
    <div class="school-header">
        <div class="school-header-content">
            <div class="school-main-info">
                <div class="school-logo-large">
                    @if ($school->logo_path)
                    <img src="{{ asset($school->logo_path) }}" alt="{{ $school->name }}" class="logo-img-large">
                    @else
                    <div class="default-logo-large">
                        <i class="bi bi-building"></i>
                    </div>
                    @endif
                </div>

                <div class="school-details">
                    <div class="school-type-badge-large {{ strtolower($school->type) }}">
                        {{ $school->type }}
                    </div>
                    <h1 class="school-name-large">{{ $school->name }}</h1>

                    @if ($school->address)
                    <div class="school-address">
                        <i class="bi bi-geo-alt"></i>
                        <span>{{ $school->address }}</span>
                    </div>
                    @endif

                    @if ($school->phone)
                    <div class="school-contact">
                        <i class="bi bi-telephone"></i>
                        <span>{{ $school->phone }}</span>
                    </div>
                    @endif

                    @if ($school->email)
                    <div class="school-contact">
                        <i class="bi bi-envelope"></i>
                        <span>{{ $school->email }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="school-actions-header">
                <button class="action-btn-header edit-btn" onclick="editSchool({{ $school->id }})">
                    <i class="bi bi-pencil"></i>
                    Edit School
                </button>
                <button class="action-btn-header delete-btn" onclick="confirmDeleteSchool({{ $school->id }}, '{{ $school->name }}')">
                    <i class="bi bi-trash"></i>
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- School Stats -->
    <div class="school-stats">
        <div class="stat-card">
            <div class="stat-icon students">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $school->students->count() }}</span>
                <span class="stat-label">Total Students</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon teachers">
                <i class="bi bi-person-workspace"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $school->teachers->count() }}</span>
                <span class="stat-label">Total Teachers</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon classes">
                <i class="bi bi-door-open"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $school->classes->count() ?? 0 }}</span>
                <span class="stat-label">Total Classes</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stages">
                <i class="bi bi-layers"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $school->stages->count() ?? 0 }}</span>
                <span class="stat-label">Total Stages</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon subjects">
                <i class="bi bi-journal-bookmark"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $school->subjects->count() ?? 0 }}</span>
                <span class="stat-label">Total Subjects</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon founded">
                <i class="bi bi-calendar-plus"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $school->created_at->format('Y') }}</span>
                <span class="stat-label">Founded</span>
            </div>
        </div>

        @if ($school->creator)
        <div class="stat-card">
            <div class="stat-icon creator">
                <i class="bi bi-person-badge"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ $school->creator->name }}</span>
                <span class="stat-label">Created By</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Content Tabs -->
    <div class="content-tabs">
        <div class="tab-navigation">
            <button class="tab-btn active" data-tab="students">
                <i class="bi bi-people"></i>
                Students ({{ $school->students->count() }})
            </button>
            <button class="tab-btn" data-tab="teachers">
                <i class="bi bi-person-workspace"></i>
                Teachers ({{ $school->teachers->count() }})
            </button>
            <button class="tab-btn" data-tab="classes">
                <i class="bi bi-door-open"></i>
                Classes ({{ $school->classes->count() ?? 0 }})
            </button>
            <button class="tab-btn" data-tab="subjects">
                <i class="bi bi-journal-bookmark"></i>
                Subjects ({{ $school->subjects->count() ?? 0 }})
            </button>
        </div>

        <!-- Students Tab -->
        <div class="tab-content active" id="students-tab">
            <div class="tab-header">
                <h3>Students List</h3>
            </div>

            <div class="data-table-container">
                @if($school->students->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Enrollment Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($school->students as $student)
                        <tr>
                            <td>
                                <div class="user-avatar">
                                    @if($student->avatar)
                                    <img src="{{ asset($student->avatar) }}" alt="{{ $student->name }}">
                                    @else
                                    <div class="avatar-placeholder">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="user-info">
                                    <span class="user-name">{{ $student->name }}</span>
                                </div>
                            </td>
                            <td>{{ $student->user->email ?? 'N/A' }}</td>
                            <td>{{ $student->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="status-badge {{ $student->status ?? 'active' }}">
                                    {{ ucfirst($student->status ?? 'Active') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3>No Students Enrolled</h3>
                    <p>This school doesn't have any students enrolled yet.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Teachers Tab -->
        <div class="tab-content" id="teachers-tab">
            <div class="tab-header">
                <h3>Teachers List</h3>
            </div>

            <div class="data-table-container">
                @if($school->teachers->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subjects</th>
                            <th>Hire Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($school->teachers as $teacher)
                        <tr>
                            <td>
                                <div class="user-avatar">
                                    @if($teacher->avatar)
                                    <img src="{{ asset($teacher->avatar) }}" alt="{{ $teacher->name }}">
                                    @else
                                    <div class="avatar-placeholder">
                                        {{ strtoupper(substr($teacher->name, 0, 1)) }}
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="user-info">
                                    <span class="user-name">{{ $teacher->name }}</span>
                                </div>
                            </td>
                            <td>
                                {{ $teacher->user->email ?? 'N/A' }}
                            </td>
                            <td>
                                <span>{{ $teacher->links->count() ?? 0 }}</span>
                            </td>
                            <td>{{ $teacher->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="status-badge {{ $teacher->status ?? 'active' }}">
                                    {{ ucfirst($teacher->status ?? 'Active') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-person-workspace"></i>
                    </div>
                    <h3>No Teachers Assigned</h3>
                    <p>This school doesn't have any teachers assigned yet.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Classes Tab -->
        <div class="tab-content" id="classes-tab">
            <div class="tab-header">
                <h3>Classes List</h3>
            </div>

            <div class="data-table-container">
                @if($school->classes->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Class Name</th>
                            <th>Stage</th>
                            <th>Current Students</th>
                            <th>Created Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($school->classes as $class)
                        <tr>
                            <td>
                                <div class="class-info">
                                    <span class="class-name">{{ $class->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="stage-badge">{{ $class->stage->name ?? 'N/A' }}</span>
                            </td>
                            <td>{{ $class->students->count() ?? 0 }}</td>
                            <td>{{ $class->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="status-badge {{ $class->status ?? 'active' }}">
                                    {{ ucfirst($class->status ?? 'Active') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-door-open"></i>
                    </div>
                    <h3>No Classes Available</h3>
                    <p>This school doesn't have any classes set up yet.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Subjects Tab -->
        <div class="tab-content" id="subjects-tab">
            <div class="tab-header">
                <h3>Subjects List</h3>
            </div>

            <div class="data-table-container">
                @if($school->subjects->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Subject Name</th>
                            <th>Stage</th>
                            <th>Teachers</th>
                            <th>Created Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($school->subjects as $subject)
                        <tr>
                            <td>
                                <div class="subject-info">
                                    <span class="subject-name">{{ $subject->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="stage-badge">{{ $subject->stage->name ?? 'N/A' }}</span>
                            </td>
                            <td>{{ $subject->links->count() ?? 0 }}</td>
                            <td>{{ $subject->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="status-badge {{ $subject->status ?? 'active' }}">
                                    {{ ucfirst($subject->status ?? 'Active') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-journal-bookmark"></i>
                    </div>
                    <h3>No Subjects Available</h3>
                    <p>This school doesn't have any subjects set up yet.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Hidden Delete Form -->
<form id="deleteSchoolForm{{ $school->id }}" action="{{ route('dashboard.schools.destroy', $school) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

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
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --border-radius: 16px;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        direction: ltr;
        text-align: left;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: var(--light-bg);
    }

    .school-detail-container {
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Back Button */
    .back-section {
        margin-bottom: 2rem;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--gray-600);
        text-decoration: none;
        font-weight: 500;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        transition: var(--transition);
    }

    .back-btn:hover {
        background: var(--gray-100);
        color: var(--primary-color);
    }

    /* School Header */
    .school-header {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .school-header-content {
        padding: 2.5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
    }

    .school-main-info {
        display: flex;
        gap: 2rem;
        align-items: flex-start;
    }

    .school-logo-large {
        width: 120px;
        height: 120px;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        flex-shrink: 0;
    }

    .logo-img-large {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .default-logo-large {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
    }

    .school-details {
        flex: 1;
    }

    .school-type-badge-large {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        color: white;
        margin-bottom: 1rem;
    }

    .school-type-badge-large.elementary {
        background: var(--success-color);
    }

    .school-type-badge-large.middle {
        background: var(--info-color);
    }

    .school-type-badge-large.high {
        background: var(--warning-color);
    }

    .school-type-badge-large.secondary {
        background: var(--danger-color);
    }

    .school-name-large {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0 0 1.5rem 0;
        line-height: 1.2;
    }

    .school-address,
    .school-contact {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--gray-600);
        font-size: 1.125rem;
        margin-bottom: 0.75rem;
    }

    .school-address i,
    .school-contact i {
        color: var(--primary-color);
        font-size: 1.25rem;
    }

    .school-actions-header {
        display: flex;
        gap: 1rem;
        flex-shrink: 0;
    }

    .action-btn-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.875rem 1.5rem;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        transition: var(--transition);
        cursor: pointer;
        text-decoration: none;
        color: white;
    }

    .action-btn-header.edit-btn {
        background: var(--warning-color);
    }

    .action-btn-header.delete-btn {
        background: var(--danger-color);
    }

    .action-btn-header:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* School Stats */
    .school-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 1.5rem;
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        color: white;
    }

    .stat-icon.students {
        background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
    }

    .stat-icon.teachers {
        background: linear-gradient(135deg, var(--info-color) 0%, #0891b2 100%);
    }

    .stat-icon.classes {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }

    .stat-icon.stages {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .stat-icon.subjects {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .stat-icon.founded {
        background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
    }

    .stat-icon.creator {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    }

    /* Content Tabs */
    .content-tabs {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .tab-navigation {
        display: flex;
        border-bottom: 1px solid var(--gray-200);
        background: var(--gray-50);
        overflow-x: auto;
    }

    .tab-btn {
        flex: 1;
        padding: 1.5rem 2rem;
        border: none;
        background: none;
        color: var(--gray-600);
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: var(--transition);
        font-size: 1rem;
        white-space: nowrap;
        min-width: 200px;
    }

    .tab-btn:hover {
        background: var(--gray-100);
        color: var(--primary-color);
    }

    .tab-btn.active {
        background: var(--white);
        color: var(--primary-color);
        border-bottom: 3px solid var(--primary-color);
    }

    .tab-content {
        display: none;
        padding: 2rem;
    }

    .tab-content.active {
        display: block;
    }

    .tab-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .tab-header h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0;
    }

    .btn-add {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-add:hover {
        background: var(--secondary-color);
        transform: translateY(-1px);
    }

    /* Data Table */
    .data-table-container {
        overflow-x: auto;
        border-radius: 12px;
        border: 1px solid var(--gray-200);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        background: var(--white);
    }

    .data-table th {
        background: var(--gray-50);
        padding: 1rem 1.5rem;
        text-align: left;
        font-weight: 600;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-200);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .data-table td {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--gray-100);
        vertical-align: middle;
    }

    .data-table tr:hover {
        background: var(--gray-50);
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid var(--gray-200);
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1rem;
    }

    .user-info,
    .class-info,
    .subject-info {
        display: flex;
        flex-direction: column;
    }

    .user-name,
    .class-name,
    .subject-name {
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 0.25rem;
    }

    .user-id {
        font-size: 0.75rem;
        color: var(--gray-500);
    }

    .grade-badge,
    .subject-badge,
    .stage-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background: var(--info-color);
        color: white;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .subject-code {
        font-family: monospace;
        background: var(--gray-100);
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.875rem;
        color: var(--gray-700);
        font-weight: 600;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
    }

    .status-badge.active {
        background: var(--success-color);
    }

    .status-badge.inactive {
        background: var(--gray-400);
    }

    .status-badge.suspended {
        background: var(--danger-color);
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
        text-align: center;
        padding: 4rem 2rem;
        color: var(--gray-500);
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--gray-300);
        margin-bottom: 1.5rem;
    }

    .empty-state h3 {
        color: var(--gray-600);
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }

    .empty-state p {
        margin-bottom: 2rem;
        font-size: 1.125rem;
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: var(--transition);
        font-size: 1rem;
    }

    .btn-primary:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .school-header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .school-actions-header {
            align-self: flex-end;
        }
    }

    @media (max-width: 768px) {
        .school-detail-container {
            padding: 1rem;
        }

        .school-main-info {
            flex-direction: column;
            text-align: center;
        }

        .school-logo-large {
            align-self: center;
        }

        .school-stats {
            grid-template-columns: 1fr;
        }

        .tab-navigation {
            flex-direction: column;
        }

        .tab-btn {
            min-width: auto;
        }

        .tab-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .school-actions-header {
            flex-direction: column;
            width: 100%;
        }

        .action-btn-header {
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

    @media (max-width: 600px) {
        .data-table-container {
            font-size: 0.875rem;
        }

        .data-table th,
        .data-table td {
            padding: 0.75rem 1rem;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
        }

        .school-name-large {
            font-size: 2rem;
        }
    }

    /* Animation */
    .school-header,
    .stat-card,
    .content-tabs {
        animation: fadeInUp 0.6s ease-out;
    }

    .stat-card:nth-child(2) {
        animation-delay: 0.1s;
    }

    .stat-card:nth-child(3) {
        animation-delay: 0.2s;
    }

    .stat-card:nth-child(4) {
        animation-delay: 0.3s;
    }

    .stat-card:nth-child(5) {
        animation-delay: 0.4s;
    }

    .stat-card:nth-child(6) {
        animation-delay: 0.5s;
    }

    .stat-card:nth-child(7) {
        animation-delay: 0.6s;
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
    // Tab Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetTab = this.dataset.tab;

                // Remove active class from all tabs and contents
                tabBtns.forEach(b => b.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));

                // Add active class to clicked tab and corresponding content
                this.classList.add('active');
                document.getElementById(targetTab + '-tab').classList.add('active');
            });
        });

        // Handle success messages
        @if(session('success'))
        showNotification(`{!! addslashes(session('success')) !!}`, 'success');
        @endif

        // Handle error messages
        @if(session('error'))
        showNotification(`{!! addslashes(session('error')) !!}`, 'error');
        @endif
    });

    // School Actions
    function editSchool(id) {
        window.location.href = `/Dashboard/schools.edit/${id}`;
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
                        <span>If this school has any users, students, teachers, classes, subjects, or other data associated with it, you may not be able to delete it. The system will prevent deletion to maintain data integrity and prevent data loss.</span>
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

    // Initialize page
    console.log('School detail page loaded successfully');
</script>
@endsection
