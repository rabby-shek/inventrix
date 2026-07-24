<div id="sidebarOverlay" class="hidden fixed inset-0 bg-black/50 z-40 md:hidden"></div>

<aside id="sidebar"
    class="fixed top-0 left-0 h-full bg-white border-r border-gray-200 z-50 transition-all duration-300 sidebar-expanded flex flex-col">
    <div class="h-16 flex items-center px-4 border-b border-gray-200">
        <div class="flex items-center gap-3 flex-1">
            <div
                class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center text-white font-bold text-sm shrink-0">
                I</div>
            <span class="logo-text text-lg font-bold text-gray-900">Inventrix</span>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-4 px-3">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('dashboard') }}" data-tooltip="Dashboard"
                    class="sidebar-item sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <li>
                <button
                    class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors w-full text-left"
                    data-toggle="inventory" data-tooltip="Inventory"
                    data-active-route="{{ request()->routeIs('inventory.products') || request()->routeIs('inventory.products.*') || request()->routeIs('inventory.categories') || request()->routeIs('inventory.brands') || request()->routeIs('inventory.stock') || request()->routeIs('inventory.stock.*') || request()->routeIs('inventory.warehouses') || request()->routeIs('inventory.warehouses.*') || request()->routeIs('inventory.stock-adjustments') || request()->routeIs('inventory.stock-adjustments.*') ? '1' : '0' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="menu-text flex-1">Inventory</span>
                    <svg class="menu-arrow w-4 h-4 shrink-0 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <ul class="sidebar-submenu ml-5 mt-1 space-y-1">
                    <li>
                        <a href="{{ route('inventory.products') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('inventory.products*') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('inventory.categories') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('inventory.categories') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Categories</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('inventory.brands') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('inventory.brands') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Brands</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('inventory.stock') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('inventory.stock') || request()->routeIs('inventory.stock.*') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Stock</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('inventory.warehouses') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('inventory.warehouses') || request()->routeIs('inventory.warehouses.*') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Warehouses</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('inventory.stock-adjustments') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('inventory.stock-adjustments') || request()->routeIs('inventory.stock-adjustments.*') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Stock Adjustments</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <button
                    class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors w-full text-left"
                    data-toggle="sales" data-tooltip="Sales"
                    data-active-route="{{ request()->routeIs('orders') || request()->routeIs('invoices') || request()->routeIs('returns') || request()->routeIs('shipments') ? '1' : '0' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span class="menu-text flex-1">Sales</span>
                    <svg class="menu-arrow w-4 h-4 shrink-0 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <ul class="sidebar-submenu ml-5 mt-1 space-y-1">
                    <li>
                        <a href="{{ route('orders') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('orders') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('invoices') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('invoices') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Invoices</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('returns') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('returns') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Returns</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shipments') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('shipments') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Shipments</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <button
                    class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors w-full text-left"
                    data-toggle="purchase" data-tooltip="Purchases"
                    data-active-route="{{ request()->routeIs('purchase-orders') || request()->routeIs('suppliers') ? '1' : '0' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                    </svg>
                    <span class="menu-text flex-1">Purchases</span>
                    <svg class="menu-arrow w-4 h-4 shrink-0 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <ul class="sidebar-submenu ml-5 mt-1 space-y-1">
                    <li>
                        <a href="{{ route('purchase-orders') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('purchase-orders') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Purchase Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('suppliers') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('suppliers') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Suppliers</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <button
                    class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors w-full text-left"
                    data-toggle="people" data-tooltip="People"
                    data-active-route="{{ request()->routeIs('customers') || request()->routeIs('suppliers') ? '1' : '0' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="menu-text flex-1">People</span>
                    <svg class="menu-arrow w-4 h-4 shrink-0 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <ul class="sidebar-submenu ml-5 mt-1 space-y-1">
                    <li>
                        <a href="{{ route('customers') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('customers') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Customers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('suppliers') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('suppliers') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Suppliers</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <button
                    class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors w-full text-left"
                    data-toggle="finance" data-tooltip="Finance"
                    data-active-route="{{ request()->routeIs('expenses') || request()->routeIs('payments') || request()->routeIs('reports') || request()->routeIs('tax-rates') ? '1' : '0' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="menu-text flex-1">Finance</span>
                    <svg class="menu-arrow w-4 h-4 shrink-0 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <ul class="sidebar-submenu ml-5 mt-1 space-y-1">
                    <li>
                        <a href="{{ route('expenses') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('expenses') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Expenses</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('payments') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('payments') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Payments</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('reports') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Reports</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tax-rates') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('tax-rates') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Tax Rates</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <hr class="border-gray-200 my-3">
            </li>

            <li>
                <button
                    class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors w-full text-left"
                    data-toggle="user-management" data-tooltip="User Management"
                    data-active-route="{{ request()->routeIs('users') || request()->routeIs('roles') ? '1' : '0' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="menu-text flex-1">User Management</span>
                    <svg class="menu-arrow w-4 h-4 shrink-0 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <ul class="sidebar-submenu ml-5 mt-1 space-y-1">
                    <li>
                        <a href="{{ route('users') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('users') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('roles') }}"
                            class="submenu-item flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 text-sm transition-colors {{ request()->routeIs('roles') ? '!text-indigo-600 !bg-indigo-50' : '' }}">
                            <span class="w-1.5 h-1.5 bg-gray-300 rounded-full shrink-0"></span>
                            <span class="submenu-text">Roles</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('activity-log') }}" data-tooltip="Activity Log"
                    class="sidebar-item sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors {{ request()->routeIs('activity-log') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="menu-text">Activity Log</span>
                </a>
            </li>

            <li>
                <a href="{{ route('settings') }}" data-tooltip="Settings"
                    class="sidebar-item sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors {{ request()->routeIs('settings') ? 'active' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="menu-text">Settings</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="p-3 border-t border-gray-200">
        <button id="sidebarToggle" data-tooltip="Collapse"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors w-full">
            <svg id="toggleIcon" class="w-5 h-5 shrink-0 transition-transform duration-300" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
            <span class="menu-text text-sm">Collapse</span>
        </button>
        <div class="flex items-center gap-3 px-3 py-2 mt-1">
            <div
                class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center text-white text-sm font-medium shrink-0">
                U
            </div>
            <div class="sidebar-footer-text overflow-hidden">
                <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name ?? "" }}</p>
                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email ?? "" }}</p>
            </div>
        </div>
    </div>
</aside>
