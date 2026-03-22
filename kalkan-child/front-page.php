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
	'shield' => '<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2L4 6v6c0 5 3.4 9.5 8 10 4.6-.5 8-5 8-10V6l-8-4z"/></svg>',
	'phone'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.79 19.79 0 012.12 4.18 2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>',
	'lock'   => '<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2l9 4v6c0 5.6-3.8 10.7-9 12-5.2-1.3-9-6.4-9-12V6l9-4z"/><path d="M12 8v4m-2 0h4v3H10v-3z"/></svg>',
	'flag'   => '<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg>',
	'trust'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2l8 3v6c0 5-3.4 9.5-8 11-4.6-1.5-8-6-8-11V5l8-3z"/><path d="M9 12l2 2 4-4"/></svg>',
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
<title><?php echo esc_html( $page_title ); ?></title>
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
.kk-hero__actions { display: flex; flex-wrap: wrap; gap: 0.8rem; }
.kk-hero__visual { display: flex; justify-content: center; align-items: center; }
.kk-mockup-placeholder {
  width: min(18rem, 78vw);
  aspect-ratio: 9/19;
  background: var(--kk-bg-card);
  border: 2px dashed rgba(139,92,246,0.3);
  border-radius: 2.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(139,92,246,0.1);
  color: var(--kk-text-muted);
  font-size: 0.9rem;
  font-weight: 600;
  text-align: center;
  padding: 1.5rem;
  position: relative;
  overflow: hidden;
}
.kk-mockup-placeholder::before {
  content: '';
  position: absolute;
  top: -40%; left: -20%;
  width: 140%; height: 60%;
  background: radial-gradient(ellipse, rgba(139,92,246,0.12) 0%, transparent 70%);
  pointer-events: none;
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
  width: 3rem; height: 3rem; border-radius: 0.75rem;
  background: rgba(139,92,246,0.12); border: 1px solid rgba(139,92,246,0.25);
  display: inline-flex; align-items: center; justify-content: center;
  margin-bottom: 1.25rem;
}
.kk-feature-card__icon svg { width: 24px; height: 24px; }
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
.kk-cta__card h2, .kk-cta__card .kk-lead, .kk-cta__actions { position: relative; }
.kk-cta__card .kk-lead { margin-inline: auto; }
.kk-cta__actions {
  display: flex; flex-wrap: wrap; justify-content: center;
  gap: 0.85rem; margin-top: 2rem;
}

.kk-faq { background: rgba(19,7,40,0.6); }
.kk-accordion {
  display: flex; flex-direction: column; gap: 0.75rem;
  max-width: 48rem; margin: 0 auto;
}
.kk-accordion details {
  border: 1px solid var(--kk-border); border-radius: var(--kk-radius-sm);
  background: rgba(255,255,255,0.04); transition: border-color 0.2s; overflow: hidden;
}
.kk-accordion details[open] { border-color: rgba(139,92,246,0.35); }
.kk-accordion summary {
  display: flex; justify-content: space-between; align-items: center; gap: 1rem;
  padding: 1.15rem 1.35rem; cursor: pointer; list-style: none;
  font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 1rem;
  color: var(--kk-text); user-select: none; min-height: 44px;
}
.kk-accordion summary::-webkit-details-marker { display: none; }
.kk-accordion summary::after {
  content: ''; flex-shrink: 0; width: 1.5rem; height: 1.5rem; border-radius: 50%;
  border: 1px solid var(--kk-border); display: inline-flex;
  align-items: center; justify-content: center;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12' fill='none' stroke='%23c084fc' stroke-width='2'%3E%3Cpath d='M6 2v8M2 6h8'/%3E%3C/svg%3E");
  background-repeat: no-repeat; background-position: center;
  transition: transform 0.3s, background-color 0.2s;
}
.kk-accordion details[open] summary::after {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12' fill='none' stroke='%23c084fc' stroke-width='2'%3E%3Cpath d='M2 6h8'/%3E%3C/svg%3E");
  background-color: rgba(139,92,246,0.15); border-color: rgba(139,92,246,0.35);
  transform: rotate(180deg);
}
.kk-accordion__body {
  padding: 0 1.35rem 1.35rem; color: var(--kk-text-dim);
  line-height: 1.7; font-size: 0.97rem;
}

@media (min-width: 40rem) {
  .kk-steps { grid-template-columns: repeat(3, 1fr); }
  .kk-feature-grid { grid-template-columns: repeat(2, 1fr); }
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

					<div class="kk-hero__actions kk-animate kk-animate-delay-3">
						<a class="kk-btn kk-btn-primary" href="<?php echo esc_url( $appstore_link ); ?>">
							<?php echo esc_html( $__( 'App Store\'dan İndir', 'Download on the App Store' ) ); ?>
						</a>
						<a class="kk-btn kk-btn-ghost" href="#kk-how">
							<?php echo esc_html( $__( 'Nasıl çalışır?', 'How it works?' ) ); ?>
						</a>
					</div>

					<a href="<?php echo esc_url( $appstore_link ); ?>" class="kk-appstore-badge kk-animate kk-animate-delay-4">
						<img src="<?php echo esc_url( $badge_url ); ?>" alt="<?php echo esc_attr( $__( 'App Store\'dan İndir', 'Download on the App Store' ) ); ?>" loading="eager" decoding="async">
					</a>
				</div>

				<div class="kk-hero__visual kk-animate kk-animate-delay-2" aria-hidden="true">
					<div class="kk-mockup-placeholder">
						<span><?php echo esc_html( $__( 'iPhone Mockup — ekran görüntüsü yükleyin', 'iPhone Mockup — upload your screenshot' ) ); ?></span>
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
						<a href="<?php echo $privacy_url; ?>"><?php echo esc_html( $__( 'Gizlilik Politikası', 'Privacy Policy' ) ); ?></a>
						<a href="<?php echo $kvkk_url; ?>"><?php echo esc_html( $__( 'KVKK Aydınlatma', 'KVKK Notice' ) ); ?></a>
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
					<div class="kk-cta__actions">
						<a class="kk-btn kk-btn-primary" href="<?php echo esc_url( $appstore_link ); ?>">
							<?php echo esc_html( $__( 'App Store\'dan İndir', 'Download on the App Store' ) ); ?>
						</a>
					</div>
					<div style="margin-top:1.5rem;">
						<a href="<?php echo esc_url( $appstore_link ); ?>" class="kk-appstore-badge" style="display:inline-block;">
							<img src="<?php echo esc_url( $badge_url ); ?>" alt="<?php echo esc_attr( $__( 'App Store\'dan İndir', 'Download on the App Store' ) ); ?>" loading="lazy" decoding="async">
						</a>
					</div>
				</div>
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
					<details>
						<summary><?php echo esc_html( $__( 'Kalkan nasıl çalışır?', 'How does Kalkan work?' ) ); ?></summary>
						<div class="kk-accordion__body"><?php echo esc_html( $__( 'Kalkan, bilinen spam numaraların veritabanını cihazınıza yükler. iOS\'un arama dizini sistemi ile entegre çalışarak gelen aramaları engeller veya işaretler. İnternet bağlantısı gerektirmez.', 'Kalkan loads a database of known spam numbers to your device. It works with iOS\'s call directory system to block or flag incoming calls. No internet connection required.' ) ); ?></div>
					</details>
					<details>
						<summary><?php echo esc_html( $__( 'Kalkan gerçek zamanlı arama analizi yapıyor mu?', 'Does Kalkan do real-time call analysis?' ) ); ?></summary>
						<div class="kk-accordion__body"><?php echo esc_html( $__( 'Hayır. iOS platformu gerçek zamanlı arama analizine izin vermez. Kalkan, önceden yüklenmiş veritabanı ile çalışır. Bu Apple\'ın güvenlik kısıtlamalarından kaynaklanmaktadır.', 'No. iOS does not allow real-time call analysis. Kalkan works with a preloaded database. This is due to Apple\'s security restrictions.' ) ); ?></div>
					</details>
					<details>
						<summary><?php echo esc_html( $__( 'Ekstra Koruma nedir?', 'What is Extra Protection?' ) ); ?></summary>
						<div class="kk-accordion__body"><?php echo esc_html( $__( 'Ekstra Koruma, standart spam listesinin ötesinde genişletilmiş numara kalıplarını engelleyen gelişmiş bir koruma katmanıdır. Şu anda ücretsizdir.', 'Extra Protection is an advanced layer that blocks extended number patterns beyond the standard spam list. It\'s currently free.' ) ); ?></div>
					</details>
					<details>
						<summary><?php echo esc_html( $__( 'Verilerim güvende mi?', 'Is my data safe?' ) ); ?></summary>
						<div class="kk-accordion__body"><?php echo esc_html( $__( 'Evet. Kalkan rehberinize veya arama geçmişinize erişmez. Tüm arama koruma işlemleri cihazınızda yerel olarak gerçekleşir.', 'Yes. Kalkan doesn\'t access your contacts or call history. All call protection happens locally on your device.' ) ); ?></div>
					</details>
					<details>
						<summary><?php echo esc_html( $__( 'Kalkan ücretsiz mi?', 'Is Kalkan free?' ) ); ?></summary>
						<div class="kk-accordion__body"><?php echo esc_html( $__( 'Genel Koruma ve İletişim Bildirimi özellikleri tamamen ücretsizdir. Ekstra Koruma şu anda ücretsiz olarak sunulmaktadır.', 'General Protection and Communication Reporting features are completely free. Extra Protection is currently offered for free.' ) ); ?></div>
					</details>
				</div>
			</div>
		</section>

	</main>

	<?php include get_stylesheet_directory() . '/inc/kalkan-footer.php'; ?>

</div>

<?php include get_stylesheet_directory() . '/inc/kalkan-scripts.php'; ?>
<?php wp_footer(); ?>
</body>
</html>
