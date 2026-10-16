{{-- resources/views/panelAdmin/support/chat.blade.php --}}

@extends('panelAdmin.layouts.panel')

@section('title', 'گفتگو با مشتری')

@section('styles')
<style>
    /* =========================================================
   SUPPORT PANEL - Chat Page Styles
   public/css/support/support.css
========================================================= */

    /* =========================================================
       ROOT VARIABLES
    ========================================================= */
    :root {
        --sp-primary: #1b361e;
        --sp-primary-dark: #132b17;
        --sp-primary-light: #2a4d2e;
        --sp-secondary: #d6a84f;
        --sp-secondary-dark: #b8902f;

        --sp-bg: #f5f6f3;
        --sp-card: #ffffff;
        --sp-light: #f7f8f4;
        --sp-border: rgba(27, 54, 30, .1);
        --sp-border-strong: rgba(27, 54, 30, .18);

        --sp-text: #26352a;
        --sp-text-soft: #4a5a4d;
        --sp-muted: #7a8a7d;

        --sp-success: #10b981;
        --sp-success-bg: #ecfdf5;
        --sp-danger: #ef4444;
        --sp-danger-bg: #fef2f2;
        --sp-warning: #f59e0b;
        --sp-warning-bg: #fffbeb;
        --sp-info: #3b82f6;
        --sp-info-bg: #eff6ff;

        --sp-radius-sm: 8px;
        --sp-radius: 12px;
        --sp-radius-lg: 18px;
        --sp-radius-xl: 24px;

        --sp-shadow-sm: 0 1px 3px rgba(0, 0, 0, .04);
        --sp-shadow: 0 4px 16px rgba(0, 0, 0, .06);
        --sp-shadow-lg: 0 12px 40px rgba(0, 0, 0, .1);

        --sp-transition: all .22s ease;
    }

    /* =========================================================
       RESET & BASE
       ========================================================= */
    .support-page * {
        box-sizing: border-box;
    }

    .support-page {
        font-family: 'Vazirmatn', Tahoma, Arial, sans-serif;
        color: var(--sp-text);
        padding: 24px;
        max-width: 1400px;
        margin: 0 auto;
        direction: rtl;
    }

    .support-page h1,
    .support-page h2,
    .support-page h3 {
        margin: 0;
        font-weight: 700;
        color: var(--sp-text);
    }

    .support-page p {
        margin: 0;
    }

    .support-page a {
        color: inherit;
        text-decoration: none;
    }

    /* =========================================================
       PAGE HEADER
       ========================================================= */
    .support-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 22px;
        padding: 18px 22px;
        background: var(--sp-card);
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-lg);
        box-shadow: var(--sp-shadow-sm);
    }

    .support-chat-title {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .support-chat-title h1 {
        font-size: 20px;
        line-height: 1.3;
        margin-bottom: 4px;
    }

    .support-chat-title p {
        font-size: 13px;
        color: var(--sp-muted);
        line-height: 1.6;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .support-back-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        border-radius: 50%;
        background: var(--sp-light);
        color: var(--sp-primary);
        font-size: 20px;
        transition: var(--sp-transition);
    }

    .support-back-button:hover {
        background: var(--sp-primary);
        color: #fff;
        transform: translateX(-2px);
    }

    /* =========================================================
       ALERTS
       ========================================================= */
    .support-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        margin-bottom: 18px;
        border-radius: var(--sp-radius);
        font-size: 14px;
        line-height: 1.7;
    }

    .support-alert i {
        font-size: 18px;
        flex-shrink: 0;
    }

    .support-alert ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .support-alert-success {
        background: var(--sp-success-bg);
        color: #065f46;
        border: 1px solid rgba(16, 185, 129, .2);
    }

    .support-alert-danger {
        background: var(--sp-danger-bg);
        color: #991b1b;
        border: 1px solid rgba(239, 68, 68, .2);
        align-items: flex-start;
    }

    .support-alert-danger i {
        margin-top: 2px;
    }

    .support-alert-danger ul li::before {
        content: '• ';
        color: var(--sp-danger);
    }

    /* =========================================================
       LAYOUT
       ========================================================= */
    .support-chat-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 22px;
        align-items: start;
    }

    /* =========================================================
       CHAT CARD
       ========================================================= */
    .support-chat-card {
        display: flex;
        flex-direction: column;
        background: var(--sp-card);
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-lg);
        box-shadow: var(--sp-shadow);
        overflow: hidden;
        min-height: 600px;
        max-height: calc(100vh - 200px);
    }

    .support-chat-card-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 20px;
        background: linear-gradient(135deg, var(--sp-primary) 0%, var(--sp-primary-dark) 100%);
        color: #fff;
        flex-shrink: 0;
    }

    .support-customer-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .support-chat-card-header h2 {
        font-size: 15px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 3px;
    }

    .support-chat-card-header span {
        font-size: 12px;
        color: rgba(255, 255, 255, .75);
        display: block;
    }

    .support-live-indicator {
        margin-right: auto;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 5px 12px;
        border-radius: 20px;
        background: rgba(255, 255, 255, .12);
        font-size: 12px;
        font-weight: 600;
        color: #fff;
    }

    .support-live-indicator > span {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #2ecc71;
        box-shadow: 0 0 0 2px rgba(46, 204, 113, .3);
        animation: spPulse 1.8s infinite;
    }

    @keyframes spPulse {
        0%, 100% { box-shadow: 0 0 0 2px rgba(46, 204, 113, .3); }
        50%      { box-shadow: 0 0 0 6px rgba(46, 204, 113, .05); }
    }

    /* =========================================================
       MESSAGES AREA
       ========================================================= */
    .support-messages {
        flex: 1;
        overflow-y: auto;
        padding: 22px 20px;
        background: var(--sp-light);
        display: flex;
        flex-direction: column;
        gap: 12px;
        scroll-behavior: smooth;
    }

    .support-messages::-webkit-scrollbar {
        width: 8px;
    }

    .support-messages::-webkit-scrollbar-track {
        background: transparent;
    }

    .support-messages::-webkit-scrollbar-thumb {
        background: rgba(27, 54, 30, .2);
        border-radius: 4px;
    }

    .support-messages::-webkit-scrollbar-thumb:hover {
        background: rgba(27, 54, 30, .35);
    }

    /* Date divider */
    .support-date-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 4px 0 8px;
        color: var(--sp-muted);
        font-size: 12px;
        font-weight: 600;
    }

    .support-date-divider::before,
    .support-date-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--sp-border);
    }

    .support-date-divider > span {
        padding: 4px 12px;
        background: rgba(27, 54, 30, .05);
        border-radius: 20px;
    }

    /* Empty state */
    .support-empty-chat {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 60px 20px;
        color: var(--sp-muted);
        text-align: center;
    }

    .support-empty-chat i {
        font-size: 48px;
        color: var(--sp-primary);
        opacity: .35;
    }

    .support-empty-chat p {
        font-size: 14px;
        line-height: 1.8;
    }

    /* Message bubbles (assuming partial produces .support-message) */
    .support-message {
        display: flex;
        gap: 10px;
        max-width: 78%;
        animation: spMsgIn .25s ease;
    }

    @keyframes spMsgIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .support-message-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: var(--sp-primary);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }

    .support-message-body {
        padding: 11px 15px;
        border-radius: 14px;
        font-size: 14px;
        line-height: 1.7;
        word-wrap: break-word;
        box-shadow: var(--sp-shadow-sm);
    }

    .support-message-time {
        display: block;
        margin-top: 5px;
        font-size: 10px;
        opacity: .6;
    }

    /* Visitor messages (incoming) */
    .support-message-visitor {
        align-self: flex-start;
    }

    .support-message-visitor .support-message-avatar {
        background: #e5e7eb;
        color: var(--sp-text);
    }

    .support-message-visitor .support-message-body {
        background: #fff;
        color: var(--sp-text);
        border-bottom-right-radius: 4px;
    }

    /* Agent messages (outgoing) */
    .support-message-agent {
        align-self: flex-end;
        flex-direction: row-reverse;
    }

    .support-message-agent .support-message-body {
        background: var(--sp-primary);
        color: #fff;
        border-bottom-left-radius: 4px;
    }

    /* Bot messages */
    .support-message-bot .support-message-avatar {
        background: var(--sp-secondary);
    }

    .support-message-bot .support-message-body {
        background: #fff;
        border: 1px dashed var(--sp-border-strong);
    }

    /* =========================================================
       REPLY AREA
       ========================================================= */
    .support-reply-area {
        flex-shrink: 0;
        padding: 16px 20px;
        background: #fff;
        border-top: 1px solid var(--sp-border);
    }

    .support-reply-alert {
        padding: 9px 14px;
        margin-bottom: 10px;
        border-radius: var(--sp-radius-sm);
        font-size: 13px;
        line-height: 1.7;
        background: var(--sp-info-bg);
        color: #1e40af;
        border: 1px solid rgba(59, 130, 246, .2);
    }

    .support-reply-alert[hidden] {
        display: none;
    }

    .support-reply-area form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .support-reply-area textarea {
        width: 100%;
        min-height: 90px;
        max-height: 220px;
        padding: 13px 16px;
        border: 1.5px solid var(--sp-border);
        border-radius: var(--sp-radius);
        background: var(--sp-light);
        color: var(--sp-text);
        font-family: inherit;
        font-size: 14px;
        line-height: 1.7;
        resize: vertical;
        outline: none;
        transition: var(--sp-transition);
    }

    .support-reply-area textarea:focus {
        border-color: var(--sp-primary);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(27, 54, 30, .08);
    }

    .support-reply-area textarea:disabled {
        background: #f3f4f6;
        color: var(--sp-muted);
        cursor: not-allowed;
    }

    .support-reply-area textarea::placeholder {
        color: #a0a8a2;
    }

    .support-reply-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .support-reply-footer > span {
        font-size: 12px;
        color: var(--sp-muted);
        line-height: 1.6;
    }

    .support-send-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        border: 0;
        border-radius: var(--sp-radius);
        background: var(--sp-primary);
        color: #fff;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: var(--sp-transition);
        box-shadow: 0 4px 12px rgba(27, 54, 30, .2);
    }

    .support-send-button:hover:not(:disabled) {
        background: var(--sp-primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(27, 54, 30, .28);
    }

    .support-send-button:active:not(:disabled) {
        transform: translateY(0);
    }

    .support-send-button:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        box-shadow: none;
        opacity: .7;
    }

    .support-send-button i {
        font-size: 16px;
    }

    /* =========================================================
       SIDEBAR
       ========================================================= */
    .support-chat-sidebar {
        display: flex;
        flex-direction: column;
        gap: 18px;
        position: sticky;
        top: 20px;
    }

    .support-sidebar-card {
        background: var(--sp-card);
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-lg);
        box-shadow: var(--sp-shadow-sm);
        padding: 18px 20px;
    }

    .support-sidebar-card h3 {
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 15px;
        padding-bottom: 12px;
        margin-bottom: 14px;
        border-bottom: 1px solid var(--sp-border);
        color: var(--sp-primary);
    }

    .support-sidebar-card h3 i {
        font-size: 18px;
    }

    .support-info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 9px 0;
        font-size: 13px;
        border-bottom: 1px dashed var(--sp-border);
    }

    .support-info-row:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .support-info-row > span {
        color: var(--sp-muted);
        flex-shrink: 0;
    }

    .support-info-row > strong {
        color: var(--sp-text);
        font-weight: 600;
        text-align: left;
        word-break: break-word;
    }

    .support-public-id {
        font-family: 'Courier New', monospace;
        font-size: 11px !important;
        color: var(--sp-primary) !important;
        background: rgba(27, 54, 30, .06);
        padding: 3px 8px;
        border-radius: 6px;
        direction: ltr;
        display: inline-block;
        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* =========================================================
       ACTION BUTTONS
       ========================================================= */
    .support-action-form {
        margin: 0;
    }

    .support-action-form + .support-action-form {
        margin-top: 10px;
    }

    .support-action-button {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 16px;
        border: 1.5px solid transparent;
        border-radius: var(--sp-radius);
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--sp-transition);
    }

    .support-action-button i {
        font-size: 16px;
    }

    .support-action-assign {
        background: rgba(27, 54, 30, .08);
        color: var(--sp-primary);
        border-color: rgba(27, 54, 30, .15);
    }

    .support-action-assign:hover {
        background: var(--sp-primary);
        color: #fff;
        border-color: var(--sp-primary);
        transform: translateY(-1px);
    }

    .support-action-close {
        background: var(--sp-success-bg);
        color: #065f46;
        border-color: rgba(16, 185, 129, .25);
    }

    .support-action-close:hover {
        background: var(--sp-success);
        color: #fff;
        border-color: var(--sp-success);
        transform: translateY(-1px);
    }

    .support-action-reopen {
        background: var(--sp-warning-bg);
        color: #92400e;
        border-color: rgba(245, 158, 11, .3);
    }

    .support-action-reopen:hover {
        background: var(--sp-warning);
        color: #fff;
        border-color: var(--sp-warning);
        transform: translateY(-1px);
    }

    /* =========================================================
       SIDEBAR NOTE
       ========================================================= */
    .support-sidebar-note {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px 16px;
        background: rgba(59, 130, 246, .06);
        border: 1px solid rgba(59, 130, 246, .15);
        border-radius: var(--sp-radius);
        color: #1e40af;
        font-size: 12px;
        line-height: 1.8;
    }

    .support-sidebar-note i {
        font-size: 18px;
        flex-shrink: 0;
        margin-top: 2px;
        color: var(--sp-info);
    }

    .support-sidebar-note p {
        margin: 0;
    }

    /* =========================================================
       STATUS BADGE (conversation-status partial)
    ========================================================= */
    .support-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .support-status-badge > span:first-child {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
        flex-shrink: 0;
    }

    .support-status-bot {
        background: rgba(59, 130, 246, .12);
        color: #1e40af;
    }

    .support-status-waiting_for_agent {
        background: rgba(245, 158, 11, .15);
        color: #92400e;
    }

    .support-status-assigned {
        background: rgba(16, 185, 129, .12);
        color: #065f46;
    }

    .support-status-closed {
        background: rgba(107, 114, 128, .12);
        color: #374151;
    }

    /* =========================================================
       RESPONSIVE
       ========================================================= */
    @media (max-width: 1199.98px) {
        .support-chat-layout {
            grid-template-columns: minmax(0, 1fr) 300px;
        }
    }

    @media (max-width: 991.98px) {
        .support-page {
            padding: 18px;
        }

        .support-chat-layout {
            grid-template-columns: 1fr;
        }

        .support-chat-card {
            max-height: none;
            min-height: 500px;
        }

        .support-chat-sidebar {
            position: static;
        }

        .support-chat-title h1 {
            font-size: 18px;
        }
    }

    @media (max-width: 767.98px) {
        .support-page {
            padding: 14px;
        }

        .support-page-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 14px 16px;
        }

        .support-chat-title h1 {
            font-size: 17px;
        }

        .support-chat-title p {
            white-space: normal;
        }

        .support-chat-card-header {
            padding: 13px 15px;
        }

        .support-customer-avatar {
            width: 40px;
            height: 40px;
            font-size: 18px;
        }

        .support-chat-card-header h2 {
            font-size: 14px;
        }

        .support-messages {
            padding: 16px 14px;
        }

        .support-message {
            max-width: 88%;
        }

        .support-reply-area {
            padding: 13px 14px;
        }

        .support-reply-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .support-reply-footer > span {
            text-align: center;
            order: 2;
        }

        .support-send-button {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 575.98px) {
        .support-sidebar-card {
            padding: 15px 16px;
        }

        .support-chat-title {
            gap: 10px;
        }

        .support-back-button {
            width: 38px;
            height: 38px;
            font-size: 18px;
        }

        .support-live-indicator {
            display: none;
        }

        .support-reply-area textarea {
            min-height: 80px;
            font-size: 13px;
        }

        .support-info-row {
            font-size: 12px;
        }

        .support-public-id {
            max-width: 140px;
        }
    }

    /* =========================================================
       REDUCED MOTION
       ========================================================= */
    @media (prefers-reduced-motion: reduce) {
        .support-page *,
        .support-page *::before,
        .support-page *::after {
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: .01ms !important;
        }
    }
</style>
@endsection

@section('content')
    <div class="support-page support-chat-page">

        {{-- سربرگ --}}
        <div class="support-page-header support-chat-header">
            <div class="support-chat-title">
                <a href="{{ route('admin.support.index') }}"
                   class="support-back-button"
                   aria-label="بازگشت به فهرست مکالمات">
                    <i class="bi bi-arrow-right"></i>
                </a>

                <div>
                    <h1>گفتگو با مشتری</h1>
                    <p>
                        مکالمه #{{ $conversation->id }}
                        · شناسه:
                        {{ $conversation->public_id }}
                    </p>
                </div>
            </div>

            <div id="supportChatStatus">
                @include(
                    'panelAdmin.chatbot.support.partials.conversation-status',
                    ['status' => $conversation->status]
                )
            </div>
        </div>

        @if(session('success'))
            <div class="support-alert support-alert-success">
                <i class="bi bi-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="support-alert support-alert-danger">
                <i class="bi bi-exclamation-circle"></i>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="support-chat-layout">

            {{-- پنجره گفتگو --}}
            <section class="support-chat-card">

                <div class="support-chat-card-header">
                    <div class="support-customer-avatar">
                        <i class="bi bi-person"></i>
                    </div>

                    <div>
                        <h2>بازدیدکننده سایت</h2>
                        <span id="supportConnectionStatus">
                        تاریخچه مکالمه
                    </span>
                    </div>

                    <div class="support-live-indicator">
                        <span></span>
                        گفتگو
                    </div>
                </div>

                {{-- پیام‌ها --}}
                <div id="supportMessages"
                     class="support-messages"
                     data-after-id="{{ $messages->max('id') ?? 0 }}">

                    <div class="support-date-divider">
                        <span>تاریخچه گفتگو</span>
                    </div>

                    @forelse($messages as $message)
                        @include(
                            'panelAdmin.chatbot.support.partials.message',
                            ['message' => $message]
                        )
                    @empty
                        <div class="support-empty-chat">
                            <i class="bi bi-chat-dots"></i>
                            <p>هنوز پیامی در این مکالمه ثبت نشده است.</p>
                        </div>
                    @endforelse
                </div>

                {{-- فرم ارسال پاسخ --}}
                <div class="support-reply-area">
                    <div id="supportReplyAlert"
                         class="support-reply-alert"
                         role="status"
                         aria-live="polite"
                         hidden></div>

                    <form id="supportReplyForm"
                          action="{{ route('admin.support.reply', $conversation) }}"
                          method="POST"
                          data-url="{{ route('admin.support.reply', $conversation) }}">

                        @csrf

                        <label for="supportReplyInput" class="visually-hidden">
                            متن پاسخ کارشناس
                        </label>

                        <textarea id="supportReplyInput"
                                  name="content"
                                  rows="3"
                                  maxlength="5000"
                                  placeholder="پاسخ خود را بنویسید..."
                                  required
                              {{ $conversation->status === 'closed' ? 'disabled' : '' }}></textarea>

                        <div class="support-reply-footer">
                        <span>
                            پاسخ شما مستقیماً برای بازدیدکننده ارسال می‌شود.
                        </span>

                            <button type="submit"
                                    id="supportReplyButton"
                                    class="support-send-button"
                                {{ $conversation->status === 'closed' ? 'disabled' : '' }}>
                                <i class="bi bi-send"></i>
                                ارسال پاسخ
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            {{-- اطلاعات و عملیات مکالمه --}}
            <aside class="support-chat-sidebar">

                <div class="support-sidebar-card">
                    <h3>
                        <i class="bi bi-info-circle"></i>
                        اطلاعات مکالمه
                    </h3>

                    <div class="support-info-row">
                        <span>شناسه</span>
                        <strong>#{{ $conversation->id }}</strong>
                    </div>

                    <div class="support-info-row">
                        <span>شناسه عمومی</span>
                        <strong class="support-public-id">
                            {{ $conversation->public_id }}
                        </strong>
                    </div>

                    <div class="support-info-row">
                        <span>زبان گفتگو</span>
                        <strong>
                            @switch($conversation->locale)
                                @case('fa')
                                    فارسی
                                    @break

                                @case('en')
                                    English
                                    @break

                                @case('ar')
                                    العربية
                                    @break

                                @default
                                    {{ $conversation->locale }}
                            @endswitch
                        </strong>
                    </div>

                    <div class="support-info-row">
                        <span>شروع مکالمه</span>
                        <strong>
                            {{ $conversation->created_at?->format('Y/m/d H:i') ?? '—' }}
                        </strong>
                    </div>

                    <div class="support-info-row">
                        <span>آخرین فعالیت</span>
                        <strong>
                            {{ $conversation->last_message_at
                                ? \Illuminate\Support\Carbon::parse(
                                    $conversation->last_message_at
                                )->format('Y/m/d H:i')
                                : '—' }}
                        </strong>
                    </div>
                </div>

                <div class="support-sidebar-card">
                    <h3>
                        <i class="bi bi-gear"></i>
                        مدیریت مکالمه
                    </h3>

                    {{-- اختصاص مکالمه به کارشناس فعلی --}}
                    @if($conversation->status !== 'closed')
                        <form action="{{ route('admin.support.assign', $conversation) }}"
                              method="POST"
                              class="support-action-form">
                            @csrf

                            <button type="submit"
                                    class="support-action-button support-action-assign">
                                <i class="bi bi-person-check"></i>
                                اختصاص به من
                            </button>
                        </form>
                    @endif

                    {{-- بستن مکالمه --}}
                    @if($conversation->status !== 'closed')
                        <form action="{{ route('admin.support.close', $conversation) }}"
                              method="POST"
                              class="support-action-form"
                              onsubmit="return confirm('آیا از بستن این مکالمه مطمئن هستید؟')">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="support-action-button support-action-close">
                                <i class="bi bi-check2-circle"></i>
                                بستن مکالمه
                            </button>
                        </form>
                    @else
                        {{-- بازگشایی مکالمه --}}
                        <form action="{{ route('admin.support.reopen', $conversation) }}"
                              method="POST"
                              class="support-action-form">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="support-action-button support-action-reopen">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                بازگشایی مکالمه
                            </button>
                        </form>
                    @endif
                </div>

                <div class="support-sidebar-note">
                    <i class="bi bi-shield-check"></i>

                    <p>
                        اطلاعات این گفتگو فقط باید در اختیار کاربران مجاز پنل
                        پشتیبانی قرار داشته باشد.
                    </p>
                </div>

            </aside>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        window.supportChatConfig = {
            messagesUrl: @json(route('admin.support.messages', $conversation)),
            initialAfterId: {{ (int) ($messages->max('id') ?? 0) }},
            status: @json($conversation->status),
            csrfToken: @json(csrf_token()),
            closed: @json($conversation->status === 'closed')
        };
    </script>

    <script src="{{ asset('js/panelAdmin/support/support-chat.js') }}?v=2" defer></script>
@endsection
