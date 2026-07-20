<span @class([
    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
    'bg-green-100 text-green-700' => $status === 'active',
    'bg-red-100 text-red-700' => $status === 'inactive',
])>{{ ucfirst($status) }}</span>
