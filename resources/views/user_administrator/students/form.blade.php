{{-- ADD STUDENT FORM --}}
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

        .form-textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            resize: vertical;
            min-height: 80px;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            background: white;
        }

        .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-file {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            background: white;
        }

        .form-file:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 16px;
        }

        .form-section {
            margin-bottom: 24px;
        }

        .form-section-title {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e5e7eb;
        }

        .required {
            color: #ef4444;
        }

        .form-help {
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
        }

        .photo-preview {
            margin-top: 8px;
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
            border: 2px solid #e5e7eb;
            display: none;
        }

        .back-button {
            margin-bottom: 24px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
            margin-top: 24px;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                justify-content: stretch;
            }

            .form-actions .btn {
                flex: 1;
            }
        }
    </style>

    <div>

        <!-- Back Button -->
        <div class="back-button">
            <a href="{{ route('account.students') }}" class="btn btn-secondary">
                <span style="margin-right: 8px;">←</span> Go Back to Students
            </a>
        </div>

        <!-- Page Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div>
                <h1 style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 4px;">
                    {{ isset($student) ? 'Edit Student' : 'Add New Student' }}
                </h1>
                <p style="color: #6b7280;">
                    {{ isset($student) ? 'Update student information' : 'Fill in the details to add a new student' }}
                </p>
            </div>
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

        <!-- Student Form -->
        <div class="card">
            <form
                action="{{ isset($student) ? route('account.students.update', $student->id) : route('account.students.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($student))
                    @method('PUT')
                @endif

                <!-- Basic Information Section -->
                <div class="form-section">
                    <h3 class="form-section-title">Basic Information</h3>

                    <div class="form-grid">
                        <!-- Full Name -->
                        <div class="form-group">
                            <label class="form-label" for="name">Full Name <span class="required">*</span></label>
                            <input type="text" id="name" name="name" class="form-input"
                                value="{{ old('name', isset($student) ? $student->user->name : '') }}"
                                placeholder="Enter student's full name" required>
                            <div class="form-help">Enter the complete name of the student</div>
                        </div>

                        <!-- Username -->
                        <div class="form-group">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-input"
                                value="{{ old('username', isset($student) ? $student->user->username : '') }}"
                                placeholder="Enter unique username">
                            <div class="form-help">Unique username for student login</div>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="form-label" for="email">Email Address</label>
                            <input type="email" id="email" name="email" class="form-input"
                                value="{{ old('email', isset($student) ? $student->user->email : '') }}"
                                placeholder="student@example.com">
                            <div class="form-help">Student's email address for communication</div>
                        </div>

                        <!-- Phone Number -->
                        <div class="form-group">
                            <label class="form-label" for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="form-input"
                                value="{{ old('phone', isset($student) ? $student->user->phone : '') }}"
                                placeholder="+964 XXX XXX XXXX">
                            <div class="form-help">Student's contact number</div>
                        </div>



                        <!-- Student Photo -->
                        <div class="form-group">
                            <label class="form-label" for="photo">Student Photo</label>
                            <input type="file" id="photo" name="photo" class="form-file"
                                accept="image/jpg, image/jpeg, image/png" onchange="previewPhoto(this)">
                            <div class="form-help">Upload student's photo (JPG, PNG, max 2MB)</div>
                            <img id="photoPreview" class="photo-preview" src="#" alt="Photo preview">
                            @if (isset($student) && $student->photo)
                                <div style="margin-top: 8px;">
                                    <img src="{{ asset('storage/' . $student->photo) }}"
                                        style="max-width: 100px; border-radius: 8px;" alt="Current photo">
                                    <div class="form-help">Current photo</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Academic Information Section -->
                <div class="form-section">
                    <h3 class="form-section-title">Academic Information</h3>

                    <div class="form-grid">
                        <!-- Stage -->
                        <div class="form-group">
                            <label class="form-label" for="stage_id">Stage <span class="required">*</span></label>
                            <select id="stage_id" name="stage_id" class="form-select" required>
                                <option value="">Select a stage</option>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}"
                                        {{ old('class_id', isset($student) ? $student->classes->stage_id : '') == $stage->id ? 'selected' : '' }}>
                                        {{ $stage->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-help">Select the stage for this student</div>
                        </div>
                        <!-- Class -->
                        <div class="form-group">
                            <label class="form-label" for="class_id">Class <span class="required">*</span></label>
                            <select id="class_id" name="class_id" class="form-select" required>
                                <option value="">Select a class</option>

                            </select>
                            <div class="form-help">Select the class for this student</div>
                        </div>


                    </div>




                </div>

                <!-- Account Information Section -->
                <div class="form-section">
                    <h3 class="form-section-title">Account Information</h3>

                    <div class="form-grid">
                        <!-- Password -->
                        <div class="form-group">
                            <label class="form-label" for="password">Password <span class="required">*</span></label>
                            <input type="password" id="password" name="password" class="form-input"
                                placeholder="Enter password" {{ !isset($student) ? 'required' : '' }}>
                            <div class="form-help">
                                {{ isset($student) ? 'Leave blank to keep current password' : 'Strong password for student account' }}
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">Confirm Password <span
                                    class="required">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-input" placeholder="Confirm password"
                                {{ !isset($student) ? 'required' : '' }}>
                            <div class="form-help">Re-enter the password to confirm</div>
                        </div>
                        <!-- Status -->
                        <div class="form-group">
                            <label class="form-label" for="status">Status <span class="required">*</span></label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="">Select status</option>
                                <option value="0"
                                    {{ old('status', isset($student) ? $student->status : '') == 0 ? 'selected' : '' }}>
                                    Active</option>
                                <option value="1"
                                    {{ old('status', isset($student) ? $student->status : '') == 1 ? 'selected' : '' }}>
                                    Transferred</option>
                                <option value="2"
                                    {{ old('status', isset($student) ? $student->status : '') == 2 ? 'selected' : '' }}>
                                    Suspended</option>
                            </select>
                            <div class="form-help">Select the status for this student</div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('account.students') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn {{ isset($student) ? 'btn-primary' : 'btn-success' }}">
                        {{ isset($student) ? 'Update Student' : 'Add Student' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Photo preview function
        function previewPhoto(input) {
            const preview = document.getElementById('photoPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }

        // Form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('password_confirmation');

            // Password confirmation validation
            if (confirmPasswordField) {
                confirmPasswordField.addEventListener('input', function() {
                    if (passwordField.value !== confirmPasswordField.value) {
                        confirmPasswordField.setCustomValidity('Passwords do not match');
                    } else {
                        confirmPasswordField.setCustomValidity('');
                    }
                });
            }

            // Username validation (no spaces)
            const usernameField = document.getElementById('username');
            if (usernameField) {
                usernameField.addEventListener('input', function() {
                    this.value = this.value.toLowerCase().replace(/\s/g, '');
                });
            }

            // Phone number formatting
            const phoneFields = document.querySelectorAll('input[type="tel"]');
            phoneFields.forEach(field => {
                field.addEventListener('input', function() {
                    // Remove non-numeric characters except + and spaces
                    this.value = this.value.replace(/[^\d\+\s]/g, '');
                });
            });
        });



        function getStageValue() {
            const stageId = document.getElementById('stage_id').value;

            if (!stageId) {
                document.getElementById('class_id').innerHTML = '<option value="">Select a class</option>';
                return;
            }
            // Get the selected class id from server (edit or validation old input)
            const selectedClassId = "{{ old('class_id', isset($student) ? $student->class_id : '') }}";
            fetch(`/${stageId}`)
                .then(response => response.json())
                .then(data => {
                    // Populate classes
                    let classOptions = '<option value="">Select a class</option>';
                    data.classes.forEach(cls => {
                        // compare with selectedClassId
                        const selected = cls.id == selectedClassId ? 'selected' : '';
                        classOptions += `<option value="${cls.id}" ${selected}>${cls.name}</option>`;
                    });
                    document.getElementById('class_id').innerHTML = classOptions;

                });
        };


        document.getElementById('stage_id').addEventListener('change', getStageValue);
        @if (isset($student))
            getStageValue();
        @endif
    </script>
@endsection
