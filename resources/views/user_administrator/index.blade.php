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

        .stat-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 24px;
            margin: 12px;
            display: inline-block;
            width: 300px;
            vertical-align: top;
            border-left: 4px solid;
        }

        .stat-green {
            border-left-color: #10b981;
        }

        .stat-blue {
            border-left-color: #3b82f6;
        }

        .stat-purple {
            border-left-color: #8b5cf6;
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            margin: 8px 0;
        }

        .green-text {
            color: #10b981;
        }

        .blue-text {
            color: #3b82f6;
        }

        .purple-text {
            color: #8b5cf6;
        }

        .header-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            color: white;
            border-radius: 8px;
            padding: 32px;
            margin-bottom: 24px;
        }

        .quick-action {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            margin: 8px;
            display: inline-block;
            width: 200px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .quick-action:hover {
            background: #f3f4f6;
        }

        .manage-link {
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            margin-top: 12px;
            display: block;
        }

        .manage-link:hover {
            text-decoration: underline;
        }
    </style>

    <div>
        <!-- Welcome Header -->
        <div class="header-gradient">
            <h1 style="font-size: 32px; font-weight: bold; margin-bottom: 8px;">Welcome to Account Management</h1>
            <p style="font-size: 18px; opacity: 0.9;">Manage your educational Accounts efficiently</p>
        </div>

        <!-- Statistics Cards -->
        <div style="text-align: center; margin-bottom: 32px;">
            <!-- Stages Card -->
            <div class="stat-card stat-green">
                <h3 style="font-size: 18px; font-weight: 600; color: #374151; margin-bottom: 12px;">Total Student</h3>
                <div class="stat-number green-text">{{ $studentCount ?? 0 }}</div>
                <a href="" class="manage-link green-text" style="color: #10b981;">
                    Manage Student →
                </a>
            </div>

            <!-- Classes Card -->
            <div class="stat-card stat-blue">
                <h3 style="font-size: 18px; font-weight: 600; color: #374151; margin-bottom: 12px;">Total Teacher</h3>
                <div class="stat-number blue-text">{{ $teacherCount ?? 0 }}</div>
                <a href="" class="manage-link blue-text" style="color: #3b82f6;">
                    Manage Teacher →
                </a>
            </div>



        </div>


    </div>
@endsection
