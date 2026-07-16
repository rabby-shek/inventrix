<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Inventrix'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }

        .sidebar-link.active,
        .sidebar-item[data-toggle].active {
            background-color: #eef2ff;
            color: #4f46e5;
        }

        .sidebar-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .sidebar-submenu.open {
            max-height: 500px;
        }

        .menu-arrow {
            transition: transform 0.2s ease;
            display: inline-flex;
        }

        .menu-arrow.rotated {
            transform: rotate(90deg);
        }

        .sidebar-expanded {
            width: 260px;
        }

        .sidebar-collapsed {
            width: 72px;
        }

        .sidebar-collapsed .menu-text,
        .sidebar-collapsed .submenu-text,
        .sidebar-collapsed .sidebar-footer-text,
        .sidebar-collapsed .logo-text,
        .sidebar-collapsed .menu-arrow {
            display: none;
        }

        .sidebar-collapsed .sidebar-item {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        .sidebar-collapsed .submenu-item {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        .sidebar-collapsed .sidebar-submenu {
            display: none;
        }

        .main-content-expanded {
            margin-left: 260px;
        }

        .main-content-collapsed {
            margin-left: 72px;
        }

        .topbar-expanded {
            left: 260px;
        }

        .topbar-collapsed {
            left: 72px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content-expanded,
            .main-content-collapsed {
                margin-left: 0;
            }

            .topbar-expanded,
            .topbar-collapsed {
                left: 0;
            }
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    @include('layouts.sidebar')

    <div id="topbar"
        class="fixed top-0 right-0 h-16 bg-white border-b border-gray-200 z-30 transition-all duration-300 flex items-center justify-between px-6 topbar-expanded">
        <div class="flex items-center gap-4">
            <button id="mobileMenuBtn" class="md:hidden text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <h2 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative">
                <button id="notifBtn"
                    class="relative text-gray-500 hover:text-gray-700 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <div id="notifDropdown"
                    class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 z-50">
                    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                        <button class="text-xs text-indigo-600 hover:text-indigo-500 font-medium">Mark all read</button>
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        <a href="#"
                            class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50">
                            <div class="w-2 h-2 bg-indigo-500 rounded-full mt-1.5 shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Low stock alert</p>
                                <p class="text-xs text-gray-500 truncate">Product X is running low on stock</p>
                                <p class="text-xs text-gray-400 mt-1">5 min ago</p>
                            </div>
                        </a>
                        <a href="#"
                            class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50">
                            <div class="w-2 h-2 bg-green-500 rounded-full mt-1.5 shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">New order received</p>
                                <p class="text-xs text-gray-500 truncate">Order #1024 from John Doe</p>
                                <p class="text-xs text-gray-400 mt-1">1 hour ago</p>
                            </div>
                        </a>
                        <a href="#"
                            class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mt-1.5 shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Payment pending</p>
                                <p class="text-xs text-gray-500 truncate">Invoice #INV-003 awaiting payment</p>
                                <p class="text-xs text-gray-400 mt-1">3 hours ago</p>
                            </div>
                        </a>
                        <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div class="w-2 h-2 bg-gray-300 rounded-full mt-1.5 shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">System update</p>
                                <p class="text-xs text-gray-500 truncate">Weekly report is ready for review</p>
                                <p class="text-xs text-gray-400 mt-1">Yesterday</p>
                            </div>
                        </a>
                    </div>
                    <a href="#"
                        class="block text-center text-sm text-indigo-600 hover:text-indigo-500 font-medium py-3 border-t border-gray-100">View
                        all notifications</a>
                </div>
            </div>

            <div class="relative">
                <button id="userMenuBtn"
                    class="flex items-center gap-3 text-gray-700 hover:text-gray-900 p-1.5 pr-3 rounded-lg hover:bg-gray-100 transition-colors">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-medium shadow-sm">
                        U</div>
                    <span class="hidden sm:block text-sm font-medium">User</span>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="userDropdown"
                    class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 z-50 overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="py-1">
                        <a href="{{ route('profile') }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </a>
                        <a href="{{ route('settings') }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Settings
                        </a>
                        <hr class="my-1 border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit"
                                class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>

                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="mainContent" class="pt-16 min-h-screen transition-all duration-300 main-content-expanded">
        <div class="p-6">
            @yield('content')
        </div>
    </div>

    @yield('footer-scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const topbar = document.getElementById('topbar');
            const toggleBtn = document.getElementById('sidebarToggle');
            const toggleIcon = document.getElementById('toggleIcon');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const userMenuBtn = document.getElementById('userMenuBtn');
            const userDropdown = document.getElementById('userDropdown');
            const notifBtn = document.getElementById('notifBtn');
            const notifDropdown = document.getElementById('notifDropdown');
            const overlay = document.getElementById('sidebarOverlay');

            let expanded = true;

            function updateLayout() {
                if (expanded) {
                    sidebar.classList.remove('sidebar-collapsed');
                    sidebar.classList.add('sidebar-expanded');
                    mainContent.classList.remove('main-content-collapsed');
                    mainContent.classList.add('main-content-expanded');
                    topbar.classList.remove('topbar-collapsed');
                    topbar.classList.add('topbar-expanded');
                    toggleIcon.style.transform = 'rotate(0deg)';
                } else {
                    sidebar.classList.remove('sidebar-expanded');
                    sidebar.classList.add('sidebar-collapsed');
                    mainContent.classList.remove('main-content-expanded');
                    mainContent.classList.add('main-content-collapsed');
                    topbar.classList.remove('topbar-expanded');
                    topbar.classList.add('topbar-collapsed');
                    toggleIcon.style.transform = 'rotate(180deg)';
                }
            }

            toggleBtn.addEventListener('click', function () {
                expanded = !expanded;
                updateLayout();
            });

            mobileMenuBtn.addEventListener('click', function () {
                sidebar.classList.toggle('mobile-open');
                overlay.classList.toggle('hidden');
            });

            overlay.addEventListener('click', function () {
                sidebar.classList.remove('mobile-open');
                overlay.classList.add('hidden');
            });

            userMenuBtn.addEventListener('click', function () {
                userDropdown.classList.toggle('hidden');
            });

            notifBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                notifDropdown.classList.toggle('hidden');
                userDropdown.classList.add('hidden');
            });

            document.addEventListener('click', function (e) {
                if (!userMenuBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                }
                if (!notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) {
                    notifDropdown.classList.add('hidden');
                }
            });

            function toggleSubmenu(item, open) {
                var submenu = item.nextElementSibling;
                var arrow = item.querySelector('.menu-arrow');
                if (open) {
                    submenu.classList.add('open');
                    if (arrow) arrow.classList.add('rotated');
                    item.classList.add('active');
                } else {
                    submenu.classList.remove('open');
                    if (arrow) arrow.classList.remove('rotated');
                    item.classList.remove('active');
                }
            }

            document.querySelectorAll('.sidebar-item[data-toggle]').forEach(function (item) {
                var isActive = item.getAttribute('data-active-route') === '1';
                if (isActive) {
                    toggleSubmenu(item, true);
                }

                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (!expanded) {
                        expanded = true;
                        updateLayout();
                    }
                    var submenu = item.nextElementSibling;
                    var currentlyOpen = submenu.classList.contains('open');
                    toggleSubmenu(item, !currentlyOpen);
                });
            });
        });
    </script>
</body>

</html>
