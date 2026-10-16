@php
    $senderLabels = [
        'user' => 'مشتری',
        'assistant' => 'چت‌بات',
        'agent' => 'کارشناس پشتیبانی',
        'system' => 'سیستم',
    ];

    $senderClasses = [
        'user' => 'message-user',
        'assistant' => 'message-assistant',
        'agent' => 'message-agent',
        'system' => 'message-system',
    ];

    $senderType = $message->sender_type ?? 'system';
@endphp

<div class="support-message-row {{ $senderClasses[$senderType] ?? 'message-system' }}"
     data-message-id="{{ $message->id }}">

    <div class="support-message-avatar">
        @if($senderType === 'user')
            <i class="bi bi-person"></i>
        @elseif($senderType === 'agent')
            <i class="bi bi-headset"></i>
        @elseif($senderType === 'assistant')
            <i class="bi bi-robot"></i>
        @else
            <i class="bi bi-info-circle"></i>
        @endif
    </div>

    <div class="support-message-content">
        <div class="support-message-meta">
            <strong>
                {{ $senderLabels[$senderType] ?? 'سیستم' }}
            </strong>

            <time>
                {{ $message->created_at?->format('Y/m/d H:i') ?? '' }}
            </time>
        </div>

        <div class="support-message-bubble">
            {!! nl2br(e($message->content)) !!}
        </div>
    </div>
</div>
