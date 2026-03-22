<?php
/**
 * Shared footer component.
 *
 * Requires variables from inc/kalkan-setup.php.
 *
 * @package kalkan-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- ── FOOTER ────────────────────────────────────────────────────────────── -->
<footer class="kk-footer" aria-label="<?php echo esc_attr( $__( 'Site altı', 'Site footer' ) ); ?>">
	<div class="kk-shell kk-footer__layout">

		<div class="kk-footer__brand">
			<a class="kk-brand" href="<?php echo $home_url; ?>" aria-label="Kalkan">
				<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png' ); ?>" alt="Kalkan" class="kk-brand__icon kk-brand__icon--sm" width="32" height="32">
				<span class="kk-brand__name">Kalkan</span>
			</a>
			<p class="kk-footer__tagline">
				<?php echo esc_html( $__( 'iOS için spam arama engelleyici ve arayan kimlik uygulaması.', 'Spam call blocker and caller ID app for iOS.' ) ); ?>
			</p>
		</div>

		<nav class="kk-footer__nav" aria-label="<?php echo esc_attr( $__( 'Alt bağlantılar', 'Footer links' ) ); ?>">
			<a href="<?php echo $privacy_url; ?>"><?php echo esc_html( $__( 'Gizlilik Politikası', 'Privacy Policy' ) ); ?></a>
			<a href="<?php echo $kvkk_url; ?>"><?php echo esc_html( $__( 'KVKK Aydınlatma', 'Legal Notice' ) ); ?></a>
			<a href="<?php echo $blog_url; ?>">Blog</a>
			<a href="<?php echo $contact_url; ?>"><?php echo esc_html( $__( 'İletişim', 'Contact' ) ); ?></a>
		</nav>

		<div class="kk-footer__meta">
			<div class="kk-lang" aria-label="<?php echo esc_attr( $__( 'Dil seçimi', 'Language switcher' ) ); ?>">
				<?php if ( 'tr' === $lang ) : ?>
					<span class="kk-lang--active">TR</span>
					<a href="<?php echo $lang_en_url; ?>">EN</a>
				<?php else : ?>
					<a href="<?php echo $lang_tr_url; ?>">TR</a>
					<span class="kk-lang--active">EN</span>
				<?php endif; ?>
			</div>
			<p class="kk-footer__copy">
				&copy; <?php echo esc_html( (string) gmdate( 'Y' ) ); ?> Kalkan.
				<?php echo esc_html( $__( 'Tüm hakları saklıdır.', 'All rights reserved.' ) ); ?>
			</p>
		</div>

	</div>
</footer>
