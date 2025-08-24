<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teacher Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #2196F3, #21CBF3);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .content {
            padding: 30px;
        }

        .stage-card {
            background: #f8f9ff;
            border: 2px solid #e3f2fd;
            border-radius: 15px;
            margin-bottom: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stage-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stage-header {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stage-header:hover {
            background: linear-gradient(135deg, #45a049, #4CAF50);
        }

        .stage-title {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .arrow {
            transition: transform 0.3s ease;
            font-size: 1.2rem;
        }

        .arrow.active {
            transform: rotate(90deg);
        }

        .subjects-container {
            display: none;
            padding: 20px;
            background: white;
        }

        .subjects-container.active {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .subject-btn {
            background: linear-gradient(135deg, #FF9800, #F57C00);
            color: white;
            border: none;
            padding: 12px 25px;
            margin: 8px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 152, 0, 0.3);
        }

        .subject-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 152, 0, 0.4);
            background: linear-gradient(135deg, #F57C00, #FF9800);
        }

        .classes-container {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background: #f5f5f5;
            border-radius: 10px;
        }

        .classes-container.active {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .class-btn {
            background: linear-gradient(135deg, #9C27B0, #7B1FA2);
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 6px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(156, 39, 176, 0.3);
        }

        .class-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(156, 39, 176, 0.4);
        }

        .students-container {
            display: none;
            margin-top: 15px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            border: 2px solid #e1bee7;
        }

        .students-container.active {
            display: block;
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-title {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.2rem;
            font-weight: bold;
            padding-bottom: 10px;
            border-bottom: 2px solid #ddd;
        }

        .search-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-input {
            flex: 1;
            min-width: 250px;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: #2196F3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        }

        .students-count {
            background: #2196F3;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .students-table {
            width: 100%;
            border-collapse: collapse;
        }

        .students-table thead {
            background: linear-gradient(135deg, #2196F3, #1976D2);
            color: white;
        }

        .students-table th {
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 1rem;
        }

        .students-table tbody tr {
            border-bottom: 1px solid #eee;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .students-table tbody tr:hover {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .students-table td {
            padding: 15px 20px;
            font-size: 0.95rem;
        }

        .student-id {
            font-weight: 600;
            color: #1976D2;
        }

        .student-name {
            font-weight: 500;
            color: #333;
        }

        .grade-link {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .grade-link:hover {
            background: linear-gradient(135deg, #45a049, #4CAF50);
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(76, 175, 80, 0.3);
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .loading::after {
            content: '';
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3498db;
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

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            padding: 20px 0;
        }

        .pagination button {
            padding: 10px 15px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pagination button:hover {
            background: #f0f0f0;
        }

        .pagination button.active {
            background: #2196F3;
            color: white;
            border-color: #2196F3;
        }

        .pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .search-section {
                flex-direction: column;
            }

            .search-input {
                min-width: 100%;
            }

            .students-table {
                font-size: 0.85rem;
            }

            .students-table th,
            .students-table td {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🎓 Teacher Dashboard</h1>
            <p>Manage your stages, subjects, classes, and students</p>
        </div>

        <div class="content">
            @forelse($stages as $stage)
            <div class="stage-card">
                <div class="stage-header" onclick="toggleStage('stage{{ $stage->id }}', {{ $stage->id }})">
                    <div class="stage-title">
                        📚 {{ $stage->name }}
                        <span class="arrow" id="arrow-stage{{ $stage->id }}">▶</span>
                    </div>
                </div>
                <div class="subjects-container" id="stage{{ $stage->id }}">
                    <div class="section-title">📖 اختر المادة:</div>
                    <div id="subjects-{{ $stage->id }}" class="subjects-list">
                        <div class="loading">جاري تحميل المواد...</div>
                    </div>

                    <!-- Classes will be loaded here dynamically -->
                    <div id="classes-container-{{ $stage->id }}"></div>

                    <!-- Students will be loaded here dynamically -->
                    <div id="students-container-{{ $stage->id }}"></div>
                </div>
            </div>
            @empty
            <div class="no-data">
                <p>لا توجد مراحل دراسية متاحة</p>
            </div>
            @endforelse
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // CSRF token setup for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let currentStageId = null;
        let currentSubjectId = null;
        let currentClassId = null;
        let searchTimeout = null;
        let currentPage = 1;

        // Toggle stage visibility and load subjects
        function toggleStage(stageElementId, stageId) {
            const stage = document.getElementById(stageElementId);
            const arrow = document.getElementById('arrow-' + stageElementId);

            // Close all other stages
            const allStages = document.querySelectorAll('.subjects-container');
            const allArrows = document.querySelectorAll('.arrow');

            allStages.forEach(s => {
                if (s.id !== stageElementId) {
                    s.classList.remove('active');
                }
            });

            allArrows.forEach(a => {
                if (a.id !== 'arrow-' + stageElementId) {
                    a.classList.remove('active');
                }
            });

            // Toggle current stage
            stage.classList.toggle('active');
            arrow.classList.toggle('active');

            // If opening stage, load subjects
            if (stage.classList.contains('active')) {
                currentStageId = stageId;
                loadSubjects(stageId);
            } else {
                currentStageId = null;
                currentSubjectId = null;
                currentClassId = null;
            }
        }

        // Load subjects for a stage
        function loadSubjects(stageId) {
            const container = document.getElementById(`subjects-${stageId}`);
            container.innerHTML = '<div class="loading">جاري تحميل المواد...</div>';

            $.ajax({
                url: '{{ route("teacher.subjects") }}',
                method: 'GET',
                data: {
                    stage_id: stageId
                },
                success: function(response) {
                    if (response.success && response.subjects.length > 0) {
                        let html = '';
                        response.subjects.forEach(subject => {
                            html += `<button class="subject-btn" onclick="loadClasses(${subject.id}, '${subject.name}', ${stageId})">${subject.name}</button>`;
                        });
                        container.innerHTML = html;
                    } else {
                        container.innerHTML = '<div class="no-data">لا توجد مواد متاحة لهذه المرحلة</div>';
                    }
                },
                error: function(xhr) {
                    console.error('Error loading subjects:', xhr);
                    container.innerHTML = '<div class="no-data">حدث خطأ في تحميل المواد</div>';
                }
            });
        }

        // Load classes for a subject
        function loadClasses(subjectId, subjectName, stageId) {
            currentSubjectId = subjectId;
            currentClassId = null;

            const container = document.getElementById(`classes-container-${stageId}`);
            const studentsContainer = document.getElementById(`students-container-${stageId}`);

            // Clear students container
            studentsContainer.innerHTML = '';

            container.innerHTML = `
                <div class="classes-container active">
                    <div class="section-title">🏫 صفوف ${subjectName}:</div>
                    <div class="loading">جاري تحميل الصفوف...</div>
                </div>
            `;

            $.ajax({
                url: '{{ route("teacher.classes") }}',
                method: 'GET',
                data: {
                    stage_id: stageId,
                    subject_id: subjectId
                },
                success: function(response) {
                    console.log(response, response.classes.length);
                    if (response.success && response.classes.length > 0) {
                        let html = `
                            <div class="classes-container active">
                                <div class="section-title">🏫 صفوف ${subjectName}:</div>
                        `;
                        response.classes.forEach(classItem => {
                            html += `<button class="class-btn" onclick="loadStudents(${classItem.id}, '${classItem.name}', ${stageId}, ${subjectId})">${classItem.name}</button>`;
                        });

                        html += '</div>';
                        container.innerHTML = html;
                    } else {
                        container.innerHTML = `
                            <div class="classes-container active">
                                <div class="section-title">🏫 صفوف ${subjectName}:</div>
                                <div class="no-data">لا توجد صفوف متاحة لهذه المادة</div>
                            </div>
                        `;
                    }
                },
                error: function(xhr) {
                    console.error('Error loading classes:', xhr);
                    container.innerHTML = `
                        <div class="classes-container active">
                            <div class="section-title">🏫 صفوف ${subjectName}:</div>
                            <div class="no-data">حدث خطأ في تحميل الصفوف</div>
                        </div>
                    `;
                }
            });
        }

        // Load students for a class
        function loadStudents(classId, className, stageId, subjectId, page = 1, search = '') {
            currentClassId = classId;
            currentPage = page;

            const container = document.getElementById(`students-container-${stageId}`);

            if (page === 1 && !search) {
                container.innerHTML = `
                    <div class="students-container active">
                        <div class="section-title">👨‍🎓 طلاب ${className}:</div>
                        <div class="loading">جاري تحميل الطلاب...</div>
                    </div>
                `;
            }

            $.ajax({
                url: '{{ route("teacher.students") }}',
                method: 'GET',
                data: {
                    class_id: classId,
                    page: page,
                    search: search
                },
                success: function(response) {
                    if (response.success) {
                        renderStudentsTable(response, className, subjectId, stageId, classId, search);
                    } else {
                        container.innerHTML = `
                            <div class="students-container active">
                                <div class="section-title">👨‍🎓 طلاب ${className}:</div>
                                <div class="no-data">حدث خطأ في تحميل بيانات الطلاب</div>
                            </div>
                        `;
                    }
                },
                error: function(xhr) {
                    console.error('Error loading students:', xhr);
                    container.innerHTML = `
                        <div class="students-container active">
                            <div class="section-title">👨‍🎓 طلاب ${className}:</div>
                            <div class="no-data">حدث خطأ في تحميل الطلاب</div>
                        </div>
                    `;
                }
            });
        }

        // Render students table with pagination
        function renderStudentsTable(response, className, subjectId, stageId, classId, currentSearch = '') {
            const container = document.getElementById(`students-container-${stageId}`);
            const students = response.students;
            const pagination = response.pagination;

            let html = `
                <div class="students-container active">
                    <div class="section-title">👨‍🎓 طلاب ${className}:</div>

                    <div class="search-section">
                        <input type="text" class="search-input" placeholder="🔍 البحث عن طالب..."
                               value="${currentSearch}"
                               onkeyup="searchStudents(this.value, ${classId}, '${className}', ${stageId}, ${subjectId})" />
                        <div class="students-count">
                            ${currentSearch ?
                                `نتائج البحث: ${pagination.total} من أصل ${response.total_without_search}` :
                                `العدد الكلي: ${pagination.total} طالب`
                            }
                        </div>
                    </div>
            `;

            if (students.data && students.data.length > 0) {
                html += `
                    <div class="table-container">
                        <table class="students-table">
                            <thead>
                                <tr>
                                    <th>رقم الطالب</th>
                                    <th>اسم الطالب</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>إدارة الدرجات</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                students.data.forEach(student => {
                    html += `
                        <tr onclick="goToGrades(${student.id}, '${student.name}', ${subjectId})">
                            <td class="student-id">${student.student_number || student.id}</td>
                            <td class="student-name">${student.name}</td>
                            <td>${new Date(student.created_at).toLocaleDateString('ar-SA')}</td>
                            <td>
                                <a href="#" class="grade-link"
                                   onclick="event.stopPropagation(); goToGrades(${student.id}, '${student.name}')">
                                   إدارة الدرجات
                                </a>
                            </td>
                        </tr>
                    `;
                });

                html += `
                            </tbody>
                        </table>
                    </div>
                `;

                // Add pagination if there are multiple pages
                if (pagination.last_page > 1) {
                    html += generatePagination(pagination, classId, className, stageId, currentSearch);
                }
            } else {
                html += `<div class="no-data">لا توجد نتائج${currentSearch ? ' للبحث المطلوب' : ''}</div>`;
            }

            html += '</div>';
            container.innerHTML = html;
        }

        // Generate pagination HTML
        function generatePagination(pagination, classId, className, stageId, search) {
            let html = '<div class="pagination">';

            // Previous button
            if (pagination.current_page > 1) {
                html += `<button onclick="loadStudents(${classId}, '${className}', ${subjectId}, ${stageId}, ${pagination.current_page - 1}, '${search}')">السابق</button>`;
            } else {
                html += '<button disabled>السابق</button>';
            }

            // Page numbers
            let startPage = Math.max(1, pagination.current_page - 2);
            let endPage = Math.min(pagination.last_page, pagination.current_page + 2);

            if (startPage > 1) {
                html += `<button onclick="loadStudents(${classId}, '${className}',${subjectId}, ${stageId}, 1, '${search}')">1</button>`;
                if (startPage > 2) html += '<span>...</span>';
            }

            for (let i = startPage; i <= endPage; i++) {
                const activeClass = i === pagination.current_page ? 'active' : '';
                html += `<button class="${activeClass}" onclick="loadStudents(${classId}, '${className}',${subjectId}, ${stageId}, ${i}, '${search}')">${i}</button>`;
            }

            if (endPage < pagination.last_page) {
                if (endPage < pagination.last_page - 1) html += '<span>...</span>';
                html += `<button onclick="loadStudents(${classId}, '${className}', ${subjectId}, ${stageId}, ${pagination.last_page}, '${search}')">${pagination.last_page}</button>`;
            }

            // Next button
            if (pagination.current_page < pagination.last_page) {
                html += `<button onclick="loadStudents(${classId}, '${className}', ${subjectId}, ${stageId}, ${pagination.current_page + 1}, '${search}')">التالي</button>`;
            } else {
                html += '<button disabled>التالي</button>';
            }

            html += '</div>';
            return html;
        }

        // Search students with debounce
        function searchStudents(query, classId, className, stageId, subjectId) {
            // Clear previous timeout
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }

            // Set new timeout for debounced search
            searchTimeout = setTimeout(() => {
                loadStudents(classId, className, subjectId, stageId, 1, query);
            }, 500);
        }

        // Navigate to grades management page
        function goToGrades(studentId, studentName, subjectId) {
            // Generate the URL for grades management
            console.log(
                studentId,
                subjectId
            )
            const gradesUrl = `{{ route('grades.manage', [':studentId', ':subjectId']) }}`.replace(':studentId', studentId).replace(':subjectId', subjectId);
            window.location.href = gradesUrl;
        }

        // Add interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add click animation to buttons
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
        });
    </script>
</body>

</html>
