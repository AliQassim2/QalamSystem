<!-- resources/views/layouts/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <!-- Header -->
    <header class="bg-white shadow-md py-3 px-6 flex justify-between items-center">

        <!-- Left side -->
        <nav class="flex items-center space-x-6">
            <a href="{{ route('dashboard.home') }}" class="text-gray-700 hover:text-blue-500 font-medium">Home</a>
            <a href="{{ route('dashboard.users.index') }}" class="text-gray-700 hover:text-blue-500 font-medium">Users</a>
            <a href="{{ route('dashboard.schools') }}" class="text-gray-700 hover:text-blue-500 font-medium">Schools</a>
        </nav>

        <!-- Right side -->
        <div class="flex items-center space-x-4">
            <span class="text-gray-700 font-semibold">{{ auth()->user()->name ?? 'Guest' }}</span>
            <a href="{{ route('logout') }}" class="text-red-500 hover:underline">Logout</a>
        </div>

    </header>

    <!-- Page Content -->
    <main class="p-6">
        @yield('content')
    </main>

</body>

</html>