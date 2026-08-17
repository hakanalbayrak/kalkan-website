<?php
/**
 * Template Name: Kalkan Sürüm Geçmişi
 * Template Post Type: page
 *
 * Verified App Store release history for Kalkan.
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
<style>
.kk-release-list{display:grid;gap:1rem}.kk-release{padding:1.35rem}.kk-release__top{display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:.8rem}.kk-release__version{font-size:1.3rem}.kk-release__date{color:var(--kk-text-muted);font-size:.9rem;white-space:nowrap}.kk-release__status{display:inline-flex;padding:.24rem .65rem;border:1px solid var(--kk-border);border-radius:999px;color:var(--kk-green);font-size:.76rem;font-weight:700;margin-top:.45rem}.kk-release ul{margin:.75rem 0 0 1.2rem;color:var(--kk-text-dim)}.kk-release li+li{margin-top:.4rem}.kk-release-note{margin:0 0 2rem;padding:1rem 1.1rem;border-left:3px solid var(--kk-purple);background:rgba(139,92,246,.08);border-radius:.5rem;color:var(--kk-text-dim)}@media(max-width:620px){.kk-release__top{display:block}.kk-release__date{display:block;margin-top:.4rem}}
</style>
</head>
<body <?php body_class(); ?>>
<div class="kk-page">
	<?php include get_stylesheet_directory() . '/inc/kalkan-header.php'; ?>
	<main class="kk-main">
		<div class="kk-page-header"><div class="kk-shell">
			<span class="kk-eyebrow"><?php echo esc_html( $__( 'Ürün değişiklikleri', 'Product changes' ) ); ?></span>
			<h1><?php echo esc_html( $__( 'Kalkan Sürüm Geçmişi', 'Kalkan Version History' ) ); ?></h1>
			<p class="kk-lead"><?php echo esc_html( $__( 'Her iOS sürümünde eklenen özellikler ve yapılan önemli iyileştirmeler.', 'Features and important improvements included in each iOS release.' ) ); ?></p>
		</div></div>
		<div class="kk-page-content"><div class="kk-shell" style="max-width:56rem;">
			<p class="kk-release-note"><?php echo esc_html( $__( 'Tarihler App Store kayıtlarına göre verilmiştir. İncelemedeki sürümler, Apple onaylayana kadar kullanıcılara açık değildir.', 'Dates are based on App Store records. Versions under review are not available to users until Apple approves them.' ) ); ?></p>
			<div class="kk-release-list">
				<article class="kk-release kk-glass">
					<div class="kk-release__top"><div><h2 class="kk-release__version">1.0.6 (110)</h2><span class="kk-release__status"><?php echo esc_html( $__( 'Apple incelemesinde', 'In Apple review' ) ); ?></span></div><time class="kk-release__date" datetime="2026-08-17"><?php echo esc_html( $__( '17 Ağustos 2026', '17 August 2026' ) ); ?></time></div>
					<p><?php echo esc_html( $__( 'App Store sunumu ve koruma açıklamaları daha anlaşılır hale getirildi.', 'The App Store presentation and protection descriptions were made clearer.' ) ); ?></p>
					<ul><li><?php echo esc_html( $__( 'Türkçe ve İngilizce App Store görselleri yenilendi.', 'Turkish and English App Store visuals were refreshed.' ) ); ?></li><li><?php echo esc_html( $__( 'Genel ve Ekstra Koruma ayrımı daha açık anlatıldı.', 'The distinction between General and Extra Protection was clarified.' ) ); ?></li><li><?php echo esc_html( $__( 'Küçük kararlılık iyileştirmeleri yapıldı.', 'Minor stability improvements were included.' ) ); ?></li></ul>
				</article>
				<article class="kk-release kk-glass">
					<div class="kk-release__top"><div><h2 class="kk-release__version">1.0.5 (109)</h2><span class="kk-release__status"><?php echo esc_html( $__( 'Yayında', 'Released' ) ); ?></span></div><time class="kk-release__date" datetime="2026-07-27"><?php echo esc_html( $__( '27 Temmuz 2026', '27 July 2026' ) ); ?></time></div>
					<ul><li><?php echo esc_html( $__( 'Uygulama içine Genel ve Güncellemeler duyuru akışı eklendi.', 'General and Updates announcement feeds were added inside the app.' ) ); ?></li><li><?php echo esc_html( $__( 'Koruma verisi güncelleme hatırlatıcıları eklendi: 1, 3, 6 veya 12 ay.', 'Protection-data update reminders were added: 1, 3, 6 or 12 months.' ) ); ?></li><li><?php echo esc_html( $__( 'İş, Hafta Sonu ve Proje senaryoları için Odak Kurulum Yardımcısı eklendi.', 'A Focus Setup Assistant was added for Work, Weekend and Project scenarios.' ) ); ?></li><li><?php echo esc_html( $__( 'Açık/koyu tema kontrastı ve düğme okunabilirliği geliştirildi.', 'Light/Dark Mode contrast and button readability were improved.' ) ); ?></li></ul>
				</article>
				<article class="kk-release kk-glass">
					<div class="kk-release__top"><div><h2 class="kk-release__version">1.0.4 (108)</h2></div><time class="kk-release__date" datetime="2026-07"><?php echo esc_html( $__( 'Temmuz 2026', 'July 2026' ) ); ?></time></div>
					<ul><li><?php echo esc_html( $__( 'Ekstra Koruma için Kalkan Premium yıllık abonelik desteği eklendi.', 'Annual Kalkan Premium subscription support was added for Extra Protection.' ) ); ?></li><li><?php echo esc_html( $__( 'Genel Koruma ücretsiz ve bağımsız kalmaya devam etti.', 'General Protection remained free and independent.' ) ); ?></li><li><?php echo esc_html( $__( 'Satın alma, geri yükleme ve abonelik yönetimi StoreKit 2 ile uygulandı.', 'Purchase, restore and subscription management were implemented with StoreKit 2.' ) ); ?></li><li><?php echo esc_html( $__( 'Kararlılık iyileştirmeleri yapıldı.', 'Reliability improvements were included.' ) ); ?></li></ul>
				</article>
				<article class="kk-release kk-glass">
					<div class="kk-release__top"><div><h2 class="kk-release__version">1.0.3</h2></div><time class="kk-release__date" datetime="2026-04"><?php echo esc_html( $__( 'Nisan 2026', 'April 2026' ) ); ?></time></div>
					<ul><li><?php echo esc_html( $__( 'Şüpheli numara bildirme akışı geliştirildi.', 'The suspicious-number reporting experience was improved.' ) ); ?></li><li><?php echo esc_html( $__( 'Koruma durumları ve güncelleme geri bildirimi daha anlaşılır hale getirildi.', 'Protection states and update feedback were made clearer.' ) ); ?></li><li><?php echo esc_html( $__( 'Açık/koyu görünüm, performans ve genel kararlılık iyileştirildi.', 'Light/Dark appearance, performance and general reliability were improved.' ) ); ?></li></ul>
				</article>
				<article class="kk-release kk-glass">
					<div class="kk-release__top"><div><h2 class="kk-release__version">1.0.2</h2></div><time class="kk-release__date" datetime="2026-03"><?php echo esc_html( $__( 'Mart 2026', 'March 2026' ) ); ?></time></div>
					<ul><li><?php echo esc_html( $__( 'Ekstra Koruma ve spam koruması daha güvenilir hale getirildi.', 'Extra Protection and spam protection reliability were improved.' ) ); ?></li><li><?php echo esc_html( $__( 'Kurulum, yeniden etkinleştirme, güncelleme kontrolü ve çevrimdışı güvenlik geliştirildi.', 'Setup, reactivation, update checks and offline protection were improved.' ) ); ?></li><li><?php echo esc_html( $__( 'Hata düzeltmeleri ve performans iyileştirmeleri yapıldı.', 'Bug fixes and performance improvements were included.' ) ); ?></li></ul>
				</article>
				<article class="kk-release kk-glass">
					<div class="kk-release__top"><div><h2 class="kk-release__version">1.0.1</h2><span class="kk-release__status"><?php echo esc_html( $__( 'İlk genel sürüm', 'Initial public release' ) ); ?></span></div><time class="kk-release__date" datetime="2026-03-09"><?php echo esc_html( $__( '9 Mart 2026', '9 March 2026' ) ); ?></time></div>
					<ul><li><?php echo esc_html( $__( 'iOS Call Directory tabanlı Genel Koruma ve arayan kimliği sunuldu.', 'General Protection and caller identification based on iOS Call Directory were introduced.' ) ); ?></li><li><?php echo esc_html( $__( 'Bilinen spam numaralarını engelleme, kurumsal numaraları tanıma ve şüpheli numara bildirme özellikleri sunuldu.', 'Known-spam blocking, institutional caller identification and suspicious-number reporting were introduced.' ) ); ?></li><li><?php echo esc_html( $__( 'Kişiler listesine erişmeden cihaz içi koruma sağlandı.', 'On-device protection was provided without accessing contacts.' ) ); ?></li></ul>
				</article>
			</div>
			<p style="margin-top:2rem"><a class="kk-btn kk-btn-primary" href="<?php echo $documentation_url; ?>"><?php echo esc_html( $__( 'Tüm özellikleri inceleyin', 'Read the full documentation' ) ); ?></a></p>
		</div></div>
	</main>
	<?php include get_stylesheet_directory() . '/inc/kalkan-footer.php'; ?>
</div>
<?php include get_stylesheet_directory() . '/inc/kalkan-scripts.php'; ?>
<?php wp_footer(); ?>
</body>
</html>
