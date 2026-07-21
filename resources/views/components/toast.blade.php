@props([
    'position' => 'top-right',
])

<div
    id="toast-container"
    class="fixed z-[9999] flex flex-col gap-3 pointer-events-none
        {{ match($position) {
            'top-right' => 'top-5 right-5',
            'top-left' => 'top-5 left-5',
            'bottom-left' => 'bottom-5 left-5',
            default => 'bottom-5 right-5',
        } }}"
>
    @foreach (['success', 'error', 'warning', 'info'] as $type)
        @if (session($type))
            @php
                $configs = [
                    'success' => [
                        'bg' => 'bg-emerald-50',
                        'border' => 'border-emerald-200',
                        'text' => 'text-emerald-800',
                        'progress' => 'bg-emerald-500',
                        'icon' => '<svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    ],
                    'error' => [
                        'bg' => 'bg-red-50',
                        'border' => 'border-red-200',
                        'text' => 'text-red-800',
                        'progress' => 'bg-red-500',
                        'icon' => '<svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    ],
                    'warning' => [
                        'bg' => 'bg-amber-50',
                        'border' => 'border-amber-200',
                        'text' => 'text-amber-800',
                        'progress' => 'bg-amber-500',
                        'icon' => '<svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
                    ],
                    'info' => [
                        'bg' => 'bg-blue-50',
                        'border' => 'border-blue-200',
                        'text' => 'text-blue-800',
                        'progress' => 'bg-blue-500',
                        'icon' => '<svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    ],
                ];
                $cfg = $configs[$type];
            @endphp
            <div
                data-auto-dismiss
                class="pointer-events-auto flex items-start gap-3 w-80 px-4 py-3 rounded-xl border shadow-lg relative overflow-hidden {{ $cfg['bg'] }} {{ $cfg['border'] }} {{ $cfg['text'] }} toast-enter"
                style="position: relative;"
            >
                <span class="mt-0.5 shrink-0">{!! $cfg['icon'] !!}</span>
                <p class="text-sm font-medium flex-1 pt-0.5">{{ session($type) }}</p>
                <button
                    class="shrink-0 mt-0.5 text-current opacity-40 hover:opacity-100 transition-opacity cursor-pointer dismiss-btn"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <div class="absolute bottom-0 left-0 h-0.5 rounded-b-xl {{ $cfg['progress'] }} toast-progress" style="width: 100%;"></div>
            </div>
        @endif
    @endforeach
</div>

<style>
    @keyframes toast-in {
        from { opacity: 0; transform: translateX(100%); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes toast-out {
        from { opacity: 1; transform: translateX(0); }
        to { opacity: 0; transform: translateX(100%); }
    }
    @keyframes toast-progress {
        from { width: 100%; }
        to { width: 0%; }
    }
    .toast-enter { animation: toast-in 0.3s ease forwards; }
    .toast-exit { animation: toast-out 0.3s ease forwards; }
    .toast-progress { animation: toast-progress 5s linear forwards; }
</style>

<script>
    (function () {
        var container = document.getElementById('toast-container');
        if (!container) return;

        function setupAutoDismiss(toast) {
            var progressBar = toast.querySelector('.toast-progress');
            var timer = setTimeout(function () { dismissToast(toast); }, 5000);

            toast.addEventListener('mouseenter', function () {
                clearTimeout(timer);
                var computed = getComputedStyle(progressBar);
                var current = parseFloat(computed.width);
                var parent = parseFloat(getComputedStyle(progressBar.parentElement).width) || 320;
                progressBar.style.animationPlayState = 'paused';
                toast._remaining = (current / parent) * 5000;
            });

            toast.addEventListener('mouseleave', function () {
                progressBar.style.animationPlayState = 'running';
                timer = setTimeout(function () { dismissToast(toast); }, toast._remaining || 2000);
            });

            toast.querySelector('.dismiss-btn').addEventListener('click', function () {
                clearTimeout(timer);
                dismissToast(toast);
            });
        }

        function dismissToast(toast) {
            if (!toast || toast.classList.contains('toast-exit')) return;
            toast.style.animationPlayState = 'running';
            toast.classList.remove('toast-enter');
            toast.classList.add('toast-exit');
            setTimeout(function () { toast.remove(); }, 300);
        }

        container.querySelectorAll('[data-auto-dismiss]').forEach(setupAutoDismiss);

        window.showToast = function (message, type) {
            var configs = {
                success: { bg: 'bg-emerald-50', border: 'border-emerald-200', text: 'text-emerald-800', progress: 'bg-emerald-500', icon: '<svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' },
                error: { bg: 'bg-red-50', border: 'border-red-200', text: 'text-red-800', progress: 'bg-red-500', icon: '<svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' },
                warning: { bg: 'bg-amber-50', border: 'border-amber-200', text: 'text-amber-800', progress: 'bg-amber-500', icon: '<svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>' },
                info: { bg: 'bg-blue-50', border: 'border-blue-200', text: 'text-blue-800', progress: 'bg-blue-500', icon: '<svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' },
            };
            type = type || 'info';
            var cfg = configs[type] || configs.info;

            var toast = document.createElement('div');
            toast.setAttribute('data-auto-dismiss', '');
            toast.className = 'pointer-events-auto flex items-start gap-3 w-80 px-4 py-3 rounded-xl border shadow-lg relative overflow-hidden ' + cfg.bg + ' ' + cfg.border + ' ' + cfg.text + ' toast-enter';
            toast.style.position = 'relative';
            toast.innerHTML =
                '<span class="mt-0.5 shrink-0">' + cfg.icon + '</span>' +
                '<p class="text-sm font-medium flex-1 pt-0.5">' + message + '</p>' +
                '<button class="shrink-0 mt-0.5 text-current opacity-40 hover:opacity-100 transition-opacity cursor-pointer dismiss-btn">' +
                    '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>' +
                '</button>' +
                '<div class="absolute bottom-0 left-0 h-0.5 rounded-b-xl ' + cfg.progress + ' toast-progress" style="width: 100%;"></div>';

            container.appendChild(toast);
            setupAutoDismiss(toast);
        };

        window.dismissToast = dismissToast;
    })();
</script>
