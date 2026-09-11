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
$is_category_archive = is_category();
$archive_title = $is_category_archive ? single_cat_title( '', false ) : 'Blog';
$archive_lead  = $is_category_archive ? wp_strip_all_tags( category_description() ) : '';

if ( '' === trim( $archive_lead ) ) {
	$archive_lead = $__(
		'Kalkan hakkında güncellemeler, güvenlik ipuçları ve haberler.',
		'Updates, security tips and news about Kalkan.'
	);
}

$page_title = $archive_title . ' — Kalkan';
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
</head>
<body <?php body_class(); ?>>

<div class="kk-page">

	<?php include get_stylesheet_directory() . '/inc/kalkan-header.php'; ?>

	<main class="kk-main">

		<div class="kk-page-header">
			<div class="kk-shell">
				<span class="kk-eyebrow"><?php echo esc_html( $is_category_archive ? $__( 'Duyurular', 'Announcements' ) : 'Blog' ); ?></span>
				<h1><?php echo esc_html( $archive_title ); ?></h1>
				<p class="kk-lead" style="margin-top:0.6rem;">
					<?php echo esc_html( $archive_lead ); ?>
				</p>
			</div>
		</div>

		<section class="kk-section">
			<div class="kk-shell">
				<div class="kk-page-content" style="max-width:52rem;margin:0 auto 2.5rem;padding:0;">
					<?php if ('tr' === $lang) : ?>
						<p>Kalkan blogunda istenmeyen aramalar, telefon dolandırıcılığı, sahte kurum aramaları ve iPhone arama güvenliği hakkında uygulanabilir rehberler bulabilirsiniz. İçerikler, bir aramaya yanıt vermeden önce hangi işaretlere bakmanız gerektiğini, şüpheli talepleri nasıl doğrulayacağınızı ve kişisel bilgilerinizi nasıl koruyacağınızı açıklar. Ürün duyuruları ve sürüm notları da Kalkan'ın koruma özelliklerindeki değişiklikleri takip etmenize yardımcı olur.</p>
						<p>Bir arayanın ekranda görünen numarası veya kurum adı tek başına güven kanıtı değildir. Şüpheli bir görüşmede işlemi durdurun; kuruma yalnızca resmî web sitesi, mobil uygulama veya kartınızın üzerindeki bağımsız iletişim kanalından ulaşın. Kalkan'ın rehberleri bu doğrulama alışkanlığını günlük kullanımda daha kolay uygulamanız için hazırlanır. Her içerikte uygulanabilir kontrol adımlarına ve güvenli karar vermeyi destekleyen tarafsız açıklamalara öncelik verilir.</p>
					<?php else : ?>
						<p>The Kalkan blog provides practical guidance on unwanted calls, telephone fraud, impersonation attempts and iPhone call safety. Articles explain what to check before answering or acting on a request, how to verify an organization through an independent official channel, and how to protect account and identity information. Product announcements and release notes also document changes to Kalkan's on-device call protection and caller identification features.</p>
						<p>A displayed number or organization name is not proof that a caller is genuine. If a request feels suspicious, stop the conversation and contact the organization through an independent channel from its official website, app, or your physical card. Kalkan's guides turn that verification habit into clear steps you can use during everyday calls.</p>
					<?php endif; ?>
				</div>

				<?php if ( have_posts() ) : ?>

					<div class="kk-blog-grid">
						<?php while ( have_posts() ) : the_post();
						$post_link = get_the_permalink();
						if ( 'en' === $lang && function_exists( 'pll_get_post' ) ) {
							$pll_translated = pll_get_post( get_the_ID() );
							if ( $pll_translated ) {
								$post_link = get_permalink( $pll_translated );
							}
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
								<h2 class="kk-post-card__title">
									<a href="<?php echo esc_url( $post_link ); ?>">
										<?php echo esc_html( ( 'en' === $lang && $en_title ) ? $en_title : get_the_title() ); ?>
									</a>
								</h2>
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
