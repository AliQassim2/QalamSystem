<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        /* Search and Filter Section */
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

        /* Table Styles */
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

        .student-actions {
            color: #666;
            font-size: 0.9rem;
            font-style: italic;
        }

        .no-students {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 1.1rem;
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

        /* Pagination */
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

        /* Responsive */
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
            <!-- Stage 1: ابتدائي -->
            <div class="stage-card">
                <div class="stage-header" onclick="toggleStage('stage1')">
                    <div class="stage-title">
                        📚 المرحلة الابتدائية
                        <span class="arrow" id="arrow-stage1">▶</span>
                    </div>
                </div>
                <div class="subjects-container" id="stage1">
                    <div class="section-title">📖 اختر المادة:</div>
                    <button class="subject-btn" onclick="showClasses('primary-math')">الرياضيات</button>
                    <button class="subject-btn" onclick="showClasses('primary-arabic')">اللغة العربية</button>
                    <button class="subject-btn" onclick="showClasses('primary-english')">اللغة الإنجليزية</button>
                    <button class="subject-btn" onclick="showClasses('primary-science')">العلوم</button>

                    <!-- Mathematics Classes -->
                    <div class="classes-container" id="primary-math">
                        <div class="section-title">🏫 صفوف الرياضيات:</div>
                        <button class="class-btn" onclick="showStudents('math-grade1')">الصف الأول أ</button>
                        <button class="class-btn" onclick="showStudents('math-grade2')">الصف الثاني ب</button>
                        <button class="class-btn" onclick="showStudents('math-grade3')">الصف الثالث ج</button>

                        <!-- Students for Math Grade 1 -->
                        <div class="students-container" id="math-grade1">
                            <div class="section-title">👨‍🎓 طلاب الصف الأول أ - الرياضيات:</div>

                            <div class="search-section">
                                <input type="text" class="search-input" placeholder="🔍 البحث عن طالب..."
                                    onkeyup="searchStudents(this, 'table-math-grade1')">
                                <div class="students-count" id="count-math-grade1">العدد الكلي: 45 طالب</div>
                            </div>

                            <div class="table-container">
                                <table class="students-table" id="table-math-grade1">
                                    <thead>
                                        <tr>
                                            <th>رقم الطالب</th>
                                            <th>اسم الطالب</th>
                                            <th>تاريخ التسجيل</th>
                                            <th>إدارة الدرجات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr onclick="goToGrades(1001, 'أحمد علي حسن')">
                                            <td class="student-id">1001</td>
                                            <td class="student-name">أحمد علي حسن</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(1001, 'أحمد علي حسن')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(1002, 'فاطمة محمد')">
                                            <td class="student-id">1002</td>
                                            <td class="student-name">فاطمة محمد</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(1002, 'فاطمة محمد')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(1003, 'عمر خليل')">
                                            <td class="student-id">1003</td>
                                            <td class="student-name">عمر خليل</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(1003, 'عمر خليل')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(1004, 'زينب أحمد')">
                                            <td class="student-id">1004</td>
                                            <td class="student-name">زينب أحمد</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(1004, 'زينب أحمد')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(1005, 'حسن إبراهيم')">
                                            <td class="student-id">1005</td>
                                            <td class="student-name">حسن إبراهيم</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(1005, 'حسن إبراهيم')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(1006, 'مريم يوسف')">
                                            <td class="student-id">1006</td>
                                            <td class="student-name">مريم يوسف</td>
                                            <td>2024-09-02</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(1006, 'مريم يوسف')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(1007, 'علي محمود')">
                                            <td class="student-id">1007</td>
                                            <td class="student-name">علي محمود</td>
                                            <td>2024-09-02</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(1007, 'علي محمود')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(1008, 'سارة عبدالله')">
                                            <td class="student-id">1008</td>
                                            <td class="student-name">سارة عبدالله</td>
                                            <td>2024-09-02</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(1008, 'سارة عبدالله')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(1009, 'محمود رشيد')">
                                            <td class="student-id">1009</td>
                                            <td class="student-name">محمود رشيد</td>
                                            <td>2024-09-03</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(1009, 'محمود رشيد')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(1010, 'ليلى حسن')">
                                            <td class="student-id">1010</td>
                                            <td class="student-name">ليلى حسن</td>
                                            <td>2024-09-03</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(1010, 'ليلى حسن')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="pagination">
                                <button onclick="changePage('math-grade1', -1)">السابق</button>
                                <button class="active">1</button>
                                <button onclick="changePage('math-grade1', 1)">2</button>
                                <button onclick="changePage('math-grade1', 1)">3</button>
                                <button onclick="changePage('math-grade1', 1)">4</button>
                                <button onclick="changePage('math-grade1', 1)">5</button>
                                <button onclick="changePage('math-grade1', 1)">التالي</button>
                            </div>
                        </div>

                        <!-- Students for Math Grade 2 -->
                        <div class="students-container" id="math-grade2">
                            <div class="section-title">👨‍🎓 طلاب الصف الثاني ب - الرياضيات:</div>

                            <div class="search-section">
                                <input type="text" class="search-input" placeholder="🔍 البحث عن طالب..."
                                    onkeyup="searchStudents(this, 'table-math-grade2')">
                                <div class="students-count">العدد الكلي: 38 طالب</div>
                            </div>

                            <div class="table-container">
                                <table class="students-table" id="table-math-grade2">
                                    <thead>
                                        <tr>
                                            <th>رقم الطالب</th>
                                            <th>اسم الطالب</th>
                                            <th>تاريخ التسجيل</th>
                                            <th>إدارة الدرجات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr onclick="goToGrades(2001, 'كريم سعيد')">
                                            <td class="student-id">2001</td>
                                            <td class="student-name">كريم سعيد</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(2001, 'كريم سعيد')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(2002, 'نور الدين')">
                                            <td class="student-id">2002</td>
                                            <td class="student-name">نور الدين</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(2002, 'نور الدين')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(2003, 'ياسمين فريد')">
                                            <td class="student-id">2003</td>
                                            <td class="student-name">ياسمين فريد</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(2003, 'ياسمين فريد')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Students for Math Grade 3 -->
                        <div class="students-container" id="math-grade3">
                            <div class="section-title">👨‍🎓 طلاب الصف الثالث ج - الرياضيات:</div>

                            <div class="search-section">
                                <input type="text" class="search-input" placeholder="🔍 البحث عن طالب..."
                                    onkeyup="searchStudents(this, 'table-math-grade3')">
                                <div class="students-count">العدد الكلي: 42 طالب</div>
                            </div>

                            <div class="table-container">
                                <table class="students-table" id="table-math-grade3">
                                    <thead>
                                        <tr>
                                            <th>رقم الطالب</th>
                                            <th>اسم الطالب</th>
                                            <th>تاريخ التسجيل</th>
                                            <th>إدارة الدرجات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr onclick="goToGrades(3001, 'أميرة سالم')">
                                            <td class="student-id">3001</td>
                                            <td class="student-name">أميرة سالم</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(3001, 'أميرة سالم')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(3002, 'طارق ناصر')">
                                            <td class="student-id">3002</td>
                                            <td class="student-name">طارق ناصر</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(3002, 'طارق ناصر')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Other subjects containers would follow similar pattern -->
                    <div class="classes-container" id="primary-arabic">
                        <div class="section-title">🏫 صفوف اللغة العربية:</div>
                        <button class="class-btn" onclick="showStudents('arabic-grade1')">الصف الأول أ</button>
                        <button class="class-btn" onclick="showStudents('arabic-grade2')">الصف الثاني ب</button>

                        <div class="students-container" id="arabic-grade1">
                            <div class="section-title">👨‍🎓 طلاب الصف الأول أ - اللغة العربية:</div>

                            <div class="search-section">
                                <input type="text" class="search-input" placeholder="🔍 البحث عن طالب..."
                                    onkeyup="searchStudents(this, 'table-arabic-grade1')">
                                <div class="students-count">العدد الكلي: 35 طالب</div>
                            </div>

                            <div class="table-container">
                                <table class="students-table" id="table-arabic-grade1">
                                    <thead>
                                        <tr>
                                            <th>رقم الطالب</th>
                                            <th>اسم الطالب</th>
                                            <th>تاريخ التسجيل</th>
                                            <th>إدارة الدرجات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr onclick="goToGrades(4001, 'جنى محمود')">
                                            <td class="student-id">4001</td>
                                            <td class="student-name">جنى محمود</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(4001, 'جنى محمود')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(4002, 'سامي خليل')">
                                            <td class="student-id">4002</td>
                                            <td class="student-name">سامي خليل</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(4002, 'سامي خليل')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stage 2: متوسط -->
            <div class="stage-card">
                <div class="stage-header" onclick="toggleStage('stage2')">
                    <div class="stage-title">
                        🎒 المرحلة المتوسطة
                        <span class="arrow" id="arrow-stage2">▶</span>
                    </div>
                </div>
                <div class="subjects-container" id="stage2">
                    <div class="section-title">📖 اختر المادة:</div>
                    <button class="subject-btn" onclick="showClasses('middle-physics')">الفيزياء</button>
                    <button class="subject-btn" onclick="showClasses('middle-chemistry')">الكيمياء</button>
                    <button class="subject-btn" onclick="showClasses('middle-biology')">الأحياء</button>

                    <!-- Physics Classes -->
                    <div class="classes-container" id="middle-physics">
                        <div class="section-title">🏫 صفوف الفيزياء:</div>
                        <button class="class-btn" onclick="showStudents('physics-grade7')">الصف الأول المتوسط</button>

                        <div class="students-container" id="physics-grade7">
                            <div class="section-title">👨‍🎓 طلاب الصف الأول المتوسط - الفيزياء:</div>

                            <div class="search-section">
                                <input type="text" class="search-input" placeholder="🔍 البحث عن طالب..."
                                    onkeyup="searchStudents(this, 'table-physics-grade7')">
                                <div class="students-count">العدد الكلي: 52 طالب</div>
                            </div>

                            <div class="table-container">
                                <table class="students-table" id="table-physics-grade7">
                                    <thead>
                                        <tr>
                                            <th>رقم الطالب</th>
                                            <th>اسم الطالب</th>
                                            <th>تاريخ التسجيل</th>
                                            <th>إدارة الدرجات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr onclick="goToGrades(7001, 'محمد الزهراء')">
                                            <td class="student-id">7001</td>
                                            <td class="student-name">محمد الزهراء</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(7001, 'محمد الزهراء')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(7002, 'ريم جواد')">
                                            <td class="student-id">7002</td>
                                            <td class="student-name">ريم جواد</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(7002, 'ريم جواد')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(7003, 'يوسف عباس')">
                                            <td class="student-id">7003</td>
                                            <td class="student-name">يوسف عباس</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(7003, 'يوسف عباس')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(7004, 'آية حكيم')">
                                            <td class="student-id">7004</td>
                                            <td class="student-name">آية حكيم</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(7004, 'آية حكيم')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(7005, 'مصطفى قاسم')">
                                            <td class="student-id">7005</td>
                                            <td class="student-name">مصطفى قاسم</td>
                                            <td>2024-09-02</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(7005, 'مصطفى قاسم')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stage 3: ثانوي -->
            <div class="stage-card">
                <div class="stage-header" onclick="toggleStage('stage3')">
                    <div class="stage-title">
                        🎓 المرحلة الثانوية
                        <span class="arrow" id="arrow-stage3">▶</span>
                    </div>
                </div>
                <div class="subjects-container" id="stage3">
                    <div class="section-title">📖 اختر المادة:</div>
                    <button class="subject-btn" onclick="showClasses('high-advanced-physics')">الفيزياء
                        المتقدمة</button>
                    <button class="subject-btn" onclick="showClasses('high-calculus')">التفاضل والتكامل</button>
                    <button class="subject-btn" onclick="showClasses('high-chemistry')">الكيمياء العضوية</button>

                    <!-- Advanced Physics Classes -->
                    <div class="classes-container" id="high-advanced-physics">
                        <div class="section-title">🏫 صفوف الفيزياء المتقدمة:</div>
                        <button class="class-btn" onclick="showStudents('physics-grade11')">الصف الخامس
                            العلمي</button>

                        <div class="students-container" id="physics-grade11">
                            <div class="section-title">👨‍🎓 طلاب الصف الخامس العلمي - الفيزياء المتقدمة:</div>

                            <div class="search-section">
                                <input type="text" class="search-input" placeholder="🔍 البحث عن طالب..."
                                    onkeyup="searchStudents(this, 'table-physics-grade11')">
                                <div class="students-count">العدد الكلي: 28 طالب</div>
                            </div>

                            <div class="table-container">
                                <table class="students-table" id="table-physics-grade11">
                                    <thead>
                                        <tr>
                                            <th>رقم الطالب</th>
                                            <th>اسم الطالب</th>
                                            <th>تاريخ التسجيل</th>
                                            <th>إدارة الدرجات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr onclick="goToGrades(11001, 'أحمد التميمي')">
                                            <td class="student-id">11001</td>
                                            <td class="student-name">أحمد التميمي</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(11001, 'أحمد التميمي')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(11002, 'نور فاضل')">
                                            <td class="student-id">11002</td>
                                            <td class="student-name">نور فاضل</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(11002, 'نور فاضل')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(11003, 'حيدر سلمان')">
                                            <td class="student-id">11003</td>
                                            <td class="student-name">حيدر سلمان</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(11003, 'حيدر سلمان')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(11004, 'زهراء مهدي')">
                                            <td class="student-id">11004</td>
                                            <td class="student-name">زهراء مهدي</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(11004, 'زهراء مهدي')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(11005, 'فارس جاسم')">
                                            <td class="student-id">11005</td>
                                            <td class="student-name">فارس جاسم</td>
                                            <td>2024-09-02</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(11005, 'فارس جاسم')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Calculus Classes -->
                    <div class="classes-container" id="high-calculus">
                        <div class="section-title">🏫 صفوف التفاضل والتكامل:</div>
                        <button class="class-btn" onclick="showStudents('calculus-grade12')">الصف السادس
                            الإعدادي</button>

                        <div class="students-container" id="calculus-grade12">
                            <div class="section-title">👨‍🎓 طلاب الصف السادس الإعدادي - التفاضل والتكامل:</div>

                            <div class="search-section">
                                <input type="text" class="search-input" placeholder="🔍 البحث عن طالب..."
                                    onkeyup="searchStudents(this, 'table-calculus-grade12')">
                                <div class="students-count">العدد الكلي: 22 طالب</div>
                            </div>

                            <div class="table-container">
                                <table class="students-table" id="table-calculus-grade12">
                                    <thead>
                                        <tr>
                                            <th>رقم الطالب</th>
                                            <th>اسم الطالب</th>
                                            <th>تاريخ التسجيل</th>
                                            <th>إدارة الدرجات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr onclick="goToGrades(12001, 'مريم كاظم')">
                                            <td class="student-id">12001</td>
                                            <td class="student-name">مريم كاظم</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(12001, 'مريم كاظم')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(12002, 'قاسم الربيعي')">
                                            <td class="student-id">12002</td>
                                            <td class="student-name">قاسم الربيعي</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(12002, 'قاسم الربيعي')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(12003, 'رنا هاشم')">
                                            <td class="student-id">12003</td>
                                            <td class="student-name">رنا هاشم</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(12003, 'رنا هاشم')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                        <tr onclick="goToGrades(12004, 'خالد نوري')">
                                            <td class="student-id">12004</td>
                                            <td class="student-name">خالد نوري</td>
                                            <td>2024-09-01</td>
                                            <td><a href="#" class="grade-link"
                                                    onclick="event.stopPropagation(); goToGrades(12004, 'خالد نوري')">إدارة
                                                    الدرجات</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentPage = {};
        let studentsPerPage = 10;

        // Toggle stage visibility
        function toggleStage(stageId) {
            const stage = document.getElementById(stageId);
            const arrow = document.getElementById('arrow-' + stageId);

            // Close all other stages
            const allStages = document.querySelectorAll('.subjects-container');
            const allArrows = document.querySelectorAll('.arrow');

            allStages.forEach(s => {
                if (s.id !== stageId) {
                    s.classList.remove('active');
                }
            });

            allArrows.forEach(a => {
                if (a.id !== 'arrow-' + stageId) {
                    a.classList.remove('active');
                }
            });

            // Close all classes and students when switching stages
            const allClasses = document.querySelectorAll('.classes-container');
            const allStudents = document.querySelectorAll('.students-container');

            allClasses.forEach(c => c.classList.remove('active'));
            allStudents.forEach(s => s.classList.remove('active'));

            // Toggle current stage
            stage.classList.toggle('active');
            arrow.classList.toggle('active');
        }

        // Show classes for selected subject
        function showClasses(subjectId) {
            // Hide all class containers first
            const allClasses = document.querySelectorAll('.classes-container');
            const allStudents = document.querySelectorAll('.students-container');

            allClasses.forEach(c => c.classList.remove('active'));
            allStudents.forEach(s => s.classList.remove('active'));

            // Show selected subject's classes
            const selectedSubject = document.getElementById(subjectId);
            if (selectedSubject) {
                selectedSubject.classList.add('active');
            }
        }

        // Show students for selected class
        function showStudents(classId) {
            // Hide all student containers first
            const allStudents = document.querySelectorAll('.students-container');
            allStudents.forEach(s => s.classList.remove('active'));

            // Show selected class's students
            const selectedClass = document.getElementById(classId);
            if (selectedClass) {
                selectedClass.classList.add('active');
                // Initialize current page for this class if not exists
                if (!currentPage[classId]) {
                    currentPage[classId] = 1;
                }
            }
        }

        // Search functionality
        function searchStudents(input, tableId) {
            const filter = input.value.toLowerCase();
            const table = document.getElementById(tableId);
            const tbody = table.getElementsByTagName('tbody')[0];
            const rows = tbody.getElementsByTagName('tr');
            let visibleCount = 0;

            for (let i = 0; i < rows.length; i++) {
                const studentName = rows[i].getElementsByTagName('td')[1];
                const studentId = rows[i].getElementsByTagName('td')[0];

                if (studentName && studentId) {
                    const nameText = studentName.textContent || studentName.innerText;
                    const idText = studentId.textContent || studentId.innerText;

                    if (nameText.toLowerCase().indexOf(filter) > -1 ||
                        idText.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = "";
                        visibleCount++;
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }

            // Update student count
            const countElement = input.parentNode.querySelector('.students-count');
            if (countElement) {
                if (filter) {
                    countElement.textContent = `نتائج البحث: ${visibleCount} طالب`;
                } else {
                    const totalCount = rows.length;
                    countElement.textContent = `العدد الكلي: ${totalCount} طالب`;
                }
            }
        }

        // Navigate to grades management page
        function goToGrades(studentId, studentName) {
            // In a real application, this would navigate to the grades page
            // For now, we'll show an alert
            alert(`سيتم توجيهك إلى صفحة إدارة درجات الطالب:\n${studentName}\nرقم الطالب: ${studentId}`);

            // In Laravel, this would be something like:
            // window.location.href = `/grades/student/${studentId}`;
            // or using route:
            // window.location.href = route('grades.manage', {'student': studentId});
        }

        // Pagination functionality (basic implementation)
        function changePage(classId, direction) {
            if (!currentPage[classId]) {
                currentPage[classId] = 1;
            }

            const newPage = currentPage[classId] + direction;
            if (newPage >= 1) {
                currentPage[classId] = newPage;
                // Here you would typically load new data via AJAX
                console.log(`Loading page ${newPage} for class ${classId}`);
            }
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

            // Add row hover effects
            const tables = document.querySelectorAll('.students-table tbody tr');
            tables.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#e3f2fd';
                });

                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });
        });
    </script>
</body>

</html>
