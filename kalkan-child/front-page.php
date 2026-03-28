<?php
/**
 * Front page template — Kalkan child theme.
 * Fully self-contained: no get_header()/get_footer() to avoid Blocksy conflicts.
 *
 * @package kalkan-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ── Shared setup ──────────────────────────────────────────────────────────── */
include get_stylesheet_directory() . '/inc/kalkan-setup.php';

/* ── Inline SVG icons (all 48×48 with proper stroke) ───────────────────────── */
$icons = array(
	'shield' => '<svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="url(#grad1)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><defs><linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#a78bfa"/><stop offset="100%" style="stop-color:#7c3aed"/></linearGradient></defs><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>',
	'phone'  => '<svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="url(#grad2)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><defs><linearGradient id="grad2" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#a78bfa"/><stop offset="100%" style="stop-color:#7c3aed"/></linearGradient></defs><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="14" y1="4" x2="18" y2="4"/></svg>',
	'lock'   => '<svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="url(#grad3)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><defs><linearGradient id="grad3" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#a78bfa"/><stop offset="100%" style="stop-color:#7c3aed"/></linearGradient></defs><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><rect x="9" y="11" width="6" height="4.5" rx="1"/><path d="M10 11V9a2 2 0 0 1 4 0v2"/></svg>',
	'flag'   => '<svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="url(#grad4)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><defs><linearGradient id="grad4" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#a78bfa"/><stop offset="100%" style="stop-color:#7c3aed"/></linearGradient></defs><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg>',
	'trust'  => '<svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>',
);

$icon = static function ( string $name ) use ( $icons ) : string {
	return $icons[ $name ] ?? '';
};

$page_title = 'en' === $lang ? 'Kalkan — Your Shield Against Spam Calls' : 'Kalkan — Spam Aramalara Karşı Kalkanınız';
$is_front_page = true;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
<?php wp_head(); ?>
<?php include get_stylesheet_directory() . '/inc/kalkan-styles.php'; ?>
<style>
/* ─── Homepage-specific styles ───────────────────────────────────────────────── */
.kk-hero {
  position: relative;
  overflow: hidden;
  padding-block: clamp(4rem, 12vw, 8rem) clamp(3rem, 8vw, 6rem);
  background:
    radial-gradient(ellipse 80% 60% at 80% 0%, rgba(139,92,246,0.18) 0%, transparent 65%),
    radial-gradient(ellipse 50% 40% at 10% 100%, rgba(109,40,217,0.12) 0%, transparent 60%);
}
.kk-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background-image: radial-gradient(rgba(139,92,246,0.08) 1px, transparent 1px);
  background-size: 32px 32px;
  pointer-events: none;
}
.kk-hero__layout { display: grid; gap: 3rem; position: relative; }
.kk-hero__content > * + * { margin-top: 1.2rem; }
.kk-hero__subtitle {
  font-size: clamp(1.05rem, 2.4vw, 1.2rem);
  color: var(--kk-text-muted);
  max-width: 40rem;
  line-height: 1.65;
}
/* ===== HERO BUTTONS — DESKTOP ===== */
.hero-buttons {
  display: flex; flex-direction: row; align-items: center; gap: 16px; margin-top: 32px;
}
.hero-appstore {
  display: inline-flex; align-items: center; text-decoration: none; flex-shrink: 0;
}
.hero-appstore img {
  height: 44px; width: auto; display: block;
}
.hero-secondary-btn {
  display: inline-flex; align-items: center; justify-content: center;
  height: 44px; padding: 0 24px; font-size: 15px; font-weight: 600;
  font-family: inherit; color: rgba(245,243,255,0.9);
  border: 1px solid rgba(255,255,255,0.2); border-radius: 10px;
  background: transparent; text-decoration: none; white-space: nowrap;
  transition: border-color 0.2s ease, background 0.2s ease; box-sizing: border-box;
}
.hero-secondary-btn:hover {
  border-color: rgba(139,92,246,0.5); background: rgba(139,92,246,0.1); color: #f5f3ff;
}
.kk-hero__visual { display: flex; justify-content: center; align-items: center; }
.phone-frame {
  position: relative;
  width: 280px;
  height: 572px;
  background: #000000;
  border-radius: 44px;
  border: 4px solid #2a2a3a;
  box-shadow:
    0 0 0 1px rgba(255, 255, 255, 0.08),
    0 30px 80px rgba(0, 0, 0, 0.5),
    0 0 40px rgba(139, 92, 246, 0.12),
    inset 0 0 2px rgba(255, 255, 255, 0.05);
  overflow: hidden;
}
.phone-notch {
  position: absolute;
  top: 10px;
  left: 50%;
  transform: translateX(-50%);
  width: 100px;
  height: 28px;
  background: #000000;
  border-radius: 20px;
  z-index: 10;
}
.phone-screen {
  width: 100%;
  height: 100%;
  overflow: hidden;
  border-radius: 40px;
}
.phone-screen img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.kk-how { background: rgba(19,7,40,0.6); }
.kk-steps { display: grid; gap: 1.5rem; }
.kk-step { padding: clamp(1.5rem, 4vw, 2rem); position: relative; }
.kk-step__num {
  display: inline-flex; align-items: center; justify-content: center;
  width: 3.5rem; height: 3.5rem; border-radius: 50%;
  background: linear-gradient(135deg, var(--kk-purple), var(--kk-purple-dark));
  color: var(--kk-white); font-weight: 800; font-size: 1.25rem;
  margin-bottom: 1rem;
  box-shadow: 0 4px 20px rgba(139,92,246,0.4);
}
.kk-step h3 { margin-bottom: 0.5rem; }
.kk-step p { color: var(--kk-text-dim); line-height: 1.7; }

.kk-feature-grid { display: grid; gap: 1.5rem; }
.kk-feature-card {
  padding: clamp(1.5rem, 4vw, 2rem); position: relative;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.kk-feature-card:hover {
  border-color: var(--kk-border-hover);
  box-shadow: 0 8px 32px rgba(139,92,246,0.2);
}
.kk-feature-card__icon {
  width: 64px; height: 64px; border-radius: 16px;
  background: rgba(139,92,246,0.1); border: 1px solid rgba(139,92,246,0.25);
  display: inline-flex; align-items: center; justify-content: center;
  margin-bottom: 1.25rem; flex-shrink: 0;
}
.kk-feature-card__icon svg { width: 52px; height: 52px; display: block; }
.kk-feature-card h3 { margin-bottom: 0.5rem; }
.kk-feature-card p { color: var(--kk-text-dim); line-height: 1.7; }

.kk-badge-free {
  display: inline-block; margin-top: 0.85rem;
  padding: 0.3rem 0.85rem; border-radius: 999px;
  background: rgba(139,92,246,0.15); border: 1px solid rgba(139,92,246,0.3);
  color: var(--kk-purple-light); font-size: 0.78rem; font-weight: 700;
  letter-spacing: 0.04em;
}

.kk-trust { background: rgba(26,5,51,0.6); position: relative; overflow: hidden; }
.kk-trust::before {
  content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%);
  width: 600px; height: 1px;
  background: linear-gradient(90deg, transparent, var(--kk-purple), transparent);
}
.kk-trust__layout { display: grid; gap: 2.5rem; }
.kk-trust__shield { display: flex; justify-content: center; align-items: center; }
.kk-shield-icon {
  width: min(9rem, 44vw); aspect-ratio: 1; border-radius: 50%;
  display: inline-flex; align-items: center; justify-content: center;
  background: radial-gradient(circle at 35% 35%, rgba(139,92,246,0.3) 0%, rgba(52,211,153,0.1) 100%);
  border: 1.5px solid rgba(52,211,153,0.25);
  box-shadow: 0 0 40px rgba(52,211,153,0.15), 0 12px 40px rgba(0,0,0,0.3);
}
.kk-shield-icon svg { width: 48px; height: 48px; }
.kk-trust__list {
  list-style: none; margin: 1.5rem 0 0; padding: 0;
  display: flex; flex-direction: column; gap: 0.85rem;
}
.kk-trust__list li {
  display: flex; gap: 0.75rem; align-items: flex-start;
  color: var(--kk-text-muted); font-size: 1rem; line-height: 1.5;
}
.kk-trust__list li::before {
  content: ''; display: inline-flex; flex-shrink: 0;
  width: 1.25rem; height: 1.25rem; margin-top: 0.15rem;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%2334d399'%3E%3Cpath d='M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z'/%3E%3C/svg%3E");
  background-size: contain; background-repeat: no-repeat;
}
.kk-trust__links { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1.75rem; }
.kk-trust__links a {
  display: inline-block; padding: 0.45rem 1rem; border-radius: 999px;
  border: 1px solid var(--kk-border); color: var(--kk-text-muted);
  font-weight: 600; font-size: 0.88rem; text-decoration: none;
  transition: border-color 0.15s, color 0.15s, background 0.15s;
}
.kk-trust__links a:hover {
  border-color: var(--kk-border-hover); color: var(--kk-text);
  background: rgba(139,92,246,0.08);
}

.kk-cta__card {
  padding: clamp(2.5rem, 6vw, 4rem); text-align: center;
  background: linear-gradient(135deg, rgba(109,40,217,0.35) 0%, rgba(139,92,246,0.18) 50%, rgba(15,5,32,0.8) 100%);
  border: 1px solid rgba(139,92,246,0.3); border-radius: var(--kk-radius);
  position: relative; overflow: hidden;
}
.kk-cta__card::before {
  content: ''; position: absolute; top: -50%; left: -20%;
  width: 60%; height: 150%;
  background: radial-gradient(ellipse, rgba(139,92,246,0.2) 0%, transparent 60%);
  pointer-events: none;
}
.kk-cta__card h2, .kk-cta__card .kk-lead, .cta-appstore { position: relative; }
.kk-cta__card .kk-lead { margin-inline: auto; }
/* ===== CTA BADGE ===== */
.cta-appstore {
  display: flex; justify-content: center; margin-top: 28px;
}
.cta-appstore img {
  height: 44px; width: auto;
}

.kk-faq { background: rgba(19,7,40,0.6); }
.kk-accordion {
  display: flex; flex-direction: column; gap: 0.75rem;
  max-width: 48rem; margin: 0 auto;
}
.kk-faq-item {
  border: 1px solid var(--kk-border); border-radius: var(--kk-radius-sm);
  background: rgba(255,255,255,0.04); transition: border-color 0.2s; overflow: hidden;
}
.kk-faq-item.active { border-color: rgba(139,92,246,0.35); }
.kk-faq-question {
  display: flex; justify-content: space-between; align-items: center; gap: 1rem;
  padding: 1.15rem 1.35rem; cursor: pointer; width: 100%; border: none;
  background: transparent; text-align: left;
  font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 1rem;
  color: var(--kk-text); user-select: none; min-height: 44px;
}
.kk-faq-toggle {
  font-size: 28px; font-weight: 300; color: var(--kk-purple);
  flex-shrink: 0; line-height: 1;
  font-family: 'Plus Jakarta Sans', Arial, sans-serif;
  user-select: none;
}
.kk-faq-answer {
  max-height: 0; overflow: hidden;
  transition: max-height 0.3s ease;
}
.kk-faq-answer p {
  padding: 0 1.35rem 1.35rem; color: var(--kk-text-dim);
  line-height: 1.7; font-size: 0.97rem;
}

/* ===== SUBSCRIBE FORM ===== */
.kk-subscribe { background: rgba(19,7,40,0.4); }
.kk-subscribe-form { margin-top: 1.5rem; }
.kk-subscribe-row {
  display: flex; gap: 0; border-radius: 12px; overflow: hidden;
  border: 1px solid var(--kk-border);
  background: rgba(255,255,255,0.04);
  transition: border-color 0.2s;
}
.kk-subscribe-row:focus-within { border-color: rgba(139,92,246,0.5); }
.kk-subscribe-input {
  flex: 1; min-width: 0; padding: 0.85rem 1rem;
  background: transparent; border: none; outline: none;
  color: var(--kk-text); font-family: inherit; font-size: 0.95rem;
}
.kk-subscribe-input::placeholder { color: var(--kk-text-dim); }
.kk-subscribe-btn-wrap { display: flex; justify-content: center; margin-top: 1rem; }
.kk-subscribe-btn {
  display: inline-flex; align-items: center; justify-content: center;
  padding: 0.7rem 2rem; border: none; cursor: pointer; border-radius: 10px;
  background: linear-gradient(135deg, var(--kk-purple), var(--kk-purple-dark));
  color: #fff; font-family: inherit; font-size: 0.95rem; font-weight: 600;
  white-space: nowrap; transition: opacity 0.2s;
}
.kk-subscribe-btn:hover { opacity: 0.85; }
.kk-subscribe-btn:disabled { opacity: 0.5; cursor: not-allowed; }
.kk-subscribe-consent {
  display: flex; align-items: flex-start; gap: 0.5rem;
  margin-top: 0.75rem; font-size: 0.82rem; color: var(--kk-text-dim);
  cursor: pointer; line-height: 1.45;
}
.kk-subscribe-consent input[type="checkbox"] {
  width: 16px; height: 16px; margin-top: 1px; flex-shrink: 0;
  accent-color: var(--kk-purple);
}
.kk-subscribe-consent a { color: var(--kk-purple-light); text-decoration: underline; }
.kk-subscribe-msg {
  margin-top: 0.6rem; font-size: 0.88rem; min-height: 1.4em;
}
.kk-subscribe-msg.success { color: var(--kk-green); }
.kk-subscribe-msg.error { color: #f87171; }
.kk-subscribe-form.submitted .kk-subscribe-row,
.kk-subscribe-form.submitted .kk-subscribe-consent,
.kk-subscribe-form.submitted .kk-subscribe-btn-wrap { opacity: 0.5; pointer-events: none; }

/* ===== HERO BUTTONS — MOBILE ===== */
@media (max-width: 768px) {
  .phone-frame {
    width: 240px; height: 490px; margin: 0 auto;
  }
  .phone-notch { width: 80px; height: 22px; top: 8px; }
  .phone-screen { border-radius: 36px; }
  .hero-buttons {
    flex-direction: column; align-items: center; gap: 12px;
  }
  .hero-appstore img { height: 44px; }
  .hero-secondary-btn {
    height: 44px; width: auto; padding: 0 32px; font-size: 14px;
  }
  .cta-appstore img { height: 44px; }
}

@media (min-width: 40rem) {
  .kk-steps { grid-template-columns: repeat(3, 1fr); }
  .kk-feature-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (min-width: 769px) {
  .phone-frame { width: 300px; height: 612px; }
}
@media (min-width: 64rem) {
  .kk-hero__layout { grid-template-columns: 1.1fr 0.9fr; align-items: center; gap: 4rem; }
  .kk-feature-grid { grid-template-columns: repeat(2, 1fr); }
  .kk-trust__layout { grid-template-columns: 0.3fr 1fr; align-items: center; gap: 4rem; }
}
</style>
</head>
<body <?php body_class(); ?>>

<div class="kk-page">

	<?php include get_stylesheet_directory() . '/inc/kalkan-header.php'; ?>

	<main class="kk-main" id="kk-main">

		<!-- ── HERO ─────────────────────────────────────────────────────────── -->
		<section class="kk-hero kk-section" aria-labelledby="kk-hero-title">
			<div class="kk-shell kk-hero__layout">

				<div class="kk-hero__content">
					<span class="kk-eyebrow kk-animate"><?php echo esc_html( $__( 'iOS Spam Engelleyici', 'iOS Spam Blocker' ) ); ?></span>
					<h1 id="kk-hero-title" class="kk-animate kk-animate-delay-1">
						<?php echo esc_html( $__( 'Spam Aramalara Karşı Kalkanınız', 'Your Shield Against Spam Calls' ) ); ?>
					</h1>
					<p class="kk-hero__subtitle kk-animate kk-animate-delay-2">
						<?php echo esc_html( $__( 'Kalkan, iOS cihazınızda istenmeyen aramaları engeller ve bilinmeyen numaraları tanımlar.', 'Kalkan blocks unwanted calls and identifies unknown numbers on your iPhone.' ) ); ?>
					</p>

					<div class="hero-buttons kk-animate kk-animate-delay-3">
						<a href="<?php echo esc_url( $appstore_link ); ?>" class="hero-appstore">
							<img src="<?php echo esc_url( $badge_url ); ?>" alt="<?php echo esc_attr( $__( 'App Store\'dan İndir', 'Download on the App Store' ) ); ?>" loading="eager" decoding="async">
						</a>
						<a class="hero-secondary-btn" href="#kk-how">
							<?php echo esc_html( $__( 'Nasıl çalışır?', 'How it works?' ) ); ?>
						</a>
					</div>
				</div>

				<div class="kk-hero__visual kk-animate kk-animate-delay-2" aria-hidden="true">
					<?php
					$hero_screenshot = ( 'tr' === $lang )
						? get_stylesheet_directory_uri() . '/assets/images/Main-Screen-1-tr.png'
						: get_stylesheet_directory_uri() . '/assets/images/Main-Screen-1-en.png';
					?>
					<div class="phone-frame">
						<div class="phone-notch"></div>
						<div class="phone-screen">
							<img src="<?php echo esc_url( $hero_screenshot ); ?>"
								alt="<?php echo esc_attr( $__( 'Kalkan Uygulama Ekranı', 'Kalkan App Screen' ) ); ?>"
								width="280"
								height="606"
								loading="eager">
						</div>
					</div>
				</div>

			</div>
		</section>

		<!-- ── HOW IT WORKS ──────────────────────────────────────────────────── -->
		<section class="kk-how kk-section" id="kk-how" aria-labelledby="kk-how-title">
			<div class="kk-shell">
				<div class="kk-section-header kk-animate">
					<span class="kk-eyebrow"><?php echo esc_html( $__( 'Nasıl Çalışır', 'How It Works' ) ); ?></span>
					<h2 id="kk-how-title"><?php echo esc_html( $__( '3 Adımda Koruma', '3-Step Protection' ) ); ?></h2>
					<p class="kk-lead"><?php echo esc_html( $__( 'Kurulumu basit, kullanımı kolay, koruma güçlü.', 'Simple setup, easy to use, powerful protection.' ) ); ?></p>
				</div>

				<div class="kk-steps">
					<div class="kk-step kk-glass kk-animate kk-animate-delay-1">
						<div class="kk-step__num">1</div>
						<h3><?php echo esc_html( $__( 'İndir ve Kur', 'Download & Setup' ) ); ?></h3>
						<p><?php echo esc_html( $__( 'Kalkan\'ı App Store\'dan indirin ve arama korumayı etkinleştirin.', 'Download Kalkan from the App Store and enable call protection.' ) ); ?></p>
					</div>
					<div class="kk-step kk-glass kk-animate kk-animate-delay-2">
						<div class="kk-step__num">2</div>
						<h3><?php echo esc_html( $__( 'Otomatik Koruma', 'Automatic Protection' ) ); ?></h3>
						<p><?php echo esc_html( $__( 'Bilinen spam numaralar otomatik olarak engellenir veya işaretlenir.', 'Known spam numbers are automatically blocked or flagged.' ) ); ?></p>
					</div>
					<div class="kk-step kk-glass kk-animate kk-animate-delay-3">
						<div class="kk-step__num">3</div>
						<h3><?php echo esc_html( $__( 'Bildir ve Güçlendir', 'Report & Strengthen' ) ); ?></h3>
						<p><?php echo esc_html( $__( 'Şüpheli numaraları bildirerek topluluğun korunmasına katkıda bulunun.', 'Report suspicious numbers and help protect the community.' ) ); ?></p>
					</div>
				</div>
			</div>
		</section>

		<!-- ── FEATURES ──────────────────────────────────────────────────────── -->
		<section class="kk-features kk-section" id="kk-features" aria-labelledby="kk-features-title">
			<div class="kk-shell">
				<div class="kk-section-header kk-animate">
					<span class="kk-eyebrow"><?php echo esc_html( $__( 'Özellikler', 'Features' ) ); ?></span>
					<h2 id="kk-features-title"><?php echo esc_html( $__( 'Temel Özellikler', 'Core Features' ) ); ?></h2>
					<p class="kk-lead"><?php echo esc_html( $__( 'Günlük aramaları güvenli hale getiren araçlar.', 'Tools that make your daily calls safer.' ) ); ?></p>
				</div>

				<div class="kk-feature-grid">
					<div class="kk-feature-card kk-glass kk-animate kk-animate-delay-1">
						<div class="kk-feature-card__icon" aria-hidden="true"><?php echo $icon( 'shield' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
						<h3><?php echo esc_html( $__( 'Spam Koruması', 'Spam Protection' ) ); ?></h3>
						<p><?php echo esc_html( $__( 'Bilinen spam numaralar sistem entegrasyonu ile engellenir. Veritabanı cihazınıza yüklenir ve koruma çevrimdışı çalışır.', 'Known spam numbers are blocked via system integration. The database is loaded to your device and protection works offline.' ) ); ?></p>
					</div>
					<div class="kk-feature-card kk-glass kk-animate kk-animate-delay-2">
						<div class="kk-feature-card__icon" aria-hidden="true"><?php echo $icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
						<h3><?php echo esc_html( $__( 'Arayan Kimliği', 'Caller Identification' ) ); ?></h3>
						<p><?php echo esc_html( $__( 'Bilinmeyen numaralar hakkında bilgi görüntüler. Kimin aradığını tahmin etmenize gerek kalmaz.', 'Shows information about unknown numbers. No more guessing who\'s calling.' ) ); ?></p>
					</div>
					<div class="kk-feature-card kk-glass kk-animate kk-animate-delay-3">
						<div class="kk-feature-card__icon" aria-hidden="true"><?php echo $icon( 'lock' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
						<h3><?php echo esc_html( $__( 'Ekstra Koruma', 'Extra Protection' ) ); ?></h3>
						<p><?php echo esc_html( $__( 'Genişletilmiş koruma ile daha fazla spam numara engellenir. Sürekli güncellenen veritabanı ile kapsamlı güvenlik.', 'Extended protection blocks even more spam numbers. Comprehensive security with continuously updated database.' ) ); ?></p>
						<span class="kk-badge-free"><?php echo esc_html( $__( 'Şimdilik Ücretsiz', 'Free for Now' ) ); ?></span>
					</div>
					<div class="kk-feature-card kk-glass kk-animate kk-animate-delay-4">
						<div class="kk-feature-card__icon" aria-hidden="true"><?php echo $icon( 'flag' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
						<h3><?php echo esc_html( $__( 'İletişim Bildirimi', 'Communication Reporting' ) ); ?></h3>
						<p><?php echo esc_html( $__( 'Şüpheli numaraları doğrudan Telefon uygulamasından veya Kalkan içinden kolayca bildirin.', 'Easily report suspicious numbers directly from the Phone app or from within Kalkan.' ) ); ?></p>
					</div>
				</div>
			</div>
		</section>

		<!-- ── TRUST ─────────────────────────────────────────────────────────── -->
		<section class="kk-trust kk-section" aria-labelledby="kk-trust-title">
			<div class="kk-shell kk-trust__layout">
				<div class="kk-trust__shield kk-animate" aria-hidden="true">
					<div class="kk-shield-icon"><?php echo $icon( 'trust' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
				</div>
				<div class="kk-trust__content kk-animate kk-animate-delay-1">
					<span class="kk-eyebrow"><?php echo esc_html( $__( 'Gizlilik', 'Privacy' ) ); ?></span>
					<h2 id="kk-trust-title"><?php echo esc_html( $__( 'Gizliliğinize Saygı Duyuyoruz', 'We Respect Your Privacy' ) ); ?></h2>
					<ul class="kk-trust__list">
						<li><?php echo esc_html( $__( 'Rehberinize veya arama kayıtlarınıza erişmeyiz', 'We don\'t access your contacts or call logs' ) ); ?></li>
						<li><?php echo esc_html( $__( 'Tüm arama koruma işlemleri cihazınızda gerçekleşir', 'All call protection happens on your device' ) ); ?></li>
						<li><?php echo esc_html( $__( 'Verileriniz üçüncü taraflara satılmaz', 'Your data is never sold to third parties' ) ); ?></li>
					</ul>
					<div class="kk-trust__links">
						<a href="<?php echo $what_is_url; ?>"><?php echo esc_html( $__( 'Kalkan Nedir?', 'What is Kalkan?' ) ); ?></a>
						<a href="<?php echo $how_works_url; ?>"><?php echo esc_html( $__( 'Nasıl Çalışır?', 'How It Works?' ) ); ?></a>
						<a href="<?php echo $how_to_use_url; ?>"><?php echo esc_html( $__( 'Nasıl Kullanılır?', 'How to Use?' ) ); ?></a>
						<a href="<?php echo $privacy_url; ?>"><?php echo esc_html( $__( 'Gizlilik Politikası', 'Privacy Policy' ) ); ?></a>
						<a href="<?php echo $kvkk_url; ?>"><?php echo esc_html( $__( 'KVKK Aydınlatma', 'Legal Notice' ) ); ?></a>
					</div>
				</div>
			</div>
		</section>

		<!-- ── CTA ───────────────────────────────────────────────────────────── -->
		<section class="kk-cta kk-section" aria-labelledby="kk-cta-title">
			<div class="kk-shell">
				<div class="kk-cta__card kk-animate">
					<h2 id="kk-cta-title"><?php echo esc_html( $__( 'Kalkan ile Huzurlu Arama Deneyimi', 'Peaceful Calling Experience with Kalkan' ) ); ?></h2>
					<p class="kk-lead"><?php echo esc_html( $__( 'Hemen indirin, spam aramalardan kurtulun.', 'Download now and get rid of spam calls.' ) ); ?></p>
					<div class="cta-appstore">
						<a href="<?php echo esc_url( $appstore_link ); ?>">
							<img src="<?php echo esc_url( $badge_url ); ?>" alt="<?php echo esc_attr( $__( 'App Store\'dan İndir', 'Download on the App Store' ) ); ?>" loading="lazy" decoding="async">
						</a>
					</div>
				</div>
			</div>
		</section>

		<!-- ── SUBSCRIBE ────────────────────────────────────────────────────── -->
		<section class="kk-subscribe kk-section" id="kk-subscribe" aria-labelledby="kk-subscribe-title">
			<div class="kk-shell" style="max-width:36rem;">
				<div class="kk-section-header kk-animate" style="text-align:center;">
					<span class="kk-eyebrow"><?php echo esc_html( $__( 'Bülten aboneliği', 'Newsletter' ) ); ?></span>
					<h2 id="kk-subscribe-title"><?php echo esc_html( $__( 'E-posta listemize kaydolun', 'Join Our Mailing List' ) ); ?></h2>
					<p class="kk-lead"><?php echo esc_html( $__( 'Yeni özellikler ve güncellemelerden haberdar olmak için bültenimize abone olun.', 'Subscribe to our newsletter for new features and updates.' ) ); ?></p>
				</div>
				<?php echo do_shortcode( '[kalkan_subscribe]' ); ?>
			</div>
		</section>

		<!-- ── FAQ ───────────────────────────────────────────────────────────── -->
		<section class="kk-faq kk-section" id="kk-faq" aria-labelledby="kk-faq-title">
			<div class="kk-shell">
				<div class="kk-section-header kk-animate" style="text-align:center;">
					<span class="kk-eyebrow"><?php echo esc_html( $__( 'Sıkça Sorulan Sorular', 'Frequently Asked Questions' ) ); ?></span>
					<h2 id="kk-faq-title"><?php echo esc_html( $__( 'SSS', 'FAQ' ) ); ?></h2>
				</div>

				<div class="kk-accordion kk-animate kk-animate-delay-1">

					<div class="kk-faq-item">
						<button class="kk-faq-question" type="button">
							<span><?php echo esc_html( $__( 'Kalkan nasıl çalışır?', 'How does Kalkan work?' ) ); ?></span>
							<span class="kk-faq-toggle">+</span>
						</button>
						<div class="kk-faq-answer">
							<p><?php echo esc_html( $__( 'Kalkan, bilinen spam numaraların veritabanını cihazınıza yükler. iOS\'un arama dizini sistemi ile entegre çalışarak gelen aramaları engeller veya işaretler. İnternet bağlantısı gerektirmez.', 'Kalkan loads a database of known spam numbers to your device. It works with iOS\'s call directory system to block or flag incoming calls. No internet connection required.' ) ); ?></p>
						</div>
					</div>

					<div class="kk-faq-item">
						<button class="kk-faq-question" type="button">
							<span><?php echo esc_html( $__( 'Kalkan gerçek zamanlı arama analizi yapıyor mu?', 'Does Kalkan do real-time call analysis?' ) ); ?></span>
							<span class="kk-faq-toggle">+</span>
						</button>
						<div class="kk-faq-answer">
							<p><?php echo esc_html( $__( 'Hayır. iOS platformu gerçek zamanlı arama analizine izin vermez. Kalkan, önceden yüklenmiş veritabanı ile çalışır. Bu Apple\'ın güvenlik kısıtlamalarından kaynaklanmaktadır.', 'No. iOS does not allow real-time call analysis. Kalkan works with a preloaded database. This is due to Apple\'s security restrictions.' ) ); ?></p>
						</div>
					</div>

					<div class="kk-faq-item">
						<button class="kk-faq-question" type="button">
							<span><?php echo esc_html( $__( 'Ekstra Koruma nedir?', 'What is Extra Protection?' ) ); ?></span>
							<span class="kk-faq-toggle">+</span>
						</button>
						<div class="kk-faq-answer">
							<p><?php echo esc_html( $__( 'Ekstra Koruma, standart spam listesinin ötesinde genişletilmiş numara kalıplarını engelleyen gelişmiş bir koruma katmanıdır. Şu anda ücretsizdir.', 'Extra Protection is an advanced layer that blocks extended number patterns beyond the standard spam list. It\'s currently free.' ) ); ?></p>
						</div>
					</div>

					<div class="kk-faq-item">
						<button class="kk-faq-question" type="button">
							<span><?php echo esc_html( $__( 'Verilerim güvende mi?', 'Is my data safe?' ) ); ?></span>
							<span class="kk-faq-toggle">+</span>
						</button>
						<div class="kk-faq-answer">
							<p><?php echo esc_html( $__( 'Evet. Kalkan rehberinize veya arama geçmişinize erişmez. Tüm arama koruma işlemleri cihazınızda yerel olarak gerçekleşir.', 'Yes. Kalkan doesn\'t access your contacts or call history. All call protection happens locally on your device.' ) ); ?></p>
						</div>
					</div>

					<div class="kk-faq-item">
						<button class="kk-faq-question" type="button">
							<span><?php echo esc_html( $__( 'Kalkan ücretsiz mi?', 'Is Kalkan free?' ) ); ?></span>
							<span class="kk-faq-toggle">+</span>
						</button>
						<div class="kk-faq-answer">
							<p><?php echo esc_html( $__( 'Genel Koruma ve İletişim Bildirimi özellikleri tamamen ücretsizdir. Ekstra Koruma şu anda ücretsiz olarak sunulmaktadır.', 'General Protection and Communication Reporting features are completely free. Extra Protection is currently offered for free.' ) ); ?></p>
						</div>
					</div>

				</div>
			</div>
		</section>

	</main>

	<?php include get_stylesheet_directory() . '/inc/kalkan-footer.php'; ?>

</div>

<?php include get_stylesheet_directory() . '/inc/kalkan-scripts.php'; ?>
<script>
(function(){
  var form = document.getElementById('kk-subscribe-form');
  if (!form) return;
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    var msg = form.querySelector('.kk-subscribe-msg');
    var email = form.querySelector('[name="kk_email"]').value.trim();
    var consent = form.querySelector('[name="kk_consent"]');
    msg.textContent = '';
    msg.className = 'kk-subscribe-msg';
    if (!consent.checked) {
      msg.textContent = msg.getAttribute('data-consent');
      msg.classList.add('error');
      return;
    }
    var btn = form.querySelector('.kk-subscribe-btn');
    btn.disabled = true;
    var body = new FormData();
    body.append('action', 'kalkan_subscribe');
    body.append('kk_nonce', form.querySelector('[name="kk_nonce"]').value);
    body.append('kk_email', email);
    fetch('<?php echo esc_url( admin_url( "admin-ajax.php" ) ); ?>', {
      method: 'POST', body: body
    }).then(function(r){ return r.json(); }).then(function(data){
      if (data.success) {
        msg.textContent = msg.getAttribute('data-success');
        msg.classList.add('success');
        form.classList.add('submitted');
      } else {
        msg.textContent = (data.data && data.data.message) || msg.getAttribute('data-error');
        msg.classList.add('error');
        btn.disabled = false;
      }
    }).catch(function(){
      msg.textContent = msg.getAttribute('data-error');
      msg.classList.add('error');
      btn.disabled = false;
    });
  });
})();
</script>
<?php wp_footer(); ?>
</body>
</html>
