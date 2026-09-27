<?php
/**
 * Search-intent content and metadata for Kalkan's Turkish acquisition pages.
 *
 * @package kalkan-child
 */

if (!defined('ABSPATH')) {
    exit;
}

/** Find a post without depending on the public permalink resolver. */
function kalkan_search_find_post($slugs, $title = '') {
    foreach ((array) $slugs as $slug) {
        $post = get_page_by_path($slug, OBJECT, 'post');
        if ($post instanceof WP_Post) {
            return $post;
        }
    }

    if ('' !== $title) {
        $matches = get_posts(array(
            'post_type'        => 'post',
            'post_status'      => array('publish', 'draft'),
            'posts_per_page'   => 5,
            's'                => $title,
            'suppress_filters' => false,
        ));
        foreach ($matches as $match) {
            if (false !== stripos(wp_strip_all_tags($match->post_title), $title)) {
                return $match;
            }
        }
    }

    return null;
}

/** Update one search page and its SEOPress/social metadata. */
function kalkan_search_update_post($post, $data) {
    if (!$post instanceof WP_Post) {
        return false;
    }

    $updated = wp_update_post(array(
        'ID'           => (int) $post->ID,
        'post_title'   => $data['title'],
        'post_name'    => $data['slug'],
        'post_excerpt' => $data['excerpt'],
        'post_content' => $data['content_tr'],
        'post_status'  => 'publish',
    ), true);

    if (is_wp_error($updated)) {
        return false;
    }

    update_post_meta($post->ID, '_kalkan_title_en', $data['title_en']);
    update_post_meta($post->ID, '_kalkan_content_en', $data['content_en']);
    update_post_meta($post->ID, '_seopress_titles_title', $data['seo_title']);
    update_post_meta($post->ID, '_seopress_titles_desc', $data['seo_desc']);
    update_post_meta($post->ID, '_seopress_analysis_target_kw', $data['target_kw']);
    update_post_meta($post->ID, '_seopress_social_fb_title', $data['seo_title']);
    update_post_meta($post->ID, '_seopress_social_fb_desc', $data['seo_desc']);
    update_post_meta($post->ID, '_seopress_social_twitter_title', $data['seo_title']);
    update_post_meta($post->ID, '_seopress_social_twitter_desc', $data['seo_desc']);

    return true;
}

/** Apply the approved Turkey search-intent refresh once after deployment. */
function kalkan_optimize_turkey_search_content_v1() {
    if (get_option('kalkan_turkey_search_content_v1')) {
        return;
    }

    $home = home_url('/');

    $number_content = <<<'HTML'
<p><strong>Ücretsiz numara sorgulama</strong>, tanımadığınız bir arama hakkında açık kaynaklarda ve resmî kanallarda bulunan bilgileri karşılaştırma işlemidir. Bir telefon numarasının internette görünmesi, arayan kişinin kesin olarak doğrulandığı anlamına gelmez; arayan kimliği taklit edilebilir ve numaralar zaman içinde başka kişilere tahsis edilebilir.</p>

<h2>Ücretsiz numara sorgulama nasıl yapılır?</h2>
<ol>
<li><strong>Numarayı farklı biçimlerde arayın.</strong> 0 ile başlayan yerel biçimi ve +90 ülke kodlu biçimi tırnak içinde aratın.</li>
<li><strong>Kurumsal eşleşmeyi resmî kaynaktan doğrulayın.</strong> Arayan bir banka, kargo şirketi veya kamu kurumu olduğunu söylüyorsa aramadaki numarayı değil, kurumun resmî web sitesindeki iletişim kanalını kullanın.</li>
<li><strong>Şikâyet ve topluluk kayıtlarını yalnızca sinyal olarak değerlendirin.</strong> Tek bir yorum kesin kanıt değildir; tarih, tekrar eden arama türü ve farklı kaynaklardaki tutarlılık önemlidir.</li>
<li><strong>Geri aramadan önce risk işaretlerini kontrol edin.</strong> SMS kodu, kart bilgisi, uzaktan erişim uygulaması, para transferi veya acil karar isteyen aramalarda işlemi durdurun.</li>
</ol>

<h2>Kalkan numara sorgulamada ne gösterir?</h2>
<p><a href="/">Kalkan</a>, cihazınıza yüklenen incelenmiş verilerle bilinen istenmeyen numaraları engellemeye ve listede bulunan kurumsal numaraları açıklayıcı arayan kimliği etiketiyle göstermeye yardımcı olur. Kalkan özel bir kişinin adını ortaya çıkaran bir ters rehber değildir ve rehberinizi ya da kişisel arama geçmişinizi sunucuya yüklemez.</p>
<p>Bir numara Kalkan veritabanında bulunmuyorsa bu numaranın güvenli olduğu anlamına gelmez. Yeni kullanılan, taklit edilen veya henüz bildirilmemiş numaralar olabilir. Hassas bir talebi her zaman kurumun bağımsız resmî kanalından doğrulayın.</p>

<h2>“Bu numara kime ait?” sorusuna neden her zaman kesin cevap verilemez?</h2>
<p>Telefon numaraları taşınabilir, yeniden tahsis edilebilir veya arama ekranında taklit edilebilir. Bu nedenle internetteki isim, etiket veya yorumları arayan kişinin kimliğinin kesin kanıtı olarak kabul etmeyin. Kişisel numaraların sahibini izinsiz biçimde belirlemeye çalışmak yerine, aramanın amacı ve talebin güvenilirliği üzerinde durun.</p>
<p>Daha ayrıntılı karar adımları için <a href="/bilinmeyen-numara-kimin/">bilinmeyen numara sorgulama rehberini</a> kullanabilirsiniz.</p>

<h2>Şüpheli telefon numarası nasıl değerlendirilir?</h2>
<ul>
<li>Aynı numara için güncel ve tutarlı istenmeyen arama bildirimleri var mı?</li>
<li>Numara bir kurumun resmî HTTPS sayfasında açıkça yayımlanıyor mu?</li>
<li>Arayan sizden şifre, doğrulama kodu, ödeme veya uzaktan erişim istiyor mu?</li>
<li>Arayan, düşünmenizi engelleyecek kadar acil veya korkutucu bir dil kullanıyor mu?</li>
<li>Telefonu kapatıp kurumu resmî numarasından aradığınızda talep doğrulanıyor mu?</li>
</ul>
<p>Şüpheli aramalarda <a href="/spam-arama-engelleme/">iPhone spam arama engelleme</a> adımlarını uygulayın. Dolandırıcılık işaretleri için <a href="/dolandirici-numara-tanima/">telefon dolandırıcılığı rehberine</a> bakın.</p>

<h2>Sıkça sorulan sorular</h2>
<h3>Numara sorgulama ücretsiz mi?</h3>
<p>Resmî kurum sayfalarını, arama motorlarını ve Kalkan’ın ücretsiz Genel Koruma ile arayan kimliği özelliklerini kullanabilirsiniz. Bazı üçüncü taraf hizmetlerin ek özellikleri ücretli olabilir.</p>
<h3>Gizli numara sorgulanabilir mi?</h3>
<p>Hayır. Arayan numarasını gizlediğinde ekranda sorgulanabilecek bir telefon numarası bulunmaz.</p>
<h3>Kalkan özel bir kişinin adını gösterir mi?</h3>
<p>Hayır. Kalkan, incelenmiş kurumsal arayan kimliği ve bilinen istenmeyen arama verileriyle çalışır; özel kişilerin kimliğini açıklayan bir rehber değildir.</p>
<h3>Bir numara hakkında hiç yorum yoksa güvenli midir?</h3>
<p>Hayır. Yorum bulunmaması yalnızca açık kaynaklarda yeterli kayıt olmadığı anlamına gelir. Arayanın talebini resmî ve bağımsız bir kanaldan doğrulayın.</p>
HTML;

    $number_content = str_replace('href="/"', 'href="' . esc_url($home) . '"', $number_content);

    $spam_content = <<<'HTML'
<p><strong>Spam arama</strong>, istemediğiniz, tekrarlanan veya çok sayıda kişiye otomatik biçimde yapılan telefon aramasıdır. Satış ve anket çağrıları, robot aramalar, sahte kampanyalar ve dolandırıcılık girişimleri bu gruba girebilir. Her tanımadığınız arama spam değildir; fakat arayanın kimliği ve talebi doğrulanmadan kişisel bilgi paylaşılmamalıdır.</p>

<h2>Spam arama ne demek?</h2>
<p>Spam aramalar genellikle alıcının açık beklentisi olmadan yapılır. Aynı kayıtlı mesajın farklı numaralardan tekrarlanması, sessiz aramalar, otomatik satış çağrıları ve gerçeğe aykırı kurum iddiaları yaygın örneklerdir. “Muhtemel spam” veya “şüpheli arama” etiketi bir risk sinyalidir; arayanın suç işlediğinin kesin kanıtı değildir.</p>

<h2>iPhone’da spam arama engelleme yöntemleri</h2>
<h3>1. Kalkan ile bilinen spam numaraları engelleyin</h3>
<p><a href="/">Kalkan</a>, bilinen istenmeyen numaraları iPhone’unuza yükler ve iOS Arama Engelleme ve Numara Tanıma sistemiyle çalışır. Rehberiniz veya arama geçmişiniz Kalkan sunucusuna yüklenmez. Genel Koruma ve arayan kimliği ücretsizdir; daha geniş numara kalıplarını kapsayan Ekstra Koruma Kalkan Premium gerektirir.</p>
<ol>
<li><a href="https://apple.co/4cYKmRG">Kalkan’ı App Store’dan indirin</a>.</li>
<li>Uygulamayı açıp Genel Koruma verilerini yükleyin.</li>
<li>Ayarlar → Uygulamalar → Telefon → Arama Engelleme ve Numara Tanıma bölümünü açın.</li>
<li>Kalkan uzantılarını etkinleştirip uygulamadaki koruma durumunu kontrol edin.</li>
</ol>
<h3>2. Tek bir numarayı manuel olarak engelleyin</h3>
<p>Telefon uygulamasında Son Aramalar’ı açın, numaranın yanındaki bilgi düğmesine dokunun ve “Bu Arayanı Engelle” seçeneğini kullanın. Bu yöntem tek bir numara için uygundur; sürekli değişen numaralarda güncel bir koruma listesi daha pratiktir.</p>
<h3>3. Bilinmeyen Arayanları Sessize Al seçeneğini dikkatle değerlendirin</h3>
<p>iOS, rehberinizde olmayan numaraları sessize alabilir. Bu seçenek kesintileri azaltabilir ancak doktor, kurye veya iş görüşmesi gibi önemli aramaları da sessize alabilir. Etkinleştirmeden önce Apple’ın <a href="https://support.apple.com/tr-tr/guide/iphone/iphe4b3f7823/ios" target="_blank" rel="noopener">güncel açıklamasını</a> ve kendi kullanım ihtiyacınızı değerlendirin.</p>

<h2>Spam arama ile dolandırıcılık araması aynı şey mi?</h2>
<p>Hayır. Spam arama, istenmeyen veya toplu aramayı tanımlar. Dolandırıcılık araması ise sizi yanıltarak para, hesap erişimi veya kişisel bilgi elde etmeyi amaçlar. Bir satış araması istenmeyen olabilir ama dolandırıcılık olmayabilir; buna karşılık dolandırıcılar da otomatik spam altyapısı kullanabilir.</p>

<h2>Şüpheli arama geldiğinde ne yapmalısınız?</h2>
<ul>
<li>SMS doğrulama kodu, kart bilgisi, şifre veya kimlik bilgisi paylaşmayın.</li>
<li>Arayanın verdiği numarayı geri aramak yerine kurumun resmî sitesindeki numarayı kullanın.</li>
<li>Telefonunuza uzaktan erişim uygulaması yüklemeyin.</li>
<li>Aramayı Kalkan içinden veya iPhone’un desteklediği İletişim Bildirimi akışıyla bildirin.</li>
<li>Para kaybı veya devam eden tehdit varsa bankanızla ve kolluk birimleriyle gecikmeden iletişime geçin.</li>
</ul>
<p>Arayan hakkında açık kaynakları kontrol etmek için <a href="/numara-sorgulama-ucretsiz/">ücretsiz numara sorgulama rehberini</a>, aldatma işaretleri için <a href="/dolandirici-numara-tanima/">telefon dolandırıcılığı rehberini</a> kullanın.</p>

<h2>Sıkça sorulan sorular</h2>
<h3>Spam arama engelleme ücretsiz mi?</h3>
<p>Kalkan’ın Genel Koruma, arayan kimliği ve İletişim Bildirimi özellikleri ücretsizdir. Yalnızca Ekstra Koruma Kalkan Premium gerektirir.</p>
<h3>Kalkan rehberimi veya arama geçmişimi yükler mi?</h3>
<p>Hayır. Arama koruması iOS sistem entegrasyonu ve cihazınıza yüklenen verilerle çalışır; rehberiniz ve kişisel arama geçmişiniz Kalkan’a yüklenmez.</p>
<h3>Kalkan bütün spam aramaları engeller mi?</h3>
<p>Hayır. Hiçbir uygulama yeni, taklit edilmiş veya henüz bildirilmemiş bütün numaraları engelleyemez. Güncel koruma verileri riski azaltmaya yardımcı olur.</p>
<h3>Spam aramayı açmak tek başına tehlikeli midir?</h3>
<p>Aramayı yanıtlamak tek başına hesabınıza erişim sağlamaz. Risk; bilgi paylaşma, bağlantıya tıklama, uygulama yükleme veya para gönderme gibi sonraki eylemlerle artar.</p>
HTML;

    $spam_content = str_replace('href="/"', 'href="' . esc_url($home) . '"', $spam_content);

    $fraud_content = <<<'HTML'
<p><strong>Telefon dolandırıcılığı</strong>, arayan kişinin kendisini banka, kamu kurumu, polis, kargo şirketi veya başka bir güvenilir kuruluş gibi tanıtarak para ya da kişisel bilgi istemesidir. En güçlü işaretler; korku ve aciliyet yaratılması, doğrulama kodu istenmesi, para transferi talebi ve görüşmeyi kapatmanıza izin verilmemesidir.</p>

<h2>Telefon dolandırıcılığı nasıl anlaşılır?</h2>
<h3>1. Aciliyet ve korku yaratılır</h3>
<p>“Hesabınız kapanacak”, “adınız soruşturmaya karıştı” veya “bugün son gün” gibi ifadeler düşünmeden hareket etmenizi amaçlar. Gerçek bir kurumla işlem yapmanız gerekiyorsa telefonu kapatıp o kurumun resmî kanalına kendiniz ulaşabilirsiniz.</p>
<h3>2. Şifre, doğrulama kodu veya kart bilgisi istenir</h3>
<p>SMS doğrulama kodu, mobil bankacılık şifresi, kartın arka yüzündeki güvenlik kodu veya e-Devlet parolası paylaşılmamalıdır. Arayan ekranda tanıdık bir kurum adı görünse bile bu bilgiler verilmemelidir.</p>
<h3>3. Para transferi veya “güvenli hesap” talebi gelir</h3>
<p>Parayı korumak, soruşturmaya yardımcı olmak, ödül almak veya aboneliği yenilemek için başka hesaba para göndermeniz isteniyorsa işlemi durdurun. Banka ya da kolluk görevlileri telefonla para transferi yaptırmaz.</p>
<h3>4. Uzaktan erişim uygulaması yükletilmek istenir</h3>
<p>Telefon veya bilgisayarınıza ekran paylaşımı ve uzaktan kontrol uygulaması kurmanız isteniyorsa görüşmeyi sonlandırın. Bu araçlar bankacılık işlemlerinizi ve kişisel verilerinizi ele geçirmek için kötüye kullanılabilir.</p>
<h3>5. Numara veya kurum adı güven kanıtı gibi sunulur</h3>
<p>Arayan kimliği taklit edilebilir. Ekranda görünen numara, şehir ya da kurum etiketi tek başına doğrulama değildir. Kurumu, aramadan bağımsız resmî web sitesi veya uygulama üzerinden kendiniz arayın.</p>

<h2>Şüpheli telefon numarası aradığında ne yapmalısınız?</h2>
<ol>
<li>Bilgi vermeden ve herhangi bir işlem yapmadan görüşmeyi sonlandırın.</li>
<li>Aramanın saatini, numarayı ve istenen işlemi not alın; kişisel verileri veya konuşma metnini herkese açık biçimde paylaşmayın.</li>
<li>Kurum iddiasını resmî numaradan bağımsız olarak doğrulayın.</li>
<li>Para gönderdiyseniz veya hesap bilgisi verdiyseniz bankanızla hemen iletişime geçin.</li>
<li>Dolandırılmaya çalışıldıysanız elinizdeki bilgi ve belgelerle en yakın kolluk birimine veya Cumhuriyet Başsavcılığına başvurun.</li>
</ol>
<p><a href="https://www.egm.gov.tr/sikca-sorulan-sorular" target="_blank" rel="noopener">Emniyet Genel Müdürlüğü</a>, telefon numarasının sahibi ve olayın ayrıntılı biçimde araştırılması için adli makamların talimatı gerektiğini; bilgi ve belgelerle kolluk birimine veya Cumhuriyet Başsavcılığına başvurulmasını belirtir. <a href="https://tuketici.btk.gov.tr/mobil" target="_blank" rel="noopener">BTK Tüketici İletişim Merkezi 120</a> ise elektronik haberleşme tüketici konularında bilgi verir; acil tehlikede 112 kullanılır.</p>

<h2>Kalkan telefon dolandırıcılığı riskini nasıl azaltır?</h2>
<p><a href="/">Kalkan</a>, bilinen istenmeyen numaraları cihazdaki koruma listesiyle engellemeye ve incelenmiş kurumsal numaraları arayan kimliği etiketiyle göstermeye yardımcı olur. Bu bir kimlik doğrulama sistemi değildir ve yüzde yüz koruma garantisi vermez. Yeni veya taklit edilmiş numaralar her zaman ortaya çıkabilir.</p>
<p>Tanımadığınız bir aramayı değerlendirmek için <a href="/numara-sorgulama-ucretsiz/">ücretsiz numara sorgulama</a> ve <a href="/bilinmeyen-numara-kimin/">bu numara kime ait</a> rehberlerini kullanın. Tekrarlanan istenmeyen çağrılar için <a href="/spam-arama-engelleme/">spam arama engelleme</a> adımlarını izleyin.</p>

<h2>Sıkça sorulan sorular</h2>
<h3>Telefon dolandırıcılığı nereye ihbar edilir?</h3>
<p>Para kaybı, tehdit veya dolandırıcılık girişiminde elinizdeki bilgi ve belgelerle kolluk birimine ya da Cumhuriyet Başsavcılığına başvurun. Acil tehlikede 112’yi arayın.</p>
<h3>Dolandırıcı aramayı açarsam ne olur?</h3>
<p>Aramayı yanıtlamak tek başına hesabınızı ele geçirmez. Bilgi paylaşmak, bağlantıya tıklamak, uygulama yüklemek veya para göndermek riski oluşturur.</p>
<h3>Arayan numara bankamın numarasıyla aynıysa güvenebilir miyim?</h3>
<p>Hayır. Arayan kimliği taklit edilebilir. Görüşmeyi kapatıp bankanın kartınızda veya resmî uygulamasında yer alan numarasını kendiniz arayın.</p>
HTML;

    $fraud_content = str_replace('href="/"', 'href="' . esc_url($home) . '"', $fraud_content);

    $unknown_content = <<<'HTML'
<p><strong>“Bu numara kime ait?”</strong> sorusunun güvenli cevabı, tek bir isim bulmaktan çok aramanın kaynağını ve talebini doğrulamaktır. İnternetteki etiketler yararlı bir başlangıç olabilir; ancak numaralar taşınabilir, yeniden tahsis edilebilir ve arayan kimliği taklit edilebilir.</p>

<h2>Bilinmeyen numara sorgulama nasıl yapılır?</h2>
<h3>1. Numarayı iki yazım biçimiyle arayın</h3>
<p>Numarayı hem 0 ile başlayan biçimde hem de +90 ülke koduyla tırnak içinde aratın. Sonuçların tarihine, aynı arama türünün tekrar edip etmediğine ve kaynağın güvenilirliğine bakın.</p>
<h3>2. Kurumsal numarayı resmî sayfadan doğrulayın</h3>
<p>Arayan bir kurum adı veriyorsa yalnızca o kurumun resmî HTTPS web sayfasında yayımlanan numarayı dikkate alın. Arayanın gönderdiği bağlantıya veya verdiği geri arama numarasına güvenmeyin.</p>
<h3>3. Kalkan arayan kimliği ve koruma verisini kontrol edin</h3>
<p><a href="/">Kalkan</a>, listede bulunan kurumsal numaralar için açıklayıcı bir etiket gösterebilir ve bilinen istenmeyen numaraları engelleyebilir. Eşleşme olmaması numaranın güvenli olduğunu kanıtlamaz. Kalkan özel kişilerin adını açıklayan bir ters rehber değildir.</p>
<h3>4. Topluluk yorumlarını bağlamıyla okuyun</h3>
<p>Bir numara hakkında “reklam”, “anket”, “sessiz arama” veya “şüpheli” yorumları bulunabilir. Yorumları kesin hüküm olarak değil, araştırılacak bir sinyal olarak kullanın. Eski kayıtlar bugünkü numara kullanıcısını yansıtmayabilir.</p>

<h2>Numara kime ait görünmüyorsa ne yapmalısınız?</h2>
<ul>
<li>Sesli mesaj veya doğrulanabilir bir açıklama bırakılmadıysa aceleyle geri aramayın.</li>
<li>Arayan tekrar ulaşırsa kurum adı, departman ve görüşme amacını sorun; bilgi paylaşmayın.</li>
<li>Kurumu resmî numarasından arayıp görüşmeyi doğrulayın.</li>
<li>Tekrarlanan istenmeyen aramayı cihazınızda engelleyin ve Kalkan’a bildirin.</li>
</ul>

<h2>Şüpheli aramada hangi işaretlere dikkat edilmeli?</h2>
<p>Doğrulama kodu, kart bilgisi, şifre, para transferi veya uzaktan erişim isteyen aramalar yüksek risklidir. “Hemen yapmazsanız hesabınız kapanır” gibi baskı ifadeleri de yaygın bir dolandırıcılık işaretidir. Ayrıntılar için <a href="/dolandirici-numara-tanima/">telefon dolandırıcılığı nasıl anlaşılır?</a> rehberini okuyun.</p>
<p>Daha geniş yöntem listesi için <a href="/numara-sorgulama-ucretsiz/">ücretsiz numara sorgulama rehberine</a>, iPhone koruma adımları için <a href="/spam-arama-engelleme/">spam arama engelleme rehberine</a> bakın.</p>

<h2>Sıkça sorulan sorular</h2>
<h3>Bilinmeyen numara kimin olduğunu Kalkan gösterir mi?</h3>
<p>Kalkan, veritabanında bulunan incelenmiş kurumsal arayan kimliği etiketlerini ve bilinen istenmeyen numara sinyallerini gösterebilir. Özel kişilerin adını belirlemez.</p>
<h3>Gizli numaranın kime ait olduğu öğrenilebilir mi?</h3>
<p>Arayan numarasını gizlediğinde ekranda sorgulanacak bir numara bulunmaz. Taciz, tehdit veya suç şüphesinde kolluk birimlerine başvurun.</p>
<h3>+90 ile başlayan numara nereden arıyor?</h3>
<p>+90 Türkiye’nin ülke kodudur. Bu bilgi arayanın kimliğini veya aramanın güvenilirliğini tek başına göstermez.</p>
<h3>Numara sorgulama sonucu kesin midir?</h3>
<p>Hayır. Açık kaynak sonuçları ve etiketler zamanla değişebilir. Hassas bir işlemden önce kurumu bağımsız resmî kanaldan doğrulayın.</p>
HTML;

    $unknown_content = str_replace('href="/"', 'href="' . esc_url($home) . '"', $unknown_content);

    $posts = array(
        array(
            'lookup' => array('numara-sorgulama-ucretsiz', 'numara-sorgulama-rehberi', 'numara-sorgulama'),
            'title_match' => 'Numara Sorgulama',
            'data' => array(
                'title' => 'Ücretsiz Numara Sorgulama: Güvenli Yöntemler',
                'slug' => 'numara-sorgulama-ucretsiz',
                'excerpt' => 'Ücretsiz numara sorgulama yöntemlerini, bilinmeyen bir numarayı güvenli biçimde değerlendirmeyi ve kurumsal eşleşmeyi doğrulamayı öğrenin.',
                'seo_title' => 'Ücretsiz Numara Sorgulama: Güvenli Yöntemler | Kalkan',
                'seo_desc' => 'Ücretsiz numara sorgulama nasıl yapılır? Bilinmeyen numarayı açık kaynaklarda araştırın, kurumsal eşleşmeyi doğrulayın ve risk işaretlerini öğrenin.',
                'target_kw' => 'numara sorgulama ücretsiz, telefon numarası sorgulama',
                'title_en' => 'Free Number Lookup: Safer Methods',
                'content_en' => '<p>Learn how to research an unknown number using public and official sources without treating a name or label as proof of identity. Kalkan can show reviewed business caller labels and known unwanted-number signals, but it is not a private-person reverse directory.</p><h2>How to check an unknown number</h2><ol><li>Search both the local and +90 formats.</li><li>Verify business matches on the organization’s official HTTPS page.</li><li>Treat complaint-site comments as signals, not proof.</li><li>Never share passwords, verification codes, or payment information.</li></ol>',
                'content_tr' => $number_content,
            ),
        ),
        array(
            'lookup' => array('spam-arama-engelleme'),
            'title_match' => 'Spam Arama',
            'data' => array(
                'title' => 'Spam Arama Ne Demek? iPhone’da Nasıl Engellenir?',
                'slug' => 'spam-arama-engelleme',
                'excerpt' => 'Spam aramanın ne olduğunu, iPhone’da bilinen istenmeyen numaraları nasıl engelleyeceğinizi ve şüpheli aramada ne yapmanız gerektiğini öğrenin.',
                'seo_title' => 'Spam Arama Ne Demek? iPhone’da Engelleme | Kalkan',
                'seo_desc' => 'Spam arama ne demek ve iPhone’da nasıl engellenir? Kalkan kurulumu, manuel engelleme, şüpheli arama işaretleri ve güvenli doğrulama adımları.',
                'target_kw' => 'spam arama ne demek, spam arama engelleme, iPhone spam arama engelleme',
                'title_en' => 'What Is a Spam Call? How to Block It on iPhone',
                'content_en' => '<p>A spam call is an unwanted, repeated, or automated call. Sales calls, robocalls, false campaigns, and scam attempts may fall into this group.</p><h2>How to block spam calls on iPhone</h2><ol><li>Install Kalkan and load General Protection.</li><li>Enable Kalkan under Settings → Apps → Phone → Call Blocking &amp; Identification.</li><li>Manually block individual callers in Recents when necessary.</li></ol><p>No app can guarantee that every new or spoofed number will be blocked.</p>',
                'content_tr' => $spam_content,
            ),
        ),
        array(
            'lookup' => array('dolandirici-numara-tanima'),
            'title_match' => 'Dolandırıcı',
            'data' => array(
                'title' => 'Telefon Dolandırıcılığı Nasıl Anlaşılır?',
                'slug' => 'dolandirici-numara-tanima',
                'excerpt' => 'Telefon dolandırıcılığının uyarı işaretlerini, şüpheli aramada ne yapmanız gerektiğini ve resmî başvuru kanallarını öğrenin.',
                'seo_title' => 'Telefon Dolandırıcılığı Nasıl Anlaşılır? | Kalkan',
                'seo_desc' => 'Telefon dolandırıcılığı nasıl anlaşılır? Doğrulama kodu, para transferi ve sahte kurum aramalarını tanıyın; resmî başvuru adımlarını öğrenin.',
                'target_kw' => 'telefon dolandırıcılığı nasıl anlaşılır, telefon dolandırıcılığı ihbar',
                'title_en' => 'How to Recognize Phone Fraud',
                'content_en' => '<p>Phone fraud often relies on urgency, fear, requests for verification codes, money transfers, or remote-access software. Hang up and contact the organization through an independent official channel.</p><h2>What to do</h2><ol><li>Do not share information or send money.</li><li>Call your bank immediately if account details or funds were exposed.</li><li>Take available evidence to law enforcement or the public prosecutor.</li></ol><p>A caller-ID label is not identity authentication.</p>',
                'content_tr' => $fraud_content,
            ),
        ),
        array(
            'lookup' => array('bilinmeyen-numara-kimin'),
            'title_match' => 'Bilinmeyen Numara',
            'data' => array(
                'title' => 'Bu Numara Kime Ait? Bilinmeyen Numara Sorgulama',
                'slug' => 'bilinmeyen-numara-kimin',
                'excerpt' => 'Bilinmeyen bir numarayı açık kaynaklarda araştırın, kurumsal arayanı resmî sayfadan doğrulayın ve şüpheli arama işaretlerini değerlendirin.',
                'seo_title' => 'Bu Numara Kime Ait? Bilinmeyen Numara Sorgulama',
                'seo_desc' => 'Bu numara kime ait? Bilinmeyen numarayı güvenli biçimde sorgulayın, kurumsal eşleşmeyi doğrulayın ve şüpheli arama işaretlerini öğrenin.',
                'target_kw' => 'bu numara kime ait, bilinmeyen numara sorgulama, numara kime ait',
                'title_en' => 'Who Does This Number Belong To? Unknown Number Checks',
                'content_en' => '<p>Public labels can help you assess an unknown call, but they are not proof of identity. Search both local and international formats, verify business numbers on official HTTPS pages, and contact the organization through an independent channel.</p><p>Kalkan can show reviewed business caller labels and known unwanted-number signals. It does not identify private individuals.</p>',
                'content_tr' => $unknown_content,
            ),
        ),
    );

    $all_updated = true;
    foreach ($posts as $item) {
        $post = kalkan_search_find_post($item['lookup'], $item['title_match']);
        if (!kalkan_search_update_post($post, $item['data'])) {
            $all_updated = false;
        }
    }

    $term_descriptions = array(
        'numara-sorgulama' => 'Numara sorgulama, bilinmeyen numara kime ait araştırması ve güvenli arayan doğrulama rehberleri.',
        'spam-aramalar' => 'Spam arama ne demek, iPhone spam arama engelleme ve tekrarlanan istenmeyen çağrıları azaltma rehberleri.',
        'guvenlik' => 'Telefon dolandırıcılığı, şüpheli arama işaretleri ve resmî doğrulama adımları hakkında güvenlik rehberleri.',
    );
    foreach ($term_descriptions as $slug => $description) {
        $term = get_term_by('slug', $slug, 'category');
        if ($term instanceof WP_Term) {
            wp_update_term($term->term_id, 'category', array('description' => $description));
        }
    }

    // Point older editorial references at the unique guide URL rather than the
    // archive route that previously shared its slug.
    $legacy_posts = get_posts(array(
        'post_type'        => 'post',
        'post_status'      => array('publish', 'draft'),
        'posts_per_page'   => -1,
        'suppress_filters' => false,
    ));
    foreach ($legacy_posts as $legacy_post) {
        $repaired_tr = str_replace('/numara-sorgulama-rehberi/', '/numara-sorgulama-ucretsiz/', $legacy_post->post_content);
        if ($repaired_tr !== $legacy_post->post_content) {
            wp_update_post(array('ID' => $legacy_post->ID, 'post_content' => $repaired_tr));
        }

        $legacy_en = get_post_meta($legacy_post->ID, '_kalkan_content_en', true);
        if (is_string($legacy_en) && '' !== $legacy_en) {
            $repaired_en = str_replace('/numara-sorgulama-rehberi/', '/numara-sorgulama-ucretsiz/', $legacy_en);
            if ($repaired_en !== $legacy_en) {
                update_post_meta($legacy_post->ID, '_kalkan_content_en', $repaired_en);
            }
        }
    }

    $front_page_id = (int) get_option('page_on_front');
    if ($front_page_id > 0) {
        update_post_meta($front_page_id, '_seopress_titles_title', 'Kalkan: Spam Arama Engelleme ve Numara Sorgulama');
        update_post_meta($front_page_id, '_seopress_titles_desc', 'Kalkan ile iPhone’da bilinen spam ve şüpheli aramaları engelleyin, bilinmeyen ve kurumsal numaraları tanıyın. Genel Koruma ücretsizdir.');
        update_post_meta($front_page_id, '_seopress_analysis_target_kw', 'spam arama engelleme, numara sorgulama, bilinmeyen numara');
    }

    if ($all_updated) {
        update_option('kalkan_turkey_search_content_v1', gmdate('c'));
        if (defined('LSCWP_V')) {
            do_action('litespeed_purge_all');
        }
    }
}
add_action('init', 'kalkan_optimize_turkey_search_content_v1', 47);

/** Move legacy lookup-category assignments into the canonical search hub. */
function kalkan_consolidate_lookup_category_v1() {
    if (get_option('kalkan_lookup_category_consolidated_v1')) {
        return;
    }

    $canonical_lookup_term = get_term_by('slug', 'numara-sorgulama', 'category');
    $legacy_lookup_term = get_term_by('slug', 'numara-sorgulama-rehberi', 'category');
    if (!$canonical_lookup_term instanceof WP_Term || !$legacy_lookup_term instanceof WP_Term) {
        return;
    }

    $legacy_lookup_posts = get_posts(array(
        'post_type'        => 'post',
        'post_status'      => array('publish', 'draft'),
        'posts_per_page'   => -1,
        'category'         => (int) $legacy_lookup_term->term_id,
        'suppress_filters' => false,
    ));
    foreach ($legacy_lookup_posts as $legacy_lookup_post) {
        $category_ids = wp_get_post_categories($legacy_lookup_post->ID);
        $category_ids = array_values(array_diff($category_ids, array((int) $legacy_lookup_term->term_id)));
        $category_ids[] = (int) $canonical_lookup_term->term_id;
        wp_set_post_categories($legacy_lookup_post->ID, array_values(array_unique($category_ids)));
    }

    update_option('kalkan_lookup_category_consolidated_v1', gmdate('c'));
    if (defined('LSCWP_V')) {
        do_action('litespeed_purge_all');
    }
}
add_action('init', 'kalkan_consolidate_lookup_category_v1', 48);

/** Consolidate the duplicate legacy lookup archive into the canonical hub. */
function kalkan_redirect_legacy_lookup_category_v1() {
    $request_path = isset($_SERVER['REQUEST_URI'])
        ? (string) wp_parse_url(wp_unslash($_SERVER['REQUEST_URI']), PHP_URL_PATH)
        : '';

    if ('/numara-sorgulama-rehberi' === untrailingslashit($request_path)) {
        wp_safe_redirect(home_url('/numara-sorgulama/'), 301);
        exit;
    }
}
add_action('template_redirect', 'kalkan_redirect_legacy_lookup_category_v1', 5);

/** Search-focused category metadata. */
function kalkan_search_category_profile() {
    if (!is_category()) {
        return null;
    }

    $term = get_queried_object();
    if (!$term instanceof WP_Term) {
        return null;
    }

    $name = wp_strip_all_tags($term->name);
    $slug = (string) $term->slug;

    if ('numara-sorgulama' === $slug || false !== stripos($name, 'Numara Sorgulama')) {
        return array(
            'title' => 'Numara Sorgulama: Bilinmeyen Numara Kime Ait? | Kalkan',
            'desc' => 'Numara sorgulama rehberleriyle bilinmeyen numara kime ait araştırın, kurumsal arayanı resmî kaynaktan doğrulayın ve şüpheli aramaları değerlendirin.',
        );
    }
    if ('spam-aramalar' === $slug || false !== stripos($name, 'Spam')) {
        return array(
            'title' => 'Spam Arama Ne Demek? Engelleme Rehberleri | Kalkan',
            'desc' => 'Spam arama ne demek, iPhone’da nasıl engellenir ve şüpheli aramada ne yapılır? Kalkan’ın ücretsiz ve uygulanabilir rehberlerini inceleyin.',
        );
    }
    if ('guvenlik' === $slug || false !== stripos($name, 'Güvenlik')) {
        return array(
            'title' => 'Telefon Dolandırıcılığı ve Şüpheli Aramalar | Kalkan',
            'desc' => 'Telefon dolandırıcılığı işaretlerini, şüpheli numara doğrulama adımlarını ve resmî başvuru kanallarını Kalkan güvenlik rehberlerinde öğrenin.',
        );
    }

    return null;
}

function kalkan_search_category_title($title) {
    $profile = kalkan_search_category_profile();
    return $profile ? $profile['title'] : $title;
}
add_filter('seopress_titles_title', 'kalkan_search_category_title', 55);
add_filter('pre_get_document_title', 'kalkan_search_category_title', 55);

function kalkan_search_category_description($description) {
    $profile = kalkan_search_category_profile();
    return $profile ? $profile['desc'] : $description;
}
add_filter('seopress_titles_desc', 'kalkan_search_category_description', 55);

/** FAQPage schema for the visible FAQs on the four core search-intent posts. */
function kalkan_search_article_faq_schema() {
    if (!is_singular('post')) {
        return;
    }

    $slug = get_post_field('post_name', get_the_ID());
    $faqs = array(
        'numara-sorgulama-ucretsiz' => array(
            array('Numara sorgulama ücretsiz mi?', 'Resmî kurum sayfalarını, arama motorlarını ve Kalkan’ın ücretsiz Genel Koruma ile arayan kimliği özelliklerini kullanabilirsiniz.'),
            array('Gizli numara sorgulanabilir mi?', 'Hayır. Arayan numarasını gizlediğinde ekranda sorgulanabilecek bir telefon numarası bulunmaz.'),
            array('Kalkan özel bir kişinin adını gösterir mi?', 'Hayır. Kalkan, incelenmiş kurumsal arayan kimliği ve bilinen istenmeyen arama verileriyle çalışır; özel kişilerin kimliğini açıklayan bir rehber değildir.'),
        ),
        'spam-arama-engelleme' => array(
            array('Spam arama engelleme ücretsiz mi?', 'Kalkan’ın Genel Koruma, arayan kimliği ve İletişim Bildirimi özellikleri ücretsizdir. Yalnızca Ekstra Koruma Kalkan Premium gerektirir.'),
            array('Kalkan bütün spam aramaları engeller mi?', 'Hayır. Hiçbir uygulama yeni, taklit edilmiş veya henüz bildirilmemiş bütün numaraları engelleyemez.'),
            array('Spam aramayı açmak tek başına tehlikeli midir?', 'Aramayı yanıtlamak tek başına hesabınıza erişim sağlamaz. Risk; bilgi paylaşma, bağlantıya tıklama, uygulama yükleme veya para gönderme gibi sonraki eylemlerle artar.'),
        ),
        'dolandirici-numara-tanima' => array(
            array('Telefon dolandırıcılığı nereye ihbar edilir?', 'Para kaybı, tehdit veya dolandırıcılık girişiminde bilgi ve belgelerle kolluk birimine ya da Cumhuriyet Başsavcılığına başvurun. Acil tehlikede 112’yi arayın.'),
            array('Dolandırıcı aramayı açarsam ne olur?', 'Aramayı yanıtlamak tek başına hesabınızı ele geçirmez. Bilgi paylaşmak, bağlantıya tıklamak, uygulama yüklemek veya para göndermek riski oluşturur.'),
            array('Arayan numara bankamın numarasıyla aynıysa güvenebilir miyim?', 'Hayır. Arayan kimliği taklit edilebilir. Görüşmeyi kapatıp bankanın resmî numarasını kendiniz arayın.'),
        ),
        'bilinmeyen-numara-kimin' => array(
            array('Bilinmeyen numara kimin olduğunu Kalkan gösterir mi?', 'Kalkan, veritabanında bulunan incelenmiş kurumsal arayan kimliği etiketlerini ve bilinen istenmeyen numara sinyallerini gösterebilir. Özel kişilerin adını belirlemez.'),
            array('Gizli numaranın kime ait olduğu öğrenilebilir mi?', 'Arayan numarasını gizlediğinde ekranda sorgulanacak bir numara bulunmaz. Taciz, tehdit veya suç şüphesinde kolluk birimlerine başvurun.'),
            array('+90 ile başlayan numara nereden arıyor?', '+90 Türkiye’nin ülke kodudur. Bu bilgi arayanın kimliğini veya aramanın güvenilirliğini tek başına göstermez.'),
        ),
    );

    if (!isset($faqs[$slug])) {
        return;
    }

    $items = array();
    foreach ($faqs[$slug] as $faq) {
        $items[] = array(
            '@type' => 'Question',
            'name' => $faq[0],
            'acceptedAnswer' => array('@type' => 'Answer', 'text' => $faq[1]),
        );
    }

    echo '<script type="application/ld+json">' . wp_json_encode(array(
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $items,
    ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</script>\n";
}
add_action('wp_head', 'kalkan_search_article_faq_schema', 99);
