<?php
/**
 * Shared header component.
 *
 * Requires variables from inc/kalkan-setup.php.
 * Optional: $is_front_page (bool) — when true, section anchors are relative (#kk-features).
 *
 * @package kalkan-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$is_front_page = isset( $is_front_page ) ? (bool) $is_front_page : false;
$anchor_prefix = $is_front_page ? '' : $home_url;
$brand_icon_src = isset( $brand_icon_src ) ? $brand_icon_src : get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon-80-optimized.webp';
?>
<!-- ── HEADER ──────────────────────────────────────────────────────────── -->
<header class="kk-header" id="kk-header">
	<div class="kk-shell kk-header__inner">

		<a class="kk-brand" href="<?php echo $home_url; ?>" aria-label="Kalkan">
			<img src="<?php echo esc_attr( $brand_icon_src ); ?>" alt="" class="kk-brand__icon skip-lazy" width="40" height="40" loading="eager" decoding="async" fetchpriority="high" data-no-lazy="1">
			<span class="kk-brand__name">Kalkan</span>
		</a>

		<nav class="kk-nav" aria-label="<?php echo esc_attr( $__( 'Ana menü', 'Main menu' ) ); ?>">
			<ul>
				<li><a href="<?php echo $what_is_url; ?>"><?php echo esc_html( $__( 'Kalkan Nedir?', 'What is Kalkan?' ) ); ?></a></li>
				<li><a href="<?php echo $how_works_url; ?>"><?php echo esc_html( $__( 'Nasıl Çalışır?', 'How It Works?' ) ); ?></a></li>
				<li><a href="<?php echo $how_to_use_url; ?>"><?php echo esc_html( $__( 'Nasıl Kullanılır?', 'How to Use?' ) ); ?></a></li>
				<li><a href="<?php echo $documentation_url; ?>"><?php echo esc_html( $__( 'Dokümanlar', 'Documentation' ) ); ?></a></li>
				<li><a href="<?php echo $blog_url; ?>">Blog</a></li>
				<li><a href="<?php echo $contact_url; ?>"><?php echo esc_html( $__( 'İletişim', 'Contact' ) ); ?></a></li>
			</ul>
		</nav>

		<div class="kk-header__right">
			<div class="kk-header-stores" aria-label="<?php echo esc_attr( $__( 'Uygulamayı indir', 'Download the app' ) ); ?>">
				<a href="<?php echo esc_url( $appstore_link ); ?>" aria-label="App Store">
					<img src="<?php echo esc_url( $badge_url ); ?>" alt="App Store" loading="eager" decoding="async" width="151" height="40">
				</a>
				<a href="<?php echo esc_url( $playstore_link ); ?>" aria-label="Google Play">
					<img class="kk-googleplay-badge" src="<?php echo esc_url( $play_badge_url ); ?>" alt="Google Play" loading="eager" decoding="async" width="646" height="250">
				</a>
			</div>

			<div class="kk-lang" aria-label="<?php echo esc_attr( $__( 'Dil seçimi', 'Language switcher' ) ); ?>">
				<?php if ( function_exists( 'pll_the_languages' ) ) :
					$pll_langs = pll_the_languages( array( 'raw' => 1, 'hide_if_no_translation' => 0 ) );
					if ( $pll_langs ) :
						foreach ( $pll_langs as $pll_lang ) :
							if ( $pll_lang['current_lang'] ) : ?>
								<span class="kk-lang--active"><?php echo strtoupper( esc_html( $pll_lang['slug'] ) ); ?></span>
							<?php else : ?>
								<a href="<?php echo esc_url( $pll_lang['url'] ); ?>" hreflang="<?php echo esc_attr( $pll_lang['slug'] ); ?>"><?php echo strtoupper( esc_html( $pll_lang['slug'] ) ); ?></a>
							<?php endif;
						endforeach;
					endif;
				else : ?>
					<span class="kk-lang--active">TR</span>
					<a href="/en/">EN</a>
				<?php endif; ?>
			</div>

			<button class="kk-menu-toggle" id="kk-menu-toggle" aria-expanded="false" aria-controls="kk-mobile-nav" aria-label="<?php echo esc_attr( $__( 'Menüyü aç', 'Open menu' ) ); ?>">
				<span></span>
				<span></span>
				<span></span>
			</button>
		</div>
	</div>

	<!-- Mobile drawer -->
	<nav class="kk-mobile-nav" id="kk-mobile-nav" aria-label="<?php echo esc_attr( $__( 'Mobil menü', 'Mobile menu' ) ); ?>">
		<ul>
			<li><a href="<?php echo $what_is_url; ?>"><?php echo esc_html( $__( 'Kalkan Nedir?', 'What is Kalkan?' ) ); ?></a></li>
			<li><a href="<?php echo $how_works_url; ?>"><?php echo esc_html( $__( 'Nasıl Çalışır?', 'How It Works?' ) ); ?></a></li>
			<li><a href="<?php echo $how_to_use_url; ?>"><?php echo esc_html( $__( 'Nasıl Kullanılır?', 'How to Use?' ) ); ?></a></li>
			<li><a href="<?php echo $documentation_url; ?>"><?php echo esc_html( $__( 'Dokümanlar', 'Documentation' ) ); ?></a></li>
			<li><a href="<?php echo $version_history_url; ?>"><?php echo esc_html( $__( 'Sürüm Geçmişi', 'Version History' ) ); ?></a></li>
			<li><a href="<?php echo $blog_url; ?>">Blog</a></li>
			<li><a href="<?php echo $contact_url; ?>"><?php echo esc_html( $__( 'İletişim', 'Contact' ) ); ?></a></li>
			<li><a href="<?php echo esc_url( $appstore_link ); ?>"><?php echo esc_html( $__( 'App Store\'dan İndir', 'Download on App Store' ) ); ?></a></li>
			<li><a href="<?php echo esc_url( $playstore_link ); ?>"><?php echo esc_html( $__( 'Google Play\'den İndir', 'Get it on Google Play' ) ); ?></a></li>
		</ul>
		<div class="kk-lang" style="margin-top:1rem;">
			<?php if ( function_exists( 'pll_the_languages' ) ) :
				$pll_langs_m = pll_the_languages( array( 'raw' => 1, 'hide_if_no_translation' => 0 ) );
				if ( $pll_langs_m ) :
					foreach ( $pll_langs_m as $pll_lang_m ) :
						if ( $pll_lang_m['current_lang'] ) : ?>
							<span class="kk-lang--active"><?php echo strtoupper( esc_html( $pll_lang_m['slug'] ) ); ?></span>
						<?php else : ?>
							<a href="<?php echo esc_url( $pll_lang_m['url'] ); ?>" hreflang="<?php echo esc_attr( $pll_lang_m['slug'] ); ?>"><?php echo strtoupper( esc_html( $pll_lang_m['slug'] ) ); ?></a>
						<?php endif;
					endforeach;
				endif;
			else : ?>
				<span class="kk-lang--active">TR</span>
				<a href="/en/">EN</a>
			<?php endif; ?>
		</div>
	</nav>
</header>
