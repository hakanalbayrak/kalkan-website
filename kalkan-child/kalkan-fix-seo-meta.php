<?php
/**
 * One-time SEO meta fixer for all Kalkan pages.
 * Visit: kalkan.website/?kalkan_fix_seo=1&key=kalkan2026
 * Delete this file after running.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action('init', function () {
    if (
        ! isset($_GET['kalkan_fix_seo']) ||
        $_GET['kalkan_fix_seo'] !== '1' ||
        ! isset($_GET['key']) ||
        $_GET['key'] !== 'kalkan2026'
    ) {
        return;
    }

    // Must be logged in as admin
    if ( ! current_user_can('manage_options') ) {
        wp_die('Unauthorized');
    }

    $og_image = get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png';
    $results  = array();

    // ── PAGE SEO DATA ──────────────────────────────────────────────────────
    // Format: slug => [ title, description, focus_keyword ]
    $pages_tr = array(
        'blog' => array(
            'Kalkan Blog – Spam Arama ve Telefon Güvenliği Rehberi',
            'Spam aramalar, dolandırıcı numaralar ve telefon güvenliği hakkında güncel bilgiler. Kalkan blog ile kendinizi koruyun.',
            'spam arama blog',
        ),
        'iletisim' => array(
            'İletişim – Kalkan Destek',
            'Kalkan ekibiyle iletişime geçin. Sorularınız, önerileriniz ve destek talepleriniz için bize yazın.',
            'kalkan iletişim',
        ),
        'kalkan-nasil-kullanilir' => array(
            'Kalkan Nasıl Kullanılır? – Adım Adım Kurulum Rehberi',
            'Kalkan uygulamasını iPhone\'unuza nasıl kuracağınızı ve spam aramalardan nasıl korunacağınızı adım adım öğrenin.',
            'kalkan nasıl kullanılır',
        ),
        'kalkan-nasil-calisir' => array(
            'Kalkan Nasıl Çalışır? – Spam Engelleme Teknolojisi',
            'Kalkan\'ın iOS\'ta spam aramaları nasıl engellediğini ve arayan kimliği sisteminin nasıl çalıştığını öğrenin.',
            'kalkan nasıl çalışır',
        ),
        'kalkan-nedir' => array(
            'Kalkan Nedir? – iOS Spam Arama Engelleyici',
            'Kalkan, iPhone\'unuzda istenmeyen aramaları engelleyen ve bilinmeyen numaraları tanımlayan ücretsiz bir uygulamadır.',
            'kalkan nedir',
        ),
        'kvkk' => array(
            'KVKK Aydınlatma Metni – Kalkan',
            'Kalkan uygulaması KVKK kapsamında kişisel verilerin korunması aydınlatma metni.',
            'kalkan kvkk',
        ),
        'gizlilik-politikasi' => array(
            'Gizlilik Politikası – Kalkan',
            'Kalkan uygulaması gizlilik politikası. Verileriniz nasıl korunur ve işlenir.',
            'kalkan gizlilik politikası',
        ),
        'terms' => array(
            'Kullanım Koşulları – Kalkan',
            'Kalkan uygulaması kullanım koşulları ve şartları.',
            'kalkan kullanım koşulları',
        ),
        'number-lookup' => array(
            'Numara Sorgulama – Kalkan',
            'Bilinmeyen numaraları sorgulayın. Kimin aradığını öğrenin, spam numaraları bildirin.',
            'numara sorgulama',
        ),
        'unsubscribe' => array(
            'Abonelikten Çık – Kalkan',
            'Kalkan e-posta bülteninden aboneliğinizi iptal edin.',
            'kalkan abonelikten çık',
        ),
    );

    $pages_en = array(
        'what-is-kalkan' => array(
            'What is Kalkan? – iOS Spam Call Blocker',
            'Kalkan is a free iOS app that blocks unwanted calls and identifies unknown numbers on your iPhone.',
            'what is kalkan',
        ),
        'how-does-kalkan-work' => array(
            'How Does Kalkan Work? – Spam Blocking Technology',
            'Learn how Kalkan blocks spam calls on iOS and how the caller identification system works.',
            'how does kalkan work',
        ),
        'how-to-use-kalkan' => array(
            'How to Use Kalkan – Step by Step Setup Guide',
            'Learn how to install and set up Kalkan on your iPhone to block spam calls step by step.',
            'how to use kalkan',
        ),
        'contact' => array(
            'Contact – Kalkan Support',
            'Get in touch with the Kalkan team. Write to us for questions, suggestions, and support requests.',
            'kalkan contact',
        ),
        'privacy-policy' => array(
            'Privacy Policy – Kalkan',
            'Kalkan app privacy policy. How your data is protected and processed.',
            'kalkan privacy policy',
        ),
        'legal-notice' => array(
            'Legal Notice – Kalkan',
            'Kalkan app legal notice and data protection information.',
            'kalkan legal notice',
        ),
        'unsubscribe' => array(
            'Unsubscribe – Kalkan',
            'Unsubscribe from the Kalkan email newsletter.',
            'kalkan unsubscribe',
        ),
        'en-blog' => array(
            'Kalkan Blog – Spam Calls & Phone Security Guide',
            'Stay informed about spam calls, scam numbers, and phone security. Protect yourself with the Kalkan blog.',
            'spam call blog',
        ),
    );

    // ── PROCESS TURKISH PAGES ──────────────────────────────────────────────
    foreach ( $pages_tr as $slug => $meta ) {
        $page = get_page_by_path( $slug );
        if ( ! $page ) {
            $results[] = "TR SKIP: {$slug} — page not found";
            continue;
        }
        $post_id = $page->ID;
        update_post_meta( $post_id, '_seopress_titles_title', $meta[0] );
        update_post_meta( $post_id, '_seopress_titles_desc', $meta[1] );
        update_post_meta( $post_id, '_seopress_analysis_target_kw', $meta[2] );
        update_post_meta( $post_id, '_seopress_social_fb_title', $meta[0] );
        update_post_meta( $post_id, '_seopress_social_fb_desc', $meta[1] );
        update_post_meta( $post_id, '_seopress_social_fb_img', $og_image );
        update_post_meta( $post_id, '_seopress_social_twitter_title', $meta[0] );
        update_post_meta( $post_id, '_seopress_social_twitter_desc', $meta[1] );
        update_post_meta( $post_id, '_seopress_social_twitter_img', $og_image );
        $results[] = "TR OK: {$slug} (ID {$post_id}) — {$meta[0]}";
    }

    // ── PROCESS ENGLISH PAGES ──────────────────────────────────────────────
    // English pages are Polylang translations, find them via pll_get_post
    foreach ( $pages_en as $slug => $meta ) {
        // Try direct slug first
        $page = get_page_by_path( $slug );
        if ( ! $page ) {
            // Try with en/ prefix for Polylang
            $results[] = "EN SKIP: {$slug} — page not found";
            continue;
        }
        $post_id = $page->ID;

        // Check if this is actually the English version
        $page_lang = function_exists('pll_get_post_language') ? pll_get_post_language( $post_id, 'slug' ) : '';

        // If it's Turkish, get the English translation
        if ( $page_lang === 'tr' && function_exists('pll_get_post') ) {
            $en_id = pll_get_post( $post_id, 'en' );
            if ( $en_id ) {
                $post_id = $en_id;
            } else {
                $results[] = "EN SKIP: {$slug} — no English translation found";
                continue;
            }
        }

        update_post_meta( $post_id, '_seopress_titles_title', $meta[0] );
        update_post_meta( $post_id, '_seopress_titles_desc', $meta[1] );
        update_post_meta( $post_id, '_seopress_analysis_target_kw', $meta[2] );
        update_post_meta( $post_id, '_seopress_social_fb_title', $meta[0] );
        update_post_meta( $post_id, '_seopress_social_fb_desc', $meta[1] );
        update_post_meta( $post_id, '_seopress_social_fb_img', $og_image );
        update_post_meta( $post_id, '_seopress_social_twitter_title', $meta[0] );
        update_post_meta( $post_id, '_seopress_social_twitter_desc', $meta[1] );
        update_post_meta( $post_id, '_seopress_social_twitter_img', $og_image );
        $results[] = "EN OK: {$slug} (ID {$post_id}) — {$meta[0]}";
    }

    // ── FIX HOMEPAGE ───────────────────────────────────────────────────────
    $front_id = (int) get_option('page_on_front');
    if ( $front_id ) {
        // Turkish homepage
        update_post_meta( $front_id, '_seopress_titles_title', 'Kalkan – Spam Arama Engelleme ve Numara Sorgulama' );
        update_post_meta( $front_id, '_seopress_titles_desc', 'iPhone\'unuzda spam aramaları engelleyin, bilinmeyen numaraları tanıyın. Kalkan ile telefonunuzu güvene alın. Ücretsiz indirin.' );
        update_post_meta( $front_id, '_seopress_analysis_target_kw', 'spam arama engelleme' );
        update_post_meta( $front_id, '_seopress_social_fb_title', 'Kalkan – Spam Aramalara Karşı Kalkanınız' );
        update_post_meta( $front_id, '_seopress_social_fb_desc', 'iOS için spam arama engelleyici ve arayan kimliği uygulaması.' );
        update_post_meta( $front_id, '_seopress_social_fb_img', $og_image );
        update_post_meta( $front_id, '_seopress_social_twitter_title', 'Kalkan – Spam Aramalara Karşı Kalkanınız' );
        update_post_meta( $front_id, '_seopress_social_twitter_desc', 'iOS için spam arama engelleyici ve arayan kimliği uygulaması.' );
        update_post_meta( $front_id, '_seopress_social_twitter_img', $og_image );
        $results[] = "HOME TR OK: (ID {$front_id})";

        // English homepage translation
        if ( function_exists('pll_get_post') ) {
            $en_front = pll_get_post( $front_id, 'en' );
            if ( $en_front ) {
                update_post_meta( $en_front, '_seopress_titles_title', 'Kalkan – Spam Call Blocker & Number Lookup for iOS' );
                update_post_meta( $en_front, '_seopress_titles_desc', 'Block spam calls and identify unknown numbers on your iPhone. Download Kalkan for free.' );
                update_post_meta( $en_front, '_seopress_analysis_target_kw', 'spam call blocker ios' );
                update_post_meta( $en_front, '_seopress_social_fb_title', 'Kalkan – Your Shield Against Spam Calls' );
                update_post_meta( $en_front, '_seopress_social_fb_desc', 'iOS spam call blocker and caller identification app.' );
                update_post_meta( $en_front, '_seopress_social_fb_img', $og_image );
                update_post_meta( $en_front, '_seopress_social_twitter_title', 'Kalkan – Your Shield Against Spam Calls' );
                update_post_meta( $en_front, '_seopress_social_twitter_desc', 'iOS spam call blocker and caller identification app.' );
                update_post_meta( $en_front, '_seopress_social_twitter_img', $og_image );
                $results[] = "HOME EN OK: (ID {$en_front})";
            }
        }
    }

    // ── FIX BLOG POSTS (Turkish) ───────────────────────────────────────────
    $posts_tr = array(
        'kalkan-uygulamasi-yayinda' => array(
            'Kalkan Uygulaması Yayında! – iOS Spam Engelleyici',
            'Kalkan uygulaması App Store\'da yayında. iPhone\'unuzda spam aramaları engelleyin ve bilinmeyen numaraları öğrenin.',
            'kalkan uygulaması',
        ),
        'spam-arama-engelleme' => array(
            'Spam Arama Engelleme – iPhone\'da Nasıl Yapılır?',
            'iPhone\'unuzda spam aramaları nasıl engelleyeceğinizi adım adım öğrenin. Kalkan ile istenmeyen aramalardan kurtulun.',
            'spam arama engelleme',
        ),
        'numara-sorgulama' => array(
            'Numara Sorgulama – Bilinmeyen Numara Kimin?',
            'Sizi arayan bilinmeyen numarayı sorgulayın. Spam mı, dolandırıcı mı yoksa güvenilir mi öğrenin.',
            'numara sorgulama',
        ),
        'dolandirici-numara-tanima' => array(
            'Dolandırıcı Numara Tanıma – Kendinizi Nasıl Korursunuz?',
            'Dolandırıcı numaraları nasıl tanıyacağınızı ve telefon dolandırıcılığından nasıl korunacağınızı öğrenin.',
            'dolandırıcı numara tanıma',
        ),
        'bilinmeyen-numara-kimin' => array(
            'Bilinmeyen Numara Kimin? – Numara Sorgulama Rehberi',
            'Sizi arayan bilinmeyen numaranın kime ait olduğunu öğrenmenin yolları. Numara sorgulama rehberi.',
            'bilinmeyen numara kimin',
        ),
        'surekli-arayan-numara-engelleme' => array(
            'Sürekli Arayan Numara Engelleme – iPhone Rehberi',
            'iPhone\'unuzda sürekli arayan rahatsız edici numaraları nasıl engelleyeceğinizi öğrenin.',
            'sürekli arayan numara engelleme',
        ),
    );

    foreach ( $posts_tr as $slug => $meta ) {
        $posts = get_posts( array(
            'name'        => $slug,
            'post_type'   => 'post',
            'numberposts' => 1,
            'post_status' => 'publish',
        ) );
        if ( empty( $posts ) ) {
            $results[] = "POST SKIP: {$slug} — not found";
            continue;
        }
        $post_id = $posts[0]->ID;
        update_post_meta( $post_id, '_seopress_titles_title', $meta[0] );
        update_post_meta( $post_id, '_seopress_titles_desc', $meta[1] );
        update_post_meta( $post_id, '_seopress_analysis_target_kw', $meta[2] );
        update_post_meta( $post_id, '_seopress_social_fb_title', $meta[0] );
        update_post_meta( $post_id, '_seopress_social_fb_desc', $meta[1] );
        update_post_meta( $post_id, '_seopress_social_fb_img', $og_image );
        update_post_meta( $post_id, '_seopress_social_twitter_title', $meta[0] );
        update_post_meta( $post_id, '_seopress_social_twitter_desc', $meta[1] );
        update_post_meta( $post_id, '_seopress_social_twitter_img', $og_image );
        $results[] = "POST OK: {$slug} (ID {$post_id}) — {$meta[0]}";
    }

    // ── OUTPUT RESULTS ─────────────────────────────────────────────────────
    header('Content-Type: text/plain; charset=utf-8');
    echo "=== KALKAN SEO META FIX RESULTS ===\n\n";
    foreach ( $results as $r ) {
        echo $r . "\n";
    }
    echo "\n=== DONE ===\n";
    echo "Delete kalkan-fix-seo-meta.php from your theme after verifying.\n";
    exit;
});
