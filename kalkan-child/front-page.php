<?php
/**
 * Front page template for Kalkan child theme.
 *
 * This template intentionally renders homepage content from code to keep
 * output consistent, fast, and easy to iterate via the repository.
 *
 * @package kalkan-child
 */

if (!defined('ABSPATH')) {
    exit;
}

// Allow safe App Store URL override via filter.
$app_store_url = apply_filters('kalkan_app_store_url', '#');
$app_store_url = esc_url($app_store_url);
$learn_more_url = '#kalkan-how-it-works';

// Resolve supporting policy/contact links while keeping safe fallbacks.
$privacy_url = get_privacy_policy_url();
if (empty($privacy_url)) {
    $privacy_url = home_url('/privacy-policy/');
}

$terms_page = get_page_by_path('terms');
$terms_url  = $terms_page ? get_permalink($terms_page) : home_url('/terms/');

$support_page = get_page_by_path('contact');
if (!$support_page) {
    $support_page = get_page_by_path('support');
}
$support_url = $support_page ? get_permalink($support_page) : home_url('/contact/');

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
    <article class="kalkan-home">
        <?php // Hero section ?>
        <section class="kalkan-section kalkan-hero" aria-labelledby="kalkan-hero-title">
            <div class="kalkan-container">
                <h1 id="kalkan-hero-title" class="kalkan-hero__headline"><?php echo esc_html__('Caller safety made simple', 'kalkan-child'); ?></h1>
                <p class="kalkan-hero__body"><?php echo esc_html__('Kalkan helps you understand unknown calls before you answer. Identify suspicious numbers, reduce spam disruptions, and protect daily communication with a simple, easy-to-use app.', 'kalkan-child'); ?></p>
                <p class="kalkan-hero__supporting"><?php echo esc_html__('Built for everyday use, including families and older adults.', 'kalkan-child'); ?></p>
                <div class="kalkan-actions">
                    <a class="kalkan-button-primary" href="<?php echo $app_store_url; ?>"><?php echo esc_html__('App Store', 'kalkan-child'); ?></a>
                    <a class="kalkan-button-secondary" href="<?php echo esc_url($learn_more_url); ?>"><?php echo esc_html__('Learn more', 'kalkan-child'); ?></a>
                </div>
            </div>
        </section>

        <?php // How It Works section ?>
        <section id="kalkan-how-it-works" class="kalkan-section kalkan-how" aria-labelledby="kalkan-how-title">
            <div class="kalkan-container">
                <h2 id="kalkan-how-title"><?php echo esc_html__('How Kalkan works', 'kalkan-child'); ?></h2>
                <p><?php echo esc_html__('Start in minutes with three simple steps.', 'kalkan-child'); ?></p>
                <ul class="kalkan-list">
                    <li><?php echo esc_html__('Download Kalkan from the App Store', 'kalkan-child'); ?></li>
                    <li><?php echo esc_html__('Turn on spam protection and caller identification', 'kalkan-child'); ?></li>
                    <li><?php echo esc_html__('Report suspicious calls when needed to help improve community safety signals', 'kalkan-child'); ?></li>
                </ul>
            </div>
        </section>

        <?php // Core Features section ?>
        <section class="kalkan-section kalkan-features" aria-labelledby="kalkan-features-title">
            <div class="kalkan-container">
                <h2 id="kalkan-features-title"><?php echo esc_html__('Core features that protect your calls', 'kalkan-child'); ?></h2>
                <p><?php echo esc_html__('Kalkan focuses on practical protection, not complexity.', 'kalkan-child'); ?></p>
                <div class="kalkan-grid kalkan-grid--three">
                    <article class="kalkan-card">
                        <h3><?php echo esc_html__('Spam Protection', 'kalkan-child'); ?></h3>
                        <p><?php echo esc_html__('Reduce interruptions from unwanted callers.', 'kalkan-child'); ?></p>
                    </article>
                    <article class="kalkan-card">
                        <h3><?php echo esc_html__('Caller Identification', 'kalkan-child'); ?></h3>
                        <p><?php echo esc_html__('See clearer caller context for unknown numbers.', 'kalkan-child'); ?></p>
                    </article>
                    <article class="kalkan-card">
                        <h3><?php echo esc_html__('Extra Protection', 'kalkan-child'); ?></h3>
                        <p><?php echo esc_html__('Add stronger day-to-day call safety with simple controls.', 'kalkan-child'); ?></p>
                    </article>
                </div>
            </div>
        </section>

        <?php // Communication Reporting section ?>
        <section class="kalkan-section kalkan-reporting" aria-labelledby="kalkan-reporting-title">
            <div class="kalkan-container">
                <h2 id="kalkan-reporting-title"><?php echo esc_html__('Report suspicious calls in seconds', 'kalkan-child'); ?></h2>
                <p><?php echo esc_html__('If a call looks suspicious, you can report it directly in the app. Communication Reporting is free. Your reports help improve community awareness and support safer calling for everyone.', 'kalkan-child'); ?></p>
                <p><?php echo esc_html__('No technical setup needed.', 'kalkan-child'); ?></p>
            </div>
        </section>

        <?php // Trust and Privacy section ?>
        <section class="kalkan-section kalkan-trust" aria-labelledby="kalkan-trust-title">
            <div class="kalkan-container">
                <h2 id="kalkan-trust-title"><?php echo esc_html__('Built with trust and privacy in mind', 'kalkan-child'); ?></h2>
                <p><?php echo esc_html__('Kalkan is designed to be clear, respectful, and easy to understand. Privacy and transparent communication are core priorities, with clear policy pages and support access on the website.', 'kalkan-child'); ?></p>
                <div class="kalkan-inline-links">
                    <a href="<?php echo esc_url($privacy_url); ?>"><?php echo esc_html__('Privacy Policy', 'kalkan-child'); ?></a>
                    <a href="<?php echo esc_url($terms_url); ?>"><?php echo esc_html__('Terms', 'kalkan-child'); ?></a>
                    <a href="<?php echo esc_url($support_url); ?>"><?php echo esc_html__('Contact / Support', 'kalkan-child'); ?></a>
                </div>
            </div>
        </section>

        <?php // Final App Store CTA section ?>
        <section class="kalkan-section kalkan-cta" aria-labelledby="kalkan-cta-title">
            <div class="kalkan-container">
                <h2 id="kalkan-cta-title"><?php echo esc_html__('Get Kalkan on the App Store', 'kalkan-child'); ?></h2>
                <p class="kalkan-cta__body"><?php echo esc_html__('Ready for safer calls and clearer caller information? Install Kalkan and set up protection in minutes.', 'kalkan-child'); ?></p>
                <div class="kalkan-actions">
                    <a class="kalkan-button-primary" href="<?php echo $app_store_url; ?>"><?php echo esc_html__('App Store', 'kalkan-child'); ?></a>
                </div>
            </div>
        </section>

        <?php // FAQ Preview section ?>
        <section class="kalkan-section kalkan-faq" aria-labelledby="kalkan-faq-title">
            <div class="kalkan-container">
                <h2 id="kalkan-faq-title"><?php echo esc_html__('Common questions', 'kalkan-child'); ?></h2>
                <p><?php echo esc_html__('Quick answers before you get started.', 'kalkan-child'); ?></p>
                <ul class="kalkan-list">
                    <?php foreach ($faq_items as $faq_item) : ?>
                        <li><?php echo esc_html($faq_item); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    </article>
</main>

<?php
get_footer();
