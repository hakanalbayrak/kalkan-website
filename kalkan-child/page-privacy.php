<?php
/**
 * Template Name: Privacy Policy
 * Template Post Type: page
 *
 * Bilingual privacy policy page (TR default / EN via ?lang=en).
 *
 * @package kalkan-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ── Language detection ─────────────────────────────────────────────────────── */
$lang = ( isset( $_GET['lang'] ) && 'en' === sanitize_key( $_GET['lang'] ) ) ? 'en' : 'tr'; // phpcs:ignore WordPress.Security.NonceVerification

$__ = static function ( string $tr, string $en ) use ( $lang ) : string {
	return 'en' === $lang ? $en : $tr;
};

$lang_tr_url = esc_url( remove_query_arg( 'lang' ) );
$lang_en_url = esc_url( add_query_arg( 'lang', 'en' ) );
$home_url    = esc_url( home_url( '/' ) );

get_header();
?>

<div class="kk-page">

	<!-- ── MINIMAL HEADER ────────────────────────────────────────────────────── -->
	<header class="kk-header">
		<div class="kk-shell kk-header__inner">
			<a class="kk-brand" href="<?php echo $home_url; ?>" aria-label="Kalkan">
				<span class="kk-brand__mark">K</span>
				<span class="kk-brand__name">Kalkan</span>
			</a>
			<div class="kk-header__right">
				<div class="kk-lang">
					<?php if ( 'tr' === $lang ) : ?>
						<span class="kk-lang--active">TR</span>
						<a href="<?php echo $lang_en_url; ?>">EN</a>
					<?php else : ?>
						<a href="<?php echo $lang_tr_url; ?>">TR</a>
						<span class="kk-lang--active">EN</span>
					<?php endif; ?>
				</div>
				<a class="kk-btn kk-btn-ghost" href="<?php echo $home_url; ?>" style="font-size:0.88rem;padding:0.5rem 0.9rem;">
					← <?php echo esc_html( $__( 'Ana Sayfa', 'Home' ) ); ?>
				</a>
			</div>
		</div>
	</header>

	<main class="kk-main">

		<div class="kk-page-header">
			<div class="kk-shell">
				<span class="kk-eyebrow"><?php echo esc_html( $__( 'Yasal', 'Legal' ) ); ?></span>
				<h1><?php echo esc_html( $__( 'Gizlilik Politikası', 'Privacy Policy' ) ); ?></h1>
				<p class="kk-lead" style="margin-top:0.6rem;">
					<?php echo esc_html( $__( 'Kalkan olarak kişisel gizliliğinize saygı duyuyor ve verilerinizi korumayı taahhüt ediyoruz.', 'At Kalkan we respect your privacy and are committed to protecting your data.' ) ); ?>
				</p>
			</div>
		</div>

		<div class="kk-page-content">
			<div class="kk-shell" style="max-width:52rem;">

				<?php if ( 'tr' === $lang ) : ?>

					<p class="kk-effective">Yürürlük Tarihi: 01.03.2026</p>

					<h2>Genel</h2>
					<p>Kalkan, kullanıcı gizliliğine önem verir. Bu politika, uygulamayı ve web sitesini kullanırken toplanan ve işlenen verileri açıklamaktadır.</p>

					<h2>İşlenen Veriler</h2>
					<ul>
						<li>Bildirilen telefon numaraları ve bildirim notları</li>
						<li>Destek e-postaları (yalnızca müşteri hizmetleri amacıyla)</li>
					</ul>
					<p>Kalkan, kişisel rehberinize veya arama kayıtlarınıza <strong>erişmez</strong>.</p>

					<h2>Arama Koruma ve Arayan Kimliği</h2>
					<p>Spam engelleme veritabanı cihazınıza yerel olarak indirilir. Arayan kimlik tanımlama işlemi tamamen çevrimdışı, cihazınız üzerinde gerçekleşir. Bu veriler Kalkan sunucularına iletilmez.</p>

					<h2>Veri Güvenliği</h2>
					<p>Verileriniz üçüncü taraflara satılmaz veya pazarlama amacıyla paylaşılmaz. Güvenliğiniz için uygun teknik ve idari önlemler alınmaktadır.</p>

					<h2>Veri Silme</h2>
					<p>Verilerinizin silinmesini talep etmek için <a href="mailto:info@kalkan.website">info@kalkan.website</a> adresine e-posta gönderebilirsiniz.</p>

					<h2>İletişim</h2>
					<p>Gizlilik ile ilgili sorularınız için: <a href="mailto:info@kalkan.website">info@kalkan.website</a></p>

				<?php else : ?>

					<p class="kk-effective">Effective Date: March 01, 2026</p>

					<h2>Overview</h2>
					<p>Kalkan respects your privacy. This policy explains what data is collected and processed when you use the app and website.</p>

					<h2>Data Processed</h2>
					<ul>
						<li>Reported phone numbers and report notes</li>
						<li>Support emails (used solely for customer service purposes)</li>
					</ul>
					<p>Kalkan does <strong>not</strong> access your contacts or call logs.</p>

					<h2>Call Protection & Caller ID</h2>
					<p>The spam blocking database is downloaded locally to your device. Caller identification is performed entirely offline, on your device. This data is not transmitted to Kalkan servers.</p>

					<h2>Data Security</h2>
					<p>Your data is never sold or shared with third parties for marketing purposes. Appropriate technical and administrative measures are in place to protect your information.</p>

					<h2>Data Deletion</h2>
					<p>To request deletion of your data, please email <a href="mailto:info@kalkan.website">info@kalkan.website</a>.</p>

					<h2>Contact</h2>
					<p>For privacy-related questions: <a href="mailto:info@kalkan.website">info@kalkan.website</a></p>

				<?php endif; ?>

			</div>
		</div>

	</main>

	<footer class="kk-footer kk-page">
		<div class="kk-shell" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
			<p class="kk-footer__copy">© <?php echo esc_html( (string) gmdate( 'Y' ) ); ?> Kalkan. <?php echo esc_html( $__( 'Tüm hakları saklıdır.', 'All rights reserved.' ) ); ?></p>
			<a href="<?php echo $home_url; ?>" class="kk-footer__contact" style="color:var(--kk-text-muted);font-size:0.88rem;text-decoration:none;font-weight:600;">
				← <?php echo esc_html( $__( 'Ana Sayfaya Dön', 'Back to Home' ) ); ?>
			</a>
		</div>
	</footer>

</div><!-- /.kk-page -->

<?php get_footer(); ?>
