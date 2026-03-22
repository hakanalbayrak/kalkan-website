<?php
/**
 * Blog listing template — Kalkan child theme.
 * In WordPress, home.php controls the blog posts page when a static front page is set.
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
$page_title    = 'en' === $lang ? 'Blog — Kalkan' : 'Blog — Kalkan';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo esc_html( $page_title ); ?></title>
<meta name="description" content="<?php echo esc_attr( $__( 'Kalkan hakkında güncellemeler, güvenlik ipuçları ve haberler.', 'Updates, security tips and news about Kalkan.' ) ); ?>">
<meta property="og:title" content="<?php echo esc_attr( $page_title ); ?>">
<meta property="og:description" content="<?php echo esc_attr( $__( 'Kalkan hakkında güncellemeler, güvenlik ipuçları ve haberler.', 'Updates, security tips and news about Kalkan.' ) ); ?>">
<meta property="og:type" content="website">
<meta property="og:image" content="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png' ); ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
<?php wp_head(); ?>
<?php include get_stylesheet_directory() . '/inc/kalkan-styles.php'; ?>
</head>
<body <?php body_class(); ?>>

<div class="kk-page">

	<?php include get_stylesheet_directory() . '/inc/kalkan-header.php'; ?>

	<main class="kk-main">

		<div class="kk-page-header">
			<div class="kk-shell">
				<span class="kk-eyebrow">Blog</span>
				<h1><?php echo esc_html( $__( 'Blog', 'Blog' ) ); ?></h1>
				<p class="kk-lead" style="margin-top:0.6rem;">
					<?php echo esc_html( $__( 'Kalkan hakkında güncellemeler, güvenlik ipuçları ve haberler.', 'Updates, security tips and news about Kalkan.' ) ); ?>
				</p>
			</div>
		</div>

		<section class="kk-section">
			<div class="kk-shell">

				<?php if ( have_posts() ) : ?>

					<div class="kk-blog-grid">
						<?php while ( have_posts() ) : the_post();
						$post_link = get_the_permalink();
						if ( 'en' === $lang ) {
							$post_link = add_query_arg( 'lang', 'en', $post_link );
						}
						$en_title   = get_post_meta( get_the_ID(), '_kalkan_title_en', true );
						$en_content = get_post_meta( get_the_ID(), '_kalkan_content_en', true );
					?>
							<article class="kk-post-card kk-glass">
								<div class="kk-post-card__date">
									<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
										<?php echo esc_html( get_the_date() ); ?>
									</time>
								</div>
								<h3>
									<a href="<?php echo esc_url( $post_link ); ?>">
										<?php echo esc_html( ( 'en' === $lang && $en_title ) ? $en_title : get_the_title() ); ?>
									</a>
								</h3>
								<div class="kk-post-card__excerpt">
									<?php
									if ( 'en' === $lang && $en_content ) {
										echo esc_html( wp_trim_words( wp_strip_all_tags( $en_content ), 30 ) );
									} else {
										echo esc_html( wp_trim_words( get_the_excerpt(), 30 ) );
									}
									?>
								</div>
								<a href="<?php echo esc_url( $post_link ); ?>" class="kk-post-card__more">
									<?php echo esc_html( $__( 'Devamını Oku →', 'Read More →' ) ); ?>
								</a>
							</article>
						<?php endwhile; ?>
					</div>

					<?php
					$pagination = paginate_links( array(
						'prev_text' => '←',
						'next_text' => '→',
						'type'      => 'array',
					) );
					if ( $pagination ) : ?>
						<nav class="kk-pagination" aria-label="<?php echo esc_attr( $__( 'Sayfalama', 'Pagination' ) ); ?>">
							<?php foreach ( $pagination as $page_link ) : ?>
								<?php echo $page_link; // phpcs:ignore WordPress.Security.EscapeOutput ?>
							<?php endforeach; ?>
						</nav>
					<?php endif; ?>

				<?php else : ?>
					<div class="kk-no-posts">
						<p><?php echo esc_html( $__( 'Henüz yazı yok. Yakında burada olacak!', 'No posts yet. Coming soon!' ) ); ?></p>
					</div>
				<?php endif; ?>

			</div>
		</section>

	</main>

	<?php include get_stylesheet_directory() . '/inc/kalkan-footer.php'; ?>

</div>

<?php include get_stylesheet_directory() . '/inc/kalkan-scripts.php'; ?>
<?php wp_footer(); ?>
</body>
</html>
