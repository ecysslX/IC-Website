</div>

<div id="footer">
    <div class="footer-inner">
        <ul>
            <li>页面已经到底啦。</li>
            <li>I Wanna Be The Creator | 我想成为创造者 游戏网站</li>
            <li>游戏作者：<a target="_blank" href="https://space.bilibili.com/3124592">AikesiX</a></li>
            <li>网站作者：<a target="_blank" href="https://space.bilibili.com/1283002216">小郑</a></li>
        </ul>
    </div>
</div>

<script>
(() => {
    async function copyText(text) {
        if (navigator.clipboard && window.isSecureContext) {
            await navigator.clipboard.writeText(text);
            return true;
        }
        const input = document.createElement('textarea');
        input.value = text;
        input.style.position = 'fixed';
        input.style.opacity = '0';
        document.body.appendChild(input);
        input.focus();
        input.select();
        const ok = document.execCommand('copy');
        document.body.removeChild(input);
        return ok;
    }

    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.copy-btn');
        if (!btn) return;
        const text = btn.getAttribute('data-copy');
        if (!text) return;

        const original = btn.textContent;
        try {
            const ok = await copyText(text);
            btn.textContent = ok ? '已复制' : '复制失败';
        } catch (_) {
            btn.textContent = '复制失败';
        }
        setTimeout(() => {
            btn.textContent = original;
        }, 1200);
    });
})();
</script>

</body>
</html>
