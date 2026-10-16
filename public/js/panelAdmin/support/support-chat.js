(function () {
    'use strict';

    const config = window.supportChatConfig || {};
    if (!config.messagesUrl) return;

    const messagesEl = document.getElementById('supportMessages');
    const inputEl    = document.getElementById('supportReplyInput');
    const sendBtn    = document.getElementById('supportReplyButton');
    const form       = document.getElementById('supportReplyForm');

    if (!messagesEl || !inputEl || !sendBtn) return;

    let lastMessageId = Number(messagesEl.dataset.afterId || 0);
    let sending       = false;
    let closed        = !!config.closed;

    /* =====================================================
       SCROLL
    ===================================================== */
    function scrollToBottom() {
        requestAnimationFrame(() => {
            messagesEl.scrollTop = messagesEl.scrollHeight;
        });
    }

    /* =====================================================
       STRUCTURE OF A MESSAGE BUBBLE
    ===================================================== */
    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str == null ? '' : String(str);
        return div.innerHTML;
    }

    function formatTime(iso) {
        if (!iso) return '';
        const d = new Date(iso);
        if (isNaN(d.getTime())) return '';
        const hh = String(d.getHours()).padStart(2, '0');
        const mm = String(d.getMinutes()).padStart(2, '0');
        return `${hh}:${mm}`;
    }

    function createMessageElement(message) {
        // type: visitor | agent | bot
        const type = (message.sender_type || 'visitor').toLowerCase();

        const wrapper = document.createElement('div');
        wrapper.className = 'support-message support-message-' + type;
        wrapper.dataset.messageId = message.id;

        const avatar = document.createElement('div');
        avatar.className = 'support-message-avatar';
        avatar.innerHTML = type === 'agent'
            ? '<i class="bi bi-headset"></i>'
            : (type === 'bot'
                ? '<i class="bi bi-robot"></i>'
                : '<i class="bi bi-person"></i>');

        const body = document.createElement('div');
        body.className = 'support-message-body';

        const textNode = document.createElement('span');
        textNode.innerHTML = escapeHtml(message.content).replace(/\n/g, '<br>');
        body.appendChild(textNode);

        const time = document.createElement('span');
        time.className = 'support-message-time';
        time.textContent = formatTime(message.created_at);
        body.appendChild(time);

        wrapper.appendChild(avatar);
        wrapper.appendChild(body);
        return wrapper;
    }

    /* =====================================================
       ADD MESSAGE (dedupe by id)
    ===================================================== */
    function appendMessage(message) {
        if (!message || message.id == null) return false;

        const id = Number(message.id);
        if (id <= lastMessageId) return false;

        // حذف placeholder
        const empty = messagesEl.querySelector('.support-empty-chat');
        if (empty) empty.remove();

        messagesEl.appendChild(createMessageElement(message));
        lastMessageId = id;
        return true;
    }

    /* =====================================================
       FETCH NEW MESSAGES (POLLING)
    ===================================================== */
    async function loadMessages() {
        try {
            const url = new URL(config.messagesUrl, window.location.origin);
            url.searchParams.set('after_id', lastMessageId);

            const res = await fetch(url, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!res.ok) return;

            const data = await res.json();
            const list = Array.isArray(data.messages) ? data.messages : [];

            let added = false;
            list.forEach(m => {
                if (appendMessage(m)) added = true;
            });

            if (added) scrollToBottom();

            // به‌روزرسانی وضعیت
            if (data.status && data.status !== config.status) {
                config.status = data.status;
                closed = (data.status === 'closed');
                updateStatusBadge(data.status);
                updateComposerState();
            }

        } catch (err) {
            console.error('[support-chat] poll error:', err);
        }
    }

    /* =====================================================
       STATUS BADGE (اختیاری، اگر id خاصی دارید)
    ===================================================== */
    function updateStatusBadge(status) {
        const el = document.getElementById('supportChatStatus');
        if (!el) return;

        // اگر partial را دارید، دوباره از سرور نمی‌گیریم؛ فقط کلاس عوض می‌کنیم
        // اگر می‌خواهید متن دقیق partial باشد، از سرور بگیرید:
        // (برای سادگی فقط کلاس عوض می‌کنیم)
        el.querySelectorAll('.support-status-badge').forEach(n => n.remove());
        const labels = {
            bot: 'ربات',
            waiting_for_agent: 'در انتظار کارشناس',
            assigned: 'در حال پاسخگویی',
            closed: 'بسته شده'
        };
        const badge = document.createElement('span');
        badge.className = 'support-status-badge support-status-' + status;
        badge.innerHTML = '<span></span>' + (labels[status] || status);
        el.appendChild(badge);
    }

    function updateComposerState() {
        if (closed) {
            inputEl.disabled = true;
            sendBtn.disabled = true;
            inputEl.placeholder = 'این مکالمه بسته شده است.';
        } else {
            inputEl.disabled = false;
            sendBtn.disabled = false;
        }
    }

    /* =====================================================
       SEND REPLY
    ===================================================== */
    async function sendReply(e) {
        if (e) e.preventDefault();
        if (sending || closed) return;

        const text = inputEl.value.trim();
        if (!text) return;

        sending = true;
        sendBtn.disabled = true;

        const alertEl = document.getElementById('supportReplyAlert');
        if (alertEl) { alertEl.hidden = true; alertEl.textContent = ''; }

        try {
            const fd = new FormData();
            fd.append('_token',  config.csrfToken);
            fd.append('content', text);

            const res = await fetch(form.action, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: fd
            });

            const data = await res.json().catch(() => ({}));

            if (!res.ok) {
                throw new Error(data.message || 'ارسال پیام ناموفق بود.');
            }

            // پاک کردن ورودی و افزودن پیام
            inputEl.value = '';

            if (data.message) {
                // اگر سرور پیام را برگرداند، همان را append می‌کنیم
                appendMessage(data.message);
            } else {
                // در غیر این صورت، از سرور دوباره می‌گیریم
                await loadMessages();
            }

            scrollToBottom();

            // به‌روزرسانی وضعیت اگر تغییر کرده باشد
            if (data.status && data.status !== config.status) {
                config.status = data.status;
                updateStatusBadge(data.status);
            }

        } catch (err) {
            console.error('[support-chat] send error:', err);
            if (alertEl) {
                alertEl.textContent = err.message || 'خطا در ارسال پیام.';
                alertEl.hidden = false;
            }
        } finally {
            sending = false;
            if (!closed) sendBtn.disabled = false;
            inputEl.focus();
        }
    }

    /* =====================================================
       EVENTS
    ===================================================== */
    if (form) {
        form.addEventListener('submit', sendReply);
    } else {
        sendBtn.addEventListener('click', sendReply);
    }

    inputEl.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendReply();
        }
    });

    /* =====================================================
       POLLING: هر ۳ ثانیه
    ===================================================== */
    scrollToBottom();

    let timer = null;
    function startPolling() {
        if (timer) return;
        timer = setInterval(() => {
            if (!document.hidden) loadMessages();
        }, 3000);
    }

    function stopPolling() {
        if (timer) {
            clearInterval(timer);
            timer = null;
        }
    }

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopPolling();
        } else {
            // به‌محض بازگشت به تب، یک‌بار پیام‌ها را بگیر
            loadMessages();
            startPolling();
        }
    });

    // شروع اولیه
    loadMessages();
    startPolling();

})();
