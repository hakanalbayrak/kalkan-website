<?php
/**
 * Template Name: Terms of Use
 * Template Post Type: page
 *
 * Bilingual terms of use page (TR default / EN via Polylang).
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
$page_title    = 'en' === $lang ? 'Terms of Use — Kalkan' : 'Kullanım Koşulları — Kalkan';
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
				<h1><?php echo esc_html( $__( 'Kullanım Koşulları', 'Terms of Use' ) ); ?></h1>
				<p class="kk-lead" style="margin-top:0.6rem;">
					<?php echo esc_html( $__( 'Kalkan uygulamasını kullanmadan önce lütfen bu koşulları okuyun.', 'Please read these terms before using the Kalkan app.' ) ); ?>
				</p>
			</div>
		</div>

		<div class="kk-page-content">
			<div class="kk-shell" style="max-width:52rem;">

				<?php if ( 'tr' === $lang ) : ?>

					<p class="kk-effective">Son güncelleme: 28.02.2026</p>

					<h2>1. Uygulamanın sunduğu özellik</h2>
					<p>Kalkan, mevcut veri kümelerine göre arama engelleme ve numara tanıma sağlar; sonuçlar değişebilir.</p>

					<h2>2. %100 garanti yok</h2>
					<p>Hiçbir arama koruma uygulaması %100 koruma garanti edemez. Kararlarınızdan ve eylemlerinizden siz sorumlusunuz.</p>

					<h2>3. Kabul edilebilir kullanım</h2>
					<p>Bildirim özelliklerini kötüye kullanmayın ve yasa dışı veya yanıltıcı içerik göndermeyin.</p>

					<h2>4. Sorumluluk sınırı</h2>
					<p>Uygulama, yasal olarak izin verilen en geniş kapsamda "olduğu gibi" sunulur.</p>

					<h2>5. Apple faturalandırma</h2>
					<p>Abonelikler ve satın almalar Apple tarafından yönetilir. İade talepleri Apple tarafından ele alınır.</p>

				<?php else : ?>

					<p class="kk-effective">Last update: February 28, 2026</p>

					<h2>1. Service description</h2>
					<p>Kalkan provides call blocking and identification based on available datasets; results may vary.</p>

					<h2>2. No guarantee</h2>
					<p>No call protection app can guarantee 100% protection. You remain responsible for your decisions and actions.</p>

					<h2>3. Acceptable use</h2>
					<p>Do not abuse reporting features and do not submit illegal or misleading content.</p>

					<h2>4. Liability limitation</h2>
					<p>The app is provided "as is" to the maximum extent permitted by law.</p>

					<h2>5. Apple billing</h2>
					<p>Subscriptions and purchases are managed by Apple. Refund requests are handled by Apple.</p>

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
