const hamburgerBtn = document.getElementById('hamburger-btn');
const sidebarmenu = document.getElementById('sidebarmenu');
const sidebar = document.querySelector('.sidebar');
const navLinks = document.querySelectorAll('.nav-link');
const sections = document.querySelectorAll('.section');
const page = document.querySelector('.page');

function toggleSidebar() {
  sidebarmenu.classList.toggle('hidden');
  sidebar.classList.toggle('background_maincolor');
}

hamburgerBtn.addEventListener('click', function() {
  toggleSidebar();
});

if (window.innerWidth <= 768) {
  sidebarmenu.classList.add('hidden');
}

document.addEventListener('click', function(event) {
  if (!sidebarmenu.contains(event.target) && !hamburgerBtn.contains(event.target)) {
    sidebarmenu.classList.add('hidden');
    sidebar.classList.remove('background_maincolor');
  }
});

function openSection(target, push = true) {
  if (!document.getElementById(target)) {
    target = 'about';
  }

  navLinks.forEach(link => link.classList.toggle('active', link.dataset.target === target));
  sections.forEach(section => section.classList.toggle('active', section.id === target));
  page.scrollTo({ top: 0, behavior: 'smooth' });

  if (push && history.pushState) {
    history.pushState({ section: target }, '', `#${target}`);
  }
}

navLinks.forEach(link => {
  link.addEventListener('click', () => {
    openSection(link.dataset.target);
    if (window.innerWidth <= 768) {
      sidebarmenu.classList.add('hidden');
    }
  });
});

document.querySelectorAll('[data-jump]').forEach(button => {
  button.addEventListener('click', () => openSection(button.dataset.jump));
});

window.addEventListener('popstate', event => {
  const section = (event.state && event.state.section) || location.hash.replace('#', '') || 'about';
  openSection(section, false);
});

const initialSection = location.hash.replace('#', '') || 'about';
openSection(initialSection, false);

function updateCountdown() {
  const target = new Date('2026-09-03T08:00:00+07:00').getTime();
  let diff = Math.max(target - Date.now(), 0);
  const dayMs = 864e5;
  const hourMs = 36e5;
  const minuteMs = 6e4;

  document.getElementById('days').textContent = Math.floor(diff / dayMs);
  document.getElementById('hours').textContent = String(Math.floor((diff % dayMs) / hourMs)).padStart(2, '0');
  document.getElementById('minutes').textContent = String(Math.floor((diff % hourMs) / minuteMs)).padStart(2, '0');
  document.getElementById('seconds').textContent = String(Math.floor((diff % minuteMs) / 1000)).padStart(2, '0');
}

updateCountdown();
setInterval(updateCountdown, 1000);

const products = [
  { id: 'ava', name: 'AVA', track: 'mobile', type: 'MVP Product', booth: 'Champion 1', icon: '🤖', short: 'AI-powered digital assistance concept for smarter customer interaction, service discovery, and support experiences.', problem: 'Customers need faster, smarter, and more intuitive ways to discover services and resolve needs inside Telkomsel digital journeys.', proposition: 'AVA acts as an intelligent assistant layer that helps users navigate product information, recommendations, and service support more naturally.', focus: ['Core use cases and customer journey clarity', 'AI readiness, data source, and integration needs', 'GTM positioning and differentiation', 'Launch priority versus existing service channels'] },
  { id: 'proteksi', name: 'ProtekSi Kecil', track: 'mobile', type: 'Existing Enhancement', booth: 'Champion 1', icon: '🛡️', short: 'Family-focused protection proposition to help parents monitor, protect, and guide children’s digital activities.', problem: 'Parents want practical protection for children’s digital activities, but the journey needs to feel simple, trusted, and non-intrusive.', proposition: 'A child digital safety product that packages protection, monitoring, and family peace of mind into one accessible mobile proposition.', focus: ['Parent pain point validation', 'Feature simplicity and trust cues', 'Bundling strategy with existing packages', 'Retention and upsell opportunity'] },
  { id: 'kids-locator', name: 'Kids Locator', track: 'mobile', type: 'MVP Product', booth: 'Champion 1', icon: '📍', short: 'Location-based family safety concept that helps parents stay connected with child visibility features.', problem: 'Families need reassurance and location visibility, especially for children moving between school, home, and activities.', proposition: 'A location-based safety layer that helps parents know where their children are and receive relevant movement updates.', focus: ['Safety use case and privacy boundaries', 'Device and network dependency', 'Monetization model', 'Priority versus other family products'] },
  { id: 'siscamling', name: 'Siscamling', track: 'mobile', type: 'Existing Enhancement', booth: 'Champion 1', icon: '👁️', short: 'Community safety experience that turns connectivity into a practical neighborhood protection layer.', problem: 'Neighborhood safety initiatives often lack simple digital coordination and real-time communication tools.', proposition: 'A community safety proposition that uses connectivity to support neighborhood monitoring, coordination, and alerting.', focus: ['Community adoption model', 'Partnership and operational feasibility', 'Data privacy and moderation', 'Local market rollout priority'] },
  { id: 'fttr', name: 'FTTR', track: 'fixed', type: 'Existing Enhancement', booth: 'Champion 2', icon: '⚡', short: 'Fiber-to-the-room solution for stronger home WiFi coverage, better stability, and premium broadband experience.', problem: 'Households increasingly need consistent connectivity in every room, not just higher headline speed.', proposition: 'FTTR extends fiber performance deeper inside the home, creating a premium and more reliable broadband experience.', focus: ['Customer segment and pricing', 'Installation journey readiness', 'Premium positioning versus standard WiFi', 'Operational scalability'] },
  { id: 'indihome-smart', name: 'IndiHome Smart', track: 'fixed', type: 'MVP Product', booth: 'Champion 2', icon: '🏠', short: 'Smart-home ecosystem proposition that combines home connectivity with intelligent digital living services.', problem: 'Smart-home adoption remains fragmented, with customers needing a simpler bundle that connects devices, services, and home internet.', proposition: 'A smart-home proposition that integrates connectivity with digital living services under one practical IndiHome experience.', focus: ['Hero use cases for launch', 'Partner ecosystem readiness', 'Bundle structure and pricing', 'Customer education needs'] },
  { id: 'indihome-one', name: 'IndiHome One', track: 'fixed', type: 'Existing Enhancement', booth: 'Champion 2', icon: '🌐', short: 'Integrated fixed connectivity experience designed to simplify household digital needs in one proposition.', problem: 'Customers want home connectivity to feel simpler, more integrated, and easier to manage across household needs.', proposition: 'IndiHome One simplifies the fixed broadband experience into one clearer proposition for the household.', focus: ['Simplified packaging', 'Cross-sell potential', 'Customer journey friction', 'Launch communication clarity'] },
  { id: 'incar-wifi', name: 'In-Car WiFi', track: 'fixed', type: 'MVP Product', booth: 'Champion 2', icon: '🚗', short: 'Connectivity experience for vehicles, extending reliable internet access into mobility and family travel moments.', problem: 'Users increasingly expect internet continuity beyond the home, including inside vehicles during commute or travel.', proposition: 'A mobility connectivity product that brings reliable WiFi into car experiences for families, workers, and premium users.', focus: ['Target segment and willingness to pay', 'Device and installation model', 'Partnership opportunity', 'Launch readiness and support model'] }
];

const productGrid = document.getElementById('productGrid');
const listView = document.getElementById('productListView');
const detailView = document.getElementById('productDetailView');
const detailContent = document.getElementById('productDetailContent');
const backProducts = document.getElementById('backProducts');

function renderProducts(filter = 'all') {
  if (!productGrid) return;
  productGrid.innerHTML = '';
  products
    .filter(product => filter === 'all' || product.track === filter)
    .forEach(product => {
      const card = document.createElement('article');
      card.className = `product-card ${product.track}`;
      card.innerHTML = `
        <span class="tag">${product.track === 'mobile' ? 'Mobile' : 'Fixed'} · ${product.type}</span>
        <div class="product-art">${product.icon}</div>
        <h3>${product.name}</h3>
        <p>${product.short}</p>
        <div class="click-note">Tap for details →</div>
      `;
      card.addEventListener('click', () => showProduct(product.id));
      productGrid.appendChild(card);
    });
}

function showProduct(id) {
  const product = products.find(item => item.id === id);
  if (!product) return;

  listView.style.display = 'none';
  detailView.classList.add('active');
  detailContent.innerHTML = `
    <div class="detail-hero">
      <div class="big-icon">${product.icon}</div>
      <span class="tag">${product.track === 'mobile' ? 'Mobile' : 'Fixed'} · ${product.type}</span>
      <h2>${product.name}</h2>
      <p>${product.short}</p>
    </div>
    <div class="detail-meta">
      <div class="detail-box"><small>Track</small><strong>${product.track === 'mobile' ? 'Mobile Product Team' : 'Fixed Product Team'}</strong></div>
      <div class="detail-box"><small>Booth</small><strong>${product.booth}</strong></div>
      <div class="detail-box"><small>Category</small><strong>${product.type}</strong></div>
      <div class="detail-box"><small>Feedback</small><strong>Leadership Review</strong></div>
    </div>
    <div class="detail-section"><h3>Problem to Solve</h3><p>${product.problem}</p></div>
    <div class="detail-section"><h3>Product Proposition</h3><p>${product.proposition}</p></div>
    <div class="detail-section"><h3>Discussion Focus</h3><ul>${product.focus.map(item => `<li>${item}</li>`).join('')}</ul></div>
  `;
  page.scrollTo({ top: 0, behavior: 'smooth' });
}

if (backProducts) {
  backProducts.addEventListener('click', () => {
    detailView.classList.remove('active');
    listView.style.display = 'block';
    page.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

const filterButtons = document.querySelectorAll('.filter');
filterButtons.forEach(button => {
  button.addEventListener('click', () => {
    filterButtons.forEach(item => item.classList.remove('active'));
    button.classList.add('active');
    renderProducts(button.dataset.filter);
  });
});

const defaultFilter = document.querySelector('.filter.active')?.dataset.filter || 'all';
renderProducts(defaultFilter);

const eventTabs = document.querySelectorAll('.event-tab');
eventTabs.forEach(tab => {
  tab.addEventListener('click', () => {
    eventTabs.forEach(item => item.classList.remove('active'));
    document.querySelectorAll('.event-panel').forEach(panel => panel.classList.remove('active'));
    tab.classList.add('active');
    document.getElementById(tab.dataset.panel).classList.add('active');
  });
});

function deterministicHash(text) {
  let hash = 0;
  for (let i = 0; i < text.length; i++) {
    hash = ((hash << 5) - hash) + text.charCodeAt(i);
    hash |= 0;
  }
  return Math.abs(hash);
}

function fallbackQR(canvas, payload) {
  const ctx = canvas.getContext('2d');
  const size = canvas.width;
  const cells = 29;
  const cell = size / cells;
  const seed = deterministicHash(payload);

  ctx.fillStyle = '#fff';
  ctx.fillRect(0, 0, size, size);
  ctx.fillStyle = '#050712';

  function finder(x, y) {
    ctx.fillRect(x * cell, y * cell, 7 * cell, 7 * cell);
    ctx.fillStyle = '#fff';
    ctx.fillRect((x + 1) * cell, (y + 1) * cell, 5 * cell, 5 * cell);
    ctx.fillStyle = '#050712';
    ctx.fillRect((x + 2) * cell, (y + 2) * cell, 3 * cell, 3 * cell);
  }

  finder(1, 1);
  finder(21, 1);
  finder(1, 21);

  for (let y = 0; y < cells; y++) {
    for (let x = 0; x < cells; x++) {
      const inFinder = (x >= 1 && x <= 7 && y >= 1 && y <= 7) || (x >= 21 && x <= 27 && y >= 1 && y <= 7) || (x >= 1 && x <= 7 && y >= 21 && y <= 27);
      if (inFinder) continue;
      const value = (x * 17 + y * 31 + seed + ((x * y) % 13)) % 7;
      if (value === 0 || value === 3) {
        ctx.fillRect(Math.floor(x * cell), Math.floor(y * cell), Math.ceil(cell), Math.ceil(cell));
      }
    }
  }
}

const messages = document.getElementById('messages');
const chatText = document.getElementById('chatText');
const sendBtn = document.getElementById('sendBtn');

function addMessage(text, type) {
  const bubble = document.createElement('div');
  bubble.className = `bubble ${type}`;
  bubble.textContent = text;
  messages.appendChild(bubble);
  messages.scrollTop = messages.scrollHeight;
}

function answer(question) {
  const text = question.toLowerCase();

  if (text.includes('product')) return 'Open the Products tab to browse Mobile and Fixed products. Each product card is clickable and opens details such as booth, proposition, and discussion focus.';
  if (text.includes('register') || text.includes('qr')) return 'Open QR Registration, input your full name and role, then generate your personal QR code for the registration desk.';
  if (text.includes('where') && text.includes('next')) return 'Recommended flow: QR registration, opening keynote, booth tour in Champion 1 and 2, then Champion 3–4 for deep-dive prioritization.';
  if (text.includes('champion 1') || text.includes('mobile')) return 'Champion 1 is for Mobile Product Team exhibition. Products include AVA, ProtekSi Kecil, Kids Locator, and Siscamling.';
  if (text.includes('champion 2') || text.includes('fixed')) return 'Champion 2 is for Fixed Product Team exhibition. Products include FTTR, IndiHome Smart, IndiHome One, and In-Car WiFi.';
  if (text.includes('objective') || text.includes('purpose')) return 'Traction Day is a working forum to showcase 2027 product pipelines, collect leadership feedback, and decide launch priorities.';
  if (text.includes('rundown') || text.includes('schedule') || text.includes('time')) return 'The event runs 08.00–17.00 WIB on Thursday, 3 September 2026: registration, keynote, booth tour, deep-dive discussion, and wrap-up.';

  return 'I\'m sorry I could not help you with that. I can help with About Traction Day, Products, QR registration, venue layout, Champion rooms, rundown, and where to go next.';
}

function send(question) {
  const value = question || chatText.value.trim();
  if (!value) return;
  addMessage(value, 'user');
  chatText.value = '';
  setTimeout(() => addMessage(answer(value), 'bot'), 420);
}

sendBtn.addEventListener('click', () => send());
chatText.addEventListener('keydown', event => {
  if (event.key === 'Enter') send();
});

document.querySelectorAll('.suggestions button').forEach(button => {
  button.addEventListener('click', () => send(button.dataset.question));
});

renderProducts();
