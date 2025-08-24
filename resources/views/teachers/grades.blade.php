<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الدرجات - {{ $student->user->name }}</title>
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
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            border-radius: 20px;
            padding-bottom: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #2196F3, #21CBF3);
            color: #fff;
            padding: 25px;
            text-align: center;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header::before {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            height: 20px;
            background: inherit;
            border-radius: 0 0 50% 50%;
        }

        .back-btn {
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            white-space: nowrap;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .header h1 {
            margin: 0;
            font-size: 2.2em;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            flex: 1;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            flex-direction: column;
            gap: 10px;
        }

        .student-info {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin: 0;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 15px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
            text-align: center;
            white-space: nowrap;
        }

        .info-card:hover {
            transform: translateY(-3px);
        }

        .info-card strong {
            display: inline;
            font-size: 0.85em;
            opacity: 0.8;
            margin-left: 5px;
        }

        .content {
            padding: 40px 30px 30px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2196F3, #1976D2);
            color: #fff;
        }

        .btn-success {
            background: linear-gradient(135deg, #4CAF50, #388E3C);
            color: #fff;
        }

        .btn-warning {
            background: linear-gradient(135deg, #FF9800, #F57C00);
            color: #fff;
        }

        .btn-danger {
            background: linear-gradient(135deg, #f44336, #D32F2F);
            color: #fff;
        }

        .grades-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        .grades-table th {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 18px 15px;
            text-align: center;
            font-weight: 700;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .grades-table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #f1f3f4;
            transition: background-color 0.3s ease;
        }

        .grades-table tbody tr:hover {
            background: linear-gradient(135deg, #f8f9ff, #f0f4ff);
            transform: scale(1.01);
        }

        .grades-table tbody tr:nth-child(even) {
            background: rgba(248, 249, 250, 0.5);
        }

        .score-cell {
            font-weight: 700;
            font-size: 1.1em;
        }

        .score-high {
            color: #4CAF50;
        }

        .score-medium {
            color: #FF9800;
        }

        .score-low {
            color: #f44336;
        }

        .summary-section {
            margin-top: 30px;
            padding: 25px;
            background: linear-gradient(135deg, #f8f9fa, #ffffff);
            border-radius: 15px;
            border: 1px solid #e9ecef;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .summary-card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .summary-number {
            font-size: 2em;
            font-weight: 700;
            display: block;
            margin-bottom: 8px;
        }

        .summary-label {
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

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            background: #fff;
            margin: 8% auto;
            padding: 0;
            border-radius: 20px;
            width: 90%;
            max-width: 550px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease;
            overflow: hidden;
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
            transform: translateY(-50%) rotate(90deg);
        }

        .modal-body {
            padding: 40px 35px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 700;
            color: #495057;
            font-size: 1.1em;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 15px 18px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 16px;
            font-family: 'Cairo', sans-serif;
            transition: all 0.3s ease;
            background: #f8f9fa;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #2196F3;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        }

        .form-group input[type="number"] {
            text-align: center;
            font-weight: 700;
            font-size: 1.2em;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 35px;
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 10px;
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
            .container {
                margin: 10px;
                border-radius: 15px;
            }

            .header {
                padding: 15px;
                flex-direction: column;
                text-align: center;
            }

            .header h1 {
                font-size: 1.8em;
            }

            .student-info {
                flex-direction: column;
                gap: 10px;
            }

            .content {
                padding: 20px 15px;
            }

            .grades-table th,
            .grades-table td {
                padding: 10px 8px;
                font-size: 0.9em;
            }

            .modal-content {
                width: 95%;
                margin: 5% auto;
            }

            .modal-body {
                padding: 25px 20px;
            }

            .back-btn {
                padding: 8px 15px;
                font-size: 0.9em;
            }
        }

        /* Success Animation */
        .success-animation {
            animation: successPulse 0.6s ease;
        }

        @keyframes successPulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('teacher') }}" class="back-btn">
                ← العودة للوحة التحكم
            </a>

            <div class="header-content">
                <h1>📊 إدارة الدرجات</h1>
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
                    <div class="info-card">
                        <strong>المادة:</strong>
                        {{ $subject->name }}
                    </div>
                </div>
            </div>

            <div style="width: 150px;"></div> <!-- Spacer for balance -->
        </div>

        <div class="content">
            <table class="grades-table">
                <thead>
                    <tr>
                        <th>🗓️ الفصل</th>
                        <th>📝 نوع الامتحان</th>
                        <th>📊 الدرجة</th>
                        <th>📅 التاريخ</th>
                        <th>📋 ملاحظات</th>
                        <th>⚙️ العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($grades as $grade)
                    <tr>
                        <td>{{ $grade->type < 3 ? 'الفصل الأول' : 'الفصل الثاني' }}</td>
                        <td>
                            <span
                                style="padding: 5px 12px; background: rgba(33, 150, 243, 0.1); border-radius: 20px; font-weight: 600; color: #1976D2;">
                                @switch($grade->type)
                                @case(0)
                                الشهري الأول
                                @break

                                @case(1)
                                الشهري الثاني
                                @break

                                @case(2)
                                نصف السنة
                                @break

                                @case(3)
                                شهر الأول
                                @break

                                @case(4)
                                شهر الثاني
                                @break

                                @case(5)
                                الامتحان النهائي
                                @break
                                @endswitch
                            </span>
                        </td>
                        <td class="score-cell">
                            @if ($grade->score !== null)
                            <span
                                class="
                                        @if ($grade->score >= 80) score-high
                                        @elseif($grade->score >= 60) score-medium
                                        @else score-low @endif
                                    ">
                                {{ $grade->score }}/100
                            </span>
                            @else
                            <span style="color: #6c757d; font-style: italic;">لم يتم التقييم بعد</span>
                            @endif
                        </td>
                        <td>

                            @if ($grade->updated_at != null)
                            {{ \Carbon\Carbon::parse($grade->updated_at)->format('Y-m-d') }}
                            @else
                            <span style="color: #6c757d;">لا يوجد تاريخ</span>
                            @endif
                        </td>
                        <td>
                            @if ($grade->notes)
                            <span title="{{ $grade->notes }}" style="cursor: help;">
                                {{ Str::limit($grade->notes, 30) }}
                            </span>
                            @else
                            <span style="color: #6c757d; font-style: italic;">لا توجد ملاحظات</span>
                            @endif
                        </td>
                        <td>
                            <button
                                onclick="openEditModal({{ $grade->id ?? 1 }}, '{{ $grade->score }}', '{{ addslashes($grade->notes) }}')"
                                class="btn btn-warning">
                                ✏️ تعديل الدرجة
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 40px; color: #6c757d; font-style: italic;">
                            📝 لا توجد درجات مسجلة بعد
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($grades->count() > 0)
            <div class="summary-section">
                <h3 style="margin: 0 0 20px 0; color: #495057; text-align: center; font-size: 1.5em;">
                    📈 ملخص الدرجات
                </h3>
                <div class="summary-grid">
                    <div class="summary-card">
                        <span class="summary-number"
                            style="color: #2196F3;">{{ $firstMid + $midFinal + $secondMid + $finalExam }}</span>
                        <span class="summary-label">المجموع الحالي</span>
                    </div>
                    <div class="summary-card">
                        <span class="summary-number" style="color: #4CAF50;">{{ 400 }}</span>
                        <span class="summary-label">المجموع الكلي</span>
                    </div>
                    <div class="summary-card">
                        <span class="summary-number" style="color: #FF9800;">{{ $ratios }}%</span>
                        <span class="summary-label">النسبة المئوية</span>
                    </div>
                    <div class="summary-card">
                        <span class="summary-number" style="color: #FF0000;">{{ $letterGrade }}</span>
                        <span class="summary-label">التقدير</span>
                    </div>
                    <div class="summary-card">
                        <span class="summary-number"
                            style="color: #9C27B0;">{{ $grades->whereNotNull('score')->count() }}</span>
                        <span class="summary-label">عدد الامتحانات</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Edit Grade Modal -->
    <div id="editGradeModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeEditModal()">&times;</span>
                <h2>✏️ تعديل الدرجة</h2>
            </div>
            <div class="modal-body">
                <form id="editGradeForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="score">
                            📊 الدرجة (من 0 إلى 100):
                        </label>
                        <input type="number" id="score" name="score" required min="0" max="100"
                            step="0.5" placeholder="أدخل الدرجة هنا...">
                        <small style="color: #6c757d; display: block; margin-top: 5px;">
                            * يمكن إدخال درجات عشرية (مثل: 85.5)
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="notes">
                            📝 ملاحظات (اختياري):
                        </label>
                        <textarea id="notes" name="notes" rows="4" placeholder="أضف أي ملاحظات حول أداء الطالب..."></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">
                            💾 حفظ التعديل
                            <span class="loading-spinner" id="loadingSpinner"></span>
                        </button>
                        <button type="button" onclick="closeEditModal()" class="btn btn-danger">
                            ❌ إلغاء
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(gradeId, currentScore, currentNotes) {
            console.log('Opening modal for grade ID:', gradeId);

            // Fill form with current data
            document.getElementById('score').value = currentScore || '';
            document.getElementById('notes').value = currentNotes || '';

            // Update form action URL
            document.getElementById('editGradeForm').action = `/Teacher/grades/${gradeId}`;

            // Show modal with animation
            const modal = document.getElementById('editGradeModal');
            modal.style.display = 'block';

            // Focus on score input
            setTimeout(() => {
                document.getElementById('score').focus();
                document.getElementById('score').select();
            }, 300);
        }

        function closeEditModal() {
            const modal = document.getElementById('editGradeModal');
            modal.style.display = 'none';

            // Reset form
            document.getElementById('editGradeForm').reset();

            // Hide loading spinner
            document.getElementById('loadingSpinner').style.display = 'none';
        }

        // Enhanced form submission with loading state
        document.getElementById('editGradeForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const spinner = document.getElementById('loadingSpinner');

            // Show loading state
            submitBtn.disabled = true;
            spinner.style.display = 'inline-block';
            submitBtn.textContent = 'جاري الحفظ...';
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('editGradeModal');
            if (event.target === modal) {
                closeEditModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeEditModal();
            }
        });

        // Add success animation to updated rows
        document.addEventListener('DOMContentLoaded', function() {
            // Check if there's a success message in session and animate the updated row
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('updated') === 'success') {
                // Add success animation to the page
                document.querySelector('.container').classList.add('success-animation');

                // Show a temporary success message
                showSuccessMessage();
            }
        });

        function showSuccessMessage() {
            const message = document.createElement('div');
            message.innerHTML = '✅ تم تحديث الدرجة بنجاح!';
            message.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: linear-gradient(135deg, #4CAF50, #45a049);
                color: white;
                padding: 15px 25px;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 3000;
                font-weight: 600;
                animation: slideInRight 0.5s ease;
            `;

            document.body.appendChild(message);

            // Remove message after 3 seconds
            setTimeout(() => {
                message.style.animation = 'slideOutRight 0.5s ease';
                setTimeout(() => message.remove(), 500);
            }, 3000);
        }

        // Add CSS animations for success message
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>
