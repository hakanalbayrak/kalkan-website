<?php
/**
 * Front page template — Kalkan child theme.
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
 *
 * @param string $tr Turkish string.
 * @param string $en English string.
 * @return string
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

/* Dynamic page URLs */
$blog_page_id  = (int) get_option( 'page_for_posts' );
$blog_url      = esc_url( $blog_page_id > 0 ? get_permalink( $blog_page_id ) : home_url( '/blog/' ) );

$privacy_url   = esc_url( get_privacy_policy_url() ?: home_url( '/privacy-policy/' ) );

$kvkk_page     = get_page_by_path( 'kvkk' );
$kvkk_url      = esc_url( $kvkk_page ? get_permalink( $kvkk_page ) : home_url( '/kvkk/' ) );

/* ── Inline SVG icons ───────────────────────────────────────────────────────── */
$icons = array(
	'shield'  => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2L4 6v6c0 5 3.4 9.5 8 10 4.6-.5 8-5 8-10V6l-8-4zm0 2.2 5 2.5V12c0 3.5-2.1 6.7-5 7.7-2.9-1-5-4.2-5-7.7V6.7l5-2.5z"/></svg>',
	'phone'   => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.6 2.5l3 2.3c.7.5 1 1.5.6 2.3L9 9.4c-.3.7-.2 1.4.3 2 .9 1.2 2 2.3 3.2 3.2.6.5 1.4.6 2 .3l2.3-1.2c.8-.4 1.8-.1 2.3.6l2.3 3c.6.8.5 2-.3 2.7l-1 .8c-1.1.9-2.6 1.3-4 1.1-2.8-.4-5.5-1.7-8.2-4.4-2.7-2.7-4-5.4-4.4-8.2-.2-1.4.2-2.9 1.1-4l.8-1c.7-.8 1.9-.9 2.7-.3z"/></svg>',
	'lock'    => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 1l9 4v6c0 5.6-3.8 10.7-9 12C6.8 21.7 3 16.6 3 11V5l9-4zm0 2.1L5 6.1V11c0 4.1 2.6 7.9 7 9.2C16.4 18.9 19 15.1 19 11V6.1l-7-3zm-1 5.4h2v3h3v2h-3v3h-2v-3H8v-2h3V8.5z"/></svg>',
	'flag'    => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14.4 6L14 4H5v17h2v-7h5.6l.4 2h7V6h-5.6zM19 14h-3.4l-.4-2H7V6h5.4l.4 2H19v6z"/></svg>',
	'check'   => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>',
	'trust'   => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l8 3v6c0 5-3.4 9.5-8 11-4.6-1.5-8-6-8-11V5l8-3zm0 2.1L6 6.4V11c0 3.9 2.5 7.4 6 8.7 3.5-1.3 6-4.8 6-8.7V6.4l-6-2.3z"/></svg>',
);

/**
 * Return an inline SVG icon safely.
 *
 * @param string $name Icon key.
 * @return string HTML (no escaping — all values are hardcoded above).
 */
$icon = static function ( string $name ) use ( $icons ) : string {
	return $icons[ $name ] ?? '';
};

get_header();
?>

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

				<a class="kk-btn kk-btn-primary" href="<?php echo $app_store_url; ?>" style="display:none;" id="kk-header-cta">
					<?php echo esc_html( $__( 'İndir', 'Download' ) ); ?>
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
						<img src="<?php echo $badge_url; ?>" alt="<?php echo esc_attr( $__( 'App Store\'dan İndir', 'Download on the App Store' ) ); ?>" width="160" height="54" loading="eager" decoding="async">
					</a>
				</div>

				<div class="kk-hero__visual kk-animate kk-animate-delay-2" aria-hidden="true">
					<div class="kk-mockup-placeholder">
						<span><?php echo esc_html( $__( 'iPhone Mockup', 'iPhone Mockup' ) ); ?></span>
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

				<ol class="kk-steps" style="list-style:none;margin:0;padding:0;">

					<li class="kk-step kk-glass kk-animate kk-animate-delay-1">
						<div class="kk-step__num">1</div>
						<h3><?php echo esc_html( $__( 'İndir ve Kur', 'Download & Setup' ) ); ?></h3>
						<p><?php echo esc_html( $__( 'Kalkan\'ı App Store\'dan indirin ve arama korumayı etkinleştirin.', 'Download Kalkan from the App Store and enable call protection.' ) ); ?></p>
					</li>

					<li class="kk-step kk-glass kk-animate kk-animate-delay-2">
						<div class="kk-step__num">2</div>
						<h3><?php echo esc_html( $__( 'Otomatik Koruma', 'Automatic Protection' ) ); ?></h3>
						<p><?php echo esc_html( $__( 'Bilinen spam numaralar otomatik olarak engellenir veya işaretlenir.', 'Known spam numbers are automatically blocked or flagged.' ) ); ?></p>
					</li>

					<li class="kk-step kk-glass kk-animate kk-animate-delay-3">
						<div class="kk-step__num">3</div>
						<h3><?php echo esc_html( $__( 'Bildir ve Güçlendir', 'Report & Strengthen' ) ); ?></h3>
						<p><?php echo esc_html( $__( 'Şüpheli numaraları bildirerek topluluğun korunmasına katkıda bulunun.', 'Report suspicious numbers and help protect the community.' ) ); ?></p>
					</li>

				</ol>
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

				<ul class="kk-feature-grid" style="list-style:none;margin:0;padding:0;">

					<li class="kk-feature-card kk-glass kk-animate kk-animate-delay-1">
						<div class="kk-feature-card__icon" aria-hidden="true"><?php echo $icon( 'shield' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
						<h3><?php echo esc_html( $__( 'Spam Koruması', 'Spam Protection' ) ); ?></h3>
						<p><?php echo esc_html( $__( 'Bilinen spam numaralar sistem entegrasyonu ile engellenir. Veritabanı cihazınıza yüklenir ve koruma çevrimdışı çalışır.', 'Known spam numbers are blocked via system integration. The database is loaded to your device and protection works offline.' ) ); ?></p>
					</li>

					<li class="kk-feature-card kk-glass kk-animate kk-animate-delay-2">
						<div class="kk-feature-card__icon" aria-hidden="true"><?php echo $icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
						<h3><?php echo esc_html( $__( 'Arayan Kimliği', 'Caller Identification' ) ); ?></h3>
						<p><?php echo esc_html( $__( 'Bilinmeyen numaralar hakkında bilgi görüntüler. Kimin aradığını tahmin etmenize gerek kalmaz.', 'Shows information about unknown numbers. No more guessing who\'s calling.' ) ); ?></p>
					</li>

					<li class="kk-feature-card kk-glass kk-animate kk-animate-delay-3">
						<div class="kk-feature-card__icon" aria-hidden="true"><?php echo $icon( 'lock' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
						<h3><?php echo esc_html( $__( 'Ekstra Koruma', 'Extra Protection' ) ); ?></h3>
						<p><?php echo esc_html( $__( 'Genişletilmiş koruma ile daha fazla spam numara engellenir. Sürekli güncellenen veritabanı ile kapsamlı güvenlik.', 'Extended protection blocks even more spam numbers. Comprehensive security with continuously updated database.' ) ); ?></p>
						<span class="kk-badge-free"><?php echo esc_html( $__( 'Şimdilik Ücretsiz', 'Free for Now' ) ); ?></span>
					</li>

					<li class="kk-feature-card kk-glass kk-animate kk-animate-delay-4">
						<div class="kk-feature-card__icon" aria-hidden="true"><?php echo $icon( 'flag' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
						<h3><?php echo esc_html( $__( 'İletişim Bildirimi', 'Communication Reporting' ) ); ?></h3>
						<p><?php echo esc_html( $__( 'Şüpheli numaraları doğrudan Telefon uygulamasından veya Kalkan içinden kolayca bildirin.', 'Easily report suspicious numbers directly from the Phone app or from within Kalkan.' ) ); ?></p>
					</li>

				</ul>
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
							<img src="<?php echo $badge_url; ?>" alt="<?php echo esc_attr( $__( 'App Store\'dan İndir', 'Download on the App Store' ) ); ?>" width="160" height="54" loading="lazy" decoding="async">
						</a>
					</div>
				</div>
			</div>
		</section>

		<!-- ── FAQ ───────────────────────────────────────────────────────────── -->
		<section class="kk-faq kk-section" id="kk-faq" aria-labelledby="kk-faq-title">
			<div class="kk-shell">
				<div class="kk-section-header kk-animate">
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

	</main><!-- /.kk-main -->

	<!-- ── FOOTER ────────────────────────────────────────────────────────────── -->
	<footer class="kk-footer kk-page" aria-label="<?php echo esc_attr( $__( 'Site altı', 'Site footer' ) ); ?>">
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
					© <?php echo esc_html( (string) gmdate( 'Y' ) ); ?> Kalkan.
					<?php echo esc_html( $__( 'Tüm hakları saklıdır.', 'All rights reserved.' ) ); ?>
				</p>
			</div>

		</div>
	</footer>

</div><!-- /.kk-page -->

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

		/* Close drawer when a link inside it is clicked */
		drawer.querySelectorAll('a').forEach(function (link) {
			link.addEventListener('click', function () {
				drawer.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
			});
		});
	}

	/* ── Show header CTA after hero scrolls out of view ── */
	var heroCta = document.getElementById('kk-header-cta');
	var heroSection = document.querySelector('.kk-hero');

	if (heroCta && heroSection && 'IntersectionObserver' in window) {
		var heroObserver = new IntersectionObserver(function (entries) {
			heroCta.style.display = entries[0].isIntersecting ? 'none' : 'inline-flex';
		}, { threshold: 0 });
		heroObserver.observe(heroSection);
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
		/* Fallback: just show everything */
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

<?php get_footer(); ?>
