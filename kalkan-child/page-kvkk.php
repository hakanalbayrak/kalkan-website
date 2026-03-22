<?php
/**
 * Template Name: KVKK Aydınlatma Metni
 * Template Post Type: page
 *
 * Bilingual KVKK compliance notice (TR default / EN via ?lang=en).
 *
 * @package kalkan-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ── Language detection ─────────────────────────────────────────────────────── */
$lang = ( isset( $_GET['lang'] ) && 'en' === sanitize_key( $_GET['lang'] ) ) ? 'en' : 'tr'; // phpcs:ignore WordPress.Security.NonceVerification

$__ = static function ( string $tr, string $en ) use ( $lang ) : string {
	return 'en' === $lang ? $en : $tr;
};

$lang_tr_url = esc_url( remove_query_arg( 'lang' ) );
$lang_en_url = esc_url( add_query_arg( 'lang', 'en' ) );
$home_url    = esc_url( home_url( '/' ) );

get_header();
?>

<div class="kk-page">

	<!-- ── MINIMAL HEADER ────────────────────────────────────────────────────── -->
	<header class="kk-header">
		<div class="kk-shell kk-header__inner">
			<a class="kk-brand" href="<?php echo $home_url; ?>" aria-label="Kalkan">
				<span class="kk-brand__mark">K</span>
				<span class="kk-brand__name">Kalkan</span>
			</a>
			<div class="kk-header__right">
				<div class="kk-lang">
					<?php if ( 'tr' === $lang ) : ?>
						<span class="kk-lang--active">TR</span>
						<a href="<?php echo $lang_en_url; ?>">EN</a>
					<?php else : ?>
						<a href="<?php echo $lang_tr_url; ?>">TR</a>
						<span class="kk-lang--active">EN</span>
					<?php endif; ?>
				</div>
				<a class="kk-btn kk-btn-ghost" href="<?php echo $home_url; ?>" style="font-size:0.88rem;padding:0.5rem 0.9rem;">
					← <?php echo esc_html( $__( 'Ana Sayfa', 'Home' ) ); ?>
				</a>
			</div>
		</div>
	</header>

	<main class="kk-main">

		<div class="kk-page-header">
			<div class="kk-shell">
				<span class="kk-eyebrow"><?php echo esc_html( $__( 'Yasal', 'Legal' ) ); ?></span>
				<h1>
					<?php echo esc_html( $__( 'KVKK Aydınlatma Metni', 'KVKK Disclosure Notice' ) ); ?>
				</h1>
				<p class="kk-lead" style="margin-top:0.6rem;">
					<?php echo esc_html( $__( '6698 Sayılı Kişisel Verilerin Korunması Kanunu kapsamında hazırlanmıştır.', 'Prepared in accordance with the Law on Protection of Personal Data No. 6698.' ) ); ?>
				</p>
			</div>
		</div>

		<div class="kk-page-content">
			<div class="kk-shell" style="max-width:52rem;">

				<?php if ( 'tr' === $lang ) : ?>

					<h2>1. Veri Sorumlusu</h2>
					<p>
						Veri sorumlusu: kalkan.website<br>
						İletişim: <a href="mailto:info@kalkan.website">info@kalkan.website</a>
					</p>

					<h2>2. İşlenen Kişisel Veriler</h2>
					<ul>
						<li>E-posta adresi</li>
						<li>İşlem zaman damgası</li>
						<li>IP adresi</li>
					</ul>

					<h2>3. Kişisel Verilerin İşlenme Amaçları</h2>
					<ul>
						<li>Bilgilendirme e-postalarının gönderilmesi</li>
						<li>Abonelik yönetimi</li>
						<li>Güvenlik ve sahteciliğin önlenmesi</li>
					</ul>

					<h2>4. Hukuki Sebep</h2>
					<p>
						Kişisel verileriniz; açık rızanıza dayalı olarak (KVKK m.5/1) ve veri sorumlusunun meşru menfaatinin korunması amacıyla (KVKK m.5/2-f) işlenmektedir.
					</p>

					<h2>5. Verilerin Aktarılması</h2>
					<p>Kişisel verileriniz kural olarak üçüncü taraflarla paylaşılmaz. Yasal zorunluluk halleri saklıdır.</p>

					<h2>6. Verilerin Saklanma Süresi</h2>
					<p>Verileriniz, abonelikten çıkmanız veya silme talebinde bulunmanız halinde silinir.</p>

					<h2>7. Haklarınız</h2>
					<p>KVKK'nın 11. maddesi uyarınca aşağıdaki haklara sahipsiniz:</p>
					<ul>
						<li>Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
						<li>İşlenmişse bilgi talep etme</li>
						<li>İşlenme amacını ve bunların amacına uygun kullanılıp kullanılmadığını öğrenme</li>
						<li>Yurt içinde / yurt dışında aktarıldığı üçüncü kişileri bilme</li>
						<li>Eksik veya yanlış işlenmiş olması hâlinde bunların düzeltilmesini isteme</li>
						<li>Verilerin silinmesini veya yok edilmesini isteme</li>
						<li>İşlenen verilerin münhasıran otomatik sistemler vasıtasıyla analiz edilmesi suretiyle aleyhinize bir sonucun ortaya çıkmasına itiraz etme</li>
						<li>Kanuna aykırı işlenmesi sebebiyle zarara uğraması hâlinde zararın giderilmesini talep etme</li>
					</ul>
					<p>Haklarınızı kullanmak için <a href="mailto:info@kalkan.website">info@kalkan.website</a> adresine başvurabilirsiniz.</p>

					<h2>8. Abonelikten Çıkma</h2>
					<p>Web sitesindeki abonelikten çıkma bağlantısını kullanarak veya <a href="mailto:info@kalkan.website">info@kalkan.website</a> adresine e-posta göndererek aboneliğinizi iptal edebilirsiniz.</p>

				<?php else : ?>

					<h2>1. Data Controller</h2>
					<p>
						Data Controller: kalkan.website<br>
						Contact: <a href="mailto:info@kalkan.website">info@kalkan.website</a>
					</p>

					<h2>2. Personal Data Processed</h2>
					<ul>
						<li>Email address</li>
						<li>Transaction timestamp</li>
						<li>IP address</li>
					</ul>

					<h2>3. Purposes of Processing</h2>
					<ul>
						<li>Sending informational emails</li>
						<li>Subscription management</li>
						<li>Security and fraud prevention</li>
					</ul>

					<h2>4. Legal Basis</h2>
					<p>
						Your personal data is processed based on your explicit consent (KVKK Art. 5/1) and the legitimate interests of the data controller for security purposes (KVKK Art. 5/2-f).
					</p>

					<h2>5. Data Transfers</h2>
					<p>Personal data is generally not shared with third parties. Exceptions apply where required by law.</p>

					<h2>6. Retention Period</h2>
					<p>Your data is deleted upon unsubscription or upon a deletion request.</p>

					<h2>7. Your Rights</h2>
					<p>Under KVKK Article 11, you have the following rights:</p>
					<ul>
						<li>To learn whether your personal data is being processed</li>
						<li>To request information if it is being processed</li>
						<li>To learn the purpose of processing and whether it is being used in accordance with its purpose</li>
						<li>To know the third parties to whom data is transferred domestically or abroad</li>
						<li>To request correction of incomplete or inaccurate data</li>
						<li>To request deletion or destruction of your data</li>
						<li>To object to outcomes arising from automated analysis of your data</li>
						<li>To seek compensation for damages arising from unlawful processing</li>
					</ul>
					<p>To exercise these rights, please contact <a href="mailto:info@kalkan.website">info@kalkan.website</a>.</p>

					<h2>8. Unsubscribe</h2>
					<p>You may cancel your subscription via the unsubscribe link on the website or by emailing <a href="mailto:info@kalkan.website">info@kalkan.website</a>.</p>

				<?php endif; ?>

			</div>
		</div>

	</main>

	<footer class="kk-footer kk-page">
		<div class="kk-shell" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
			<p class="kk-footer__copy">© <?php echo esc_html( (string) gmdate( 'Y' ) ); ?> Kalkan. <?php echo esc_html( $__( 'Tüm hakları saklıdır.', 'All rights reserved.' ) ); ?></p>
			<a href="<?php echo $home_url; ?>" style="color:var(--kk-text-muted);font-size:0.88rem;text-decoration:none;font-weight:600;">
				← <?php echo esc_html( $__( 'Ana Sayfaya Dön', 'Back to Home' ) ); ?>
			</a>
		</div>
	</footer>

</div><!-- /.kk-page -->

<?php get_footer(); ?>
