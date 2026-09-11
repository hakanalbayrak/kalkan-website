<?php
/**
 * Single Post Template — Kalkan child theme.
 * Fully self-contained: no get_header()/get_footer() to avoid Blocksy conflicts.
 *
 * @package kalkan-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ── Shared setup ──────────────────────────────────────────────────────────── */
include get_stylesheet_directory() . '/inc/kalkan-setup.php';

$is_front_page = false;

/* ── Bilingual post data ───────────────────────────────────────────────────── */
$en_title   = '';
$en_content = '';
if ( 'en' === $lang && have_posts() ) {
	the_post();
	$en_title   = get_post_meta( get_the_ID(), '_kalkan_title_en', true );
	$en_content = get_post_meta( get_the_ID(), '_kalkan_content_en', true );
	rewind_posts();
}

$display_title = ( 'en' === $lang && $en_title ) ? $en_title : get_the_title();
$page_title    = $display_title . ' — Kalkan';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
<?php wp_head(); ?>
<?php echo $_kk_seo_tags(); ?>
<link rel="stylesheet" href="<?php echo esc_url(kalkan_ui_stylesheet_url()); ?>">
<style>
/* ── Single post styles ───────────────────────────────────────────────────── */
.kk-post {
  max-width: 780px;
  margin: 0 auto;
  padding: 2rem 1.5rem 5rem;
}
.kk-post__meta {
  color: rgba(245, 243, 255, 0.5);
  font-size: 0.875rem;
  margin-bottom: 0.5rem;
}
.kk-post__title {
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
  font-size: clamp(1.75rem, 4vw, 2.6rem);
  font-weight: 800;
  line-height: 1.2;
  letter-spacing: -0.02em;
  margin-bottom: 2rem;
  color: #f5f3ff;
}
.kk-post__body {
  color: rgba(245, 243, 255, 0.85);
  font-size: 1.06rem;
  line-height: 1.8;
}
.kk-post__body h2 {
  color: #f5f3ff;
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
  font-size: 1.5rem;
  font-weight: 700;
  margin-top: 2.5rem;
  margin-bottom: 1rem;
}
.kk-post__body p {
  margin-bottom: 1.125rem;
}
.kk-post__body ul {
  margin-bottom: 1.125rem;
  padding-left: 1.5rem;
}
.kk-post__body li {
  margin-bottom: 0.5rem;
  line-height: 1.7;
}
.kk-post__body strong {
  color: #f5f3ff;
  font-weight: 600;
}
.kk-post__body a {
  color: #a78bfa;
  text-decoration: underline;
  text-underline-offset: 3px;
}
.kk-post__nav {
  margin-top: 3.75rem;
  padding-top: 1.875rem;
  border-top: 1px solid rgba(255, 255, 255, 0.08);
  text-align: center;
}
.kk-post__nav a {
  color: #a78bfa;
  text-decoration: none;
  font-weight: 600;
  font-size: 0.9375rem;
}
.kk-post__nav a:hover {
  text-decoration: underline;
}
.kk-post__adjacent {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(13rem, 1fr));
  gap: 1rem;
  margin-bottom: 1.5rem;
  text-align: left;
}
.kk-post__adjacent a {
  display: block;
  padding: 0.9rem 1rem;
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 0.75rem;
}
</style>
</head>
<body <?php body_class(); ?>>

<div class="kk-page">

	<?php include get_stylesheet_directory() . '/inc/kalkan-header.php'; ?>

	<main class="kk-main">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article class="kk-post">
				<div class="kk-post__meta">
					<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
						<?php echo esc_html( get_the_date() ); ?>
					</time>
				</div>

				<h1 class="kk-post__title">
					<?php echo esc_html( ( 'en' === $lang && $en_title ) ? $en_title : get_the_title() ); ?>
				</h1>

				<div class="kk-post__body">
					<?php
					if ( 'en' === $lang && $en_content ) {
						echo wp_kses_post( $en_content );
					} else {
						the_content();
					}
					?>
				</div>

				<aside class="kk-post__body" aria-label="<?php echo esc_attr($__( 'Kalkan hakkında', 'About Kalkan' )); ?>">
					<h2><?php echo esc_html($__( 'Kalkan ile arama koruması', 'Call protection with Kalkan' )); ?></h2>
					<p><?php echo esc_html($__(
						'Kalkan, bilinen istenmeyen numaraları iOS Arama Dizini üzerinden cihazınızda engellemeye ve kurumsal numaraları arayan kimliği etiketiyle tanımanıza yardımcı olur. Rehberiniz ve kişisel arama geçmişiniz Kalkan sunucularına yüklenmez. Yeni veya taklit edilmiş numaralar her zaman ortaya çıkabileceği için, ekrandaki etiketten bağımsız olarak hassas talepleri kurumun resmî kanalından doğrulayın.',
						'Kalkan uses iOS Call Directory to help block known unwanted numbers on your device and identify institutional numbers with caller-ID labels. Your contacts and personal call history are not uploaded to Kalkan servers. Because new or spoofed numbers can still appear, verify sensitive requests through the organization\'s independent official channel even when a label is displayed.'
					)); ?></p>
				</aside>

				<div class="kk-post__nav">
					<div class="kk-post__adjacent">
						<?php previous_post_link('%link', '&larr; %title'); ?>
						<?php next_post_link('%link', '%title &rarr;'); ?>
					</div>
					<a href="<?php echo esc_url( $blog_url ); ?>">
						&larr; <?php echo esc_html( $__( 'Blog\'a Dön', 'Back to Blog' ) ); ?>
					</a>
					<span aria-hidden="true"> · </span>
					<a href="<?php echo esc_url($documentation_url); ?>">
						<?php echo esc_html($__( 'Kalkan Dokümantasyonu', 'Kalkan Documentation' )); ?>
					</a>
				</div>
			</article>

		<?php endwhile; endif; ?>

	</main>

	<?php include get_stylesheet_directory() . '/inc/kalkan-footer.php'; ?>

</div>

<?php include get_stylesheet_directory() . '/inc/kalkan-scripts.php'; ?>
<?php wp_footer(); ?>
</body>
</html>
