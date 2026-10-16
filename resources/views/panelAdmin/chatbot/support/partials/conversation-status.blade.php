@php
    $statusLabels = [
        'bot' => 'پاسخ‌گویی خودکار',
        'waiting_for_agent' => 'منتظر کارشناس',
        'assigned' => 'اختصاص‌یافته',
        'closed' => 'بسته‌شده',
    ];

    $statusClasses = [
        'bot' => 'status-bot',
        'waiting_for_agent' => 'status-waiting',
        'assigned' => 'status-assigned',
        'closed' => 'status-closed',
    ];
@endphp

<span class="support-status {{ $statusClasses[$status] ?? 'status-unknown' }}">
    <span class="support-status-dot"></span>

    {{ $statusLabels[$status] ?? $status }}
</span>
