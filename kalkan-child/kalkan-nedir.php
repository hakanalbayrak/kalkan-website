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
<?php echo $_kk_seo_tags(); ?>
<link rel="stylesheet" href="<?php echo esc_url(kalkan_ui_stylesheet_url()); ?>">
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

					<p>Kalkan, istenmeyen aramaları azaltmanıza ve bilinen kurumsal numaraları arama sırasında tanımanıza yardımcı olan bağımsız bir iPhone arama koruması uygulamasıdır. Koruma verileri cihaza yüklenir; gelen aramanın numarayla eşleştirilmesi iOS tarafından cihaz üzerinde yapılır.</p>

					<h2>Kalkan ne yapar?</h2>
					<p>Kalkan, bilinmeyen numaraları tanımanıza yardımcı olur ve spam aramaları azaltır. Telefonunuza gelen aramalar, önceden hazırlanmış bir veri listesine göre kontrol edilir. Bu uygulama sayesinde:</p>
					<ul>
						<li>Spam aramaları engelleyebilirsiniz</li>
						<li>Bilinmeyen numaralar hakkında bilgi alabilirsiniz</li>
						<li>Şüpheli aramaları kolayca bildirebilirsiniz</li>
					</ul>

					<p>Genel Koruma, arayan kimliği ve İletişim Bildirimi ücretsizdir. Kalkan Premium ile sunulan Ekstra Koruma ise şüpheli numara desenleri için daha geniş engelleme kapsamı sağlar ve uygulama içi reklamları kaldırır. Özelliklerin güncel kapsamı uygulamadaki açıklamalar ve <a href="<?php echo esc_url( $documentation_url ); ?>">Kalkan dokümantasyonunda</a> açıkça belirtilir.</p>

					<h2>Koruma verisi nasıl hazırlanır?</h2>
					<p>Kurumsal arayan kimliği adaylarında kurumun kendi resmî sayfasında yayımladığı telefon numarası aranır. İstenmeyen arama adaylarında kullanıcı bildirimleri ve erişilebilir açık kaynak sinyalleri incelenir. Bir yorum tek başına numaranın sahibini veya kötü niyetini kesin olarak kanıtlamaz; numara taklidi, numara devri ve eski kayıt olasılıkları değerlendirilir. Bu nedenle Kalkan etiketleri bir güvenlik sinyali sunar, hukuki veya kesin bir hüküm sunmaz.</p>

					<p>Yayınlanan içerikler ile numara incelemeleri birbirinden ayrılır. Bir kaynağın neden kullanıldığı, düzeltmelerin nasıl ele alındığı ve reklamların editoryal kararlardan nasıl ayrıldığı <a href="<?php echo esc_url( $editorial_policy_url ); ?>">İçerik İlkeleri</a> sayfasında açıklanır.</p>

					<p>Kalkan gerçek zamanlı çalışan bir uygulama değildir. Uygulama, iPhone'un sistem özelliklerini kullanarak daha önceden hazırlanmış veriler ile çalışır. Bu sayede:</p>
					<ul>
						<li>Daha hızlı çalışır</li>
						<li>İnternete bağlı olmadan da koruma sağlar</li>
						<li>Telefon performansını etkilemez</li>
					</ul>

					<h2>Gizliliğiniz</h2>
					<p>Kalkan arama içeriğinize erişmez; rehberinizi veya kişisel arama geçmişinizi Kalkan sunucusuna yüklemez. Uygulama, numaraları cihaz üzerinde engellemek ve etiketlemek için iOS Arama Dizini özelliklerini kullanır. Bir numarayı bildirmeyi seçtiğinizde yalnızca gönderdiğiniz rapor ve teknik olarak gerekli alanlar inceleme sürecine ulaşır. Ayrıntılar <a href="<?php echo esc_url( $privacy_url ); ?>">Gizlilik Politikası</a> içinde yer alır.</p>

					<h2>Kalkan ne yapamaz?</h2>
					<p>Hiçbir arama koruması yeni kullanılmaya başlayan, taklit edilmiş veya henüz raporlanmamış bütün numaraları önceden bilemez. Kalkan bir aramanın içeriğini dinlemez, konuşmayı analiz etmez ve ekranda görünen bir etiketi mutlak doğrulama olarak sunmaz. Para, doğrulama kodu veya kişisel bilgi isteyen aramalarda kurumun resmî kanalını kendiniz açarak doğrulama yapmanız gerekir.</p>

					<h2>Kalkan kimler için uygundur?</h2>
					<ul>
						<li>Sık spam arama alan kullanıcılar</li>
						<li>Bilinmeyen numaralardan rahatsız olanlar</li>
						<li>Aile üyelerini korumak isteyen kişiler</li>
					</ul>

					<h2>Sık Sorulan Sorular</h2>

					<h3>Kalkan ücretsiz mi?</h3>
					<p>Genel Koruma ve İletişim Bildirimi ücretsizdir. Yalnızca Ekstra Koruma, Türkiye'de sunulan Kalkan Premium yıllık aboneliğini gerektirir.</p>

					<h3>Kalkan tüm aramaları engeller mi?</h3>
					<p>Hayır. Sadece veri listesinde bulunan numaralar engellenir veya tanınır.</p>

					<h3>Kalkan internet olmadan çalışır mı?</h3>
					<p>Evet, indirilen veriler sayesinde temel koruma çevrimdışı çalışır. Yeni koruma verilerini indirmek ve bildirim göndermek için internet bağlantısı gerekir.</p>

				<?php else : ?>

					<p>Kalkan is an independently developed iPhone call-protection app that helps reduce unwanted calls and identify known institutional numbers. Protection data is loaded onto the device, and iOS performs the number match locally when a call arrives.</p>

					<h2>What does Kalkan do?</h2>
					<p>Kalkan helps you identify unknown callers and reduce unwanted spam calls. Incoming calls are checked against a preloaded dataset on your device. With Kalkan, you can:</p>
					<ul>
						<li>Block known spam calls</li>
						<li>Identify unknown numbers</li>
						<li>Report suspicious calls easily</li>
					</ul>

					<p>General Protection, caller identification and Communication Reporting are free. Extra Protection, available with Kalkan Premium, expands blocking for suspicious number patterns and removes in-app ads. The current scope of each feature is documented in the app and in the <a href="<?php echo esc_url( $documentation_url ); ?>">Kalkan documentation</a>.</p>

					<h2>How is protection data prepared?</h2>
					<p>Institutional caller-ID candidates are checked against phone numbers visibly published on the organization’s own official website. User reports and accessible public signals may be reviewed for unwanted-call candidates. A public comment alone does not conclusively prove ownership or malicious intent; caller-ID spoofing, reassigned numbers and stale records are possible. Kalkan labels are therefore risk signals, not legal findings or guarantees.</p>

					<p>Editorial publishing and number moderation are separate processes. Our <a href="<?php echo esc_url( $editorial_policy_url ); ?>">Editorial Policy</a> explains source selection, corrections, uncertainty and the separation between advertising and editorial decisions.</p>

					<p>Kalkan does not work in real time. It uses Apple's system-level features and preloaded data to provide protection. This means:</p>
					<ul>
						<li>Fast performance</li>
						<li>Works even without internet connection</li>
						<li>Does not slow down your phone</li>
					</ul>

					<h2>Your Privacy</h2>
					<p>Kalkan does not access call audio, upload your contacts or upload your personal call history. It uses iOS Call Directory features to block and label numbers on-device. If you choose to report a number, only the submitted report and technically required fields enter the review process. See the <a href="<?php echo esc_url( $privacy_url ); ?>">Privacy Policy</a> for details.</p>

					<h2>What can Kalkan not do?</h2>
					<p>No call-protection product can know every newly used, spoofed or not-yet-reported number in advance. Kalkan does not listen to calls, analyze conversations or present an on-screen label as absolute verification. If a caller asks for money, a verification code or personal information, open the organization’s official channel yourself and verify the request independently.</p>

					<h2>Who is Kalkan for?</h2>
					<ul>
						<li>Users who receive frequent spam calls</li>
						<li>People who want to identify unknown numbers</li>
						<li>Families who want safer communication</li>
					</ul>

					<h2>Frequently Asked Questions</h2>

					<h3>Is Kalkan free?</h3>
					<p>General Protection and Communication Reporting are free. Only Extra Protection requires the annual Kalkan Premium subscription, currently available in Türkiye.</p>

					<h3>Does Kalkan block all calls?</h3>
					<p>No. It only blocks or identifies numbers that exist in its dataset.</p>

					<h3>Does Kalkan work offline?</h3>
					<p>Yes, core protection works offline after the data is downloaded. An internet connection is required to download new protection data or submit a report.</p>

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
