<?php
/**
 * Shared setup — language, URL helpers, App Store badges.
 *
 * Expected to be included at the top of every self-contained page template.
 * After inclusion the following variables are available:
 *
 * $lang, $__,
 * $home_url, $blog_url, $privacy_url, $kvkk_url, $contact_url,
 * $appstore_link, $badge_url, $app_icon_url
 *
 * @package kalkan-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ── Language detection (Polylang) ──────────────────────────────────────────── */
$lang = function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : 'tr';
if ( ! $lang ) {
	$lang = 'tr';
}

$__ = static function ( string $tr, string $en ) use ( $lang ) : string {
	return 'en' === $lang ? $en : $tr;
};

/* ── URL helpers (Polylang-aware) ──────────────────────────────────────────── */
$home_url = function_exists( 'pll_home_url' ) ? esc_url( pll_home_url() ) : esc_url( home_url( '/' ) );

$blog_page_id = (int) get_option( 'page_for_posts' );
$_kk_pll_url  = static function ( int $post_id ) : string {
	if ( $post_id > 0 && function_exists( 'pll_get_post' ) ) {
		$translated_id = pll_get_post( $post_id );
		if ( $translated_id ) {
			return esc_url( get_permalink( $translated_id ) );
		}
	}
	return $post_id > 0 ? esc_url( get_permalink( $post_id ) ) : '';
};

$blog_url = $blog_page_id > 0
	? $_kk_pll_url( $blog_page_id )
	: esc_url( kalkan_page_url( 'blog', 'blog' ) );

$privacy_page_id = (int) get_option( 'wp_page_for_privacy_policy' );
$privacy_url     = $privacy_page_id > 0
	? $_kk_pll_url( $privacy_page_id )
	: esc_url( kalkan_page_url( 'privacy-policy', 'privacy-policy' ) );

$kvkk_page = get_page_by_path( 'kvkk' );
$kvkk_url  = $kvkk_page
	? $_kk_pll_url( $kvkk_page->ID )
	: esc_url( kalkan_page_url( 'kvkk', 'legal-notice' ) );

$contact_page = get_page_by_path( 'iletisim' );
if ( ! $contact_page ) {
	$contact_page = get_page_by_path( 'contact' );
}
$contact_url = $contact_page
	? $_kk_pll_url( $contact_page->ID )
	: esc_url( kalkan_page_url( 'iletisim', 'contact' ) );

/* ── Info page URLs ───────────────────────────────────────────────────────── */
$what_is_page = get_page_by_path( 'kalkan-nedir' );
$what_is_url  = $what_is_page
	? $_kk_pll_url( $what_is_page->ID )
	: esc_url( kalkan_page_url( 'kalkan-nedir', 'what-is-kalkan' ) );

$how_works_page = get_page_by_path( 'kalkan-nasil-calisir' );
$how_works_url  = $how_works_page
	? $_kk_pll_url( $how_works_page->ID )
	: esc_url( kalkan_page_url( 'kalkan-nasil-calisir', 'how-kalkan-works' ) );

$how_to_use_page = get_page_by_path( 'kalkan-nasil-kullanilir' );
$how_to_use_url  = $how_to_use_page
	? $_kk_pll_url( $how_to_use_page->ID )
	: esc_url( kalkan_page_url( 'kalkan-nasil-kullanilir', 'how-to-use-kalkan' ) );

/* ── App Store badges (official Apple hosted) ──────────────────────────────── */
$appstore_link = 'https://apple.co/4cYKmRG';
$badge_lang    = ( 'tr' === $lang ) ? 'tr-tr' : 'en-us';
$badge_url     = "https://toolbox.marketingtools.apple.com/api/v2/badges/download-on-the-app-store/white/{$badge_lang}?releaseDate=1773014400";

/* ── App icon ──────────────────────────────────────────────────────────────── */
$app_icon_url  = esc_url( get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png' );
