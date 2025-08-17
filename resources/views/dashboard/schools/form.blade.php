@extends('Dashboard.header')

@section('content')
<div class="form-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <div class="title-section">
                <h1 class="page-title">
                    <i class="bi bi-{{ isset($school) ? 'pencil-square' : 'plus-circle' }}"></i>
                    {{ isset($school) ? 'Edit School' : 'Add New School' }}
                </h1>
                <p class="page-subtitle">
                    {{ isset($school) ? 'Update school information and details' : 'Create a new school in the system' }}
                </p>
            </div>
            <div class="header-actions">
                <a href="{{ route('Dashboard.schools') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Back to Schools
                </a>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="form-wrapper">
        <form action="{{ isset($school) ? route('Dashboard.schools.update', $school) : route('Dashboard.schools.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="school-form"
            id="schoolForm">
            @csrf
            @if(isset($school))
            @method('PUT')
            @endif

            <div class="form-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-info-circle"></i>
                        Basic Information
                    </h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- School Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label required">School Name</label>
                                <input type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $school->name ?? '') }}"
                                    placeholder="Enter school name"
                                    required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- School Type -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type" class="form-label required">School Type</label>
                                <select class="form-select @error('type') is-invalid @enderror"
                                    id="type"
                                    name="type"
                                    required>
                                    <option value="">Select school type</option>
                                    <option value="1" {{ old('type', $school->type ?? '') == '1' ? 'selected' : '' }}>
                                        Elementary
                                    </option>
                                    <option value="2" {{ old('type', $school->type ?? '') == '2' ? 'selected' : '' }}>
                                        Middle School
                                    </option>
                                    <option value="3" {{ old('type', $school->type ?? '') == '3' ? 'selected' : '' }}>
                                        High School
                                    </option>
                                    <option value="4" {{ old('type', $school->type ?? '') == '4' ? 'selected' : '' }}>
                                        Secondary
                                    </option>
                                </select>
                                @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror"
                            id="address"
                            name="address"
                            rows="3"
                            placeholder="Enter school address (optional)">{{ old('address', $school->address ?? '') }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Logo Upload Section -->
            <div class="form-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-image"></i>
                        School Logo
                    </h3>
                </div>

                <div class="card-body">
                    <div class="logo-upload-section">
                        <div class="current-logo">
                            @if(isset($school) && $school->logo_path)
                            <div class="logo-preview">
                                <img src="{{ asset($school->logo_path) }}"
                                    alt="Current Logo"
                                    class="current-logo-img"
                                    id="currentLogoImg">
                            </div>
                            @else
                            <div class="no-logo" id="noLogoPlaceholder">
                                <i class="bi bi-image"></i>
                                <span>No logo uploaded</span>
                            </div>
                            @endif
                        </div>

                        <div class="upload-controls">
                            <div class="form-group">
                                <label for="logo" class="form-label">Upload New Logo</label>
                                <input type="file"
                                    class="form-control @error('logo') is-invalid @enderror"
                                    id="logo"
                                    name="logo"
                                    accept="image/*">
                                <div class="form-text">
                                    Supported formats: JPG, PNG, GIF. Max size: 2MB
                                </div>
                                @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if(isset($school) && $school->logo_path)
                            <div class="logo-actions">
                                <button type="button" class="btn btn-outline-danger btn-sm" id="removeLogo">
                                    <i class="bi bi-trash"></i>
                                    Remove Current Logo
                                </button>
                                <input type="hidden" name="remove_logo" id="removeLogoInput" value="0">
                            </div>
                            @endif
                        </div>

                        <!-- New Logo Preview -->
                        <div class="new-logo-preview" id="newLogoPreview" style="display: none;">
                            <h5>New Logo Preview:</h5>
                            <img src="" alt="New Logo Preview" id="newLogoImg">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle"></i>
                    {{ isset($school) ? 'Update School' : 'Create School' }}
                </button>
                <a href="{{ route('Dashboard.schools') }}" class="btn btn-outline-secondary btn-lg">
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

    .btn-outline-danger {
        background: var(--white);
        border: 2px solid var(--danger-color);
        color: var(--danger-color);
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

    /* Logo Upload Styles */
    .logo-upload-section {
        display: grid;
        gap: 2rem;
    }

    .current-logo {
        display: flex;
        justify-content: center;
    }

    .logo-preview {
        width: 150px;
        height: 150px;
        border-radius: var(--border-radius);
        overflow: hidden;
        border: 3px solid var(--gray-200);
        box-shadow: var(--shadow);
    }

    .current-logo-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-logo {
        width: 150px;
        height: 150px;
        border: 3px dashed var(--gray-300);
        border-radius: var(--border-radius);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--gray-400);
        background: var(--gray-50);
    }

    .no-logo i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .upload-controls {
        display: grid;
        gap: 1rem;
    }

    .logo-actions {
        display: flex;
        justify-content: center;
    }

    .new-logo-preview {
        text-align: center;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: var(--border-radius);
        border: 2px dashed var(--primary-color);
    }

    .new-logo-preview h5 {
        color: var(--gray-700);
        margin-bottom: 1rem;
    }

    .new-logo-preview img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 12px;
        box-shadow: var(--shadow);
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
    document.addEventListener('DOMContentLoaded', function() {
        const logoInput = document.getElementById('logo');
        const newLogoPreview = document.getElementById('newLogoPreview');
        const newLogoImg = document.getElementById('newLogoImg');
        const removeLogo = document.getElementById('removeLogo');
        const removeLogoInput = document.getElementById('removeLogoInput');
        const currentLogoImg = document.getElementById('currentLogoImg');
        const noLogoPlaceholder = document.getElementById('noLogoPlaceholder');
        const schoolForm = document.getElementById('schoolForm');

        // Handle new logo upload preview
        if (logoInput) {
            logoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('File size must be less than 2MB');
                        logoInput.value = '';
                        newLogoPreview.style.display = 'none';
                        return;
                    }

                    // Validate file type
                    if (!file.type.startsWith('image/')) {
                        alert('Please select a valid image file');
                        logoInput.value = '';
                        newLogoPreview.style.display = 'none';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        newLogoImg.src = e.target.result;
                        newLogoPreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    newLogoPreview.style.display = 'none';
                }
            });
        }

        // Handle remove current logo
        if (removeLogo) {
            removeLogo.addEventListener('click', function() {
                if (confirm('Are you sure you want to remove the current logo?')) {
                    removeLogoInput.value = '1';
                    if (currentLogoImg) {
                        currentLogoImg.style.display = 'none';
                    }
                    if (noLogoPlaceholder) {
                        noLogoPlaceholder.style.display = 'flex';
                    }
                    removeLogo.style.display = 'none';
                }
            });
        }

        // Form validation
        if (schoolForm) {
            schoolForm.addEventListener('submit', function(e) {
                const name = document.getElementById('name').value.trim();
                const type = document.getElementById('type').value;

                if (!name) {
                    e.preventDefault();
                    alert('Please enter a school name');
                    document.getElementById('name').focus();
                    return;
                }

                if (!type) {
                    e.preventDefault();
                    alert('Please select a school type');
                    document.getElementById('type').focus();
                    return;
                }
            });
        }

        console.log('School form page loaded successfully');
    });
</script>
@endsection