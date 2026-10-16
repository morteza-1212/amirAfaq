<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>چت پشتیبانی شرکت</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root{
            --bg: #FFF8F0;
            --panel: #FFFFFF;
            --ink: #2B2A33;
            --ink-soft: #8A8794;
            --coral: #FF6F5E;
            --coral-dark: #E8543F;
            --mint: #CDECD9;
            --mint-ink: #1E5B3E;
            --line: #F0E7DB;
            --radius: 18px;
        }
        *{box-sizing:border-box;}
        body{
            margin:0;
            font-family:'Vazirmatn', sans-serif;
            background: var(--bg);
            color: var(--ink);
            display:flex;
            align-items:center;
            justify-content:center;
            min-height:100vh;
            padding:24px;
        }

        /* ---------- ظرف اصلی چت ---------- */
        .chat-card{
            width:100%;
            max-width:420px;
            height:640px;
            background: var(--panel);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(43,42,51,0.12);
            display:flex;
            flex-direction:column;
            overflow:hidden;
            border:1px solid var(--line);
        }

        .chat-header{
            background: linear-gradient(135deg, var(--coral), var(--coral-dark));
            color:#fff;
            padding:18px 20px;
            display:flex;
            align-items:center;
            gap:12px;
        }
        .chat-header .avatar{
            width:40px;height:40px;border-radius:50%;
            background:rgba(255,255,255,.2);
            display:flex;align-items:center;justify-content:center;
            font-size:20px;
        }
        .chat-header .titles{flex:1;}
        .chat-header h1{margin:0;font-size:15px;font-weight:700;}
        .chat-header .status{
            font-size:12px;
            opacity:.9;
            display:flex;align-items:center;gap:6px;
        }
        .chat-header .status .dot{
            width:7px;height:7px;border-radius:50%;
            background:#8CFFB0;
            box-shadow:0 0 0 3px rgba(140,255,176,.25);
        }
        .status.pending .dot{background:#FFD98C;box-shadow:0 0 0 3px rgba(255,217,140,.25);}

        /* ---------- بدنه پیام‌ها ---------- */
        .chat-body{
            flex:1;
            overflow-y:auto;
            padding:18px;
            display:flex;
            flex-direction:column;
            gap:14px;
            background:
                radial-gradient(circle at 20% 10%, #fff 0%, var(--bg) 60%);
        }
        .chat-body::-webkit-scrollbar{width:6px;}
        .chat-body::-webkit-scrollbar-thumb{background:var(--line);border-radius:10px;}

        .row{display:flex;flex-direction:column;max-width:80%;}
        .row.from-customer{align-self:flex-start;align-items:flex-start;}
        .row.from-bot, .row.from-agent{align-self:flex-end;align-items:flex-end;}

        .sender-label{
            font-size:11px;
            color: var(--ink-soft);
            margin:0 6px 4px;
            display:flex;align-items:center;gap:5px;
        }
        .sender-label .badge{
            font-size:10px;
            padding:1px 7px;
            border-radius:20px;
            font-weight:600;
        }
        .badge.bot{background:#EAF4FF;color:#2E6FB8;}
        .badge.agent{background:var(--mint);color:var(--mint-ink);}

        .bubble{
            padding:10px 14px;
            line-height:1.9;
            font-size:14px;
            word-break:break-word;
        }
        .from-customer .bubble{
            background: var(--coral);
            color:#fff;
            border-radius: var(--radius) var(--radius) var(--radius) 4px;
        }
        .from-bot .bubble{
            background:#F2F2F5;
            color:var(--ink);
            border-radius: var(--radius) var(--radius) 4px var(--radius);
        }
        .from-agent .bubble{
            background: var(--mint);
            color:var(--mint-ink);
            border-radius: var(--radius) var(--radius) 4px var(--radius);
        }

        .time{
            font-size:10px;
            color:var(--ink-soft);
            margin:4px 6px 0;
        }

        /* حالت در حال تایپ */
        .typing .bubble{display:flex;gap:4px;align-items:center;padding:12px 16px;}
        .typing .bubble span{
            width:6px;height:6px;border-radius:50%;
            background:var(--ink-soft);
            animation: bounce 1.2s infinite ease-in-out;
        }
        .typing .bubble span:nth-child(2){animation-delay:.15s;}
        .typing .bubble span:nth-child(3){animation-delay:.3s;}
        @keyframes bounce{0%,60%,100%{transform:translateY(0);opacity:.5;}30%{transform:translateY(-4px);opacity:1;}}

        /* ---------- ورودی پیام ---------- */
        .chat-input{
            display:flex;
            gap:8px;
            padding:14px;
            border-top:1px solid var(--line);
            background:#fff;
        }
        .chat-input input{
            flex:1;
            border:1px solid var(--line);
            background: var(--bg);
            border-radius: 14px;
            padding:12px 14px;
            font-family:inherit;
            font-size:14px;
            outline:none;
            transition:border-color .15s;
        }
        .chat-input input:focus{border-color:var(--coral);}
        .chat-input button{
            width:44px;height:44px;
            border:none;
            border-radius:14px;
            background: var(--coral);
            color:#fff;
            font-size:18px;
            cursor:pointer;
            transition:transform .12s, background .15s;
            flex-shrink:0;
        }
        .chat-input button:hover{background:var(--coral-dark);}
        .chat-input button:active{transform:scale(.92);}
    </style>
</head>
<body>

<div class="chat-card">
    <div class="chat-header">
        <div class="avatar">🧸</div>
        <div class="titles">
            <h1>پشتیبانی فروشگاه کودک و نوجوان</h1>
            <div class="status" id="statusLine">
                <span class="dot"></span>
                <span id="statusText">دستیار هوشمند آنلاین است</span>
            </div>
        </div>
    </div>

    <div class="chat-body" id="chatBody"></div>

    <form class="chat-input" id="chatForm">
        <input type="text" id="messageInput" placeholder="پیام خود را بنویسید..." autocomplete="off">
        <button type="submit" aria-label="ارسال">➤</button>
    </form>
</div>

<script>
    /* =====================================================================
       این بخش، معادل جاوااسکریپت صفحهٔ Blade شماست (مثلاً resources/views/chat/show.blade.php).
       برای اتصال واقعی به Laravel Reverb/Echo، بخش‌های SIMULATION را با
       کدهای Echo.private(...) که قبلاً نوشتیم جایگزین کنید.
       ===================================================================== */

    const chatBody = document.getElementById('chatBody');
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const statusLine = document.getElementById('statusLine');
    const statusText = document.getElementById('statusText');

    // شناسه‌های نمونه — در پروژهٔ واقعی این‌ها از Blade پاس داده می‌شوند
    const conversationId = 123;
    const csrfToken = 'CSRF_TOKEN_HERE';

    /**
     * تابع اصلی رندر یک پیام در صفحه.
     * message = { sender_type: 'customer' | 'bot' | 'agent', body, created_at }
     */
    function appendMessage(message) {
        const row = document.createElement('div');
        row.className = `row from-${message.sender_type}`;

        // برچسب فرستنده فقط برای bot و agent نشان داده می‌شود
        if (message.sender_type !== 'customer') {
            const label = document.createElement('div');
            label.className = 'sender-label';
            const badge = message.sender_type === 'bot'
                ? '<span class="badge bot">دستیار هوشمند</span>'
                : '<span class="badge agent">پشتیبان انسانی</span>';
            label.innerHTML = badge;
            row.appendChild(label);
        }

        const bubble = document.createElement('div');
        bubble.className = 'bubble';
        bubble.textContent = message.body; // textContent برای جلوگیری از XSS

        const time = document.createElement('div');
        time.className = 'time';
        time.textContent = formatTime(message.created_at);

        row.appendChild(bubble);
        row.appendChild(time);
        chatBody.appendChild(row);

        scrollToBottom();
    }

    function formatTime(iso) {
        const d = iso ? new Date(iso) : new Date();
        return d.toLocaleTimeString('fa-IR', { hour: '2-digit', minute: '2-digit' });
    }

    function scrollToBottom() {
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    /* ---------- نشانگر «در حال تایپ» هنگام انتظار برای پاسخ AI ---------- */
    function showTyping() {
        const row = document.createElement('div');
        row.className = 'row from-bot typing';
        row.id = 'typingIndicator';
        row.innerHTML = `<div class="bubble"><span></span><span></span><span></span></div>`;
        chatBody.appendChild(row);
        scrollToBottom();
    }
    function hideTyping() {
        const el = document.getElementById('typingIndicator');
        if (el) el.remove();
    }

    /* ---------- بارگذاری تاریخچهٔ مکالمه هنگام باز شدن صفحه ---------- */
    async function loadHistory() {
        try {
            // در Laravel واقعی: GET /chat/{conversation}/messages
            const res = await fetch(`/chat/${conversationId}/messages`, {
                headers: { 'Accept': 'application/json' }
            });
            if (!res.ok) throw new Error('خطا در دریافت پیام‌ها');
            const messages = await res.json();
            messages.forEach(appendMessage);
        } catch (e) {
            // SIMULATION: چون بک‌اند واقعی متصل نیست، یک پیام خوش‌آمد نمایش می‌دهیم
            appendMessage({
                sender_type: 'bot',
                body: 'سلام! 👋 من دستیار هوشمند فروشگاه هستم. دربارهٔ سایزبندی، ارسال یا مرجوعی سوال دارید؟',
                created_at: new Date().toISOString()
            });
        }
    }

    /* ---------- ارسال پیام ---------- */
    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const text = messageInput.value.trim();
        if (!text) return;

        appendMessage({ sender_type: 'customer', body: text, created_at: new Date().toISOString() });
        messageInput.value = '';
        showTyping();

        try {
            // در Laravel واقعی همان fetch قبلی شماست:
            const res = await fetch(`/chat/${conversationId}/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ body: text })
            });
            if (!res.ok) throw new Error('failed');
            // پاسخ واقعی از طریق کانال Echo (پایین صفحه) دریافت می‌شود، نه از این fetch
        } catch (err) {
            // SIMULATION: چون سرور واقعی وصل نیست، خودمان پاسخ نمایشی می‌دهیم
            setTimeout(() => {
                hideTyping();
                const needsHuman = /مرجوع|عودت|شکایت/.test(text);
                if (needsHuman) {
                    setStatus('waiting');
                    appendMessage({
                        sender_type: 'bot',
                        body: 'در حال انتقال شما به پشتیبانی انسانی هستیم، لطفاً چند لحظه صبر کنید 🙏',
                        created_at: new Date().toISOString()
                    });
                } else {
                    appendMessage({
                        sender_type: 'bot',
                        body: 'برای اطلاع از راهنمای سایزبندی می‌توانید به صفحهٔ «راهنمای سایز» در فوتر سایت مراجعه کنید.',
                        created_at: new Date().toISOString()
                    });
                }
            }, 900);
        }
    });

    function setStatus(state) {
        if (state === 'waiting') {
            statusLine.classList.add('pending');
            statusText.textContent = 'در حال اتصال به پشتیبان انسانی...';
        } else if (state === 'agent') {
            statusLine.classList.remove('pending');
            statusText.textContent = 'یک پشتیبان انسانی به شما وصل شد';
        } else {
            statusLine.classList.remove('pending');
            statusText.textContent = 'دستیار هوشمند آنلاین است';
        }
    }

    /* =====================================================================
       اتصال واقعی به Laravel Echo / Reverb (کد شما) — این بخش را در
       پروژهٔ واقعی از حالت کامنت خارج کنید:

       Echo.private(`conversation.${conversationId}`)
           .listen('MessageSent', (e) => {
               hideTyping();
               appendMessage(e.message);
               if (e.message.sender_type === 'agent') setStatus('agent');
           })
           .listen('AgentAssigned', () => {
               setStatus('agent');
           });
       ===================================================================== */

    loadHistory();
</script>
</body>
</html>
