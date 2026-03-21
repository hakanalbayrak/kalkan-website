<?php
/**
 * Front page template for Kalkan child theme.
 *
 * @package kalkan-child
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('kalkan_home_inline_icon')) {
    /**
     * Return static inline SVG icons for homepage cards.
     */
    function kalkan_home_inline_icon($name) {
        $icons = array(
            'spam' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2L4 6v6c0 5 3.4 9.5 8 10 4.6-.5 8-5 8-10V6l-8-4zm0 3.1l5 2.5V12c0 3.5-2.1 6.7-5 7.7-2.9-1-5-4.2-5-7.7V7.6l5-2.5zm-3.8 4.4l1.6-1.6L12 10.1l2.2-2.2 1.6 1.6L13.6 12l2.2 2.2-1.6 1.6L12 13.6l-2.2 2.2-1.6-1.6L10.4 12 8.2 9.8z"/></svg>',
            'caller' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.6 2.5l3 2.3c.7.5 1 1.5.6 2.3L9 9.4c-.3.7-.2 1.4.3 2 .9 1.2 2 2.3 3.2 3.2.6.5 1.4.6 2 .3l2.3-1.2c.8-.4 1.8-.1 2.3.6l2.3 3c.6.8.5 2-.3 2.7l-1 .8c-1.1.9-2.6 1.3-4 1.1-2.8-.4-5.5-1.7-8.2-4.4-2.7-2.7-4-5.4-4.4-8.2-.2-1.4.2-2.9 1.1-4l.8-1c.7-.8 1.9-.9 2.7-.3z"/></svg>',
            'extra' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 1l9 4v6c0 5.6-3.8 10.7-9 12-5.2-1.3-9-6.4-9-12V5l9-4zm0 3.2L6 6.9V11c0 4.1 2.6 8 6 9.3 3.4-1.3 6-5.2 6-9.3V6.9l-6-2.7zm-1 4h2v3h3v2h-3v3h-2v-3H8v-2h3V8z"/></svg>',
            'report' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 11v2h2l5 4v-2h4c2.8 0 5-2.2 5-5V4l-6 3H5c-1.1 0-2 .9-2 2v2zm8-2h3.5L17 7.8V10c0 1.7-1.3 3-3 3H9l-4-3v-1h6zm6 6h2c0 2.8-2.2 5-5 5h-2v-2h2c1.7 0 3-1.3 3-3z"/></svg>',
            'trust' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l8 3v6c0 5-3.4 9.5-8 11-4.6-1.5-8-6-8-11V5l8-3zm0 2.1L6 6.4V11c0 3.9 2.5 7.4 6 8.7 3.5-1.3 6-4.8 6-8.7V6.4l-6-2.3zm0 2.4a4.5 4.5 0 014.5 4.5h-2A2.5 2.5 0 0012 8.5v2.2l3.2 3.2-1.4 1.4-3.8-3.8V6.5z"/></svg>',
            'faq' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2C6.5 2 2 6.1 2 11.2c0 2.8 1.4 5.4 3.8 7.1V22l3.1-1.9c1 .2 2 .3 3.1.3 5.5 0 10-4.1 10-9.2S17.5 2 12 2zm0 16.4c-.9 0-1.8-.1-2.7-.3l-.8-.2-1.7 1v-1.7l-.7-.5A7 7 0 014 11.2C4 7.2 7.6 4 12 4s8 3.2 8 7.2-3.6 7.2-8 7.2zm-.1-11.2c-2.1 0-3.6 1.3-3.7 3.3h2c0-.9.7-1.5 1.7-1.5s1.7.6 1.7 1.4c0 .7-.4 1.1-1.2 1.6-.9.5-1.8 1.2-1.8 2.8v.3h2v-.2c0-.8.3-1.1 1.1-1.6.9-.5 2-1.2 2-2.9 0-1.9-1.5-3.2-3.8-3.2zm-1.1 10h2.2v2h-2.2v-2z"/></svg>',
        );

        return isset($icons[$name]) ? $icons[$name] : '';
    }
}

$app_store_url = apply_filters('kalkan_app_store_url', '#');
$app_store_url = esc_url($app_store_url);

$asset_base_url      = trailingslashit(get_stylesheet_directory_uri()) . 'assets/';
$app_store_badge_url = esc_url(apply_filters('kalkan_app_store_badge_url', $asset_base_url . 'badges/app-store-badge.svg'));
$iphone_frame_url    = esc_url($asset_base_url . 'images/iphone-frame.svg');
$app_screen_url      = esc_url($asset_base_url . 'images/app-screenshot-home.svg');

$home_url = home_url('/');

$number_lookup_page = get_page_by_path('number-lookup');
$number_lookup_url  = $number_lookup_page ? get_permalink($number_lookup_page) : home_url('/number-lookup/');

$posts_page_id = (int) get_option('page_for_posts');
$blog_url      = $posts_page_id > 0 ? get_permalink($posts_page_id) : home_url('/blog/');

$privacy_url = get_privacy_policy_url();
if (empty($privacy_url)) {
    $privacy_url = home_url('/privacy-policy/');
}

$terms_page = get_page_by_path('terms');
$terms_url  = $terms_page ? get_permalink($terms_page) : home_url('/terms/');

$contact_page = get_page_by_path('contact');
if (!$contact_page) {
    $contact_page = get_page_by_path('support');
}
$contact_url = $contact_page ? get_permalink($contact_page) : home_url('/contact/');

$menu_items = array(
    array('label' => 'Home', 'url' => $home_url),
    array('label' => 'Number Lookup', 'url' => $number_lookup_url),
    array('label' => 'Blog', 'url' => $blog_url),
    array('label' => 'Privacy Policy', 'url' => $privacy_url),
    array('label' => 'Terms', 'url' => $terms_url),
    array('label' => 'Contact', 'url' => $contact_url),
);

$how_steps = array(
    array('title' => 'Install Kalkan', 'body' => 'Download Kalkan from the App Store and open the app.'),
    array('title' => 'Turn on protection', 'body' => 'Enable spam protection and caller identification in setup.'),
    array('title' => 'Report suspicious calls when needed', 'body' => 'Report suspicious calls quickly whenever they appear.'),
);

$feature_cards = array(
    array(
        'icon'  => 'spam',
        'title' => 'Spam Protection',
        'body'  => 'Reduce interruptions from suspicious and unwanted numbers with simple controls.',
    ),
    array(
        'icon'  => 'caller',
        'title' => 'Caller Identification',
        'body'  => 'See clearer context for unknown callers before deciding whether to answer.',
    ),
    array(
        'icon'  => 'extra',
        'title' => 'Extra Protection',
        'body'  => 'Add stronger day-to-day protection with expanded call safety support.',
    ),
);

$faq_items = array(
    'What does Kalkan do?',
    'How does spam protection work in simple terms?',
    'Can I identify unknown callers with Kalkan?',
    'Is Communication Reporting free?',
    'How do I report a suspicious call?',
    'Where can I read your privacy policy and terms?',
);

$social_links = apply_filters('kalkan_footer_social_links', array());

get_header();
?>

<main id="primary" class="site-main">
    <article class="kalkan-homepage" aria-label="Kalkan landing page">
        <header class="kalkan-site-header" aria-label="Primary">
            <div class="kalkan-shell">
                <a class="kalkan-brand" href="<?php echo esc_url($home_url); ?>" aria-label="Kalkan home">
                    <span class="kalkan-brand__mark">K</span>
                    <span class="kalkan-brand__wordmark">Kalkan</span>
                </a>

                <nav class="kalkan-nav-desktop" aria-label="Desktop menu">
                    <ul>
                        <?php foreach ($menu_items as $menu_item) : ?>
                            <li><a href="<?php echo esc_url($menu_item['url']); ?>"><?php echo esc_html($menu_item['label']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>

                <details class="kalkan-nav-mobile">
                    <summary><?php echo esc_html__('Menu', 'kalkan-child'); ?></summary>
                    <nav aria-label="Mobile menu">
                        <ul>
                            <?php foreach ($menu_items as $menu_item) : ?>
                                <li><a href="<?php echo esc_url($menu_item['url']); ?>"><?php echo esc_html($menu_item['label']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                </details>
            </div>
        </header>

        <div class="kalkan-main-stack">
            <section class="kalkan-section kalkan-hero" aria-labelledby="kalkan-hero-title">
                <div class="kalkan-shell kalkan-hero__layout">
                    <div class="kalkan-hero__content">
                        <p class="kalkan-eyebrow"><?php echo esc_html__('Call protection for daily life', 'kalkan-child'); ?></p>
                        <h1 id="kalkan-hero-title"><?php echo esc_html__('Caller safety made simple', 'kalkan-child'); ?></h1>
                        <p class="kalkan-hero__lead"><?php echo esc_html__('Kalkan helps you identify unknown callers, reduce spam interruptions, and report suspicious calls in seconds.', 'kalkan-child'); ?></p>
                        <p class="kalkan-hero__trust"><?php echo esc_html__('Built for everyday use, including families and older adults.', 'kalkan-child'); ?></p>

                        <div class="kalkan-actions">
                            <a class="kalkan-button-primary" href="<?php echo $app_store_url; ?>"><?php echo esc_html__('Get Kalkan on the App Store', 'kalkan-child'); ?></a>
                            <a class="kalkan-button-secondary" href="#kalkan-how-it-works"><?php echo esc_html__('Learn more', 'kalkan-child'); ?></a>
                        </div>

                        <div class="kalkan-app-store-wrap" aria-label="App Store badge area">
                            <a href="<?php echo $app_store_url; ?>" class="kalkan-app-store-link">
                                <img src="<?php echo $app_store_badge_url; ?>" alt="Download on the App Store" class="kalkan-app-store-badge" loading="lazy" decoding="async">
                            </a>
                        </div>
                    </div>

                    <div class="kalkan-hero__visual" aria-hidden="true">
                        <div class="kalkan-device-mockup">
                            <img src="<?php echo $app_screen_url; ?>" alt="" class="kalkan-device-mockup__screen" loading="lazy" decoding="async">
                            <img src="<?php echo $iphone_frame_url; ?>" alt="" class="kalkan-device-mockup__frame" loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
            </section>

            <section id="kalkan-how-it-works" class="kalkan-section kalkan-how" aria-labelledby="kalkan-how-title">
                <div class="kalkan-shell">
                    <h2 id="kalkan-how-title"><?php echo esc_html__('How It Works', 'kalkan-child'); ?></h2>
                    <p class="kalkan-section-lead"><?php echo esc_html__('Simple setup, clear controls, and practical protection from day one.', 'kalkan-child'); ?></p>
                    <ol class="kalkan-step-grid">
                        <?php foreach ($how_steps as $index => $step) : ?>
                            <li class="kalkan-step-card">
                                <span class="kalkan-step-card__index"><?php echo esc_html((string) ($index + 1)); ?></span>
                                <h3><?php echo esc_html($step['title']); ?></h3>
                                <p><?php echo esc_html($step['body']); ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </section>

            <section class="kalkan-section kalkan-features" aria-labelledby="kalkan-features-title">
                <div class="kalkan-shell">
                    <h2 id="kalkan-features-title"><?php echo esc_html__('Core Features', 'kalkan-child'); ?></h2>
                    <p class="kalkan-section-lead"><?php echo esc_html__('Protection focused on the moments that matter most.', 'kalkan-child'); ?></p>
                    <div class="kalkan-card-grid kalkan-card-grid--three">
                        <?php foreach ($feature_cards as $feature) : ?>
                            <article class="kalkan-card kalkan-feature-card">
                                <span class="kalkan-icon" aria-hidden="true"><?php echo kalkan_home_inline_icon($feature['icon']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                                <h3><?php echo esc_html($feature['title']); ?></h3>
                                <p><?php echo esc_html($feature['body']); ?></p>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <section class="kalkan-section kalkan-reporting" aria-labelledby="kalkan-reporting-title">
                <div class="kalkan-shell">
                    <div class="kalkan-highlight-card">
                        <div class="kalkan-highlight-card__icon" aria-hidden="true"><?php echo kalkan_home_inline_icon('report'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                        <div>
                            <h2 id="kalkan-reporting-title"><?php echo esc_html__('Communication Reporting', 'kalkan-child'); ?></h2>
                            <p><?php echo esc_html__('Suspicious calls can be reported quickly in the app. Communication Reporting is free and helps the wider community stay more aware of harmful calling patterns.', 'kalkan-child'); ?></p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="kalkan-section kalkan-trust" aria-labelledby="kalkan-trust-title">
                <div class="kalkan-shell kalkan-trust__layout">
                    <div class="kalkan-trust__visual" aria-hidden="true">
                        <div class="kalkan-trust-badge"><?php echo kalkan_home_inline_icon('trust'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                    </div>
                    <div class="kalkan-trust__content">
                        <h2 id="kalkan-trust-title"><?php echo esc_html__('Built with trust and privacy in mind', 'kalkan-child'); ?></h2>
                        <p class="kalkan-section-lead"><?php echo esc_html__('Kalkan is designed for clear privacy policy access, transparent communication, simple setup, and respectful product behavior.', 'kalkan-child'); ?></p>
                        <div class="kalkan-inline-links">
                            <a href="<?php echo esc_url($privacy_url); ?>"><?php echo esc_html__('Privacy Policy', 'kalkan-child'); ?></a>
                            <a href="<?php echo esc_url($terms_url); ?>"><?php echo esc_html__('Terms', 'kalkan-child'); ?></a>
                            <a href="<?php echo esc_url($contact_url); ?>"><?php echo esc_html__('Contact / Support', 'kalkan-child'); ?></a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="kalkan-section kalkan-final-cta" aria-labelledby="kalkan-final-cta-title">
                <div class="kalkan-shell">
                    <div class="kalkan-final-cta__card">
                        <h2 id="kalkan-final-cta-title"><?php echo esc_html__('Ready for safer calls?', 'kalkan-child'); ?></h2>
                        <p><?php echo esc_html__('Install Kalkan from the App Store and set up protection in minutes.', 'kalkan-child'); ?></p>
                        <div class="kalkan-actions">
                            <a class="kalkan-button-primary" href="<?php echo $app_store_url; ?>"><?php echo esc_html__('Download on the App Store', 'kalkan-child'); ?></a>
                        </div>
                        <a href="<?php echo $app_store_url; ?>" class="kalkan-app-store-link kalkan-app-store-link--centered">
                            <img src="<?php echo $app_store_badge_url; ?>" alt="Download on the App Store" class="kalkan-app-store-badge" loading="lazy" decoding="async">
                        </a>
                    </div>
                </div>
            </section>

            <section class="kalkan-section kalkan-faq" aria-labelledby="kalkan-faq-title">
                <div class="kalkan-shell">
                    <h2 id="kalkan-faq-title"><?php echo esc_html__('FAQ Preview', 'kalkan-child'); ?></h2>
                    <p class="kalkan-section-lead"><?php echo esc_html__('Quick answers before you get started.', 'kalkan-child'); ?></p>
                    <ul class="kalkan-card-grid kalkan-card-grid--two">
                        <?php foreach ($faq_items as $faq_item) : ?>
                            <li class="kalkan-card kalkan-faq-card">
                                <span class="kalkan-icon" aria-hidden="true"><?php echo kalkan_home_inline_icon('faq'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                                <h3><?php echo esc_html($faq_item); ?></h3>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </section>

            <footer class="kalkan-site-footer" aria-label="Footer">
                <div class="kalkan-shell kalkan-site-footer__layout">
                    <div class="kalkan-site-footer__brand">
                        <a class="kalkan-brand" href="<?php echo esc_url($home_url); ?>" aria-label="Kalkan home">
                            <span class="kalkan-brand__mark">K</span>
                            <span class="kalkan-brand__wordmark">Kalkan</span>
                        </a>
                        <p>© <?php echo esc_html(date_i18n('Y')); ?> Kalkan</p>
                    </div>

                    <nav class="kalkan-site-footer__links" aria-label="Footer links">
                        <a href="<?php echo esc_url($privacy_url); ?>"><?php echo esc_html__('Privacy Policy', 'kalkan-child'); ?></a>
                        <a href="<?php echo esc_url($terms_url); ?>"><?php echo esc_html__('Terms', 'kalkan-child'); ?></a>
                        <a href="<?php echo esc_url($contact_url); ?>"><?php echo esc_html__('Contact / Support', 'kalkan-child'); ?></a>
                    </nav>

                    <div class="kalkan-site-footer__meta">
                        <div class="kalkan-language-ready" aria-label="Language-ready structure">
                            <span class="kalkan-language-ready__label"><?php echo esc_html__('Language-ready', 'kalkan-child'); ?>:</span>
                            <span class="kalkan-language-ready__item is-active">EN</span>
                            <span class="kalkan-language-ready__item">TR</span>
                        </div>

                        <?php if (!empty($social_links) && is_array($social_links)) : ?>
                            <div class="kalkan-site-footer__social" aria-label="Social links">
                                <?php foreach ($social_links as $social_link) : ?>
                                    <?php if (!empty($social_link['url']) && !empty($social_link['label'])) : ?>
                                        <a href="<?php echo esc_url($social_link['url']); ?>"><?php echo esc_html($social_link['label']); ?></a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </footer>
        </div>
    </article>
</main>

<?php
get_footer();
