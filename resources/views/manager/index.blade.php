@extends('manager.header')

@section('content')
<div class="dashboard-container">
    <!-- Enhanced Welcome Header -->
    <div class="welcome-header">
        <div class="welcome-content">
            <h1 class="dashboard-title">Dashboard Overview</h1>
            <p class="dashboard-subtitle">Manage your school efficiently with real-time insights</p>
        </div>
        <div class="date-display">
            <i class="fas fa-calendar-alt"></i>
            <span>{{ date('M d, Y') }}</span>
        </div>
    </div>

    <!-- Enhanced Statistics Cards -->
    <div class="stats-grid">
        <!-- Students Card -->
        <div class="stat-card students">
            <div class="card-inner">
                <div class="icon-section">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stats-section">
                    <h3 class="number">{{$student??0}}</h3>
                    <p class="label">Students</p>
                </div>
            </div>
            <div class="card-shine"></div>
        </div>

        <!-- Teachers Card -->
        <div class="stat-card teachers">
            <div class="card-inner">
                <div class="icon-section">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stats-section">
                    <h3 class="number">{{$teacher??0}}</h3>
                    <p class="label">Teachers</p>
                </div>
            </div>
            <div class="card-shine"></div>
        </div>

        <!-- Classes Card -->
        <div class="stat-card classes">
            <div class="card-inner">
                <div class="icon-section">
                    <i class="fas fa-door-open"></i>
                </div>
                <div class="stats-section">
                    <h3 class="number">{{$class??0}}</h3>
                    <p class="label">Classes</p>
                </div>
            </div>
            <div class="card-shine"></div>
        </div>

        <!-- Stages Card -->
        <div class="stat-card stages">
            <div class="card-inner">
                <div class="icon-section">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="stats-section">
                    <h3 class="number">{{$stage??0}}</h3>
                    <p class="label">Stages</p>
                </div>
            </div>
            <div class="card-shine"></div>
        </div>

        <!-- Subjects Card -->
        <div class="stat-card subjects">
            <div class="card-inner">
                <div class="icon-section">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stats-section">
                    <h3 class="number">{{$subject??0}}</h3>
                    <p class="label">Subjects</p>
                </div>
            </div>
            <div class="card-shine"></div>
        </div>
    </div>
</div>

<style>
    /* Dashboard Container */
    .dashboard-container {
        padding: 30px;
        min-height: 100vh;
        background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #f5576c, #4facfe, #00f2fe);
        background-size: 400% 400%;
        animation: gradientFlow 20s ease infinite;
    }

    @keyframes gradientFlow {
        0% {
            background-position: 0% 50%;
        }

        25% {
            background-position: 100% 50%;
        }

        50% {
            background-position: 100% 100%;
        }

        75% {
            background-position: 0% 100%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    /* Enhanced Welcome Header */
    .welcome-header {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(25px);
        border-radius: 30px;
        padding: 40px;
        margin-bottom: 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .dashboard-title {
        font-size: 3.5rem;
        font-weight: 900;
        margin: 0;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .dashboard-subtitle {
        font-size: 1.3rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.9);
        margin: 10px 0 0 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .date-display {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(15px);
        border-radius: 50px;
        padding: 15px 25px;
        color: white;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.4);
        font-size: 1.1rem;
    }

    /* Enhanced Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 30px;
    }

    /* Enhanced Stat Cards */
    .stat-card {
        position: relative;
        height: 180px;
        border-radius: 30px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        backdrop-filter: blur(20px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .stat-card:hover {
        transform: translateY(-20px) scale(1.08);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.25);
    }

    .card-inner {
        position: relative;
        z-index: 2;
        height: 100%;
        padding: 35px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 100%);
        backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 30px;
    }

    .icon-section {
        width: 80px;
        height: 80px;
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: white;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
        transition: all 0.4s ease;
    }

    .stat-card:hover .icon-section {
        transform: rotate(15deg) scale(1.15);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
    }

    .stats-section {
        text-align: right;
        margin-left: 20px;
    }

    .number {
        font-size: 3.5rem;
        font-weight: 900;
        margin: 0;
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
        transition: all 0.4s ease;
    }

    .stat-card:hover .number {
        transform: scale(1.15);
    }

    .label {
        font-size: 1.1rem;
        font-weight: 700;
        color: #5a6c7d;
        margin: 8px 0 0 0;
        text-transform: uppercase;
        letter-spacing: 2px;
        transition: all 0.4s ease;
    }

    .stat-card:hover .label {
        color: #34495e;
        transform: translateY(-3px);
    }

    .card-shine {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0;
        transition: opacity 0.5s ease;
        border-radius: 30px;
        z-index: 1;
    }

    .stat-card:hover .card-shine {
        opacity: 1;
    }

    /* Individual Card Themes */
    .stat-card.students .icon-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stat-card.students .card-shine {
        box-shadow: 0 30px 60px rgba(102, 126, 234, 0.5);
    }

    .stat-card.teachers .icon-section {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .stat-card.teachers .card-shine {
        box-shadow: 0 30px 60px rgba(245, 87, 108, 0.5);
    }

    .stat-card.classes .icon-section {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .stat-card.classes .card-shine {
        box-shadow: 0 30px 60px rgba(79, 172, 254, 0.5);
    }

    .stat-card.stages .icon-section {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .stat-card.stages .card-shine {
        box-shadow: 0 30px 60px rgba(67, 233, 123, 0.5);
    }

    .stat-card.subjects .icon-section {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .stat-card.subjects .card-shine {
        box-shadow: 0 30px 60px rgba(250, 112, 154, 0.5);
    }

    /* Mobile Responsive */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 20px;
        }

        .welcome-header {
            flex-direction: column;
            text-align: center;
            padding: 30px;
            gap: 20px;
        }

        .dashboard-title {
            font-size: 2.5rem;
        }

        .dashboard-subtitle {
            font-size: 1.1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .stat-card {
            height: 160px;
        }

        .card-inner {
            padding: 25px;
        }

        .icon-section {
            width: 70px;
            height: 70px;
            font-size: 28px;
        }

        .number {
            font-size: 2.8rem;
        }
    }

    @media (max-width: 480px) {
        .dashboard-title {
            font-size: 2rem;
        }

        .number {
            font-size: 2.2rem;
        }

        .icon-section {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }
    }
</style>
@endsection