<?php
/**
 * Shared setup — language, URL helpers, App Store badges.
 *
 * Expected to be included at the top of every self-contained page template.
 * After inclusion the following variables are available:
 *
 * $lang, $__, $lang_tr_url, $lang_en_url,
 * $home_url, $blog_url, $privacy_url, $kvkk_url, $contact_url,
 * $appstore_link, $badge_url
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

/* ── URL helpers ────────────────────────────────────────────────────────────── */
$lang_tr_url = esc_url( remove_query_arg( 'lang' ) );
$lang_en_url = esc_url( add_query_arg( 'lang', 'en' ) );

$_kk_lang_url = static function ( string $url ) use ( $lang ) : string {
	if ( 'en' === $lang ) {
		$url = add_query_arg( 'lang', 'en', $url );
	}
	return esc_url( $url );
};

$home_url    = $_kk_lang_url( home_url( '/' ) );

$blog_page_id = (int) get_option( 'page_for_posts' );
$blog_url     = $_kk_lang_url( $blog_page_id > 0 ? get_permalink( $blog_page_id ) : home_url( '/blog/' ) );

$privacy_url  = $_kk_lang_url( get_privacy_policy_url() ?: home_url( '/privacy-policy/' ) );

$kvkk_page    = get_page_by_path( 'kvkk' );
$kvkk_url     = $_kk_lang_url( $kvkk_page ? get_permalink( $kvkk_page ) : home_url( '/kvkk/' ) );

$contact_page = get_page_by_path( 'contact' );
if ( ! $contact_page ) {
	$contact_page = get_page_by_path( 'iletisim' );
}
$contact_url  = $_kk_lang_url( $contact_page ? get_permalink( $contact_page ) : home_url( '/contact/' ) );

/* ── App Store badges (official Apple hosted) ──────────────────────────────── */
$appstore_link = 'https://apps.apple.com/tr/app/kalkan/id6759873828?itscg=30200&itsct=apps_box_badge&mttnsubad=6759873828';
$badge_lang    = ( 'tr' === $lang ) ? 'tr-tr' : 'en-us';
$badge_url     = "https://toolbox.marketingtools.apple.com/api/v2/badges/download-on-the-app-store/white/{$badge_lang}?releaseDate=1773014400";

/* ── App icon ──────────────────────────────────────────────────────────────── */
$app_icon_url  = esc_url( get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png' );
