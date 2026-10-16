<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>پنل پشتیبانی —  امیر آفاق گستر پارس</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #F6F3EE;
            --panel: #fff;
            --ink: #2B2A33;
            --ink-soft: #8A8794;
            --coral: #ff9900;
            --coral-dark: #e88a00;
            --mint: #CDECD9;
            --mint-ink: #1E5B3E;
            --line: #EAE3D8;
            --danger: #e1306c;
            --success: #2ecc71;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Vazirmatn', sans-serif;
            background: var(--bg);
            color: var(--ink);
            height: 100vh;
            overflow: hidden;
        }
        .app { display: flex; height: 100vh; }

        /* ---------- ستون لیست مکالمه‌ها ---------- */
        .sidebar {
            width: 320px; flex-shrink: 0; background: var(--panel);
            border-left: 1px solid var(--line); display: flex; flex-direction: column;
        }
        .sidebar-header { padding: 18px 20px; border-bottom: 1px solid var(--line); }
        .sidebar-header h1 { margin: 0 0 4px; font-size: 17px; display:flex; align-items:center; }
        .sidebar-header p { margin: 0; font-size: 12px; color: var(--ink-soft); }
        .online-status {
            display: inline-block; width: 8px; height: 8px; border-radius: 50%;
            background: var(--success); margin-left: 6px;
        }

        .section-title {
            padding: 14px 20px 6px; font-size: 12px; font-weight: 700; color: var(--ink-soft);
            display: flex; align-items: center; justify-content: space-between;
        }
        .section-title .count {
            background: var(--danger); color: #fff; border-radius: 20px; font-size: 10px; padding: 1px 7px;
        }

        .conv-list { overflow-y: auto; flex: 1; min-height: 150px; }
        .conv-item {
            padding: 12px 20px; cursor: pointer; border-bottom: 1px solid var(--line);
            display: flex; flex-direction: column; gap: 3px; transition: background .12s; position: relative;
        }
        .conv-item:hover { background: #FBF7F0; }
        .conv-item.active { background: #FFF3E0; border-right: 3px solid var(--coral); }
        .conv-item .name { font-size: 13.5px; font-weight: 600; }
        .conv-item .preview {
            font-size: 12px; color: var(--ink-soft);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .conv-item .time-ago { font-size: 10px; color: var(--ink-soft); margin-top: 4px; }
        .conv-item .claim-btn {
            margin-top: 6px; align-self: flex-start; background: var(--coral); color: #fff;
            border: none; border-radius: 8px; font-size: 11.5px; padding: 5px 12px;
            cursor: pointer; transition: background .15s;
        }
        .conv-item .claim-btn:hover { background: var(--coral-dark); }
        .empty-note { padding: 20px; color: var(--ink-soft); font-size: 12.5px; text-align: center; }

        /* ---------- پنل اصلی چت ---------- */
        .main { flex: 1; display: flex; flex-direction: column; }
        .main-header {
            padding: 16px 24px; background: var(--panel); border-bottom: 1px solid var(--line);
            display: flex; align-items: center; justify-content: space-between;
        }
        .main-header h2 { margin: 0; font-size: 15px; display: flex; align-items: center; gap: 8px; }
        .main-header .customer-status { font-size: 12px; color: var(--ink-soft); font-weight: 400; }
        .main-header .close-btn {
            background: #F1EEEA; border: none; border-radius: 8px; padding: 7px 14px;
            font-size: 12.5px; cursor: pointer; color: var(--ink); transition: background .15s;
        }
        .main-header .close-btn:hover { background: var(--line); }

        .main-body {
            flex: 1; overflow-y: auto; padding: 20px; display: flex;
            flex-direction: column; gap: 14px; background: #FAF8F5;
        }
        .placeholder { margin: auto; color: var(--ink-soft); font-size: 14px; text-align: center; }

        .row { display: flex; flex-direction: column; max-width: 70%; animation: fadeIn .3s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px);} to { opacity: 1; transform: translateY(0);} }
        .row.customer { align-self: flex-start; }
        .row.bot, .row.agent { align-self: flex-end; align-items: flex-end; }
        .sender-label { font-size: 11px; color: var(--ink-soft); margin: 0 6px 4px; }
        .bubble { padding: 10px 14px; line-height: 1.9; font-size: 14px; word-break: break-word; }
        .row.customer .bubble { background: #F1EEEA; border-radius: 16px 16px 16px 4px; }
        .row.bot .bubble { background: #EAF4FF; color: #2E6FB8; border-radius: 16px 16px 4px 16px; }
        .row.agent .bubble { background: var(--mint); color: var(--mint-ink); border-radius: 16px 16px 4px 16px; }
        .time { font-size: 10px; color: var(--ink-soft); margin: 4px 6px 0; }

        .main-input { display: flex; gap: 10px; padding: 16px 20px; background: var(--panel); border-top: 1px solid var(--line); }
        .main-input input {
            flex: 1; border: 1px solid var(--line); background: var(--bg); border-radius: 12px;
            padding: 12px 14px; font-family: inherit; font-size: 14px; outline: none; transition: border-color .15s;
        }
        .main-input input:focus { border-color: var(--coral); }
        .main-input input:disabled { opacity: .5; cursor: not-allowed; }
        .main-input button {
            padding: 0 22px; border: none; border-radius: 12px; background: var(--coral);
            color: #fff; font-size: 14px; cursor: pointer; transition: background .15s;
        }
        .main-input button:hover { background: var(--coral-dark); }
        .main-input button:disabled { opacity: .5; cursor: not-allowed; }
        .main-input.disabled { opacity: .5; pointer-events: none; }

        .conv-list::-webkit-scrollbar, .main-body::-webkit-scrollbar { width: 4px; }
        .conv-list::-webkit-scrollbar-track, .main-body::-webkit-scrollbar-track { background: transparent; }
        .conv-list::-webkit-scrollbar-thumb, .main-body::-webkit-scrollbar-thumb { background: var(--line); border-radius: 10px; }

        @media (max-width: 768px) { .sidebar { width: 260px; } .row { max-width: 85%; } }
        @media (max-width: 576px) {
            .app { flex-direction: column; }
            .sidebar { width: 100%; height: 40vh; border-left: none; border-bottom: 1px solid var(--line); }
            .main { height: 60vh; }
        }
    </style>
</head>
<body>

<div class="app">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h1><span class="online-status"></span> پنل پشتیبانی</h1>
            <p>خوش آمدید، {{ auth()->user()->user_name }}</p>
        </div>

        <div class="section-title">
            در انتظار پاسخ
            <span class="count" id="waitingCount">{{ $waiting->count() }}</span>
        </div>
        <div class="conv-list" id="waitingList">
            @forelse($waiting as $conv)
                <div class="conv-item" data-id="{{ $conv->id }}" data-mode="waiting">
                    <span class="name">{{ $conv->customer->user_name ?? 'مشتری' }}</span>
                    <span class="preview">{{ $conv->messages->first()?->body ?? 'در انتظار پشتیبان...' }}</span>
                    <span class="time-ago">{{ $conv->created_at->diffForHumans() }}</span>
                    <button class="claim-btn" data-claim="{{ $conv->id }}">گرفتن این مکالمه</button>
                </div>
            @empty
                <div class="empty-note" id="waitingEmptyNote">فعلاً مکالمهٔ در انتظاری نیست.</div>
            @endforelse
        </div>

        <div class="section-title">مکالمه‌های من</div>
        <div class="conv-list" id="mineList">
            @forelse($mine as $conv)
                <div class="conv-item" data-id="{{ $conv->id }}" data-mode="mine">
                    <span class="name">{{ $conv->customer->user_name ?? 'مشتری' }}</span>
                    <span class="preview">{{ $conv->messages->first()?->body ?? 'در حال گفتگو' }}</span>
                    <span class="time-ago">{{ $conv->updated_at->diffForHumans() }}</span>
                </div>
            @empty
                <div class="empty-note">مکالمهٔ فعالی ندارید.</div>
            @endforelse
        </div>
    </aside>

    <main class="main">
        <div class="main-header" id="mainHeader" style="display:none;">
            <h2>
                <span id="customerName"></span>
                <span class="customer-status" id="customerStatus">آنلاین</span>
            </h2>
            <button class="close-btn" id="closeConvBtn">پایان گفتگو</button>
        </div>
        <div class="main-body" id="mainBody">
            <div class="placeholder">یک مکالمه را از لیست سمت راست انتخاب کنید</div>
        </div>
        <div class="main-input disabled" id="mainInputWrap">
            <input type="text" id="messageInput" placeholder="پاسخ خود را بنویسید..." disabled>
            <button id="sendBtn" disabled>ارسال</button>
        </div>
    </main>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        /* =========================================================
           تنظیمات اولیه
           ========================================================= */
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let activeConversationId = null;
        let lastMessageId = 0;
        let messagePollTimer = null;
        let waitingPollTimer = null;
        let knownWaitingIds = new Set(
            $('#waitingList .conv-item').map(function () { return String($(this).data('id')); }).get()
        );

        const mainHeader   = $('#mainHeader');
        const customerName = $('#customerName');
        const mainBody     = $('#mainBody');
        const inputWrap    = $('#mainInputWrap');
        const messageInput = $('#messageInput');
        const sendBtn      = $('#sendBtn');
        const closeBtn     = $('#closeConvBtn');
        const waitingList  = $('#waitingList');
        const mineList     = $('#mineList');
        const waitingCount = $('#waitingCount');

        const MESSAGE_POLL_MS = 2500;   // فاصلهٔ چک پیام‌های جدید مکالمهٔ باز
        const WAITING_POLL_MS = 5000;   // فاصلهٔ چک مکالمه‌های جدید در انتظار

        /* =========================================================
           توابع کمکی نمایش
           ========================================================= */
        function formatTime(iso) {
            if (!iso) return '';
            return new Date(iso).toLocaleTimeString('fa-IR', { hour: '2-digit', minute: '2-digit' });
        }
        function getSenderLabel(type) {
            return { customer: 'مشتری', agent: 'پشتیبان', bot: 'دستیار هوشمند' }[type] || type;
        }
        function scrollToBottom() {
            mainBody.scrollTop(mainBody[0].scrollHeight);
        }
        function appendMessage(message) {
            const row = $('<div>').addClass(`row ${message.sender_type}`);
            if (message.sender_type !== 'customer') {
                row.append($('<div>').addClass('sender-label').text(getSenderLabel(message.sender_type)));
            }
            row.append($('<div>').addClass('bubble').text(message.body));
            row.append($('<div>').addClass('time').text(formatTime(message.created_at)));
            mainBody.append(row);
            scrollToBottom();
        }

        /* =========================================================
           باز کردن یک مکالمه + شروع polling پیام‌های آن
           ========================================================= */
        async function openConversation(id, name) {
            stopMessagePolling();

            activeConversationId = id;
            lastMessageId = 0;
            mainHeader.show();
            customerName.text(name || ('مکالمه #' + id));
            inputWrap.removeClass('disabled');
            messageInput.prop('disabled', false);
            sendBtn.prop('disabled', false);
            mainBody.html('');

            await fetchNewMessages(true);
            highlightActive(id);
            startMessagePolling();
        }

        function highlightActive(id) {
            $('.conv-item').removeClass('active');
            $(`.conv-item[data-id="${id}"]`).addClass('active');
        }

        /* =========================================================
           گرفتن پیام‌های جدیدتر از lastMessageId (polling)
           initialLoad=true یعنی اولین بارگذاری کامل مکالمه است
           ========================================================= */
        async function fetchNewMessages(initialLoad = false) {
            if (!activeConversationId) return;

            try {
                const url = `/admin/chat/${activeConversationId}/messages?after_id=${lastMessageId}`;
                const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                if (!res.ok) return;

                const messages = await res.json();

                if (initialLoad && messages.length === 0) {
                    mainBody.html('<div class="placeholder">هنوز پیامی در این مکالمه ثبت نشده</div>');
                    return;
                }
                if (initialLoad) mainBody.html('');

                messages.forEach(msg => {
                    appendMessage(msg);
                    if (msg.id > lastMessageId) lastMessageId = msg.id;
                });

                // به‌روزرسانی پیش‌نمایش در سایدبار
                if (messages.length > 0) {
                    const last = messages[messages.length - 1];
                    $(`.conv-item[data-id="${activeConversationId}"] .preview`).text(last.body);
                }
            } catch (e) {
                console.error('خطا در دریافت پیام‌های جدید:', e);
            }
        }

        function startMessagePolling() {
            stopMessagePolling();
            messagePollTimer = setInterval(() => fetchNewMessages(false), MESSAGE_POLL_MS);
        }
        function stopMessagePolling() {
            if (messagePollTimer) { clearInterval(messagePollTimer); messagePollTimer = null; }
        }

        /* =========================================================
           ارسال پاسخ اپراتور
           ========================================================= */
        async function sendMessage() {
            const text = messageInput.val().trim();
            if (!text || !activeConversationId) return;

            messageInput.val('').prop('disabled', true);
            sendBtn.prop('disabled', true);

            // نمایش خوش‌بینانه (Optimistic UI)
            appendMessage({ sender_type: 'agent', body: text, created_at: new Date().toISOString() });

            try {
                const res = await fetch(`/admin/chat/${activeConversationId}/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ body: text })
                });

                if (!res.ok) {
                    const err = await res.json().catch(() => ({}));
                    throw new Error(err.error || 'خطا در ارسال پیام');
                }

                const data = await res.json();
                // با این id، در poll بعدی همین پیام دوباره اضافه نمی‌شود
                if (data.message && data.message.id > lastMessageId) {
                    lastMessageId = data.message.id;
                }
            } catch (err) {
                appendMessage({
                    sender_type: 'bot',
                    body: '❌ ارسال پیام با خطا مواجه شد: ' + err.message,
                    created_at: new Date().toISOString()
                });
                console.error('Send error:', err);
            } finally {
                messageInput.prop('disabled', false);
                sendBtn.prop('disabled', false);
                messageInput.focus();
            }
        }

        /* =========================================================
           claim کردن یک مکالمهٔ در انتظار
           ========================================================= */
        async function claimConversation(id, itemEl) {
            try {
                const res = await fetch(`/admin/chat/${id}/claim`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });

                if (res.status === 409) {
                    alert('این مکالمه قبلاً توسط اپراتور دیگری گرفته شد.');
                    itemEl.remove();
                    knownWaitingIds.delete(String(id));
                    updateWaitingCount();
                    return;
                }
                if (!res.ok) {
                    const err = await res.json().catch(() => ({}));
                    throw new Error(err.error || 'خطا در گرفتن مکالمه');
                }

                const name = itemEl.find('.name').text();
                const preview = itemEl.find('.preview').text();

                itemEl.remove();
                knownWaitingIds.delete(String(id));
                updateWaitingCount();

                const mineItem = $(`
                <div class="conv-item" data-id="${id}" data-mode="mine">
                    <span class="name">${name}</span>
                    <span class="preview">${preview}</span>
                    <span class="time-ago">هم‌اکنون</span>
                </div>
            `);
                mineList.prepend(mineItem);

                await openConversation(id, name);
            } catch (err) {
                alert(err.message || 'خطا در گرفتن مکالمه. دوباره تلاش کنید.');
                console.error('Claim error:', err);
            }
        }

        function updateWaitingCount() {
            const count = waitingList.find('.conv-item').length;
            waitingCount.text(count);
            if (count === 0 && !$('#waitingEmptyNote').length) {
                waitingList.append('<div class="empty-note" id="waitingEmptyNote">فعلاً مکالمهٔ در انتظاری نیست.</div>');
            }
        }

        /* =========================================================
           Polling لیست «در انتظار پاسخ» — جایگزین کامل Echo/AgentNeeded
           ========================================================= */
        async function pollWaitingList() {
            try {
                const res = await fetch('/admin/chat/waiting-list', { headers: { 'Accept': 'application/json' } });
                if (!res.ok) return;
                const list = await res.json();

                list.forEach(conv => {
                    const id = String(conv.id);
                    if (knownWaitingIds.has(id)) return; // قبلاً نمایش داده شده

                    knownWaitingIds.add(id);
                    $('#waitingEmptyNote').remove();

                    const item = $(`
                    <div class="conv-item" data-id="${conv.id}" data-mode="waiting">
                        <span class="name">${conv.customer_name}</span>
                        <span class="preview">${conv.last_message ?? 'در انتظار پشتیبان...'}</span>
                        <span class="time-ago">هم‌اکنون</span>
                        <button class="claim-btn" data-claim="${conv.id}">گرفتن این مکالمه</button>
                    </div>
                `);
                    waitingList.prepend(item);
                    updateWaitingCount();

                    // نوتیفیکیشن مرورگر + صدا (اختیاری، اگر فایل صوتی/مجوز موجود نباشد بی‌صدا رد می‌شود)
                    if (window.Notification && Notification.permission === 'granted') {
                        new Notification('مکالمه جدید', { body: `${conv.customer_name} درخواست پشتیبانی دارد.` });
                    }
                });
            } catch (e) {
                console.error('خطا در polling لیست در انتظار:', e);
            }
        }

        function startWaitingPolling() {
            pollWaitingList();
            waitingPollTimer = setInterval(pollWaitingList, WAITING_POLL_MS);
        }

        /* =========================================================
           بستن مکالمه
           ========================================================= */
        async function closeConversation() {
            if (!activeConversationId) return;
            if (!confirm('این مکالمه بسته شود؟')) return;

            try {
                const res = await fetch(`/admin/chat/${activeConversationId}/close`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
                });
                if (!res.ok) throw new Error('خطا در بستن مکالمه');

                $(`.conv-item[data-id="${activeConversationId}"]`).remove();
                stopMessagePolling();
                activeConversationId = null;
                mainHeader.hide();
                mainBody.html('<div class="placeholder">یک مکالمه را از لیست سمت راست انتخاب کنید</div>');
                inputWrap.addClass('disabled');
                messageInput.prop('disabled', true);
                sendBtn.prop('disabled', true);
            } catch (err) {
                alert(err.message);
            }
        }

        /* =========================================================
           رویدادها
           ========================================================= */
        sendBtn.on('click', sendMessage);
        messageInput.on('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
        });
        closeBtn.on('click', closeConversation);

        waitingList.on('click', '[data-claim]', function (e) {
            e.stopPropagation();
            claimConversation($(this).data('claim'), $(this).closest('.conv-item'));
        });
        mineList.on('click', '.conv-item', function () {
            openConversation($(this).data('id'), $(this).find('.name').text());
        });

        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }

        // متوقف کردن polling وقتی تب مخفی است، برای صرفه‌جویی در منابع
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                stopMessagePolling();
            } else if (activeConversationId) {
                startMessagePolling();
            }
        });

        /* =========================================================
           شروع کار
           ========================================================= */
        startWaitingPolling();

        const firstMine = mineList.find('.conv-item:first');
        if (firstMine.length) {
            openConversation(firstMine.data('id'), firstMine.find('.name').text());
        }
    });
</script>
</body>
</html>
