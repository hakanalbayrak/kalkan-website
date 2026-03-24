<?php
/**
 * Template Name: Kalkan Nasıl Çalışır
 * Template Post Type: page
 *
 * How Kalkan works page (TR default / EN via Polylang).
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
$page_title    = 'en' === $lang
	? 'How Does Kalkan Work? — Kalkan'
	: 'Kalkan Nasıl Çalışır? — Kalkan';
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
				<span class="kk-eyebrow"><?php echo esc_html( $__( 'Teknik', 'Technical' ) ); ?></span>
				<h1><?php echo esc_html( $__( 'Kalkan Nasıl Çalışır?', 'How Does Kalkan Work?' ) ); ?></h1>
				<p class="kk-lead" style="margin-top:0.6rem;">
					<?php echo esc_html( $__( 'Kalkan, iPhone\'un Call Directory ve Communication Reporting özelliklerini kullanır.', 'Kalkan uses Apple\'s Call Directory and Communication Reporting features.' ) ); ?>
				</p>
			</div>
		</div>

		<div class="kk-page-content">
			<div class="kk-shell" style="max-width:52rem;">

				<?php if ( 'tr' === $lang ) : ?>

					<h2>1. Veri indirimi</h2>
					<p>Uygulama, spam olduğu bilinen numaraların bulunduğu bir veri listesini indirir.</p>

					<h2>2. Sistem entegrasyonu</h2>
					<p>Bu liste, iPhone'un arama sistemine eklenir.</p>

					<h2>3. Arama kontrolü</h2>
					<p>Bir arama geldiğinde, telefon bu listeyi kontrol eder. Eğer numara listede varsa:</p>
					<ul>
						<li>Engellenir veya</li>
						<li>Tanımlanır</li>
					</ul>

					<h2>4. Kullanıcı bildirimi</h2>
					<p>Kullanıcılar şüpheli aramaları bildirebilir. Bu bildirimler:</p>
					<ul>
						<li>Sistemin gelişmesine yardımcı olur</li>
						<li>Veri tabanını güçlendirir</li>
					</ul>

					<h2>Önemli bilgi</h2>
					<p>Kalkan gerçek zamanlı analiz yapmaz. Tüm işlemler önceden hazırlanmış veriler üzerinden gerçekleşir.</p>

					<p style="margin-top:2rem;">
						<a href="<?php echo esc_url( kalkan_page_url( 'kalkan-nedir', 'what-is-kalkan' ) ); ?>">Kalkan nedir?</a> &middot;
						<a href="<?php echo esc_url( kalkan_page_url( 'kalkan-nasil-kullanilir', 'how-to-use-kalkan' ) ); ?>">Kalkan nasıl kullanılır?</a>
					</p>

				<?php else : ?>

					<h2>1. Data download</h2>
					<p>The app downloads a dataset of known spam numbers.</p>

					<h2>2. System integration</h2>
					<p>This dataset is integrated into the iPhone's call system.</p>

					<h2>3. Call check</h2>
					<p>When a call is received, the phone checks the number against the dataset. If the number exists:</p>
					<ul>
						<li>It is blocked, or</li>
						<li>It is identified</li>
					</ul>

					<h2>4. User reporting</h2>
					<p>Users can report suspicious calls. These reports help:</p>
					<ul>
						<li>Improve the system</li>
						<li>Strengthen the dataset</li>
					</ul>

					<h2>Important note</h2>
					<p>Kalkan does not perform real-time analysis. All actions are based on preloaded data.</p>

					<p style="margin-top:2rem;">
						<a href="<?php echo esc_url( kalkan_page_url( 'kalkan-nedir', 'what-is-kalkan' ) ); ?>">What is Kalkan?</a> &middot;
						<a href="<?php echo esc_url( kalkan_page_url( 'kalkan-nasil-kullanilir', 'how-to-use-kalkan' ) ); ?>">How to use Kalkan</a>
					</p>

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
