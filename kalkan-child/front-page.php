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
$app_demo_suffix = 'en' === $lang ? 'en' : 'tr';
$app_screen_base = get_stylesheet_directory_uri() . '/assets/images/app-screens/';
$app_demo_screens = array(
	array( 'slug' => 'home', 'height' => 1565 ),
	array( 'slug' => 'incoming', 'height' => 1561 ),
	array( 'slug' => 'recents', 'height' => 1561 ),
	array( 'slug' => 'premium', 'height' => 1565 ),
	array( 'slug' => 'settings', 'height' => 1565 ),
);
$hero_screen_name    = 'home-' . $app_demo_suffix;
$hero_screen_mobile  = $app_screen_base . $hero_screen_name . '-224.webp';
$hero_screen_desktop = $app_screen_base . $hero_screen_name . '-288.webp';

/* Start the viewport-specific LCP image request before HTML parsing. */
if ( ! headers_sent() ) {
	header(
		'Link: <' . esc_url_raw( $hero_screen_mobile ) . '>; rel=preload; as=image; type=image/webp; media="(max-width: 768px)"; fetchpriority=high',
		false
	);
	header(
		'Link: <' . esc_url_raw( $hero_screen_desktop ) . '>; rel=preload; as=image; type=image/webp; media="(min-width: 769px)"; fetchpriority=high',
		false
	);
}

$brand_icon_url  = get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon-80-optimized.webp';
$brand_icon_path = get_stylesheet_directory() . '/assets/images/KalkanAppIcon-80-optimized.webp';
$brand_icon_src  = $brand_icon_url;

/* Avoid making the tiny, above-the-fold brand mark a separate LCP request. */
if ( is_readable( $brand_icon_path ) ) {
	$brand_icon_src = 'data:image/webp;base64,' . base64_encode( file_get_contents( $brand_icon_path ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preload" as="image" href="<?php echo esc_url( $hero_screen_mobile ); ?>" media="(max-width: 768px)" fetchpriority="high">
<link rel="preload" as="image" href="<?php echo esc_url( $hero_screen_desktop ); ?>" media="(min-width: 769px)" fetchpriority="high">
<?php wp_head(); ?>
<?php echo $_kk_seo_tags(); ?>
<?php $kalkan_ui_css = kalkan_ui_stylesheet_contents(); ?>
<?php if ( '' !== $kalkan_ui_css ) : ?>
<style id="kalkan-ui-critical-css" data-no-optimize="1"><?php echo $kalkan_ui_css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></style>
<?php else : ?>
<link rel="stylesheet" href="<?php echo esc_url( kalkan_ui_stylesheet_url() ); ?>">
<?php endif; ?>
<style data-no-optimize="1">
/* ─── Homepage-specific styles ───────────────────────────────────────────────── */

/* Keep the landing page render-blocking path network-free. The native UI stack
   closely matches Kalkan's typography on Apple and Android devices. */
body,
body * {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif !important;
}

/* Compact vertical rhythm — reduce section padding on homepage */
.kk-main > .kk-section { padding-block: clamp(2.5rem, 6vw, 3.5rem); }
.kk-main > .kk-section .kk-section-header { margin-bottom: 1.5rem; }
.kk-hero {
  position: relative;
  overflow: hidden;
  padding-block: clamp(3rem, 8vw, 5rem) clamp(2rem, 5vw, 3.5rem);
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
.kk-hero .kk-animate {
  opacity: 1;
  transform: none;
  transition: none;
}
.kk-hero__layout { display: grid; gap: 3rem; position: relative; }
.kk-hero__content > * + * { margin-top: 1.2rem; }
.kk-hero__subtitle {
  font-size: clamp(1.05rem, 2.4vw, 1.2rem);
  color: var(--kk-text-muted);
  max-width: 40rem;
  line-height: 1.65;
}
.kk-hero__proof {
  display: flex; flex-wrap: wrap; gap: 0.65rem 1rem;
  margin: 1.25rem 0 0; padding: 0; list-style: none;
  color: var(--kk-text-muted); font-size: 0.9rem;
}
.kk-hero__proof li::before { content: '✓'; color: var(--kk-green); font-weight: 800; margin-right: 0.4rem; }
/* ===== HERO BUTTONS — DESKTOP ===== */
.hero-buttons {
  display: flex; flex-direction: row; flex-wrap: wrap; align-items: center; gap: 10px 16px; margin-top: 32px;
}
.hero-appstore {
  display: inline-flex; align-items: center; justify-content: center; text-decoration: none; flex-shrink: 0;
  width: 166px; height: 52px; overflow: hidden;
}
.hero-appstore img {
  width: 100%; height: auto; display: block;
}
.hero-googleplay {
  display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;
  width: 166px; height: 52px; overflow: hidden;
}
.hero-googleplay img { display: block; width: 100%; height: auto; max-width: none; }
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
.kk-hero__visual { display: flex; flex-direction: column; justify-content: center; align-items: center; }
.kk-platform-note { margin-top: 0.65rem; color: var(--kk-text-muted); font-size: 0.8rem; text-align: center; }
.phone-frame {
  position: relative;
  width: 300px;
  padding: 7px;
  box-sizing: border-box;
  background: linear-gradient(145deg, #777783 0%, #292932 16%, #09090d 52%, #3d3d47 84%, #8a8a94 100%);
  border-radius: 52px;
  border: 1px solid rgba(255, 255, 255, 0.22);
  box-shadow:
    0 0 0 1px rgba(0, 0, 0, 0.8),
    0 32px 90px rgba(0, 0, 0, 0.55),
    0 0 48px rgba(139, 92, 246, 0.16),
    inset 1px 1px 1px rgba(255, 255, 255, 0.28),
    inset -1px -1px 1px rgba(0, 0, 0, 0.72);
  isolation: isolate;
}
.phone-frame::before,
.phone-frame::after {
  content: '';
  position: absolute;
  right: -4px;
  width: 3px;
  border-radius: 0 3px 3px 0;
  background: linear-gradient(180deg, #555560, #17171d 55%, #45454f);
  box-shadow: 1px 0 1px rgba(255,255,255,0.08);
}
.phone-frame::before { top: 22%; height: 12%; }
.phone-frame::after { top: 38%; height: 18%; }
.phone-frame:hover {
  transform: translateY(-3px);
  box-shadow:
    0 0 0 1px rgba(0, 0, 0, 0.8),
    0 38px 100px rgba(0, 0, 0, 0.6),
    0 0 58px rgba(139, 92, 246, 0.22),
    inset 1px 1px 1px rgba(255, 255, 255, 0.28),
    inset -1px -1px 1px rgba(0, 0, 0, 0.72);
}
.phone-screen {
  position: relative;
  width: 100%;
  aspect-ratio: 1206 / 2622;
  overflow: hidden;
  border-radius: 45px;
  background: #000;
  box-shadow: inset 0 0 0 1px rgba(255,255,255,0.08);
}
.phone-screen .kk-phone-shot {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center top;
  display: block;
  opacity: 0;
  animation: kk-phone-screen-cycle 25s infinite both;
  will-change: opacity;
}
.phone-screen picture { display: contents; }
.phone-frame,
.phone-frame:hover {
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}
@media (prefers-reduced-motion: reduce) {
  .phone-frame:hover { transform: none; }
}
.phone-screen picture:nth-child(1) .kk-phone-shot { animation-delay: 0s; }
.phone-screen picture:nth-child(2) .kk-phone-shot { animation-delay: 5s; }
.phone-screen picture:nth-child(3) .kk-phone-shot { animation-delay: 10s; }
.phone-screen picture:nth-child(4) .kk-phone-shot { animation-delay: 15s; }
.phone-screen picture:nth-child(5) .kk-phone-shot { animation-delay: 20s; }
@keyframes kk-phone-screen-cycle {
  0%, 16% { opacity: 1; }
  20%, 100% { opacity: 0; }
}
@media (prefers-reduced-motion: reduce) {
  .phone-screen .kk-phone-shot { animation: none; opacity: 0; }
  .phone-screen picture:first-child .kk-phone-shot { opacity: 1; }
}

.kk-how { background: rgba(19,7,40,0.6); }
.kk-steps { display: grid; gap: 1.5rem; }
.kk-step { padding: clamp(1.25rem, 3vw, 1.5rem); position: relative; }
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
  padding: clamp(1.25rem, 3vw, 1.5rem); position: relative;
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
.kk-guide-card { color: inherit; text-decoration: none; display: block; }
.kk-guide-card:focus-visible { outline: 3px solid var(--kk-orange); outline-offset: 4px; }

.kk-badge-free {
  display: inline-block; margin-top: 0.85rem;
  padding: 0.3rem 0.85rem; border-radius: 999px;
  background: rgba(139,92,246,0.15); border: 1px solid rgba(139,92,246,0.3);
  color: var(--kk-purple-light); font-size: 0.78rem; font-weight: 700;
  letter-spacing: 0.04em;
}

.kk-outcomes { background: rgba(10,3,24,0.72); }
.kk-outcome-grid { display: grid; gap: 1.25rem; }
.kk-outcome-card {
  position: relative; min-height: 30rem; margin: 0; overflow: hidden;
  border: 1px solid var(--kk-border); border-radius: var(--kk-radius);
  background: #120725; isolation: isolate;
}
.kk-outcome-card::after {
  content: ''; position: absolute; inset: 35% 0 0; z-index: 1;
  background: linear-gradient(180deg, transparent 0%, rgba(10,3,24,0.8) 45%, rgba(10,3,24,0.98) 100%);
  pointer-events: none;
}
.kk-outcome-card__image {
  position: absolute; inset: 0; width: 100%; height: 100%;
  object-fit: cover; display: block;
}
.kk-outcome-card__content {
  position: absolute; inset: auto 0 0; z-index: 2;
  padding: clamp(1.35rem, 4vw, 1.8rem);
}
.kk-outcome-card__content h3 { margin-bottom: 0.55rem; font-size: clamp(1.35rem, 3vw, 1.75rem); }
.kk-outcome-card__content p { margin: 0; color: var(--kk-text-muted); line-height: 1.65; }
.kk-outcome-card--updates {
  display: flex; align-items: center; min-height: 22rem;
  background:
    radial-gradient(circle at 72% 20%, rgba(52,211,153,0.2), transparent 35%),
    linear-gradient(145deg, rgba(109,40,217,0.36), rgba(10,3,24,0.95) 68%);
}
.kk-outcome-card--updates::after { display: none; }
.kk-outcome-card--updates .kk-outcome-card__content { position: relative; inset: auto; }
.kk-outcome-card__mark {
  display: inline-flex; align-items: center; justify-content: center;
  width: 4.5rem; height: 4.5rem; margin-bottom: 1.25rem; border-radius: 1.35rem;
  color: var(--kk-green); background: rgba(52,211,153,0.11);
  border: 1px solid rgba(52,211,153,0.28); box-shadow: 0 18px 45px rgba(0,0,0,0.24);
}
.kk-outcome-card__mark svg { width: 2.4rem; height: 2.4rem; }

.kk-trust { background: rgba(26,5,51,0.6); position: relative; overflow: hidden; }
.kk-trust::before {
  content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%);
  width: 600px; height: 1px;
  background: linear-gradient(90deg, transparent, var(--kk-purple), transparent);
}
.kk-trust__layout { display: grid; gap: 1.5rem; }
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
.kk-screens { background: rgba(19,7,40,0.6); }
.kk-screen-grid { display: grid; gap: 1rem; grid-template-columns: repeat(3, minmax(0, 1fr)); }
.kk-screen {
  margin: 0; padding: 0.65rem; border-radius: var(--kk-radius);
  background: rgba(255,255,255,0.035); border: 1px solid var(--kk-border);
}
.kk-screen img { display: block; width: 100%; height: auto; border-radius: calc(var(--kk-radius) - 0.4rem); }
.kk-screen figcaption { padding: 0.75rem 0.25rem 0.15rem; text-align: center; color: var(--kk-text-muted); font-size: 0.88rem; }
.kk-app-demo { display: grid; gap: 2rem; align-items: center; }
.kk-app-demo__visual { display: flex; justify-content: center; }
.phone-frame--showcase { width: min(320px, 80vw); }
.kk-app-demo__list {
  display: grid; gap: 1rem; margin: 0; padding: 0; list-style: none;
}
.kk-app-demo__list li {
  padding: 1rem 1.1rem; border: 1px solid var(--kk-border); border-radius: var(--kk-radius-sm);
  background: rgba(255,255,255,0.04); color: var(--kk-text-muted); line-height: 1.55;
}
.kk-app-demo__list strong { display: block; margin-bottom: 0.25rem; color: var(--kk-text); }

.kk-cta__card {
  padding: clamp(1.75rem, 4vw, 2.5rem); text-align: center;
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
  display: flex; flex-wrap: wrap; align-items: center; justify-content: center; gap: 10px 16px; margin-top: 28px;
}
.cta-appstore img {
  height: 44px; width: auto;
}
.cta-appstore .kk-googleplay-badge { height: 56px; margin-block: -6px; }

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
.kk-subscribe { background: #130728; }
.kk-subscribe-form { margin-top: 1rem; }
.kk-subscribe-row {
  display: flex; gap: 0; border-radius: 12px; overflow: hidden;
  border: 1px solid var(--kk-border);
  background: #24163b;
  transition: border-color 0.2s;
}
.kk-subscribe-row:focus-within { border-color: rgba(139,92,246,0.5); }
.kk-subscribe-input {
  flex: 1; min-width: 0; padding: 0.85rem 1rem;
  background: transparent; border: none; outline: none;
  color: var(--kk-text); font-family: inherit; font-size: 0.95rem;
}
.kk-subscribe-input::placeholder { color: #ffffff; opacity: 1; }
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
  justify-content: center;
  margin-top: 0.75rem; font-size: 0.82rem; color: var(--kk-text-dim);
  cursor: pointer; line-height: 1.45;
}
.kk-subscribe-consent input[type="checkbox"] {
  width: 16px; height: 16px; margin-top: 1px; flex-shrink: 0;
  accent-color: var(--kk-purple);
}
.kk-subscribe-consent a { color: var(--kk-purple-light); text-decoration: underline; }
.kk-subscribe-btn-wrap {
  display: flex; justify-content: center; margin-top: 1rem;
}
.kk-subscribe-msg {
  margin-top: 0.6rem; font-size: 0.88rem; min-height: 1.4em; text-align: center;
}
.kk-subscribe-msg.success { color: var(--kk-green); }
.kk-subscribe-msg.error { color: #f87171; }
.kk-subscribe-form.submitted .kk-subscribe-row,
.kk-subscribe-form.submitted .kk-subscribe-consent,
.kk-subscribe-form.submitted .kk-subscribe-btn-wrap { opacity: 0.5; pointer-events: none; }

/* ===== HERO BUTTONS — MOBILE ===== */
@media (max-width: 768px) {
  .phone-frame {
    width: 240px; margin: 0 auto;
  }
  .kk-app-demo__visual { display: none; }
  .phone-screen { border-radius: 36px; }
  .hero-buttons {
    flex-direction: row; justify-content: center; align-items: center; gap: 8px 12px; margin-top: 20px;
  }
  .hero-appstore, .hero-googleplay { width: 151px; height: 48px; }
  .hero-secondary-btn {
    height: 44px; width: 100%; padding: 0 32px; font-size: 14px;
  }
  .cta-appstore img { height: 44px; }
}

@media (min-width: 40rem) {
  .kk-steps { grid-template-columns: repeat(3, 1fr); }
  .kk-feature-grid { grid-template-columns: repeat(2, 1fr); }
  .kk-outcome-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .kk-outcome-card--updates { grid-column: 1 / -1; }
}
@media (max-width: 39.99rem) {
  .kk-screen-grid { grid-template-columns: 1fr; }
  .kk-screen { max-width: 19rem; margin-inline: auto; }
}
@media (min-width: 769px) {
  .phone-frame { width: 300px; }
}
@media (min-width: 64rem) {
  .kk-hero__layout { grid-template-columns: 1.1fr 0.9fr; align-items: center; gap: 4rem; }
  .kk-feature-grid { grid-template-columns: repeat(2, 1fr); }
  .kk-outcome-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
  .kk-outcome-card--updates { grid-column: auto; min-height: 30rem; }
  .kk-trust__layout { grid-template-columns: 0.3fr 1fr; align-items: center; gap: 4rem; }
  .kk-app-demo { grid-template-columns: 0.85fr 1.15fr; gap: 4rem; }
}

/* Studio: light homepage, existing assets and network-critical image path retained. */
body.kk-home-studio {
  --kk-bg: #f6f8f8;
  --kk-bg-2: #edf3f4;
  --kk-bg-3: #e3edef;
  --kk-bg-card: #ffffff;
  --kk-border: #d4e0e3;
  --kk-border-hover: #158976;
  --kk-purple: #0e796a;
  --kk-purple-light: #0d6e60;
  --kk-purple-dark: #095e53;
  --kk-green: #0e8069;
  --kk-text: #112b3b;
  --kk-text-muted: #4b6170;
  --kk-text-dim: #516778;
  background: #f6f8f8;
  color: var(--kk-text);
  color-scheme: light;
}
.kk-home-studio .kk-page { background: #f6f8f8; }
.kk-home-studio .kk-header,
.kk-home-studio .kk-mobile-nav {
  background: #f8fafa;
  border-color: #d8e3e6;
  backdrop-filter: none;
  -webkit-backdrop-filter: none;
}
.kk-home-studio .kk-brand__name { color: #112b3b; }
.kk-home-studio .kk-brand__icon { box-shadow: 0 2px 8px rgba(16, 42, 57, 0.12); }
.kk-home-studio .kk-nav a { color: #354d5b; }
.kk-home-studio .kk-nav a:hover,
.kk-home-studio .kk-lang a:hover { background: #e8f0f1; color: #112b3b; }
.kk-home-studio .kk-lang span.kk-lang--active { background: #0e796a; color: #fff; }
.kk-home-studio .kk-menu-toggle span { background: #112b3b; }
.kk-home-studio .kk-glass {
  background: #fff;
  border-color: #d4e0e3;
  backdrop-filter: none;
  -webkit-backdrop-filter: none;
  box-shadow: 0 8px 26px rgba(16, 42, 57, 0.045);
}
.kk-home-studio .kk-eyebrow { color: #0e796a; }
.kk-home-studio .kk-hero {
  padding: 0;
  background: #f8fafa;
  border-bottom: 0;
}
.kk-home-studio .kk-hero::before {
  inset: 0 0 auto auto;
  width: 43%; height: calc(100% - 55px);
  background: linear-gradient(135deg, #e3eff0, #d4e6e9);
  clip-path: polygon(11% 0, 100% 0, 100% 100%, 0 100%);
  pointer-events: none;
}
.kk-home-studio .kk-hero__layout { min-height: 610px; gap: 2rem; }
.kk-home-studio .kk-hero__content { position: relative; z-index: 1; padding-block: 3rem; }
.kk-home-studio .kk-hero__content > * + * { margin-top: 1.15rem; }
.kk-home-studio .kk-hero .kk-eyebrow {
  font-size: 0.82rem; letter-spacing: 0.065em; text-transform: none;
}
.kk-home-studio .kk-hero h1 {
  max-width: 13ch;
  font-size: clamp(3rem, 4.7vw, 4.35rem);
  line-height: 1.06; letter-spacing: -0.055em;
  text-wrap: balance;
}
.kk-home-studio .kk-hero h1 span { color: #f27421; margin-inline-start: .12em; white-space: nowrap; }
.kk-home-studio .kk-hero__subtitle {
  max-width: 37rem; color: #4b6170;
  font-size: clamp(1rem, 1.7vw, 1.1rem); line-height: 1.55;
}
.kk-home-studio .hero-buttons { gap: 10px 13px; margin-top: 1.6rem; }
.kk-home-studio .hero-appstore,
.kk-home-studio .hero-googleplay { width: 166px; height: 52px; }
.kk-home-studio .hero-appstore:focus-visible,
.kk-home-studio .hero-googleplay:focus-visible,
.kk-home-studio .cta-appstore a:focus-visible { outline: 3px solid #0e796a; outline-offset: 4px; border-radius: 4px; }
.kk-home-studio .kk-hero__visual { min-height: 610px; overflow: hidden; justify-content: flex-end; }
.kk-home-studio .kk-hero__visual::before {
  content: ''; position: absolute; left: 50%; top: 48%;
  width: 460px; height: 460px; border-radius: 50%;
  transform: translate(-50%, -50%);
  background: rgba(255,255,255,0.22);
  pointer-events: none;
}
.kk-home-studio .kk-hero .phone-frame {
  width: 308px; transform: rotate(-4deg) translateY(58px);
  border-color: #a7b0b2;
  background: linear-gradient(135deg, #849294, #303a40 20%, #0e1115 46%, #6d797b 84%, #aeb7b7);
  box-shadow: 0 3px 0 #17232b, 0 32px 58px rgba(16,42,57,.25);
}
.kk-home-studio .kk-hero .phone-frame:hover { transform: rotate(-4deg) translateY(54px); box-shadow: 0 3px 0 #17232b, 0 36px 65px rgba(16,42,57,.3); }
.kk-home-studio .kk-platform-note { display: none; }
.kk-home-studio .kk-hero__proof-band {
  position: relative; z-index: 2;
  background: #eaf1f2; border-block: 1px solid #d4e0e3;
}
.kk-home-studio .kk-hero__proof {
  display: grid; grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 1rem; align-items: center;
  margin: 0 auto; padding-block: 0.95rem;
  color: #213b49; font-size: 0.86rem; font-weight: 650;
}
.kk-home-studio .kk-hero__proof li { min-width: 0; }
.kk-home-studio .kk-hero__proof li::before { display: none; }
.kk-home-studio .kk-main > .kk-section { padding-block: clamp(3rem, 6vw, 4.6rem); }
.kk-home-studio .kk-main > .kk-hero { padding-block: 0; }
.kk-home-studio .kk-section-header { max-width: 52rem; }
.kk-home-studio .kk-how,
.kk-home-studio .kk-screens,
.kk-home-studio .kk-guides,
.kk-home-studio .kk-faq { background: #f8fafa; }
.kk-home-studio .kk-features,
.kk-home-studio .kk-outcomes,
.kk-home-studio .kk-trust,
.kk-home-studio .kk-subscribe { background: #edf3f4; }
.kk-home-studio .kk-step__num {
  background: #e4f0ed; color: #0e796a;
  box-shadow: none; border: 1px solid #c6ded8;
}
.kk-home-studio .kk-step p,
.kk-home-studio .kk-feature-card p { color: #516778; }
.kk-home-studio .kk-feature-card:hover { border-color: #82b6ac; box-shadow: 0 10px 30px rgba(16,42,57,.08); }
.kk-home-studio .kk-feature-card__icon {
  background: #edf6f3; border-color: #cee4dc;
}
.kk-home-studio .kk-feature-card__icon stop:first-child { stop-color: #0e796a !important; }
.kk-home-studio .kk-feature-card__icon stop:last-child { stop-color: #f27421 !important; }
.kk-home-studio .kk-badge-free {
  background: #e9f3ef; color: #0d6e60; border-color: #c5ded6;
}
.kk-home-studio .kk-outcome-card:not(.kk-outcome-card--updates) h3 { color: #fff; }
.kk-home-studio .kk-outcome-card:not(.kk-outcome-card--updates) p { color: #e5edf0; }
.kk-home-studio .kk-outcome-card--updates {
  background: #102b3a;
  border-color: #d4e0e3;
}
.kk-home-studio .kk-outcome-card--updates::after { display: block; }
.kk-home-studio .kk-outcome-card--updates .kk-outcome-card__content { position: absolute; inset: auto 0 0; }
.kk-home-studio .kk-outcome-card--updates h3 { color: #fff; }
.kk-home-studio .kk-outcome-card--updates p { color: #e5edf0; }
.kk-home-studio .kk-trust::before { background: linear-gradient(90deg, transparent, #a2cbc1, transparent); }
.kk-home-studio .kk-shield-icon {
  background: #e0f0eb; border-color: #c2ded6;
  box-shadow: 0 15px 35px rgba(16,42,57,.07);
}
.kk-home-studio .kk-trust__list li,
.kk-home-studio .kk-app-demo__list li { color: #4b6170; }
.kk-home-studio .kk-trust__links a { background: #fff; color: #284352; }
.kk-home-studio .kk-trust__links a:hover { background: #e5f1ed; }
.kk-home-studio .kk-app-demo__list li,
.kk-home-studio .kk-screen,
.kk-home-studio .kk-faq-item { background: #fff; border-color: #d4e0e3; }
.kk-home-studio .kk-app-demo__list strong { color: #112b3b; }
.kk-home-studio .kk-screen figcaption { color: #4b6170; }
.kk-home-studio .kk-cta { background: #f8fafa; }
.kk-home-studio .kk-cta__card {
  background: linear-gradient(120deg, #e7f3f0, #f7fbfa);
  border-color: #c8dfd9;
}
.kk-home-studio .kk-cta__card::before { display: none; }
.kk-home-studio .kk-faq-item.active { border-color: #83bcb0; }
.kk-home-studio .kk-faq-toggle { color: #0e796a; }
.kk-home-studio .kk-faq-answer p { color: #516778; }
.kk-home-studio .kk-subscribe-row { background: #fff; border-color: #bbcfd3; }
.kk-home-studio .kk-subscribe-row:focus-within { border-color: #0e796a; box-shadow: 0 0 0 2px rgba(14,121,106,.12); }
.kk-home-studio .kk-subscribe-input { color: #112b3b; }
.kk-home-studio .kk-subscribe-input::placeholder { color: #526778; }
.kk-home-studio .kk-subscribe-btn { background: #0e796a; color: #fff; }
.kk-home-studio .kk-subscribe-consent a { color: #0b6b5d; }
.kk-home-studio .kk-footer { background: #102b3a; border-top-color: #102b3a; }
.kk-home-studio .kk-footer .kk-brand__name,
.kk-home-studio .kk-footer h2,
.kk-home-studio .kk-footer h3 { color: #f6f9fa; }
.kk-home-studio .kk-footer__tagline,
.kk-home-studio .kk-footer__nav a,
.kk-home-studio .kk-footer__copy { color: #c6d4d9; }
.kk-home-studio .kk-footer__nav a:hover { color: #fff; }
.kk-home-studio .kk-footer .kk-lang a,
.kk-home-studio .kk-footer .kk-lang span { color: #e6eef0; }
.kk-home-studio .kk-footer .kk-lang a:hover { color: #fff; background: #284653; }
.kk-home-studio .kk-footer .kk-social-link { color: #f6f9fa; border-color: #637b84; }
.kk-home-studio :is(a,button,input):focus-visible { outline: 3px solid #0e796a; outline-offset: 3px; }
@media (max-width: 1023px) {
  .kk-home-studio .kk-hero::before { width: 48%; }
  .kk-home-studio .kk-hero__layout { min-height: 560px; }
  .kk-home-studio .kk-hero__visual { min-height: 560px; }
  .kk-home-studio .kk-hero .phone-frame { width: 265px; }
}
@media (max-width: 767px) {
  .kk-home-studio .kk-hero::before {
    top: auto; bottom: 0; width: 100%; height: 43%;
    clip-path: polygon(0 9%, 100% 0, 100% 100%, 0 100%);
  }
  .kk-home-studio .kk-hero__layout { min-height: 0; gap: 0; }
  .kk-home-studio .kk-hero__content { padding-block: 3rem 1.5rem; }
  .kk-home-studio .kk-hero h1 { max-width: none; font-size: clamp(2.2rem, 9.2vw, 2.7rem); }
  .kk-home-studio .kk-hero__subtitle { font-size: 1rem; }
  .kk-home-studio .hero-buttons { justify-content: flex-start; gap: 8px; }
  .kk-home-studio .hero-appstore,
  .kk-home-studio .hero-googleplay { width: min(151px, 43vw); height: 48px; }
  .kk-home-studio .kk-hero__visual { min-height: 360px; justify-content: flex-end; }
  .kk-home-studio .kk-hero__visual::before { width: 320px; height: 320px; }
  .kk-home-studio .kk-hero .phone-frame { width: 240px; transform: rotate(-4deg) translateY(100px); }
  .kk-home-studio .kk-hero .phone-frame:hover { transform: rotate(-4deg) translateY(100px); }
  .kk-home-studio .kk-hero__proof { grid-template-columns: 1fr; gap: .45rem; font-size: .82rem; }
  .kk-home-studio .kk-outcome-grid { grid-template-columns: 1fr; }
}
@media (prefers-reduced-motion: reduce) {
  .kk-home-studio .kk-hero .phone-frame,
  .kk-home-studio .kk-hero .phone-frame:hover { transition: none; }
}
</style>
</head>
<body <?php body_class( 'kk-home-studio' ); ?>>

<div class="kk-page">

	<?php include get_stylesheet_directory() . '/inc/kalkan-header.php'; ?>

	<main class="kk-main" id="kk-main">

		<!-- ── HERO ─────────────────────────────────────────────────────────── -->
		<section class="kk-hero kk-section" aria-labelledby="kk-hero-title">
			<?php
			$app_demo_label = $__(
				'Kalkan uygulamasında aktif koruma, gelen arayan kimliği, son aramalar, Premium ve ayarlar ekranları',
				'Kalkan active protection, incoming caller ID, recent calls, Premium, and settings screens'
			);
			?>
			<div class="kk-shell kk-hero__layout">

				<div class="kk-hero__content">
					<span class="kk-eyebrow kk-animate"><?php echo esc_html( $__( 'iPhone ve Android Arama Koruması', 'Call Protection for iPhone and Android' ) ); ?></span>
					<h1 id="kk-hero-title" class="kk-animate kk-animate-delay-1">
						<?php if ( 'en' === $lang ) : ?>Your Shield Against <span>Spam Calls</span><?php else : ?>Spam Aramalara Karşı <span>Kalkanınız.</span><?php endif; ?>
					</h1>
					<p class="kk-hero__subtitle kk-animate kk-animate-delay-2">
						<?php echo esc_html( $__( 'Kalkan, iPhone ve Android’de bilinen spam ve şüpheli aramaları engellemeye, bilinmeyen numaraları tanımaya yardımcı olur.', 'Kalkan helps block known spam and suspicious calls and identify unknown numbers on iPhone and Android.' ) ); ?>
					</p>
					<div class="hero-buttons kk-animate kk-animate-delay-3">
						<a href="<?php echo esc_url( $appstore_link ); ?>" class="hero-appstore">
							<img src="<?php echo esc_url( $badge_url ); ?>" alt="<?php echo esc_attr( $__( 'App Store\'dan İndir', 'Download on the App Store' ) ); ?>" loading="eager" decoding="async" width="151" height="40">
						</a>
						<a href="<?php echo esc_url( $playstore_link ); ?>" class="hero-googleplay" aria-label="<?php echo esc_attr( $__( 'Google Play\'den İndir', 'Get it on Google Play' ) ); ?>">
							<img src="<?php echo esc_url( $play_badge_url ); ?>" alt="" loading="eager" decoding="async" width="646" height="250">
						</a>
					</div>
				</div>

				<div class="kk-hero__visual kk-animate kk-animate-delay-2">
					<div class="phone-frame">
						<div class="phone-screen" role="img" aria-label="<?php echo esc_attr( $app_demo_label ); ?>">
							<?php foreach ( $app_demo_screens as $screen_index => $screen ) : ?>
								<?php
								$screen_name   = $screen['slug'] . '-' . $app_demo_suffix;
								$screen_mobile  = $app_screen_base . $screen_name . '-224.webp';
								$screen_desktop = $app_screen_base . $screen_name . '-288.webp';
								?>
								<picture>
									<source media="(max-width: 768px)" srcset="<?php echo esc_url( $screen_mobile ); ?>">
									<source media="(min-width: 769px)" srcset="<?php echo esc_url( $screen_desktop ); ?>">
									<img class="kk-phone-shot" src="<?php echo esc_url( $screen_desktop ); ?>" alt="" width="288" height="<?php echo esc_attr( (string) round( $screen['height'] * 0.4 ) ); ?>" loading="<?php echo 0 === $screen_index ? 'eager' : 'lazy'; ?>" decoding="async"<?php echo 0 === $screen_index ? ' fetchpriority="high"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput ?> aria-hidden="true">
								</picture>
							<?php endforeach; ?>
						</div>
					</div>
					<p class="kk-platform-note"><?php echo esc_html( $__( 'Gösterilen uygulama ekranları iPhone sürümündendir.', 'App screens shown are from the iPhone version.' ) ); ?></p>
				</div>

			</div>
			<div class="kk-hero__proof-band">
				<ul class="kk-shell kk-hero__proof">
					<li><?php echo esc_html( $__( 'Genel Koruma ücretsiz', 'General Protection is free' ) ); ?></li>
					<li><?php echo esc_html( $__( 'Rehber ve arama geçmişi yüklenmez', 'No contacts or call history uploaded' ) ); ?></li>
					<li><?php echo esc_html( $__( 'Koruma cihazınızda çalışır', 'Protection works on-device' ) ); ?></li>
				</ul>
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
						<p><?php echo esc_html( $__( 'Kalkan\'ı App Store veya Google Play\'den indirin ve arama korumayı etkinleştirin.', 'Download Kalkan from the App Store or Google Play and enable call protection.' ) ); ?></p>
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
						<p><?php echo esc_html( $__( 'Kimin aradığını bilin. Yanıtlamadan önce arayanın kimliğini görün.', 'Know who is calling. See the caller\'s identity before you answer.' ) ); ?></p>
					</div>
					<div class="kk-feature-card kk-glass kk-animate kk-animate-delay-3">
						<div class="kk-feature-card__icon" aria-hidden="true"><?php echo $icon( 'lock' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
						<h3><?php echo esc_html( $__( 'Ekstra Koruma', 'Extra Protection' ) ); ?></h3>
						<p><?php echo esc_html( $__( 'Genişletilmiş koruma daha fazla bilinen spam numarayı kapsar. Sürekli güncellenen koruma verileri, kötü niyetli numaralara karşı korunmanıza yardımcı olur.', 'Extended protection covers more known spam numbers. Continuously updated protection data helps protect you against malicious numbers.' ) ); ?></p>
						<span class="kk-badge-free"><?php echo esc_html( $__( 'iPhone: Kalkan Premium · Android: ücretsiz', 'iPhone: Kalkan Premium · Android: free' ) ); ?></span>
					</div>
					<div class="kk-feature-card kk-glass kk-animate kk-animate-delay-4">
						<div class="kk-feature-card__icon" aria-hidden="true"><?php echo $icon( 'flag' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
						<h3><?php echo esc_html( $__( 'İletişim Bildirimi', 'Communication Reporting' ) ); ?></h3>
						<p><?php echo esc_html( $__( 'Şüpheli numaraları doğrudan Telefon uygulamasından veya Kalkan içinden kolayca bildirin.', 'Easily report suspicious numbers directly from the Phone app or from within Kalkan.' ) ); ?></p>
					</div>
				</div>
			</div>
		</section>

		<!-- ── EVERYDAY BENEFITS ─────────────────────────────────────────────── -->
		<section class="kk-outcomes kk-section" aria-labelledby="kk-outcomes-title">
			<div class="kk-shell">
				<div class="kk-section-header kk-animate">
					<span class="kk-eyebrow"><?php echo esc_html( $__( 'Günlük Yaşam', 'Everyday Life' ) ); ?></span>
					<h2 id="kk-outcomes-title"><?php echo esc_html( $__( 'Kalkan Size Ne Kazandırır?', 'What Does Kalkan Give You?' ) ); ?></h2>
					<p class="kk-lead"><?php echo esc_html( $__( 'Daha sakin, daha anlaşılır ve daha az bölünen bir telefon deneyimi.', 'A calmer, clearer phone experience with fewer interruptions.' ) ); ?></p>
				</div>

				<div class="kk-outcome-grid">
					<article class="kk-outcome-card kk-animate kk-animate-delay-1">
						<img class="kk-outcome-card__image" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/marketing/focus-protection-384.webp' ); ?>" alt="<?php echo esc_attr( $__( 'Çalışma masasında dikkatini işine veren bir Kalkan kullanıcısı', 'A Kalkan user focused at a work desk' ) ); ?>" width="384" height="480" loading="lazy" decoding="async">
						<div class="kk-outcome-card__content">
							<h3><?php echo esc_html( $__( 'Arama Engellenir. Odağınız Dağılmaz.', 'The Call Is Blocked. Your Focus Stays.' ) ); ?></h3>
							<p><?php echo esc_html( $__( 'Çalışırken, üretirken veya öğrenirken gereksiz aramalarla bölünmeyin.', 'Avoid unnecessary interruptions while you work, create, or learn.' ) ); ?></p>
						</div>
					</article>

					<article class="kk-outcome-card kk-animate kk-animate-delay-2">
						<img class="kk-outcome-card__image" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/marketing/family-protection-384.webp' ); ?>" alt="<?php echo esc_attr( $__( 'Telefonunu rahatça kullanan bir aile büyüğü', 'An older family member using a phone comfortably' ) ); ?>" width="384" height="480" loading="lazy" decoding="async">
						<div class="kk-outcome-card__content">
							<h3><?php echo esc_html( $__( 'Yakınlarınızı İstenmeyen Aramalara Karşı Koruyun.', 'Help Protect Your Loved Ones From Unwanted Calls.' ) ); ?></h3>
							<p><?php echo esc_html( $__( 'Huzur bozacak senaryolara karşı önleminiz olsun.', 'Be prepared for calls that could disturb your peace.' ) ); ?></p>
						</div>
					</article>

					<article class="kk-outcome-card kk-outcome-card--updates kk-animate kk-animate-delay-3">
						<img class="kk-outcome-card__image" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/marketing/update-protection-384.webp' ); ?>" alt="<?php echo esc_attr( $__( 'Evinde telefonundaki koruma durumunu kontrol eden kişi', 'A person checking phone protection status at home' ) ); ?>" width="384" height="480" loading="lazy" decoding="async">
						<div class="kk-outcome-card__content">
							<h3><?php echo esc_html( $__( 'Korumanız Her Zaman Güncel Kalsın.', 'Keep Your Protection Up to Date.' ) ); ?></h3>
							<p><?php echo esc_html( $__( 'Sürekli güncellenen koruma verileri, bilinen kötü niyetli telefon numaralarına karşı korunmanıza yardımcı olur.', 'Continuously updated protection data helps protect you against known malicious phone numbers.' ) ); ?></p>
						</div>
					</article>
				</div>
			</div>
		</section>

		<!-- ── APP SCREENS ─────────────────────────────────────────────────── -->
		<section class="kk-screens kk-section" aria-labelledby="kk-screens-title">
			<div class="kk-shell">
				<div class="kk-section-header kk-animate">
					<span class="kk-eyebrow"><?php echo esc_html( $__( 'Uygulama', 'The App' ) ); ?></span>
					<h2 id="kk-screens-title"><?php echo esc_html( $__( 'Korumanızı Kolayca Yönetin', 'Manage Your Protection Easily' ) ); ?></h2>
					<p class="kk-lead"><?php echo esc_html( $__( 'Koruma durumunu görün, iPhone ayarlarını tamamlayın ve şüpheli aramalar hakkında bilgi alın.', 'Check protection status, complete iPhone setup, and learn about suspicious calls.' ) ); ?></p>
				</div>
				<div class="kk-app-demo">
					<div class="kk-app-demo__visual kk-animate kk-animate-delay-1">
						<div class="phone-frame phone-frame--showcase">
							<div class="phone-screen" role="img" aria-label="<?php echo esc_attr( $app_demo_label ); ?>">
								<?php foreach ( $app_demo_screens as $screen ) : ?>
									<?php
									$screen_name   = $screen['slug'] . '-' . $app_demo_suffix;
									$screen_mobile  = $app_screen_base . $screen_name . '-224.webp';
									$screen_desktop = $app_screen_base . $screen_name . '-288.webp';
									?>
									<picture>
										<source media="(max-width: 768px)" srcset="<?php echo esc_url( $screen_mobile ); ?>">
										<source media="(min-width: 769px)" srcset="<?php echo esc_url( $screen_desktop ); ?>">
										<img class="kk-phone-shot" src="<?php echo esc_url( $screen_desktop ); ?>" alt="" width="288" height="<?php echo esc_attr( (string) round( $screen['height'] * 0.4 ) ); ?>" loading="lazy" decoding="async" aria-hidden="true">
									</picture>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<ul class="kk-app-demo__list kk-animate kk-animate-delay-2">
						<li><strong><?php echo esc_html( $__( 'Koruma durumunu görün', 'See your protection status' ) ); ?></strong><?php echo esc_html( $__( 'Kalkan aktif olduğunda telefonunuzun korunma durumunu tek bakışta kontrol edin.', 'Check your phone’s protection status at a glance when Kalkan is active.' ) ); ?></li>
						<li><strong><?php echo esc_html( $__( 'Koruma verilerini güncelleyin', 'Update protection data' ) ); ?></strong><?php echo esc_html( $__( 'Bilinen istenmeyen numaralara karşı güncel koruma verilerini kolayca alın.', 'Easily receive current protection data against known unwanted numbers.' ) ); ?></li>
						<li><strong><?php echo esc_html( $__( 'Duyuruları ve yenilikleri takip edin', 'Follow announcements and updates' ) ); ?></strong><?php echo esc_html( $__( 'Yeni özellikleri, sürüm notlarını ve Kalkan içeriğini uygulama içinde görün.', 'See new features, release notes, and Kalkan content inside the app.' ) ); ?></li>
					</ul>
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

		<?php if ( 'tr' === $lang ) : ?>
		<!-- ── SEARCH GUIDES ───────────────────────────────────────────────── -->
		<section class="kk-guides kk-section" aria-labelledby="kk-guides-title">
			<div class="kk-shell">
				<div class="kk-section-header kk-animate">
					<span class="kk-eyebrow">Arama Güvenliği</span>
					<h2 id="kk-guides-title">Numara Sorgulama ve Şüpheli Arama Rehberleri</h2>
					<p class="kk-lead">Bilinmeyen bir aramayı güvenli biçimde değerlendirin, spam çağrıları azaltın ve dolandırıcılık işaretlerini tanıyın.</p>
				</div>
				<div class="kk-feature-grid">
					<a class="kk-feature-card kk-guide-card kk-glass kk-animate kk-animate-delay-1" href="<?php echo esc_url( home_url( '/numara-sorgulama-ucretsiz/' ) ); ?>">
						<h3>Ücretsiz Numara Sorgulama</h3>
						<p>Telefon numarasını açık kaynaklarda araştırın ve kurumsal eşleşmeyi resmî kanaldan doğrulayın.</p>
					</a>
					<a class="kk-feature-card kk-guide-card kk-glass kk-animate kk-animate-delay-2" href="<?php echo esc_url( home_url( '/bilinmeyen-numara-kimin/' ) ); ?>">
						<h3>Bu Numara Kime Ait?</h3>
						<p>Bilinmeyen numara sorgulama sonuçlarını, yorumları ve arayan kimliği etiketlerini doğru yorumlayın.</p>
					</a>
					<a class="kk-feature-card kk-guide-card kk-glass kk-animate kk-animate-delay-3" href="<?php echo esc_url( home_url( '/spam-arama-engelleme/' ) ); ?>">
						<h3>Spam Arama Engelleme</h3>
						<p>Spam aramanın ne olduğunu ve iPhone’da bilinen istenmeyen numaraları nasıl engelleyebileceğinizi öğrenin.</p>
					</a>
					<a class="kk-feature-card kk-guide-card kk-glass kk-animate kk-animate-delay-4" href="<?php echo esc_url( home_url( '/dolandirici-numara-tanima/' ) ); ?>">
						<h3>Telefon Dolandırıcılığı</h3>
						<p>Şüpheli aramadaki baskı, kod, para transferi ve sahte kurum iddialarını tanıyın.</p>
					</a>
				</div>
			</div>
		</section>
		<?php endif; ?>

		<!-- ── CTA ───────────────────────────────────────────────────────────── -->
		<section class="kk-cta kk-section" aria-labelledby="kk-cta-title">
			<div class="kk-shell">
				<div class="kk-cta__card kk-animate">
					<h2 id="kk-cta-title"><?php echo esc_html( $__( 'Kalkan ile Huzurlu Arama Deneyimi', 'Peaceful Calling Experience with Kalkan' ) ); ?></h2>
					<p class="kk-lead"><?php echo esc_html( $__( 'Hemen indirin ve istenmeyen aramalara karşı korumayı başlatın.', 'Download now and start protection against unwanted calls.' ) ); ?></p>
					<div class="cta-appstore">
						<a href="<?php echo esc_url( $appstore_link ); ?>">
							<img src="<?php echo esc_url( $badge_url ); ?>" alt="<?php echo esc_attr( $__( 'App Store\'dan İndir', 'Download on the App Store' ) ); ?>" loading="lazy" decoding="async" width="151" height="40">
						</a>
						<a href="<?php echo esc_url( $playstore_link ); ?>" aria-label="<?php echo esc_attr( $__( 'Google Play\'den İndir', 'Get it on Google Play' ) ); ?>">
							<img class="kk-googleplay-badge" src="<?php echo esc_url( $play_badge_url ); ?>" alt="" loading="lazy" decoding="async" width="646" height="250">
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
							<p><?php echo esc_html( $__( 'Ekstra Koruma, standart spam listesinin ötesindeki genişletilmiş numara kalıplarını kapsar. iPhone sürümünde Premium gerektirir; Android sürümünde ücretsizdir.', 'Extra Protection covers extended number patterns beyond the standard spam list. It requires Premium on iPhone and is free on Android.' ) ); ?></p>
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
							<p><?php echo esc_html( $__( 'Android sürümünde Genel ve Ekstra Koruma ücretsizdir; reklam gösterilebilir. iPhone’da Genel Koruma ve İletişim Bildirimi ücretsizdir, Ekstra Koruma ise Premium gerektirir. Uygun yeni iPhone aboneliklerinde üç aylık deneme App Store’da gösterilir.', 'General and Extra Protection are free on Android, where ads may appear. On iPhone, General Protection and Communication Reporting are free, while Extra Protection requires Premium. Eligible new iPhone subscriptions may see a three-month App Store trial.' ) ); ?></p>
						</div>
					</div>

					<div class="kk-faq-item">
						<button class="kk-faq-question" type="button">
							<span><?php echo esc_html( $__( 'Spam arama ne demek?', 'What is a spam call?' ) ); ?></span>
							<span class="kk-faq-toggle">+</span>
						</button>
						<div class="kk-faq-answer">
							<p><?php echo esc_html( $__( 'Spam arama; istemediğiniz, tekrarlanan veya çok sayıda kişiye otomatik biçimde yapılan telefon aramasıdır. Satış, anket, robot arama ve dolandırıcılık girişimleri bu gruba girebilir.', 'A spam call is an unwanted, repeated, or automated phone call. Sales, surveys, robocalls, and scam attempts may fall into this group.' ) ); ?></p>
						</div>
					</div>

					<div class="kk-faq-item">
						<button class="kk-faq-question" type="button">
							<span><?php echo esc_html( $__( 'Bilinmeyen numara sorgulama nasıl yapılır?', 'How do I check an unknown number?' ) ); ?></span>
							<span class="kk-faq-toggle">+</span>
						</button>
						<div class="kk-faq-answer">
							<p><?php echo esc_html( $__( 'Numarayı hem yerel hem +90 biçimiyle arayın, kurumsal eşleşmeyi resmî HTTPS sayfasından doğrulayın ve topluluk yorumlarını kesin kanıt değil, araştırma sinyali olarak değerlendirin.', 'Search both local and international formats, verify business matches on an official HTTPS page, and treat community comments as research signals rather than proof.' ) ); ?></p>
						</div>
					</div>

					<div class="kk-faq-item">
						<button class="kk-faq-question" type="button">
							<span><?php echo esc_html( $__( 'Kalkan %100 koruma sağlar mı?', 'Does Kalkan provide 100% protection?' ) ); ?></span>
							<span class="kk-faq-toggle">+</span>
						</button>
						<div class="kk-faq-answer">
							<p><?php echo esc_html( $__( 'Kalkan; spam, robot arama, dolandırıcılık ve izinsiz reklam aramalarını veritabanımız ve topluluk bildirimlerine göre engelleyip tanımlayarak azaltmaya yardımcı olur. Kötüye kullanılan yeni numaralar her zaman ortaya çıkabilir, bu nedenle hiçbir arama engelleme uygulaması %100 koruma garanti edemez. Kalkan bilinen numaraların size ulaşmasını engeller; sizin eylemlerinizi kontrol etmez. Lütfen dikkatli olun ve bilinmeyen arayanları doğrulayın.', 'Kalkan app helps reduce spam, robocalls, scams, and phishing by blocking and identifying numbers based on our database and community reports. New abusive numbers can appear at any time, so no call-blocking app can guarantee 100% protection. Kalkan blocks known numbers from reaching you — it does not control your actions. Please stay cautious and verify unknown callers.' ) ); ?></p>
						</div>
					</div>

					<div class="kk-faq-item">
						<button class="kk-faq-question" type="button">
							<span><?php echo esc_html( $__( 'Neden Ayarlar\'da Arama Engelleme ve Numara Tanıma\'yı etkinleştirmem gerekiyor?', 'Why do I need to enable Call Blocking & Identification in Settings?' ) ); ?></span>
							<span class="kk-faq-toggle">+</span>
						</button>
						<div class="kk-faq-answer">
							<p><?php echo esc_html( $__( 'iOS, Kalkan\'ı Ayarlar > Uygulamalar > Telefon > Arama Engelleme ve Numara Tanıma altında etkinleştirmenizi gerektirir. Etkinleştirmezseniz iOS, Kalkan\'ın aramaları engellemesine veya arayan kimliği etiketlerini göstermesine izin vermez.', 'iOS requires you to enable Kalkan under Settings > Apps > Phone > Call Blocking & Identification. Without enabling it, iOS won\'t let Kalkan block calls or show caller identification labels.' ) ); ?></p>
						</div>
					</div>

					<div class="kk-faq-item">
						<button class="kk-faq-question" type="button">
							<span><?php echo esc_html( $__( 'Veritabanını ne sıklıkla güncellemeliyim?', 'How often should I update the database?' ) ); ?></span>
							<span class="kk-faq-toggle">+</span>
						</button>
						<div class="kk-faq-answer">
							<p><?php echo esc_html( $__( 'En güncel koruma listelerini almak için düzenli olarak güncellemenizi öneririz. Uygulama içinden istediğiniz zaman güncelleyebilirsiniz.', 'We recommend updating regularly to receive the latest protection lists. You can update anytime from the app.' ) ); ?></p>
						</div>
					</div>

					<div class="kk-faq-item">
						<button class="kk-faq-question" type="button">
							<span><?php echo esc_html( $__( 'İade politikası (Apple App Store)', 'Refund policy (Apple App Store)' ) ); ?></span>
							<span class="kk-faq-toggle">+</span>
						</button>
						<div class="kk-faq-answer">
							<p><?php echo esc_html( $__( 'Satın alma ve iadeler Apple tarafından yönetilir. Kalkan uygulaması doğrudan iade yapamaz. İadeye uygun olduğunuzu düşünüyorsanız, App Store işlemleri için Apple\'ın satın alma destek ve iade sürecinden talep oluşturun.', 'Purchases and refunds are handled by Apple. Kalkan cannot issue refunds directly. If you believe you\'re eligible for a refund, request it through Apple\'s purchase support and refund flow for App Store transactions.' ) ); ?></p>
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
    body.append('kk_website_url', form.querySelector('[name="kk_website_url"]') ? form.querySelector('[name="kk_website_url"]').value : '');
    body.append('kk_ts', form.querySelector('[name="kk_ts"]') ? form.querySelector('[name="kk_ts"]').value : '');
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
