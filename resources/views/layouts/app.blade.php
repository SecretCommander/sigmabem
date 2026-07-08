<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BEM System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased flex h-screen overflow-hidden relative">

    <!-- Overlay Latar Belakang Gelap (Hanya di Mobile saat menu terbuka) -->
    <div id="sidebarOverlay" onclick="toggleSidebar()"
        class="fixed inset-0 bg-gray-900/50 z-40 hidden lg:hidden transition-opacity"></div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-purple-800 text-white flex flex-col justify-between h-full shadow-xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        <div>

            <!-- Logo -->
            <div class="p-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center shadow-inner">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold tracking-wider">BEM System</h2>
                        <p class="text-xs text-purple-200">RAB Management</p>
                    </div>
                </div>

                <!-- Tombol Close Menu di Mobile -->
                <button onclick="toggleSidebar()" class="lg:hidden text-purple-200 hover:text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- ✅ Navigation Menu (Session-Based + Role-Based) -->
            <nav class="mt-2 px-4 space-y-2 overflow-y-auto">

                <!-- Dashboard (Semua Role) -->
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white font-medium' : 'text-purple-200 hover:bg-white/5 hover:text-white transition' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    Dashboard
                </a>

                <!-- ✅ Proposal (Superadmin & Admin) -->
                @if (Session::get('user_role') === 'Superadmin' || Session::get('user_role') === 'Admin')
                    <a href="{{ route('proposal.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('proposal.*') ? 'bg-white/10 text-white font-medium' : 'text-purple-200 hover:bg-white/5 hover:text-white transition' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Format Proposal
                    </a>
                @endif

                <!-- ✅ LPJ (Superadmin & Admin) -->
                @if (Session::get('user_role') === 'Superadmin' || Session::get('user_role') === 'Admin')
                    <a href="{{ route('lpj.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('lpj.*') ? 'bg-white/10 text-white font-medium' : 'text-purple-200 hover:bg-white/5 hover:text-white transition' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                        Format LPJ
                    </a>
                @endif

                <!-- ✅ Users Management (Superadmin Only) -->
                {{-- @if (Session::get('user_role') === 'Superadmin')
                    <a href="{{ route('users.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('users.*') ? 'bg-white/10 text-white font-medium' : 'text-purple-200 hover:bg-white/5 hover:text-white transition' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        Manajemen User
                    </a>
                @endif --}}

                <!-- ✅ My Proposals (User Only) -->
                @if (Session::get('user_role') === 'User')
                    <a href="{{ route('user.proposals') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.proposals') ? 'bg-white/10 text-white font-medium' : 'text-purple-200 hover:bg-white/5 hover:text-white transition' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Proposal Saya
                    </a>
                @endif

                <!-- ✅ My LPJ (User Only) -->
                @if (Session::get('user_role') === 'User')
                    <a href="{{ route('user.lpj') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.lpj') ? 'bg-white/10 text-white font-medium' : 'text-purple-200 hover:bg-white/5 hover:text-white transition' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                        LPJ Saya
                    </a>
                @endif

                <!-- ✅ Settings (Superadmin Only) -->
                {{-- @if (Session::get('user_role') === 'Superadmin')
                    <a href="{{ route('settings.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('settings.*') ? 'bg-white/10 text-white font-medium' : 'text-purple-200 hover:bg-white/5 hover:text-white transition' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                            </path>
                        </svg>
                        Pengaturan
                    </a>
                @endif --}}

                <!-- About (Semua Role) -->
                <a href="{{ route('about') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('about') ? 'bg-white/10 text-white font-medium' : 'text-purple-200 hover:bg-white/5 hover:text-white transition' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    About
                </a>
            </nav>
        </div>

        <!-- ✅ Footer Sidebar (User Info + Logout) -->
        <div class="p-6 border-t border-purple-700">
            <!-- User Info -->
            <div class="flex items-center gap-3 mb-4">
                <div
                    class="w-8 h-8 rounded-full bg-white/20 text-white font-bold flex items-center justify-center text-sm">
                    {{ strtoupper(substr(Session::get('user_username', 'U'), 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-medium text-white">{{ Session::get('user_username', 'User') }}</p>
                    <p class="text-xs text-purple-300">{{ Session::get('user_role', 'Role') }}</p>
                    <p class="text-xs text-purple-300">{{ Session::get('user_email', 'Email') }}</p>
                </div>
            </div>

            <!-- Logout Form -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center gap-3 text-purple-200 hover:text-white transition font-medium w-full text-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Content Area (Memuat Header Mobile & Main Content) -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Header Mobile (Hanya muncul di layar HP/Tablet kecil) -->
        <header
            class="lg:hidden bg-white shadow-sm border-b border-gray-100 flex items-center justify-between px-4 py-4">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()"
                    class="text-gray-500 hover:text-purple-700 focus:outline-none p-1 rounded-md hover:bg-gray-100 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h1 class="text-xl font-bold text-purple-900">BEM System</h1>
            </div>

            <!-- ✅ Inisial User dari Session -->
            <div
                class="w-8 h-8 rounded-full bg-purple-100 text-purple-700 font-bold flex items-center justify-center text-sm border border-purple-200">
                {{ strtoupper(substr(Session::get('user_username', 'U'), 0, 1)) }}
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-4 md:p-8">

            <!-- ✅ Flash Messages -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    <!-- Script JavaScript untuk Toggle Sidebar -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            // Mengubah posisi sidebar (muncul / sembunyi)
            sidebar.classList.toggle('-translate-x-full');

            // Menampilkan / menyembunyikan overlay latar belakang gelap
            overlay.classList.toggle('hidden');
        }
    </script>
</body>

</html>
