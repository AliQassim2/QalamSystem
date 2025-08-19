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
        <a href="{{ route('account.teachers') }}" class="btn btn-secondary">
            <span style="margin-right: 8px;">←</span> Go Back to Teachers
        </a>
    </div>

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 4px;">
                {{ isset($teacher) ? 'Edit Teacher' : 'Add New Teacher' }}
            </h1>
            <p style="color: #6b7280;">
                {{ isset($teacher) ? 'Update teacher information' : 'Fill in the details to add a new teacher' }}
            </p>
        </div>
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

    <!-- Teacher Form -->
    <div class="card">
        <form action="{{ isset($teacher) ? route('account.teachers.update', $teacher->id) : route('account.teachers.store') }}"
            method="POST">
            @csrf
            @if(isset($teacher))
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
                            value="{{ old('name', isset($teacher) ? $teacher->user->name : '') }}"
                            placeholder="Enter teacher's full name" required>
                        <div class="form-help">Enter the complete name of the teacher</div>
                    </div>

                    <!-- Username -->
                    <div class="form-group">
                        <label class="form-label" for="username">Username <span class="required">*</span></label>
                        <input type="text" id="username" name="username" class="form-input"
                            value="{{ old('username', isset($teacher) ? $teacher->user->username : '') }}"
                            placeholder="Enter unique username" required>
                        <div class="form-help">Unique username for teacher login</div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address <span class="required">*</span></label>
                        <input type="email" id="email" name="email" class="form-input"
                            value="{{ old('email', isset($teacher) ? $teacher->user->email : '') }}"
                            placeholder="teacher@example.com" required>
                        <div class="form-help">Teacher's email address for communication</div>
                    </div>

                    <!-- Phone Number -->
                    <div class="form-group">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-input"
                            value="{{ old('phone', isset($teacher) ? $teacher->user->phone : '') }}"
                            placeholder="+964 XXX XXX XXXX">
                        <div class="form-help">Teacher's contact number</div>
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
                            placeholder="Enter password" {{ !isset($teacher) ? 'required' : '' }}>
                        <div class="form-help">
                            {{ isset($teacher) ? 'Leave blank to keep current password' : 'Strong password for teacher account' }}
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Confirm Password <span class="required">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
                            placeholder="Confirm password" {{ !isset($teacher) ? 'required' : '' }}>
                        <div class="form-help">Re-enter the password to confirm</div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('account.teachers') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn {{ isset($teacher) ? 'btn-primary' : 'btn-success' }}">
                    {{ isset($teacher) ? 'Update Teacher' : 'Add Teacher' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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
        const phoneField = document.getElementById('phone');
        if (phoneField) {
            phoneField.addEventListener('input', function() {
                // Remove non-numeric characters except + and spaces
                this.value = this.value.replace(/[^\d\+\s]/g, '');
            });
        }
    });
</script>
@endsection
