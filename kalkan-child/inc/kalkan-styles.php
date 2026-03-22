<style>
/* ─── Reset & Base ──────────────────────────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }

:root {
  --kk-bg:            #0f0520;
  --kk-bg-2:          #130728;
  --kk-bg-3:          #1a0533;
  --kk-bg-card:       rgba(255,255,255,0.055);
  --kk-border:        rgba(255,255,255,0.10);
  --kk-border-hover:  rgba(139,92,246,0.45);
  --kk-purple:        #8b5cf6;
  --kk-purple-light:  #c084fc;
  --kk-purple-dark:   #6d28d9;
  --kk-green:         #34d399;
  --kk-text:          #f5f3ff;
  --kk-text-muted:    #c4b5fd;
  --kk-text-dim:      rgba(245,243,255,0.62);
  --kk-white:         #ffffff;
  --kk-shell:         76rem;
  --kk-radius:        1.25rem;
  --kk-radius-sm:     0.75rem;
  --kk-header-h:      4.5rem;
  --kk-blur:          blur(16px) saturate(180%);
}

/* Hide Blocksy chrome if it leaks through */
.ct-header, .ct-footer, #main-container { display: none !important; }

body {
  background: linear-gradient(135deg, #0a0118 0%, #1a0533 30%, #2d1b69 60%, #1a0533 100%);
  color: var(--kk-text);
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  min-height: 100vh;
  line-height: 1.6;
}

.kk-page { display: block !important; }
h1, h2, h3, h4, p { margin: 0; }
a { color: inherit; }

.kk-shell {
  margin-inline: auto;
  max-width: var(--kk-shell);
  padding-inline: 1.5rem;
}

.kk-section {
  padding-block: clamp(4rem, 10vw, 6rem);
}

/* ─── Typography ─────────────────────────────────────────────────────────────── */
h1 {
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
  font-size: clamp(2.2rem, 6.5vw, 3.6rem);
  font-weight: 800;
  letter-spacing: -0.03em;
  line-height: 1.08;
  color: var(--kk-text);
}

h2 {
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
  font-size: clamp(1.6rem, 4.5vw, 2.5rem);
  font-weight: 700;
  letter-spacing: -0.02em;
  line-height: 1.15;
  color: var(--kk-text);
}

h3 {
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
  font-size: clamp(1.05rem, 2.5vw, 1.2rem);
  font-weight: 700;
  line-height: 1.3;
  color: var(--kk-text);
}

.kk-lead {
  font-size: clamp(1rem, 2.2vw, 1.15rem);
  color: var(--kk-text-muted);
  margin-top: 0.9rem;
  max-width: 46rem;
  line-height: 1.65;
}

.kk-eyebrow {
  display: inline-block;
  font-size: 0.78rem;
  font-weight: 700;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--kk-purple-light);
  margin-bottom: 0.65rem;
}

.kk-section-header {
  margin-bottom: 2.5rem;
}
.kk-section-header > * + * {
  margin-top: 0.6rem;
}

/* ─── Animations ─────────────────────────────────────────────────────────────── */
.kk-animate {
  opacity: 0;
  transform: translateY(28px);
  transition: opacity 0.55s cubic-bezier(0.16,1,0.3,1),
              transform 0.55s cubic-bezier(0.16,1,0.3,1);
}
.kk-animate.kk-visible {
  opacity: 1;
  transform: translateY(0);
}
.kk-animate-delay-1 { transition-delay: 0.08s; }
.kk-animate-delay-2 { transition-delay: 0.16s; }
.kk-animate-delay-3 { transition-delay: 0.24s; }
.kk-animate-delay-4 { transition-delay: 0.32s; }

/* ─── Buttons ────────────────────────────────────────────────────────────────── */
.kk-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.45rem;
  padding: 0.8rem 1.5rem;
  border-radius: 0.75rem;
  font-weight: 700;
  font-size: 0.95rem;
  text-decoration: none;
  border: 1.5px solid transparent;
  cursor: pointer;
  transition: transform 0.15s ease, box-shadow 0.15s ease,
              background 0.15s ease, border-color 0.15s ease;
  white-space: nowrap;
}
.kk-btn:hover { transform: translateY(-1px); }

.kk-btn-primary {
  background: var(--kk-purple);
  border-color: var(--kk-purple);
  color: var(--kk-white);
  box-shadow: 0 4px 20px rgba(139,92,246,0.4);
}
.kk-btn-primary:hover {
  background: var(--kk-purple-dark);
  border-color: var(--kk-purple-dark);
  box-shadow: 0 6px 28px rgba(139,92,246,0.55);
  color: var(--kk-white);
}

.kk-btn-ghost {
  background: transparent;
  border-color: var(--kk-border);
  color: var(--kk-text);
}
.kk-btn-ghost:hover {
  border-color: var(--kk-border-hover);
  background: rgba(139,92,246,0.08);
  color: var(--kk-text);
}

/* ─── Glass card ─────────────────────────────────────────────────────────────── */
.kk-glass {
  background: var(--kk-bg-card);
  border: 1px solid var(--kk-border);
  border-radius: var(--kk-radius);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  box-shadow: 0 4px 24px rgba(0,0,0,0.35);
}

/* ─── App Store badge ────────────────────────────────────────────────────────── */
.kk-appstore-badge {
  display: inline-flex;
  align-items: center;
}
.kk-appstore-badge img {
  height: 54px;
  width: auto;
  display: block;
  border-radius: 0.5rem;
  transition: transform 0.2s ease;
}
.kk-appstore-badge:hover img {
  transform: translateY(-2px);
}

/* ─── Header ─────────────────────────────────────────────────────────────────── */
.kk-header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1000;
  background: rgba(10, 1, 24, 0.85);
  border-bottom: 1px solid var(--kk-border);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
}

.kk-header__inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  height: var(--kk-header-h);
}

.kk-brand {
  display: inline-flex;
  align-items: center;
  gap: 0.6rem;
  text-decoration: none;
  flex-shrink: 0;
}
.kk-brand__icon {
  border-radius: 22%;
  box-shadow: 0 2px 12px rgba(139,92,246,0.45);
  display: block;
}
.kk-brand__icon--sm {
  width: 32px;
  height: 32px;
}
.kk-brand__name {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 1.15rem;
  font-weight: 800;
  color: var(--kk-white);
  letter-spacing: -0.01em;
}

/* Desktop nav */
.kk-nav { display: none; }
.kk-nav ul {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  list-style: none;
  margin: 0;
  padding: 0;
}
.kk-nav a {
  color: var(--kk-text-muted);
  text-decoration: none;
  font-weight: 600;
  font-size: 0.9rem;
  padding: 0.45rem 0.8rem;
  border-radius: 0.5rem;
  transition: color 0.15s, background 0.15s;
}
.kk-nav a:hover {
  color: var(--kk-text);
  background: rgba(255,255,255,0.06);
}

/* Header right */
.kk-header__right {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  flex-shrink: 0;
}

/* Language switcher */
.kk-lang {
  display: inline-flex;
  align-items: center;
  border: 1px solid var(--kk-border);
  border-radius: 999px;
  overflow: hidden;
  font-size: 0.8rem;
  font-weight: 700;
}
.kk-lang a, .kk-lang span {
  padding: 0.3rem 0.6rem;
  text-decoration: none;
  color: var(--kk-text-muted);
  transition: background 0.15s, color 0.15s;
}
.kk-lang span.kk-lang--active {
  background: var(--kk-purple);
  color: var(--kk-white);
}
.kk-lang a:hover {
  background: rgba(139,92,246,0.12);
  color: var(--kk-text);
}

/* Header App Store button */
.kk-header-appstore { display: none; }
.kk-header-appstore img {
  height: 36px;
  width: auto;
  border-radius: 6px;
  transition: transform 0.2s ease;
}
.kk-header-appstore:hover img {
  transform: translateY(-1px);
}

/* Mobile menu toggle */
.kk-menu-toggle {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 5px;
  width: 2.6rem;
  height: 2.6rem;
  border: 1px solid var(--kk-border);
  border-radius: 0.55rem;
  background: transparent;
  cursor: pointer;
  padding: 0;
  min-height: 44px;
  min-width: 44px;
}
.kk-menu-toggle span {
  display: block;
  width: 1.1rem;
  height: 2px;
  background: var(--kk-text);
  border-radius: 2px;
  transition: transform 0.25s, opacity 0.25s;
}
.kk-menu-toggle[aria-expanded="true"] span:nth-child(1) {
  transform: translateY(7px) rotate(45deg);
}
.kk-menu-toggle[aria-expanded="true"] span:nth-child(2) {
  opacity: 0;
}
.kk-menu-toggle[aria-expanded="true"] span:nth-child(3) {
  transform: translateY(-7px) rotate(-45deg);
}

/* Mobile drawer */
.kk-mobile-nav {
  display: none;
  position: absolute;
  top: var(--kk-header-h);
  left: 0;
  right: 0;
  background: rgba(10, 1, 24, 0.97);
  border-bottom: 1px solid var(--kk-border);
  padding: 1rem 1.5rem 1.5rem;
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
}
.kk-mobile-nav.is-open { display: block; }
.kk-mobile-nav ul { list-style: none; margin: 0; padding: 0; }
.kk-mobile-nav li + li { border-top: 1px solid var(--kk-border); }
.kk-mobile-nav a {
  display: flex;
  align-items: center;
  padding: 0.85rem 0;
  color: var(--kk-text);
  text-decoration: none;
  font-weight: 600;
  font-size: 1rem;
  min-height: 44px;
}
.kk-mobile-nav .kk-lang { margin-top: 1rem; }

/* Content push-down */
.kk-main { padding-top: var(--kk-header-h); }

/* ─── Footer ─────────────────────────────────────────────────────────────────── */
.kk-footer {
  background: rgba(10, 1, 24, 0.9);
  border-top: 1px solid var(--kk-border);
  padding-block: 3rem 2.5rem;
}
.kk-footer__layout { display: grid; gap: 2rem; }
.kk-footer__brand { display: flex; flex-direction: column; gap: 0.6rem; }
.kk-footer__tagline {
  font-size: 0.9rem;
  color: var(--kk-text-muted);
  max-width: 22rem;
  line-height: 1.6;
}
.kk-footer__nav {
  display: flex;
  flex-direction: column;
  gap: 0.65rem;
}
.kk-footer__nav a {
  color: var(--kk-text-muted);
  text-decoration: none;
  font-weight: 600;
  font-size: 0.9rem;
  transition: color 0.15s;
}
.kk-footer__nav a:hover { color: var(--kk-text); }
.kk-footer__meta {
  display: flex;
  flex-direction: column;
  gap: 0.65rem;
}
.kk-footer__copy {
  font-size: 0.88rem;
  color: rgba(245,243,255,0.45);
}

/* ─── Static page styles (privacy, kvkk, contact) ────────────────────────────── */
.kk-page-header {
  padding: 3rem 0 2.5rem;
  background: rgba(19,7,40,0.6);
  border-bottom: 1px solid var(--kk-border);
}
.kk-page-header h1 {
  font-size: clamp(1.7rem, 4vw, 2.6rem);
}
.kk-page-content {
  padding-block: 3rem 5rem;
}
.kk-page-content h2 {
  font-size: clamp(1.2rem, 2.5vw, 1.5rem);
  margin-top: 2.5rem;
  margin-bottom: 0.85rem;
  color: var(--kk-purple-light);
}
.kk-page-content h2:first-child {
  margin-top: 0;
}
.kk-page-content p,
.kk-page-content li {
  color: var(--kk-text-muted);
  line-height: 1.75;
  margin-top: 0.6rem;
}
.kk-page-content ul {
  padding-left: 1.5rem;
  margin-top: 0.6rem;
}
.kk-page-content a {
  color: var(--kk-purple-light);
  text-decoration: underline;
  text-underline-offset: 3px;
}
.kk-page-content .kk-effective {
  font-size: 0.88rem;
  color: rgba(245,243,255,0.45);
  margin-bottom: 2rem;
}

/* ─── Blog listing ───────────────────────────────────────────────────────────── */
.kk-blog-grid {
  display: grid;
  gap: 1.5rem;
}
.kk-post-card {
  padding: clamp(1.5rem, 4vw, 2rem);
  transition: border-color 0.2s, box-shadow 0.2s;
}
.kk-post-card:hover {
  border-color: var(--kk-border-hover);
  box-shadow: 0 8px 32px rgba(139,92,246,0.2);
}
.kk-post-card__date {
  font-size: 0.8rem;
  color: var(--kk-text-dim);
  text-transform: uppercase;
  letter-spacing: 0.06em;
  margin-bottom: 0.5rem;
}
.kk-post-card h3 {
  margin-bottom: 0.6rem;
}
.kk-post-card h3 a {
  color: var(--kk-text);
  text-decoration: none;
  transition: color 0.15s;
}
.kk-post-card h3 a:hover {
  color: var(--kk-purple-light);
}
.kk-post-card__excerpt {
  color: var(--kk-text-dim);
  line-height: 1.7;
  font-size: 0.95rem;
  margin-bottom: 1rem;
}
.kk-post-card__more {
  color: var(--kk-purple-light);
  text-decoration: none;
  font-weight: 600;
  font-size: 0.9rem;
  transition: color 0.15s;
}
.kk-post-card__more:hover {
  color: var(--kk-purple);
}

.kk-pagination {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
  margin-top: 3rem;
}
.kk-pagination a,
.kk-pagination span {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 2.5rem;
  height: 2.5rem;
  padding: 0.4rem 0.8rem;
  border-radius: 0.5rem;
  border: 1px solid var(--kk-border);
  color: var(--kk-text-muted);
  text-decoration: none;
  font-weight: 600;
  font-size: 0.9rem;
  transition: border-color 0.15s, background 0.15s, color 0.15s;
}
.kk-pagination a:hover {
  border-color: var(--kk-border-hover);
  background: rgba(139,92,246,0.08);
  color: var(--kk-text);
}
.kk-pagination .current {
  background: var(--kk-purple);
  border-color: var(--kk-purple);
  color: var(--kk-white);
}

.kk-no-posts {
  text-align: center;
  padding: 3rem 1rem;
  color: var(--kk-text-muted);
  font-size: 1.1rem;
}

/* ─── Contact form ───────────────────────────────────────────────────────────── */
.kk-contact-form {
  max-width: 40rem;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}
.kk-form-group {
  display: flex;
  flex-direction: column;
  gap: 0.4rem;
}
.kk-form-group label {
  font-weight: 600;
  font-size: 0.9rem;
  color: var(--kk-text-muted);
}
.kk-form-group input,
.kk-form-group textarea {
  background: rgba(255,255,255,0.08);
  border: 1.5px solid var(--kk-border);
  border-radius: 14px;
  padding: 0.85rem 1rem;
  color: var(--kk-text);
  font-family: inherit;
  font-size: 1rem;
  outline: none;
  transition: border-color 0.2s, box-shadow 0.2s;
  width: 100%;
}
.kk-form-group input:focus,
.kk-form-group textarea:focus {
  border-color: var(--kk-purple);
  box-shadow: 0 0 0 3px rgba(139,92,246,0.2);
}
.kk-form-group input::placeholder,
.kk-form-group textarea::placeholder {
  color: var(--kk-text-dim);
}
.kk-form-group textarea {
  min-height: 10rem;
  resize: vertical;
}
.kk-form-submit {
  align-self: flex-start;
}
.kk-form-message {
  padding: 1rem 1.25rem;
  border-radius: 14px;
  font-weight: 600;
  font-size: 0.95rem;
  margin-bottom: 1rem;
}
.kk-form-message--success {
  background: rgba(52,211,153,0.12);
  border: 1px solid rgba(52,211,153,0.3);
  color: var(--kk-green);
}
.kk-form-message--error {
  background: rgba(239,68,68,0.12);
  border: 1px solid rgba(239,68,68,0.3);
  color: #f87171;
}

/* ─── Responsive — tablet (>= 640px) ─────────────────────────────────────────── */
@media (min-width: 40rem) {
  .kk-blog-grid { grid-template-columns: repeat(2, 1fr); }
  .kk-footer__layout { grid-template-columns: 1fr 1fr; }
  .kk-footer__nav { flex-direction: row; flex-wrap: wrap; gap: 1rem; }
}

/* ─── Responsive — desktop (>= 1024px) ───────────────────────────────────────── */
@media (min-width: 64rem) {
  .kk-shell { padding-inline: 2rem; }
  .kk-nav { display: block; }
  .kk-menu-toggle { display: none; }
  .kk-header-appstore { display: inline-block; }
  .kk-blog-grid { grid-template-columns: repeat(2, 1fr); }
  .kk-footer__layout {
    grid-template-columns: 1.2fr 1fr 1fr;
    align-items: start;
  }
}
</style>
