<?php
/**
 * Template Name: Privacy Policy
 * Template Post Type: page
 *
 * Bilingual privacy policy page (TR default / EN via ?lang=en).
 * Fully self-contained: no get_header()/get_footer() to avoid Blocksy conflicts.
 *
 * @package kalkan-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ── Shared setup ──────────────────────────────────────────────────────────── */
include get_stylesheet_directory() . '/inc/kalkan-setup.php';

$is_front_page = false;
$page_title    = 'en' === $lang ? 'Privacy Policy — Kalkan' : 'Gizlilik Politikası — Kalkan';
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
</head>
<body <?php body_class(); ?>>

<div class="kk-page">

	<?php include get_stylesheet_directory() . '/inc/kalkan-header.php'; ?>

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

	<?php include get_stylesheet_directory() . '/inc/kalkan-footer.php'; ?>

</div>

<?php include get_stylesheet_directory() . '/inc/kalkan-scripts.php'; ?>
<?php wp_footer(); ?>
</body>
</html>
