<?php
/**
 * Template Name: Contact Page
 * Template Post Type: page
 *
 * Contact page with form — Kalkan child theme.
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
$page_title    = 'en' === $lang ? 'Contact — Kalkan' : 'İletişim — Kalkan';

/* ── Form processing ───────────────────────────────────────────────────────── */
$form_message = '';
$form_status  = '';

if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['kk_contact_nonce'] ) ) {
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kk_contact_nonce'] ) ), 'kk_contact_form' ) ) {
		$form_status  = 'error';
		$form_message = $__( 'Güvenlik doğrulaması başarısız. Lütfen tekrar deneyin.', 'Security verification failed. Please try again.' );
	} else {
		$name    = isset( $_POST['kk_name'] ) ? sanitize_text_field( wp_unslash( $_POST['kk_name'] ) ) : '';
		$email   = isset( $_POST['kk_email'] ) ? sanitize_email( wp_unslash( $_POST['kk_email'] ) ) : '';
		$subject = isset( $_POST['kk_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['kk_subject'] ) ) : '';
		$message = isset( $_POST['kk_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['kk_message'] ) ) : '';

		$errors = array();
		if ( empty( $name ) ) {
			$errors[] = $__( 'Ad alanı gereklidir.', 'Name field is required.' );
		}
		if ( empty( $email ) || ! is_email( $email ) ) {
			$errors[] = $__( 'Geçerli bir e-posta adresi giriniz.', 'Please enter a valid email address.' );
		}
		if ( empty( $subject ) ) {
			$errors[] = $__( 'Konu alanı gereklidir.', 'Subject field is required.' );
		}
		if ( empty( $message ) ) {
			$errors[] = $__( 'Mesaj alanı gereklidir.', 'Message field is required.' );
		}

		if ( ! empty( $errors ) ) {
			$form_status  = 'error';
			$form_message = implode( ' ', $errors );
		} else {
			$to      = 'info@kalkan.website';
			$headers = array(
				'Content-Type: text/plain; charset=UTF-8',
				'Reply-To: ' . $name . ' <' . $email . '>',
			);
			$body    = sprintf(
				"Name: %s\nEmail: %s\nSubject: %s\n\nMessage:\n%s",
				$name,
				$email,
				$subject,
				$message
			);

			$sent = wp_mail( $to, '[Kalkan Contact] ' . $subject, $body, $headers );

			if ( $sent ) {
				$form_status  = 'success';
				$form_message = $__( 'Mesajınız gönderildi. Teşekkürler!', 'Your message has been sent. Thank you!' );
			} else {
				$form_status  = 'error';
				$form_message = $__( 'Mesaj gönderilemedi. Lütfen daha sonra tekrar deneyin.', 'Message could not be sent. Please try again later.' );
			}
		}
	}
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo esc_html( $page_title ); ?></title>
<meta name="description" content="<?php echo esc_attr( $__( 'Kalkan ile iletişime geçin. Sorularınız veya önerileriniz için bize yazın.', 'Get in touch with Kalkan. Write to us with your questions or suggestions.' ) ); ?>">
<meta property="og:title" content="<?php echo esc_attr( $page_title ); ?>">
<meta property="og:description" content="<?php echo esc_attr( $__( 'Kalkan ile iletişime geçin.', 'Get in touch with Kalkan.' ) ); ?>">
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
				<span class="kk-eyebrow"><?php echo esc_html( $__( 'İletişim', 'Contact' ) ); ?></span>
				<h1><?php echo esc_html( $__( 'İletişim', 'Contact Us' ) ); ?></h1>
				<p class="kk-lead" style="margin-top:0.6rem;">
					<?php echo esc_html( $__( 'Sorularınız veya önerileriniz için bize ulaşın.', 'Reach out to us with your questions or suggestions.' ) ); ?>
				</p>
			</div>
		</div>

		<section class="kk-section">
			<div class="kk-shell">

				<?php if ( ! empty( $form_message ) ) : ?>
					<div class="kk-form-message kk-form-message--<?php echo esc_attr( $form_status ); ?>" style="max-width:40rem;margin:0 auto 2rem;">
						<?php echo esc_html( $form_message ); ?>
					</div>
				<?php endif; ?>

				<?php if ( 'success' !== $form_status ) : ?>
					<form class="kk-contact-form" method="post" action="">
						<?php wp_nonce_field( 'kk_contact_form', 'kk_contact_nonce' ); ?>

						<div class="kk-form-group">
							<label for="kk_name"><?php echo esc_html( $__( 'Adınız', 'Your Name' ) ); ?></label>
							<input type="text" id="kk_name" name="kk_name" required
								placeholder="<?php echo esc_attr( $__( 'Adınızı giriniz', 'Enter your name' ) ); ?>"
								value="<?php echo isset( $_POST['kk_name'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_POST['kk_name'] ) ) ) : ''; ?>">
						</div>

						<div class="kk-form-group">
							<label for="kk_email"><?php echo esc_html( $__( 'E-posta Adresiniz', 'Your Email' ) ); ?></label>
							<input type="email" id="kk_email" name="kk_email" required
								placeholder="<?php echo esc_attr( $__( 'E-posta adresinizi giriniz', 'Enter your email' ) ); ?>"
								value="<?php echo isset( $_POST['kk_email'] ) ? esc_attr( sanitize_email( wp_unslash( $_POST['kk_email'] ) ) ) : ''; ?>">
						</div>

						<div class="kk-form-group">
							<label for="kk_subject"><?php echo esc_html( $__( 'Konu', 'Subject' ) ); ?></label>
							<input type="text" id="kk_subject" name="kk_subject" required
								placeholder="<?php echo esc_attr( $__( 'Konuyu giriniz', 'Enter subject' ) ); ?>"
								value="<?php echo isset( $_POST['kk_subject'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_POST['kk_subject'] ) ) ) : ''; ?>">
						</div>

						<div class="kk-form-group">
							<label for="kk_message"><?php echo esc_html( $__( 'Mesajınız', 'Your Message' ) ); ?></label>
							<textarea id="kk_message" name="kk_message" required
								placeholder="<?php echo esc_attr( $__( 'Mesajınızı yazınız', 'Write your message' ) ); ?>"><?php echo isset( $_POST['kk_message'] ) ? esc_textarea( wp_unslash( $_POST['kk_message'] ) ) : ''; ?></textarea>
						</div>

						<div class="kk-form-submit">
							<button type="submit" class="kk-btn kk-btn-primary">
								<?php echo esc_html( $__( 'Gönder', 'Send' ) ); ?>
							</button>
						</div>
					</form>
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
