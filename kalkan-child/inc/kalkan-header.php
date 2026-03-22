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
$anchor_prefix = $is_front_page ? '' : esc_url( home_url( '/' ) );
$lang_suffix   = ( 'en' === $lang ) ? '?lang=en' : '';
?>
<!-- ── HEADER ──────────────────────────────────────────────────────────── -->
<header class="kk-header" id="kk-header">
	<div class="kk-shell kk-header__inner">

		<a class="kk-brand" href="<?php echo $home_url; ?>" aria-label="Kalkan">
			<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png' ); ?>" alt="Kalkan" class="kk-brand__icon" width="40" height="40">
			<span class="kk-brand__name">Kalkan</span>
		</a>

		<nav class="kk-nav" aria-label="<?php echo esc_attr( $__( 'Ana menü', 'Main menu' ) ); ?>">
			<ul>
				<li><a href="<?php echo $anchor_prefix . $lang_suffix; ?>#kk-features"><?php echo esc_html( $__( 'Özellikler', 'Features' ) ); ?></a></li>
				<li><a href="<?php echo $anchor_prefix . $lang_suffix; ?>#kk-how"><?php echo esc_html( $__( 'Nasıl Çalışır', 'How It Works' ) ); ?></a></li>
				<li><a href="<?php echo $anchor_prefix . $lang_suffix; ?>#kk-faq"><?php echo esc_html( $__( 'SSS', 'FAQ' ) ); ?></a></li>
				<li><a href="<?php echo $blog_url; ?>">Blog</a></li>
				<li><a href="<?php echo $contact_url; ?>"><?php echo esc_html( $__( 'İletişim', 'Contact' ) ); ?></a></li>
			</ul>
		</nav>

		<div class="kk-header__right">
			<div class="kk-lang" aria-label="<?php echo esc_attr( $__( 'Dil seçimi', 'Language switcher' ) ); ?>">
				<?php if ( 'tr' === $lang ) : ?>
					<span class="kk-lang--active">TR</span>
					<a href="<?php echo $lang_en_url; ?>">EN</a>
				<?php else : ?>
					<a href="<?php echo $lang_tr_url; ?>">TR</a>
					<span class="kk-lang--active">EN</span>
				<?php endif; ?>
			</div>

			<a class="kk-header-appstore" href="<?php echo esc_url( $appstore_link ); ?>" aria-label="App Store">
				<img src="<?php echo esc_url( $badge_url ); ?>" alt="App Store" loading="eager">
			</a>

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
			<li><a href="<?php echo $anchor_prefix . $lang_suffix; ?>#kk-features"><?php echo esc_html( $__( 'Özellikler', 'Features' ) ); ?></a></li>
			<li><a href="<?php echo $anchor_prefix . $lang_suffix; ?>#kk-how"><?php echo esc_html( $__( 'Nasıl Çalışır', 'How It Works' ) ); ?></a></li>
			<li><a href="<?php echo $anchor_prefix . $lang_suffix; ?>#kk-faq"><?php echo esc_html( $__( 'SSS', 'FAQ' ) ); ?></a></li>
			<li><a href="<?php echo $blog_url; ?>">Blog</a></li>
			<li><a href="<?php echo $contact_url; ?>"><?php echo esc_html( $__( 'İletişim', 'Contact' ) ); ?></a></li>
			<li><a href="<?php echo esc_url( $appstore_link ); ?>"><?php echo esc_html( $__( 'App Store\'dan İndir', 'Download on App Store' ) ); ?></a></li>
		</ul>
		<div class="kk-lang" style="margin-top:1rem;">
			<?php if ( 'tr' === $lang ) : ?>
				<span class="kk-lang--active">TR</span>
				<a href="<?php echo $lang_en_url; ?>">EN</a>
			<?php else : ?>
				<a href="<?php echo $lang_tr_url; ?>">TR</a>
				<span class="kk-lang--active">EN</span>
			<?php endif; ?>
		</div>
	</nav>
</header>
