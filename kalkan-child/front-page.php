<?php
/**
 * Front page template — Kalkan child theme.
 * Fully self-contained: no get_header()/get_footer() to avoid Blocksy conflicts.
 * Bilingual (TR default / EN via ?lang=en).
 *
 * @package kalkan-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ── Language detection ─────────────────────────────────────────────────────── */
$lang = ( isset( $_GET['lang'] ) && 'en' === sanitize_key( $_GET['lang'] ) ) ? 'en' : 'tr'; // phpcs:ignore WordPress.Security.NonceVerification

/**
 * Translation helper.
 */
$__ = static function ( string $tr, string $en ) use ( $lang ) : string {
	return 'en' === $lang ? $en : $tr;
};

/* ── URL helpers ────────────────────────────────────────────────────────────── */
$lang_tr_url = esc_url( remove_query_arg( 'lang' ) );
$lang_en_url = esc_url( add_query_arg( 'lang', 'en' ) );

$app_store_url = esc_url( apply_filters( 'kalkan_app_store_url', '#' ) );

$asset_base    = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/';
$badge_url     = esc_url( apply_filters( 'kalkan_app_store_badge_url', $asset_base . 'badges/app-store-badge.svg' ) );

$home_url      = esc_url( home_url( '/' ) );

$blog_page_id  = (int) get_option( 'page_for_posts' );
$blog_url      = esc_url( $blog_page_id > 0 ? get_permalink( $blog_page_id ) : home_url( '/blog/' ) );

$privacy_url   = esc_url( get_privacy_policy_url() ?: home_url( '/privacy-policy/' ) );

$kvkk_page     = get_page_by_path( 'kvkk' );
$kvkk_url      = esc_url( $kvkk_page ? get_permalink( $kvkk_page ) : home_url( '/kvkk/' ) );

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

/* Hide Blocksy chrome if it somehow leaks through */
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

.kk-page {
  display: block !important;
}

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
  display: inline-block;
  margin-top: 1rem;
}
.kk-appstore-badge img {
  width: 180px;
  height: auto;
  display: block;
  border-radius: 0.5rem;
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
.kk-brand__mark {
  width: 2.1rem;
  height: 2.1rem;
  border-radius: 0.55rem;
  background: linear-gradient(135deg, var(--kk-purple), var(--kk-purple-dark));
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: var(--kk-white);
  font-weight: 800;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 1.05rem;
  box-shadow: 0 2px 12px rgba(139,92,246,0.45);
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
.kk-header-appstore {
  display: none;
}
.kk-header-appstore img {
  height: 32px;
  width: auto;
  border-radius: 6px;
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
  display: block;
  padding: 0.85rem 0;
  color: var(--kk-text);
  text-decoration: none;
  font-weight: 600;
  font-size: 1rem;
  min-height: 44px;
  display: flex;
  align-items: center;
}
.kk-mobile-nav .kk-lang { margin-top: 1rem; }

/* Content push-down */
.kk-main { padding-top: var(--kk-header-h); }

/* ─── Hero ───────────────────────────────────────────────────────────────────── */
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
.kk-hero__layout {
  display: grid;
  gap: 3rem;
  position: relative;
}
.kk-hero__content > * + * { margin-top: 1.2rem; }
.kk-hero__subtitle {
  font-size: clamp(1.05rem, 2.4vw, 1.2rem);
  color: var(--kk-text-muted);
  max-width: 40rem;
  line-height: 1.65;
}
.kk-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: 0.8rem;
}
.kk-hero__visual {
  display: flex;
  justify-content: center;
  align-items: center;
}
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
  top: -40%;
  left: -20%;
  width: 140%;
  height: 60%;
  background: radial-gradient(ellipse, rgba(139,92,246,0.12) 0%, transparent 70%);
  pointer-events: none;
}

/* ─── How It Works ───────────────────────────────────────────────────────────── */
.kk-how { background: rgba(19,7,40,0.6); }
.kk-steps {
  display: grid;
  gap: 1.5rem;
}
.kk-step {
  padding: clamp(1.5rem, 4vw, 2rem);
  position: relative;
}
.kk-step__num {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 3.5rem;
  height: 3.5rem;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--kk-purple), var(--kk-purple-dark));
  color: var(--kk-white);
  font-weight: 800;
  font-size: 1.25rem;
  margin-bottom: 1rem;
  box-shadow: 0 4px 20px rgba(139,92,246,0.4);
}
.kk-step h3 { margin-bottom: 0.5rem; }
.kk-step p { color: var(--kk-text-dim); line-height: 1.7; }

/* ─── Features ───────────────────────────────────────────────────────────────── */
.kk-features { background: transparent; }
.kk-feature-grid {
  display: grid;
  gap: 1.5rem;
}
.kk-feature-card {
  padding: clamp(1.5rem, 4vw, 2rem);
  position: relative;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.kk-feature-card:hover {
  border-color: var(--kk-border-hover);
  box-shadow: 0 8px 32px rgba(139,92,246,0.2);
}
.kk-feature-card__icon {
  width: 3rem;
  height: 3rem;
  border-radius: 0.75rem;
  background: rgba(139,92,246,0.12);
  border: 1px solid rgba(139,92,246,0.25);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1.25rem;
}
.kk-feature-card__icon svg {
  width: 24px;
  height: 24px;
}
.kk-feature-card h3 { margin-bottom: 0.5rem; }
.kk-feature-card p { color: var(--kk-text-dim); line-height: 1.7; }

.kk-badge-free {
  display: inline-block;
  margin-top: 0.85rem;
  padding: 0.3rem 0.85rem;
  border-radius: 999px;
  background: rgba(139,92,246,0.15);
  border: 1px solid rgba(139,92,246,0.3);
  color: var(--kk-purple-light);
  font-size: 0.78rem;
  font-weight: 700;
  letter-spacing: 0.04em;
}

/* ─── Trust ──────────────────────────────────────────────────────────────────── */
.kk-trust {
  background: rgba(26,5,51,0.6);
  position: relative;
  overflow: hidden;
}
.kk-trust::before {
  content: '';
  position: absolute;
  top: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 600px;
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--kk-purple), transparent);
}
.kk-trust__layout { display: grid; gap: 2.5rem; }
.kk-trust__shield {
  display: flex;
  justify-content: center;
  align-items: center;
}
.kk-shield-icon {
  width: min(9rem, 44vw);
  aspect-ratio: 1;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: radial-gradient(circle at 35% 35%, rgba(139,92,246,0.3) 0%, rgba(52,211,153,0.1) 100%);
  border: 1.5px solid rgba(52,211,153,0.25);
  box-shadow: 0 0 40px rgba(52,211,153,0.15), 0 12px 40px rgba(0,0,0,0.3);
}
.kk-shield-icon svg {
  width: 48px;
  height: 48px;
}
.kk-trust__content .kk-eyebrow { margin-bottom: 0.5rem; }

.kk-trust__list {
  list-style: none;
  margin: 1.5rem 0 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 0.85rem;
}
.kk-trust__list li {
  display: flex;
  gap: 0.75rem;
  align-items: flex-start;
  color: var(--kk-text-muted);
  font-size: 1rem;
  line-height: 1.5;
}
.kk-trust__list li::before {
  content: '';
  display: inline-flex;
  flex-shrink: 0;
  width: 1.25rem;
  height: 1.25rem;
  margin-top: 0.15rem;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%2334d399'%3E%3Cpath d='M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z'/%3E%3C/svg%3E");
  background-size: contain;
  background-repeat: no-repeat;
}
.kk-trust__links {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;
  margin-top: 1.75rem;
}
.kk-trust__links a {
  display: inline-block;
  padding: 0.45rem 1rem;
  border-radius: 999px;
  border: 1px solid var(--kk-border);
  color: var(--kk-text-muted);
  font-weight: 600;
  font-size: 0.88rem;
  text-decoration: none;
  transition: border-color 0.15s, color 0.15s, background 0.15s;
}
.kk-trust__links a:hover {
  border-color: var(--kk-border-hover);
  color: var(--kk-text);
  background: rgba(139,92,246,0.08);
}

/* ─── CTA ────────────────────────────────────────────────────────────────────── */
.kk-cta { background: transparent; }
.kk-cta__card {
  padding: clamp(2.5rem, 6vw, 4rem);
  text-align: center;
  background: linear-gradient(135deg, rgba(109,40,217,0.35) 0%, rgba(139,92,246,0.18) 50%, rgba(15,5,32,0.8) 100%);
  border: 1px solid rgba(139,92,246,0.3);
  border-radius: var(--kk-radius);
  position: relative;
  overflow: hidden;
}
.kk-cta__card::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -20%;
  width: 60%;
  height: 150%;
  background: radial-gradient(ellipse, rgba(139,92,246,0.2) 0%, transparent 60%);
  pointer-events: none;
}
.kk-cta__card h2, .kk-cta__card .kk-lead, .kk-cta__actions { position: relative; }
.kk-cta__card .kk-lead { margin-inline: auto; }
.kk-cta__actions {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 0.85rem;
  margin-top: 2rem;
}

/* ─── FAQ ────────────────────────────────────────────────────────────────────── */
.kk-faq { background: rgba(19,7,40,0.6); }
.kk-accordion {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  max-width: 48rem;
  margin: 0 auto;
}
.kk-accordion details {
  border: 1px solid var(--kk-border);
  border-radius: var(--kk-radius-sm);
  background: rgba(255,255,255,0.04);
  transition: border-color 0.2s;
  overflow: hidden;
}
.kk-accordion details[open] {
  border-color: rgba(139,92,246,0.35);
}
.kk-accordion summary {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  padding: 1.15rem 1.35rem;
  cursor: pointer;
  list-style: none;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-weight: 700;
  font-size: 1rem;
  color: var(--kk-text);
  user-select: none;
  min-height: 44px;
}
.kk-accordion summary::-webkit-details-marker { display: none; }
.kk-accordion summary::after {
  content: '';
  flex-shrink: 0;
  width: 1.5rem;
  height: 1.5rem;
  border-radius: 50%;
  border: 1px solid var(--kk-border);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12' fill='none' stroke='%23c084fc' stroke-width='2'%3E%3Cpath d='M6 2v8M2 6h8'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: center;
  transition: transform 0.3s, background-color 0.2s;
}
.kk-accordion details[open] summary::after {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12' fill='none' stroke='%23c084fc' stroke-width='2'%3E%3Cpath d='M2 6h8'/%3E%3C/svg%3E");
  background-color: rgba(139,92,246,0.15);
  border-color: rgba(139,92,246,0.35);
  transform: rotate(180deg);
}
.kk-accordion__body {
  padding: 0 1.35rem 1.35rem;
  color: var(--kk-text-dim);
  line-height: 1.7;
  font-size: 0.97rem;
}

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

/* ─── Responsive — tablet (≥ 640px) ──────────────────────────────────────────── */
@media (min-width: 40rem) {
  .kk-steps { grid-template-columns: repeat(3, 1fr); }
  .kk-feature-grid { grid-template-columns: repeat(2, 1fr); }
  .kk-footer__layout {
    grid-template-columns: 1fr 1fr;
  }
  .kk-footer__nav { flex-direction: row; flex-wrap: wrap; gap: 1rem; }
}

/* ─── Responsive — desktop (≥ 1024px) ────────────────────────────────────────── */
@media (min-width: 64rem) {
  .kk-shell { padding-inline: 2rem; }

  .kk-nav { display: block; }
  .kk-menu-toggle { display: none; }

  .kk-header-appstore { display: inline-block; }

  .kk-hero__layout {
    grid-template-columns: 1.1fr 0.9fr;
    align-items: center;
    gap: 4rem;
  }

  .kk-feature-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .kk-trust__layout {
    grid-template-columns: 0.3fr 1fr;
    align-items: center;
    gap: 4rem;
  }

  .kk-footer__layout {
    grid-template-columns: 1.2fr 1fr 1fr;
    align-items: start;
  }
}
</style>
</head>
<body <?php body_class(); ?>>

<div class="kk-page">

	<!-- ── HEADER ──────────────────────────────────────────────────────────── -->
	<header class="kk-header" id="kk-header">
		<div class="kk-shell kk-header__inner">

			<a class="kk-brand" href="<?php echo $home_url; ?>" aria-label="Kalkan">
				<span class="kk-brand__mark">K</span>
				<span class="kk-brand__name">Kalkan</span>
			</a>

			<nav class="kk-nav" aria-label="<?php echo esc_attr( $__( 'Ana menü', 'Main menu' ) ); ?>">
				<ul>
					<li><a href="#kk-features"><?php echo esc_html( $__( 'Özellikler', 'Features' ) ); ?></a></li>
					<li><a href="#kk-how"><?php echo esc_html( $__( 'Nasıl Çalışır', 'How It Works' ) ); ?></a></li>
					<li><a href="#kk-faq"><?php echo esc_html( $__( 'SSS', 'FAQ' ) ); ?></a></li>
					<li><a href="<?php echo $blog_url; ?>">Blog</a></li>
				</ul>
			</nav>

			<div class="kk-header__right">
				<div class="kk-lang" aria-label="<?php echo esc_attr( $__( 'Dil seçimi', 'Language switcher' ) ); ?>">
					<?php if ( 'tr' === $lang ) : ?>
						<span class="kk-lang--active">TR</span>
						<a href="<?php echo $lang_en_url; ?>">EN</a>
					<?php else : ?>
						<a href="<?php echo $lang_tr_url; ?>">TR</a>
						<span class="kk-lang--active">EN</span>
					<?php endif; ?>
				</div>

				<a class="kk-header-appstore" href="<?php echo $app_store_url; ?>" aria-label="App Store">
					<img src="<?php echo $badge_url; ?>" alt="App Store" loading="eager">
				</a>

				<button class="kk-menu-toggle" id="kk-menu-toggle" aria-expanded="false" aria-controls="kk-mobile-nav" aria-label="<?php echo esc_attr( $__( 'Menüyü aç', 'Open menu' ) ); ?>">
					<span></span>
					<span></span>
					<span></span>
				</button>
			</div>
		</div>

		<!-- Mobile drawer -->
		<nav class="kk-mobile-nav" id="kk-mobile-nav" aria-label="<?php echo esc_attr( $__( 'Mobil menü', 'Mobile menu' ) ); ?>">
			<ul>
				<li><a href="#kk-features"><?php echo esc_html( $__( 'Özellikler', 'Features' ) ); ?></a></li>
				<li><a href="#kk-how"><?php echo esc_html( $__( 'Nasıl Çalışır', 'How It Works' ) ); ?></a></li>
				<li><a href="#kk-faq"><?php echo esc_html( $__( 'SSS', 'FAQ' ) ); ?></a></li>
				<li><a href="<?php echo $blog_url; ?>">Blog</a></li>
				<li><a href="<?php echo $app_store_url; ?>"><?php echo esc_html( $__( 'App Store\'dan İndir', 'Download on App Store' ) ); ?></a></li>
			</ul>
			<div class="kk-lang" style="margin-top:1rem;">
				<?php if ( 'tr' === $lang ) : ?>
					<span class="kk-lang--active">TR</span>
					<a href="<?php echo $lang_en_url; ?>">EN</a>
				<?php else : ?>
					<a href="<?php echo $lang_tr_url; ?>">TR</a>
					<span class="kk-lang--active">EN</span>
				<?php endif; ?>
			</div>
		</nav>
	</header>

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
						<a class="kk-btn kk-btn-primary" href="<?php echo $app_store_url; ?>">
							<?php echo esc_html( $__( 'App Store\'dan İndir', 'Download on the App Store' ) ); ?>
						</a>
						<a class="kk-btn kk-btn-ghost" href="#kk-how">
							<?php echo esc_html( $__( 'Nasıl çalışır?', 'How it works?' ) ); ?>
						</a>
					</div>

					<a href="<?php echo $app_store_url; ?>" class="kk-appstore-badge kk-animate kk-animate-delay-4">
						<img src="<?php echo $badge_url; ?>" alt="<?php echo esc_attr( $__( 'App Store\'dan İndir', 'Download on the App Store' ) ); ?>" width="180" height="60" loading="eager" decoding="async">
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
					<h2 id="kk-how-title">
						<?php echo esc_html( $__( '3 Adımda Koruma', '3-Step Protection' ) ); ?>
					</h2>
					<p class="kk-lead">
						<?php echo esc_html( $__( 'Kurulumu basit, kullanımı kolay, koruma güçlü.', 'Simple setup, easy to use, powerful protection.' ) ); ?>
					</p>
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
					<h2 id="kk-features-title">
						<?php echo esc_html( $__( 'Temel Özellikler', 'Core Features' ) ); ?>
					</h2>
					<p class="kk-lead">
						<?php echo esc_html( $__( 'Günlük aramaları güvenli hale getiren araçlar.', 'Tools that make your daily calls safer.' ) ); ?>
					</p>
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
					<h2 id="kk-trust-title">
						<?php echo esc_html( $__( 'Gizliliğinize Saygı Duyuyoruz', 'We Respect Your Privacy' ) ); ?>
					</h2>

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
					<h2 id="kk-cta-title">
						<?php echo esc_html( $__( 'Kalkan ile Huzurlu Arama Deneyimi', 'Peaceful Calling Experience with Kalkan' ) ); ?>
					</h2>
					<p class="kk-lead">
						<?php echo esc_html( $__( 'Hemen indirin, spam aramalardan kurtulun.', 'Download now and get rid of spam calls.' ) ); ?>
					</p>
					<div class="kk-cta__actions">
						<a class="kk-btn kk-btn-primary" href="<?php echo $app_store_url; ?>">
							<?php echo esc_html( $__( 'App Store\'dan İndir', 'Download on the App Store' ) ); ?>
						</a>
					</div>
					<div style="margin-top:1.5rem;">
						<a href="<?php echo $app_store_url; ?>" class="kk-appstore-badge" style="display:inline-block;">
							<img src="<?php echo $badge_url; ?>" alt="<?php echo esc_attr( $__( 'App Store\'dan İndir', 'Download on the App Store' ) ); ?>" width="180" height="60" loading="lazy" decoding="async">
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
					<h2 id="kk-faq-title">
						<?php echo esc_html( $__( 'SSS', 'FAQ' ) ); ?>
					</h2>
				</div>

				<div class="kk-accordion kk-animate kk-animate-delay-1">

					<details>
						<summary><?php echo esc_html( $__( 'Kalkan nasıl çalışır?', 'How does Kalkan work?' ) ); ?></summary>
						<div class="kk-accordion__body">
							<?php echo esc_html( $__( 'Kalkan, bilinen spam numaraların veritabanını cihazınıza yükler. iOS\'un arama dizini sistemi ile entegre çalışarak gelen aramaları engeller veya işaretler. İnternet bağlantısı gerektirmez.', 'Kalkan loads a database of known spam numbers to your device. It works with iOS\'s call directory system to block or flag incoming calls. No internet connection required.' ) ); ?>
						</div>
					</details>

					<details>
						<summary><?php echo esc_html( $__( 'Kalkan gerçek zamanlı arama analizi yapıyor mu?', 'Does Kalkan do real-time call analysis?' ) ); ?></summary>
						<div class="kk-accordion__body">
							<?php echo esc_html( $__( 'Hayır. iOS platformu gerçek zamanlı arama analizine izin vermez. Kalkan, önceden yüklenmiş veritabanı ile çalışır. Bu Apple\'ın güvenlik kısıtlamalarından kaynaklanmaktadır.', 'No. iOS does not allow real-time call analysis. Kalkan works with a preloaded database. This is due to Apple\'s security restrictions.' ) ); ?>
						</div>
					</details>

					<details>
						<summary><?php echo esc_html( $__( 'Ekstra Koruma nedir?', 'What is Extra Protection?' ) ); ?></summary>
						<div class="kk-accordion__body">
							<?php echo esc_html( $__( 'Ekstra Koruma, standart spam listesinin ötesinde genişletilmiş numara kalıplarını engelleyen gelişmiş bir koruma katmanıdır. Şu anda ücretsizdir.', 'Extra Protection is an advanced layer that blocks extended number patterns beyond the standard spam list. It\'s currently free.' ) ); ?>
						</div>
					</details>

					<details>
						<summary><?php echo esc_html( $__( 'Verilerim güvende mi?', 'Is my data safe?' ) ); ?></summary>
						<div class="kk-accordion__body">
							<?php echo esc_html( $__( 'Evet. Kalkan rehberinize veya arama geçmişinize erişmez. Tüm arama koruma işlemleri cihazınızda yerel olarak gerçekleşir.', 'Yes. Kalkan doesn\'t access your contacts or call history. All call protection happens locally on your device.' ) ); ?>
						</div>
					</details>

					<details>
						<summary><?php echo esc_html( $__( 'Kalkan ücretsiz mi?', 'Is Kalkan free?' ) ); ?></summary>
						<div class="kk-accordion__body">
							<?php echo esc_html( $__( 'Genel Koruma ve İletişim Bildirimi özellikleri tamamen ücretsizdir. Ekstra Koruma şu anda ücretsiz olarak sunulmaktadır.', 'General Protection and Communication Reporting features are completely free. Extra Protection is currently offered for free.' ) ); ?>
						</div>
					</details>

				</div>
			</div>
		</section>

	</main>

	<!-- ── FOOTER ────────────────────────────────────────────────────────────── -->
	<footer class="kk-footer" aria-label="<?php echo esc_attr( $__( 'Site altı', 'Site footer' ) ); ?>">
		<div class="kk-shell kk-footer__layout">

			<div class="kk-footer__brand">
				<a class="kk-brand" href="<?php echo $home_url; ?>" aria-label="Kalkan">
					<span class="kk-brand__mark">K</span>
					<span class="kk-brand__name">Kalkan</span>
				</a>
				<p class="kk-footer__tagline">
					<?php echo esc_html( $__( 'iOS için spam arama engelleyici ve arayan kimlik uygulaması.', 'Spam call blocker and caller ID app for iOS.' ) ); ?>
				</p>
			</div>

			<nav class="kk-footer__nav" aria-label="<?php echo esc_attr( $__( 'Alt bağlantılar', 'Footer links' ) ); ?>">
				<a href="<?php echo $privacy_url; ?>"><?php echo esc_html( $__( 'Gizlilik Politikası', 'Privacy Policy' ) ); ?></a>
				<a href="<?php echo $kvkk_url; ?>"><?php echo esc_html( $__( 'KVKK Aydınlatma', 'KVKK Notice' ) ); ?></a>
				<a href="<?php echo $blog_url; ?>">Blog</a>
				<a href="mailto:info@kalkan.website">info@kalkan.website</a>
			</nav>

			<div class="kk-footer__meta">
				<div class="kk-lang" aria-label="<?php echo esc_attr( $__( 'Dil seçimi', 'Language switcher' ) ); ?>">
					<?php if ( 'tr' === $lang ) : ?>
						<span class="kk-lang--active">TR</span>
						<a href="<?php echo $lang_en_url; ?>">EN</a>
					<?php else : ?>
						<a href="<?php echo $lang_tr_url; ?>">TR</a>
						<span class="kk-lang--active">EN</span>
					<?php endif; ?>
				</div>
				<p class="kk-footer__copy">
					&copy; <?php echo esc_html( (string) gmdate( 'Y' ) ); ?> Kalkan.
					<?php echo esc_html( $__( 'Tüm hakları saklıdır.', 'All rights reserved.' ) ); ?>
				</p>
			</div>

		</div>
	</footer>

</div>

<script>
(function () {
	'use strict';

	/* ── Mobile menu toggle ── */
	var toggle = document.getElementById('kk-menu-toggle');
	var drawer = document.getElementById('kk-mobile-nav');

	if (toggle && drawer) {
		toggle.addEventListener('click', function () {
			var open = drawer.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});

		drawer.querySelectorAll('a').forEach(function (link) {
			link.addEventListener('click', function () {
				drawer.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
			});
		});
	}

	/* ── Scroll animations ── */
	if ('IntersectionObserver' in window) {
		var animObserver = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('kk-visible');
					animObserver.unobserve(entry.target);
				}
			});
		}, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

		document.querySelectorAll('.kk-animate').forEach(function (el) {
			animObserver.observe(el);
		});
	} else {
		document.querySelectorAll('.kk-animate').forEach(function (el) {
			el.classList.add('kk-visible');
		});
	}

	/* ── Smooth scroll for anchor links ── */
	document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
		anchor.addEventListener('click', function (e) {
			var id = this.getAttribute('href').slice(1);
			var target = document.getElementById(id);
			if (target) {
				e.preventDefault();
				target.scrollIntoView({ behavior: 'smooth', block: 'start' });
			}
		});
	});
}());
</script>

<?php wp_footer(); ?>
</body>
</html>
