<?php
/**
 * Template Name: Kalkan Nedir
 * Template Post Type: page
 *
 * What is Kalkan? page (TR default / EN via Polylang).
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
	? 'What is Kalkan? | Spam Call Blocking and Caller ID App'
	: 'Kalkan Nedir? | Spam Arama Engelleme ve Numara Tanıma Uygulaması';
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
				<span class="kk-eyebrow"><?php echo esc_html( $__( 'Hakkında', 'About' ) ); ?></span>
				<h1><?php echo esc_html( $__( 'Kalkan Nedir?', 'What is Kalkan?' ) ); ?></h1>
				<p class="kk-lead" style="margin-top:0.6rem;">
					<?php echo esc_html( $__( 'Kalkan, iPhone kullanıcıları için geliştirilmiş bir spam arama engelleme ve numara tanıma uygulamasıdır.', 'Kalkan is a spam call blocking and caller identification app for iPhone users.' ) ); ?>
				</p>
			</div>
		</div>

		<div class="kk-page-content">
			<div class="kk-shell" style="max-width:52rem;">

				<?php if ( 'tr' === $lang ) : ?>

					<h2><?php echo esc_html( 'Kalkan ne yapar?' ); ?></h2>
					<p>Kalkan, bilinmeyen numaraları tanımanıza yardımcı olur ve spam aramaları azaltır. Telefonunuza gelen aramalar, önceden hazırlanmış bir veri listesine göre kontrol edilir. Bu uygulama sayesinde:</p>
					<ul>
						<li>Spam aramaları engelleyebilirsiniz</li>
						<li>Bilinmeyen numaralar hakkında bilgi alabilirsiniz</li>
						<li>Şüpheli aramaları kolayca bildirebilirsiniz</li>
					</ul>

					<p>Kalkan gerçek zamanlı çalışan bir uygulama değildir. Uygulama, iPhone'un sistem özelliklerini kullanarak daha önceden hazırlanmış veriler ile çalışır. Bu sayede:</p>
					<ul>
						<li>Daha hızlı çalışır</li>
						<li>İnternete bağlı olmadan da koruma sağlar</li>
						<li>Telefon performansını etkilemez</li>
					</ul>

					<h2><?php echo esc_html( 'Kalkan kimler için uygundur?' ); ?></h2>
					<ul>
						<li>Sık spam arama alan kullanıcılar</li>
						<li>Bilinmeyen numaralardan rahatsız olanlar</li>
						<li>Aile üyelerini korumak isteyen kişiler</li>
					</ul>

					<h2><?php echo esc_html( 'Sık Sorulan Sorular' ); ?></h2>

					<h3>Kalkan ücretsiz mi?</h3>
					<p>Evet, temel koruma ve arama bildirme özellikleri ücretsizdir.</p>

					<h3>Kalkan tüm aramaları engeller mi?</h3>
					<p>Hayır. Sadece veri listesinde bulunan numaralar engellenir veya tanınır.</p>

					<h3>Kalkan internet olmadan çalışır mı?</h3>
					<p>Evet, indirilen veriler sayesinde temel koruma çevrimdışı çalışır.</p>

					<p style="margin-top:2rem;">
						<a href="<?php echo esc_url( kalkan_page_url( 'kalkan-nasil-calisir', 'how-kalkan-works' ) ); ?>">Kalkan nasıl çalışır?</a> &middot;
						<a href="<?php echo esc_url( kalkan_page_url( 'kalkan-nasil-kullanilir', 'how-to-use-kalkan' ) ); ?>">Kalkan nasıl kullanılır?</a>
					</p>

				<?php else : ?>

					<h2>What does Kalkan do?</h2>
					<p>Kalkan helps you identify unknown callers and reduce unwanted spam calls. Incoming calls are checked against a preloaded dataset on your device. With Kalkan, you can:</p>
					<ul>
						<li>Block known spam calls</li>
						<li>Identify unknown numbers</li>
						<li>Report suspicious calls easily</li>
					</ul>

					<p>Kalkan does not work in real time. It uses Apple's system-level features and preloaded data to provide protection. This means:</p>
					<ul>
						<li>Fast performance</li>
						<li>Works even without internet connection</li>
						<li>Does not slow down your phone</li>
					</ul>

					<h2>Who is Kalkan for?</h2>
					<ul>
						<li>Users who receive frequent spam calls</li>
						<li>People who want to identify unknown numbers</li>
						<li>Families who want safer communication</li>
					</ul>

					<h2>Frequently Asked Questions</h2>

					<h3>Is Kalkan free?</h3>
					<p>Yes, basic protection and reporting features are free.</p>

					<h3>Does Kalkan block all calls?</h3>
					<p>No. It only blocks or identifies numbers that exist in its dataset.</p>

					<h3>Does Kalkan work offline?</h3>
					<p>Yes, core protection works offline after the data is downloaded.</p>

					<p style="margin-top:2rem;">
						<a href="<?php echo esc_url( kalkan_page_url( 'kalkan-nasil-calisir', 'how-kalkan-works' ) ); ?>">How does Kalkan work?</a> &middot;
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
