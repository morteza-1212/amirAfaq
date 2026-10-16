document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('chatbot-toggle');
    const close = document.getElementById('chatbot-close');
    const panel = document.getElementById('chatbot-panel');
    const form = document.getElementById('chatbot-form');
    const input = document.getElementById('chatbot-input');
    const messages = document.getElementById('chatbot-messages');
    const sendButton = document.getElementById('chatbot-send');

    if (!window.chatbotConfig) {
        console.warn('[chatbot] window.chatbotConfig not found');
        return;
    }

    let conversationStarted = false;
    let sending = false;

    const csrfToken = document.querySelector(
        'meta[name="csrf-token"]'
    )?.content;

    // =========================================================
    // افزودن پیام به صفحه
    // =========================================================
    function addMessage(content, sender = 'assistant') {
        const message = document.createElement('div');
        message.className = `chatbot-message ${sender}`;
        message.textContent = content;
        messages.appendChild(message);
        messages.scrollTop = messages.scrollHeight;
    }

    // =========================================================
    // درخواست JSON
    // =========================================================
    async function postJson(url, payload) {
        const response = await fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json().catch(() => ({}));

        // دیباگ - بعداً حذف کنید
        console.log('[chatbot]', url, response.status, data);

        if (!response.ok) {
            const err = new Error(data.message || `خطای سرور (${response.status})`);
            err.status = response.status;
            err.data = data;
            throw err;
        }

        return data;
    }

    // =========================================================
    // شروع مکالمه (یک‌بار)
    // =========================================================
    async function startConversation() {
        if (conversationStarted) return;

        await postJson(window.chatbotConfig.startUrl, {
            locale: window.chatbotConfig.locale
        });

        conversationStarted = true;
    }

    // =========================================================
    // باز/بسته کردن پنل
    // =========================================================
    toggle.addEventListener('click', async () => {
        const opening = panel.hidden;
        panel.hidden = !opening;
        toggle.setAttribute('aria-expanded', String(opening));

        if (!opening) return;

        input.focus();

        if (conversationStarted) return;

        try {
            await startConversation();
            addMessage(
                'سلام! به شرکت امیر آفاق گستر پارس خوش آمدید. چگونه می‌توانیم به شما کمک کنیم؟',
                'assistant'
            );
        } catch (error) {
            console.error('[chatbot] start error:', error);
            addMessage(
                'در حال حاضر امکان برقراری ارتباط وجود ندارد. لطفاً دوباره تلاش کنید.',
                'assistant'
            );
        }
    });

    close.addEventListener('click', () => {
        panel.hidden = true;
        toggle.setAttribute('aria-expanded', 'false');
    });

    // =========================================================
    // ارسال پیام
    // =========================================================
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const message = input.value.trim();
        if (!message || sending) return;

        sending = true;
        sendButton.disabled = true;

        addMessage(message, 'user');
        input.value = '';

        try {
            await startConversation();

            // ✅ فقط content را می‌فرستیم — همان چیزی که بک‌اند انتظار دارد
            const data = await postJson(
                window.chatbotConfig.sendUrl,
                { content: message }
            );

            // ✅ پاسخ سرور آرایه messages است
            if (Array.isArray(data.messages)) {
                data.messages.forEach((msg) => {
                    // پیام خود کاربر را دوباره نمایش نده
                    if (msg.sender_type === 'user') return;
                    addMessage(msg.content, msg.sender_type || 'assistant');
                });
            } else if (data.message) {
                addMessage(data.message, 'assistant');
            }
        } catch (error) {
            console.error('[chatbot] send error:', error);

            // پیام خطای دقیق‌تر برای دیباگ
            let userMsg = 'ارسال پیام با خطا مواجه شد. لطفاً دوباره تلاش کنید.';

            if (error.status === 419) {
                userMsg = 'نشست شما منقضی شده است. لطفاً صفحه را رفرش کنید.';
            } else if (error.status === 422) {
                userMsg = 'متن پیام نامعتبر است.';
            } else if (error.status === 500) {
                userMsg = 'خطای سرور. لطفاً بعداً تلاش کنید.';
            }

            addMessage(userMsg, 'assistant');
        } finally {
            sending = false;
            sendButton.disabled = false;
            input.focus();
        }
    });
});
