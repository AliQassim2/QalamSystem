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

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .btn-warning {
        background: #f59e0b;
        color: white;
    }

    .btn-warning:hover {
        background: #d97706;
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

    .badge-info {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .badge-purple {
        background: #ede9fe;
        color: #7c3aed;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        margin-bottom: 24px;
    }

    .info-item {
        background: #f8fafc;
        padding: 16px;
        border-radius: 8px;
        border-left: 4px solid #3b82f6;
    }

    .info-label {
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e5e7eb;
    }

    .section-title {
        font-size: 20px;
        font-weight: 600;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .count-badge {
        background: #3b82f6;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .empty-state {
        text-align: center;
        padding: 48px 0;
        color: #6b7280;
    }

    .empty-state .icon {
        font-size: 48px;
        margin-bottom: 16px;
    }

    .list-item {
        padding: 12px 16px;
        background: #f8fafc;
        border-radius: 6px;
        margin-bottom: 8px;
        border-left: 4px solid #e5e7eb;
        transition: all 0.2s;
    }

    .list-item:hover {
        border-left-color: #3b82f6;
        background: #f1f5f9;
    }

    .list-item-name {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .list-item-meta {
        font-size: 12px;
        color: #6b7280;
    }

    .tabs {
        display: flex;
        border-bottom: 2px solid #e5e7eb;
        margin-bottom: 24px;
    }

    .tab {
        padding: 12px 24px;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        font-weight: 500;
        color: #6b7280;
        transition: all 0.2s;
    }

    .tab.active {
        color: #3b82f6;
        border-bottom-color: #3b82f6;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }
</style>

<div>
    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                <a href="{{ route('account.teachers') }}" class="btn btn-secondary">
                    ← Back to Teachers
                </a>
            </div>
            <h1 style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 4px;">Teacher Details</h1>
            <p style="color: #6b7280;">View comprehensive information about {{ $teacher->user->name }}</p>
        </div>

    </div>

    <!-- Teacher Basic Information -->
    <div class="card">
        <div class="section-header">
            <h2 class="section-title">
                👨‍🏫 Basic Information
            </h2>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Teacher Name</div>
                <div class="info-value">{{ $teacher->user->name }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Username</div>
                <div class="info-value">{{ $teacher->user->username ?? 'Not set' }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Email Address</div>
                <div class="info-value">{{ $teacher->user->email ?? 'Not set' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Phone Number</div>
                <div class="info-value">{{ $teacher->user->phone ?? 'Not set' }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Created At</div>
                <div class="info-value">{{ $teacher->created_at->format('M d, Y') }}</div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div style="display: flex; gap: 16px; flex-wrap: wrap; margin-top: 16px;">
            <div style="background: #dbeafe; padding: 12px 16px; border-radius: 8px; text-align: center; min-width: 120px;">
                <div style="font-size: 24px; font-weight: bold; color: #1d4ed8;">{{ $teacher->stages->count() }}</div>
                <div style="font-size: 12px; color: #1d4ed8;">Stages</div>
            </div>
            <div style="background: #ede9fe; padding: 12px 16px; border-radius: 8px; text-align: center; min-width: 120px;">
                <div style="font-size: 24px; font-weight: bold; color: #7c3aed;">{{ $teacher->links->unique('class_id')->count() }}</div>
                <div style="font-size: 12px; color: #7c3aed;">Classes</div>
            </div>
            <div style="background: #fef3c7; padding: 12px 16px; border-radius: 8px; text-align: center; min-width: 120px;">
                <div style="font-size: 24px; font-weight: bold; color: #d97706;">{{ $teacher->links->unique('subject_id')->count() }}</div>
                <div style="font-size: 12px; color: #d97706;">Subjects</div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="tabs">
        <div class="tab active" onclick="switchTab('stages')">
            📚 Stages ({{ $teacher->stages->count() }})
        </div>
        <div class="tab" onclick="switchTab('subjects')">
            📖 Subjects ({{ $teacher->links->unique('subject_id')->count() }})
        </div>
        <div class="tab" onclick="switchTab('classes')">
            🏫 Classes ({{ $teacher->links->unique('class_id')->count() }})
        </div>
    </div>

    <!-- Stages Tab -->
    <div id="stages-content" class="tab-content active">
        <div class="card">
            <div class="section-header">
                <h2 class="section-title">
                    📚 Assigned Stages
                    <span class="count-badge">{{ $teacher->stages->count() }}</span>
                </h2>
            </div>

            @if($teacher->stages->count() > 0)
            <div style="display: grid; gap: 12px;">
                @foreach($teacher->stages as $stage)
                <div class="list-item">
                    <div class="list-item-name">{{ $stage->name }}</div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state">
                <div class="icon">📚</div>
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">No Stages Assigned</h3>
                <p>This teacher is not assigned to any stages yet.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Subjects Tab -->
    <div id="subjects-content" class="tab-content">
        <div class="card">
            <div class="section-header">
                <h2 class="section-title">
                    📖 Teaching Subjects
                    <span class="count-badge">{{ $teacher->links->unique('subject_id')->count() }}</span>
                </h2>
            </div>

            @if($teacher->links->unique('subject_id')->count() > 0)
            <div style="display: grid; gap: 12px;">
                @foreach($teacher->links->unique('subject_id') as $link)
                <div class="list-item">
                    <div class="list-item-name">{{ $link->subject->name }}</div>
                    <div class="list-item-meta">
                        Stage: {{ $link->subject->stage->name }}
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state">
                <div class="icon">📖</div>
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">No Subjects Assigned</h3>
                <p>This teacher is not assigned to teach any subjects yet.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Classes Tab -->
    <div id="classes-content" class="tab-content">
        <div class="card">
            <div class="section-header">
                <h2 class="section-title">
                    🏫 Teaching Classes
                    <span class="count-badge">{{ $teacher->links->unique('class_id')->count() }}</span>
                </h2>
            </div>

            @if($teacher->links->unique('class_id')->count() > 0)
            <div style="display: grid; gap: 12px;">
                @foreach($teacher->links->unique('class_id') as $link)
                <div class="list-item">
                    <div class="list-item-name">{{ $link->class->name }}</div>
                    <div class="list-item-meta">
                        Stage: {{ $link->class->stage->name }}
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state">
                <div class="icon">🏫</div>
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">No Classes Assigned</h3>
                <p>This teacher is not assigned to any classes yet.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    function switchTab(tabName) {
        // Hide all tab contents
        const tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(content => {
            content.classList.remove('active');
        });

        // Remove active class from all tabs
        const tabs = document.querySelectorAll('.tab');
        tabs.forEach(tab => {
            tab.classList.remove('active');
        });

        // Show selected tab content
        document.getElementById(tabName + '-content').classList.add('active');

        // Add active class to clicked tab
        event.target.classList.add('active');
    }
</script>
@endsection
