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

    .student-profile {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }

    .student-photo {
        flex-shrink: 0;
    }

    .photo-container {
        width: 200px;
        height: 200px;
        border-radius: 12px;
        overflow: hidden;
        border: 4px solid #e5e7eb;
        background: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .photo-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-placeholder {
        color: #9ca3af;
        font-size: 64px;
    }

    .student-info {
        flex: 1;
    }

    .student-name {
        font-size: 32px;
        font-weight: bold;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .student-username {
        font-size: 18px;
        color: #6b7280;
        margin-bottom: 24px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .info-item {
        background: #f9fafb;
        padding: 16px;
        border-radius: 8px;
        border-left: 4px solid #3b82f6;
    }

    .info-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        color: #6b7280;
        margin-bottom: 4px;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 16px;
        font-weight: 500;
        color: #1f2937;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        display: inline-block;
    }

    .badge-info {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .badge-success {
        background: #d1fae5;
        color: #065f46;
    }

    .back-button {
        margin-bottom: 24px;
    }

    .action-buttons {
        margin-top: 24px;
        display: flex;
        gap: 12px;
    }

    @media (max-width: 768px) {
        .student-profile {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .photo-container {
            width: 150px;
            height: 150px;
        }

        .student-name {
            font-size: 24px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            justify-content: center;
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
            <h1 style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 4px;">Student Details</h1>
            <p style="color: #6b7280;">Complete information about the student</p>
        </div>
    </div>

    <!-- Student Profile Card -->
    <div class="card">
        <div class="student-profile">
            <!-- Student Photo -->
            <div class="student-photo">
                <div class="photo-container">
                    @if($student->photo)
                    <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->name }}">
                    @else
                    <div class="photo-placeholder">
                        👨‍🎓
                    </div>
                    @endif
                </div>
            </div>

            <!-- Student Information -->
            <div class="student-info">
                <h2 class="student-name">{{ $student->user->name }}</h2>
                <p class="student-username">{{ $student->user->username ?? 'No username' }}</p>

                <div class="info-grid">
                    <!-- Email -->
                    <div class="info-item">
                        <div class="info-label">Email Address</div>
                        <div class="info-value">{{ $student->user->email ?? 'Not provided' }}</div>
                    </div>

                    <!-- Class -->
                    <div class="info-item">
                        <div class="info-label">Class</div>
                        <div class="info-value">
                            <span class="badge badge-info">{{ $student->classes->name ?? 'No class assigned' }}</span>

                        </div>
                    </div>

                    <!-- Stage -->
                    <div class="info-item">
                        <div class="info-label">Stage</div>
                        <div class="info-value">
                            <span class="badge badge-success">{{ $student->classes->stage->name ?? 'No stage assigned' }}</span>
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="info-item">
                        <div class="info-label">Phone Number</div>
                        <div class="info-value">{{ $student->user->phone ?? 'Not provided' }}</div>
                    </div>


                    <!-- Registration Date -->
                    <div class="info-item">
                        <div class="info-label">Registration Date</div>
                        <div class="info-value">{{ $student->created_at->format('M d, Y') }}</div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- Additional Information Card -->
    @if($student->bio || $student->address || $student->date_of_birth)
    <div class="card">
        <h3 style="font-size: 20px; font-weight: 600; color: #1f2937; margin-bottom: 16px;">Additional Information</h3>

        <div class="info-grid">
            @if($student->date_of_birth)
            <div class="info-item">
                <div class="info-label">Date of Birth</div>
                <div class="info-value">{{ $student->date_of_birth->format('M d, Y') }}</div>
            </div>
            @endif

            @if($student->address)
            <div class="info-item">
                <div class="info-label">Address</div>
                <div class="info-value">{{ $student->address }}</div>
            </div>
            @endif

            @if($student->parent_phone)
            <div class="info-item">
                <div class="info-label">Parent/Guardian Phone</div>
                <div class="info-value">{{ $student->parent_phone }}</div>
            </div>
            @endif
        </div>

        @if($student->bio)
        <div style="margin-top: 20px;">
            <div class="info-label">Biography</div>
            <div style="background: #f9fafb; padding: 16px; border-radius: 8px; margin-top: 8px;">
                {{ $student->bio }}
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Academic Information Card -->
    <div class="card">
        <h3 style="font-size: 20px; font-weight: 600; color: #1f2937; margin-bottom: 16px;">Academic Information</h3>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Total Marks</div>
                <div class="info-value">{{ $student->grades->count() ?? 0 }} records</div>
            </div>



            <div class="info-item">
                <div class="info-label">Account Status</div>
                <div class="info-value">
                    @if($student->deleted_at)
                    <span class="badge" style="background: #fee2e2; color: #991b1b;">Inactive</span>
                    @else
                    <span class="badge badge-success">Active</span>
                    @endif
                </div>
            </div>
            @if($student->updated_at)
            <div class="info-item">
                <div class="info-label">Last Updated</div>
                <div class="info-value">{{ $student->updated_at->format('M d, Y \a\t H:i') }}</div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
