<?php
/**
 * Template Name: Kalkan Nasıl Çalışır
 * Template Post Type: page
 *
 * Bilingual "How Kalkan Works" page.
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
				<span class="kk-eyebrow"><?php echo esc_html( $__( 'Teknik', 'Technical' ) ); ?></span>
				<h1><?php echo esc_html( $__( 'Kalkan Nasıl Çalışır?', 'How Does Kalkan Work?' ) ); ?></h1>
				<p class="kk-lead" style="margin-top:0.6rem;">
					<?php echo esc_html( $__( 'iPhone\'un sistem özelliklerini kullanarak spam aramaları engeller.', 'Blocks spam calls using iPhone\'s system-level features.' ) ); ?>
				</p>
			</div>
		</div>

		<div class="kk-page-content">
			<div class="kk-shell" style="max-width:52rem;">

				<?php if ( 'tr' === $lang ) : ?>

					<p>Kalkan, iPhone'un Arama Dizini ve İletişim Bildirimi özelliklerini kullanır. Arama sırasında ses dinlemez veya sunucuda gerçek zamanlı sorgu yapmaz; eşleştirme, önceden yüklenen koruma verisi ile iOS tarafından cihaz üzerinde gerçekleştirilir.</p>

					<h2>1. Veri hazırlanır ve indirilir</h2>
					<p>Kalkan, incelenmiş istenmeyen arama kayıtlarını ve kurumsal arayan kimliği kayıtlarını ayrı amaçlarla hazırlar. Kullanıcı Güncelle düğmesine dokunduğunda uygun koruma verisi güvenli bağlantı üzerinden telefona indirilir. İndirilen verinin tarihi uygulamada gösterilir; böylece korumanın ne zaman yenilendiği görülebilir.</p>

					<h2>2. Sistem entegrasyonu</h2>
					<p>İndirilen kayıtlar Kalkan uzantıları aracılığıyla iPhone'un Arama Engelleme ve Numara Tanıma sistemine eklenir. Bunun çalışması için kullanıcı iOS Ayarları içinde Kalkan uzantılarını bir kez etkinleştirir. Kalkan bu sistem ayarını kullanıcı adına gizlice değiştiremez.</p>

					<h2>3. Arama kontrolü</h2>
					<p>Bir arama geldiğinde iOS, arayan numarayı cihazdaki kayıtlarla karşılaştırır. Numara engelleme listesinde ise çağrı sistem düzeyinde engellenebilir; arayan kimliği listesinde ise ekranda nötr kurum etiketi gösterilebilir. Bir numara aynı anda hem güvenli hem de engellenecek kayıt olarak değerlendirilmez.</p>
					<ul>
						<li>Engellenir veya</li>
						<li>Tanımlanır</li>
					</ul>

					<h2>4. Kullanıcı bildirimi incelemeye gider</h2>
					<p>Kullanıcılar şüpheli, reklam, otomatik veya yanıltıcı olduğunu düşündükleri aramaları iPhone'un İletişim Bildirimi akışı üzerinden Kalkan'a gönderebilir. Bildirim doğrudan engelleme listesine yayımlanmaz; kategori, mevcut kayıtlar, açık kaynak sinyalleri ve olası kurumsal eşleşmeler açısından incelenir.</p>
					<p>Bu bildirimler:</p>
					<ul>
						<li>Tekrarlanan reklam, otomatik arama ve dolandırıcılık girişimi sinyallerinin araştırılmasına yardımcı olur.</li>
						<li>Yanlış veya eski bir kaydın düzeltilebilmesi için inceleme izi oluşturur.</li>
					</ul>

					<h2>5. Koruma güncel tutulur</h2>
					<p>Yeni incelenmiş kayıtlar uygulamadaki güncelleme işlemiyle cihaza alınır. Güncelleme hatırlatıcısı cihazda yerel olarak çalışır. Bir güncellemenin yapılmış olması bütün yeni veya taklit edilmiş numaraların kesin olarak engelleneceği anlamına gelmez; güncel veri yalnızca bilinen kayıtların kapsamını artırır.</p>

					<h2>Gizlilik sınırı</h2>
					<p>Kalkan rehberinizi, kişisel arama geçmişinizi veya görüşme içeriğini koruma eşleştirmesi için sunucuya göndermez. iOS uzantısı, Apple'ın izin verdiği sınırlı çalışma modeli içinde önceden yüklenmiş numara verisini kullanır. Ayrıntılı veri işleme açıklaması <a href="<?php echo esc_url( $privacy_url ); ?>">Gizlilik Politikası</a> içinde bulunur.</p>

					<h2>Önemli bilgi</h2>
					<p>Kalkan gerçek zamanlı konuşma analizi yapmaz. Yeni, numarası taklit edilmiş veya henüz bildirilmemiş çağrılar mevcut listede bulunmayabilir. Ekrandaki etiket tek başına arayanın kesin kimlik doğrulaması değildir; hassas talepleri kurumun resmî kanalından ayrıca doğrulayın. Kurulum ve sorun giderme için <a href="<?php echo esc_url( $how_to_use_url ); ?>">adım adım kullanım rehberini</a>, bütün özellikler için <a href="<?php echo esc_url( $documentation_url ); ?>">dokümantasyonu</a> kullanın.</p>

				<?php else : ?>

					<p>Kalkan uses Apple's Call Directory and Communication Reporting features. It does not listen to call audio or query a server in real time during a call; iOS performs the match on-device using protection data loaded in advance.</p>

					<h2>1. Data is prepared and downloaded</h2>
					<p>Kalkan prepares reviewed unwanted-call records and institutional caller-ID records for separate purposes. When the user taps Update, the relevant protection data is downloaded over a secure connection. The app displays the data date so users can see when protection was last refreshed.</p>

					<h2>2. System integration</h2>
					<p>The downloaded records are added to iPhone's Call Blocking &amp; Identification system through Kalkan extensions. The user enables those extensions once in iOS Settings. Kalkan cannot silently change this system setting on the user's behalf.</p>

					<h2>3. Call check</h2>
					<p>When a call arrives, iOS compares the caller number with the records stored on the device. A number on the blocking list can be blocked at system level; a number on the caller-ID list can display a neutral institution label. The same record is not treated as both safe and blocked.</p>
					<ul>
						<li>It is blocked, or</li>
						<li>It is identified</li>
					</ul>

					<h2>4. User reports enter review</h2>
					<p>Users can report suspicious, advertising, automated or misleading calls through the iPhone Communication Reporting flow. A report is not published directly to the blocking list; it is reviewed against its category, existing records, accessible public signals and possible institutional matches.</p>
					<ul>
						<li>Investigate repeated advertising, robocall and impersonation signals</li>
						<li>Create a review trail for correcting stale or inaccurate records</li>
					</ul>

					<h2>5. Protection is kept current</h2>
					<p>New reviewed records reach the device through the in-app update action. Update reminders run locally on the device. A successful update does not guarantee that every new or spoofed caller will be blocked; it only increases coverage of known records.</p>

					<h2>Privacy boundary</h2>
					<p>Kalkan does not upload your contacts, personal call history or call content for protection matching. The iOS extension uses preloaded number data within Apple's constrained execution model. Read the <a href="<?php echo esc_url( $privacy_url ); ?>">Privacy Policy</a> for the full data-handling explanation.</p>

					<h2>Important note</h2>
					<p>Kalkan does not perform real-time conversation analysis. New, spoofed or not-yet-reported callers may not appear in the current list. An on-screen label is not absolute identity verification; verify sensitive requests through the organization's official channel. Use the <a href="<?php echo esc_url( $how_to_use_url ); ?>">step-by-step setup guide</a> for installation help and the <a href="<?php echo esc_url( $documentation_url ); ?>">documentation</a> for the complete feature reference.</p>

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
