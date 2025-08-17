@extends('Dashboard.header')

@section('content')
<div class="form-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <div class="title-section">
                <h1 class="page-title">
                    <i class="bi bi-{{ isset($user) ? 'pencil-square' : 'person-plus' }}"></i>
                    {{ isset($user) ? 'Edit User' : 'Add New User' }}
                </h1>
                <p class="page-subtitle">
                    {{ isset($user) ? 'Update user account information' : 'Create a new user account in the system' }}
                </p>
            </div>
            <div class="header-actions">
                <a href="{{ route('Dashboard.users.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Back to Users
                </a>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="form-wrapper">
        <form action="{{ isset($user) ? route('Dashboard.users.update', $user) : route('Dashboard.users.store') }}"
            method="POST" class="user-form" id="userForm">
            @csrf
            @if (isset($user))
            @method('PUT')
            @endif

            <div class="form-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-person-circle"></i>
                        Personal Information
                    </h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Full Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label required">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $user->name ?? '') }}"
                                    placeholder="Enter full name" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username" class="form-label required">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" value="{{ old('username', $user->username ?? '') }}"
                                    placeholder="Enter username" required>
                                <div class="form-text">Username must be unique and contain only letters, numbers, and
                                    underscores</div>
                                @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="usernameAvailability" class="availability-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label required">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $user->email ?? '') }}"
                            placeholder="Enter email address" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="emailAvailability" class="availability-feedback"></div>
                    </div>

                    <!-- Phone (Optional) -->
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                            placeholder="Enter phone number (optional)">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="form-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-shield-check"></i>
                        Account Information
                    </h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Password -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="form-label {{ !isset($user) ? 'required' : '' }}">
                                    {{ isset($user) ? 'New Password' : 'Password' }}
                                </label>
                                <div class="password-input-container">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password"
                                        placeholder="{{ isset($user) ? 'Enter new password (leave blank to keep current)' : 'Enter password' }}"
                                        {{ !isset($user) ? 'required' : '' }}>
                                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                        <i class="bi bi-eye" id="passwordToggleIcon"></i>
                                    </button>
                                </div>
                                <div class="form-text">
                                    {{ isset($user) ? 'Leave blank to keep current password. ' : '' }}Password must be
                                    at least 8 characters long
                                </div>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation"
                                    class="form-label {{ !isset($user) ? 'required' : '' }}">
                                    Confirm Password
                                </label>
                                <div class="password-input-container">
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation"
                                        placeholder="{{ isset($user) ? 'Confirm new password' : 'Confirm password' }}"
                                        {{ !isset($user) ? 'required' : '' }}>
                                    <button type="button" class="password-toggle"
                                        onclick="togglePassword('password_confirmation')">
                                        <i class="bi bi-eye" id="passwordConfirmToggleIcon"></i>
                                    </button>
                                </div>
                                <div id="passwordMatch" class="password-match-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Role -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role" class="form-label required">User Role</label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role"
                                    name="role" required>
                                    <option value="">Select user role</option>
                                    <option value="0"
                                        {{ old('role', $user->role ?? '') == '0' || (isset($user) && $user->role == '1') ? 'selected' : '' }}>
                                        School Manager
                                    </option>
                                    <option value="1"
                                        {{ old('role', $user->role ?? '') == '1' || (isset($user) && $user->role == '2') ? 'selected' : '' }}>
                                        User Administrator
                                    </option>
                                    <option value="2"
                                        {{ old('role', $user->role ?? '') == '2' || (isset($user) && $user->role == '3') ? 'selected' : '' }}>
                                        Structure Manager
                                    </option>
                                </select>
                                @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- School (Conditional) -->
                        @if (!isset($user))
                        <div class="col-md-6">
                            <div class="form-group" id="schoolGroup">
                                <label for="school_id" class="form-label required">Assigned School</label>
                                <select class="form-select @error('school_id') is-invalid @enderror"
                                    id="school_id" name="school_id">
                                    <option value="">Select school</option>
                                    @foreach ($schools as $school)
                                    <option value="{{ $school->id }}"
                                        {{ old('school_id', $user->school_id ?? '') == $school->id ? 'selected' : '' }}>
                                        {{ $school->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('school_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Account Status -->
                    <div class="form-group">
                        <label class="form-label">Account Status</label>
                        <div class="status-options">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="state" id="active"
                                    value="1" {{ old('state', $user->state ?? '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label active-label" for="active">
                                    <i class="bi bi-check-circle"></i>
                                    Active
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="state" id="inactive"
                                    value="0" {{ old('state', $user->state ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label inactive-label" for="inactive">
                                    <i class="bi bi-pause-circle"></i>
                                    Inactive
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                    <i class="bi bi-{{ isset($user) ? 'check-circle' : 'person-plus' }}"></i>
                    {{ isset($user) ? 'Update User' : 'Create User' }}
                </button>
                <a href="{{ route('Dashboard.users.index') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-x-circle"></i>
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

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
        background: var(--light-bg);
    }

    .form-container {
        padding: 2rem;
        max-width: 1000px;
        margin: 0 auto;
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

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: var(--transition);
        box-shadow: var(--shadow);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
    }

    .btn-outline-secondary {
        background: var(--white);
        border: 2px solid var(--gray-300);
        color: var(--gray-700);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Form Styles */
    .form-wrapper {
        background: var(--white);
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .form-card {
        border-bottom: 1px solid var(--gray-200);
    }

    .form-card:last-child {
        border-bottom: none;
    }

    .card-header {
        background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-title i {
        color: var(--primary-color);
    }

    .card-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-label.required::after {
        content: ' *';
        color: var(--danger-color);
    }

    .form-control,
    .form-select {
        border: 2px solid var(--gray-300);
        border-radius: 12px;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: var(--transition);
        width: 100%;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        outline: none;
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: var(--danger-color);
    }

    .invalid-feedback {
        color: var(--danger-color);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .form-text {
        font-size: 0.875rem;
        color: var(--gray-500);
        margin-top: 0.25rem;
    }

    /* Password Input */
    .password-input-container {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--gray-500);
        cursor: pointer;
        font-size: 1rem;
    }

    .password-toggle:hover {
        color: var(--primary-color);
    }

    /* Availability Feedback */
    .availability-feedback {
        margin-top: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .availability-feedback.available {
        color: var(--success-color);
    }

    .availability-feedback.unavailable {
        color: var(--danger-color);
    }

    .password-match-feedback {
        margin-top: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .password-match-feedback.match {
        color: var(--success-color);
    }

    .password-match-feedback.no-match {
        color: var(--danger-color);
    }

    /* Status Options */
    .status-options {
        display: flex;
        gap: 2rem;
        margin-top: 0.5rem;
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-check-input {
        margin: 0;
    }

    .form-check-label {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-weight: 500;
        cursor: pointer;
    }

    .active-label {
        color: var(--success-color);
    }

    .inactive-label {
        color: var(--warning-color);
    }

    /* Form Actions */
    .form-actions {
        padding: 2rem;
        background: var(--gray-50);
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .btn-lg {
        padding: 1rem 2rem;
        font-size: 1.125rem;
    }

    /* Loading State */
    .btn.loading {
        opacity: 0.7;
        cursor: not-allowed;
        pointer-events: none;
    }

    .btn.loading::after {
        content: '';
        width: 16px;
        height: 16px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-left: 0.5rem;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-container {
            padding: 1rem;
        }

        .header-content {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .card-body {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .page-title {
            font-size: 1.875rem;
            justify-content: center;
        }

        .status-options {
            flex-direction: column;
            gap: 1rem;
        }
    }

    /* Animation */
    .form-card {
        animation: slideInUp 0.6s ease-out;
    }

    .form-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .form-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    @keyframes slideInUp {
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
    // Toggle school field based on role selection
    @if(!isset($user))

    function toggleSchoolField() {
        const roleSelect = document.getElementById('role');
        const schoolGroup = document.getElementById('schoolGroup');
        const schoolSelect = document.getElementById('school_id');

        // Show school field only for School Manager (role 3)
        schoolGroup.style.display = "{{ isset($user) ? 'none' : 'block' }}";
        schoolSelect.required = true;

    }
    @endif


    // Toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + 'ToggleIcon');

        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    // Check username availability
    function checkUsernameAvailability(username) {
        if (username.length < 3) return;

        const feedback = document.getElementById('usernameAvailability');
        feedback.innerHTML = 'Checking...';
        feedback.className = 'availability-feedback';

        // Simulate API call - replace with actual endpoint
        setTimeout(() => {
            // This should be an actual AJAX call to your backend
            const isAvailable = Math.random() > 0.3; // Random for demo

            if (isAvailable) {
                feedback.innerHTML = '<i class="bi bi-check-circle"></i> Username is available';
                feedback.className = 'availability-feedback available';
            } else {
                feedback.innerHTML = '<i class="bi bi-x-circle"></i> Username is already taken';
                feedback.className = 'availability-feedback unavailable';
            }
        }, 500);
    }

    // Check email availability
    function checkEmailAvailability(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) return;

        const feedback = document.getElementById('emailAvailability');
        feedback.innerHTML = 'Checking...';
        feedback.className = 'availability-feedback';

        // Simulate API call - replace with actual endpoint
        setTimeout(() => {
            // This should be an actual AJAX call to your backend
            const isAvailable = Math.random() > 0.2; // Random for demo

            if (isAvailable) {
                feedback.innerHTML = '<i class="bi bi-check-circle"></i> Email is available';
                feedback.className = 'availability-feedback available';
            } else {
                feedback.innerHTML = '<i class="bi bi-x-circle"></i> Email is already registered';
                feedback.className = 'availability-feedback unavailable';
            }
        }, 500);
    }

    // Check password match
    function checkPasswordMatch() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        const feedback = document.getElementById('passwordMatch');

        if (confirmPassword.length === 0) {
            feedback.innerHTML = '';
            return;
        }

        if (password === confirmPassword) {
            feedback.innerHTML = '<i class="bi bi-check-circle"></i> Passwords match';
            feedback.className = 'password-match-feedback match';
        } else {
            feedback.innerHTML = '<i class="bi bi-x-circle"></i> Passwords do not match';
            feedback.className = 'password-match-feedback no-match';
        }
    }

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        const userForm = document.getElementById('userForm');
        const submitBtn = document.getElementById('submitBtn');
        const usernameInput = document.getElementById('username');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        // Initialize school field visibility
        @if(!isset($user))
        toggleSchoolField();
        @endif

        // Username availability check
        let usernameTimeout;
        usernameInput.addEventListener('input', function() {
            clearTimeout(usernameTimeout);
            usernameTimeout = setTimeout(() => {
                checkUsernameAvailability(this.value);
            }, 300);
        });

        // Email availability check
        let emailTimeout;
        emailInput.addEventListener('input', function() {
            clearTimeout(emailTimeout);
            emailTimeout = setTimeout(() => {
                checkEmailAvailability(this.value);
            }, 300);
        });

        // Password match check
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
        passwordInput.addEventListener('input', checkPasswordMatch);

        // Form submission
        userForm.addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const username = document.getElementById('username').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const role = document.getElementById('role').value;
            const schoolId = document.getElementById('school_id').value;

            // Basic validation
            if (!name || !username || !email || !password || !confirmPassword || !role) {
                e.preventDefault();
                alert('Please fill in all required fields');
                return;
            }

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match');
                return;
            }

            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long');
                return;
            }

            // Check if school is required for school manager
            if (role === '3' && !schoolId) {
                e.preventDefault();
                alert('Please select a school for the School Manager role');
                return;
            }

            // Show loading state
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });

        console.log('Add user form loaded successfully');
    });
</script>
@endsection