<?php
/**
 * Kalkan Child Theme functions.
 *
 * Extend this file conservatively and keep logic simple.
 */

if (!defined('ABSPATH')) {
    exit;
}

// Serve SEOPress sitemap index at /sitemap.xml (no redirect).
// Rewrite REQUEST_URI early so WordPress & SEOPress see /sitemaps.xml internally,
// but the public URL remains /sitemap.xml.
if (isset($_SERVER['REQUEST_URI']) && preg_match('#^/sitemap\.xml(\?.*)?$#', $_SERVER['REQUEST_URI'])) {
    $_SERVER['REQUEST_URI'] = '/sitemaps.xml' . (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? '?' . $_SERVER['QUERY_STRING'] : '');
    // Prevent canonical redirect from sending users to /sitemaps.xml.
    add_filter('redirect_canonical', '__return_false');
    add_filter('wp_redirect', function ($location) {
        if (strpos($location, '/sitemaps.xml') !== false) {
            return false;
        }
        return $location;
    }, 1);
}

// One-time: write app-ads.txt to public_html root and minefinder subdomain.
add_action('init', function () {
    $content = "google.com, pub-2459893282569161, DIRECT, f08c47fec0942fa0\n";

    // Main domain
    $main = ABSPATH . 'app-ads.txt';
    if ( ! file_exists($main) ) {
        file_put_contents($main, $content);
    }

    // Minefinder subdomain — try common cPanel subdomain paths
    $base = dirname(ABSPATH); // /home/matur124
    $candidates = [
        $base . '/minefinder.kalkan.website/app-ads.txt',
        $base . '/public_html/minefinder/app-ads.txt',
        $base . '/minefinder/app-ads.txt',
    ];
    foreach ($candidates as $path) {
        $dir = dirname($path);
        if ( is_dir($dir) && ! file_exists($path) ) {
            file_put_contents($path, $content);
        }
    }
});

/* ── Search discovery: IndexNow ─────────────────────────────────────────── */

/**
 * Public IndexNow verification key. IndexNow requires this value to be
 * reachable from the site root; it is not a secret credential.
 */
define('KALKAN_INDEXNOW_KEY', 'b7f24d92a16d44b98409f03241071d62');

/**
 * Keep the IndexNow key file available at the public site root.
 */
function kalkan_indexnow_ensure_key_file() {
    $path    = ABSPATH . KALKAN_INDEXNOW_KEY . '.txt';
    $content = KALKAN_INDEXNOW_KEY . "\n";

    if (!file_exists($path) || file_get_contents($path) !== $content) {
        file_put_contents($path, $content, LOCK_EX);
    }
}
add_action('init', 'kalkan_indexnow_ensure_key_file');

/**
 * Submit one public canonical URL to IndexNow after a real publish/update.
 */
function kalkan_indexnow_submit_url($post_id, $post, $update) {
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        return;
    }

    if (!$post || 'publish' !== $post->post_status || !is_post_type_viewable($post->post_type)) {
        return;
    }

    $url = get_permalink($post_id);
    if (!$url || wp_parse_url($url, PHP_URL_HOST) !== wp_parse_url(home_url('/'), PHP_URL_HOST)) {
        return;
    }

    wp_remote_post(
        'https://api.indexnow.org/indexnow',
        array(
            'timeout'  => 5,
            'blocking' => false,
            'headers'  => array('Content-Type' => 'application/json; charset=utf-8'),
            'body'     => wp_json_encode(
                array(
                    'host'        => wp_parse_url(home_url('/'), PHP_URL_HOST),
                    'key'         => KALKAN_INDEXNOW_KEY,
                    'keyLocation' => home_url('/' . KALKAN_INDEXNOW_KEY . '.txt'),
                    'urlList'     => array($url),
                )
            ),
        )
    );
}
add_action('wp_after_insert_post', 'kalkan_indexnow_submit_url', 10, 3);

/**
 * Bing Webmaster Tools ownership verification.
 */
function kalkan_bing_webmaster_verification() {
    echo '<meta name="msvalidate.01" content="5D2ACD45126FB449B85EBFE4619DC6FA">' . "\n";
}
add_action('wp_head', 'kalkan_bing_webmaster_verification', 1);

/**
 * Keep the Yandex Webmaster verification file available at the site root.
 */
function kalkan_yandex_webmaster_verification() {
    $path = ABSPATH . 'yandex_23bc325a4706bde3.html';
    $content = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>'
        . '<body>Verification: 23bc325a4706bde3</body></html>';

    if (!file_exists($path) || file_get_contents($path) !== $content) {
        file_put_contents($path, $content, LOCK_EX);
    }
}
add_action('init', 'kalkan_yandex_webmaster_verification');

/* ── Anti-spam: honeypot + time-check helpers ─────────────────────────────── */

/**
 * Output honeypot + timestamp hidden fields for any form.
 * The honeypot field is invisible; bots fill it, humans don't.
 * The timestamp rejects submissions faster than 2 seconds.
 */
function kalkan_antispam_fields() {
    $ts = time();
    return '<div style="position:absolute;left:-9999px;top:-9999px;" aria-hidden="true">'
         . '<input type="text" name="kk_website_url" value="" tabindex="-1" autocomplete="off">'
         . '</div>'
         . '<input type="hidden" name="kk_ts" value="' . esc_attr( (string) $ts ) . '">';
}

/**
 * Validate honeypot + timestamp. Returns error message or empty string if OK.
 */
function kalkan_antispam_check() {
    // Honeypot: must be empty
    if ( ! empty( $_POST['kk_website_url'] ) ) {
        return 'spam';
    }
    // Time check: must be at least 2 seconds since form loaded
    $ts = isset( $_POST['kk_ts'] ) ? (int) $_POST['kk_ts'] : 0;
    if ( $ts > 0 && ( time() - $ts ) < 2 ) {
        return 'spam';
    }
    return '';
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
 * Shortcode: [kalkan_subscribe] — FluentCRM email subscribe form.
 * Inline form with checkbox consent, AJAX submission, no popup.
 *
 * @return string HTML output.
 */
function kalkan_subscribe_shortcode() {
    $nonce = wp_create_nonce( 'kalkan_subscribe' );
    $lang  = function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : 'tr';

    $placeholder   = 'en' === $lang ? 'Enter your email' : 'E-posta adresinizi girin';
    $btn_text      = 'en' === $lang ? 'Subscribe' : 'Abone Ol';
    $consent       = 'en' === $lang
        ? '<a href="/privacy-policy/" target="_blank">KVKK</a> ve <a href="/privacy-policy/" target="_blank">Privacy Policy</a> accept.'
        : '<a href="/kvkk/" target="_blank">KVKK</a> ve <a href="/gizlilik-politikasi/" target="_blank">Gizlilik Politikası</a>\'nı kabul ediyorum.';
    $success_msg   = 'en' === $lang ? 'You\'re subscribed!' : 'Abone oldunuz!';
    $error_msg     = 'en' === $lang ? 'Something went wrong. Please try again.' : 'Bir hata oluştu. Lütfen tekrar deneyin.';
    $consent_warn  = 'en' === $lang ? 'Please accept the privacy policy.' : 'Lütfen gizlilik politikasını kabul edin.';

    ob_start();
    ?>
    <form class="kk-subscribe-form" id="kk-subscribe-form" novalidate>
        <input type="hidden" name="kk_nonce" value="<?php echo esc_attr( $nonce ); ?>">
        <?php echo kalkan_antispam_fields(); ?>
        <div class="kk-subscribe-row">
            <input type="email" name="kk_email" class="kk-subscribe-input" placeholder="<?php echo esc_attr( $placeholder ); ?>" required autocomplete="email">
        </div>
        <label class="kk-subscribe-consent">
            <input type="checkbox" name="kk_consent" required>
            <span><?php echo wp_kses( $consent, array( 'a' => array( 'href' => array(), 'target' => array() ) ) ); ?></span>
        </label>
        <div class="kk-subscribe-btn-wrap">
            <button type="submit" class="kk-subscribe-btn"><?php echo esc_html( $btn_text ); ?></button>
        </div>
        <div class="kk-subscribe-msg" aria-live="polite"
            data-success="<?php echo esc_attr( $success_msg ); ?>"
            data-error="<?php echo esc_attr( $error_msg ); ?>"
            data-consent="<?php echo esc_attr( $consent_warn ); ?>"></div>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('kalkan_subscribe', 'kalkan_subscribe_shortcode');

/**
 * AJAX handler: subscribe email via FluentCRM.
 */
function kalkan_subscribe_ajax() {
    check_ajax_referer( 'kalkan_subscribe', 'kk_nonce' );

    if ( kalkan_antispam_check() ) {
        wp_send_json_error( array( 'message' => 'Submission rejected.' ), 403 );
    }

    $email = isset( $_POST['kk_email'] ) ? sanitize_email( $_POST['kk_email'] ) : '';
    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Invalid email address.' ), 400 );
    }

    // FluentCRM API — add or update contact.
    if ( ! function_exists( 'FluentCrmApi' ) ) {
        wp_send_json_error( array( 'message' => 'Newsletter service unavailable.' ), 500 );
    }

    $contact_api = FluentCrmApi( 'contacts' );
    $contact = $contact_api->createOrUpdate( array(
        'email'  => $email,
        'status' => 'subscribed',
    ) );

    if ( is_wp_error( $contact ) ) {
        wp_send_json_error( array( 'message' => 'Subscription failed.' ), 500 );
    }

    wp_send_json_success( array( 'message' => 'Subscribed.' ) );
}
add_action( 'wp_ajax_kalkan_subscribe', 'kalkan_subscribe_ajax' );
add_action( 'wp_ajax_nopriv_kalkan_subscribe', 'kalkan_subscribe_ajax' );

/**
 * AJAX handler: unsubscribe email via FluentCRM.
 */
function kalkan_unsubscribe_ajax() {
    check_ajax_referer( 'kalkan_unsubscribe', 'kk_nonce' );

    if ( kalkan_antispam_check() ) {
        wp_send_json_error( array( 'message' => 'Submission rejected.' ), 403 );
    }

    $email = isset( $_POST['kk_email'] ) ? sanitize_email( $_POST['kk_email'] ) : '';
    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Invalid email address.' ), 400 );
    }

    if ( ! function_exists( 'FluentCrmApi' ) ) {
        wp_send_json_error( array( 'message' => 'Newsletter service unavailable.' ), 500 );
    }

    $contact_api = FluentCrmApi( 'contacts' );
    $contact = $contact_api->getContactByUserRef( $email );

    if ( $contact ) {
        $contact->status = 'unsubscribed';
        $contact->save();
        wp_send_json_success( array( 'message' => 'Unsubscribed.' ) );
    }

    wp_send_json_error( array( 'message' => 'Email not found.' ), 404 );
}
add_action( 'wp_ajax_kalkan_unsubscribe', 'kalkan_unsubscribe_ajax' );
add_action( 'wp_ajax_nopriv_kalkan_unsubscribe', 'kalkan_unsubscribe_ajax' );

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
 * Ensure the public Updates category consumed by native Kalkan clients exists
 * independently from the original one-time SEO category setup.
 */
function kalkan_create_announcement_categories() {
    $categories = array(
        array(
            'name' => 'Duyurular',
            'slug' => 'duyurular',
            'desc' => 'Kalkan hakkında genel bilgiler, güvenlik içerikleri ve duyurular',
        ),
        array(
            'name' => 'Güncellemeler',
            'slug' => 'guncellemeler',
            'desc' => 'Kalkan sürüm notları, yeni özellikler ve uygulama güncellemeleri',
        ),
    );

    foreach ($categories as $category) {
        if (!term_exists($category['slug'], 'category')) {
            wp_insert_term(
                $category['name'],
                'category',
                array(
                    'slug'        => $category['slug'],
                    'description' => $category['desc'],
                )
            );
        }
    }
}
add_action('init', 'kalkan_create_announcement_categories', 6);

/**
 * Public, read-only feed for native Kalkan clients.
 *
 * GET /wp-json/kalkan/v1/announcements?type=general|updates&lang=tr|en
 */
function kalkan_register_announcements_endpoint() {
    register_rest_route(
        'kalkan/v1',
        '/announcements',
        array(
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => 'kalkan_get_announcements',
            'permission_callback' => '__return_true',
            'args'                => array(
                'type' => array(
                    'default'           => 'general',
                    'sanitize_callback' => 'sanitize_key',
                    'validate_callback' => static function ($value) {
                        return in_array($value, array('general', 'updates'), true);
                    },
                ),
                'lang' => array(
                    'default'           => 'tr',
                    'sanitize_callback' => 'sanitize_key',
                    'validate_callback' => static function ($value) {
                        return in_array($value, array('tr', 'en'), true);
                    },
                ),
                'page' => array(
                    'default'           => 1,
                    'sanitize_callback' => 'absint',
                    'validate_callback' => static function ($value) {
                        return (int) $value >= 1;
                    },
                ),
            ),
        )
    );
}
add_action('rest_api_init', 'kalkan_register_announcements_endpoint');

function kalkan_decode_native_text($value) {
    $decoded = (string) $value;
    for ($pass = 0; $pass < 2; $pass++) {
        $next = html_entity_decode($decoded, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if ($next === $decoded) {
            break;
        }
        $decoded = $next;
    }
    return $decoded;
}

function kalkan_get_announcements(WP_REST_Request $request) {
    if (has_action('litespeed_control_set_nocache')) {
        do_action('litespeed_control_set_nocache', 'Kalkan native announcements feed');
    }

    $type          = $request->get_param('type');
    $lang          = $request->get_param('lang');
    $page          = max(1, (int) $request->get_param('page'));
    $query_args = array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 20,
        'paged'               => $page,
        'ignore_sticky_posts' => false,
        'no_found_rows'       => false,
    );

    if ('updates' === $type) {
        $query_args['category_name'] = 'guncellemeler';
    } else {
        // Every normal published article belongs in the General native feed.
        // Updates stay in their dedicated segment even when they also carry
        // another editorial/SEO category.
        $updates_category = get_category_by_slug('guncellemeler');
        if ($updates_category instanceof WP_Term) {
            $query_args['category__not_in'] = array((int) $updates_category->term_id);
        }
    }

    $query = new WP_Query($query_args);

    $items = array();
    foreach ($query->posts as $post) {
        $title   = get_the_title($post);
        $content = apply_filters('the_content', $post->post_content);

        if ('en' === $lang) {
            $english_title   = get_post_meta($post->ID, '_kalkan_title_en', true);
            $english_content = get_post_meta($post->ID, '_kalkan_content_en', true);

            if (is_string($english_title) && '' !== trim($english_title)) {
                $title = $english_title;
            }
            if (is_string($english_content) && '' !== trim($english_content)) {
                $content = apply_filters('the_content', $english_content);
            }
        }

        $items[] = array(
            'id'             => (int) $post->ID,
            'type'           => $type,
            'title'          => kalkan_decode_native_text(wp_strip_all_tags($title)),
            'summary'        => wp_trim_words(
                kalkan_decode_native_text(wp_strip_all_tags($content)),
                34
            ),
            'content_html'   => wp_kses_post(
                kalkan_decode_native_text($content)
            ),
            'published_at'   => get_post_time(DATE_ATOM, true, $post),
            'updated_at'     => get_post_modified_time(DATE_ATOM, true, $post),
            'url'            => get_permalink($post),
            'image_url'      => get_the_post_thumbnail_url($post, 'large') ?: null,
            'app_version'    => sanitize_text_field((string) get_post_meta($post->ID, '_kalkan_app_version', true)),
            'source_name'    => sanitize_text_field((string) get_post_meta($post->ID, '_kalkan_source_name', true)),
            'source_url'     => esc_url_raw((string) get_post_meta($post->ID, '_kalkan_source_url', true)),
        );
    }

    $response = rest_ensure_response(
        array(
            'schema_version' => 1,
            'type'           => $type,
            'language'       => $lang,
            'page'           => $page,
            'total_pages'    => (int) $query->max_num_pages,
            'items'          => $items,
        )
    );
    // Native clients keep their own offline cache. Avoid serving a stale
    // WordPress/LiteSpeed response after an editor publishes an article.
    $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    $response->header('X-LiteSpeed-Cache-Control', 'no-cache');

    return $response;
}

// Force large Twitter card for better link previews on X.
add_filter('seopress_social_twitter_card', function ($card_type) {
    if (is_singular('post')) {
        return 'summary';
    }
    return 'summary_large_image';
});

/**
 * The public Duyurular route is the website's all-articles archive. Posts keep
 * their editorial categories for the app feeds and SEO, while this page lists
 * every published article.
 */
function kalkan_duyurular_archive_all_posts($query) {
    if (is_admin() || ! $query->is_main_query() || ! $query->is_category('duyurular')) {
        return;
    }

    $query->set('cat', '');
    $query->set('category_name', '');
    $query->set('category__in', array());
    $query->set('tax_query', array());
    $query->set('post_type', 'post');
    $query->set('post_status', 'publish');
}
add_action('pre_get_posts', 'kalkan_duyurular_archive_all_posts');

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
        'sameAs'    => array(
            'https://apps.apple.com/tr/app/kalkan-caller-id-block/id6759873828',
            'https://x.com/Kalkan_App',
        ),
    );
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
}

/**
 * WebSite schema — homepage only.
 *
 * Do not advertise SearchAction: this site has no search product, and the
 * placeholder target causes Google to crawl synthetic search_term_string URLs.
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
        ? 'Kalkan, iOS cihazınızda spam aramaları engeller ve bilinmeyen numaraları tanımlar. Genel Koruma ücretsizdir; Ekstra Koruma Kalkan Premium gerektirir.'
        : 'Kalkan blocks spam calls and identifies unknown numbers on your iPhone. General Protection is free; Extra Protection requires Kalkan Premium.';

    $schema = array(
        '@context'            => 'https://schema.org',
        '@type'               => 'MobileApplication',
        'name'                => 'Kalkan',
        'operatingSystem'     => 'iOS',
        'applicationCategory' => 'UtilitiesApplication',
        'description'         => $desc,
        'url'                 => 'https://kalkan.website',
        'downloadUrl'         => apply_filters('kalkan_app_store_url', 'https://apple.co/4cYKmRG'),
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
        array('Ekstra Koruma nedir?', 'Ekstra Koruma, standart spam listesinin ötesindeki genişletilmiş numara kalıplarını engelleyen Premium katmandır. Kalkan Premium şu anda yalnızca Türkiye\'de sunulur.'),
        array('Verilerim güvende mi?', 'Evet. Kalkan rehberinize veya arama geçmişinize erişmez. Tüm arama koruma işlemleri cihazınızda yerel olarak gerçekleşir.'),
        array('Kalkan ücretsiz mi?', 'Genel Koruma ve İletişim Bildirimi tamamen ücretsizdir. Yalnızca Ekstra Koruma Kalkan Premium gerektirir. Uygun yeni aboneliklerde üç aylık ücretsiz deneme App Store\'da gösterilir.'),
    );
    $faqs_en = array(
        array('How does Kalkan work?', 'Kalkan loads a database of known spam numbers to your device. It works with iOS\'s call directory system to block or flag incoming calls. No internet connection required.'),
        array('Does Kalkan do real-time call analysis?', 'No. iOS does not allow real-time call analysis. Kalkan works with a preloaded database. This is due to Apple\'s security restrictions.'),
        array('What is Extra Protection?', 'Extra Protection is the Premium layer that blocks extended number patterns beyond the standard spam list. Kalkan Premium is currently available only in Türkiye.'),
        array('Is my data safe?', 'Yes. Kalkan doesn\'t access your contacts or call history. All call protection happens locally on your device.'),
        array('Is Kalkan free?', 'General Protection and Communication Reporting are completely free. Only Extra Protection requires Kalkan Premium. A three-month free trial for eligible new subscriptions is shown on the App Store.'),
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
            'content_tr' => '<p>Kalkan uygulaması artık App Store\'da! iOS için geliştirilen Kalkan, bilinen spam aramaları engeller ve bilinmeyen numaraları tanımlar. Genel Koruma ücretsizdir; Ekstra Koruma Kalkan Premium gerektirir.</p>

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

<p><a href="https://apple.co/4cYKmRG">Kalkan\'ı indirin</a> ve ücretsiz Genel Koruma ile başlayın. Ekstra Koruma, Türkiye\'de sunulan Kalkan Premium kapsamındadır.</p>',
            'content_en' => '<p>Kalkan is now available on the App Store! Built for iOS, Kalkan blocks known spam calls and identifies unknown numbers. General Protection is free; Extra Protection requires Kalkan Premium.</p>

<h2>What Is Kalkan App?</h2>
<p>Kalkan loads a comprehensive database of known spam numbers to your iPhone, automatically blocking unwanted calls. All protection happens on-device — no internet needed, no access to your contacts.</p>

<h2>Who Is Kalkan For?</h2>
<ul>
<li><strong>Children</strong> — Protection against calls from unknown and suspicious numbers</li>
<li><strong>Elderly</strong> — Identifies <a href="' . $home . 'dolandirici-numara-tanima/">fraud calls</a> for a safer calling experience</li>
<li><strong>Everyone</strong> — Minimizes disturbance from <a href="' . $home . 'spam-arama-engelleme/">spam calls</a></li>
</ul>

<h2>Download Now</h2>
<p><a href="https://apple.co/4cYKmRG">Download Kalkan</a> and start with free General Protection. Extra Protection is included with Kalkan Premium, currently available in Türkiye.</p>',
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
            update_post_meta($post_id, '_seopress_social_twitter_title', $post_data['seo_title']);
            update_post_meta($post_id, '_seopress_social_twitter_desc', $post_data['seo_desc']);

            if (function_exists('pll_set_post_language')) {
                pll_set_post_language($post_id, 'tr');
            }
        }
    }

    update_option('kalkan_seo_posts_v4', true);
}
add_action('init', 'kalkan_seo_optimized_posts', 20);

/**
 * Expand the primary acquisition article without recreating or touching other posts.
 */
function kalkan_update_primary_growth_article() {
    if (get_option('kalkan_primary_growth_article_v1')) return;

    $post = get_page_by_path('spam-arama-engelleme', OBJECT, 'post');
    if (!$post) return;

    $home = home_url('/');
    $appstore = apply_filters('kalkan_app_store_url', 'https://apple.co/4cYKmRG');

    $content_tr = '<p>Spam aramalar; istenmeyen satış aramalarından kendisini banka, kamu kurumu veya kargo şirketi gibi tanıtan dolandırıcılara kadar farklı biçimlerde karşınıza çıkabilir. iPhone\'da bu aramaları azaltmak için yerleşik iOS seçeneklerini ve Kalkan\'ın cihaz üzerinde çalışan korumasını birlikte kullanabilirsiniz.</p>

<h2>iPhone\'da Spam Arama Engelleme Yöntemleri</h2>

<h3>1. Kalkan ile bilinen spam numaraları engelleyin</h3>
<p><a href="' . esc_url($home) . '">Kalkan</a>, bilinen spam numaraları iPhone\'unuza yükler ve iOS Arama Engelleme ve Numara Tanıma sistemiyle çalışır. Rehberiniz veya arama geçmişiniz sunucuya yüklenmez. Genel Koruma ve arayan kimliği ücretsizdir; genişletilmiş numara kalıplarını engelleyen Ekstra Koruma ise Kalkan Premium kapsamındadır.</p>

<ol>
<li><a href="' . esc_url($appstore) . '">Kalkan\'ı App Store\'dan indirin</a>.</li>
<li>Uygulamayı açın ve Genel Koruma veritabanını yükleyin.</li>
<li>Ayarlar → Uygulamalar → Telefon → Arama Engelleme ve Numara Tanıma bölümünü açın.</li>
<li>Kalkan\'ı etkinleştirin ve uygulamaya dönerek koruma durumunu kontrol edin.</li>
</ol>

<h3>2. Bilinmeyen Arayanları Sessize Al seçeneğini değerlendirin</h3>
<p>iOS, rehberinizde bulunmayan numaraları sessize alabilir. Bu seçenek spam aramaları azaltır ancak doktor, kurye veya iş görüşmesi gibi önemli aramaları da sessize alabilir. Ayrıntılar için Apple\'ın <a href="https://support.apple.com/tr-tr/guide/iphone/iphe4b3f7823/ios" target="_blank" rel="noopener">bilinmeyen arayanları yönetme rehberini</a> inceleyin.</p>

<h3>3. Tek bir numarayı manuel olarak engelleyin</h3>
<p>Telefon uygulamasında Son Aramalar\'ı açın, numaranın yanındaki bilgi düğmesine dokunun ve “Bu Arayanı Engelle” seçeneğini kullanın. Bu yöntem tek bir numara için etkilidir; sürekli değişen spam numaraları için veritabanı tabanlı koruma daha pratiktir.</p>

<h2>Arayan Kimliği ile Engelleme Arasındaki Fark</h2>
<p>Arayan kimliği, bilinen bir numaranın etiketini arama ekranında gösterir. Engelleme ise eşleşen aramanın size ulaşmasını önler. Kalkan\'ın Genel Koruma katmanı ücretsiz temel korumayı sağlar. Ekstra Koruma, daha geniş numara kalıpları için Türkiye\'de sunulan Kalkan Premium aboneliğini gerektirir.</p>

<h2>Kalkan Çalışmıyorsa Kontrol Edin</h2>
<ul>
<li>iPhone ayarlarında Kalkan uzantısının etkin olduğundan emin olun.</li>
<li>Kalkan\'ı açıp koruma veritabanını yeniden güncelleyin.</li>
<li>iOS veya Kalkan güncellemesi varsa yükleyin.</li>
<li>Yeni kötüye kullanılan numaraların henüz veritabanında bulunmayabileceğini unutmayın.</li>
</ul>

<p>Şüpheli bir arama aldıysanız numarayı Kalkan içinden veya iPhone\'un desteklediği İletişim Bildirimi akışıyla bildirebilirsiniz. Ayrıca <a href="' . esc_url($home) . 'dolandirici-numara-tanima/">dolandırıcı aramaların belirtilerini</a> ve <a href="' . esc_url($home) . 'bilinmeyen-numara-kimin/">bilinmeyen numaraları değerlendirmenin güvenli yollarını</a> inceleyebilirsiniz.</p>

<h2>Sıkça Sorulan Sorular</h2>

<h3>Spam arama engelleme ücretsiz mi?</h3>
<p>Kalkan\'ın Genel Koruma, arayan kimliği ve İletişim Bildirimi özellikleri ücretsizdir. Yalnızca Ekstra Koruma, Kalkan Premium gerektirir.</p>

<h3>Kalkan arama geçmişimi veya rehberimi yükler mi?</h3>
<p>Hayır. Arama koruması iOS\'un sistem entegrasyonu ve cihazınıza yüklenen verilerle çalışır; rehberiniz ve arama geçmişiniz Kalkan\'a yüklenmez.</p>

<h3>Kalkan bütün spam aramaları engeller mi?</h3>
<p>Hiçbir arama engelleme uygulaması yüzde yüz koruma garanti edemez. Yeni veya henüz bildirilmemiş numaralar zaman zaman size ulaşabilir.</p>';

    $content_en = '<p>Spam calls can range from unwanted sales calls to scammers pretending to represent a bank, government agency, or delivery company. On iPhone, you can reduce these calls by combining built-in iOS options with Kalkan\'s on-device protection.</p>

<h2>How to Block Spam Calls on iPhone</h2>

<h3>1. Block known spam numbers with Kalkan</h3>
<p><a href="' . esc_url($home) . '">Kalkan</a> loads known spam numbers onto your iPhone and works with iOS Call Blocking &amp; Identification. Your contacts and call history are not uploaded. General Protection and caller identification are free; Extra Protection for extended number patterns requires Kalkan Premium.</p>

<ol>
<li><a href="' . esc_url($appstore) . '">Download Kalkan from the App Store</a>.</li>
<li>Open the app and load the General Protection database.</li>
<li>Open Settings → Apps → Phone → Call Blocking &amp; Identification.</li>
<li>Enable Kalkan, return to the app, and check the protection status.</li>
</ol>

<h3>2. Consider Silence Unknown Callers</h3>
<p>iOS can silence numbers that are not in your contacts. This reduces interruptions, but it may also silence important calls from a doctor, courier, or employer. Review Apple\'s <a href="https://support.apple.com/guide/iphone/manage-unknown-callers-iph3c9947bf/ios" target="_blank" rel="noopener">unknown caller guidance</a> before enabling it.</p>

<h3>3. Manually block one number</h3>
<p>In the Phone app, open Recents, tap the information button next to the number, and choose “Block Caller.” This works well for one number; database-based protection is more practical when spam callers keep changing numbers.</p>

<h2>Caller Identification vs. Blocking</h2>
<p>Caller identification displays a known label on the incoming-call screen. Blocking prevents a matched call from reaching you. Kalkan\'s General Protection provides the free core layer. Extra Protection requires the Kalkan Premium subscription currently available in Türkiye.</p>

<h2>If Protection Does Not Appear</h2>
<ul>
<li>Confirm that the Kalkan extension is enabled in iPhone Settings.</li>
<li>Open Kalkan and update the protection database again.</li>
<li>Install available iOS and Kalkan updates.</li>
<li>Remember that a newly abused number may not be in the database yet.</li>
</ul>

<p>You can report a suspicious call from Kalkan or through the iPhone Communication Reporting flow. You can also learn how to <a href="' . esc_url($home) . 'dolandirici-numara-tanima/">recognize scam calls</a> and assess an <a href="' . esc_url($home) . 'bilinmeyen-numara-kimin/">unknown number safely</a>.</p>

<h2>Frequently Asked Questions</h2>

<h3>Is spam call blocking free?</h3>
<p>Kalkan\'s General Protection, caller identification, and Communication Reporting are free. Only Extra Protection requires Kalkan Premium.</p>

<h3>Does Kalkan upload my contacts or call history?</h3>
<p>No. Call protection uses the iOS system integration and data loaded onto your device; your contacts and call history are not uploaded to Kalkan.</p>

<h3>Does Kalkan block every spam call?</h3>
<p>No call-blocking app can guarantee complete protection. New or not-yet-reported numbers may occasionally reach you.</p>';

    $updated = wp_update_post(array(
        'ID'           => $post->ID,
        'post_content' => $content_tr,
    ), true);

    if (is_wp_error($updated)) return;

    update_post_meta($post->ID, '_kalkan_content_en', $content_en);
    update_post_meta($post->ID, '_seopress_titles_title', 'Spam Arama Engelleme – iPhone\'da Nasıl Yapılır?');
    update_post_meta($post->ID, '_seopress_titles_desc', 'iPhone\'da spam aramaları engelleme, arayan kimliği, Kalkan kurulumu ve sorun giderme adımlarını öğrenin.');

    $launch_post = get_page_by_path('kalkan-uygulamasi-yayinda', OBJECT, 'post');
    if ($launch_post) {
        $launch_tr = str_replace(
            array(
                'Kalkan uygulaması artık App Store\'da! iOS kullanıcıları için geliştirilen Kalkan, spam aramaları engelleyen ve bilinmeyen numaraları tanımlayan ücretsiz bir uygulamadır.',
                '<p>Kalkan şu anda App Store\'da ücretsiz. <a href="https://apple.co/4cYKmRG">Hemen indirerek</a> kendinizi ve sevdiklerinizi spam aramalardan koruyun.</p>',
            ),
            array(
                'Kalkan uygulaması artık App Store\'da! iOS için geliştirilen Kalkan, bilinen spam aramaları engeller ve bilinmeyen numaraları tanımlar. Genel Koruma ücretsizdir; Ekstra Koruma Kalkan Premium gerektirir.',
                '<p><a href="' . esc_url($appstore) . '">Kalkan\'ı indirin</a> ve ücretsiz Genel Koruma ile başlayın. Ekstra Koruma, Türkiye\'de sunulan Kalkan Premium kapsamındadır.</p>',
            ),
            $launch_post->post_content
        );
        wp_update_post(array('ID' => $launch_post->ID, 'post_content' => $launch_tr));

        $launch_en = get_post_meta($launch_post->ID, '_kalkan_content_en', true);
        $launch_en = str_replace(
            array(
                'Kalkan app is now available on the App Store! Developed for iOS users, Kalkan is a free app that blocks spam calls and identifies unknown numbers.',
                '<p>Kalkan is currently free on the App Store. <a href="https://apple.co/4cYKmRG">Download now</a> to protect yourself and your loved ones.</p>',
            ),
            array(
                'Kalkan is now available on the App Store! Built for iOS, Kalkan blocks known spam calls and identifies unknown numbers. General Protection is free; Extra Protection requires Kalkan Premium.',
                '<p><a href="' . esc_url($appstore) . '">Download Kalkan</a> and start with free General Protection. Extra Protection is included with Kalkan Premium, currently available in Türkiye.</p>',
            ),
            $launch_en
        );
        update_post_meta($launch_post->ID, '_kalkan_content_en', $launch_en);
    }

    update_option('kalkan_primary_growth_article_v1', true);
}
add_action('init', 'kalkan_update_primary_growth_article', 21);

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
 * Create and connect the bilingual documentation and version-history pages.
 */
function kalkan_create_product_reference_pages() {
    if (get_option('kalkan_product_reference_pages_v1')) return;

    $definitions = array(
        'documentation' => array(
            'tr' => array(
                'title' => 'Kalkan Dokümantasyonu ve SSS',
                'slug' => 'dokumantasyon',
                'template' => 'product-documentation.php',
                'seo_title' => 'Kalkan Dokümantasyonu ve SSS | Özellikler ve Teknik Çalışma',
                'seo_desc' => 'Kalkan özellikleri, Genel ve Ekstra Koruma farkı, iOS Call Directory çalışma modeli, kurulum, gizlilik, sınırlar ve sık sorulan sorular.',
            ),
            'en' => array(
                'title' => 'Kalkan Documentation and FAQ',
                'slug' => 'documentation',
                'template' => 'product-documentation.php',
                'seo_title' => 'Kalkan Documentation and FAQ | Features and Technical Operation',
                'seo_desc' => 'Kalkan features, General and Extra Protection, iOS Call Directory operation, setup, privacy, limitations and frequently asked questions.',
            ),
        ),
        'version_history' => array(
            'tr' => array(
                'title' => 'Kalkan Sürüm Geçmişi',
                'slug' => 'surum-gecmisi',
                'template' => 'version-history.php',
                'seo_title' => 'Kalkan Sürüm Geçmişi | iOS Güncelleme Notları',
                'seo_desc' => 'Kalkan iOS uygulamasının tarihli sürüm geçmişi, yeni özellikleri, güvenilirlik geliştirmeleri ve güncelleme notları.',
            ),
            'en' => array(
                'title' => 'Kalkan Version History',
                'slug' => 'version-history',
                'template' => 'version-history.php',
                'seo_title' => 'Kalkan Version History | iOS Release Notes',
                'seo_desc' => 'Dated Kalkan iOS version history with new features, reliability improvements and release notes.',
            ),
        ),
    );

    foreach ($definitions as $translations) {
        $ids = array();
        foreach ($translations as $language => $page_data) {
            $existing = get_page_by_path($page_data['slug']);
            $page_id = $existing ? (int) $existing->ID : wp_insert_post(array(
                'post_title' => $page_data['title'],
                'post_name' => $page_data['slug'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_content' => '',
            ));

            if (!$page_id || is_wp_error($page_id)) continue;

            update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            update_post_meta($page_id, '_seopress_titles_title', $page_data['seo_title']);
            update_post_meta($page_id, '_seopress_titles_desc', $page_data['seo_desc']);
            $is_documentation = 'product-documentation.php' === $page_data['template'];
            $focus_keyword = $is_documentation
                ? ('en' === $language ? 'Kalkan documentation' : 'Kalkan dokümantasyonu')
                : ('en' === $language ? 'Kalkan version history' : 'Kalkan sürüm geçmişi');
            update_post_meta($page_id, '_seopress_analysis_target_kw', $focus_keyword);

            if (function_exists('pll_set_post_language')) {
                pll_set_post_language($page_id, $language);
            }
            $ids[$language] = $page_id;
        }

        if (count($ids) === 2 && function_exists('pll_save_post_translations')) {
            pll_save_post_translations($ids);
        }
    }

    update_option('kalkan_product_reference_pages_v1', true);
}
add_action('init', 'kalkan_create_product_reference_pages', 17);

/**
 * Structured data for the public product reference pages.
 */
function kalkan_product_reference_schema() {
    if (!is_singular('page')) return;
    $slug = get_post_field('post_name', get_the_ID());
    if (!in_array($slug, array('dokumantasyon', 'documentation', 'surum-gecmisi', 'version-history'), true)) return;

    $lang = function_exists('pll_current_language') ? pll_current_language('slug') : 'tr';
    if (!$lang) $lang = 'tr';

    if (in_array($slug, array('dokumantasyon', 'documentation'), true)) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'TechArticle',
            'headline' => 'en' === $lang ? 'Kalkan Documentation and FAQ' : 'Kalkan Dokümantasyonu ve SSS',
            'description' => 'en' === $lang ? 'Technical product documentation for Kalkan iOS call blocking and caller identification.' : 'Kalkan iOS arama engelleme ve arayan kimliği uygulamasının teknik ürün dokümantasyonu.',
            'dateModified' => '2026-08-17',
            'inLanguage' => $lang,
            'mainEntityOfPage' => get_permalink(),
            'about' => array('@type' => 'SoftwareApplication', 'name' => 'Kalkan', 'operatingSystem' => 'iOS'),
            'author' => array('@type' => 'Organization', 'name' => 'Kalkan', 'url' => home_url('/')),
        );
    } else {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => 'en' === $lang ? 'Kalkan Version History' : 'Kalkan Sürüm Geçmişi',
            'itemListOrder' => 'https://schema.org/ItemListOrderDescending',
            'numberOfItems' => 6,
            'itemListElement' => array_map(static function ($version, $position) {
                return array('@type' => 'ListItem', 'position' => $position, 'name' => 'Kalkan ' . $version);
            }, array('1.0.6', '1.0.5', '1.0.4', '1.0.3', '1.0.2', '1.0.1'), range(1, 6)),
        );
    }

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
}
add_action('wp_head', 'kalkan_product_reference_schema', 99);

/**
 * FAQ schema mirrors the visible questions on the documentation page.
 */
function kalkan_product_documentation_faq_schema() {
    if (!is_singular('page')) return;
    $slug = get_post_field('post_name', get_the_ID());
    if (!in_array($slug, array('dokumantasyon', 'documentation'), true)) return;

    $lang = function_exists('pll_current_language') ? pll_current_language('slug') : 'tr';
    if (!$lang) $lang = 'tr';
    $faqs = 'en' === $lang ? array(
        array('Is Kalkan free?', 'General Protection, basic caller identification, General updates, announcements and settings are free. Only Extra Protection requires Kalkan Premium or valid grandfathered access.'),
        array('Does Kalkan block every unwanted call?', 'No. iOS can only block or identify matches in the loaded dataset. New or unlisted numbers may pass through.'),
        array('Does the app run continuously in the background?', 'No. Kalkan prepares data; iOS performs the match when a call arrives.'),
        array('What is the difference between General and Extra Protection?', 'General Protection contains exact-number blocking and identification lists. Extra Protection adds blocking expanded from suspicious number patterns.'),
        array('When should I update protection data?', 'Use the Home update action regularly. You can schedule a local 1, 3, 6 or 12-month reminder from the last successful update.'),
        array('Is a reported number blocked immediately?', 'No. Reports are reviewed; approval and dataset publication are separate processes.'),
    ) : array(
        array('Kalkan ücretsiz mi?', 'Genel Koruma, temel arayan kimliği, Genel güncellemeler, duyurular ve ayarlar ücretsizdir. Yalnızca Ekstra Koruma, Kalkan Premium veya geçerli önceki erişim gerektirir.'),
        array('Kalkan bütün istenmeyen aramaları engeller mi?', 'Hayır. iOS yalnızca yüklenmiş veri setindeki eşleşmeleri engeller veya tanımlar. Yeni ya da listede olmayan numaralar geçebilir.'),
        array('Uygulama arka planda sürekli çalışır mı?', 'Hayır. Kalkan veriyi hazırlar; gelen çağrıda eşleştirmeyi iOS yapar.'),
        array('Genel ve Ekstra Koruma arasındaki fark nedir?', 'Genel Koruma kesin numara engelleme ve tanımlama listeleridir. Ekstra Koruma, şüpheli numara desenlerinden genişletilen ek engelleme katmanıdır.'),
        array('Veriyi ne zaman güncellemeliyim?', 'Ana ekrandaki Güncelle işlemini düzenli kullanın. Son başarılı güncellemeden itibaren 1, 3, 6 veya 12 aylık yerel hatırlatıcı kurabilirsiniz.'),
        array('Numara bildirince hemen engellenir mi?', 'Hayır. Bildirimler incelenir; onay ve veri seti yayını ayrı süreçlerdir.'),
    );

    $items = array_map(static function($faq) {
        return array('@type' => 'Question', 'name' => $faq[0], 'acceptedAnswer' => array('@type' => 'Answer', 'text' => $faq[1]));
    }, $faqs);

    echo '<script type="application/ld+json">' . wp_json_encode(array('@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $items), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
}
add_action('wp_head', 'kalkan_product_documentation_faq_schema', 100);

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

/**
 * 301 redirect /en/home-english/ to /en/ to fix duplicate content.
 * Google crawled this page but won't index it because it duplicates the front page.
 * Only redirect when accessed via the direct slug, NOT when Polylang serves it as front page.
 */
add_action('template_redirect', function () {
    if ( is_page('home-english') && ! is_front_page() ) {
        $en_home = function_exists('pll_home_url') ? pll_home_url('en') : home_url('/en/');
        wp_redirect($en_home, 301);
        exit;
    }
});

/**
 * 301 redirect old slug /en/how-to-use-kalkan-app/ to correct /en/how-to-use-kalkan/.
 */
add_action('template_redirect', function () {
    $request_path = isset($_SERVER['REQUEST_URI'])
        ? (string) parse_url(wp_unslash($_SERVER['REQUEST_URI']), PHP_URL_PATH)
        : '';

    // The old page no longer exists, so is_page() is false on its 404 response.
    // Match the exact legacy path instead and leave every other 404 untouched.
    if (untrailingslashit($request_path) === '/en/how-to-use-kalkan-app') {
        $correct_url = home_url('/en/how-to-use-kalkan/');
        wp_safe_redirect($correct_url, 301);
        exit;
    }
});

/**
 * 301 redirects for old/wrong slugs.
 * Only redirect blog-2 and en-blog which are genuinely obsolete slugs.
 * gizlilik-politikasi and iletisim are valid Turkish pages — do NOT redirect.
 */
add_action('template_redirect', function () {
    $redirects = array(
        'blog-2'   => '/en/blog/',
        'en-blog'  => '/en/blog/',
    );
    foreach ($redirects as $old_slug => $new_path) {
        if (is_page($old_slug)) {
            wp_redirect(home_url($new_path), 301);
            exit;
        }
    }
});

// Remove X-Pingback header.
add_filter('wp_headers', function ($headers) {
    unset($headers['X-Pingback']);
    return $headers;
});

// Disable XML-RPC (common spam vector).
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Publish the product owner's approved Kalkan protection guide once.
 * The option and slug guards make WP Pusher retries idempotent.
 */
function kalkan_publish_protection_guide_v1() {
    if (get_option('kalkan_protection_guide_published_v1')) {
        return;
    }

    $slug = 'kalkan-sizi-nasil-korur';
    if (get_page_by_path($slug, OBJECT, 'post')) {
        update_option('kalkan_protection_guide_published_v1', true);
        return;
    }

    $category = get_category_by_slug('uygulama');
    if (!$category) {
        return;
    }

    $app_store = 'https://apple.co/4cYKmRG';
    $guide_url = home_url('/kalkan-nasil-kullanilir/');

    $content_tr = '
<p>Kalkan, bilinen istenmeyen numaraları engellemeye ve kurumsal numaraları arama ekranında tanımlamaya yardımcı olur. Böylece çalışırken, dinlenirken veya ailenizle vakit geçirirken gereksiz aramalar sizi daha az böler.</p>

<h2>Kalkan arama gelmeden önce nasıl çalışır?</h2>
<p>Kalkan’ın koruma verileri iPhone’un Arama Engelleme ve Numara Tanıma özelliğine yüklenir. Bilinen istenmeyen numaralar engelleme listesine, doğrulanmış kurum numaraları ise arayan kimliği listesine aktarılır.</p>
<ul>
<li><strong>Daha az bölünme:</strong> Bilinen istenmeyen aramalar telefonunuzu çaldırmadan engellenebilir; önemli işinize odaklanmanız kolaylaşır.</li>
<li><strong>Arayanı daha kolay tanıma:</strong> Kalkan veritabanında bulunan bir kurum aradığında, numara yerine açıklayıcı kurum etiketi görebilirsiniz.</li>
<li><strong>Kontrol sizde kalır:</strong> Genel Koruma ücretsizdir. İzin verilen numaraları yönetebilir, verileri yenileyebilir ve şüpheli aramaları bildirebilirsiniz.</li>
</ul>

<h2>Kalkan nasıl etkinleştirilir?</h2>
<ol>
<li>Kalkan’ı açın ve Genel Koruma verilerini indirin.</li>
<li><strong>Ayarlar → Uygulamalar → Telefon → Arama Engelleme ve Numara Tanıma</strong> bölümünü açın.</li>
<li>Kalkan uzantılarını etkinleştirin ve uygulamaya dönün.</li>
<li>Ana ekrandaki durum kartının korumanın aktif olduğunu gösterdiğini doğrulayın.</li>
</ol>
<p><strong>Önemli:</strong> iOS, bu izni sizin açmanızı gerektirir. Kalkan etkinleştirilmezse aramaları engelleyemez ve arayan kimliği etiketlerini gösteremez.</p>

<h2>Genel Koruma ve Extra Koruma arasındaki fark</h2>
<p><strong>Genel Koruma</strong>, bilinen kesin numaralar için ücretsiz engelleme ve arayan kimliği sağlar. <strong>Extra Koruma</strong> ise Kalkan Premium ile şüpheli numara kalıplarına karşı daha geniş, kural tabanlı engelleme ekler. Extra Koruma kullanmasanız da Genel Koruma çalışmaya devam eder.</p>

<h2>Koruma verilerini güncel tutun</h2>
<p>Yeni istenmeyen numaralar ortaya çıkabildiği için ana ekrandaki Güncelle düğmesini düzenli aralıklarla kullanın. Güncelleme tamamlandığında Kalkan yeni arayan kimliği ve engelleme verilerini iPhone’a uygular. Ayrıntılı adımlar için <a href="' . esc_url($guide_url) . '">Kalkan kullanım rehberini</a> inceleyebilirsiniz.</p>

<h2>Şüpheli bir arama size ulaştığında</h2>
<p>Numarayı Kalkan içinden bildirebilir veya Telefon uygulamasındaki desteklenen hızlı bildirim akışını kullanabilirsiniz. Gönderilen bildirimler incelenir; uygun bulunan numaralar sonraki veri güncellemelerine eklenebilir.</p>

<p><strong>Güvenlik hatırlatması:</strong> Hiçbir arama uygulaması yüzde 100 koruma garantisi veremez. Ekranda kurum adı görünse bile şifre, SMS kodu veya banka bilgisi paylaşmayın. Hassas işlemleri kurumun resmî numarasını kendiniz arayarak doğrulayın.</p>
<p><a href="' . esc_url($app_store) . '"><strong>Kalkan’ı açın veya App Store’dan indirin ve koruma durumunuzu kontrol edin.</strong></a></p>';

    $content_en = '
<p>Kalkan helps block known unwanted numbers and identify verified institutional lines on the incoming-call screen. Fewer unnecessary calls interrupt your work, rest, and time with family.</p>
<h2>How does Kalkan work before you answer?</h2>
<p>Kalkan loads protection data into iPhone’s Call Blocking &amp; Identification system. Known unwanted numbers can be added to the blocking list, while verified institutional numbers can receive a useful caller identification label.</p>
<ul>
<li><strong>Fewer interruptions:</strong> Known unwanted calls can be stopped before your phone rings.</li>
<li><strong>More useful caller context:</strong> When a listed organization calls, Kalkan can display a descriptive organization label.</li>
<li><strong>You stay in control:</strong> General Protection is free. You can update data, manage allowed numbers, and report suspicious calls.</li>
</ul>
<h2>How to activate Kalkan</h2>
<ol>
<li>Open Kalkan and download General Protection data.</li>
<li>Open <strong>Settings → Apps → Phone → Call Blocking &amp; Identification</strong>.</li>
<li>Enable the Kalkan extensions and return to the app.</li>
<li>Confirm that the Home status card shows protection as active.</li>
</ol>
<p><strong>Important:</strong> iOS requires you to enable this permission. Without it, Kalkan cannot block calls or display caller identification labels.</p>
<h2>General and Extra Protection</h2>
<p><strong>General Protection</strong> provides free exact-number blocking and identification. <strong>Extra Protection</strong>, available with Kalkan Premium, adds broader rule-based blocking for suspicious number patterns. General Protection remains available separately.</p>
<h2>Keep protection data current</h2>
<p>Because new unwanted numbers appear over time, use the Update button on Home regularly. Kalkan applies refreshed caller identification and blocking data when the update completes.</p>
<h2>When a suspicious call gets through</h2>
<p>Report it inside Kalkan or through the supported quick-reporting flow in the Phone app. Reports are reviewed, and suitable numbers may be included in a future data update.</p>
<p><strong>Security reminder:</strong> No call-protection app can guarantee complete protection. Even when an organization label appears, never share passwords, SMS codes, or banking details. Independently call the organization’s official number for sensitive requests.</p>
<p><a href="' . esc_url($app_store) . '"><strong>Open Kalkan or download it from the App Store and check your protection status.</strong></a></p>';

    $post_id = wp_insert_post(array(
        'post_title'    => 'Kalkan Sizi Nasıl Korur ve Günlük Hayatınıza Ne Kazandırır?',
        'post_name'     => $slug,
        'post_content'  => $content_tr,
        'post_status'   => 'publish',
        'post_type'     => 'post',
        'post_category' => array((int) $category->term_id),
    ), true);

    if (is_wp_error($post_id)) {
        return;
    }

    update_post_meta($post_id, '_kalkan_title_en', 'How Kalkan Protects You and Improves Your Day');
    update_post_meta($post_id, '_kalkan_content_en', $content_en);
    update_post_meta($post_id, '_seopress_titles_title', 'Kalkan Sizi Nasıl Korur? | Arama Koruma Rehberi');
    update_post_meta($post_id, '_seopress_titles_desc', 'Kalkan ile istenmeyen aramaları azaltın, arayan kurumları tanıyın ve iPhone arama korumasını birkaç adımda etkinleştirin.');
    update_post_meta($post_id, '_seopress_analysis_target_kw', 'Kalkan nasıl korur');
    update_post_meta($post_id, '_seopress_social_fb_title', 'Kalkan Sizi Nasıl Korur?');
    update_post_meta($post_id, '_seopress_social_fb_desc', 'Daha az gereksiz arama, daha anlaşılır arayan kimliği ve kontrolü sizde bırakan koruma.');
    update_post_meta($post_id, '_seopress_social_fb_img', get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png');
    update_post_meta($post_id, '_seopress_social_twitter_title', 'Kalkan Sizi Nasıl Korur?');
    update_post_meta($post_id, '_seopress_social_twitter_desc', 'Daha az gereksiz arama, daha anlaşılır arayan kimliği ve kontrolü sizde bırakan koruma.');
    update_post_meta($post_id, '_seopress_social_twitter_img', get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png');
    set_post_thumbnail($post_id, 50);

    if (function_exists('pll_set_post_language')) {
        pll_set_post_language($post_id, 'tr');
    }

    update_option('kalkan_protection_guide_published_v1', true);
}
add_action('init', 'kalkan_publish_protection_guide_v1', 40);

/**
 * One-time cleanup requested after publication: remove the visible logo from
 * the protection guide body while retaining its social sharing image.
 */
function kalkan_remove_protection_guide_body_logo_v1() {
    if (get_option('kalkan_protection_guide_body_logo_removed_v1')) {
        return;
    }

    $post = get_page_by_path('kalkan-sizi-nasil-korur', OBJECT, 'post');
    if (!$post instanceof WP_Post) {
        return;
    }

    $content_tr = preg_replace(
        '#^\s*<p><img[^>]+alt="Kalkan uygulama logosu"[^>]*/></p>\s*#u',
        '',
        $post->post_content
    );
    $content_en = get_post_meta($post->ID, '_kalkan_content_en', true);
    $content_en = preg_replace(
        '#^\s*<p><img[^>]+alt="Kalkan app logo"[^>]*/></p>\s*#u',
        '',
        $content_en
    );

    wp_update_post(array(
        'ID'           => $post->ID,
        'post_content' => $content_tr,
    ));
    update_post_meta($post->ID, '_kalkan_content_en', $content_en);
    update_option('kalkan_protection_guide_body_logo_removed_v1', true);
}
add_action('init', 'kalkan_remove_protection_guide_body_logo_v1', 41);
