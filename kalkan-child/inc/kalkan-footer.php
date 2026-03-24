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
			<a href="<?php echo $what_is_url; ?>"><?php echo esc_html( $__( 'Kalkan Nedir?', 'What is Kalkan?' ) ); ?></a>
			<a href="<?php echo $how_works_url; ?>"><?php echo esc_html( $__( 'Nasıl Çalışır?', 'How It Works?' ) ); ?></a>
			<a href="<?php echo $how_to_use_url; ?>"><?php echo esc_html( $__( 'Nasıl Kullanılır?', 'How to Use?' ) ); ?></a>
			<a href="<?php echo $privacy_url; ?>"><?php echo esc_html( $__( 'Gizlilik Politikası', 'Privacy Policy' ) ); ?></a>
			<a href="<?php echo $kvkk_url; ?>"><?php echo esc_html( $__( 'KVKK Aydınlatma', 'Legal Notice' ) ); ?></a>
			<a href="<?php echo $blog_url; ?>">Blog</a>
			<a href="<?php echo $contact_url; ?>"><?php echo esc_html( $__( 'İletişim', 'Contact' ) ); ?></a>
		</nav>

		<div class="kk-footer__meta">
			<div class="kk-lang" aria-label="<?php echo esc_attr( $__( 'Dil seçimi', 'Language switcher' ) ); ?>">
				<?php if ( function_exists( 'pll_the_languages' ) ) :
					$pll_langs_f = pll_the_languages( array( 'raw' => 1, 'hide_if_no_translation' => 0 ) );
					if ( $pll_langs_f ) :
						foreach ( $pll_langs_f as $pll_lang_f ) :
							if ( $pll_lang_f['current_lang'] ) : ?>
								<span class="kk-lang--active"><?php echo strtoupper( esc_html( $pll_lang_f['slug'] ) ); ?></span>
							<?php else : ?>
								<a href="<?php echo esc_url( $pll_lang_f['url'] ); ?>" hreflang="<?php echo esc_attr( $pll_lang_f['slug'] ); ?>"><?php echo strtoupper( esc_html( $pll_lang_f['slug'] ) ); ?></a>
							<?php endif;
						endforeach;
					endif;
				else : ?>
					<span class="kk-lang--active">TR</span>
					<a href="/en/">EN</a>
				<?php endif; ?>
			</div>
			<p class="kk-footer__copy">
				&copy; <?php echo esc_html( (string) gmdate( 'Y' ) ); ?> Kalkan.
				<?php echo esc_html( $__( 'Tüm hakları saklıdır.', 'All rights reserved.' ) ); ?>
			</p>
		</div>

	</div>
</footer>
