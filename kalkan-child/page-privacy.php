<?php
/**
 * Template Name: Privacy Policy
 * Template Post Type: page
 *
 * Bilingual privacy policy page (TR default / EN via Polylang).
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
<?php echo $_kk_seo_tags(); ?>
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

					<h2>Biz ne tür veri topluyoruz?</h2>
					<p>Hizmeti geliştirmek için gönderdiğiniz bildirimleri (bildirdiğiniz telefon numarası, kategori, isteğe bağlı not, ülke) toplayabiliriz.</p>
					<ul>
						<li>Bildirilen telefon numaraları ve bildirim notları</li>
						<li>Destek e-postaları (yalnızca müşteri hizmetleri amacıyla)</li>
					</ul>

					<h2>Biz ne toplamıyoruz?</h2>
					<p>Kalkan uygulaması telefon rehberinize, arama içeriğinize ve kişisel çağrı geçmişinize <strong>erişmez</strong> ve bu bilgileri toplamaz.</p>

					<h2>Arama Koruma ve Arayan Kimliği</h2>
					<p>Spam engelleme veritabanı cihazınıza yerel olarak indirilir. Arayan kimlik tanımlama işlemi tamamen çevrimdışı, cihazınız üzerinde gerçekleşir. Bu veriler Kalkan sunucularına iletilmez.</p>

					<h2>Veri nasıl kullanılıyor?</h2>
					<p>Kullanıcılardan gelen raporlar değerlendirilip koruma verimliliğini arttırmak amacıyla şüpheli numaralar veritabanımızda işlenerek koruma uygulaması güncellenmektedir.</p>

					<h2>Veri paylaşımı</h2>
					<p>Kişisel veri toplanmamaktadır. İletilen raporlar içerisindeki numaralar moderasyon ekibi tarafından gerekli kontroller yapıldıktan sonra veritabanımızda ilgili kategori içerisinde listelenmektedir.</p>

					<h2>Veri saklama</h2>
					<p>Bildirimler, kötüye kullanımın önlenmesi ve hizmet kalitesi için gerektiği sürece saklanabilir.</p>

					<h2>Veri Silme</h2>
					<p>Verilerinizin silinmesini talep etmek için <a href="mailto:info@kalkan.website">info@kalkan.website</a> adresine e-posta gönderebilirsiniz.</p>

					<h2>Bu politikadaki değişiklikler</h2>
					<p>Bu Gizlilik Politikasını zaman zaman güncelleyebiliriz. Değişiklikler uygulama içinde ve web sitesinde yansıtılır.</p>

					<h2>İletişim</h2>
					<p>Gizlilik ile ilgili sorularınız için: <a href="mailto:info@kalkan.website">info@kalkan.website</a></p>

				<?php else : ?>

					<p class="kk-effective">Effective Date: March 01, 2026</p>

					<h2>Overview</h2>
					<p>Kalkan respects your privacy. This policy explains what data is collected and processed when you use the app and website.</p>

					<h2>What we collect</h2>
					<p>We may collect reports you submit (phone number you report, category, optional note, country) to improve the service.</p>
					<ul>
						<li>Reported phone numbers and report notes</li>
						<li>Support emails (used solely for customer service purposes)</li>
					</ul>

					<h2>What we do not collect</h2>
					<p>We do <strong>not</strong> access your contacts, call audio, call content, or personal call history.</p>

					<h2>Call Protection & Caller ID</h2>
					<p>The spam blocking database is downloaded locally to your device. Caller identification is performed entirely offline, on your device. This data is not transmitted to Kalkan servers.</p>

					<h2>How data is used</h2>
					<p>Reports are used for moderation and to improve protection lists.</p>

					<h2>Data sharing</h2>
					<p>We do not sell personal data. We may share aggregated, non-identifying stats for service improvement.</p>

					<h2>Data retention</h2>
					<p>Reports may be retained as needed for abuse prevention and service quality.</p>

					<h2>Data Deletion</h2>
					<p>To request deletion of your data, please email <a href="mailto:info@kalkan.website">info@kalkan.website</a>.</p>

					<h2>Changes to this policy</h2>
					<p>We may update this Privacy Policy from time to time. Changes will be reflected inside the app and on this website.</p>

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
