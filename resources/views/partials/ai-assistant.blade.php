{{-- ============================================ --}}
{{-- AI ASSISTANT FLOATING CHAT --}}
{{-- ============================================ --}}

<style>
    /* Tombol floating */
    .ai-fab {
        position: fixed;
        bottom: 24px;
        right: 24px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: #fff;
        border: none;
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        cursor: pointer;
        z-index: 9998;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .ai-fab:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 24px rgba(0, 123, 255, 0.6);
    }
    .ai-fab.active {
        background: linear-gradient(135deg, #dc3545, #a71d2a);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
    }

    /* Panel chat */
    .ai-panel {
        position: fixed;
        bottom: 96px;
        right: 24px;
        width: 380px;
        height: 560px;
        max-height: calc(100vh - 120px);
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 12px 48px rgba(0, 0, 0, 0.18);
        display: none;
        flex-direction: column;
        overflow: hidden;
        z-index: 9999;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    .ai-panel.open {
        display: flex;
        animation: aiSlideUp 0.25s ease-out;
    }
    @keyframes aiSlideUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Header */
    .ai-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: #fff;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
    }
    .ai-header-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        font-size: 15px;
    }
    .ai-header-title .ai-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #4ade80;
        box-shadow: 0 0 8px #4ade80;
    }
    .ai-close {
        background: transparent;
        border: none;
        color: #fff;
        font-size: 22px;
        cursor: pointer;
        line-height: 1;
        padding: 0 4px;
        opacity: 0.85;
    }
    .ai-close:hover { opacity: 1; }

    /* Body */
    .ai-body {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        background: #f2f6fa;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .ai-body::-webkit-scrollbar { width: 6px; }
    .ai-body::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    /* Bubble */
    .ai-msg {
        display: flex;
        gap: 8px;
        align-items: flex-end;
        max-width: 100%;
    }
    .ai-msg.user { justify-content: flex-end; }
    .ai-msg .ai-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #007bff;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    .ai-msg .ai-bubble {
        max-width: 78%;
        padding: 10px 14px;
        border-radius: 16px;
        font-size: 13.5px;
        line-height: 1.5;
        white-space: pre-wrap;
        word-wrap: break-word;
    }
    .ai-msg.assistant .ai-bubble {
        background: #fff;
        color: #1f2d3d;
        border: 1px solid #e3ebf3;
        border-bottom-left-radius: 4px;
    }
    .ai-msg.user .ai-bubble {
        background: #007bff;
        color: #fff;
        border-bottom-right-radius: 4px;
    }

    /* Typing indicator */
    .ai-typing {
        display: none;
        align-items: center;
        gap: 8px;
        padding: 0 16px 8px;
        background: #f2f6fa;
        color: #7a8a99;
        font-size: 12px;
        font-style: italic;
    }
    .ai-typing.show { display: flex; }
    .ai-typing .ai-spinner {
        width: 14px;
        height: 14px;
        border: 2px solid #cbd5e1;
        border-top-color: #007bff;
        border-radius: 50%;
        animation: aiSpin 0.8s linear infinite;
    }
    @keyframes aiSpin {
        to { transform: rotate(360deg); }
    }

    /* Input bar */
    .ai-input-bar {
        display: flex;
        align-items: flex-end;
        gap: 8px;
        padding: 10px 12px;
        background: #fff;
        border-top: 1px solid #e3ebf3;
        flex-shrink: 0;
    }
    .ai-input {
        flex: 1;
        min-height: 40px;
        max-height: 100px;
        padding: 10px 14px;
        border: 1px solid #e3ebf3;
        border-radius: 20px;
        font-size: 13.5px;
        resize: none;
        outline: none;
        font-family: inherit;
        background: #f2f6fa;
        color: #1f2d3d;
    }
    .ai-input:focus {
        border-color: #007bff;
        background: #fff;
    }
    .ai-send {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: 16px;
        flex-shrink: 0;
        transition: background 0.2s;
    }
    .ai-send:hover { background: #0056b3; }
    .ai-send:disabled {
        background: #cbd5e1;
        cursor: not-allowed;
    }

    /* Responsive */
    @media (max-width: 480px) {
        .ai-panel {
            width: calc(100vw - 24px);
            right: 12px;
            bottom: 84px;
            height: calc(100vh - 120px);
        }
        .ai-fab {
            right: 12px;
            bottom: 16px;
        }
    }
</style>

{{-- Tombol Floating --}}
<button class="ai-fab" id="aiFab" title="Tanya AI Assistant">
    <span id="aiFabIcon">💬</span>
</button>

{{-- Panel Chat --}}
<div class="ai-panel" id="aiPanel">
    <div class="ai-header">
        <div class="ai-header-title">
            <span class="ai-dot"></span>
            <span>🤖 AI Assistant PDAM</span>
        </div>
        <button class="ai-close" id="aiClose" title="Tutup">×</button>
    </div>

    <div class="ai-body" id="aiBody">
        <div class="ai-msg assistant">
            <div class="ai-avatar">✨</div>
            <div class="ai-bubble">
Halo bro! Gue asisten inventory PDAM Tirta Sago. Tanya apa aja soal stok, barang masuk/keluar, atau kondisi gudang. 🔥
            </div>
        </div>
    </div>

    <div class="ai-typing" id="aiTyping">
        <div class="ai-spinner"></div>
        <span>AI lagi mikir...</span>
    </div>

    <div class="ai-input-bar">
        <textarea
            class="ai-input"
            id="aiInput"
            placeholder="Tanya apa aja soal gudang..."
            rows="1"
        ></textarea>
        <button class="ai-send" id="aiSend" title="Kirim">➤</button>
    </div>
</div>

<script>
(function() {
    const fab      = document.getElementById('aiFab');
    const fabIcon  = document.getElementById('aiFabIcon');
    const panel    = document.getElementById('aiPanel');
    const closeBtn = document.getElementById('aiClose');
    const body     = document.getElementById('aiBody');
    const input    = document.getElementById('aiInput');
    const sendBtn  = document.getElementById('aiSend');
    const typing   = document.getElementById('aiTyping');

    let isOpen = false;
    let isLoading = false;

    // Toggle panel
    function openPanel() {
        isOpen = true;
        panel.classList.add('open');
        fab.classList.add('active');
        fabIcon.textContent = '×';
        setTimeout(() => input.focus(), 200);
    }
    function closePanel() {
        isOpen = false;
        panel.classList.remove('open');
        fab.classList.remove('active');
        fabIcon.textContent = '💬';
    }

    fab.addEventListener('click', () => {
        isOpen ? closePanel() : openPanel();
    });
    closeBtn.addEventListener('click', closePanel);

    // Auto-resize textarea
    input.addEventListener('input', () => {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 100) + 'px';
    });

    // Enter = kirim, Shift+Enter = new line
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    sendBtn.addEventListener('click', sendMessage);

    // Tambah bubble ke chat
    function addMessage(role, text) {
        const msg = document.createElement('div');
        msg.className = 'ai-msg ' + role;

        if (role === 'assistant') {
            const avatar = document.createElement('div');
            avatar.className = 'ai-avatar';
            avatar.textContent = '✨';
            msg.appendChild(avatar);
        }

        const bubble = document.createElement('div');
        bubble.className = 'ai-bubble';
        bubble.textContent = text;
        msg.appendChild(bubble);

        body.appendChild(msg);
        body.scrollTop = body.scrollHeight;
    }

    // Kirim pesan
    async function sendMessage() {
        const text = input.value.trim();
        if (!text || isLoading) return;

        addMessage('user', text);
        input.value = '';
        input.style.height = 'auto';

        isLoading = true;
        sendBtn.disabled = true;
        typing.classList.add('show');
        body.scrollTop = body.scrollHeight;

        try {
            const res = await fetch('/api/ai/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify({ message: text })
            });

            const data = await res.json();

            if (data.success) {
                addMessage('assistant', data.reply);
            } else {
                let errorText = 'Aduh, koneksi ke AI bermasalah. Coba lagi ya bro.';
                const detail = data.detail || '';

                if (detail.includes('high demand') || detail.includes('UNAVAILABLE')) {
                    errorText = 'AI lagi rame banget bro. Tunggu 1-2 menit, terus coba lagi ya. 🙏';
                } else if (detail.includes('timed out')) {
                    errorText = 'Koneksi ke AI lambat. Coba lagi ya bro. ⏱️';
                }

                addMessage('assistant', errorText);
            }
        } catch (err) {
            addMessage('assistant', 'Koneksi internet bermasalah. Cek koneksi lo bro. 📶');
        } finally {
            isLoading = false;
            sendBtn.disabled = false;
            typing.classList.remove('show');
            input.focus();
        }
    }
})();
</script>