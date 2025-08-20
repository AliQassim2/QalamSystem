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
        <!-- Back Button -->
        <div class="back-button">
            <a href="{{ route('account.teachers') }}" class="btn btn-secondary">
                <span style="margin-right: 8px;">←</span> Go Back to Teachers
            </a>
        </div>
        <!-- Page Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div>
                <h1 style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 4px;">links Management</h1>
                <p style="color: #6b7280;">Manage educational links for your school</p>
            </div>
            <button onclick="openModal('addModal')" class="btn btn-primary">
                <span style="margin-right: 8px;">+</span> Add New links
            </button>
        </div>


        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Please fix the following errors:</strong>
                <ul style="margin: 8px 0 0 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- classes Table -->
        <div class="card">

            <!-- Search and Filter Bar -->
            <div class="search-bar">
                <input type="text" id="searchInput" class="form-input" placeholder="Search links..." style="flex: 2;">
                <select id="stageFilter" class="form-input">
                    <option value="">All Stages</option>
                    @foreach ($stages as $stage)
                        <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                    @endforeach
                </select>
                <select id="classFilter" class="form-input">
                    <option value="">All Classes</option>

                </select>
                <select id="subjectFilter" class="form-input">
                    <option value="">All Subjects</option>

                </select>
            </div>

            @if ($links->count() > 0)
                <table class="table" id="linksTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Stage Name</th>
                            <th>Class Name</th>
                            <th>Subject Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($links ?? [] as $link)
                            <tr data-stage="{{ $link->class->stage->name ?? '' }}"
                                data-class="{{ $link->class->name ?? '' }}" data-subject="{{ $link->subject->name ?? '' }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $link->class->stage->name ?? '' }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $link->class->name ?? '' }}</strong>
                                </td>
                                <td>
                                    <span class="badge" style="background: #dbeafe; color: #1d4ed8;">
                                        {{ $link->subject->name ?? 0 }} Teacher
                                    </span>
                                </td>

                                <td>
                                    <div style="display: flex; gap: 4px;">
                                        <!-- Delete Button -->
                                        <button onclick="deleteclass({{ $link->class_id }}, {{ $link->subject_id }})"
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
                    <div style="font-size: 48px; margin-bottom: 16px;">📚</div>
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">No Links found</h3>
                    <p>Get started by adding your first educational link.</p>
                    <button onclick="openModal('addModal')" class="btn btn-primary" style="margin-top: 16px;">
                        Add Your First Link
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Add class Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-size: 20px; font-weight: 600; color: #1f2937; margin: 0;">Add New class</h3>
                <span class="close" onclick="closeModal('addModal')">&times;</span>
            </div>

            <form action="{{ route('account.teachers.links.store', $teacher) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="stage_id">Stage</label>
                    <select id="stage_id" name="stage_id" class="form-input" required>
                        <option value="">Select a stage</option>
                        @foreach ($stages ?? [] as $stage)
                            <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="class_id">Class</label>
                    <select id="class_id" name="class_id" class="form-input" required>
                        <option value="">Select a class</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="subject_id">Subject</label>
                    <select id="subject_id" name="subject_id" class="form-input" required>
                        <option value="">Select a subject</option>
                    </select>
                </div>
                <input type="submit" value="Add Link" class="btn btn-primary" style="width: 100%; margin-top: 16px;">
            </form>
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
                <button id="confirmDeleteBtn" class="btn btn-danger">Delete Anyway</button>
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



        // Delete class function
        function deleteclass(classes, subject) {
            const deleteContent = document.getElementById('deleteContent');
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            deleteContent.innerHTML = `
            <div class="alert alert-error">
                <strong>Are you sure?</strong><br>
                You are about to permanently delete the link.
            </div>
            <p style="color: #6b7280; margin-top: 16px;">
                This action cannot be undone. The link will be completely removed from the system.
            </p>
        `;
            confirmBtn.style.display = 'inline-block';
            confirmBtn.onclick = function() {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = ``;
                form.innerHTML = `
                @csrf
                @method('DELETE')
                <input type="hidden" name="class_id" value="${classes}">
                <input type="hidden" name="subject_id" value="${subject}">
            `;
                document.body.appendChild(form);
                form.submit();
            };
            openModal('deleteModal');
        }
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#linksTable tbody tr');

            rows.forEach(row => {
                const stageName = row.cells[1].textContent.toLowerCase();
                const className = row.cells[2].textContent.toLowerCase();
                const subjectName = row.cells[3].textContent.toLowerCase();

                if (stageName.includes(searchTerm) || className.includes(searchTerm) || subjectName
                    .includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        function applyFilters() {
            const stageSelect = document.getElementById('stageFilter');
            const selectedStage = stageSelect.options[stageSelect.selectedIndex].text;

            const selectedClass = document.getElementById('classFilter').value;
            const selectedSubject = document.getElementById('subjectFilter').value;

            const rows = document.querySelectorAll('#linksTable tbody tr');

            rows.forEach(row => {
                const rowStage = row.getAttribute('data-stage');
                const rowClass = row.getAttribute('data-class');
                const rowSubject = row.getAttribute('data-subject');

                const stageMatch = (selectedStage === 'All Stages' || rowStage === selectedStage);
                const classMatch = (selectedClass === '' || rowClass === selectedClass);
                const subjectMatch = (selectedSubject === '' || rowSubject === selectedSubject);

                if (stageMatch && classMatch && subjectMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Attach the same function to all three filters
        document.getElementById('stageFilter').addEventListener('change', applyFilters);
        document.getElementById('classFilter').addEventListener('change', applyFilters);
        document.getElementById('subjectFilter').addEventListener('change', applyFilters);



        document.getElementById('stageFilter').addEventListener('change', function() {
            const stageId = this.value;

            if (!stageId) {
                document.getElementById('classFilter').innerHTML = '<option value="">Select a class</option>';
                document.getElementById('subjectFilter').innerHTML = '<option value="">Select a subject</option>';
                return;
            }

            fetch(`/${stageId}`)
                .then(response => response.json())
                .then(data => {
                    // Populate classes
                    let classOptions = '<option value="">Select a class</option>';
                    data.classes.forEach(cls => {
                        classOptions += `<option value="${cls.name}">${cls.name}</option>`;
                    });
                    document.getElementById('classFilter').innerHTML = classOptions;

                    // Populate subjects
                    let subjectOptions = '<option value="">Select a subject</option>';
                    data.subjects.forEach(sub => {
                        subjectOptions += `<option value="${sub.name}">${sub.name}</option>`;
                    });
                    document.getElementById('subjectFilter').innerHTML = subjectOptions;
                });
        });

        // get stages for add
        document.getElementById('stage_id').addEventListener('change', function() {
            const stageId = this.value;

            if (!stageId) {
                document.getElementById('class_id').innerHTML = '<option value="">Select a class</option>';
                document.getElementById('subject_id').innerHTML = '<option value="">Select a subject</option>';
                return;
            }

            fetch(`/${stageId}`)
                .then(response => response.json())
                .then(data => {
                    // Populate classes
                    let classOptions = '<option value="">Select a class</option>';
                    data.classes.forEach(cls => {
                        classOptions += `<option value="${cls.id}">${cls.name}</option>`;
                    });
                    document.getElementById('class_id').innerHTML = classOptions;

                    // Populate subjects
                    let subjectOptions = '<option value="">Select a subject</option>';
                    data.subjects.forEach(sub => {
                        subjectOptions += `<option value="${sub.id}">${sub.name}</option>`;
                    });
                    document.getElementById('subject_id').innerHTML = subjectOptions;
                });
        });


        // Close modal when clicking outside
        window.onclick = function(event) {
            const modals = ['addModal', 'deleteModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    closeModal(modalId);
                }
            });
        }
    </script>
@endsection
