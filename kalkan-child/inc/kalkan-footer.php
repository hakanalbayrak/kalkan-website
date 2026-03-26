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
			<div class="kk-footer__social">
				<a href="https://x.com/Kalkan_App" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)" class="kk-social-link">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
				</a>
				<a href="<?php echo esc_url( $appstore_link ); ?>" target="_blank" rel="noopener noreferrer" aria-label="App Store" class="kk-social-link">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
				</a>
			</div>
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
