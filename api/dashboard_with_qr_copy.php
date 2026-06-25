<?php
require_once __DIR__ . '/auth_check.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./CSS/WIP.css">
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js" defer></script>
    <script type="text/javascript" src="/Frontend/JS-UI/dashboard.js" defer></script>
</head>
<body class="dashboard-body">
    <div class="parent">
        <div class="sidebar" id="sidebar">
            <div class="topbar">
                <div class="brand">
                    <div class="brand-logo">t</div>
                    <div class="brand-text">
                        <small>Telkomsel STC</small>
                        <strong>Traction Day</strong>
                    </div>
                </div>
                <button class="hamburger" id="hamburger-btn" aria-label="Menu">☰</button>
            </div>
            <div class="sidebarmenu" id="sidebarmenu">
                <button class="nav-link active" data-target="about">About Traction Day</button>
                <button class="nav-link" data-target="products">Products</button>
                <button class="nav-link" data-target="event">Event</button>
                <button class="nav-link" data-target="registration">Visitor QR</button>
                <button class="nav-link" data-target="assistant">AI Chat</button>
            </div>
        </div>

        <main class="page">
            <section id="about" class="section active">
                <div class="about-hero">
                    <div class="eyebrow"><span class="pulse"></span> About Traction Day</div>
                    <h1>Traction<br>Day <span>2026</span></h1>
                    <div class="slogan">2027. <span>Execute.</span></div>
                    <p>Internal Telkomsel working forum by STC Department to showcase product pipelines, gather leadership feedback, and prioritize launch execution for 2027.</p>
                    <div class="poster-actions">
                        <button class="cta primary" data-jump="registration">Register QR</button>
                        <button class="cta secondary" data-jump="products">View Products</button>
                    </div>
                </div>
                <div class="countdown-wrap">
                    <div class="countdown-title">
                        <strong>Countdown to execution day</strong>
                        <span>Sep 3, 2026<br>08.00 WIB</span></div>
                    <div class="countdown">
                        <div class="time-card">
                            <span class="num" id="days">--</span>
                            <span class="label">Days</span>
                        </div>
                        <div class="time-card">
                            <span class="num" id="hours">--</span>
                            <span class="label">Hours</span>
                        </div>
                        <div class="time-card">
                            <span class="num" id="minutes">--</span>
                            <span class="label">Minutes</span>
                        </div>
                        <div class="time-card">
                            <span class="num" id="seconds">--</span>
                            <span class="label">Seconds</span>
                        </div>
                    </div>
                </div>
                <div class="info-grid">
                    <div class="info-box">
                        <small>Date</small>
                        <strong>Thursday, September 3rd</strong>
                        <span>One-day hybrid event.</span></div>
                    <div class="info-box">
                        <small>Venue</small>
                        <strong>TSO 6th Floor</strong>
                        <span>Champion 1–4.</span></div>
                    <div class="info-box">
                        <small>Format</small>
                        <strong>Meeting & Exhibition</strong>
                        <span>Booth tour plus deep-dive rooms.</span></div>
                    <div class="info-box">
                        <small>Products</small>
                        <strong>4–8 per team</strong>
                        <span>MVP and existing enhancements.</span></div>
                </div>
            </section>

            <section id="products" class="section">
                <div id="productListView">
                    <div class="section-head" style="margin-top:8px">
                        <div class="overline">Product Showcase</div>
                        <h2>Click a product to open details.</h2>
                        <p>Each product card opens into a detailed view with track, category, booth, proposition, and discussion focus.</p>
                    </div>
                    <div class="filters">
                        <button class="filter active" data-filter="all">All Products</button>
                        <button class="filter" data-filter="mobile">Mobile</button>
                        <button class="filter" data-filter="fixed">Fixed</button>
                    </div>
                    <div class="product-grid" id="productGrid"></div>
                </div>
                <div class="product-detail" id="productDetailView">
                    <button class="back-btn" id="backProducts">← Back to Products</button>
                    <div id="productDetailContent"></div>
                </div>
            </section>

            <section id="event" class="section">
                <div class="section-head" style="margin-top:8px">
                    <div class="overline">Event</div>
                    <h2>Venue layout and rundown.</h2>
                    <p>Attendees are guided through booth exhibition first, then decision makers continue into in-depth discussion rooms.</p>
                </div>
                <div class="event-tabs">
                    <button class="event-tab active" data-panel="layout">Venue Layout</button>
                    <button class="event-tab" data-panel="rundown">Rundown</button>
                </div>
                <div id="layout" class="event-panel active">
                    <div class="layout-card">
                        <div class="layout-title">
                            <strong>Telkomsel Smart Office · 6th Floor</strong>
                            <span>Champion 1–4</span>
                        </div>
                        <div class="room-grid">
                            <div class="room red">
                                <strong>Champion 1</strong>
                                <span>Mobile Product Team booth exhibition and guest tour.</span>
                            </div>
                            <div class="room blue">
                                <strong>Champion 2</strong>
                                <span>Fixed Product Team booth exhibition and product showcase.</span>
                            </div>
                            <div class="room">
                                <strong>Champion 3</strong>
                                <span>Decision-maker room for launch readiness discussion.</span>
                            </div>
                            <div class="room">
                                <strong>Champion 4</strong>
                                <span>Prioritization room for feedback consolidation and next steps.</span>
                            </div>
                        </div>
                    </div>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-time">Step 1</div>
                            <div>
                                <strong>QR Check-in</strong>
                                <p>Attendees scan their personal QR at registration desk.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-time">Step 2</div>
                            <div>
                                <strong>Booth Exhibition</strong>
                                <p>Guests visit Mobile and Fixed tracks to understand product pipeline.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-time">Step 3</div>
                            <div>
                                <strong>Feedback Capture</strong>
                                <p>Leadership feedback is captured for GTM, readiness, and priority.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-time">Step 4</div>
                            <div>
                                <strong>Deep-dive Room</strong>
                                <p>Decision makers move to Champion 3–4 for launch prioritization.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="rundown" class="event-panel">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-time">08.00</div>
                            <div>
                                <strong>Registration & QR Scan</strong>
                                <p>Check-in, attendance validation, and route guidance.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-time">09.00</div>
                            <div>
                                <strong>Opening Keynote</strong>
                                <p>BoD and VP Traction recall past impact and frame the current problem statement.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-time">10.00</div>
                            <div>
                                <strong>Booth Tour</strong>
                                <p>Mobile and Fixed teams present MVP Products and Existing Product Enhancements.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-time">13.00</div>
                            <div>
                                <strong>In-depth Discussion</strong>
                                <p>Decision makers discuss product readiness, risks, GTM, and launch priority.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-time">16.30</div>
                            <div>
                                <strong>Priority Wrap-up</strong>
                                <p>Output is consolidated into a concrete 2027 execution plan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="registration" class="section">
                <div class="section-head" style="margin-top:8px">
                    <div class="overline">Visitor QR</div>
                </div>
                <div class="registration-card">
                    <?php
                    $file = __DIR__ . '/qr_secure.php';

                    if (file_exists($file) && is_readable($file)) {
                        include $file;
                    } else {
                        echo "<p style='color:red;'>File tidak ditemukan atau tidak bisa dibaca.</p>";
                    }
                    ?>
                </div>
            </section>

            <section id="assistant" class="section">
                <div class="section-head" style="margin-top:8px">
                    <div class="overline">AI Chat Assistant</div>
                    <h2>Ask the event, not the committee.</h2>
                    <p>Personal assistant concept to guide attendees through agenda, venue, registration, and product tracks.</p>
                </div>
                <div class="assistant-card">
                    <div class="ai-head">
                        <div class="ai-avatar">AI</div>
                        <div>
                            <strong>Traction Assistant</strong>
                            <span>Ask about schedule, venue, products, and where to go next.</span>
                        </div>
                    </div>
                    <div class="messages" id="messages">
                        <div class="bubble bot">Welcome to Traction Day 2026. I can help you find products, rundown, venue layout, and next session.</div>
                    </div>
                    <div class="suggestions">
                        <button data-question="Where should I go next?">Where next?</button>
                        <button data-question="Show product list">Product list</button>
                        <button data-question="How do I register?">How to register?</button>
                        <button data-question="Where is Champion 1?">Champion 1</button>
                        <button data-question="What is the event objective?">Objective</button>
                    </div>
                    <div class="chat-input">
                        <input id="chatText" type="text" placeholder="Ask Traction Assistant...">
                        <button class="send" id="sendBtn">↗</button>
                    </div>
                </div>
            </section>

            <div class="footer">Traction Day 2026 · 2027. Execute. · STC Department · Telkomsel Internal Event</div>
        </main>
    </div>
</body>
</html>
