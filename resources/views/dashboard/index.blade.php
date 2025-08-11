@extends('dashboard.header')

@section('content')
<div class="dashboard-container">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="header-content">
            <div class="title-section">
                <h1 class="dashboard-title">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard Overview
                </h1>
                <p class="dashboard-subtitle">Welcome back! Here's what's happening with your platform.</p>
            </div>

            <!-- Controls Section -->
            <div class="controls-section">
                <form method="GET" action="{{ route('dashboard.home') }}" class="year-selector">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-calendar3"></i>
                        </span>
                        <select name="year" id="year" class="form-select" onchange="this.form.submit()">
                            @for ($y = now()->year; $y >= now()->year - 10; $y--)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </form>

                <!-- Refresh Button -->
                <button type="button" class="btn btn-outline-primary refresh-btn" onclick="location.reload()">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="stats-grid">
        <!-- Total Users Card -->
        <div class="stat-card users-card">
            <div class="card-background">
                <div class="floating-shapes">
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                </div>
            </div>
            <div class="card-content">
                <div class="icon-container">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-label">Total Users</h3>
                    <div class="stat-value-container">
                        <span class="stat-value" data-count="{{ $TotalUsers }}">0</span>
                        <div class="growth-indicator positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+0%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Students Card -->
        <div class="stat-card students-card">
            <div class="card-background">
                <div class="floating-shapes">
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                </div>
            </div>
            <div class="card-content">
                <div class="icon-container">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-label">Total Students</h3>
                    <div class="stat-value-container">
                        <span class="stat-value" data-count="{{ $TotalStudents }}">0</span>
                        <div class="growth-indicator positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+0%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Schools Card -->
        <div class="stat-card schools-card">
            <div class="card-background">
                <div class="floating-shapes">
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                </div>
            </div>
            <div class="card-content">
                <div class="icon-container">
                    <i class="bi bi-building"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-label">Total Schools</h3>
                    <div class="stat-value-container">
                        <span class="stat-value" data-count="{{ $TotalSchools }}">0</span>
                        <div class="growth-indicator positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+0%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Teachers Card -->
        <div class="stat-card teachers-card">
            <div class="card-background">
                <div class="floating-shapes">
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                </div>
            </div>
            <div class="card-content">
                <div class="icon-container">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <div class="stat-info">
                    <h3 class="stat-label">Total Teachers</h3>
                    <div class="stat-value-container">
                        <span class="stat-value" data-count="{{ $TotalTeachers }}">0</span>
                        <div class="growth-indicator positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>+0%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="quick-actions-section">
        <h2 class="section-title">
            <i class="bi bi-lightning-fill"></i>
            Quick Actions
        </h2>
        <div class="actions-grid">
            <a href="{{ route('dashboard.users.create') }}" class="action-card">
                <i class="bi bi-person-plus-fill"></i>
                <span>Add User</span>
            </a>
            <a href="{{ route('dashboard.schools.create') }}" class="action-card">
                <i class="bi bi-building-add"></i>
                <span>New School</span>
            </a>
        </div>
    </div>
</div>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --users-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --students-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --schools-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --teachers-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
        --border-radius: 20px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dashboard-container {
        padding: 2rem;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    /* Header Styles */
    .dashboard-header {
        margin-bottom: 2rem;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        background: white;
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .title-section {
        flex: 1;
    }

    .dashboard-title {
        font-size: 2.5rem;
        font-weight: 700;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .dashboard-subtitle {
        color: #64748b;
        font-size: 1.1rem;
        margin: 0;
    }

    .controls-section {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .year-selector .input-group {
        width: 200px;
    }

    .year-selector .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-weight: 500;
    }

    .year-selector .input-group-text {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 12px 0 0 12px;
    }

    .refresh-btn {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem;
        transition: var(--transition);
    }

    .refresh-btn:hover {
        transform: rotate(180deg);
        border-color: #667eea;
        color: #667eea;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        position: relative;
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow);
        transition: var(--transition);
        overflow: hidden;
        cursor: pointer;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
    }

    .stat-card:hover::before {
        height: 100%;
        opacity: 0.1;
    }

    .users-card::before {
        background: var(--users-gradient);
    }

    .students-card::before {
        background: var(--students-gradient);
    }

    .schools-card::before {
        background: var(--schools-gradient);
    }

    .teachers-card::before {
        background: var(--teachers-gradient);
    }

    .card-background {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
    }

    .floating-shapes {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .shape {
        position: absolute;
        border-radius: 50%;
        opacity: 0.1;
    }

    .shape-1 {
        width: 60px;
        height: 60px;
        top: -20px;
        right: -20px;
        background: var(--primary-gradient);
    }

    .shape-2 {
        width: 40px;
        height: 40px;
        bottom: -10px;
        right: 20px;
        background: var(--primary-gradient);
    }

    .card-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .icon-container {
        flex-shrink: 0;
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        position: relative;
    }

    .users-card .icon-container {
        background: var(--users-gradient);
    }

    .students-card .icon-container {
        background: var(--students-gradient);
    }

    .schools-card .icon-container {
        background: var(--schools-gradient);
    }

    .teachers-card .icon-container {
        background: var(--teachers-gradient);
    }

    .stat-info {
        flex: 1;
    }

    .stat-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #64748b;
        margin: 0 0 0.5rem 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value-container {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1e293b;
        line-height: 1;
    }

    .growth-indicator {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
    }

    .growth-indicator.positive {
        background: #dcfce7;
        color: #166534;
    }

    .growth-indicator.negative {
        background: #fef2f2;
        color: #dc2626;
    }

    /* Quick Actions Section */
    .quick-actions-section {
        margin-top: 3rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 1.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: #f59e0b;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .action-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: white;
        border-radius: 16px;
        text-decoration: none;
        color: #1e293b;
        font-weight: 600;
        box-shadow: var(--shadow);
        transition: var(--transition);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .action-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-hover);
        color: #667eea;
        text-decoration: none;
    }

    .action-card i {
        font-size: 1.5rem;
        color: #667eea;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }

        .header-content {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
        }

        .controls-section {
            justify-content: center;
        }

        .dashboard-title {
            font-size: 2rem;
            justify-content: center;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .card-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .stat-value-container {
            justify-content: center;
        }
    }

    /* Loading Animation */
    .stat-card {
        animation: slideInUp 0.6s ease-out;
    }

    .stat-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .stat-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .stat-card:nth-child(3) {
        animation-delay: 0.3s;
    }

    .stat-card:nth-child(4) {
        animation-delay: 0.4s;
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

    /* Counter Animation */
    .stat-value {
        transition: color 0.3s ease;
    }
</style>

<script>
    // Counter Animation
    function animateCounters() {
        const counters = document.querySelectorAll('.stat-value');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-count'));
            const duration = 2000; // 2 seconds
            const increment = target / (duration / 16); // 60fps
            let current = 0;

            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                counter.textContent = Math.floor(current).toLocaleString();
            }, 16);
        });
    }

    // Run counter animation when page loads
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(animateCounters, 500); // Delay to let cards animate in first
    });

    // Add pulse effect on card hover
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            const icon = card.querySelector('.icon-container i');
            icon.style.transform = 'scale(1.1)';
            icon.style.transition = 'transform 0.3s ease';
        });

        card.addEventListener('mouseleave', () => {
            const icon = card.querySelector('.icon-container i');
            icon.style.transform = 'scale(1)';
        });
    });
</script>
@endsection
