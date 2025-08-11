@extends('dashboard.header')

@section('content')
<div class="users-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <div class="title-section">
                <h1 class="page-title">
                    <i class="bi bi-people"></i>
                    Users Management
                </h1>
                <p class="page-subtitle">Manage all system users and their roles</p>
            </div>

            <div class="header-actions">
                <button type="button" class="btn btn-primary add-user-btn" data-bs-toggle="modal"
                    data-bs-target="#addUserModal">
                    <i class="bi bi-person-plus"></i>
                    <a href="{{ route('dashboard.users.create') }}">
                        Add New User
                    </a>
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-icon">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $users->total() }}</div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>

        <div class="stat-card manager">
            <div class="stat-icon">
                <i class="bi bi-person-gear"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $roleStats[1] ?? 0 }}</div>
                <div class="stat-label">Managers</div>
            </div>
        </div>

        <div class="stat-card account-manager">
            <div class="stat-icon">
                <i class="bi bi-person-badge"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $roleStats[2] ?? 0 }}</div>
                <div class="stat-label">Account Managers</div>
            </div>
        </div>

        <div class="stat-card school-manager">
            <div class="stat-icon">
                <i class="bi bi-building-gear"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $roleStats[3] ?? 0 }}</div>
                <div class="stat-label">School Managers</div>
            </div>
        </div>

        <div class="stat-card teacher">
            <div class="stat-icon">
                <i class="bi bi-person-workspace"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $roleStats[4] ?? 0 }}</div>
                <div class="stat-label">Teachers</div>
            </div>
        </div>

        <div class="stat-card student">
            <div class="stat-icon">
                <i class="bi bi-mortarboard"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $roleStats[5] ?? 0 }}</div>
                <div class="stat-label">Students</div>
            </div>
        </div>

        <div class="stat-card active">
            <div class="stat-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $activeUsers ?? 0 }}</div>
                <div class="stat-label">Active Users</div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <div class="filters-content">
            <div class="search-container">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" id="searchInput"
                        placeholder="Search by name, username, or email..." onkeyup="filterUsers()">
                </div>
            </div>

            <div class="filter-controls">
                <select class="form-select" id="roleFilter" onchange="filterUsers()">
                    <option value="">All Roles</option>
                    <option value="1">Manager</option>
                    <option value="2">Account Manager</option>
                    <option value="3">School Manager</option>

                </select>

                <select class="form-select" id="stateFilter" onchange="filterUsers()">
                    <option value="">All States</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="table-wrapper">
        <div class="table-responsive">
            <table class="table users-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>School</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    @forelse($users as $user)
                    <tr class="user-row" data-name="{{ strtolower($user->name) }}"
                        data-username="{{ strtolower($user->username) }}"
                        data-email="{{ strtolower($user->email) }}" data-role="{{ $user->role }}"
                        data-state="{{ $user->state }}">
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <span>{{ substr($user->name, 0, 2) }}</span>
                                </div>
                                <div class="user-details">
                                    <div class="user-name">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="username">{{ $user->username }}</span>
                        </td>
                        <td>
                            <span class="email">{{ $user->email }}</span>
                        </td>
                        <td>
                            <span class="phone">{{ $user->phone ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span class="role-badge role-{{ $user->role }}">
                                {{ $roleNames[$user->role] }}
                            </span>
                        </td>
                        <td>
                            <span class="school-name">
                                @if (isset($userSchools[$user->id]))
                                {{ $userSchools[$user->id] }}
                                @else
                                <span class="text-muted">N/A</span>
                                @endif
                            </span>
                        </td>
                        <td>
                            <span class="status-badge {{ $user->state ? 'active' : 'inactive' }}">
                                {{ $user->state ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <span class="created-date">{{ $user->created_at->format('M d, Y') }}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn edit-btn" onclick="editUser({{ $user->id }})"
                                    title="Edit User">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="action-btn {{ $user->state ? 'deactivate-btn' : 'activate-btn' }}"
                                    onclick="toggleUserState({{ $user->id }}, {{ $user->state }})"
                                    title="{{ $user->state ? 'Deactivate' : 'Activate' }}">
                                    <i class="bi bi-{{ $user->state ? 'pause' : 'play' }}"></i>
                                </button>
                                <button class="action-btn delete-btn" onclick="confirmDeleteUser({{ $user->id }}, '{{ $user->name }}')"
                                    title="Delete User">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="9" class="text-center">
                            <div class="empty-state">
                                <i class="bi bi-people"></i>
                                <h5>No users found</h5>
                                <p>Add your first user to get started</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($users->hasPages())
    <div class="pagination-wrapper">
        {{ $users->links() }}
    </div>
    @endif
</div>

<!-- Hidden Delete Forms for each user -->
@foreach($users as $user)
<form id="deleteForm{{ $user->id }}" action="{{ route('dashboard.users.destroy', $user) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endforeach

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    :root {
        --primary-color: #6366f1;
        --secondary-color: #8b5cf6;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #06b6d4;
        --light-bg: #f8fafc;
        --white: #ffffff;
        --gray-50: #f9fafb;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
        --border-radius: 16px;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        direction: ltr;
        text-align: left;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .users-container {
        padding: 2rem;
        background: var(--light-bg);
        min-height: 100vh;
    }

    /* Header Styles */
    .page-header {
        margin-bottom: 2rem;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-200);
    }

    .page-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-title i {
        color: var(--primary-color);
    }

    .page-subtitle {
        color: var(--gray-500);
        font-size: 1.125rem;
        margin: 0;
    }

    .add-user-btn {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border: none;
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: var(--transition);
        box-shadow: var(--shadow);
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .add-user-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
    }

    /* Statistics Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .stat-card.total .stat-icon {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    }

    .stat-card.admin .stat-icon {
        background: linear-gradient(135deg, #dc2626, #ef4444);
    }

    .stat-card.manager .stat-icon {
        background: linear-gradient(135deg, #7c3aed, #8b5cf6);
    }

    .stat-card.account-manager .stat-icon {
        background: linear-gradient(135deg, #0891b2, var(--info-color));
    }

    .stat-card.school-manager .stat-icon {
        background: linear-gradient(135deg, #ea580c, var(--warning-color));
    }

    .stat-card.teacher .stat-icon {
        background: linear-gradient(135deg, #059669, var(--success-color));
    }

    .stat-card.student .stat-icon {
        background: linear-gradient(135deg, #4338ca, #6366f1);
    }

    .stat-card.active .stat-icon {
        background: linear-gradient(135deg, var(--success-color), #34d399);
    }

    .stat-content {
        display: flex;
        flex-direction: column;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-800);
        line-height: 1;
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--gray-500);
        margin-top: 0.25rem;
    }

    /* Filters Section */
    .filters-section {
        margin-bottom: 2rem;
    }

    .filters-content {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        display: flex;
        gap: 1.5rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .search-container {
        flex: 1;
        min-width: 300px;
    }

    .input-group-text {
        background: var(--gray-100);
        border-color: var(--gray-300);
        color: var(--gray-500);
    }

    .form-control,
    .form-select {
        border-color: var(--gray-300);
        padding: 0.75rem;
        border-radius: 8px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
    }

    .filter-controls {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    /* Table Styles */
    .table-wrapper {
        background: var(--white);
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .users-table {
        margin: 0;
        border: none;
    }

    .users-table thead th {
        background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
        border: none;
        padding: 1.25rem 1rem;
        font-weight: 600;
        color: var(--gray-700);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .users-table tbody td {
        padding: 1rem;
        border-top: 1px solid var(--gray-200);
        vertical-align: middle;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
    }

    .user-name {
        font-weight: 600;
        color: var(--gray-800);
        font-size: 0.95rem;
    }

    .user-id {
        font-size: 0.75rem;
        color: var(--gray-500);
    }

    .username {
        font-family: monospace;
        background: var(--gray-100);
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.875rem;
        color: var(--gray-700);
    }

    .email {
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    .phone {
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    .role-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
        text-transform: capitalize;
    }

    .role-badge.role-0 {
        background: #dc2626;
    }

    .role-badge.role-1 {
        background: #7c3aed;
    }

    .role-badge.role-2 {
        background: var(--info-color);
    }

    .role-badge.role-3 {
        background: var(--warning-color);
    }

    .role-badge.role-4 {
        background: var(--success-color);
    }

    .role-badge.role-5 {
        background: var(--primary-color);
    }

    .school-name {
        color: var(--gray-700);
        font-size: 0.875rem;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-badge.active {
        background: #dcfce7;
        color: #166534;
    }

    .status-badge.inactive {
        background: #fef2f2;
        color: #991b1b;
    }

    .created-date {
        color: var(--gray-500);
        font-size: 0.875rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        color: white;
        font-size: 0.875rem;
    }

    .delete-btn {
        background: var(--danger-color);
    }

    .edit-btn {
        background: var(--warning-color);
    }

    .activate-btn {
        background: var(--success-color);
    }

    .deactivate-btn {
        background: var(--danger-color);
    }

    .action-btn:hover {
        transform: scale(1.1);
        opacity: 0.9;
    }

    /* Delete Confirmation Modal */
    .delete-confirmation-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        max-width: 500px;
        width: 90%;
        position: relative;
        z-index: 10000;
        animation: modalSlideIn 0.3s ease-out;
    }

    .modal-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modal-header h3 {
        margin: 0;
        color: var(--gray-800);
        font-size: 1.25rem;
        font-weight: 600;
    }

    .warning-icon {
        font-size: 1.5rem;
        color: var(--danger-color);
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-body p {
        margin-bottom: 1rem;
        color: var(--gray-700);
    }

    .warning-message {
        background: #fef3c7;
        border: 1px solid #fbbf24;
        border-radius: 8px;
        padding: 1rem;
        display: flex;
        gap: 0.75rem;
        margin: 1rem 0;
    }

    .warning-message i {
        color: #d97706;
        font-size: 1.125rem;
        margin-top: 0.125rem;
        flex-shrink: 0;
    }

    .warning-message span {
        color: #92400e;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .danger-text {
        color: var(--danger-color);
        font-weight: 600;
        margin-top: 1rem;
    }

    .modal-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--gray-200);
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-outline-secondary {
        background: var(--white);
        border: 2px solid var(--gray-300);
        color: var(--gray-700);
    }

    .btn-danger {
        background: var(--danger-color);
        color: white;
    }

    .btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px) scale(0.95);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Empty State */
    .empty-state {
        padding: 3rem 0;
        text-align: center;
        color: var(--gray-500);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .empty-state h5 {
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .users-container {
            padding: 1rem;
        }

        .header-content {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .filters-content {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-controls {
            justify-content: center;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }

        .table-responsive {
            font-size: 0.875rem;
        }

        .user-info {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .modal-content {
            margin: 1rem;
        }

        .modal-footer {
            flex-direction: column;
            gap: 0.75rem;
        }

        .modal-footer .btn {
            width: 100%;
        }
    }

    /* Animation */
    .stat-card,
    .user-row {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>


<script>
    // Filter function
    function filterUsers() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const roleFilter = document.getElementById('roleFilter').value;
        const stateFilter = document.getElementById('stateFilter').value;
        const userRows = document.querySelectorAll('.user-row');

        userRows.forEach(row => {
            const name = row.getAttribute('data-name');
            const username = row.getAttribute('data-username');
            const email = row.getAttribute('data-email');
            const role = row.getAttribute('data-role');
            const state = row.getAttribute('data-state');

            const matchesSearch = name.includes(searchTerm) ||
                username.includes(searchTerm) ||
                email.includes(searchTerm);
            const matchesRole = !roleFilter || role === roleFilter;
            const matchesState = !stateFilter || state === stateFilter;

            if (matchesSearch && matchesRole && matchesState) {
                row.style.display = 'table-row';
                row.style.animation = 'fadeInUp 0.3s ease-out';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Delete confirmation with better error handling
    function confirmDeleteUser(userId, userName) {
        // Create custom confirmation modal
        const confirmModal = document.createElement('div');
        confirmModal.className = 'delete-confirmation-modal';
        confirmModal.innerHTML = `
            <div class="modal-backdrop" onclick="closeDeleteModal()"></div>
            <div class="modal-content">
                <div class="modal-header">
                    <i class="bi bi-exclamation-triangle warning-icon"></i>
                    <h3>Delete User Account</h3>
                </div>
                <div class="modal-body">
                    <p><strong>Are you sure you want to delete "${userName}"?</strong></p>
                    <div class="warning-message">
                        <i class="bi bi-info-circle"></i>
                        <span>If this user has any actions in their school, you will not be able to delete this account. The system will prevent deletion to maintain data integrity.</span>
                    </div>
                    <p class="danger-text">This action cannot be undone!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" onclick="closeDeleteModal()">
                        <i class="bi bi-x-circle"></i>
                        Cancel
                    </button>
                    <button type="button" class="btn btn-danger" onclick="proceedWithDelete(${userId})">
                        <i class="bi bi-trash"></i>
                        Yes, Delete Account
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(confirmModal);
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        const modal = document.querySelector('.delete-confirmation-modal');
        if (modal) {
            document.body.removeChild(modal);
            document.body.style.overflow = '';
        }
    }

    function proceedWithDelete(userId) {
        const deleteForm = document.getElementById(`deleteForm${userId}`);
        if (deleteForm) {
            closeDeleteModal();
            deleteForm.submit();
        }
    }

    // User actions
    function editUser(id) {
        window.location.href = `users.edit/${id}`;
    }

    function toggleUserState(id, currentState) {
        const action = currentState ? 'deactivate' : 'activate';
        if (confirm(`Are you sure you want to ${action} this user?`)) {
            // Submit form to toggle state
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `users/${id}/toggle-state`;
            form.innerHTML = `
                @csrf
                @method('PATCH')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Users management page loaded successfully');

        // Handle success messages
        @if(session('success'))
        showNotification(`{!! addslashes(session('success')) !!}`, 'success');
        @endif

        // Handle error messages - Fixed to show full message
        @if(session('error'))
        showNotification(`{!! addslashes(session('error')) !!}`, 'error');
        @endif
    });

    // Enhanced notification function
    function showNotification(message, type) {
        // Remove any existing notifications first
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());

        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;

        // Create the notification HTML with proper message display
        notification.innerHTML = `
            <div class="notification-content">
                <div class="notification-icon">
                    <i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill'}"></i>
                </div>
                <div class="notification-message">
                    <div class="notification-title">${type === 'success' ? 'Success!' : 'Error!'}</div>
                    <div class="notification-text">${message}</div>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" class="notification-close">
                <i class="bi bi-x"></i>
            </button>
        `;

        // Add enhanced notification styles
        if (!document.querySelector('#notification-styles')) {
            const style = document.createElement('style');
            style.id = 'notification-styles';
            style.textContent = `
                .notification {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: white;
                    padding: 1.25rem;
                    border-radius: 12px;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.1), 0 4px 12px rgba(0,0,0,0.05);
                    display: flex;
                    align-items: flex-start;
                    justify-content: space-between;
                    gap: 1rem;
                    z-index: 10000;
                    max-width: 400px;
                    min-width: 320px;
                    animation: slideInRight 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
                    border: 1px solid rgba(0,0,0,0.05);
                }

                .notification-success {
                    border-left: 4px solid var(--success-color);
                    background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
                }

                .notification-error {
                    border-left: 4px solid var(--danger-color);
                    background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%);
                }

                .notification-content {
                    display: flex;
                    align-items: flex-start;
                    gap: 0.75rem;
                    flex: 1;
                }

                .notification-icon {
                    flex-shrink: 0;
                    margin-top: 0.125rem;
                }

                .notification-success .notification-icon i {
                    color: var(--success-color);
                    font-size: 1.25rem;
                }

                .notification-error .notification-icon i {
                    color: var(--danger-color);
                    font-size: 1.25rem;
                }

                .notification-message {
                    flex: 1;
                    min-width: 0;
                }

                .notification-title {
                    font-weight: 600;
                    font-size: 0.95rem;
                    margin-bottom: 0.25rem;
                    color: var(--gray-800);
                }

                .notification-text {
                    font-size: 0.875rem;
                    line-height: 1.4;
                    color: var(--gray-600);
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                }

                .notification-close {
                    background: none;
                    border: none;
                    color: var(--gray-400);
                    cursor: pointer;
                    padding: 0.25rem;
                    border-radius: 4px;
                    font-size: 1.125rem;
                    flex-shrink: 0;
                    transition: all 0.2s ease;
                    margin-top: -0.125rem;
                }

                .notification-close:hover {
                    color: var(--gray-600);
                    background: rgba(0,0,0,0.05);
                }

                @keyframes slideInRight {
                    from {
                        transform: translateX(100%) scale(0.95);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0) scale(1);
                        opacity: 1;
                    }
                }

                /* Animation for removing notification */
                .notification.removing {
                    animation: slideOutRight 0.3s ease-in forwards;
                }

                @keyframes slideOutRight {
                    to {
                        transform: translateX(100%) scale(0.95);
                        opacity: 0;
                    }
                }
            `;

            document.head.appendChild(style);
        }

        document.body.appendChild(notification);

        // Auto remove after 6 seconds with animation
        setTimeout(() => {
            if (document.body.contains(notification)) {
                notification.classList.add('removing');
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        notification.remove();
                    }
                }, 300);
            }
        }, 6000);
    }

    // Handle ESC key for modals
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endsection
