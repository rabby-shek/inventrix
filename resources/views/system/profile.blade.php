@extends('layouts.panel')

@section('title', 'Profile - Inventrix')
@section('page-title', 'My Profile')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-8 pt-8 pb-6 text-center">
                <div class="w-24 h-24 bg-indigo-500 rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto">U</div>
                <h2 class="text-lg font-semibold text-gray-900 mt-4">{{ auth()->user()->name }}</h2>
                <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                <div class="mt-4 flex items-center justify-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">{{ ucfirst(auth()->user()->status) }}</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700">{{ ucfirst(auth()->user()->role) }}</span>
                </div>
            </div>
            <div class="px-8 pb-6 border-b border-gray-100">
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span class="text-gray-600">{{ auth()->user()->email }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span class="text-gray-600">{{ auth()->user()->phone ?? 'Not provided' }}</span>
                    </div>
                </div>
            </div>
            <div class="px-8 py-6">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Activity</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-green-500 rounded-full mt-1.5 shrink-0"></div>
                        <div>
                            <p class="text-sm text-gray-900">Logged in</p>
                            <p class="text-xs text-gray-400">Just now</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-1.5 shrink-0"></div>
                        <div>
                            <p class="text-sm text-gray-900">Updated profile settings</p>
                            <p class="text-xs text-gray-400">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-1.5 shrink-0"></div>
                        <div>
                            <p class="text-sm text-gray-900">Created purchase order PO-2026-0042</p>
                            <p class="text-xs text-gray-400">5 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-amber-500 rounded-full mt-1.5 shrink-0"></div>
                        <div>
                            <p class="text-sm text-gray-900">Approved expense report #EXP-2026-0089</p>
                            <p class="text-xs text-gray-400">Yesterday</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-1.5 shrink-0"></div>
                        <div>
                            <p class="text-sm text-gray-900">Added new user Sarah Wilson</p>
                            <p class="text-xs text-gray-400">2 days ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <form action="{{ route('system.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-8 py-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">Personal Information</h2>
                <p class="text-sm text-gray-500 mt-1">Update your personal details and contact information.</p>
            </div>
            <div class="px-8 py-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ auth()->user()->name ?? "" }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ auth()->user()->email ?? "" }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="{{ auth()->user()->phone ?? "" }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white">
                    </div>


                </div>

            </div>
            <div class="px-8 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-3 rounded-b-xl">
                <button class="px-5 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-white transition-colors bg-white">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">Save Changes</button>
            </div>
        </div>
        </form>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-8 py-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">Change Password</h2>
                <p class="text-sm text-gray-500 mt-1">Ensure your account is secure with a strong password.</p>
            </div>
            <div class="px-8 py-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Current Password</label>
                        <input type="password" placeholder="Enter current password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label>
                        <input type="password" placeholder="Enter new password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm New Password</label>
                        <input type="password" placeholder="Confirm new password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white">
                    </div>
                </div>
            </div>
            <div class="px-8 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-3 rounded-b-xl">
                <button class="px-5 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">Update Password</button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-8 py-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">Profile Picture</h2>
                <p class="text-sm text-gray-500 mt-1">Update your profile photo.</p>
            </div>
            <div class="px-8 py-6">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 bg-indigo-500 rounded-full flex items-center justify-center text-white text-2xl font-bold shrink-0">U</div>
                    <div>
                        <button class="px-5 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">Upload Photo</button>
                        <p class="text-xs text-gray-500 mt-2">JPG, PNG or GIF. Max 2MB.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
