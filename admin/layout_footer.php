<?php
/**
 * NovaDrop Commerce OS — Enterprise Admin Layout Footer v3.0
 * Provides JavaScript, Bootstrap bindings, theme engine, toast notifications,
 * keyboard shortcuts, and closing tags for standalone pages.
 */
$is_standalone = (basename($_SERVER['SCRIPT_FILENAME'] ?? '') !== 'index.php');

if ($is_standalone):
?>

<!-- Core Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Optional page scripts -->
<script src="../js/script.js" onerror="void(0)"></script>
<script src="js/script.js" onerror="void(0)"></script>

<script>
/* ═══════════════════════════════════════════════════════════════
   NOVADROP ADMIN CORE JS v3.0
═══════════════════════════════════════════════════════════════ */

/* ── Dark / Light Mode Engine ── */
function toggleMode() {
    const body = document.body;
    const isDark = body.classList.toggle('dark-mode');
    localStorage.setItem('nd_theme', isDark ? 'dark' : 'light');

    // Update icon
    const btn = document.querySelector('.theme-toggle-btn i');
    if (btn) {
        btn.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
    }

    // Smooth ripple effect
    const ripple = document.createElement('div');
    ripple.style.cssText = `
        position: fixed; inset: 0; z-index: 9999; pointer-events: none;
        background: ${isDark ? '#080c14' : '#f1f5f9'};
        opacity: 0.5; transition: opacity 0.4s ease;
    `;
    document.body.appendChild(ripple);
    setTimeout(() => { ripple.style.opacity = '0'; }, 50);
    setTimeout(() => ripple.remove(), 500);

    ndToast(isDark ? '🌙 Dark mode on' : '☀️ Light mode on', 'info', 1800);
}

// Apply saved theme & correct icon on load
(function() {
    const saved = localStorage.getItem('nd_theme') || 'light';
    if (saved === 'dark') document.body.classList.add('dark-mode');
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.querySelector('.theme-toggle-btn i');
        if (btn) {
            btn.className = document.body.classList.contains('dark-mode')
                ? 'fas fa-sun' : 'fas fa-moon';
        }
    });
})();

/* ── Mobile Navbar Toggle ── */
function toggleNavbar() {
    const nav = document.getElementById('navbar-nav');
    if (nav) nav.classList.toggle('show');
}

/* ── Toast Notification System ── */
(function() {
    // Create container
    const container = document.createElement('div');
    container.id = 'nd-toast-container';
    container.style.cssText = `
        position: fixed; bottom: 24px; right: 24px;
        z-index: 99999; display: flex; flex-direction: column;
        gap: 10px; pointer-events: none; max-width: 340px;
    `;
    document.body.appendChild(container);
})();

function ndToast(message, type = 'success', duration = 3500) {
    const container = document.getElementById('nd-toast-container');
    if (!container) return;

    const colors = {
        success: { bg: 'rgba(16,185,129,0.12)', border: 'rgba(16,185,129,0.3)', icon: 'fas fa-check-circle', c: '#059669' },
        error:   { bg: 'rgba(239,68,68,0.12)',  border: 'rgba(239,68,68,0.3)',  icon: 'fas fa-times-circle', c: '#dc2626' },
        warning: { bg: 'rgba(245,158,11,0.12)', border: 'rgba(245,158,11,0.3)', icon: 'fas fa-exclamation-circle', c: '#d97706' },
        info:    { bg: 'rgba(99,102,241,0.12)', border: 'rgba(99,102,241,0.3)', icon: 'fas fa-info-circle', c: '#6366f1' },
    };

    const s = colors[type] || colors.info;
    const toast = document.createElement('div');
    toast.style.cssText = `
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px; border-radius: 12px;
        background: ${s.bg}; border: 1px solid ${s.border};
        backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
        font-size: 0.85rem; font-weight: 500; color: var(--text-primary, #0f172a);
        pointer-events: all; cursor: pointer;
        box-shadow: 0 8px 32px rgba(0,0,0,0.12);
        transform: translateX(120%); transition: transform 0.35s cubic-bezier(0.16,1,0.3,1), opacity 0.35s ease;
        opacity: 0; min-width: 240px;
        font-family: 'Inter', sans-serif;
    `;
    toast.innerHTML = `<i class="${s.icon}" style="color:${s.c};font-size:1.05rem;flex-shrink:0;"></i><span style="flex:1">${message}</span>`;
    toast.onclick = () => removeToast(toast);

    container.appendChild(toast);

    // Trigger animation
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            toast.style.transform = 'translateX(0)';
            toast.style.opacity = '1';
        });
    });

    setTimeout(() => removeToast(toast), duration);
}

function removeToast(toast) {
    toast.style.transform = 'translateX(120%)';
    toast.style.opacity = '0';
    setTimeout(() => toast.remove(), 400);
}

/* ── Auto-show alerts as toasts then fade ── */
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.alert-success').forEach(function(el) {
        const text = el.textContent.trim().replace(/×/g, '').trim();
        if (text.length > 3) ndToast(text, 'success');
        setTimeout(() => { el.style.transition = 'opacity 0.5s'; el.style.opacity = '0'; }, 3000);
    });
    document.querySelectorAll('.alert-danger').forEach(function(el) {
        const text = el.textContent.trim().replace(/×/g, '').trim();
        if (text.length > 3) ndToast(text, 'error', 5000);
    });
});

/* ── Smooth Table Row Entrance ── */
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(function(row, i) {
        row.style.opacity = '0';
        row.style.transform = 'translateY(8px)';
        row.style.transition = 'opacity 0.3s ease ' + (i * 0.03) + 's, transform 0.3s ease ' + (i * 0.03) + 's';
        setTimeout(function() {
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, 60 + i * 30);
    });
});

/* ── Tooltip Init (Bootstrap) ── */
document.addEventListener('DOMContentLoaded', function() {
    $('[data-toggle="tooltip"]').tooltip({ trigger: 'hover', placement: 'top' });
    $('[data-toggle="popover"]').popover();
});

/* ── Number counter animation ── */
function animateNumber(el, target, duration) {
    const start = 0;
    const step = target / (duration / 16);
    let current = start;
    const timer = setInterval(function() {
        current = Math.min(current + step, target);
        el.textContent = Math.floor(current).toLocaleString('en-IN');
        if (current >= target) clearInterval(timer);
    }, 16);
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.card-metric-value').forEach(function(el) {
        const raw = el.textContent.trim().replace(/[₹,\+%]/g, '');
        const num = parseFloat(raw);
        if (!isNaN(num) && num > 0 && num < 1000000) {
            const prefix = el.textContent.includes('₹') ? '₹' : '';
            const suffix = el.textContent.includes('%') ? '%' : (el.textContent.includes('+') ? '+' : '');
            el.textContent = prefix + '0' + suffix;
            animateNumber({ textContent: '' }, num, 900);

            let count = 0;
            const step = num / (900 / 16);
            let cur = 0;
            const timer = setInterval(function() {
                cur = Math.min(cur + step, num);
                if (Number.isInteger(num)) {
                    el.textContent = prefix + Math.floor(cur).toLocaleString('en-IN') + suffix;
                } else {
                    el.textContent = prefix + cur.toFixed(1) + suffix;
                }
                if (cur >= num) clearInterval(timer);
            }, 16);
        }
    });
});

/* ── Keyboard Shortcut: Alt+D = Dashboard ── */
document.addEventListener('keydown', function(e) {
    if (e.altKey && e.key === 'd') { window.location.href = 'index.php?q=0'; }
    if (e.altKey && e.key === 'p') { window.location.href = 'index.php?q=1'; }
    if (e.altKey && e.key === 'o') { window.location.href = 'index.php?q=3'; }
});

/* ── Active dropdown item highlighting ── */
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.dropdown-item.active').forEach(function(item) {
        item.closest('.dropdown')?.querySelector('.nav-link')?.classList.add('active');
    });
});

</script>

</body>
</html>
<?php endif; ?>
