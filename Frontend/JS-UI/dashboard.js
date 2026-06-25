   /* ─ MOBILE MENU ─ */
    function toggleMenu() {
      const m = document.getElementById('mobileMenu');
      m.classList.toggle('open');
    }
    function closeMenu() {
      document.getElementById('mobileMenu').classList.remove('open');
    }

    /* ─ NAV ACTIVE HIGHLIGHT ─ */
    const sections = ['hero','events','products','qr','assistant'];
    const navAs = document.querySelectorAll('.nav-links a');
    window.addEventListener('scroll', () => {
      let cur = 'hero';
      sections.forEach(id => {
        const el = document.getElementById(id);
        if (el && window.scrollY >= el.offsetTop - 100) cur = id;
      });
      navAs.forEach(a => {
        a.classList.toggle('active', a.getAttribute('href') === '#' + cur);
      });
    });

    /* ─ PRODUCT TABS ─ */
    document.querySelectorAll('.product-tab').forEach(tab => {
      tab.addEventListener('click', () => {
        document.querySelectorAll('.product-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        const filter = tab.dataset.filter;
        document.getElementById('mobileTrack').style.display = (filter === 'fixed') ? 'none' : '';
        document.getElementById('fixedTrack').style.display = (filter === 'mobile') ? 'none' : '';
      });
    });

    /* ─ PRODUCT DETAIL MODAL ─ */
    function openProduct(card) {
      const art = card.querySelector('.product-art');
      const artImg = art ? art.querySelector('img') : null;
      const me = document.getElementById('modalEmoji');
      me.className = 'modal-emoji';
      if (artImg) {
        me.classList.add('has-img');
        if (art.classList.contains('white-bg')) me.classList.add('white-bg');
        if (art.classList.contains('contain')) me.classList.add('contain');
        const im = document.createElement('img');
        im.src = artImg.getAttribute('src'); im.alt = '';
        me.replaceChildren(im);
      } else {
        me.textContent = (art && art.textContent.trim()) || '📦';
      }
      const tag = card.querySelector('.product-tag')?.textContent.trim() || '';
      const title = card.querySelector('h3')?.textContent.trim() || '';
      const desc = card.querySelector('p')?.textContent.trim() || '';
      const type = card.dataset.type;
      const room = type === 'mobile'
        ? 'Mobile Product · Champion 1 (lantai 6 TSO, kiri pintu masuk)'
        : 'Fixed Product · Champion 2 (lantai 6 TSO, kanan pintu masuk)';

      document.getElementById('modalTag').textContent = tag;
      document.getElementById('modalTitle').textContent = title;
      document.getElementById('modalDesc').textContent = desc;
      document.getElementById('modalRoom').textContent = '📍 ' + room;
      document.getElementById('productModal').classList.add('open');
    }
    function closeProduct() {
      document.getElementById('productModal').classList.remove('open');
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeProduct(); });

    /* ─ FAQ ACCORDION ─ */
    function toggleFaq(btn) {
      const item = btn.closest('.faq-item');
      const wasOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
      if (!wasOpen) item.classList.add('open');
    }

    /* ─ SCROLL REVEAL ─ */
    const observer = new IntersectionObserver(entries => {
      entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
    }, { threshold: 0.08 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    /* ─ CITY SKYLINE (in case inline script didn't render) ─ */
    (function() {
      const city = document.querySelector('.poster-city');
      if (city && city.children.length === 0) {
        [28,18,38,14,48,22,36,12,54,20,42,16,60,24,40,18,50,26,34,14,44,20,38,16,52,22,46,18,32,12,48,24].forEach(h => {
          const d = document.createElement('div');
          d.className = 'city-bar';
          d.style.height = h + 'px';
          city.appendChild(d);
        });
      }
    })();

    /* ─ COUNTDOWN TO 3 SEP 2026 ─ */
    (function() {
      // 3 September 2026, 08:00 WIB (UTC+7)
      const target = new Date('2026-09-03T08:00:00+07:00').getTime();
      const elDays = document.getElementById('cd-days');
      const elHours = document.getElementById('cd-hours');
      const elMins = document.getElementById('cd-mins');
      const elSecs = document.getElementById('cd-secs');
      const grid = document.getElementById('countdown');
      const pad = n => String(n).padStart(2, '0');

      function tick() {
        const diff = target - Date.now();
        if (diff <= 0) {
          grid.innerHTML = '<div class="countdown-live">🔴 Traction Day sedang berlangsung!</div>';
          clearInterval(timer);
          return;
        }
        const d = Math.floor(diff / 86400000);
        const h = Math.floor((diff % 86400000) / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        if (elDays) elDays.textContent = d;
        if (elHours) elHours.textContent = pad(h);
        if (elMins) elMins.textContent = pad(m);
        if (elSecs) elSecs.textContent = pad(s);
      }
      tick();
      const timer = setInterval(tick, 1000);
    })();

    /* ─ QR GENERATOR ─ */
    function generateQR() {
      const email = document.getElementById('qrEmail').value.trim();
      const dept = document.getElementById('qrDept').value.trim();
      if (!email) { alert('Masukkan email terlebih dahulu.'); return; }
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { alert('Masukkan email yang valid.'); return; }

      const id = 'TD26-' + Math.random().toString(36).substring(2, 8).toUpperCase();
      const qrData = JSON.stringify({ event: 'Traction Day 2026', email, dept, id, ts: new Date().toISOString() });

      const canvas = document.getElementById('qrCanvas');
      drawQR(canvas, qrData, 200);

      document.getElementById('qrNameLabel').textContent = 'Hi ' + email + (dept ? ' from ' + dept : '') + ', this is your QR Code';
      document.getElementById('qrIdLabel').textContent = id;
      document.getElementById('qrOutput').classList.add('show');
    }

    /* Simple QR-like pattern renderer (visual placeholder using data hash) */
    function drawQR(canvas, data, size) {
      const ctx = canvas.getContext('2d');
      canvas.width = size; canvas.height = size;
      const modules = 25;
      const cell = size / modules;

      // Background
      ctx.fillStyle = '#ffffff';
      ctx.fillRect(0, 0, size, size);

      // Deterministic pattern from data
      let hash = 0;
      for (let i = 0; i < data.length; i++) { hash = ((hash << 5) - hash + data.charCodeAt(i)) | 0; }
      const rng = (n) => { hash = ((hash * 1664525) + 1013904223) | 0; return Math.abs(hash) % n; };

      ctx.fillStyle = '#000000';

      // Draw data modules
      for (let r = 0; r < modules; r++) {
        for (let c = 0; c < modules; c++) {
          // Skip finder pattern zones
          const inFinder = (r < 8 && c < 8) || (r < 8 && c >= modules - 8) || (r >= modules - 8 && c < 8);
          if (!inFinder) {
            if (rng(2) === 1) {
              ctx.fillRect(c * cell, r * cell, cell - 0.5, cell - 0.5);
            }
          }
        }
      }

      // Draw finder patterns (top-left, top-right, bottom-left)
      [[0, 0], [0, modules - 7], [modules - 7, 0]].forEach(([r, c]) => {
        ctx.fillStyle = '#000';
        ctx.fillRect(c * cell, r * cell, 7 * cell, 7 * cell);
        ctx.fillStyle = '#fff';
        ctx.fillRect((c + 1) * cell, (r + 1) * cell, 5 * cell, 5 * cell);
        ctx.fillStyle = '#000';
        ctx.fillRect((c + 2) * cell, (r + 2) * cell, 3 * cell, 3 * cell);
      });

      // Center label overlay
      const cx = size / 2, cy = size / 2;
      ctx.fillStyle = 'rgba(255,255,255,0.92)';
      ctx.beginPath();
      ctx.roundRect(cx - 28, cy - 14, 56, 28, 6);
      ctx.fill();
      ctx.fillStyle = '#080a18';
      ctx.font = 'bold 9px -apple-system, sans-serif';
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      ctx.fillText('TD2026', cx, cy);
    }

    function downloadQR() {
      const canvas = document.getElementById('qrCanvas');
      const email = document.getElementById('qrEmail').value.trim();
      const slug = (email.split('@')[0] || 'qr').replace(/[^a-zA-Z0-9._-]/g, '-');
      const link = document.createElement('a');
      link.download = 'QR-Absen-TractionDay2026-' + slug + '.png';
      link.href = canvas.toDataURL('image/png');
      link.click();
    }

    /* ─ AI CHAT ─ */
    const faqs = [
      { keys: ['champion 1', 'booth mobile', 'mobile booth'], ans: 'Champion 1 ada di lantai 6 TSO, area kiri pintu masuk. Di sana kamu bisa menemukan booth Mobile Products: AVA, ProtekSi Kecil, Kids Locator, dan Siscamling.' },
      { keys: ['champion 2', 'booth fixed', 'fixed booth'], ans: 'Champion 2 ada di sebelah kanan pintu masuk, lantai 6 TSO. Fixed Products: FTTR, IndiHome Smart, IndiHome One, dan In-Car WiFi.' },
      { keys: ['champion 3'], ans: 'Champion 3 adalah Launch Readiness Room — ruangan khusus untuk decision-maker review kesiapan launch dan feedback per produk. Dimulai pukul 13.00.' },
      { keys: ['champion 4'], ans: 'Champion 4 adalah Prioritization Room — tempat konsolidasi semua feedback menjadi product priority list 2027. Sesi mulai pukul 15.30.' },
      { keys: ['produk mobile', 'mobile apa saja', 'mobile track'], ans: 'Mobile Products (Champion 1) menampilkan 4 produk: AVA (AI assistant MVP), ProtekSi Kecil (family protection), Kids Locator (MVP), dan Siscamling (community safety enhancement).' },
      { keys: ['produk fixed', 'fixed apa saja', 'fixed track'], ans: 'Fixed Products (Champion 2): FTTR (fiber-to-the-room, existing), IndiHome Smart (smart-home MVP), IndiHome One (integrated connectivity enhancement), dan In-Car WiFi (mobility MVP).' },
      { keys: ['jadwal', 'agenda', 'rundown', 'acara hari'], ans: '08.00 Check-in · 09.00 Opening Keynote · 10.00 Booth Exhibition · 12.00 Lunch · 13.00 Deep-dive Discussion · 15.30 Prioritization Workshop · 16.30 Closing · 17.00 Selesai.' },
      { keys: ['decision maker', 'harus ke mana'], ans: 'Sebagai decision-maker, rutenya: Check-in → Booth Tour Champion 1 & 2 → Deep-dive Champion 3 (13.00) → Prioritization Champion 4 (15.30). Harap hadir di Champion 3 tepat waktu.' },
      { keys: ['tujuan', 'apa itu', 'traction day'], ans: 'Traction Day 2026 adalah internal forum Telkomsel STC untuk showcase 8 produk pipeline 2027, mengumpulkan feedback leadership, dan menetapkan urutan prioritas launch berdasarkan readiness dan business impact.' },
      { keys: ['check-in', 'absen', 'registrasi', 'qr'], ans: 'Generate QR code absensimu di halaman QR Absen, lalu tunjukkan ke panitia di depan Champion 1 mulai pukul 08.00.' },
      { keys: ['venue', 'lokasi', 'di mana', 'tso'], ans: 'Event berlangsung di Telkomsel Smart Office (TSO) Lantai 6, Champion 1–4. Kamis, 3 September 2026, 08.00–17.00 WIB.' },
    ];

    function getAnswer(q) {
      const lq = q.toLowerCase();
      const hit = faqs.find(f => f.keys.some(k => lq.includes(k)));
      return hit ? hit.ans : 'Hmm, saya belum punya jawaban pasti untuk itu. Coba tanya ke panitia di area check-in, atau cek section Rundown dan Products di halaman ini!';
    }

    function sendMsg(text) {
      const msgs = document.getElementById('chatMessages');
      const u = document.createElement('div');
      u.className = 'bubble user'; u.textContent = text; msgs.appendChild(u);
      msgs.scrollTop = msgs.scrollHeight;
      setTimeout(() => {
        const b = document.createElement('div');
        b.className = 'bubble bot'; b.textContent = getAnswer(text); msgs.appendChild(b);
        msgs.scrollTop = msgs.scrollHeight;
      }, 360);
    }

    function sendChatInput() {
      const input = document.getElementById('chatInput');
      const text = input.value.trim();
      if (!text) return;
      input.value = '';
      sendMsg(text);
    }