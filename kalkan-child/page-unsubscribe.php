<?php
/**
 * Template Name: Unsubscribe Page
 * Template Post Type: page
 *
 * Unsubscribe page — Kalkan child theme.
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
$page_title    = 'en' === $lang ? 'Unsubscribe — Kalkan' : 'Abonelikten Çık — Kalkan';
$nonce         = wp_create_nonce( 'kalkan_unsubscribe' );

$placeholder = 'en' === $lang ? 'Enter your email' : 'E-posta adresinizi girin';
$btn_text    = 'en' === $lang ? 'Unsubscribe' : 'Abonelikten Çık';
$success_msg = 'en' === $lang ? 'You have been unsubscribed.' : 'Aboneliğiniz iptal edildi.';
$error_msg   = 'en' === $lang ? 'Something went wrong. Please try again.' : 'Bir hata oluştu. Lütfen tekrar deneyin.';
$not_found   = 'en' === $lang ? 'Email not found in our list.' : 'E-posta listemizde bulunamadı.';
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
<?php include get_stylesheet_directory() . '/inc/kalkan-styles.php'; ?>
<style>
.kk-unsub-form { max-width: 28rem; margin: 0 auto; }
.kk-unsub-row {
  display: flex; gap: 0; border-radius: 12px; overflow: hidden;
  border: 1px solid var(--kk-border);
  background: rgba(255,255,255,0.04);
  transition: border-color 0.2s;
}
.kk-unsub-row:focus-within { border-color: rgba(139,92,246,0.5); }
.kk-unsub-input {
  flex: 1; min-width: 0; padding: 0.85rem 1rem;
  background: transparent; border: none; outline: none;
  color: var(--kk-text); font-family: inherit; font-size: 0.95rem;
}
.kk-unsub-input::placeholder { color: var(--kk-text-dim); }
.kk-unsub-btn {
  display: inline-flex; align-items: center; justify-content: center;
  padding: 0 1.25rem; flex-shrink: 0; border: none; cursor: pointer;
  background: linear-gradient(135deg, #ef4444, #dc2626);
  color: #fff; font-family: inherit; font-size: 0.9rem; font-weight: 600;
  transition: opacity 0.2s; white-space: nowrap;
}
.kk-unsub-btn:hover { opacity: 0.85; }
.kk-unsub-btn:disabled { opacity: 0.5; cursor: not-allowed; }
.kk-unsub-msg {
  margin-top: 0.75rem; font-size: 0.9rem; text-align: center; min-height: 1.4em;
}
.kk-unsub-msg.success { color: var(--kk-green); }
.kk-unsub-msg.error { color: #f87171; }
.kk-unsub-form.submitted .kk-unsub-row { opacity: 0.5; pointer-events: none; }
</style>
</head>
<body <?php body_class(); ?>>

<div class="kk-page">

	<?php include get_stylesheet_directory() . '/inc/kalkan-header.php'; ?>

	<main class="kk-main">

		<div class="kk-page-header">
			<div class="kk-shell">
				<span class="kk-eyebrow"><?php echo esc_html( $__( 'Bülten', 'Newsletter' ) ); ?></span>
				<h1><?php echo esc_html( $__( 'Abonelikten Çık', 'Unsubscribe' ) ); ?></h1>
				<p class="kk-lead" style="margin-top:0.6rem;">
					<?php echo esc_html( $__( 'E-posta adresinizi girerek bülten aboneliğinizi iptal edebilirsiniz.', 'Enter your email to unsubscribe from our newsletter.' ) ); ?>
				</p>
			</div>
		</div>

		<section class="kk-section">
			<div class="kk-shell">
				<div class="kk-unsub-form" id="kk-unsub-form-wrap">
					<form id="kk-unsub-form" novalidate>
						<input type="hidden" name="kk_nonce" value="<?php echo esc_attr( $nonce ); ?>">
						<div class="kk-unsub-row">
							<input type="email" name="kk_email" class="kk-unsub-input" placeholder="<?php echo esc_attr( $placeholder ); ?>" required autocomplete="email">
							<button type="submit" class="kk-unsub-btn"><?php echo esc_html( $btn_text ); ?></button>
						</div>
						<div class="kk-unsub-msg" aria-live="polite"
							data-success="<?php echo esc_attr( $success_msg ); ?>"
							data-error="<?php echo esc_attr( $error_msg ); ?>"
							data-notfound="<?php echo esc_attr( $not_found ); ?>"></div>
					</form>
				</div>
			</div>
		</section>

	</main>

	<?php include get_stylesheet_directory() . '/inc/kalkan-footer.php'; ?>

</div>

<?php include get_stylesheet_directory() . '/inc/kalkan-scripts.php'; ?>
<script>
(function(){
  var form = document.getElementById('kk-unsub-form');
  if (!form) return;
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    var msg = form.querySelector('.kk-unsub-msg');
    var btn = form.querySelector('.kk-unsub-btn');
    msg.textContent = '';
    msg.className = 'kk-unsub-msg';
    btn.disabled = true;
    var body = new FormData();
    body.append('action', 'kalkan_unsubscribe');
    body.append('kk_nonce', form.querySelector('[name="kk_nonce"]').value);
    body.append('kk_email', form.querySelector('[name="kk_email"]').value.trim());
    fetch('<?php echo esc_url( admin_url( "admin-ajax.php" ) ); ?>', {
      method: 'POST', body: body
    }).then(function(r){ return r.json(); }).then(function(data){
      if (data.success) {
        msg.textContent = msg.getAttribute('data-success');
        msg.classList.add('success');
        form.closest('.kk-unsub-form').classList.add('submitted');
      } else {
        var m = (data.data && data.data.message) || '';
        if (m.indexOf('not found') !== -1) {
          msg.textContent = msg.getAttribute('data-notfound');
        } else {
          msg.textContent = msg.getAttribute('data-error');
        }
        msg.classList.add('error');
        btn.disabled = false;
      }
    }).catch(function(){
      msg.textContent = msg.getAttribute('data-error');
      msg.classList.add('error');
      btn.disabled = false;
    });
  });
})();
</script>
<?php wp_footer(); ?>
</body>
</html>
