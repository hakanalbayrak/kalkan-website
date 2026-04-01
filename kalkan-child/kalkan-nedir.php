<?php
/**
 * Template Name: Kalkan Nedir
 * Template Post Type: page
 *
 * Bilingual "What is Kalkan?" page.
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
					<?php echo esc_html( $__( 'Spam arama engelleme ve numara tanıma uygulaması.', 'Spam call blocking and caller identification app.' ) ); ?>
				</p>
			</div>
		</div>

		<div class="kk-page-content">
			<div class="kk-shell" style="max-width:52rem;">

				<?php if ( 'tr' === $lang ) : ?>

					<p>Kalkan, istenmeyen aramaları azaltmanıza ve bilinen numaraları etiketleyerek hangi kurum veya kurumların sizi aradığını görmenize yardımcı olan bir arama engelleme ve arayanı bildirme uygulamasıdır.</p>

					<h2>Kalkan ne yapar?</h2>
					<p>Kalkan, bilinmeyen numaraları tanımanıza yardımcı olur ve spam aramaları azaltır. Telefonunuza gelen aramalar, önceden hazırlanmış bir veri listesine göre kontrol edilir. Bu uygulama sayesinde:</p>
					<ul>
						<li>Spam aramaları engelleyebilirsiniz</li>
						<li>Bilinmeyen numaralar hakkında bilgi alabilirsiniz</li>
						<li>Şüpheli aramaları kolayca bildirebilirsiniz</li>
					</ul>

					<p>Koruma, düzenli olarak güncellenen veritabanı ve kullanıcılar bildirdiği numaralar da gerekli incelemeler sonucu listeye eklenerek güncel koruma sağlanır.</p>

					<p>Kalkan gerçek zamanlı çalışan bir uygulama değildir. Uygulama, iPhone'un sistem özelliklerini kullanarak daha önceden hazırlanmış veriler ile çalışır. Bu sayede:</p>
					<ul>
						<li>Daha hızlı çalışır</li>
						<li>İnternete bağlı olmadan da koruma sağlar</li>
						<li>Telefon performansını etkilemez</li>
					</ul>

					<h2>Gizliliğiniz</h2>
					<p>Kalkan arama içeriğinize erişmez. Uygulama, numaraları cihaz üzerinde engellemek ve etiketlemek için CallKit Arama Dizini özelliklerini kullanır.</p>

					<h2>Kalkan kimler için uygundur?</h2>
					<ul>
						<li>Sık spam arama alan kullanıcılar</li>
						<li>Bilinmeyen numaralardan rahatsız olanlar</li>
						<li>Aile üyelerini korumak isteyen kişiler</li>
					</ul>

					<h2>Sık Sorulan Sorular</h2>

					<h3>Kalkan ücretsiz mi?</h3>
					<p>Evet, temel koruma ve arama bildirme özellikleri ücretsizdir.</p>

					<h3>Kalkan tüm aramaları engeller mi?</h3>
					<p>Hayır. Sadece veri listesinde bulunan numaralar engellenir veya tanınır.</p>

					<h3>Kalkan internet olmadan çalışır mı?</h3>
					<p>Evet, indirilen veriler sayesinde temel koruma çevrimdışı çalışır.</p>

				<?php else : ?>

					<p>Kalkan is a call protection app that helps you reduce unwanted calls and see identification labels for known numbers.</p>

					<h2>What does Kalkan do?</h2>
					<p>Kalkan helps you identify unknown callers and reduce unwanted spam calls. Incoming calls are checked against a preloaded dataset on your device. With Kalkan, you can:</p>
					<ul>
						<li>Block known spam calls</li>
						<li>Identify unknown numbers</li>
						<li>Report suspicious calls easily</li>
					</ul>

					<p>Protection is powered by regularly updated datasets and community reports reviewed in our moderation dashboard.</p>

					<p>Kalkan does not work in real time. It uses Apple's system-level features and preloaded data to provide protection. This means:</p>
					<ul>
						<li>Fast performance</li>
						<li>Works even without internet connection</li>
						<li>Does not slow down your phone</li>
					</ul>

					<h2>Your Privacy</h2>
					<p>Your call content is not accessed by Kalkan. The app uses CallKit Call Directory features to block and label numbers on-device.</p>

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
