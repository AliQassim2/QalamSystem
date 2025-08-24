<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>درجاتي - {{ $student->user->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            direction: rtl;
            margin: 0;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #2196F3, #21CBF3);
            color: #fff;
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 0;
            right: 0;
            height: 30px;
            background: inherit;
            border-radius: 0 0 50% 50%;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .header h1 {
            margin: 0 0 20px 0;
            font-size: 3em;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .student-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 25px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.15);
            padding: 15px 20px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-3px);
        }

        .info-card strong {
            display: block;
            font-size: 0.9em;
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .content {
            padding: 50px 30px 30px;
        }

        .subjects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .subject-card {
            background: #fff;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .subject-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4CAF50, #45a049);
        }

        .subject-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .subject-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f8f9fa;
        }

        .subject-name {
            font-size: 1.4em;
            font-weight: 700;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .subject-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4CAF50, #45a049);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2em;
        }

        .grades-summary {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .grade-item {
            background: #f8f9fa;
            padding: 12px 15px;
            border-radius: 12px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .grade-item:hover {
            background: #e9ecef;
            transform: scale(1.02);
        }

        .grade-label {
            font-size: 0.85em;
            color: #6c757d;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .grade-value {
            font-size: 1.1em;
            font-weight: 700;
        }

        .grade-completed {
            color: #28a745;
        }

        .grade-pending {
            color: #ffc107;
        }

        .grade-missing {
            color: #dc3545;
        }

        .final-grade {
            background: linear-gradient(135deg, #f8f9fa, #ffffff);
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }

        .final-score {
            font-size: 2.5em;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .letter-grade {
            font-size: 1.8em;
            font-weight: 700;
            padding: 8px 20px;
            border-radius: 25px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .grade-A {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .grade-B {
            background: linear-gradient(135deg, #17a2b8, #20c997);
            color: white;
        }

        .grade-C {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
        }

        .grade-D {
            background: linear-gradient(135deg, #fd7e14, #dc3545);
            color: white;
        }

        .grade-F {
            background: linear-gradient(135deg, #dc3545, #6f42c1);
            color: white;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 15px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #4CAF50, #45a049);
            transition: width 0.5s ease;
        }

        .stats-section {
            margin-top: 40px;
            background: linear-gradient(135deg, #f8f9fa, #ffffff);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid #e9ecef;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin-top: 25px;
        }

        .stat-card {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            border: 1px solid #e9ecef;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5em;
            font-weight: 700;
            display: block;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9em;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background: #fff;
            margin: 5% auto;
            padding: 0;
            border-radius: 20px;
            width: 95%;
            max-width: 900px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, #2196F3, #21CBF3);
            color: white;
            padding: 25px 30px;
            text-align: center;
            position: relative;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.8em;
            font-weight: 700;
        }

        .close {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.8);
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 5px;
            border-radius: 50%;
        }

        .close:hover {
            color: white;
            background: rgba(255, 255, 255, 0.2);
        }

        .modal-body {
            padding: 30px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .detailed-grades {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .detailed-grade-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .detailed-grade-card:hover {
            background: #e9ecef;
            transform: scale(1.02);
        }

        .exam-type {
            font-size: 0.9em;
            color: #6c757d;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .exam-score {
            font-size: 2em;
            font-weight: 700;
            margin-bottom: 5px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 15px;
            }

            .header {
                padding: 20px 15px;
            }

            .header h1 {
                font-size: 2.2em;
            }

            .content {
                padding: 30px 15px;
            }

            .subjects-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .grades-summary {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }

            .modal-content {
                width: 98%;
                margin: 2% auto;
            }

            .detailed-grades {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">

            <h1>📊 درجاتي الأكاديمية</h1>
            <div class="student-info">
                <div class="info-card">
                    <strong>الطالب:</strong>
                    {{ $student->user->name }}
                </div>
                <div class="info-card">
                    <strong>الصف:</strong>
                    {{ $student->classes->name }}
                </div>
                <div class="info-card">
                    <strong>المرحلة:</strong>
                    {{ $student->classes->stage->name }}
                </div>

            </div>
        </div>

        <div class="content">
            <h2 style="text-align: center; color: #2c3e50; font-size: 2em; margin-bottom: 10px;">
                📚 المواد الدراسية ودرجاتها
            </h2>
            <p style="text-align: center; color: #6c757d; margin-bottom: 30px;">
                انقر على أي مادة لعرض تفاصيل الدرجات والامتحانات
            </p>

            <div class="subjects-grid">
                @foreach ($subjects as $subject)
                    @php
                        $subjectGrades = $grades->where('subject_id', $subject->id);
                        $completedGrades = $subjectGrades->whereNotNull('score');
                        $totalScore = $completedGrades->sum('score');
                        $completedCount = $completedGrades->count();
                        $finalGrade = $completedCount > 0 ? round($totalScore / $completedCount, 1) : 0;

                        // Calculate letter grade
                        $letterGrade = 'غير مكتمل';
                        $gradeClass = 'grade-F';

                        if ($completedCount == 6) {
                            // All exams completed
                            if ($finalGrade >= 90) {
                                $letterGrade = 'A';
                                $gradeClass = 'grade-A';
                            } elseif ($finalGrade >= 80) {
                                $letterGrade = 'B';
                                $gradeClass = 'grade-B';
                            } elseif ($finalGrade >= 70) {
                                $letterGrade = 'C';
                                $gradeClass = 'grade-C';
                            } elseif ($finalGrade >= 60) {
                                $letterGrade = 'D';
                                $gradeClass = 'grade-D';
                            } else {
                                $letterGrade = 'F';
                                $gradeClass = 'grade-F';
                            }
                        }

                        $progressPercentage = ($completedCount / 6) * 100;
                    @endphp

                    <div class="subject-card" onclick="openSubjectModal('{{ $subject->name }}', {{ $subject->id }})">
                        <div class="subject-header">
                            <div class="subject-name">
                                <div class="subject-icon">📖</div>
                                {{ $subject->name }}
                            </div>
                        </div>

                        <div class="grades-summary">
                            <div class="grade-item">
                                <div class="grade-label">الامتحانات المكتملة</div>
                                <div
                                    class="grade-value {{ $completedCount > 0 ? 'grade-completed' : 'grade-missing' }}">
                                    {{ $completedCount }}/6
                                </div>
                            </div>
                            <div class="grade-item">
                                <div class="grade-label">المعدل الحالي</div>
                                <div
                                    class="grade-value {{ $finalGrade >= 70 ? 'grade-completed' : ($finalGrade >= 60 ? 'grade-pending' : 'grade-missing') }}">
                                    {{ $finalGrade }}/100
                                </div>
                            </div>
                        </div>

                        @if ($completedCount == 6)
                            <div class="final-grade">
                                <div
                                    class="final-score {{ $finalGrade >= 70 ? 'grade-completed' : ($finalGrade >= 60 ? 'grade-pending' : 'grade-missing') }}">
                                    {{ $finalGrade }}/100
                                </div>
                                <div class="letter-grade {{ $gradeClass }}">
                                    {{ $letterGrade }}
                                </div>
                                <div style="color: #6c757d; font-size: 0.9em;">الدرجة النهائية</div>
                            </div>
                        @else
                            <div class="final-grade">
                                <div style="color: #ffc107; font-size: 1.2em; font-weight: 600;">
                                    ⏳ في انتظار {{ 6 - $completedCount }} امتحان
                                </div>
                            </div>
                        @endif

                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Overall Statistics -->
            <div class="stats-section">
                <h3 style="text-align: center; color: #2c3e50; font-size: 1.8em; margin: 0 0 20px 0;">
                    📈 الإحصائيات العامة
                </h3>
                <div class="stats-grid">
                    <div class="stat-card">
                        <span class="stat-number" style="color: #2196F3;">{{ $subjects->count() }}</span>
                        <span class="stat-label">إجمالي المواد</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number"
                            style="color: #4CAF50;">{{ $grades->whereNotNull('score')->count() }}</span>
                        <span class="stat-label">الامتحانات المكتملة</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number"
                            style="color: #FF9800;">{{ $subjects->count() * 6 - $grades->whereNotNull('score')->count() }}</span>
                        <span class="stat-label">الامتحانات المتبقية</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number" style="color: #9C27B0;">
                            {{ $grades->whereNotNull('score')->count() > 0 ? round($grades->whereNotNull('score')->avg('score'), 1) : 0 }}%
                        </span>
                        <span class="stat-label">المعدل العام</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subject Details Modal -->
    <div id="subjectModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeSubjectModal()">&times;</span>
                <h2 id="modalTitle">تفاصيل المادة</h2>
            </div>
            <div class="modal-body">
                <div id="modalContent" class="detailed-grades">
                    <!-- Dynamic content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Subject grades data (this would come from your backend)
        const subjectGrades = {
            @foreach ($subjects as $subject)
                {{ $subject->id }}: [
                    @foreach ($grades->where('subject_id', $subject->id) as $grade)
                        {
                            type: {{ $grade->type }},
                            score: {{ $grade->score ?? 'null' }},
                            notes: "{{ $grade->notes ?? '' }}",
                            date: "{{ $grade->updated_at ? $grade->updated_at->format('Y-m-d') : '' }}"
                        },
                    @endforeach
                ],
            @endforeach
        };

        const gradeTypes = {
            0: 'الشهري الأول - الفصل الأول',
            1: 'الشهري الثاني - الفصل الأول',
            2: 'نصف السنة',
            3: 'الشهري الأول - الفصل الثاني',
            4: 'الشهري الثاني - الفصل الثاني',
            5: 'الامتحان النهائي'
        };

        function openSubjectModal(subjectName, subjectId) {
            document.getElementById('modalTitle').textContent = `📊 ${subjectName} - تفاصيل الدرجات`;

            const grades = subjectGrades[subjectId] || [];
            const modalContent = document.getElementById('modalContent');

            let content = '';

            // Create all 6 grade types
            for (let i = 0; i < 6; i++) {
                const grade = grades.find(g => g.type === i);
                const hasScore = grade && grade.score !== null;

                content += `
                    <div class="detailed-grade-card">
                        <div class="exam-type">${gradeTypes[i]}</div>
                        <div class="exam-score ${hasScore ? (grade.score >= 70 ? 'grade-completed' : (grade.score >= 60 ? 'grade-pending' : 'grade-missing')) : 'grade-missing'}">
                            ${hasScore ? `${grade.score}/100` : 'لم يتم بعد'}
                        </div>
                        ${hasScore && grade.date ? `<div style="font-size: 0.8em; color: #6c757d; margin-top: 5px;">${grade.date}</div>` : ''}
                        ${hasScore && grade.notes ? `<div style="font-size: 0.8em; color: #495057; margin-top: 5px; font-style: italic;">${grade.notes}</div>` : ''}
                    </div>
                `;
            }

            modalContent.innerHTML = content;
            document.getElementById('subjectModal').style.display = 'block';
        }

        function closeSubjectModal() {
            document.getElementById('subjectModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('subjectModal');
            if (event.target === modal) {
                closeSubjectModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeSubjectModal();
            }
        });

        // Add smooth loading animation
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.subject-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>

</html>
