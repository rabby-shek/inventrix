@props([
    'id' => 'confirm-modal',
    'title' => 'Confirm Action',
    'message' => 'Are you sure you want to proceed?',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'type' => 'danger',
])

<div id="{{ $id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" data-confirm-overlay></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md transform transition-all">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                @if ($type === 'danger')
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                @elseif ($type === 'warning')
                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                @else
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                @endif
                <div>
                    <h3 class="text-base font-semibold text-gray-900">{{ $title }}</h3>
                </div>
            </div>
            <button data-confirm-close class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-5 py-5">
            <p class="text-sm text-gray-600 leading-relaxed">{{ $message }}</p>
        </div>
        <div class="px-5 py-3 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-3 rounded-b-2xl">
            <button data-confirm-close
                class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-white bg-white transition-colors cursor-pointer">
                {{ $cancelText }}
            </button>
            <button data-confirm-action
                class="px-4 py-2 rounded-lg text-sm font-medium text-white transition-colors cursor-pointer
                    {{ $type === 'danger' ? 'bg-red-600 hover:bg-red-700' : ($type === 'warning' ? 'bg-amber-600 hover:bg-amber-700' : 'bg-indigo-600 hover:bg-indigo-700') }}">
                {{ $confirmText }}
            </button>
        </div>
    </div>
</div>

<script>
    (function () {
        var modal = document.getElementById('{{ $id }}');
        if (!modal) return;

        function openConfirmModal(callback) {
            modal._callback = callback;
            modal.classList.remove('hidden');
            document.body.classList.add('modal-blur');
        }

        function closeConfirmModal() {
            modal.classList.add('hidden');
            document.body.classList.remove('modal-blur');
            modal._callback = null;
        }

        modal.querySelectorAll('[data-confirm-close]').forEach(function (el) {
            el.addEventListener('click', closeConfirmModal);
        });

        modal.querySelector('[data-confirm-overlay]').addEventListener('click', closeConfirmModal);

        modal.querySelector('[data-confirm-action]').addEventListener('click', function () {
            if (typeof modal._callback === 'function') {
                modal._callback();
            }
            closeConfirmModal();
        });

        document.addEventListener('keydown', function (e) {
            if (!modal.classList.contains('hidden') && e.key === 'Escape') {
                closeConfirmModal();
            }
        });

        window.{{ $id }} = { open: openConfirmModal, close: closeConfirmModal };
    })();
</script>
