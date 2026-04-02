<?php
/**
 * Template Name: Kalkan Nasıl Kullanılır
 * Template Post Type: page
 *
 * Bilingual "How to Use Kalkan" page.
 * Fully self-contained: no get_header()/get_footer() to avoid Blocksy conflicts.
 *
 * @package kalkan-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include get_stylesheet_directory() . '/inc/kalkan-setup.php';

$is_front_page = false;
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
				<span class="kk-eyebrow"><?php echo esc_html( $__( 'Rehber', 'Guide' ) ); ?></span>
				<h1><?php echo esc_html( $__( 'Kalkan Nasıl Kullanılır?', 'How to Use Kalkan?' ) ); ?></h1>
				<p class="kk-lead" style="margin-top:0.6rem;">
					<?php echo esc_html( $__( 'Adım adım kurulum ve kullanım rehberi.', 'Step-by-step setup and usage guide.' ) ); ?>
				</p>
			</div>
		</div>

		<div class="kk-page-content">
			<div class="kk-shell" style="max-width:52rem;">

				<?php if ( 'tr' === $lang ) : ?>

					<p>Kalkan'ı kullanmak oldukça basittir.</p>

					<h2>1. Uygulamayı indirin</h2>
					<p>App Store üzerinden <a href="https://apple.co/4cYKmRG">Kalkan uygulamasını indirin</a>.</p>

					<h2>2. Koruma ayarlarını açın</h2>
					<p>iPhone Ayarlar → Telefon → Arama Engelleme ve Kimlik Tanımlama bölümüne gidin ve Kalkan'ı aktif edin.</p>

					<h2>3. Koruma hazır</h2>
					<p>Artık spam aramalar engellenir veya tanımlanır.</p>

					<h2>4. Arama bildirme</h2>
					<p>Şüpheli bir arama aldığınızda:</p>
					<ul>
						<li>Son aramalar ekranını açın</li>
						<li>Numarayı sola kaydırın</li>
						<li>Bildir seçeneğine dokunun</li>
					</ul>

					<h2>5. Kategori seçin ve gönderin</h2>
					<p>Aramanın türünü seçin ve gönderin. Bu işlem diğer kullanıcıların da korunmasına yardımcı olur.</p>

				<?php else : ?>

					<p>Using Kalkan is simple.</p>

					<h2>1. Download the app</h2>
					<p>Install <a href="https://apple.co/4cYKmRG">Kalkan from the App Store</a>.</p>

					<h2>2. Enable protection</h2>
					<p>Go to iPhone Settings → Phone → Call Blocking &amp; Identification and enable Kalkan.</p>

					<h2>3. Protection is active</h2>
					<p>Spam calls will now be blocked or identified.</p>

					<h2>4. Report a call</h2>
					<p>If you receive a suspicious call:</p>
					<ul>
						<li>Open Recents</li>
						<li>Swipe the number from right to left</li>
						<li>Tap report</li>
					</ul>

					<h2>5. Select category and send</h2>
					<p>Choose the correct category and submit. This helps improve protection for all users.</p>

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
