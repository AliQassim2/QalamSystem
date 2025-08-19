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
</style>

<div>
    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 4px;">Students Management</h1>
            <p style="color: #6b7280;">Manage all students in your school system</p>
        </div>
        <a href="{{ route('account.students.create') }}" class="btn btn-primary">
            <span style="margin-right: 8px;">+</span> Add New Student
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

    <!-- Students Table -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h2 style="font-size: 20px; font-weight: 600; color: #1f2937;">All Students</h2>
            <span style="color: #6b7280; font-size: 14px;">Total: {{ $students->count() }} students</span>
        </div>

        <!-- Search and Filter Bar -->
        <div class="search-bar">
            <input type="text" id="searchInput" class="form-input" placeholder="Search students..." style="flex: 2;">
            <select id="classFilter" class="form-input">
                <option value="">All Classes</option>
                @foreach($classes as $class)
                <option value="{{ $class->name }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        @if($students->count() > 0)
        <table class="table" id="studentsTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Class</th>
                    <th>Username</th>

                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <strong>{{ $student->user->name }}</strong>
                    </td>
                    <td>
                        <span class="badge badge-info">
                            {{ $student->classes->name ?? 'No Class' }}
                        </span>
                    </td>
                    <td>{{ $student->user->username ?? '-' }}</td>

                    <td>
                        <div style="display: flex; gap: 4px;">
                            <!-- View Button -->
                            <a href="{{ route('account.students.show', $student->id) }}"
                                class="btn btn-info" style="padding: 6px 12px; font-size: 12px;">
                                View
                            </a>
                            <!-- Edit Button -->
                            <a href="{{ route('account.students.edit', $student->id) }}"
                                class="btn btn-warning" style="padding: 6px 12px; font-size: 12px;">
                                Edit
                            </a>
                            <!-- Delete Button -->
                            <button onclick="deleteStudent({{ $student->id }}, '{{ $student->name }}', {{ $student->grades->count() ?? 0 }})"
                                class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div style="text-align: center; padding: 48px 0; color: #6b7280;">
            <div style="font-size: 48px; margin-bottom: 16px;">👨‍🎓</div>
            <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">No students found</h3>
            <p>Get started by adding your first student.</p>
            <a href="{{ route('account.students.create') }}" class="btn btn-primary" style="margin-top: 16px;">
                Add Your First Student
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
            <button id="confirmDeleteBtn" class="btn btn-danger">Delete Student</button>
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

    // Delete student function
    function deleteStudent(id, name, marksCount) {
        const deleteContent = document.getElementById('deleteContent');
        const confirmBtn = document.getElementById('confirmDeleteBtn');

        if (marksCount > 0) {
            deleteContent.innerHTML = `
            <div class="alert alert-warning">
                <strong>Cannot Delete!</strong><br>
                The student "<strong>${name}</strong>" has <strong>${marksCount}</strong> related records (marks/grades).<br><br>
                <strong>You can only:</strong><br>
                • <strong>Disable</strong> the student to hide them while keeping data<br>
                • Delete all related marks first, then delete the student
            </div>
            <p style="color: #6b7280; margin-top: 16px;">
                Deleting this student will permanently remove all related marks and academic data. This action cannot be undone.
            </p>
        `;
            confirmBtn.style.display = 'none';
        } else {
            deleteContent.innerHTML = `
            <div class="alert alert-error">
                <strong>Are you sure?</strong><br>
                You are about to permanently delete the student "<strong>${name}</strong>".
            </div>
            <p style="color: #6b7280; margin-top: 16px;">
                This action cannot be undone. The student will be completely removed from the system.
            </p>
        `;
            confirmBtn.style.display = 'inline-block';
            confirmBtn.onclick = function() {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/AccountManager/students/${id}`;
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
        const rows = document.querySelectorAll('#studentsTable tbody tr');

        rows.forEach(row => {
            const studentName = row.cells[1].textContent.toLowerCase();
            const email = row.cells[3].textContent.toLowerCase();
            const username = row.cells[4].textContent.toLowerCase();

            if (studentName.includes(searchTerm) || email.includes(searchTerm) || username.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Class filter functionality
    document.getElementById('classFilter').addEventListener('change', function() {
        const selectedClass = this.value;
        const rows = document.querySelectorAll('#studentsTable tbody tr');

        rows.forEach(row => {
            const studentClass = row.cells[2].textContent.trim();

            if (selectedClass === '' || studentClass.includes(selectedClass)) {
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
</script>
@endsection
