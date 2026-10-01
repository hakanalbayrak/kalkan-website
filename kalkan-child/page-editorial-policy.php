<?php
/**
 * Template Name: Kalkan Editorial Policy
 *
 * @package kalkan-child
 */

if (!defined('ABSPATH')) {
    exit;
}

include get_stylesheet_directory() . '/inc/kalkan-setup.php';
$is_front_page = false;
$page_title = $__( 'Kalkan İçerik İlkeleri', 'Kalkan Editorial Policy' ) . ' — Kalkan';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <span class="kk-eyebrow"><?php echo esc_html( $__( 'Şeffaflık', 'Transparency' ) ); ?></span>
                <h1><?php echo esc_html( $__( 'Kalkan İçerik İlkeleri', 'Kalkan Editorial Policy' ) ); ?></h1>
                <p class="kk-lead"><?php echo esc_html( $__(
                    'Telefon güvenliği içeriklerimizi nasıl araştırdığımızı, kaynakları nasıl değerlendirdiğimizi ve hataları nasıl düzelttiğimizi açıklıyoruz.',
                    'How we research phone-safety guidance, evaluate sources, and correct mistakes.'
                ) ); ?></p>
            </div>
        </div>

        <section class="kk-section">
            <div class="kk-shell">
                <article class="kk-page-content" style="max-width:52rem;margin:0 auto;">
                <?php if ('en' === $lang) : ?>
                    <p><strong>Last updated: 1 October 2026.</strong> Kalkan publishes practical guidance about unwanted calls, caller identification, iPhone call settings, and telephone-fraud warning signs. This policy explains the standards used by the Kalkan Editorial Team. It also describes the limits of what a caller label, public complaint, or number lookup can prove.</p>

                    <h2>Purpose and scope</h2>
                    <p>Our goal is to help readers make a safer decision before answering a call, sharing information, installing software, or sending money. We describe current Kalkan features accurately and separate product capabilities from general iPhone guidance. We do not promise complete protection, identify private people, or treat a displayed caller name as proof that a caller is genuine.</p>

                    <h2>Source hierarchy</h2>
                    <p>We prefer primary sources: Apple documentation for iPhone behavior; official government, regulator, bank, carrier, or organization pages for institutional guidance; and Kalkan’s current product behavior for Kalkan features. When a primary source is unavailable, we may use a reputable secondary source and clearly preserve uncertainty.</p>
                    <p>Complaint sites and community comments are discovery signals only. They may be outdated, incomplete, mistaken, affected by number recycling, or describe spoofed caller ID. We do not present a complaint as proof that a named person or organization made a call.</p>

                    <h2>How phone numbers are discussed</h2>
                    <p>An institutional number is described only when it is visible on the organization’s official HTTPS page or another authoritative first-party channel. A suspicious-number report is described neutrally. Labels such as “reported advertising call” or “community-reported suspicious call” communicate the evidence level without declaring a person guilty or a number permanently unsafe.</p>

                    <h2>Writing and review</h2>
                    <p>Articles are prepared by the Kalkan Editorial Team. Before publication or material revision, we check the stated iOS path, current Kalkan behavior, internal links, factual limitations, and the availability of cited sources. Content must provide a concrete reader outcome: a verified setting path, a decision checklist, an official verification method, or a clear explanation of product behavior.</p>

                    <h2>Updates and corrections</h2>
                    <p>Articles show their original publication date and a modified date after a material update. We review pages when iOS menus, Kalkan features, regulations, official source URLs, or known scam patterns change. If you find an error, send the page URL and the correction to <a href="mailto:info@kalkanapp.com">info@kalkanapp.com</a>. We verify the report and correct confirmed errors without hiding the article’s updated date.</p>

                    <h2>Advertising independence</h2>
                    <p>Advertising supports the website but does not determine an article’s conclusion, source selection, or safety recommendation. Ads are visually separated from editorial content. Paid placement does not make a phone number, organization, app, or service trusted. Product comparisons should explain meaningful differences and limitations rather than manufacture a winner.</p>

                    <h2>Safety and professional-advice limits</h2>
                    <p>Kalkan content is educational and is not legal, financial, medical, or emergency advice. Caller ID can be spoofed, phone numbers can be reassigned, and new unwanted numbers can appear before any protection list is updated. End suspicious calls and independently contact the organization using its official website, app, card, or published switchboard. Contact local emergency services when there is immediate danger.</p>

                    <h2>Privacy and respectful reporting</h2>
                    <p>Do not send passwords, one-time codes, banking information, private conversations, or unnecessary personal data when reporting a correction or suspicious call. We avoid copying complaint narratives or identifying private individuals. Read the <a href="<?php echo esc_url($privacy_url); ?>">Privacy Policy</a> for website and app data practices.</p>

                    <h2>Contact</h2>
                    <p>Questions, source suggestions, and correction requests can be sent through the <a href="<?php echo esc_url($contact_url); ?>">contact page</a> or to <a href="mailto:info@kalkanapp.com">info@kalkanapp.com</a>.</p>
                <?php else : ?>
                    <p><strong>Son güncelleme: 1 Ekim 2026.</strong> Kalkan; istenmeyen aramalar, arayan kimliği, iPhone arama ayarları ve telefon dolandırıcılığı işaretleri hakkında uygulanabilir içerikler yayımlar. Bu sayfa Kalkan İçerik Ekibinin kullandığı standartları ve bir arayan etiketi, açık kaynak yorumu veya numara sorgusunun neleri kanıtlayamayacağını açıklar.</p>

                    <h2>Amaç ve kapsam</h2>
                    <p>Amacımız okuyucunun bir aramayı yanıtlamadan, bilgi paylaşmadan, uygulama yüklemeden veya ödeme yapmadan önce daha güvenli bir karar vermesine yardımcı olmaktır. Kalkan’ın mevcut özelliklerini doğru biçimde açıklar, ürün özellikleriyle genel iPhone yönlendirmesini birbirinden ayırırız. Tam koruma garantisi vermeyiz, özel kişilerin kimliğini açıklamayız ve ekranda görünen kurum adını arayanın gerçek olduğunun kanıtı olarak sunmayız.</p>

                    <h2>Kaynak sıralamamız</h2>
                    <p>Birincil kaynaklara öncelik veririz: iPhone davranışları için Apple belgeleri; kurumsal bilgiler için ilgili kamu kurumu, düzenleyici, banka, operatör veya kuruluşun resmî sayfası; Kalkan özellikleri için güncel ürün davranışı ve Kalkan dokümantasyonu. Birincil kaynak bulunmadığında güvenilir ikincil kaynaklardan yararlanabilir ve belirsizliği açıkça belirtiriz.</p>
                    <p>Şikâyet siteleri ve topluluk yorumları yalnızca araştırma sinyalidir. Kayıt eski, eksik veya hatalı olabilir; numara yeniden tahsis edilmiş ya da arayan kimliği taklit edilmiş olabilir. Bir yorumu, belirli bir kişi veya kurumun aramayı yaptığının kesin kanıtı olarak sunmayız.</p>

                    <h2>Telefon numaralarını nasıl değerlendiriyoruz?</h2>
                    <p>Bir kurumsal numarayı ancak kuruluşun resmî HTTPS sayfasında veya başka bir yetkili birinci taraf kanalında açıkça yayımlanıyorsa kurumsal eşleşme olarak değerlendiririz. Şüpheli numara bildirimlerini tarafsız dille açıklarız. “Reklam araması olarak bildirilmiş” veya “toplulukta şüpheli olarak raporlanmış” gibi ifadeler kanıt seviyesini gösterir; bir kişiyi suçlu ya da bir numarayı sonsuza kadar güvensiz ilan etmez.</p>

                    <h2>Yazım ve inceleme süreci</h2>
                    <p>İçerikler Kalkan İçerik Ekibi tarafından hazırlanır. Yayın veya önemli güncelleme öncesinde anlatılan iOS yolunu, Kalkan’ın güncel davranışını, iç bağlantıları, güvenlik sınırlamalarını ve kaynakların erişilebilirliğini kontrol ederiz. Her içerik okuyucuya somut bir sonuç sunmalıdır: doğrulanmış ayar yolu, karar kontrol listesi, resmî doğrulama yöntemi veya ürün davranışının açık açıklaması.</p>

                    <h2>Güncelleme ve düzeltmeler</h2>
                    <p>Makalelerde ilk yayın tarihi ve önemli bir değişiklik yapıldığında güncellenme tarihi gösterilir. iOS menüleri, Kalkan özellikleri, mevzuat, resmî kaynak adresleri veya yaygın dolandırıcılık yöntemleri değiştiğinde ilgili sayfaları inceleriz. Bir hata görürseniz sayfa bağlantısını ve önerilen düzeltmeyi <a href="mailto:info@kalkanapp.com">info@kalkanapp.com</a> adresine iletebilirsiniz. Bildirimi doğrular, doğrulanan hatayı düzeltir ve güncellenme tarihini görünür tutarız.</p>

                    <h2>Reklamdan bağımsızlık</h2>
                    <p>Reklamlar sitenin işletilmesine katkı sağlayabilir; ancak bir içeriğin sonucunu, kaynak seçimini veya güvenlik tavsiyesini belirlemez. Reklam alanları editoryal içerikten görsel olarak ayrılır. Ücretli gösterim bir telefon numarasını, kurumu, uygulamayı veya hizmeti güvenilir yapmaz. Ürün karşılaştırmaları yapay bir kazanan üretmek yerine anlamlı farkları ve sınırlamaları açıklamalıdır.</p>

                    <h2>Güvenlik ve profesyonel tavsiye sınırı</h2>
                    <p>Kalkan içerikleri eğitim amaçlıdır; hukuki, finansal, tıbbi veya acil durum danışmanlığı değildir. Arayan kimliği taklit edilebilir, telefon numaraları yeniden tahsis edilebilir ve yeni istenmeyen numaralar koruma listeleri güncellenmeden önce ortaya çıkabilir. Şüpheli görüşmeyi sonlandırın ve kuruma resmî web sitesi, uygulaması, kartı veya yayımlanmış santral numarası üzerinden kendiniz ulaşın. Acil tehlikede 112’yi arayın.</p>

                    <h2>Gizlilik ve saygılı bildirim</h2>
                    <p>Düzeltme veya şüpheli arama bildirirken şifre, tek kullanımlık kod, banka bilgisi, özel konuşma ya da gereksiz kişisel veri göndermeyin. Şikâyet metinlerini kopyalamaktan ve özel kişileri teşhis etmekten kaçınırız. Uygulama ve web sitesi veri uygulamaları için <a href="<?php echo esc_url($privacy_url); ?>">Gizlilik Politikasını</a> inceleyin.</p>

                    <h2>İletişim</h2>
                    <p>Soru, kaynak önerisi ve düzeltme taleplerinizi <a href="<?php echo esc_url($contact_url); ?>">iletişim sayfasından</a> veya <a href="mailto:info@kalkanapp.com">info@kalkanapp.com</a> adresinden iletebilirsiniz.</p>
                <?php endif; ?>
                </article>
            </div>
        </section>
    </main>
    <?php include get_stylesheet_directory() . '/inc/kalkan-footer.php'; ?>
</div>
<?php include get_stylesheet_directory() . '/inc/kalkan-scripts.php'; ?>
<?php wp_footer(); ?>
</body>
</html>
