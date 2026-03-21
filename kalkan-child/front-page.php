<?php
/**
 * Front page template for Kalkan child theme.
 *
 * @package kalkan-child
 */

if (!defined('ABSPATH')) {
    exit;
}

$app_store_url = apply_filters('kalkan_app_store_url', '#');
$app_store_url = esc_url($app_store_url);
$learn_more_url = '#kalkan-how-it-works';

$asset_base_url      = trailingslashit(get_stylesheet_directory_uri()) . 'assets/';
$app_store_badge_url = $asset_base_url . 'badges/app-store-badge.svg';
$iphone_frame_url    = $asset_base_url . 'images/iphone-frame.svg';
$app_screen_url      = $asset_base_url . 'images/app-screenshot-home.svg';

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

$how_steps = array(
    'Download Kalkan from the App Store',
    'Turn on spam protection and caller identification',
    'Report suspicious calls when needed to help improve community safety signals',
);

$feature_cards = array(
    array(
        'title' => 'Spam Protection',
        'body'  => 'Reduce interruptions from unwanted callers.',
    ),
    array(
        'title' => 'Caller Identification',
        'body'  => 'See clearer caller context for unknown numbers.',
    ),
    array(
        'title' => 'Extra Protection',
        'body'  => 'Add stronger day-to-day call safety with simple controls.',
    ),
);

$trust_cards = array(
    array(
        'title' => 'Privacy-first approach',
        'body'  => 'Clear privacy messaging and transparent communication are built into the experience.',
    ),
    array(
        'title' => 'Simple for everyone',
        'body'  => 'The product is designed to stay understandable for families and older adults.',
    ),
    array(
        'title' => 'Community-minded reporting',
        'body'  => 'Communication Reporting is free and helps improve awareness for everyone.',
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

get_header();
?>

<main id="primary" class="site-main">
    <article class="kalkan-home" aria-label="Kalkan homepage">
        <?php // Hero ?>
        <section class="kalkan-section kalkan-section--soft kalkan-hero" aria-labelledby="kalkan-hero-title">
            <div class="kalkan-container kalkan-hero__layout">
                <div class="kalkan-hero__content">
                    <h1 id="kalkan-hero-title" class="kalkan-hero__headline"><?php echo esc_html__('Caller safety made simple', 'kalkan-child'); ?></h1>
                    <p class="kalkan-hero__body"><?php echo esc_html__('Kalkan helps you understand unknown calls before you answer. Identify suspicious numbers, reduce spam interruptions, and protect daily communication with a simple, easy-to-use app.', 'kalkan-child'); ?></p>
                    <p class="kalkan-hero__supporting"><?php echo esc_html__('Built for everyday use, including families and older adults.', 'kalkan-child'); ?></p>

                    <div class="kalkan-actions">
                        <a class="kalkan-button-primary" href="<?php echo $app_store_url; ?>"><?php echo esc_html__('App Store', 'kalkan-child'); ?></a>
                        <a class="kalkan-button-secondary" href="<?php echo esc_url($learn_more_url); ?>"><?php echo esc_html__('Learn more', 'kalkan-child'); ?></a>
                    </div>

                    <div class="kalkan-app-store" aria-label="App Store badge area">
                        <a class="kalkan-app-store__link" href="<?php echo $app_store_url; ?>">
                            <img class="kalkan-app-store__badge" src="<?php echo esc_url($app_store_badge_url); ?>" alt="Download on the App Store" loading="lazy" decoding="async">
                        </a>
                    </div>
                </div>

                <div class="kalkan-hero__visual" aria-hidden="true">
                    <div class="kalkan-device-mockup">
                        <img class="kalkan-device-mockup__screen" src="<?php echo esc_url($app_screen_url); ?>" alt="" loading="lazy" decoding="async">
                        <img class="kalkan-device-mockup__frame" src="<?php echo esc_url($iphone_frame_url); ?>" alt="" loading="lazy" decoding="async">
                    </div>
                </div>
            </div>
        </section>

        <?php // How It Works ?>
        <section id="kalkan-how-it-works" class="kalkan-section kalkan-how" aria-labelledby="kalkan-how-title">
            <div class="kalkan-container">
                <h2 id="kalkan-how-title"><?php echo esc_html__('How Kalkan works', 'kalkan-child'); ?></h2>
                <p class="kalkan-section__lead"><?php echo esc_html__('Start in minutes with three simple steps.', 'kalkan-child'); ?></p>
                <ul class="kalkan-step-list">
                    <?php foreach ($how_steps as $index => $step_text) : ?>
                        <li class="kalkan-step-card">
                            <h3><?php echo esc_html(sprintf('Step %d', $index + 1)); ?></h3>
                            <p><?php echo esc_html($step_text); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

        <?php // Core Features ?>
        <section class="kalkan-section kalkan-section--soft kalkan-features" aria-labelledby="kalkan-features-title">
            <div class="kalkan-container">
                <h2 id="kalkan-features-title"><?php echo esc_html__('Core features that protect your calls', 'kalkan-child'); ?></h2>
                <p class="kalkan-section__lead"><?php echo esc_html__('Kalkan focuses on practical protection, not complexity.', 'kalkan-child'); ?></p>
                <ul class="kalkan-card-grid kalkan-card-grid--three" role="list">
                    <?php foreach ($feature_cards as $feature_card) : ?>
                        <li class="kalkan-card kalkan-feature-card">
                            <h3><?php echo esc_html($feature_card['title']); ?></h3>
                            <p><?php echo esc_html($feature_card['body']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

        <?php // Communication Reporting ?>
        <section class="kalkan-section kalkan-reporting" aria-labelledby="kalkan-reporting-title">
            <div class="kalkan-container">
                <div class="kalkan-highlight-card">
                    <h2 id="kalkan-reporting-title"><?php echo esc_html__('Report suspicious calls in seconds', 'kalkan-child'); ?></h2>
                    <p><?php echo esc_html__('If a call looks suspicious, you can report it directly in the app. Communication Reporting is free. Your reports help improve community awareness and support safer calling for everyone.', 'kalkan-child'); ?></p>
                    <p><?php echo esc_html__('No technical setup needed.', 'kalkan-child'); ?></p>
                </div>
            </div>
        </section>

        <?php // Trust and Privacy ?>
        <section class="kalkan-section kalkan-section--soft kalkan-trust" aria-labelledby="kalkan-trust-title">
            <div class="kalkan-container">
                <h2 id="kalkan-trust-title"><?php echo esc_html__('Built with trust and privacy in mind', 'kalkan-child'); ?></h2>
                <p class="kalkan-section__lead"><?php echo esc_html__('Kalkan is designed to be clear, respectful, and easy to understand. Privacy and transparent communication are core priorities, with clear policy pages and support access on the website.', 'kalkan-child'); ?></p>
                <ul class="kalkan-card-grid kalkan-card-grid--three" role="list">
                    <?php foreach ($trust_cards as $trust_card) : ?>
                        <li class="kalkan-card kalkan-trust-card">
                            <h3><?php echo esc_html($trust_card['title']); ?></h3>
                            <p><?php echo esc_html($trust_card['body']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="kalkan-inline-links">
                    <a href="<?php echo esc_url($privacy_url); ?>"><?php echo esc_html__('Privacy Policy', 'kalkan-child'); ?></a>
                    <a href="<?php echo esc_url($terms_url); ?>"><?php echo esc_html__('Terms', 'kalkan-child'); ?></a>
                    <a href="<?php echo esc_url($contact_url); ?>"><?php echo esc_html__('Contact', 'kalkan-child'); ?></a>
                </div>
            </div>
        </section>

        <?php // App Store CTA ?>
        <section class="kalkan-section kalkan-cta" aria-labelledby="kalkan-cta-title">
            <div class="kalkan-container">
                <div class="kalkan-cta-card">
                    <h2 id="kalkan-cta-title"><?php echo esc_html__('Get Kalkan on the App Store', 'kalkan-child'); ?></h2>
                    <p><?php echo esc_html__('Ready for safer calls and clearer caller information? Install Kalkan and set up protection in minutes.', 'kalkan-child'); ?></p>
                    <div class="kalkan-actions">
                        <a class="kalkan-button-primary" href="<?php echo $app_store_url; ?>"><?php echo esc_html__('App Store', 'kalkan-child'); ?></a>
                    </div>
                    <div class="kalkan-app-store kalkan-app-store--centered" aria-label="App Store badge area">
                        <a class="kalkan-app-store__link" href="<?php echo $app_store_url; ?>">
                            <img class="kalkan-app-store__badge" src="<?php echo esc_url($app_store_badge_url); ?>" alt="Download on the App Store" loading="lazy" decoding="async">
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <?php // FAQ Preview ?>
        <section class="kalkan-section kalkan-section--soft kalkan-faq" aria-labelledby="kalkan-faq-title">
            <div class="kalkan-container">
                <h2 id="kalkan-faq-title"><?php echo esc_html__('Common questions', 'kalkan-child'); ?></h2>
                <p class="kalkan-section__lead"><?php echo esc_html__('Quick answers before you get started.', 'kalkan-child'); ?></p>
                <ul class="kalkan-card-grid kalkan-card-grid--two" role="list">
                    <?php foreach ($faq_items as $faq_item) : ?>
                        <li class="kalkan-card kalkan-faq-card">
                            <h3><?php echo esc_html($faq_item); ?></h3>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    </article>
</main>

<?php
get_footer();
