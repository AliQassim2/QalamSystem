@extends('manager.header')

@section('content')
<div class="reports-container">
    <!-- Header Section -->
    <div class="reports-header">
        <div class="header-content">
            <h1 class="reports-title">School Reports Dashboard</h1>
            <p class="reports-subtitle">Comprehensive analytics and insights for data-driven decisions</p>
        </div>
        <div class="header-actions">
            <button class="export-btn">
                <i class="fas fa-download"></i>
                Export All Reports
            </button>
            <div class="date-filter">
                <select class="form-select">
                    <option>Academic Year 2024-2025</option>
                    <option>Academic Year 2023-2024</option>
                    <option>Academic Year 2022-2023</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Reports Grid -->
    <div class="reports-grid">
        <!-- Success Rate by Year -->
        <div class="report-card large-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line text-success"></i>
                    Success Rate by Year
                </h3>
                <button class="card-action">
                    <i class="fas fa-expand-alt"></i>
                </button>
            </div>
            <div class="card-content">
                <div class="chart-container">
                    <canvas id="successRateChart"></canvas>
                </div>
                <div class="chart-summary">
                    <div class="summary-item">
                        <span class="summary-value text-success">94.2%</span>
                        <span class="summary-label">2024 Success Rate</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-value text-info">+3.1%</span>
                        <span class="summary-label">vs Last Year</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Missing Grades -->
        <div class="report-card medium-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Students Missing Grades
                </h3>
                <span class="alert-badge">{{ $studentsMissingGradesCount }}</span>
            </div>
            <div class="card-content">
                <div class="missing-grades-list">
                    @foreach ($studentsMissingGrades as $student)
                    <div class="student-item urgent">
                        <div class="student-info">
                            <span class="student-name">{{ $student->name }}</span>
                            <span class="student-class">{{ $student->stageName }}-{{ $student->className }}</span>
                        </div>
                        <div class="missing-subjects">
                            @foreach ($student->missingSubjects as $subject)
                            <span class="subject-tag">{{ $subject->subjectName }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endforeach


                </div>
                <button class="view-all-btn">View All Missing Grades</button>
            </div>
        </div>

        <!-- Duplicate Student Names -->
        <div class="report-card medium-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-copy text-danger"></i>
                    Duplicate Student Names
                </h3>
                <span class="alert-badge danger">{{ count($dublicateNames) }}</span>
            </div>
            <div class="card-content">
                <div class="duplicate-list">
                    <div class="duplicate-group">

                        @foreach ($dublicateNames as $name)
                        <div class="duplicate-name">{{ $name->name }}</div>
                        <div class="duplicate-students">
                            @foreach ($name->info as $student)

                            <div class="duplicate-item">
                                <span>{{ $student->stageName }}-{{ $student->className }}</span>
                                <span class="student-id">#{{ $student->username }}</span>
                            </div>
                            @endforeach

                        </div>
                        @endforeach
                    </div>
                </div>
                <button class="view-all-btn">Resolve Duplicates</button>
            </div>
        </div>

        <!-- Failed Students per Subject -->
        <div class="report-card large-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar text-danger"></i>
                    Failed Students per Subject
                </h3>
                <div class="filter-tabs">
                    <button class="tab-btn active">Current Term</button>
                    <button class="tab-btn">Previous Term</button>
                </div>
            </div>
            <div class="card-content">
                <div class="subjects-grid">
                    <div class="subject-card high-risk">
                        <div class="subject-header">
                            <span class="subject-name">Mathematics</span>
                            <span class="failure-count">23 Students</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 18.4%"></div>
                        </div>
                        <div class="subject-details">
                            <span class="failure-rate">18.4% Failure Rate</span>
                            <button class="details-btn">View Details</button>
                        </div>
                    </div>
                    <div class="subject-card medium-risk">
                        <div class="subject-header">
                            <span class="subject-name">Physics</span>
                            <span class="failure-count">15 Students</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 12.3%"></div>
                        </div>
                        <div class="subject-details">
                            <span class="failure-rate">12.3% Failure Rate</span>
                            <button class="details-btn">View Details</button>
                        </div>
                    </div>
                    <div class="subject-card low-risk">
                        <div class="subject-header">
                            <span class="subject-name">English</span>
                            <span class="failure-count">8 Students</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 6.4%"></div>
                        </div>
                        <div class="subject-details">
                            <span class="failure-rate">6.4% Failure Rate</span>
                            <button class="details-btn">View Details</button>
                        </div>
                    </div>
                    <div class="subject-card low-risk">
                        <div class="subject-header">
                            <span class="subject-name">Chemistry</span>
                            <span class="failure-count">11 Students</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 9.1%"></div>
                        </div>
                        <div class="subject-details">
                            <span class="failure-rate">9.1% Failure Rate</span>
                            <button class="details-btn">View Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teachers Teaching Multiple Subjects -->
        <div class="report-card medium-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-graduate text-info"></i>
                    Multi-Subject Teachers
                </h3>
                <span class="info-badge">{{ count($multiSubjectTeachers) }}</span>
            </div>
            <div class="card-content">
                <div class="teachers-list">
                    @foreach ($multiSubjectTeachers as $teacher)
                    <div class="teacher-item">
                        <div class="teacher-avatar">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&background=667eea&color=fff" alt="Teacher">
                        </div>
                        <div class="teacher-info">
                            <span class="teacher-name">{{ $teacher->name }}</span>

                            <div class="teacher-subjects">
                                @foreach ($teacher->subjects as $subject)
                                <span class="subject-pill">{{ $subject->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="workload-indicator high">
                            <span>18h/week</span>
                        </div>
                    </div>
                    @endforeach

                </div>
                <button class="view-all-btn">View All Teachers</button>
            </div>
        </div>

        <!-- Year Comparison -->
        <div class="report-card large-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-balance-scale text-purple"></i>
                    Success Rate Comparison
                </h3>
                <div class="comparison-controls">
                    <select class="form-select small">
                        <option>Compare by Grade</option>
                        <option>Compare by Subject</option>
                        <option>Compare by Class</option>
                    </select>
                </div>
            </div>
            <div class="card-content">
                <div class="comparison-chart">
                    <canvas id="comparisonChart"></canvas>
                </div>
                <div class="comparison-insights">
                    <div class="insight-card positive">
                        <i class="fas fa-arrow-up"></i>
                        <div class="insight-text">
                            <span class="insight-title">Overall Improvement</span>
                            <span class="insight-desc">Success rates increased by 4.2% across all grades</span>
                        </div>
                    </div>
                    <div class="insight-card negative">
                        <i class="fas fa-arrow-down"></i>
                        <div class="insight-text">
                            <span class="insight-title">Grade 10 Decline</span>
                            <span class="insight-desc">Mathematics success rate dropped by 2.1%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Reports Container */
    .reports-container {
        padding: 30px;
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #4facfe 100%);
        background-size: 400% 400%;
        animation: reportsBG 25s ease infinite;
    }

    @keyframes reportsBG {

        0%,
        100% {
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
    }

    /* Header Section */
    .reports-header {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(25px);
        border-radius: 30px;
        padding: 40px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .reports-title {
        font-size: 3rem;
        font-weight: 900;
        margin: 0;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .reports-subtitle {
        font-size: 1.2rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.9);
        margin: 8px 0 0 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .header-actions {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .export-btn {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(67, 233, 123, 0.3);
    }

    .export-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(67, 233, 123, 0.4);
    }

    .date-filter .form-select {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 25px;
        padding: 10px 20px;
        color: white;
        font-weight: 600;
    }

    /* Reports Grid */
    .reports-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 25px;
    }

    .large-card {
        grid-column: span 8;
    }

    .medium-card {
        grid-column: span 4;
    }

    /* Report Cards */
    .report-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 25px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        padding: 25px 30px 20px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin: 0;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-action,
    .details-btn {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        border: none;
        padding: 8px 12px;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .card-action:hover,
    .details-btn:hover {
        background: rgba(102, 126, 234, 0.2);
        transform: scale(1.1);
    }

    .alert-badge {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 700;
    }

    .alert-badge.danger {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    }

    .info-badge {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 700;
    }

    .card-content {
        padding: 25px 30px 30px;
    }

    /* Chart Container */
    .chart-container {
        height: 300px;
        margin-bottom: 20px;
        background: rgba(0, 0, 0, 0.02);
        border-radius: 15px;
        padding: 20px;
    }

    .chart-summary {
        display: flex;
        justify-content: center;
        gap: 40px;
    }

    .summary-item {
        text-align: center;
    }

    .summary-value {
        display: block;
        font-size: 2rem;
        font-weight: 900;
        margin-bottom: 5px;
    }

    .summary-label {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 600;
    }

    /* Missing Grades */
    .missing-grades-list {
        max-height: 300px;
        overflow-y: auto;
        margin-bottom: 20px;
    }

    .student-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background: rgba(0, 0, 0, 0.02);
        border-radius: 12px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }

    .student-item:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: translateX(5px);
    }

    .student-item.urgent {
        border-left: 4px solid #f5576c;
        background: rgba(245, 87, 108, 0.05);
    }

    .student-name {
        font-weight: 700;
        color: #2c3e50;
        display: block;
    }

    .student-class {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .missing-subjects {
        display: flex;
        gap: 5px;
    }

    .subject-tag {
        background: rgba(245, 87, 108, 0.1);
        color: #f5576c;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* Duplicate Names */
    .duplicate-list {
        max-height: 300px;
        overflow-y: auto;
        margin-bottom: 20px;
    }

    .duplicate-group {
        margin-bottom: 20px;
        padding: 15px;
        background: rgba(255, 107, 107, 0.05);
        border-radius: 12px;
        border-left: 4px solid #ff6b6b;
    }

    .duplicate-name {
        font-weight: 700;
        font-size: 1.1rem;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .duplicate-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .duplicate-item:last-child {
        border-bottom: none;
    }

    .student-id {
        color: #6c757d;
        font-weight: 600;
    }

    /* Subject Cards */
    .subjects-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .subject-card {
        padding: 20px;
        border-radius: 15px;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .subject-card.high-risk {
        background: rgba(255, 107, 107, 0.05);
        border-color: rgba(255, 107, 107, 0.2);
    }

    .subject-card.medium-risk {
        background: rgba(255, 193, 7, 0.05);
        border-color: rgba(255, 193, 7, 0.2);
    }

    .subject-card.low-risk {
        background: rgba(40, 167, 69, 0.05);
        border-color: rgba(40, 167, 69, 0.2);
    }

    .subject-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .subject-name {
        font-weight: 700;
        color: #2c3e50;
    }

    .failure-count {
        font-weight: 600;
        color: #f5576c;
    }

    .progress-bar {
        height: 8px;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 15px;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(135deg, #f5576c 0%, #ff6b6b 100%);
        border-radius: 10px;
        transition: width 0.3s ease;
    }

    .subject-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .failure-rate {
        font-weight: 600;
        color: #6c757d;
    }

    /* Teachers List */
    .teachers-list {
        max-height: 300px;
        overflow-y: auto;
        margin-bottom: 20px;
    }

    .teacher-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: rgba(0, 0, 0, 0.02);
        border-radius: 12px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }

    .teacher-item:hover {
        background: rgba(79, 172, 254, 0.05);
        transform: translateX(5px);
    }

    .teacher-avatar img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .teacher-info {
        flex: 1;
    }

    .teacher-name {
        font-weight: 700;
        color: #2c3e50;
        display: block;
        margin-bottom: 5px;
    }

    .teacher-subjects {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .subject-pill {
        background: rgba(79, 172, 254, 0.1);
        color: #4facfe;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .workload-indicator {
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .workload-indicator.high {
        background: rgba(245, 87, 108, 0.1);
        color: #f5576c;
    }

    .workload-indicator.normal {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        gap: 10px;
    }

    .tab-btn {
        background: rgba(0, 0, 0, 0.05);
        border: none;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .tab-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    /* Comparison Insights */
    .comparison-insights {
        display: flex;
        gap: 20px;
        margin-top: 20px;
    }

    .insight-card {
        flex: 1;
        padding: 20px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .insight-card.positive {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .insight-card.negative {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .insight-card i {
        font-size: 2rem;
    }

    .insight-title {
        font-weight: 700;
        display: block;
        margin-bottom: 5px;
    }

    .insight-desc {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    /* View All Buttons */
    .view-all-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }

    .view-all-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .large-card {
            grid-column: span 12;
        }

        .medium-card {
            grid-column: span 6;
        }
    }

    @media (max-width: 768px) {
        .reports-container {
            padding: 20px;
        }

        .reports-header {
            flex-direction: column;
            gap: 20px;
            text-align: center;
            padding: 30px;
        }

        .reports-title {
            font-size: 2.2rem;
        }

        .medium-card {
            grid-column: span 12;
        }

        .subjects-grid {
            grid-template-columns: 1fr;
        }

        .comparison-insights {
            flex-direction: column;
        }

        .header-actions {
            flex-direction: column;
            width: 100%;
        }

        .export-btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Utility Classes */
    .text-success {
        color: #28a745 !important;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .text-warning {
        color: #ffc107 !important;
    }

    .text-info {
        color: #17a2b8 !important;
    }

    .text-purple {
        color: #6f42c1 !important;
    }
</style>

<script>
    // Initialize charts when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Success Rate Chart
        const successCtx = document.getElementById('successRateChart');
        if (successCtx) {
            new Chart(successCtx, {
                type: 'line',
                data: {
                    labels: ['2020', '2021', '2022', '2023', '2024'],
                    datasets: [{
                        label: 'Success Rate %',
                        data: [87.2, 89.1, 91.3, 91.1, 94.2],
                        borderColor: 'rgba(102, 126, 234, 1)',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 80,
                            max: 100
                        }
                    }
                }
            });
        }

        // Comparison Chart
        const comparisonCtx = document.getElementById('comparisonChart');
        if (comparisonCtx) {
            new Chart(comparisonCtx, {
                type: 'bar',
                data: {
                    labels: ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'],
                    datasets: [{
                        label: '2023',
                        data: [92, 88, 90, 85, 87, 91],
                        backgroundColor: 'rgba(245, 87, 108, 0.7)',
                        borderColor: 'rgba(245, 87, 108, 1)',
                        borderWidth: 2
                    }, {
                        label: '2024',
                        data: [94, 91, 93, 83, 89, 96],
                        backgroundColor: 'rgba(102, 126, 234, 0.7)',
                        borderColor: 'rgba(102, 126, 234, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 70,
                            max: 100
                        }
                    }
                }
            });
        }

        // Add interactive functionality
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Add hover effects to cards
        document.querySelectorAll('.subject-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // Simulate data refresh
        setInterval(function() {
            const badges = document.querySelectorAll('.alert-badge, .info-badge');
            badges.forEach(badge => {
                badge.style.animation = 'pulse 0.5s';
                setTimeout(() => {
                    badge.style.animation = '';
                }, 500);
            });
        }, 30000); // Every 30 seconds
    });

    // Add pulse animation
    const style = document.createElement('style');
    style.textContent = `
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
`;
    document.head.appendChild(style);
</script>
@endsection