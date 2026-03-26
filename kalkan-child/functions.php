<?php
/**
 * Kalkan Child Theme functions.
 *
 * Extend this file conservatively and keep logic simple.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue child stylesheet.
 *
 * We load after parent styles and keep dependency handling minimal.
 */
function kalkan_child_enqueue_styles() {
    $dependencies = array();

    // If Blocksy registered its main stylesheet, load child CSS after it.
    if (wp_style_is('blocksy-style', 'registered') || wp_style_is('blocksy-style', 'enqueued')) {
        $dependencies[] = 'blocksy-style';
    }

    wp_enqueue_style(
        'kalkan-child-style',
        get_stylesheet_uri(),
        $dependencies,
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'kalkan_child_enqueue_styles', 20);

/**
 * Register lightweight theme settings used by code-rendered homepage.
 */
function kalkan_child_customize_register($wp_customize) {
    $wp_customize->add_setting(
        'kalkan_app_store_url',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'kalkan_app_store_url',
        array(
            'type'        => 'url',
            'section'     => 'title_tagline',
            'label'       => __('Kalkan App Store URL', 'kalkan-child'),
            'description' => __('Used for homepage App Store CTA buttons.', 'kalkan-child'),
        )
    );
}
add_action('customize_register', 'kalkan_child_customize_register');

/**
 * App Store URL override for homepage template.
 */
function kalkan_child_filter_app_store_url($url) {
    $customizer_value = get_theme_mod('kalkan_app_store_url', '');

    if (!empty($customizer_value)) {
        return $customizer_value;
    }

    return $url;
}
add_filter('kalkan_app_store_url', 'kalkan_child_filter_app_store_url');

/**
 * Map menu item labels to a normalized key used for ordering.
 */
function kalkan_child_get_menu_item_key($menu_item) {
    $title = isset($menu_item->title) ? wp_strip_all_tags((string) $menu_item->title) : '';
    $title = strtolower(trim((string) preg_replace('/\s+/', ' ', $title)));

    if ('home' === $title) {
        return 'home';
    }

    if (false !== strpos($title, 'number lookup')) {
        return 'number lookup';
    }

    if (false !== strpos($title, 'blog')) {
        return 'blog';
    }

    if (false !== strpos($title, 'privacy')) {
        return 'privacy policy';
    }

    if (false !== strpos($title, 'term')) {
        return 'terms';
    }

    if (false !== strpos($title, 'contact') || false !== strpos($title, 'support')) {
        return 'contact';
    }

    return '';
}

/**
 * Resolve root parent menu item ID for consistent top-level sorting.
 */
function kalkan_child_get_root_menu_item_id($item_id, $parent_map) {
    $root   = (int) $item_id;
    $safety = 0;

    while (isset($parent_map[$root]) && (int) $parent_map[$root] > 0 && $safety < 25) {
        $root = (int) $parent_map[$root];
        $safety++;
    }

    return $root;
}

/**
 * Enforce top menu order for Kalkan marketing navigation.
 */
function kalkan_child_reorder_menu_items($items, $args) {
    if (empty($items) || !is_array($items)) {
        return $items;
    }

    // Skip footer-like locations to avoid unintended reordering.
    if (isset($args->theme_location) && false !== strpos((string) $args->theme_location, 'footer')) {
        return $items;
    }

    $target_order = array(
        'home',
        'number lookup',
        'blog',
        'privacy policy',
        'terms',
        'contact',
    );

    $top_level_items = array();
    foreach ($items as $item) {
        if ((int) $item->menu_item_parent === 0) {
            $top_level_items[] = $item;
        }
    }

    if (empty($top_level_items)) {
        return $items;
    }

    $ordered_root_ids = array();
    $matched_count     = 0;

    foreach ($target_order as $target_key) {
        foreach ($top_level_items as $top_level_item) {
            if (in_array((int) $top_level_item->ID, $ordered_root_ids, true)) {
                continue;
            }

            if (kalkan_child_get_menu_item_key($top_level_item) === $target_key) {
                $ordered_root_ids[] = (int) $top_level_item->ID;
                $matched_count++;
                break;
            }
        }
    }

    // If this does not look like the main site menu, leave it untouched.
    if ($matched_count < 3) {
        return $items;
    }

    foreach ($top_level_items as $top_level_item) {
        if (!in_array((int) $top_level_item->ID, $ordered_root_ids, true)) {
            $ordered_root_ids[] = (int) $top_level_item->ID;
        }
    }

    $root_rank      = array();
    $parent_map     = array();
    $original_index = array();

    foreach ($ordered_root_ids as $index => $root_id) {
        $root_rank[(int) $root_id] = (int) $index;
    }

    foreach ($items as $index => $item) {
        $parent_map[(int) $item->ID]     = (int) $item->menu_item_parent;
        $original_index[(int) $item->ID] = (int) $index;
    }

    usort(
        $items,
        function ($a, $b) use ($root_rank, $parent_map, $original_index) {
            $a_id   = (int) $a->ID;
            $b_id   = (int) $b->ID;
            $a_root = kalkan_child_get_root_menu_item_id($a_id, $parent_map);
            $b_root = kalkan_child_get_root_menu_item_id($b_id, $parent_map);

            $a_rank = $root_rank[$a_root] ?? 9999;
            $b_rank = $root_rank[$b_root] ?? 9999;

            if ($a_rank === $b_rank) {
                $a_original = $original_index[$a_id] ?? 0;
                $b_original = $original_index[$b_id] ?? 0;

                return $a_original <=> $b_original;
            }

            return $a_rank <=> $b_rank;
        }
    );

    return $items;
}
add_filter('wp_nav_menu_objects', 'kalkan_child_reorder_menu_items', 20, 2);

/**
 * Theme setup: title-tag, thumbnails, navigation.
 */
function kalkan_child_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menus(
        array(
            'kalkan-header' => __('Kalkan Header Menu', 'kalkan-child'),
            'kalkan-footer' => __('Kalkan Footer Menu', 'kalkan-child'),
        )
    );
}
add_action('after_setup_theme', 'kalkan_child_theme_setup');

/**
 * Enqueue Google Fonts: Plus Jakarta Sans + Inter.
 */
function kalkan_child_enqueue_google_fonts() {
    wp_enqueue_style(
        'kalkan-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'kalkan_child_enqueue_google_fonts', 5);

/**
 * Shortcode: [kalkan_subscribe] — placeholder for FluentCRM form.
 *
 * @return string HTML output.
 */
function kalkan_subscribe_shortcode() {
    return '<div class="kalkan-subscribe-placeholder" style="padding:1.5rem;border:1px dashed rgba(139,92,246,0.35);border-radius:0.75rem;text-align:center;color:#c4b5fd;font-size:0.95rem;">'
        . esc_html__('Email subscription form — connect FluentCRM here.', 'kalkan-child')
        . '</div>';
}
add_shortcode('kalkan_subscribe', 'kalkan_subscribe_shortcode');

/**
 * Add favicon and apple-touch-icon using the Kalkan app icon.
 */
function kalkan_child_favicon() {
    $icon_url = esc_url( get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png' );
    echo '<link rel="icon" type="image/png" href="' . $icon_url . '">' . "\n";
    echo '<link rel="apple-touch-icon" href="' . $icon_url . '">' . "\n";
}
add_action('wp_head', 'kalkan_child_favicon', 1);

/**
 * Create SEO-optimized blog categories.
 */
function kalkan_create_categories() {
    if (get_option('kalkan_categories_created_v2')) return;

    $categories = array(
        array('name' => 'Spam Aramalar', 'slug' => 'spam-aramalar', 'desc' => 'Spam arama engelleme yöntemleri ve ipuçları'),
        array('name' => 'Numara Sorgulama', 'slug' => 'numara-sorgulama', 'desc' => 'Bilinmeyen numara sorgulama ve arayan kimliği'),
        array('name' => 'Güvenlik', 'slug' => 'guvenlik', 'desc' => 'Telefon güvenliği ve dolandırıcılıktan korunma'),
        array('name' => 'Uygulama', 'slug' => 'uygulama', 'desc' => 'Kalkan uygulaması haberleri ve güncellemeleri'),
    );

    foreach ($categories as $cat) {
        if (!term_exists($cat['slug'], 'category')) {
            wp_insert_term($cat['name'], 'category', array(
                'slug' => $cat['slug'],
                'description' => $cat['desc'],
            ));
        }
    }

    $uncategorized = get_cat_ID('Uncategorized');
    if ($uncategorized) {
        wp_delete_category($uncategorized);
    }

    update_option('kalkan_categories_created_v2', true);
}
add_action('init', 'kalkan_create_categories', 5);

/**
 * Set default OG image for SEOPress if none is set.
 */
add_filter('seopress_social_og_thumb', 'kalkan_default_og_image');
function kalkan_default_og_image($og_image) {
    if (empty($og_image)) {
        return get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png';
    }
    return $og_image;
}

add_filter('seopress_social_twitter_card_thumb', 'kalkan_default_twitter_image');
function kalkan_default_twitter_image($image) {
    if (empty($image)) {
        return get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png';
    }
    return $image;
}

/**
 * Get Polylang-aware URL for internal pages.
 *
 * @param string $slug_tr Turkish slug.
 * @param string $slug_en English slug (defaults to $slug_tr).
 * @return string Full URL.
 */
function kalkan_page_url($slug_tr, $slug_en = null) {
    $lang = function_exists('pll_current_language') ? pll_current_language('slug') : 'tr';
    if (!$lang) {
        $lang = 'tr';
    }

    if ($lang === 'en' && $slug_en) {
        return home_url('/en/' . $slug_en . '/');
    }
    return home_url('/' . $slug_tr . '/');
}

/**
 * Organization schema — output on every page for consistent brand signals.
 */
add_action('wp_head', 'kalkan_organization_schema', 98);
function kalkan_organization_schema() {
    static $done = false;
    if ($done) return;
    $done = true;

    $schema = array(
        '@context'  => 'https://schema.org',
        '@type'     => 'Organization',
        'name'      => 'Kalkan',
        'url'       => 'https://kalkan.website',
        'logo'      => get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png',
        'email'     => 'info@kalkan.website',
        'sameAs'    => array('https://apps.apple.com/app/kalkan/id6746268015'),
    );
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
}

/**
 * WebSite schema with SearchAction — homepage only.
 */
add_action('wp_head', 'kalkan_website_schema', 98);
function kalkan_website_schema() {
    if (!is_front_page()) return;

    $schema = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'WebSite',
        'name'            => 'Kalkan',
        'url'             => 'https://kalkan.website',
        'inLanguage'      => array('tr', 'en'),
        'description'     => 'Kalkan - iOS spam arama engelleyici ve arayan kimliği uygulaması.',
        'potentialAction' => array(
            '@type'       => 'SearchAction',
            'target'      => 'https://kalkan.website/?s={search_term_string}',
            'query-input' => 'required name=search_term_string',
        ),
    );
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
}

/**
 * MobileApplication schema — homepage only.
 */
add_action('wp_head', 'kalkan_add_structured_data', 99);
function kalkan_add_structured_data() {
    if (!is_front_page()) return;

    $lang = function_exists('pll_current_language') ? pll_current_language('slug') : 'tr';
    if (!$lang) $lang = 'tr';

    $desc = ($lang === 'tr')
        ? 'Kalkan, iOS cihazınızda spam aramaları engelleyen ve bilinmeyen numaraları tanımlayan ücretsiz bir uygulamadır.'
        : 'Kalkan blocks spam calls and identifies unknown numbers on your iPhone. Free app with offline protection.';

    $schema = array(
        '@context'            => 'https://schema.org',
        '@type'               => 'MobileApplication',
        'name'                => 'Kalkan',
        'operatingSystem'     => 'iOS',
        'applicationCategory' => 'UtilitiesApplication',
        'description'         => $desc,
        'url'                 => 'https://kalkan.website',
        'downloadUrl'         => 'https://apple.co/4cYKmRG',
        'offers'              => array(
            '@type'         => 'Offer',
            'price'         => '0',
            'priceCurrency' => 'TRY',
        ),
        'author'              => array(
            '@type' => 'Organization',
            'name'  => 'Kalkan',
            'url'   => 'https://kalkan.website',
            'email' => 'info@kalkan.website',
        ),
        'inLanguage'          => array('tr', 'en'),
    );
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
}

/**
 * FAQPage schema for homepage FAQ section.
 */
add_action('wp_head', 'kalkan_homepage_faq_schema', 99);
function kalkan_homepage_faq_schema() {
    if (!is_front_page()) return;

    $lang = function_exists('pll_current_language') ? pll_current_language('slug') : 'tr';
    if (!$lang) $lang = 'tr';

    $faqs_tr = array(
        array('Kalkan nasıl çalışır?', 'Kalkan, bilinen spam numaraların veritabanını cihazınıza yükler. iOS\'un arama dizini sistemi ile entegre çalışarak gelen aramaları engeller veya işaretler. İnternet bağlantısı gerektirmez.'),
        array('Kalkan gerçek zamanlı arama analizi yapıyor mu?', 'Hayır. iOS platformu gerçek zamanlı arama analizine izin vermez. Kalkan, önceden yüklenmiş veritabanı ile çalışır. Bu Apple\'ın güvenlik kısıtlamalarından kaynaklanmaktadır.'),
        array('Ekstra Koruma nedir?', 'Ekstra Koruma, standart spam listesinin ötesinde genişletilmiş numara kalıplarını engelleyen gelişmiş bir koruma katmanıdır. Şu anda ücretsizdir.'),
        array('Verilerim güvende mi?', 'Evet. Kalkan rehberinize veya arama geçmişinize erişmez. Tüm arama koruma işlemleri cihazınızda yerel olarak gerçekleşir.'),
        array('Kalkan ücretsiz mi?', 'Genel Koruma ve İletişim Bildirimi özellikleri tamamen ücretsizdir. Ekstra Koruma şu anda ücretsiz olarak sunulmaktadır.'),
    );
    $faqs_en = array(
        array('How does Kalkan work?', 'Kalkan loads a database of known spam numbers to your device. It works with iOS\'s call directory system to block or flag incoming calls. No internet connection required.'),
        array('Does Kalkan do real-time call analysis?', 'No. iOS does not allow real-time call analysis. Kalkan works with a preloaded database. This is due to Apple\'s security restrictions.'),
        array('What is Extra Protection?', 'Extra Protection is an advanced layer that blocks extended number patterns beyond the standard spam list. It\'s currently free.'),
        array('Is my data safe?', 'Yes. Kalkan doesn\'t access your contacts or call history. All call protection happens locally on your device.'),
        array('Is Kalkan free?', 'General Protection and Communication Reporting features are completely free. Extra Protection is currently offered for free.'),
    );

    $faqs = ($lang === 'en') ? $faqs_en : $faqs_tr;
    $items = array();
    foreach ($faqs as $faq) {
        $items[] = array(
            '@type' => 'Question',
            'name'  => $faq[0],
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => $faq[1],
            ),
        );
    }

    $schema = array(
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => $items,
    );
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
}

/**
 * BreadcrumbList schema for interior pages and posts.
 */
add_action('wp_head', 'kalkan_breadcrumb_schema', 99);
function kalkan_breadcrumb_schema() {
    if (is_front_page()) return;

    $items = array();
    $items[] = array(
        '@type'    => 'ListItem',
        'position' => 1,
        'name'     => 'Kalkan',
        'item'     => 'https://kalkan.website',
    );

    $pos = 2;
    if (is_singular('post')) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $pos++,
            'name'     => 'Blog',
            'item'     => 'https://kalkan.website/blog/',
        );
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $pos,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );
    } elseif (is_home()) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $pos,
            'name'     => 'Blog',
            'item'     => get_permalink(get_option('page_for_posts')),
        );
    } elseif (is_singular('page')) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $pos,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );
    }

    if (count($items) < 2) return;

    $schema = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    );
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
}

/**
 * BlogPosting schema for single blog posts.
 */
add_action('wp_head', 'kalkan_blogposting_schema', 99);
function kalkan_blogposting_schema() {
    if (!is_singular('post')) return;

    $schema = array(
        '@context'      => 'https://schema.org',
        '@type'         => 'BlogPosting',
        'headline'      => get_the_title(),
        'description'   => get_post_meta(get_the_ID(), '_seopress_titles_desc', true) ?: wp_trim_words(get_the_excerpt(), 25),
        'datePublished' => get_the_date('c'),
        'dateModified'  => get_the_modified_date('c'),
        'url'           => get_permalink(),
        'inLanguage'    => 'tr',
        'author'        => array(
            '@type' => 'Organization',
            'name'  => 'Kalkan',
            'url'   => 'https://kalkan.website',
        ),
        'publisher'     => array(
            '@type' => 'Organization',
            'name'  => 'Kalkan',
            'logo'  => array(
                '@type' => 'ImageObject',
                'url'   => get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png',
            ),
        ),
        'mainEntityOfPage' => array(
            '@type' => 'WebPage',
            '@id'   => get_permalink(),
        ),
    );
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
}

/**
 * HowTo schema for info pages (Nasıl Çalışır, Nasıl Kullanılır).
 */
add_action('wp_head', 'kalkan_howto_schema', 99);
function kalkan_howto_schema() {
    if (!is_singular('page')) return;

    $slug = get_post_field('post_name', get_the_ID());

    if ('kalkan-nasil-calisir' === $slug) {
        $schema = array(
            '@context'    => 'https://schema.org',
            '@type'       => 'HowTo',
            'name'        => 'Kalkan Nasıl Çalışır?',
            'description' => 'Kalkan uygulamasının iOS cihazlarda spam aramaları nasıl engellediğinin teknik açıklaması.',
            'step'        => array(
                array('@type' => 'HowToStep', 'name' => 'Veritabanı İndirilir', 'text' => 'Kalkan, bilinen spam numaraların veritabanını cihazınıza indirir.'),
                array('@type' => 'HowToStep', 'name' => 'iOS Entegrasyonu', 'text' => 'Veriler iOS Call Directory Extension ile sisteme yüklenir.'),
                array('@type' => 'HowToStep', 'name' => 'Arama Kontrolü', 'text' => 'Gelen arama sırasında iOS, numarayı yüklenen veritabanında kontrol eder.'),
                array('@type' => 'HowToStep', 'name' => 'Kullanıcı Bildirimi', 'text' => 'Şüpheli numaraları Communication Reporting ile bildirebilirsiniz.'),
            ),
        );
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
    }

    if ('kalkan-nasil-kullanilir' === $slug) {
        $schema = array(
            '@context'    => 'https://schema.org',
            '@type'       => 'HowTo',
            'name'        => 'Kalkan Nasıl Kullanılır?',
            'description' => 'Kalkan uygulamasını iPhone\'a kurma ve kullanma rehberi.',
            'step'        => array(
                array('@type' => 'HowToStep', 'name' => 'App Store\'dan İndirin', 'text' => 'App Store\'da "Kalkan" aratın veya doğrudan bağlantıdan indirin.'),
                array('@type' => 'HowToStep', 'name' => 'Uygulamayı Açın', 'text' => 'Kalkan\'ı açın ve karşılama ekranındaki talimatları takip edin.'),
                array('@type' => 'HowToStep', 'name' => 'Arama Engellemeyi Etkinleştirin', 'text' => 'Ayarlar → Telefon → Arama Engelleme ve Kimliklendirme → Kalkan\'ı etkinleştirin.'),
                array('@type' => 'HowToStep', 'name' => 'Veritabanını Güncelleyin', 'text' => 'Uygulama içinden veritabanını güncelleyerek en son spam numaraları alın.'),
                array('@type' => 'HowToStep', 'name' => 'Şüpheli Numaraları Bildirin', 'text' => 'Telefon uygulamasından veya Kalkan içinden şüpheli numaraları bildirebilirsiniz.'),
            ),
        );
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
    }
}

/**
 * SEO-Optimized Blog Posts — Full Rewrite.
 * Following strict SEOPress rules:
 * - Target keyword in Title, H2, meta desc, slug
 * - Internal links in every post (2-3 per post)
 * - 1 category per post
 * - Short slugs with keyword
 * - Focus keyword set
 */
function kalkan_seo_optimized_posts() {
    if (get_option('kalkan_seo_posts_v4')) return;

    $cat_spam = get_cat_ID('Spam Aramalar');
    $cat_numara = get_cat_ID('Numara Sorgulama');
    $cat_guvenlik = get_cat_ID('Güvenlik');
    $cat_uygulama = get_cat_ID('Uygulama');

    if (!$cat_spam) return;

    $home = home_url('/');

    $posts_data = array(
        // POST 1: Spam arama engelleme
        array(
            'title' => 'iPhone\'da Spam Arama Nasıl Engellenir?',
            'slug' => 'spam-arama-engelleme',
            'category' => $cat_spam,
            'focus_keyword' => 'spam arama engelleme',
            'seo_title' => 'Spam Arama Engelleme – Kalkan',
            'seo_desc' => 'iPhone\'da spam aramaları engellemenin en etkili yolları. Kalkan uygulaması ile otomatik spam engelleme ve arayan kimliği.',
            'en_title' => 'How to Block Spam Calls on iPhone',
            'content_tr' => '<p>Spam arama engelleme, günümüzde iPhone kullanıcılarının en çok ihtiyaç duyduğu özelliklerden biridir. Dolandırıcılık aramaları, istenmeyen satış telefonları ve rahatsız edici numaralar günlük hayatı olumsuz etkiler.</p>

<h2>iPhone\'da Spam Arama Engelleme Yöntemleri</h2>

<p>iOS, spam aramaları engellemek için yerleşik özellikler sunar. Ancak en kapsamlı koruma için <a href="' . $home . '">Kalkan uygulamasını</a> kullanmanızı öneriyoruz.</p>

<h3>1. Kalkan ile Otomatik Spam Arama Engelleme</h3>
<p>Kalkan, iOS\'un Arama Engelleme ve Kimliklendirme sistemi ile entegre çalışır. Binlerce bilinen spam numarayı içeren veritabanını cihazınıza yükler. Koruma tamamen çevrimdışı çalışır — internet gerekmez.</p>

<p>Kurulum:</p>
<ol>
<li>App Store\'dan <a href="https://apple.co/4cYKmRG">Kalkan\'ı indirin</a></li>
<li>Uygulamayı açın ve talimatları takip edin</li>
<li>Ayarlar → Telefon → Arama Engelleme ve Kimliklendirme → Kalkan\'ı etkinleştirin</li>
</ol>

<h3>2. iOS Bilinmeyen Arayanları Susturma</h3>
<p>Ayarlar → Telefon → Bilinmeyen Arayanları Sustur seçeneği rehberinizde olmayan tüm numaraları sessize alır. Ancak önemli aramaları da kaçırabilirsiniz. Apple\'ın <a href="https://support.apple.com/tr-tr/guide/iphone/iphe4b3f7823/ios" target="_blank" rel="noopener">iPhone\'da aramaları engelleme rehberine</a> göz atabilirsiniz.</p>

<h3>3. Manuel Numara Engelleme</h3>
<p>Telefon uygulamasında numaranın yanındaki (i) simgesine dokunup "Bu Arayanı Engelle" seçeneğini kullanabilirsiniz.</p>

<h2>Spam Arama Engelleme İçin En Etkili Yöntem</h2>

<p>Manuel engelleme tek tek numaralar için çalışır ama sürekli farklı numaralardan gelen spam aramalar için yetersizdir. Kalkan gibi veritabanı tabanlı bir uygulama tüm bilinen spam numaraları otomatik olarak engeller.</p>

<p>Özellikle <a href="' . $home . 'dolandirici-numara-tanima/">dolandırıcı numaraları tanımak</a> ve çocukları korumak için Kalkan idealdir.</p>

<h2>Sıkça Sorulan Sorular</h2>

<h3>Spam arama engelleme ücretsiz mi?</h3>
<p>Evet. Kalkan\'ın genel koruma ve arayan kimliği özellikleri tamamen ücretsizdir.</p>

<h3>Spam arama engelleme pil tüketir mi?</h3>
<p>Hayır. Kalkan veritabanını cihaza indirdiği için arka planda sürekli çalışmaz.</p>

<h3>Engellenen numara mesaj gönderebilir mi?</h3>
<p>Kalkan\'ın engelleme sistemi aramalar için çalışır. SMS filtreleme ayrı bir iOS özelliğidir. <a href="' . $home . 'bilinmeyen-numara-kimin/">Bilinmeyen numaraları sorgulama</a> hakkında daha fazla bilgi edinin.</p>',
            'content_en' => '<p>Blocking spam calls is one of the most needed features for iPhone users today. Scam calls, unwanted sales calls, and harassing numbers negatively affect daily life.</p>

<h2>How to Block Spam Calls on iPhone</h2>

<p>iOS offers built-in features for spam call blocking. However, for the most comprehensive protection, we recommend using <a href="' . $home . '">Kalkan app</a>.</p>

<h3>1. Automatic Spam Blocking with Kalkan</h3>
<p>Kalkan integrates with iOS Call Blocking and Identification system. It loads a database of thousands of known spam numbers to your device. Protection works completely offline.</p>

<h3>2. Silence Unknown Callers</h3>
<p>Settings → Phone → Silence Unknown Callers silences all numbers not in your contacts, but may cause you to miss important calls.</p>

<h3>3. Manual Blocking</h3>
<p>Tap (i) next to a number in Phone app and select "Block this Caller."</p>

<h2>Most Effective Spam Blocking Method</h2>
<p>Manual blocking works for individual numbers but is insufficient for spam from constantly changing numbers. A database-based app like Kalkan automatically blocks all known spam numbers.</p>',
        ),

        // POST 2: Numara sorgulama
        array(
            'title' => 'Numara Sorgulama – Ücretsiz Yöntemler',
            'slug' => 'numara-sorgulama-rehberi',
            'category' => $cat_numara,
            'focus_keyword' => 'numara sorgulama',
            'seo_title' => 'Numara Sorgulama – Kalkan',
            'seo_desc' => 'Bilinmeyen numarayı ücretsiz sorgulama yöntemleri. Google, Kalkan uygulaması ve diğer araçlarla numara kime ait öğrenin.',
            'en_title' => 'Number Lookup – Free Methods',
            'content_tr' => '<p>Numara sorgulama, bilinmeyen bir numaranın kime ait olduğunu öğrenmenin en hızlı yoludur. Telefonunuza gelen tanımadığınız aramaları sorgulamak için birkaç ücretsiz yöntem bulunmaktadır.</p>

<h2>Ücretsiz Numara Sorgulama Yöntemleri</h2>

<h3>1. Kalkan ile Otomatik Numara Sorgulama</h3>
<p><a href="' . $home . '">Kalkan uygulaması</a> gelen aramalarda otomatik olarak numara hakkında bilgi gösterir. Numara spam veritabanında varsa "Spam" olarak işaretlenir. Uygulama ücretsiz ve çevrimdışı çalışır.</p>

<h3>2. Google ile Numara Sorgulama</h3>
<p>Numarayı <a href="https://www.google.com" target="_blank" rel="noopener">Google</a>\'a yazın. İşletme numaraları genellikle sonuçlarda görünür. Tırnak içinde aratmak ("05XX XXX XX XX") daha kesin sonuçlar verir.</p>

<h3>3. Şikayet Siteleri</h3>
<p>sikayetvar.com gibi platformlarda numarayı aratarak başkalarının deneyimlerini okuyabilirsiniz. Özellikle <a href="' . $home . 'dolandirici-numara-tanima/">dolandırıcı numaraları</a> tanımak için faydalıdır.</p>

<h2>Numara Sorgulama İçin En İyi Araç</h2>

<p>Tek seferlik sorgular için Google yeterlidir. Ancak sürekli bilinmeyen numaralardan aranıyorsanız, Kalkan arayan kimliği özelliği ile aramaları otomatik olarak tanımlar.</p>

<h2>Sıkça Sorulan Sorular</h2>

<h3>Numara sorgulama ücretsiz mi?</h3>
<p>Evet. Google araması ve Kalkan uygulamasının arayan kimliği özelliği tamamen ücretsizdir.</p>

<h3>Gizli numarayı sorgulayabilir miyim?</h3>
<p>Hayır. Numarasını gizleyerek arayan kişinin numarası görünmediği için sorgulama yapılamaz. <a href="' . $home . 'spam-arama-engelleme/">Spam aramaları engelleme</a> yöntemlerini inceleyebilirsiniz.</p>',
            'content_en' => '<p>Number lookup is the fastest way to find out who an unknown number belongs to. There are several free methods to look up unfamiliar calls.</p>

<h2>Free Number Lookup Methods</h2>

<h3>1. Automatic Lookup with Kalkan</h3>
<p><a href="' . $home . '">Kalkan app</a> automatically shows information about incoming calls. If the number is in the spam database, it gets flagged. Free and works offline.</p>

<h3>2. Google Search</h3>
<p>Type the number into Google. Business numbers usually appear in results.</p>

<h3>3. Complaint Websites</h3>
<p>Search the number on complaint platforms to read others\' experiences.</p>

<h2>Best Tool for Number Lookup</h2>
<p>For one-time lookups, Google works. For ongoing unknown calls, Kalkan automatically identifies them with its caller ID feature.</p>',
        ),

        // POST 3: Dolandırıcı numara tanıma
        array(
            'title' => 'Dolandırıcı Numaraları Nasıl Tanırsınız?',
            'slug' => 'dolandirici-numara-tanima',
            'category' => $cat_guvenlik,
            'focus_keyword' => 'dolandırıcı numara',
            'seo_title' => 'Dolandırıcı Numara Tanıma – Kalkan',
            'seo_desc' => 'Telefon dolandırıcılığı numaralarını tanımanın yolları. Dolandırıcıların yaygın yöntemleri ve Kalkan ile korunma ipuçları.',
            'en_title' => 'How to Recognize Scam Phone Numbers',
            'content_tr' => '<p>Dolandırıcı numara tanıma, kendinizi ve ailenizi telefon dolandırıcılığından korumanın ilk adımıdır. Türkiye\'de telefon dolandırıcılığı ciddi bir sorun haline gelmiştir.</p>

<h2>Dolandırıcı Numara Belirtileri</h2>

<h3>1. Aciliyet Yaratma</h3>
<p>"Hesabınız kapatılacak", "Son dakika" gibi panik ifadeleri dolandırıcılığın en yaygın işaretidir. Gerçek kurumlar sizi telefonla arayıp acil işlem yapmanızı istemez. <a href="https://www.btk.gov.tr/ihbar-merkezi" target="_blank" rel="noopener">BTK İhbar Merkezi</a> üzerinden şüpheli numaraları bildirebilirsiniz.</p>

<h3>2. Kişisel Bilgi İsteme</h3>
<p>TC kimlik, banka kartı bilgileri veya SMS kodu isteyen aramalar kesinlikle dolandırıcılıktır. Hiçbir banka bu bilgileri telefonla istemez.</p>

<h3>3. Yabancı veya Garip Numaralar</h3>
<p>+1, +44 gibi yabancı kodlarla gelen aramalar, çok kısa süren aramalar (wangiri dolandırıcılığı) şüphelidir.</p>

<h2>Dolandırıcı Numaralardan Korunma Yolları</h2>

<ul>
<li>Bilinmeyen aramalarda kişisel bilgi paylaşmayın</li>
<li><a href="' . $home . 'numara-sorgulama-rehberi/">Şüpheli numarayı sorgulayın</a></li>
<li><a href="' . $home . '">Kalkan uygulamasını</a> kullanın — dolandırıcı numaraları otomatik işaretler</li>
<li>Yaşlı aile üyelerinizi bilgilendirin — dolandırıcılar özellikle yaşlıları hedef alır</li>
</ul>

<h2>Sıkça Sorulan Sorular</h2>

<h3>Dolandırıcı numarayı nereye şikayet edebilirim?</h3>
<p>BTK ihbar hattı 137\'yi arayabilir veya Kalkan üzerinden numarayı bildirebilirsiniz.</p>

<h3>Dolandırıcı aramayı açarsam ne olur?</h3>
<p>Açmak tek başına tehlikeli değildir. Tehlike kişisel bilgi paylaşımında başlar. <a href="' . $home . 'spam-arama-engelleme/">Spam aramaları engellemeyi</a> öğrenin.</p>',
            'content_en' => '<p>Recognizing scam numbers is the first step to protecting yourself and your family from phone fraud.</p>

<h2>Signs of a Scam Number</h2>

<h3>1. Creating Urgency</h3>
<p>Phrases like "Your account will be closed" are the most common sign. Real institutions never demand urgent phone action.</p>

<h3>2. Requesting Personal Information</h3>
<p>Calls asking for ID numbers, card details, or SMS codes are always scams.</p>

<h3>3. Foreign or Strange Numbers</h3>
<p>Calls from foreign area codes or very short calls (wangiri fraud) are suspicious.</p>

<h2>How to Protect Against Scam Numbers</h2>
<ul>
<li>Never share personal information on unknown calls</li>
<li><a href="' . $home . 'numara-sorgulama-rehberi/">Look up suspicious numbers</a></li>
<li>Use <a href="' . $home . '">Kalkan app</a> — it automatically flags scam numbers</li>
<li>Inform elderly family members — scammers especially target them</li>
</ul>',
        ),

        // POST 4: Bilinmeyen numara kimin
        array(
            'title' => 'Bilinmeyen Numara Kimin? Nasıl Öğrenilir',
            'slug' => 'bilinmeyen-numara-kimin',
            'category' => $cat_numara,
            'focus_keyword' => 'bilinmeyen numara kimin',
            'seo_title' => 'Bilinmeyen Numara Kimin – Kalkan',
            'seo_desc' => 'Bilinmeyen bir numara mı aradı? Bu numaranın kime ait olduğunu öğrenin ve spam aramaları Kalkan ile engelleyin.',
            'en_title' => 'Who Is This Unknown Number? How to Find Out',
            'content_tr' => '<p>Bilinmeyen numara kimin diye merak etmek herkesin başına gelir. Cevapsız bir arama veya tanımadığınız bir numara gördüğünüzde arayanın kim olduğunu öğrenmek istemeniz doğaldır.</p>

<h2>Bilinmeyen Numara Kimin — Öğrenme Yolları</h2>

<h3>1. Kalkan Arayan Kimliği</h3>
<p><a href="' . $home . '">Kalkan uygulaması</a> arama geldiği anda bilinmeyen numara hakkında bilgi gösterir. Numara spam veritabanında varsa otomatik olarak işaretlenir. Telefonu açmadan kimin aradığını anlayabilirsiniz.</p>

<h3>2. Google\'da Aratın</h3>
<p>Numarayı Google\'a yazın. "05XX XXX XX XX spam" şeklinde aratmak daha iyi sonuç verir. Apple\'ın <a href="https://support.apple.com/tr-tr/guide/iphone/iphe4b3f7823/ios" target="_blank" rel="noopener">arama engelleme rehberi</a> de faydalı bilgiler içerir.</p>

<h3>3. WhatsApp Kontrolü</h3>
<p>Numarayı rehberinize ekleyip WhatsApp\'ta profil fotoğrafını kontrol edebilirsiniz.</p>

<h2>Bilinmeyen Numaralardan Korunma</h2>

<p>Bilinmeyen numara kimin olduğunu öğrenmek yetmez — kendinizi de korumalısınız. <a href="' . $home . 'spam-arama-engelleme/">Spam arama engelleme rehberimizi</a> okuyarak sürekli koruma altına girebilirsiniz.</p>

<p>Özellikle çocuklar ve yaşlılar bilinmeyen numaralardan gelen aramalara karşı savunmasızdır. Kalkan\'ı aile üyelerinin telefonlarına kurarak onları koruyabilirsiniz.</p>

<h2>Sıkça Sorulan Sorular</h2>

<h3>Bilinmeyen numara kimin olduğunu Kalkan gösterir mi?</h3>
<p>Kalkan, numaranın spam veya dolandırıcı olarak tanınıp tanınmadığını gösterir. Kişisel rehber bilgilerine erişmez.</p>

<h3>Gizli numarayı öğrenebilir miyim?</h3>
<p>Numara gizleme ile arayan kişinin numarasını öğrenmek mümkün değildir. <a href="' . $home . 'dolandirici-numara-tanima/">Dolandırıcı numaraları tanıma</a> rehberimize göz atın.</p>

<h3>+90 ile başlayan numara nereden arıyor?</h3>
<p>+90 Türkiye ülke kodudur. Yurt içinden yapılan aramalar +90 ile başlar.</p>',
            'content_en' => '<p>Wondering who an unknown number belongs to is something everyone experiences. When you see a missed call from an unfamiliar number, wanting to find out who called is natural.</p>

<h2>How to Find Out Who an Unknown Number Belongs To</h2>

<h3>1. Kalkan Caller ID</h3>
<p><a href="' . $home . '">Kalkan app</a> shows information about unknown numbers when a call comes in. If the number is in the spam database, it gets automatically flagged.</p>

<h3>2. Google Search</h3>
<p>Type the number into Google for quick results.</p>

<h3>3. WhatsApp Check</h3>
<p>Add the number to your contacts and check their WhatsApp profile.</p>

<h2>Protecting Against Unknown Numbers</h2>
<p>Finding out who a number belongs to is not enough — you should also protect yourself. Read our <a href="' . $home . 'spam-arama-engelleme/">spam call blocking guide</a> for ongoing protection.</p>',
        ),

        // POST 5: Sürekli arayan numara engelleme
        array(
            'title' => 'Sürekli Arayan Numarayı Engelleme Yöntemleri',
            'slug' => 'surekli-arayan-numara-engelleme',
            'category' => $cat_spam,
            'focus_keyword' => 'sürekli arayan numara engelleme',
            'seo_title' => 'Sürekli Arayan Numara Engelleme – Kalkan',
            'seo_desc' => 'Sürekli arayan rahatsız edici numaraları iPhone\'da engellemenin en kolay yolları. Kalkan ile otomatik koruma.',
            'en_title' => 'How to Block Numbers That Keep Calling',
            'content_tr' => '<p>Sürekli arayan numara engelleme, iPhone kullanıcılarının sık karşılaştığı bir ihtiyaçtır. Aynı numaradan veya benzer numaralardan tekrar tekrar gelen aramalar ciddi rahatsızlık verir.</p>

<h2>Sürekli Arayan Numara Engelleme Yöntemleri</h2>

<h3>1. Kalkan ile Otomatik Engelleme</h3>
<p><a href="' . $home . '">Kalkan uygulaması</a> bilinen spam numaraların veritabanını cihazınıza yükler. Sürekli arayan spam numaralar otomatik olarak engellenir. Ekstra Koruma özelliği ile benzer numara kalıpları da engellenir.</p>

<h3>2. iPhone Manuel Engelleme</h3>
<p>Telefon uygulamasında numaranın yanındaki (i) → "Bu Arayanı Engelle" seçeneğini kullanın. Bu yöntem tek bir numara için çalışır.</p>

<h3>3. Rahatsız Etmeyin Modu</h3>
<p>Ayarlar → Odaklanma → Rahatsız Etmeyin ile sadece rehberinizdeki kişilerin aramasına izin verebilirsiniz. Apple\'ın <a href="https://support.apple.com/tr-tr/guide/iphone/iphd6288a67e/ios" target="_blank" rel="noopener">Odaklanma modu rehberine</a> göz atın.</p>

<h2>Sürekli Arayan Numara Engelleme İçin En İyi Çözüm</h2>

<p>Tek bir numarayı engellemek kolaydır ama spam arayanlar sürekli numara değiştirir. Bu yüzden Kalkan gibi veritabanı tabanlı bir uygulama en etkili çözümdür. <a href="' . $home . 'numara-sorgulama-rehberi/">Numarayı sorgulayarak</a> kimin aradığını da öğrenebilirsiniz.</p>

<h2>Sıkça Sorulan Sorular</h2>

<h3>Engellediğim numara beni tekrar arayabilir mi?</h3>
<p>iPhone\'da engellediğiniz numara sizi arayamaz. Ancak aynı kişi farklı numaradan arayabilir — bu yüzden <a href="' . $home . 'spam-arama-engelleme/">kapsamlı spam engelleme</a> gerekir.</p>

<h3>Kalkan internet olmadan çalışır mı?</h3>
<p>Evet. Tüm koruma çevrimdışı olarak gerçekleşir.</p>',
            'content_en' => '<p>Blocking numbers that keep calling is a common need for iPhone users. Repeated calls from the same or similar numbers cause serious disturbance.</p>

<h2>Methods to Block Persistent Callers</h2>

<h3>1. Automatic Blocking with Kalkan</h3>
<p><a href="' . $home . '">Kalkan app</a> loads a database of known spam numbers. Persistent spam callers are automatically blocked. Extra Protection also blocks similar number patterns.</p>

<h3>2. iPhone Manual Blocking</h3>
<p>Tap (i) next to the number → "Block this Caller." Works for individual numbers.</p>

<h3>3. Do Not Disturb Mode</h3>
<p>Settings → Focus → Do Not Disturb allows calls only from contacts.</p>

<h2>Best Solution for Persistent Callers</h2>
<p>Blocking one number is easy but spammers change numbers constantly. A database-based app like Kalkan is the most effective solution.</p>',
        ),

        // POST 6: Kalkan uygulaması yayında
        array(
            'title' => 'Kalkan Uygulaması Yayında – Spam Aramalara Son',
            'slug' => 'kalkan-uygulamasi-yayinda',
            'category' => $cat_uygulama,
            'focus_keyword' => 'kalkan uygulaması',
            'seo_title' => 'Kalkan Uygulaması Yayında – Kalkan',
            'seo_desc' => 'Kalkan iOS uygulaması yayında. Spam aramaları engelleyin, bilinmeyen numaraları tanıyın. Çocuklar ve yaşlılar için ideal koruma.',
            'en_title' => 'Kalkan App Is Live – Say Goodbye to Spam Calls',
            'content_tr' => '<p>Kalkan uygulaması artık App Store\'da! iOS kullanıcıları için geliştirilen Kalkan, spam aramaları engelleyen ve bilinmeyen numaraları tanımlayan ücretsiz bir uygulamadır.</p>

<h2>Kalkan Uygulaması Nedir?</h2>

<p>Kalkan, bilinen spam numaraların kapsamlı veritabanını iPhone\'unuza yükleyerek istenmeyen aramaları otomatik olarak engeller. Tüm koruma cihaz üzerinde gerçekleşir — internet gerekmez, rehberinize erişmez. Apple\'ın <a href="https://developer.apple.com/documentation/callkit/cxcalldirectoryextensioncontext" target="_blank" rel="noopener">Call Directory Extension</a> teknolojisini kullanır.</p>

<h2>Kalkan Uygulaması Kimin İçin?</h2>

<p>Kalkan özellikle şu gruplar için geliştirilmiştir:</p>

<ul>
<li><strong>Çocuklar</strong> — Bilinmeyen ve şüpheli numaralardan gelen aramalara karşı koruma</li>
<li><strong>Yaşlılar</strong> — <a href="' . $home . 'dolandirici-numara-tanima/">Dolandırıcılık aramalarını</a> tanımlayarak güvenli arama deneyimi</li>
<li><strong>Herkes</strong> — <a href="' . $home . 'spam-arama-engelleme/">Spam aramaların</a> yarattığı rahatsızlığı minimize etme</li>
</ul>

<h2>Kalkan Uygulaması Özellikleri</h2>

<ul>
<li><strong>Spam Koruması</strong> — Bilinen spam numaralar otomatik engellenir</li>
<li><strong>Arayan Kimliği</strong> — <a href="' . $home . 'bilinmeyen-numara-kimin/">Bilinmeyen numaralar</a> hakkında bilgi gösterir</li>
<li><strong>Ekstra Koruma</strong> — Genişletilmiş numara kalıplarını engeller</li>
<li><strong>İletişim Bildirimi</strong> — Şüpheli numaraları kolayca bildirin</li>
</ul>

<h2>Hemen İndirin</h2>

<p>Kalkan şu anda App Store\'da ücretsiz. <a href="https://apple.co/4cYKmRG">Hemen indirerek</a> kendinizi ve sevdiklerinizi spam aramalardan koruyun.</p>',
            'content_en' => '<p>Kalkan app is now available on the App Store! Developed for iOS users, Kalkan is a free app that blocks spam calls and identifies unknown numbers.</p>

<h2>What Is Kalkan App?</h2>
<p>Kalkan loads a comprehensive database of known spam numbers to your iPhone, automatically blocking unwanted calls. All protection happens on-device — no internet needed, no access to your contacts.</p>

<h2>Who Is Kalkan For?</h2>
<ul>
<li><strong>Children</strong> — Protection against calls from unknown and suspicious numbers</li>
<li><strong>Elderly</strong> — Identifies <a href="' . $home . 'dolandirici-numara-tanima/">fraud calls</a> for a safer calling experience</li>
<li><strong>Everyone</strong> — Minimizes disturbance from <a href="' . $home . 'spam-arama-engelleme/">spam calls</a></li>
</ul>

<h2>Download Now</h2>
<p>Kalkan is currently free on the App Store. <a href="https://apple.co/4cYKmRG">Download now</a> to protect yourself and your loved ones.</p>',
        ),
    );

    // Delete ALL existing posts first (clean slate).
    $existing = get_posts(array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'post_status' => array('publish', 'draft', 'trash'),
    ));
    foreach ($existing as $p) {
        wp_delete_post($p->ID, true);
    }

    // Create new posts.
    foreach ($posts_data as $post_data) {
        $post_id = wp_insert_post(array(
            'post_title' => $post_data['title'],
            'post_content' => $post_data['content_tr'],
            'post_name' => $post_data['slug'],
            'post_status' => 'publish',
            'post_type' => 'post',
            'post_category' => array($post_data['category']),
        ));

        if ($post_id && !is_wp_error($post_id)) {
            update_post_meta($post_id, '_kalkan_content_en', $post_data['content_en']);
            update_post_meta($post_id, '_kalkan_title_en', $post_data['en_title']);
            update_post_meta($post_id, '_seopress_titles_title', $post_data['seo_title']);
            update_post_meta($post_id, '_seopress_titles_desc', $post_data['seo_desc']);
            update_post_meta($post_id, '_seopress_analysis_target_kw', $post_data['focus_keyword']);
            update_post_meta($post_id, '_seopress_social_fb_title', $post_data['seo_title']);
            update_post_meta($post_id, '_seopress_social_fb_desc', $post_data['seo_desc']);
            update_post_meta($post_id, '_seopress_social_fb_img', get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png');
            update_post_meta($post_id, '_seopress_social_twitter_title', $post_data['seo_title']);
            update_post_meta($post_id, '_seopress_social_twitter_desc', $post_data['seo_desc']);
            update_post_meta($post_id, '_seopress_social_twitter_img', get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png');

            if (function_exists('pll_set_post_language')) {
                pll_set_post_language($post_id, 'tr');
            }
        }
    }

    update_option('kalkan_seo_posts_v4', true);
}
add_action('init', 'kalkan_seo_optimized_posts', 20);

/**
 * Set homepage SEOPress meta.
 */
function kalkan_set_homepage_seo() {
    if (get_option('kalkan_homepage_seo_set')) return;

    $front_page_id = get_option('page_on_front');
    if ($front_page_id) {
        update_post_meta($front_page_id, '_seopress_titles_title', 'Kalkan – Spam Arama Engelleme ve Numara Sorgulama');
        update_post_meta($front_page_id, '_seopress_titles_desc', 'Spam aramaları engelleyin, bilinmeyen numaraları tanıyın. Kalkan ile telefonunuzu güvene alın.');
        update_post_meta($front_page_id, '_seopress_analysis_target_kw', 'spam arama engelleme');
        update_post_meta($front_page_id, '_seopress_social_fb_title', 'Kalkan – Spam Aramalara Karşı Kalkanınız');
        update_post_meta($front_page_id, '_seopress_social_fb_desc', 'iOS için spam arama engelleyici ve arayan kimliği uygulaması.');
        update_post_meta($front_page_id, '_seopress_social_fb_img', get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png');
        update_post_meta($front_page_id, '_seopress_social_twitter_title', 'Kalkan – Spam Aramalara Karşı Kalkanınız');
        update_post_meta($front_page_id, '_seopress_social_twitter_desc', 'iOS için spam arama engelleyici ve arayan kimliği uygulaması.');
        update_post_meta($front_page_id, '_seopress_social_twitter_img', get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png');
    }
    update_option('kalkan_homepage_seo_set', true);
}
add_action('init', 'kalkan_set_homepage_seo', 25);

/**
 * Serve llms.txt at site root for AI platform crawlers.
 */
add_action('init', 'kalkan_serve_llms_txt');
function kalkan_serve_llms_txt() {
    if (!isset($_SERVER['REQUEST_URI'])) return;
    $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    if ($path === 'llms.txt' || $path === 'llms-full.txt') {
        $file = get_stylesheet_directory() . '/' . $path;
        if (file_exists($file)) {
            header('Content-Type: text/plain; charset=utf-8');
            header('Cache-Control: public, max-age=86400');
            readfile($file);
            exit;
        }
    }
}

/**
 * Add FAQ Schema (JSON-LD) to single blog posts.
 */
add_action('wp_head', 'kalkan_faq_schema_blog');
function kalkan_faq_schema_blog() {
    if (!is_singular('post')) return;

    $lang = function_exists('pll_current_language') ? pll_current_language('slug') : 'tr';
    if (!$lang) {
        $lang = 'tr';
    }

    $content = '';
    if ($lang === 'en') {
        $content = get_post_meta(get_the_ID(), '_kalkan_content_en', true);
    }
    if (empty($content)) {
        $content = get_the_content();
    }

    preg_match_all('/<h3[^>]*>(.*?)<\/h3>\s*<p>(.*?)<\/p>/s', $content, $matches);

    if (empty($matches[1])) return;

    $faq_items = array();
    foreach ($matches[1] as $i => $question) {
        $answer = isset($matches[2][$i]) ? $matches[2][$i] : '';
        if ($question && $answer) {
            $faq_items[] = array(
                '@type' => 'Question',
                'name' => wp_strip_all_tags($question),
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text' => wp_strip_all_tags($answer),
                ),
            );
        }
    }

    if (empty($faq_items)) return;

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $faq_items,
    );

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";
}

/**
 * Customize robots.txt to allow AI crawlers.
 */
add_filter('robots_txt', 'kalkan_custom_robots_txt', 10, 2);
function kalkan_custom_robots_txt($output, $public) {
    $custom  = "User-agent: *\n";
    $custom .= "Allow: /\n";
    $custom .= "Disallow: /wp-admin/\n";
    $custom .= "Allow: /wp-admin/admin-ajax.php\n\n";

    $custom .= "User-agent: GPTBot\nAllow: /\n\n";
    $custom .= "User-agent: OAI-SearchBot\nAllow: /\n\n";
    $custom .= "User-agent: ChatGPT-User\nAllow: /\n\n";
    $custom .= "User-agent: Google-Extended\nAllow: /\n\n";
    $custom .= "User-agent: PerplexityBot\nAllow: /\n\n";
    $custom .= "User-agent: ClaudeBot\nAllow: /\n\n";
    $custom .= "User-agent: anthropic-ai\nAllow: /\n\n";
    $custom .= "User-agent: Amazonbot\nAllow: /\n\n";
    $custom .= "User-agent: Bytespider\nAllow: /\n\n";
    $custom .= "User-agent: Applebot\nAllow: /\n\n";

    $custom .= "Sitemap: " . home_url('/sitemap.xml') . "\n";

    return $custom;
}

/**
 * Create info pages (Kalkan Nedir, Nasıl Çalışır, Nasıl Kullanılır) with correct slugs and templates.
 */
function kalkan_create_info_pages() {
    if (get_option('kalkan_info_pages_created_v1')) return;

    $pages = array(
        array(
            'title'    => 'Kalkan Nedir?',
            'slug'     => 'kalkan-nedir',
            'template' => 'kalkan-nedir.php',
            'seo_title' => 'Kalkan Nedir? | Spam Arama Engelleme ve Numara Tanıma Uygulaması',
            'seo_desc'  => 'Kalkan, iPhone kullanıcıları için geliştirilmiş spam arama engelleme ve numara tanıma uygulamasıdır. Ücretsiz, çevrimdışı koruma.',
            'en_title'  => 'What is Kalkan? | Spam Call Blocking and Caller ID App',
        ),
        array(
            'title'    => 'Kalkan Nasıl Çalışır?',
            'slug'     => 'kalkan-nasil-calisir',
            'template' => 'kalkan-nasil-calisir.php',
            'seo_title' => 'Kalkan Nasıl Çalışır? | iOS Arama Engelleme Sistemi',
            'seo_desc'  => 'Kalkan uygulamasının teknik çalışma prensibi. Call Directory ve Communication Reporting entegrasyonu.',
            'en_title'  => 'How Does Kalkan Work? | iOS Call Blocking System',
        ),
        array(
            'title'    => 'Kalkan Nasıl Kullanılır?',
            'slug'     => 'kalkan-nasil-kullanilir',
            'template' => 'kalkan-nasil-kullanilir.php',
            'seo_title' => 'Kalkan Nasıl Kullanılır? | Adım Adım Kurulum Rehberi',
            'seo_desc'  => 'Kalkan uygulamasını iPhone\'a kurmak ve kullanmak için adım adım rehber. Arama engelleme ve bildirme.',
            'en_title'  => 'How to Use Kalkan? | Step-by-Step Setup Guide',
        ),
    );

    foreach ($pages as $page_data) {
        // Check if page already exists.
        $existing = get_page_by_path($page_data['slug']);
        if ($existing) continue;

        $page_id = wp_insert_post(array(
            'post_title'  => $page_data['title'],
            'post_name'   => $page_data['slug'],
            'post_status' => 'publish',
            'post_type'   => 'page',
            'post_content' => '',
        ));

        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', $page_data['template']);

            // SEOPress meta.
            update_post_meta($page_id, '_seopress_titles_title', $page_data['seo_title']);
            update_post_meta($page_id, '_seopress_titles_desc', $page_data['seo_desc']);
            update_post_meta($page_id, '_seopress_social_fb_title', $page_data['seo_title']);
            update_post_meta($page_id, '_seopress_social_fb_desc', $page_data['seo_desc']);
            update_post_meta($page_id, '_seopress_social_fb_img', get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png');

            // English title for bilingual display.
            update_post_meta($page_id, '_kalkan_title_en', $page_data['en_title']);

            // Set Polylang language.
            if (function_exists('pll_set_post_language')) {
                pll_set_post_language($page_id, 'tr');
            }
        }
    }

    update_option('kalkan_info_pages_created_v1', true);
}
add_action('init', 'kalkan_create_info_pages', 15);

/**
 * Ensure info pages have correct template assigned (repair after rename).
 */
function kalkan_fix_info_page_templates() {
    if (get_option('kalkan_info_templates_fixed_v1')) return;

    $map = array(
        'kalkan-nedir'            => 'kalkan-nedir.php',
        'kalkan-nasil-calisir'    => 'kalkan-nasil-calisir.php',
        'kalkan-nasil-kullanilir' => 'kalkan-nasil-kullanilir.php',
    );

    foreach ($map as $slug => $template) {
        $page = get_page_by_path($slug);
        if ($page) {
            update_post_meta($page->ID, '_wp_page_template', $template);
        }
    }

    update_option('kalkan_info_templates_fixed_v1', true);
}
add_action('init', 'kalkan_fix_info_page_templates', 16);

/**
 * SEOPress fixes — taxonomy meta, RSS excerpt, posts per page.
 */
function kalkan_seopress_fixes() {
    if (get_option('kalkan_seopress_fixes_v1')) return;

    // 1. Set global meta title & description for "language" taxonomy (Polylang).
    $seopress_titles = get_option('seopress_titles_option_name', array());

    if (!isset($seopress_titles['seopress_titles_tax_titles'])) {
        $seopress_titles['seopress_titles_tax_titles'] = array();
    }
    $seopress_titles['seopress_titles_tax_titles']['language'] = array(
        'title' => 'Kalkan – %%term_title%% %%sep%% %%sitetitle%%',
        'description' => 'Kalkan uygulaması içerikleri: %%term_title%%.',
    );

    update_option('seopress_titles_option_name', $seopress_titles);

    // 2. RSS feed: show summary instead of full text.
    update_option('rss_use_excerpt', 1);

    // 3. Show more posts per page (default 10 → 20).
    update_option('posts_per_page', 20);

    update_option('kalkan_seopress_fixes_v1', true);
}
add_action('init', 'kalkan_seopress_fixes', 30);

/**
 * Anti-spam: disable comments site-wide.
 * Kalkan is a marketing site — no need for comments on any post/page.
 */

// Remove comment support from all post types.
add_action('init', function () {
    remove_post_type_support('post', 'comments');
    remove_post_type_support('post', 'trackbacks');
    remove_post_type_support('page', 'comments');
    remove_post_type_support('page', 'trackbacks');
}, 100);

// Close comments on the front-end.
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments.
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments from admin menu and admin bar.
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});
add_action('admin_bar_menu', function ($wp_admin_bar) {
    $wp_admin_bar->remove_node('comments');
}, 999);

// Disable comments feed.
add_action('template_redirect', function () {
    if (is_comment_feed()) {
        wp_safe_redirect(home_url('/'), 301);
        exit;
    }
});

// Remove X-Pingback header.
add_filter('wp_headers', function ($headers) {
    unset($headers['X-Pingback']);
    return $headers;
});

// Disable XML-RPC (common spam vector).
add_filter('xmlrpc_enabled', '__return_false');
