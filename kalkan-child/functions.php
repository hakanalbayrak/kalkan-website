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
 * Replace the inner HTML with the actual FluentCRM shortcode when ready.
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
 * Create/update launch blog post on theme activation or first load.
 */
function kalkan_create_launch_post() {
    $existing = get_posts(array(
        'meta_key'       => '_kalkan_launch_post',
        'meta_value'     => '1',
        'post_type'      => 'post',
        'posts_per_page' => 1,
    ));

    if (!empty($existing)) {
        return;
    }

    // Delete Hello World post if it exists.
    $hello = get_page_by_path('hello-world', OBJECT, 'post');
    if ($hello) {
        wp_delete_post($hello->ID, true);
    }

    $content_tr = '<p>Kalkan, iOS kullanıcıları için geliştirilmiş bir spam arama engelleyici ve arayan kimliği uygulamasıdır. Amacımız, sizi istenmeyen ve şüpheli aramalardan korumaktır.</p>

<h2>Kalkan Neden Oluşturuldu?</h2>

<p>Günümüzde spam aramalar ciddi bir sorun haline geldi. Dolandırıcılık girişimleri, istenmeyen satış aramaları ve rahatsız edici numaralar günlük hayatımızı olumsuz etkiliyor. Özellikle çocuklar ve yaşlılar bu tür aramalara karşı daha savunmasız durumdadır.</p>

<p>Kalkan, bu soruna pratik ve güvenilir bir çözüm sunmak için geliştirildi.</p>

<h2>Kalkan Ne İşe Yarar?</h2>

<p>Kalkan, bilinen spam numaraları otomatik olarak engeller ve bilinmeyen numaralar hakkında bilgi gösterir. Böylece telefonu açmadan önce kimin aradığını görebilirsiniz.</p>

<p>Uygulama özellikle şu gruplar için çok faydalıdır:</p>

<ul>
<li><strong>Çocuklar</strong> — Bilinmeyen veya şüpheli numaralardan gelen aramalara karşı koruma sağlar</li>
<li><strong>Yaşlılar</strong> — Dolandırıcılık aramalarını tanımlayarak güvenli bir arama deneyimi sunar</li>
<li><strong>Herkes</strong> — Spam aramaların yarattığı rahatsızlığı en aza indirir</li>
</ul>

<h2>Temel Özellikler</h2>

<ul>
<li><strong>Spam Koruması</strong> — Bilinen spam numaralar otomatik olarak engellenir</li>
<li><strong>Arayan Kimliği</strong> — Bilinmeyen numaralar hakkında bilgi görüntüler</li>
<li><strong>Ekstra Koruma</strong> — Genişletilmiş numara kalıplarını engelleyen gelişmiş koruma</li>
<li><strong>İletişim Bildirimi</strong> — Şüpheli numaraları kolayca bildirin</li>
</ul>

<h2>Gizlilik Önceliğimizdir</h2>

<p>Kalkan, rehberinize veya arama geçmişinize erişmez. Tüm arama koruma işlemleri cihazınızda yerel olarak gerçekleşir. Verileriniz üçüncü taraflara satılmaz.</p>

<h2>Hemen İndirin</h2>

<p>Kalkan şu anda App Store\'da ücretsiz olarak mevcuttur. Hemen indirerek kendinizi ve sevdiklerinizi spam aramalardan koruyun.</p>';

    $post_id = wp_insert_post(array(
        'post_title'   => 'Kalkan Uygulaması Yayında',
        'post_content' => $content_tr,
        'post_status'  => 'publish',
        'post_type'    => 'post',
        'post_name'    => 'kalkan-uygulamasi-yayinda',
    ));

    if ($post_id && !is_wp_error($post_id)) {
        update_post_meta($post_id, '_kalkan_launch_post', '1');

        $content_en = '<p>Kalkan is a spam call blocker and caller identification app developed for iOS users. Our goal is to protect you from unwanted and suspicious calls.</p>

<h2>Why Was Kalkan Created?</h2>

<p>Spam calls have become a serious problem today. Fraud attempts, unwanted sales calls, and harassing numbers negatively affect our daily lives. Children and elderly people are especially vulnerable to these types of calls.</p>

<p>Kalkan was developed to provide a practical and reliable solution to this problem.</p>

<h2>What Does Kalkan Do?</h2>

<p>Kalkan automatically blocks known spam numbers and shows information about unknown numbers. This way, you can see who is calling before answering the phone.</p>

<p>The app is especially useful for:</p>

<ul>
<li><strong>Children</strong> — Provides protection against calls from unknown or suspicious numbers</li>
<li><strong>Elderly People</strong> — Identifies fraud calls and offers a safe calling experience</li>
<li><strong>Everyone</strong> — Minimizes the disturbance caused by spam calls</li>
</ul>

<h2>Key Features</h2>

<ul>
<li><strong>Spam Protection</strong> — Known spam numbers are automatically blocked</li>
<li><strong>Caller Identification</strong> — Shows information about unknown numbers</li>
<li><strong>Extra Protection</strong> — Advanced protection that blocks extended number patterns</li>
<li><strong>Communication Reporting</strong> — Easily report suspicious numbers</li>
</ul>

<h2>Privacy Is Our Priority</h2>

<p>Kalkan does not access your contacts or call history. All call protection happens locally on your device. Your data is never sold to third parties.</p>

<h2>Download Now</h2>

<p>Kalkan is currently available for free on the App Store. Download now and protect yourself and your loved ones from spam calls.</p>';

        update_post_meta($post_id, '_kalkan_content_en', $content_en);
        update_post_meta($post_id, '_kalkan_title_en', 'Kalkan Is Ready to Use');
    }
}
add_action('after_switch_theme', 'kalkan_create_launch_post');
add_action('init', 'kalkan_create_launch_post');

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
 * Add JSON-LD structured data for homepage.
 */
add_action('wp_head', 'kalkan_add_structured_data', 99);
function kalkan_add_structured_data() {
    if (!is_front_page()) {
        return;
    }

    $lang = function_exists('pll_current_language') ? pll_current_language('slug') : 'tr';
    if (!$lang) {
        $lang = 'tr';
    }
    $desc = ($lang === 'tr')
        ? 'Kalkan, iOS cihazınızda spam aramaları engelleyen ve bilinmeyen numaraları tanımlayan ücretsiz bir uygulamadır.'
        : 'Kalkan blocks spam calls and identifies unknown numbers on your iPhone. Free app with offline protection.';

    echo '<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "MobileApplication",
  "name": "Kalkan",
  "operatingSystem": "iOS",
  "applicationCategory": "UtilitiesApplication",
  "description": "' . esc_js($desc) . '",
  "url": "https://kalkan.website",
  "downloadUrl": "https://apple.co/4cYKmRG",
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "TRY"
  },
  "author": {
    "@type": "Organization",
    "name": "Kalkan",
    "url": "https://kalkan.website",
    "email": "info@kalkan.website"
  },
  "inLanguage": ["tr", "en"]
}
</script>' . "\n";
}

/**
 * Update draft blog posts with SEO-optimized content and publish them.
 */
function kalkan_publish_blog_posts() {
    if (get_option('kalkan_blog_posts_published_v2')) return;

    $posts_data = array(
        array(
            'find_title' => 'Sürekli arayan numaralar nasıl engellenir',
            'slug' => 'surekli-arayan-numaralar-nasil-engellenir',
            'seo_title' => 'Sürekli Arayan Numaralar Nasıl Engellenir? [2026 Rehber]',
            'seo_desc' => 'Sürekli arayan rahatsız edici numaraları iPhone\'da engellemenin en kolay yolları. Kalkan uygulaması ile otomatik spam engelleme.',
            'en_title' => 'How to Block Numbers That Keep Calling You',
            'content_tr' => '<p>Sürekli arayan numaralar günlük hayatınızı ciddi şekilde etkileyebilir. İster bir telefoncu olsun, ister dolandırıcı — tekrar tekrar arayan numaraları engellemek herkesin hakkıdır.</p>

<h2>Sürekli Arayan Numarayı Engellemenin 3 Yolu</h2>

<h3>1. iPhone Ayarlarından Manuel Engelleme</h3>
<p>Telefon uygulamasını açın, Son Aramalar listesinde rahatsız edici numaranın yanındaki (i) simgesine dokunun. En altta "Bu Arayanı Engelle" seçeneğini bulacaksınız. Bu yöntem tek tek numaralar için işe yarar, ancak farklı numaralardan gelen spam aramaları engelleyemez.</p>

<h3>2. Kalkan Uygulaması ile Otomatik Engelleme</h3>
<p>Kalkan uygulaması, bilinen spam numaraların kapsamlı bir veritabanını cihazınıza yükler. Bu sayede daha önce hiç aramayan bir spam numara bile otomatik olarak engellenir veya işaretlenir. Veritabanı düzenli olarak güncellenir ve koruma internet bağlantısı gerektirmeden çalışır.</p>

<h3>3. Rahatsız Etmeyin Modu</h3>
<p>Ayarlar > Odaklanma > Rahatsız Etmeyin bölümünden sadece rehberinizdeki kişilerin sizi aramasına izin verebilirsiniz. Ancak bu yöntem tanımadığınız ama önemli olabilecek aramaları da engeller.</p>

<h2>En Etkili Yöntem Hangisi?</h2>
<p>Manuel engelleme tek tek numaralar için, Rahatsız Etmeyin modu geçici durumlar için uygundur. Ancak sürekli farklı numaralardan gelen spam aramalar için en etkili çözüm Kalkan gibi bir spam engelleyici uygulamadır. Kalkan, binlerce bilinen spam numarayı otomatik olarak tanır ve engeller.</p>

<h2>Sıkça Sorulan Sorular</h2>

<h3>Engellediğim numara beni tekrar arayabilir mi?</h3>
<p>iPhone\'da engellediğiniz numara sizi arayamaz. Ancak aynı kişi farklı bir numaradan arayabilir. Bu nedenle Kalkan gibi veritabanı tabanlı bir uygulama daha kapsamlı koruma sağlar.</p>

<h3>Kalkan uygulaması internet olmadan çalışır mı?</h3>
<p>Evet. Kalkan spam numara veritabanını cihazınıza indirir ve tüm koruma işlemleri çevrimdışı olarak gerçekleşir.</p>

<h3>Engelleme çocuklar için de çalışır mı?</h3>
<p>Evet. Kalkan özellikle çocukları ve yaşlıları istenmeyen aramalardan korumak için idealdir. Kurulumu yapıldıktan sonra otomatik olarak çalışır.</p>',
            'content_en' => '<p>Numbers that keep calling you can seriously disrupt your daily life. Whether it is a telemarketer or a scammer, you have every right to block numbers that call you repeatedly.</p>

<h2>3 Ways to Block Persistent Callers</h2>

<h3>1. Manual Blocking via iPhone Settings</h3>
<p>Open the Phone app, tap the (i) icon next to the annoying number in Recent Calls. Scroll down to find "Block this Caller." This works for individual numbers but cannot stop spam calls coming from different numbers.</p>

<h3>2. Automatic Blocking with Kalkan App</h3>
<p>Kalkan loads a comprehensive database of known spam numbers to your device. This means even a spam number that has never called you before gets automatically blocked or flagged. The database is regularly updated and protection works without internet.</p>

<h3>3. Do Not Disturb Mode</h3>
<p>Go to Settings > Focus > Do Not Disturb to allow calls only from your contacts. However, this method also blocks unknown but potentially important calls.</p>

<h2>Which Method Works Best?</h2>
<p>Manual blocking works for individual numbers, Do Not Disturb is good for temporary situations. But for persistent spam calls from different numbers, the most effective solution is a spam blocker app like Kalkan that automatically recognizes and blocks thousands of known spam numbers.</p>',
        ),
        array(
            'find_title' => 'Numara sorgulama ücretsiz yöntemler',
            'slug' => 'numara-sorgulama-ucretsiz-yontemler',
            'seo_title' => 'Numara Sorgulama Ücretsiz Yöntemler [2026]',
            'seo_desc' => 'Bilinmeyen numarayı ücretsiz sorgulama yöntemleri. Google, Kalkan uygulaması ve diğer araçlarla numara kime ait öğrenin.',
            'en_title' => 'Free Number Lookup Methods',
            'content_tr' => '<p>Telefonunuza gelen bilinmeyen bir numaranın kime ait olduğunu öğrenmek istiyorsanız, bunu ücretsiz olarak yapmanın birkaç yolu vardır.</p>

<h2>Ücretsiz Numara Sorgulama Yöntemleri</h2>

<h3>1. Google ile Arama</h3>
<p>En basit yöntem numarayı Google\'a yazmaktır. Eğer numara bir işletmeye veya bilinen bir spam kaynağına aitse, genellikle sonuçlarda görüntülenir. Numarayı başına +90 ekleyerek veya boşluksuz yazarak arayın.</p>

<h3>2. Kalkan Uygulaması</h3>
<p>Kalkan uygulaması gelen aramalarda bilinmeyen numaralar hakkında bilgi gösterir. Arayan kimliği özelliği sayesinde telefonu açmadan önce numaranın spam olup olmadığını görebilirsiniz. Uygulama ücretsizdir ve çevrimdışı çalışır.</p>

<h3>3. Şikayet Siteleri</h3>
<p>sikayetvar.com gibi platformlarda numarayı aratarak başkalarının o numara hakkında yazdıklarını okuyabilirsiniz. Bu özellikle dolandırıcılık numaraları için faydalıdır.</p>

<h3>4. Sosyal Medya Arama</h3>
<p>Numarayı Facebook veya Instagram arama çubuğuna yazarak numara sahibinin profilini bulabilirsiniz. Ancak bu yöntem sadece numarasını profiline eklemiş kişiler için çalışır.</p>

<h2>Hangi Yöntemi Kullanmalısınız?</h2>
<p>Tek seferlik sorgular için Google yeterlidir. Ancak sürekli bilinmeyen numaralardan aranıyorsanız, Kalkan gibi bir uygulama otomatik olarak arayan kimliği gösterir ve sizi spam aramalardan korur.</p>

<h2>Sıkça Sorulan Sorular</h2>

<h3>Numara sorgulama ücretsiz mi?</h3>
<p>Evet. Google araması, şikayet siteleri ve Kalkan uygulamasının arayan kimliği özelliği tamamen ücretsizdir.</p>

<h3>Gizli numarayı sorgulayabilir miyim?</h3>
<p>Hayır. Gizli numara (numara gizleme) ile arayan kişinin numarası görünmediği için sorgulama yapılamaz.</p>',
            'content_en' => '<p>If you want to find out who an unknown number belongs to, there are several free methods available.</p>

<h2>Free Number Lookup Methods</h2>

<h3>1. Google Search</h3>
<p>The simplest method is typing the number into Google. If the number belongs to a business or known spam source, it usually appears in results.</p>

<h3>2. Kalkan App</h3>
<p>Kalkan shows information about unknown numbers on incoming calls. The caller identification feature lets you see if a number is spam before answering. The app is free and works offline.</p>

<h3>3. Complaint Websites</h3>
<p>Search the number on complaint platforms to read what others have reported about that number. This is especially useful for fraud numbers.</p>

<h3>4. Social Media Search</h3>
<p>Search the number on Facebook or Instagram to find the owner\'s profile. This only works if they have added their number to their profile.</p>',
        ),
        array(
            'find_title' => 'Dolandırıcı numaralar nasıl anlaşılır',
            'slug' => 'dolandirici-numaralar-nasil-anlasilir',
            'seo_title' => 'Dolandırıcı Numaralar Nasıl Anlaşılır? Dikkat Edilmesi Gerekenler',
            'seo_desc' => 'Telefon dolandırıcılığı numaralarını tanımanın yolları. Dolandırıcıların kullandığı yaygın yöntemler ve korunma ipuçları.',
            'en_title' => 'How to Recognize Scam Phone Numbers',
            'content_tr' => '<p>Telefon dolandırıcılığı Türkiye\'de giderek artan ciddi bir sorundur. Dolandırıcılar genellikle banka, kargo şirketi veya resmi kurum gibi davranarak kişisel bilgilerinizi ele geçirmeye çalışır.</p>

<h2>Dolandırıcı Numaraların Belirtileri</h2>

<h3>1. Aciliyet Yaratma</h3>
<p>"Hesabınız kapatılacak", "Son 10 dakikanız var" gibi panik yaratan ifadeler dolandırıcılığın en yaygın işaretidir. Gerçek kurumlar sizi telefonla arayıp acil işlem yapmanızı istemez.</p>

<h3>2. Kişisel Bilgi İsteme</h3>
<p>TC kimlik numarası, banka kartı bilgileri, şifre veya SMS doğrulama kodu isteyen aramalar kesinlikle dolandırıcılıktır. Hiçbir banka veya resmi kurum bu bilgileri telefonla istemez.</p>

<h3>3. Bilinmeyen veya Garip Numaralar</h3>
<p>+1, +44 gibi yabancı alan kodları ile gelen aramalar, çok kısa süren ve geri aramanızı bekleyen aramalar (wangiri dolandırıcılığı) veya ardışık numaralardan gelen aramalar şüphelidir.</p>

<h3>4. Ödül veya Kazanç Vaadi</h3>
<p>"Çekilişimizi kazandınız", "Size kredi onaylandı" gibi beklemediğiniz teklifler genellikle dolandırıcılıktır.</p>

<h2>Kendinizi Nasıl Korursunuz?</h2>

<ul>
<li><strong>Bilinmeyen numaralardan gelen aramalarda kişisel bilgi paylaşmayın</strong></li>
<li><strong>Şüpheli numarayı Google\'da aratın</strong></li>
<li><strong>Kalkan uygulamasını kullanın</strong> — bilinen dolandırıcı numaraları otomatik olarak işaretler</li>
<li><strong>Geri aramayın</strong> — özellikle yabancı numaraları</li>
<li><strong>Yaşlı aile üyelerinizi bilgilendirin</strong> — dolandırıcılar özellikle yaşlıları hedef alır</li>
</ul>

<h2>Sıkça Sorulan Sorular</h2>

<h3>Dolandırıcı aramayı açarsam ne olur?</h3>
<p>Aramayı açmak tek başına tehlikeli değildir. Tehlike, kişisel bilgilerinizi paylaşmanız veya yönlendirdikleri linklere tıklamanız durumunda başlar.</p>

<h3>Dolandırıcı numarayı nereye şikayet edebilirim?</h3>
<p>BTK (Bilgi Teknolojileri ve İletişim Kurumu) ihbar hattı 137\'yi arayabilir veya Kalkan uygulaması üzerinden numarayı bildirebilirsiniz.</p>',
            'content_en' => '<p>Phone scams are a growing problem. Scammers typically pretend to be banks, delivery companies, or government agencies to steal your personal information.</p>

<h2>Signs of a Scam Call</h2>

<h3>1. Creating Urgency</h3>
<p>Phrases like "Your account will be closed" or "You have 10 minutes" are the most common signs of fraud. Real institutions do not call you demanding urgent action.</p>

<h3>2. Requesting Personal Information</h3>
<p>Calls asking for ID numbers, bank card details, passwords, or SMS verification codes are always scams. No bank or official institution requests this information by phone.</p>

<h3>3. Unknown or Strange Numbers</h3>
<p>Calls from foreign area codes, very short calls expecting you to call back (wangiri fraud), or calls from sequential numbers are suspicious.</p>

<h3>4. Prize or Profit Promises</h3>
<p>Unexpected offers like "You won our raffle" or "A loan has been approved for you" are typically scams.</p>

<h2>How to Protect Yourself</h2>
<ul>
<li>Never share personal information on calls from unknown numbers</li>
<li>Search suspicious numbers on Google</li>
<li>Use Kalkan app — it automatically flags known scam numbers</li>
<li>Do not call back — especially foreign numbers</li>
<li>Inform elderly family members — scammers especially target the elderly</li>
</ul>',
        ),
        array(
            'find_title' => 'Bu numara kime ait? Numara Sorgula',
            'slug' => 'bu-numara-kime-ait-numara-sorgula',
            'seo_title' => 'Bu Numara Kime Ait? Numara Sorgulama Rehberi [2026]',
            'seo_desc' => 'Bilinmeyen numara kime ait öğrenmenin en kolay yolları. Ücretsiz numara sorgulama araçları ve Kalkan uygulaması ile arayan kimliği.',
            'en_title' => 'Who Does This Number Belong To? Number Lookup Guide',
            'content_tr' => '<p>"Bu numara kime ait?" sorusu Türkiye\'de en çok aranan sorulardan biridir. Cevapsız bir arama, bilinmeyen bir numara veya şüpheli bir mesaj aldığınızda numaranın sahibini öğrenmek istemeniz doğaldır.</p>

<h2>Numara Kime Ait Nasıl Öğrenilir?</h2>

<h3>1. Kalkan Uygulaması ile Arayan Kimliği</h3>
<p>Kalkan uygulamasını iPhone\'unuza kurduğunuzda, gelen aramalarda otomatik olarak numara hakkında bilgi görürsünüz. Numara spam veritabanında varsa "Spam" veya "Dolandırıcı" olarak işaretlenir. Bu sayede telefonu açmadan kimin aradığını anlayabilirsiniz.</p>

<h3>2. Google Araması</h3>
<p>Numarayı olduğu gibi Google\'a yazın. İşletme numaralarının çoğu Google sonuçlarında görünür. Numarayı tırnak işareti içinde aratmak ("05XX XXX XX XX") daha kesin sonuçlar verir.</p>

<h3>3. Şikayet ve Forum Siteleri</h3>
<p>Türkiye\'de sikayetvar.com ve benzeri platformlarda numara aratarak başkalarının deneyimlerini okuyabilirsiniz. Özellikle spam ve dolandırıcılık numaraları hakkında detaylı bilgi bulabilirsiniz.</p>

<h3>4. Operatör Müşteri Hizmetleri</h3>
<p>Rahatsız edici aramalar alıyorsanız, kendi operatörünüzün müşteri hizmetlerini arayarak numara engelleme talebinde bulunabilirsiniz.</p>

<h2>Sıkça Sorulan Sorular</h2>

<h3>Kalkan numaranın kime ait olduğunu gösterir mi?</h3>
<p>Kalkan, numaranın spam veya dolandırıcı olarak tanınıp tanınmadığını gösterir. Kişisel rehber bilgilerine erişmez — gizliliğinize saygı duyar.</p>

<h3>+90 ile başlayan numara nereden arıyor?</h3>
<p>+90 Türkiye\'nin ülke kodudur. Yurt içinden yapılan aramalar +90 ile başlar.</p>

<h3>Bilinmeyen numarayı geri aramalı mıyım?</h3>
<p>Tanımadığınız numaraları geri aramamanız önerilir. Özellikle yabancı alan kodlu numaraları geri aramak yüksek ücretlere neden olabilir.</p>',
            'content_en' => '<p>"Who does this number belong to?" is one of the most commonly asked questions. When you receive a missed call or message from an unknown number, wanting to know who it belongs to is natural.</p>

<h2>How to Find Out Who a Number Belongs To</h2>

<h3>1. Kalkan App Caller ID</h3>
<p>When you install Kalkan on your iPhone, incoming calls automatically show information about the number. If the number is in the spam database, it gets flagged. You can tell who is calling before answering.</p>

<h3>2. Google Search</h3>
<p>Type the number directly into Google. Most business numbers appear in search results.</p>

<h3>3. Complaint and Forum Sites</h3>
<p>Search the number on complaint platforms to read about others\' experiences, especially for spam and fraud numbers.</p>

<h3>4. Carrier Customer Service</h3>
<p>If you receive harassing calls, contact your carrier\'s customer service to request number blocking.</p>',
        ),
        array(
            'find_title' => 'Spam arama nasıl engellenir iPhone',
            'slug' => 'spam-arama-nasil-engellenir-iphone',
            'seo_title' => 'iPhone\'da Spam Arama Nasıl Engellenir? [Adım Adım Rehber]',
            'seo_desc' => 'iPhone\'da spam aramaları engellemenin en etkili yolları. iOS arama engelleme ayarları ve Kalkan uygulaması ile tam koruma.',
            'en_title' => 'How to Block Spam Calls on iPhone',
            'content_tr' => '<p>iPhone\'da spam aramaları engellemek için birkaç farklı yöntem bulunmaktadır. iOS\'un yerleşik özellikleri temel koruma sağlarken, Kalkan gibi uygulamalar kapsamlı spam engelleme sunar.</p>

<h2>iPhone\'da Spam Engelleme Yöntemleri</h2>

<h3>1. Kalkan Uygulamasını Kurun (Önerilen)</h3>
<p>Kalkan, iOS\'un Arama Engelleme ve Kimliklendirme özelliği ile entegre çalışır. Kurulum adımları:</p>
<ol>
<li>App Store\'dan Kalkan\'ı indirin</li>
<li>Uygulamayı açın ve kurulum adımlarını takip edin</li>
<li>Ayarlar > Telefon > Arama Engelleme ve Kimliklendirme bölümünde Kalkan\'ı etkinleştirin</li>
<li>Uygulama spam veritabanını otomatik olarak yükleyecektir</li>
</ol>
<p>Bu işlemden sonra bilinen spam numaralar otomatik olarak engellenir veya işaretlenir. İnternet bağlantısı gerekmez.</p>

<h3>2. iOS Sessiz Bilinmeyen Arayanlar Özelliği</h3>
<p>Ayarlar > Telefon > Bilinmeyen Arayanları Sustur seçeneğini açın. Bu özellik rehberinizde olmayan tüm numaraları sessize alır. Ancak önemli aramaları da kaçırabilirsiniz.</p>

<h3>3. Manuel Numara Engelleme</h3>
<p>Telefon uygulamasında Son Aramalar listesinden numaranın yanındaki (i) simgesine dokunun ve "Bu Arayanı Engelle" seçeneğini kullanın.</p>

<h3>4. Operatör Spam Filtreleme</h3>
<p>Bazı Türk operatörleri (Turkcell, Vodafone, Türk Telekom) spam filtreleme hizmetleri sunar. Operatörünüzün müşteri hizmetlerinden bu hizmeti aktif edebilirsiniz.</p>

<h2>En Etkili Yöntem: Kalkan + iOS Özellikleri</h2>
<p>En kapsamlı koruma için Kalkan uygulamasını kurup iOS\'un "Bilinmeyen Arayanları Sustur" özelliğini birlikte kullanmanızı öneriyoruz. Kalkan bilinen spam numaraları engellerken, iOS özelliği ek bir güvenlik katmanı sağlar.</p>

<h2>Sıkça Sorulan Sorular</h2>

<h3>Kalkan uygulaması ücretsiz mi?</h3>
<p>Evet. Genel koruma ve arayan kimliği özellikleri tamamen ücretsizdir. Ekstra Koruma özelliği de şu anda ücretsiz olarak sunulmaktadır.</p>

<h3>Spam engelleme pil tüketir mi?</h3>
<p>Hayır. Kalkan spam veritabanını cihaza indirdiği için arka planda sürekli çalışmaz ve pil tüketimi yapmaz.</p>

<h3>Engellenen numaralar mesaj gönderebilir mi?</h3>
<p>Kalkan\'ın engelleme sistemi aramalar için çalışır. SMS filtreleme ayrı bir iOS özelliğidir.</p>',
            'content_en' => '<p>There are several methods to block spam calls on iPhone. While iOS built-in features provide basic protection, apps like Kalkan offer comprehensive spam blocking.</p>

<h2>Spam Blocking Methods for iPhone</h2>

<h3>1. Install Kalkan App (Recommended)</h3>
<p>Kalkan integrates with iOS Call Blocking and Identification. Setup steps: download from App Store, follow setup, enable in Settings > Phone > Call Blocking & Identification. Known spam numbers are automatically blocked or flagged. No internet required.</p>

<h3>2. iOS Silence Unknown Callers</h3>
<p>Enable Settings > Phone > Silence Unknown Callers. This silences all numbers not in your contacts, but may cause you to miss important calls.</p>

<h3>3. Manual Number Blocking</h3>
<p>In the Phone app, tap (i) next to a number in Recent Calls and select "Block this Caller."</p>

<h3>4. Carrier Spam Filtering</h3>
<p>Some carriers offer spam filtering services. Contact your carrier to activate this feature.</p>',
        ),
        array(
            'find_title' => 'Bilinmeyen numara kimin nasıl öğrenilir',
            'slug' => 'bilinmeyen-numara-kimin-nasil-ogrenilir',
            'seo_title' => 'Bilinmeyen Numara Kimin Nasıl Öğrenilir? [2026 Rehber]',
            'seo_desc' => 'Sizi arayan bilinmeyen numaranın kime ait olduğunu öğrenmenin ücretsiz yolları. Arayan kimliği ve numara sorgulama yöntemleri.',
            'en_title' => 'How to Find Out Who an Unknown Number Belongs To',
            'content_tr' => '<p>Telefonunuza bilinmeyen bir numaradan arama geldiğinde, arayanın kim olduğunu öğrenmek istemeniz çok doğal. İşte bunu yapmanın en pratik yolları.</p>

<h2>Bilinmeyen Numarayı Tanımanın Yolları</h2>

<h3>1. Kalkan Arayan Kimliği</h3>
<p>Kalkan uygulaması, arama geldiği anda numaranın spam veya dolandırıcı olarak tanınıp tanınmadığını ekranda gösterir. Telefonu açmadan önce karar vermenizi sağlar. Ücretsizdir ve çevrimdışı çalışır.</p>

<h3>2. Cevapsız Aramayı Google\'da Aratın</h3>
<p>Cevapsız arama bırakan numarayı Google\'a yazın. İşletme numaralarının büyük çoğunluğu arama sonuçlarında çıkar. "05XX XXX XX XX spam" şeklinde aratmak daha spesifik sonuçlar verir.</p>

<h3>3. WhatsApp ile Kontrol</h3>
<p>Numarayı rehberinize ekleyin ve WhatsApp\'ta kontrol edin. Eğer kişi WhatsApp kullanıyorsa profil fotoğrafı ve durumu görünür. İşiniz bitince numarayı silebilirsiniz.</p>

<h3>4. Geri Arama Riskleri</h3>
<p>Bilinmeyen numarayı geri aramamanız önerilir. Özellikle yabancı alan kodlu (+1, +44, +992 gibi) numaralar yüksek ücretli hatlara yönlendirebilir. Önemli bir arama ise arayan tekrar arar veya mesaj bırakır.</p>

<h2>Özellikle Dikkat Edilmesi Gerekenler</h2>

<ul>
<li><strong>Çocuklar ve yaşlılar</strong> bilinmeyen numaralardan gelen aramalara karşı daha savunmasızdır. Kalkan uygulamasını aile üyelerinin telefonlarına kurarak onları koruyabilirsiniz.</li>
<li><strong>+90 ile başlayan numaralar</strong> Türkiye\'den arıyor demektir.</li>
<li><strong>Çok kısa süren aramalar</strong> (1-2 çalıp kapanan) genellikle geri aramanızı bekleyen dolandırıcılardır.</li>
</ul>

<h2>Sıkça Sorulan Sorular</h2>

<h3>Numara sorgulama yasal mı?</h3>
<p>Evet. Sizi arayan bir numarayı sorgulamak tamamen yasaldır. Kalkan uygulaması da kişisel rehber bilgilerinize erişmeden çalışır.</p>

<h3>Gizli numarayı öğrenebilir miyim?</h3>
<p>Numarasını gizleyerek arayan kişinin numarasını öğrenmek teknik olarak mümkün değildir. Ancak operatörünüze başvurarak rahatsız edici gizli aramalar hakkında işlem başlatabilirsiniz.</p>

<h3>Kalkan tüm bilinmeyen numaraları engeller mi?</h3>
<p>Kalkan, veritabanında bulunan bilinen spam ve dolandırıcı numaraları engeller. Her bilinmeyen numarayı engellemez — sadece zararlı olduğu bilinen numaraları. Bu sayede önemli aramaları kaçırmazsınız.</p>',
            'content_en' => '<p>When you receive a call from an unknown number, wanting to find out who is calling is completely natural. Here are the most practical ways to do it.</p>

<h2>Ways to Identify Unknown Numbers</h2>

<h3>1. Kalkan Caller ID</h3>
<p>Kalkan shows whether a number is recognized as spam or fraud right on your screen when a call comes in. It helps you decide before answering. Free and works offline.</p>

<h3>2. Google the Missed Call</h3>
<p>Type the missed call number into Google. Most business numbers appear in search results.</p>

<h3>3. Check via WhatsApp</h3>
<p>Add the number to your contacts and check WhatsApp. If the person uses WhatsApp, their profile photo will be visible.</p>

<h3>4. Risks of Calling Back</h3>
<p>It is recommended not to call back unknown numbers, especially those with foreign area codes, as they may redirect to premium-rate lines.</p>',
        ),
    );

    foreach ($posts_data as $post_data) {
        $posts = get_posts(array(
            'post_type' => 'post',
            'post_status' => 'draft',
            'title' => $post_data['find_title'],
            'posts_per_page' => 1,
        ));

        if (empty($posts)) {
            $posts = get_posts(array(
                'post_type' => 'post',
                'post_status' => 'draft',
                's' => $post_data['find_title'],
                'posts_per_page' => 1,
            ));
        }

        if (!empty($posts)) {
            $post_id = $posts[0]->ID;

            wp_update_post(array(
                'ID' => $post_id,
                'post_content' => $post_data['content_tr'],
                'post_name' => $post_data['slug'],
                'post_status' => 'publish',
            ));

            update_post_meta($post_id, '_kalkan_content_en', $post_data['content_en']);
            update_post_meta($post_id, '_kalkan_title_en', $post_data['en_title']);
            update_post_meta($post_id, '_seopress_titles_title', $post_data['seo_title']);
            update_post_meta($post_id, '_seopress_titles_desc', $post_data['seo_desc']);

            if (function_exists('pll_set_post_language')) {
                pll_set_post_language($post_id, 'tr');
            }
        }
    }

    update_option('kalkan_blog_posts_published_v2', true);
}
add_action('init', 'kalkan_publish_blog_posts');

/**
 * Serve llms.txt at site root for AI platform crawlers.
 */
add_action('init', 'kalkan_serve_llms_txt');
function kalkan_serve_llms_txt() {
    if (isset($_SERVER['REQUEST_URI']) && trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') === 'llms.txt') {
        $file = get_stylesheet_directory() . '/llms.txt';
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
    $custom .= "User-agent: ChatGPT-User\nAllow: /\n\n";
    $custom .= "User-agent: Google-Extended\nAllow: /\n\n";
    $custom .= "User-agent: PerplexityBot\nAllow: /\n\n";
    $custom .= "User-agent: ClaudeBot\nAllow: /\n\n";
    $custom .= "User-agent: Amazonbot\nAllow: /\n\n";

    $custom .= "Sitemap: " . home_url('/sitemap.xml') . "\n";

    return $custom;
}
