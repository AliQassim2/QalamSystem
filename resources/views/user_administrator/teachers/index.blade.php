@extends('user_administrator.header')

@section('content')
<style>
    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 24px;
        margin-bottom: 24px;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        margin: 2px;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
    }

    .btn-warning {
        background: #f59e0b;
        color: white;
    }

    .btn-warning:hover {
        background: #d97706;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .btn-info {
        background: #0ea5e9;
        color: white;
    }

    .btn-info:hover {
        background: #0284c7;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-label {
        display: block;
        margin-bottom: 4px;
        font-weight: 500;
        color: #374151;
    }

    .form-input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 16px;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    .table th {
        background: #f9fafb;
        font-weight: 600;
        color: #374151;
    }

    .table tr:hover {
        background: #f9fafb;
    }

    .badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-success {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-info {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .badge-purple {
        background: #ede9fe;
        color: #7c3aed;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: white;
        margin: 15% auto;
        padding: 20px;
        border-radius: 8px;
        width: 90%;
        max-width: 500px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: black;
    }

    .alert {
        padding: 12px 16px;
        margin-bottom: 16px;
        border-radius: 6px;
        border-left: 4px solid;
    }

    .alert-success {
        background: #f0f9f4;
        border-left-color: #10b981;
        color: #065f46;
    }

    .alert-error {
        background: #fef2f2;
        border-left-color: #ef4444;
        color: #991b1b;
    }

    .alert-warning {
        background: #fefbf2;
        border-left-color: #f59e0b;
        color: #92400e;
    }

    .disabled-row {
        opacity: 0.6;
        background: #f9fafb;
    }

    .search-bar {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
        align-items: center;
    }

    .search-bar input,
    .search-bar select {
        flex: 1;
        max-width: 250px;
    }

    .teacher-name {
        font-weight: 600;
        color: #1f2937;
    }

    .username {
        color: #6b7280;
        font-style: italic;
    }
</style>

<div>
    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 4px;">Teachers Management</h1>
            <p style="color: #6b7280;">Manage all teachers in your school system</p>
        </div>
        <a href="{{ route('account.teachers.create') }}" class="btn btn-primary">
            <span style="margin-right: 8px;">+</span> Add New Teacher
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success">
        <strong>Success!</strong> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <strong>Error!</strong> {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">
        <strong>Please fix the following errors:</strong>
        <ul style="margin: 8px 0 0 20px;">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Teachers Table -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h2 style="font-size: 20px; font-weight: 600; color: #1f2937;">All Teachers</h2>
            <span style="color: #6b7280; font-size: 14px;">Total: {{ $teachers->count() }} teachers</span>
        </div>

        <!-- Search and Filter Bar -->
        <div class="search-bar">
            <input type="text" id="searchInput" class="form-input" placeholder="Search teachers..." style="flex: 2;">

        </div>

        @if($teachers->count() > 0)
        <table class="table" id="teachersTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Teacher Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Stages Count</th>
                    <th>Classes Count</th>
                    <th>Subjects Count</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $teacher)
                <tr class="{{ $teacher->deleted_at ? 'disabled-row' : '' }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="teacher-name">{{ $teacher->user->name }}</div>

                    </td>
                    <td>
                        <span class="username">{{ $teacher->user->username ?? '-' }}</span>
                    </td>
                    <td>{{ $teacher->user->email ?? '-' }}</td>
                    <td>
                        <span class="badge badge-info">
                            {{ $teacher->stages->count() ?? 0 }} stages
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-info">
                            {{ $teacher->links->unique('class_id')->count() ?? 0 }} classes
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-purple">
                            {{ $teacher->links->unique('subject_id')->count() ?? 0 }} subjects
                        </span>
                    </td>
                    <td>
                        @if($teacher->deleted_at)
                        <span class="badge badge-danger">Inactive</span>
                        @else
                        <span class="badge badge-success">Active</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 4px;">
                            <!-- View Button -->
                            <a href="{{ route('account.teachers.show', $teacher->id) }}"
                                class="btn btn-info" style="padding: 6px 12px; font-size: 12px;">
                                View
                            </a>
                            <!-- Edit Button -->
                            <a href="{{ route('account.teachers.edit', $teacher->id) }}"
                                class="btn btn-warning" style="padding: 6px 12px; font-size: 12px;">
                                Edit
                            </a>
                            <!-- Delete Button -->
                            <button onclick="deleteTeacher({{ $teacher->id }}, '{{ $teacher->name }}', {{ ($teacher->stages->count() ?? 0) + ($teacher->links->unique('subject_id')->count() ?? 0) + ($teacher->links->unique('class_id')->count() ?? 0) }})"
                                class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;">
                                Delete
                            </button>
                            <!-- Edit Button -->
                            <a href="{{ route('account.teachers.links', $teacher->id) }}"
                                class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">
                                View links
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div style="text-align: center; padding: 48px 0; color: #6b7280;">
            <div style="font-size: 48px; margin-bottom: 16px;">👨‍🏫</div>
            <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">No teachers found</h3>
            <p>Get started by adding your first teacher.</p>
            <a href="{{ route('account.teachers.create') }}" class="btn btn-primary" style="margin-top: 16px;">
                Add Your First Teacher
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Delete Warning Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-size: 20px; font-weight: 600; color: #dc2626; margin: 0;">⚠️ Delete Warning</h3>
            <span class="close" onclick="closeModal('deleteModal')">&times;</span>
        </div>

        <div id="deleteContent">
            <!-- Content will be filled by JavaScript -->
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
            <button type="button" onclick="closeModal('deleteModal')" class="btn btn-secondary">Cancel</button>
            <button id="confirmDeleteBtn" class="btn btn-danger">Delete Teacher</button>
        </div>
    </div>
</div>

<script>
    // Modal functions
    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    // Delete teacher function
    function deleteTeacher(id, name, relatedDataCount) {
        const deleteContent = document.getElementById('deleteContent');
        const confirmBtn = document.getElementById('confirmDeleteBtn');

        if (relatedDataCount > 0) {
            deleteContent.innerHTML = `
            <div class="alert alert-warning">
                <strong>Cannot Delete!</strong><br>
                The teacher "<strong>${name}</strong>" has <strong>${relatedDataCount}</strong> related records (stages, subjects, or classes).<br><br>
                <strong>You can only:</strong><br>
                • <strong>Disable</strong> the teacher to hide them while keeping data<br>
                • Remove all assignments first, then delete the teacher
            </div>
            <p style="color: #6b7280; margin-top: 16px;">
                Deleting this teacher will permanently remove all related teaching assignments and academic data. This action cannot be undone.
            </p>
        `;
            confirmBtn.style.display = 'none';
        } else {
            deleteContent.innerHTML = `
            <div class="alert alert-error">
                <strong>Are you sure?</strong><br>
                You are about to permanently delete the teacher "<strong>${name}</strong>".
            </div>
            <p style="color: #6b7280; margin-top: 16px;">
                This action cannot be undone. The teacher will be completely removed from the system.
            </p>
        `;
            confirmBtn.style.display = 'inline-block';
            confirmBtn.onclick = function() {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `teachers/${id}`;
                form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
                document.body.appendChild(form);
                form.submit();
            };
        }

        openModal('deleteModal');
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#teachersTable tbody tr');

        rows.forEach(row => {
            if (row.classList.contains('disabled-row')) return;

            const teacherName = row.cells[1].textContent.toLowerCase();
            const username = row.cells[2].textContent.toLowerCase();
            const email = row.cells[3].textContent.toLowerCase();

            if (teacherName.includes(searchTerm) || username.includes(searchTerm) || email.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });



    // Close modal when clicking outside
    window.onclick = function(event) {
        const modals = ['deleteModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (event.target === modal) {
                closeModal(modalId);
            }
        });
    }

    // Update total count when rows are filtered
    function updateTotalCount() {
        const visibleRows = document.querySelectorAll('#teachersTable tbody tr:not([style*="display: none"])');
        const totalSpan = document.querySelector('.card h2 + span');
        if (totalSpan) {
            totalSpan.textContent = `Showing: ${visibleRows.length} teachers`;
        }
    }

    // Add event listeners for filter updates
    document.getElementById('searchInput').addEventListener('input', updateTotalCount);
</script>
@endsection
