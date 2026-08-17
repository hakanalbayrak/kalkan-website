<?php
/**
 * Template Name: Kalkan Ürün Dokümantasyonu
 * Template Post Type: page
 *
 * Human-readable and machine-readable product documentation.
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
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
<?php wp_head(); ?><?php echo $_kk_seo_tags(); ?><?php include get_stylesheet_directory() . '/inc/kalkan-styles.php'; ?>
<style>
.kk-doc-grid{display:grid;gap:1rem;grid-template-columns:repeat(2,minmax(0,1fr));margin:1.2rem 0 2.2rem}.kk-doc-card{padding:1.25rem}.kk-doc-card p{margin-top:.55rem;color:var(--kk-text-dim)}.kk-doc-card ul{margin:.7rem 0 0 1.15rem;color:var(--kk-text-dim)}.kk-doc-card li+li{margin-top:.35rem}.kk-doc-table{width:100%;border-collapse:collapse;margin:1rem 0 2rem}.kk-doc-table th,.kk-doc-table td{text-align:left;vertical-align:top;padding:.8rem;border-bottom:1px solid var(--kk-border)}.kk-doc-table th{color:var(--kk-text-muted)}.kk-doc-faq{padding:1.1rem 0;border-bottom:1px solid var(--kk-border)}.kk-doc-faq h3{margin-bottom:.4rem}.kk-doc-code{font-family:ui-monospace,SFMono-Regular,Menlo,monospace;font-size:.9em;color:var(--kk-green)}@media(max-width:720px){.kk-doc-grid{grid-template-columns:1fr}.kk-doc-table{display:block;overflow-x:auto}}
</style>
</head>
<body <?php body_class(); ?>>
<div class="kk-page">
	<?php include get_stylesheet_directory() . '/inc/kalkan-header.php'; ?>
	<main class="kk-main">
		<div class="kk-page-header"><div class="kk-shell"><span class="kk-eyebrow"><?php echo esc_html( $__( 'Ürün referansı', 'Product reference' ) ); ?></span><h1><?php echo esc_html( $__( 'Kalkan Dokümantasyonu', 'Kalkan Documentation' ) ); ?></h1><p class="kk-lead"><?php echo esc_html( $__( 'Özellikler, çalışma modeli, kurulum, sınırlar, gizlilik ve sık sorulan sorular.', 'Features, operating model, setup, limitations, privacy and frequently asked questions.' ) ); ?></p></div></div>
		<div class="kk-page-content"><div class="kk-shell" style="max-width:62rem;">
		<?php if ( 'tr' === $lang ) : ?>
			<h2>Ürün özeti</h2>
			<p>Kalkan, iPhone için istenmeyen arama engelleme ve arayan kimliği uygulamasıdır. Uygulama, Apple'ın Call Directory altyapısına cihazda kullanılacak engelleme ve tanımlama verileri yükler. Gelen çağrı sırasında karar veren taraf iOS'tur; Kalkan görüşmeyi dinlemez veya gerçek zamanlı ses analizi yapmaz.</p>
			<div class="kk-doc-grid">
				<section class="kk-doc-card kk-glass"><h3>Genel Koruma — ücretsiz</h3><p>Bilinen istenmeyen numaraları engeller ve veri setindeki kurumsal/işletme numaralarını arama ekranında tanımlar.</p><ul><li>Ekstra Koruma'dan bağımsız çalışır.</li><li>İndirildikten sonra temel çağrı eşleştirmesi çevrimdışı çalışır.</li><li>Ana ekrandaki güncelleme işlemiyle veriler yenilenir ve iOS Arama Dizini yeniden yüklenir.</li></ul></section>
				<section class="kk-doc-card kk-glass"><h3>Ekstra Koruma — Premium</h3><p>Tek tek numaraların ötesinde, şüpheli numara desenleri ve genişletilmiş aralıklar için isteğe bağlı koruma katmanıdır.</p><ul><li>Yalnızca Ekstra Koruma Premium ile sınırlıdır.</li><li>Genel Koruma, abonelik olmadan kullanılmaya devam eder.</li><li>Yıllık ürün Türkiye'de sunulur; uygun yeni aboneliklerde üç aylık deneme App Store tarafından gösterilir.</li></ul></section>
				<section class="kk-doc-card kk-glass"><h3>Arayan kimliği</h3><p>Numara tanımlama veri setinde bir eşleşme olduğunda, iOS gelen arama ekranında Kalkan etiketini gösterir.</p><ul><li>Bir etiket kimlik doğrulaması veya numaranın taklit edilemeyeceği garantisi değildir.</li><li>Engellenen numaralar tanımlama listesinden çıkarılır; engelleme önceliklidir.</li></ul></section>
				<section class="kk-doc-card kk-glass"><h3>Şüpheli numara bildirimi</h3><p>Uygulama içindeki form ile spam, dolandırıcılık veya inceleme gerektiren numaralar bildirilebilir. iOS Telefon uygulamasındaki sistem bildirim uzantısı da önceden tanımlı kategorileri Apple'ın sistem akışıyla iletir.</p><ul><li>Bildirilen numaralar doğrudan engelleme listesine girmez; inceleme sürecinden geçer.</li><li>İletişim Bildirimi, Apple'ın sistem Tamam/onay adımı tamamlandığında iletilir.</li></ul></section>
				<section class="kk-doc-card kk-glass"><h3>Duyurular ve güncellemeler</h3><p>Genel içerikler ve sürüm/güncelleme notları uygulama içinden okunabilir. Akış önbellek ve cihaz içi varsayılan içerikle çalışır; ağ hatası korumayı durdurmaz.</p></section>
				<section class="kk-doc-card kk-glass"><h3>Güncelleme hatırlatıcıları</h3><p>Başarılı bir manuel koruma verisi güncellemesinden sonra 1, 3, 6 veya 12 aylık yerel hatırlatıcı seçilebilir. Bu özellik uygulamanın App Store sürümünü otomatik güncellemez.</p></section>
				<section class="kk-doc-card kk-glass"><h3>Odak Kurulum Yardımcısı</h3><p>İş, Hafta Sonu ve Proje senaryoları için Apple Odak ayarlarını adım adım anlatır. Kalkan kişilerinizi veya Odak yapılandırmanızı okuyamaz ve kendisi değiştiremez.</p></section>
				<section class="kk-doc-card kk-glass"><h3>Ayarlar ve destek</h3><p>Koruma durumunu kontrol etme, Premium satın alma/geri yükleme/yönetme, hatırlatıcı ayarlama, izin verilen numara talebi, numara kaldırma talebi ve destek formları sunulur.</p></section>
			</div>
			<h2>Teknik çalışma akışı</h2>
			<table class="kk-doc-table"><thead><tr><th>Aşama</th><th>Davranış</th></tr></thead><tbody><tr><td>1. İndirme</td><td>Genel tanımlama ve kesin engelleme verileri güvenli HTTPS kaynaklarından indirilir. Ekstra veri yalnızca erişim varsa hazırlanır.</td></tr><tr><td>2. Derleme</td><td>Veriler doğrulanır, normalize edilir, tekrarlardan arındırılır ve uygulama ile uzantının paylaştığı cihaz içi alana yazılır.</td></tr><tr><td>3. Birleştirme</td><td>Genel tanımlama + Genel engelleme + erişim varsa Ekstra engelleme tek, sıralı Call Directory çıktısında birleştirilir. Engelleme, tanımlamaya göre önceliklidir.</td></tr><tr><td>4. iOS yükleme</td><td>Kalkan, Call Directory Extension'ın yeniden yüklenmesini ister. Gelen çağrı eşleştirmesini iOS yapar.</td></tr><tr><td>5. Güncelleme</td><td>Pasif güncellemeler yalnızca anlamlı veri değiştiğinde ağır yeniden yükleme yapar. Kullanıcının manuel Güncelle işlemi önbellekteki kullanılabilir verilerle de yeniden uygulama yapabilir.</td></tr></tbody></table>
			<h2>Kurulum</h2><ol><li>Kalkan'ı App Store'dan indirin.</li><li>Uygulamayı açıp Genel Koruma verilerini hazırlayın.</li><li><strong>Ayarlar → Uygulamalar → Telefon → Arama Engelleme ve Kimlik Belirleme</strong> bölümünde Kalkan'ı etkinleştirin.</li><li>Kalkan'a dönün ve koruma durumunun aktif olduğunu doğrulayın.</li><li>İsterseniz iOS Telefon ayarlarında SMS/Arama Bildirimi bölümünden Kalkan bildirim uzantısını etkinleştirin.</li></ol>
			<h2 style="margin-top:2rem">Gizlilik ve sınırlar</h2><ul><li>Kalkan rehberinize ve arama geçmişinize erişmez.</li><li>Çağrı sesi veya konuşma içeriği analiz edilmez.</li><li>Koruma, önceden yüklenen numara verisine dayanır; her bilinmeyen veya yeni spam numarasını yakalama garantisi yoktur.</li><li>Bir kurum etiketi, çağrının gerçek kaynağını kriptografik olarak doğrulamaz; numara sahteciliği mümkündür.</li><li>İnternet, yeni veriyi indirmek, bildirim göndermek, duyuru almak ve StoreKit durumunu yenilemek için gerekir; yüklenmiş temel Call Directory koruması çevrimdışı çalışabilir.</li></ul>
			<h2 style="margin-top:2rem">Sık sorulan sorular</h2>
			<div class="kk-doc-faq"><h3>Kalkan ücretsiz mi?</h3><p>Genel Koruma, temel arayan kimliği, Genel güncellemeler, bildirim akışları ve ayarlar ücretsizdir. Yalnızca Ekstra Koruma, Kalkan Premium veya daha önce kazanılmış geçerli erişim gerektirir.</p></div>
			<div class="kk-doc-faq"><h3>Kalkan bütün istenmeyen aramaları engeller mi?</h3><p>Hayır. iOS yalnızca yüklenmiş veri setindeki eşleşmeleri engeller veya tanımlar. Yeni ya da listede olmayan numaralar geçebilir.</p></div>
			<div class="kk-doc-faq"><h3>Uygulama arka planda sürekli çalışır mı?</h3><p>Hayır. Sürekli çalışan bir arama motoru değildir. Kalkan veriyi hazırlar; gelen çağrıda eşleştirmeyi iOS yapar.</p></div>
			<div class="kk-doc-faq"><h3>Genel ve Ekstra Koruma arasındaki fark nedir?</h3><p>Genel Koruma kesin numara engelleme ve tanımlama listeleridir. Ekstra Koruma, şüpheli numara desenlerinden genişletilen ek engelleme katmanıdır.</p></div>
			<div class="kk-doc-faq"><h3>Veriyi ne zaman güncellemeliyim?</h3><p>Ana ekrandaki Güncelle işlemini düzenli kullanın. İsterseniz son başarılı güncellemeden itibaren 1, 3, 6 veya 12 aylık yerel hatırlatıcı kurun.</p></div>
			<div class="kk-doc-faq"><h3>Numara bildirince hemen engellenir mi?</h3><p>Hayır. Bildirimler veri kalitesini korumak için incelenir; onay ve veri seti yayını ayrı süreçlerdir.</p></div>
		<?php else : ?>
			<h2>Product summary</h2><p>Kalkan is an unwanted-call blocking and caller identification app for iPhone. It loads blocking and identification data into Apple's Call Directory framework. iOS makes the match during an incoming call; Kalkan does not listen to calls or perform real-time audio analysis.</p>
			<div class="kk-doc-grid">
			<section class="kk-doc-card kk-glass"><h3>General Protection — free</h3><p>Blocks known unwanted numbers and identifies institutional/business numbers present in the dataset.</p><ul><li>Works independently from Extra Protection.</li><li>Core matching works offline after data is loaded.</li><li>The Home update action refreshes data and reloads iOS Call Directory.</li></ul></section>
			<section class="kk-doc-card kk-glass"><h3>Extra Protection — Premium</h3><p>Optional protection for suspicious number patterns and expanded ranges beyond individual exact numbers.</p><ul><li>Only Extra Protection is Premium-gated.</li><li>General Protection remains available without a subscription.</li><li>The annual product is offered in Türkiye; eligible new subscriptions may see a three-month App Store trial.</li></ul></section>
			<section class="kk-doc-card kk-glass"><h3>Caller identification</h3><p>When the identification dataset contains a match, iOS displays Kalkan's label on the incoming-call screen.</p><ul><li>A label is not identity authentication or proof against caller-ID spoofing.</li><li>Blocking takes precedence over identification for overlapping numbers.</li></ul></section>
			<section class="kk-doc-card kk-glass"><h3>Suspicious-number reporting</h3><p>The in-app form accepts spam, fraud and investigation reports. The iOS Phone reporting extension also prepares preset categories for Apple's system-managed delivery.</p><ul><li>Reports are reviewed; they do not enter the blocking dataset automatically.</li><li>System reporting completes only after the user taps Apple's Done/checkmark control.</li></ul></section>
			<section class="kk-doc-card kk-glass"><h3>Announcements and updates</h3><p>General content and release notes are available in the app. Cached and bundled fallbacks keep the section useful when the remote feed is unavailable.</p></section>
			<section class="kk-doc-card kk-glass"><h3>Update reminders</h3><p>After a successful manual protection-data update, users can schedule a local reminder for 1, 3, 6 or 12 months. This does not update the App Store binary.</p></section>
			<section class="kk-doc-card kk-glass"><h3>Focus Setup Assistant</h3><p>Explains Apple Focus setup for Work, Weekend and Project scenarios. Kalkan cannot read or modify contacts or the user's Focus configuration.</p></section>
			<section class="kk-doc-card kk-glass"><h3>Settings and support</h3><p>Includes protection status, Premium purchase/restore/manage, reminders, allowlist and removal requests, and support forms.</p></section></div>
			<h2>Technical flow</h2><table class="kk-doc-table"><thead><tr><th>Stage</th><th>Behavior</th></tr></thead><tbody><tr><td>1. Download</td><td>General exact-identification and exact-blocking data are downloaded over HTTPS. Extra data is prepared only when access exists.</td></tr><tr><td>2. Compile</td><td>Rows are validated, normalized, deduplicated and written to on-device shared storage.</td></tr><tr><td>3. Merge</td><td>General identification + General blocking + optional Extra blocking become one ordered Call Directory payload. Blocking has precedence.</td></tr><tr><td>4. iOS load</td><td>Kalkan requests a Call Directory Extension reload. iOS performs incoming-call matching.</td></tr><tr><td>5. Refresh</td><td>Passive refresh is change-gated. A manual Home refresh can reapply usable cached artifacts and request a reload.</td></tr></tbody></table>
			<h2>Setup</h2><ol><li>Install Kalkan from the App Store.</li><li>Open the app and prepare General Protection data.</li><li>Enable Kalkan in <strong>Settings → Apps → Phone → Call Blocking &amp; Identification</strong>.</li><li>Return to Kalkan and confirm that protection is active.</li><li>Optionally enable Kalkan under SMS/Call Reporting in iOS Phone settings.</li></ol>
			<h2 style="margin-top:2rem">Privacy and limitations</h2><ul><li>Kalkan does not access contacts or call history.</li><li>Call audio and conversation content are not analyzed.</li><li>Protection depends on preloaded data and cannot guarantee detection of every new or unknown number.</li><li>An institutional label does not cryptographically authenticate the caller; caller-ID spoofing remains possible.</li><li>Internet is needed to download fresh data, submit reports, load announcements and refresh StoreKit state; already-loaded core Call Directory protection can work offline.</li></ul>
			<h2 style="margin-top:2rem">Frequently asked questions</h2>
			<div class="kk-doc-faq"><h3>Is Kalkan free?</h3><p>General Protection, basic caller identification, General updates, announcements and settings are free. Only Extra Protection requires Kalkan Premium or valid grandfathered access.</p></div>
			<div class="kk-doc-faq"><h3>Does Kalkan block every unwanted call?</h3><p>No. iOS can only block or identify matches in the loaded dataset. New or unlisted numbers may pass through.</p></div>
			<div class="kk-doc-faq"><h3>Does the app run continuously in the background?</h3><p>No. Kalkan prepares data; iOS performs the match when a call arrives.</p></div>
			<div class="kk-doc-faq"><h3>What is the difference between General and Extra Protection?</h3><p>General Protection contains exact-number blocking and identification lists. Extra Protection adds blocking expanded from suspicious number patterns.</p></div>
			<div class="kk-doc-faq"><h3>When should I update protection data?</h3><p>Use the Home update action regularly. You can schedule a local 1, 3, 6 or 12-month reminder from the last successful update.</p></div>
			<div class="kk-doc-faq"><h3>Is a reported number blocked immediately?</h3><p>No. Reports are reviewed; approval and dataset publication are separate processes.</p></div>
		<?php endif; ?>
			<p style="margin-top:2rem"><a class="kk-btn kk-btn-ghost" href="<?php echo $version_history_url; ?>"><?php echo esc_html( $__( 'Sürüm geçmişini görüntüleyin', 'View version history' ) ); ?></a></p>
		</div></div>
	</main>
	<?php include get_stylesheet_directory() . '/inc/kalkan-footer.php'; ?>
</div>
<?php include get_stylesheet_directory() . '/inc/kalkan-scripts.php'; ?><?php wp_footer(); ?>
</body></html>
