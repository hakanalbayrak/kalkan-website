<?php
/**
 * Editorial transparency and low-value-content cleanup.
 *
 * @package kalkan-child
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Publish the Turkish and English editorial-policy pages once.
 */
function kalkan_publish_editorial_policy_v1() {
    if (get_option('kalkan_editorial_policy_published_v1')) {
        return;
    }

    $pages = array(
        'tr' => array(
            'slug' => 'icerik-ilkeleri',
            'title' => 'Kalkan İçerik İlkeleri',
            'excerpt' => 'Kalkan içeriklerinin nasıl araştırıldığını, güncellendiğini ve düzeltildiğini açıklayan editoryal ilkeler.',
            'seo_title' => 'Kalkan İçerik İlkeleri ve Kaynak Politikası',
            'seo_desc' => 'Kalkan telefon güvenliği içeriklerinin kaynak, inceleme, güncelleme, düzeltme ve reklam bağımsızlığı ilkelerini inceleyin.',
        ),
        'en' => array(
            'slug' => 'editorial-policy',
            'title' => 'Kalkan Editorial Policy',
            'excerpt' => 'How Kalkan researches, reviews, updates, and corrects its phone-safety content.',
            'seo_title' => 'Kalkan Editorial and Source Policy',
            'seo_desc' => 'Learn how Kalkan researches, reviews, updates, corrects, and separates advertising from its phone-safety guidance.',
        ),
    );

    $ids = array();
    foreach ($pages as $language => $page) {
        $existing = get_page_by_path($page['slug'], OBJECT, 'page');
        $post_id = wp_insert_post(array(
            'ID'           => $existing instanceof WP_Post ? (int) $existing->ID : 0,
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_title'   => $page['title'],
            'post_name'    => $page['slug'],
            'post_excerpt' => $page['excerpt'],
            'post_content' => '',
        ), true);

        if (is_wp_error($post_id)) {
            return;
        }

        update_post_meta($post_id, '_wp_page_template', 'page-editorial-policy.php');
        update_post_meta($post_id, '_seopress_titles_title', $page['seo_title']);
        update_post_meta($post_id, '_seopress_titles_desc', $page['seo_desc']);
        if (function_exists('pll_set_post_language')) {
            pll_set_post_language($post_id, $language);
        }
        $ids[$language] = (int) $post_id;
    }

    if (function_exists('pll_save_post_translations') && isset($ids['tr'], $ids['en'])) {
        pll_save_post_translations($ids);
    }

    update_option('kalkan_editorial_policy_published_v1', true);
}
add_action('init', 'kalkan_publish_editorial_policy_v1', 46);

/**
 * Consolidate two legacy posts that duplicate stronger, maintained pages.
 */
function kalkan_consolidate_legacy_thin_posts_v1() {
    if (get_option('kalkan_legacy_thin_posts_consolidated_v1')) {
        return;
    }

    $slugs = array(
        'surekli-arayan-numara-engelleme',
        'kalkan-uygulamasi-yayinda',
    );

    foreach ($slugs as $slug) {
        $post = get_page_by_path($slug, OBJECT, 'post');
        if ($post instanceof WP_Post && 'draft' !== $post->post_status) {
            $result = wp_update_post(array(
                'ID'          => (int) $post->ID,
                'post_status' => 'draft',
            ), true);
            if (is_wp_error($result)) {
                return;
            }
        }
    }

    update_option('kalkan_legacy_thin_posts_consolidated_v1', true);
}
add_action('init', 'kalkan_consolidate_legacy_thin_posts_v1', 47);

/** Keep links to consolidated posts useful and preserve accumulated signals. */
function kalkan_redirect_legacy_thin_posts() {
    $path = isset($_SERVER['REQUEST_URI'])
        ? untrailingslashit((string) wp_parse_url(wp_unslash($_SERVER['REQUEST_URI']), PHP_URL_PATH))
        : '';

    $redirects = array(
        '/surekli-arayan-numara-engelleme' => '/spam-arama-engelleme/',
        '/kalkan-uygulamasi-yayinda'       => '/surum-gecmisi/',
    );

    if (isset($redirects[$path])) {
        wp_safe_redirect(home_url($redirects[$path]), 301);
        exit;
    }
}
add_action('template_redirect', 'kalkan_redirect_legacy_thin_posts', 4);

/**
 * Remove utility and duplicate archives from search results while keeping
 * useful topic categories indexable.
 */
function kalkan_content_quality_robots($robots) {
    if (is_search() || is_author() || is_date() || is_tag() || is_attachment()) {
        return 'noindex, follow';
    }
    return $robots;
}
add_filter('seopress_titles_robots', 'kalkan_content_quality_robots', 30);

/** Redirect attachment pages to their parent article or the homepage. */
function kalkan_redirect_attachment_pages() {
    if (!is_attachment()) {
        return;
    }

    $attachment = get_queried_object();
    $target = ($attachment instanceof WP_Post && $attachment->post_parent)
        ? get_permalink((int) $attachment->post_parent)
        : home_url('/');
    wp_safe_redirect($target, 301);
    exit;
}
add_action('template_redirect', 'kalkan_redirect_attachment_pages', 5);

/** Use the editorial method as the visible and structured article author. */
function kalkan_editorial_policy_url() {
    return kalkan_page_url('icerik-ilkeleri', 'editorial-policy');
}

/** Purge stale page and sitemap caches after the quality cleanup. */
function kalkan_purge_content_quality_cache_v1() {
    if (get_option('kalkan_content_quality_cache_purged_v1')) {
        return;
    }

    if (has_action('litespeed_purge_all')) {
        do_action('litespeed_purge_all');
    }

    update_option('kalkan_content_quality_cache_purged_v1', true);
}
add_action('init', 'kalkan_purge_content_quality_cache_v1', 1018);
