<?php
/**
 * Idempotent WordPress content update for the relationship-intent SEO cluster.
 * Run with: wp --path=/path/to/wordpress eval-file publish-relationship-intent-content.php
 */

if (!defined('ABSPATH')) {
    fwrite(STDERR, "WordPress must be loaded by WP-CLI.\n");
    exit(1);
}

$category_id = 36; // Duyurular

$posts = [
    [
        'slug' => 'iphoneda-eski-sevgilinin-numarasi-nasil-engellenir',
        'title' => 'iPhone’da Eski Sevgilinin Numarası Nasıl Engellenir?',
        'excerpt' => 'Eski sevgilinizin aramalarını ve mesajlarını iPhone’da engelleyin; farklı numaralardan gelen ısrarlı iletişim için sakin ve güvenli adımları izleyin.',
        'seo_title' => 'iPhone’da Eski Sevgilinin Numarası Nasıl Engellenir?',
        'seo_desc' => 'Eski sevgilinizin numarasını iPhone’da Telefon, Mesajlar ve FaceTime üzerinden engelleyin; ısrarlı aramalarda güvenli adımları öğrenin.',
        'target_kw' => 'eski sevgilinin numarasını engelleme',
        'content' => <<<'HTML'
<p>Bir ilişkinin bitmesinden sonra arama ve mesajların devam etmesi dikkatinizi dağıtabilir veya kendinizi güvende hissetmenizi zorlaştırabilir. iPhone’da bir numarayı engellemek için karşı tarafa açıklama yapmak ya da yanıt vermek zorunda değilsiniz. Aşağıdaki adımlarla Telefon, Mesajlar ve FaceTime üzerinden gelen iletişimi durdurabilirsiniz.</p>

<h2>Son Aramalar’dan numarayı engelleme</h2>
<ol>
<li><strong>Telefon</strong> uygulamasını açın ve <strong>Son Aramalar</strong> bölümüne girin.</li>
<li>Engellemek istediğiniz kişinin veya numaranın yanındaki bilgi düğmesine dokunun.</li>
<li>Aşağı kaydırın ve <strong>Arayanı Engelle</strong> seçeneğini belirleyin.</li>
<li>Kararınızı onaylayın.</li>
</ol>
<p>Menü adları iOS sürümüne göre küçük farklılıklar gösterebilir. Apple’ın güncel yönergelerini <a href="https://support.apple.com/tr-tr/111104" rel="noopener" target="_blank">resmî destek sayfasından</a> kontrol edebilirsiniz.</p>

<h2>Mesajlar ve FaceTime üzerinden engelleme</h2>
<p>Kişi size mesaj gönderiyorsa Mesajlar uygulamasında konuşmayı açın, üst bölümdeki kişi adına veya numaraya dokunun ve bilgi ekranından engelleme seçeneğini kullanın. FaceTime geçmişindeki bilgi düğmesi de aynı engelleme denetimine ulaşır. iPhone’da engellediğiniz kişi size sesli mesaj bırakabilir; ancak bunun için bildirim almazsınız.</p>

<h2>Farklı numaralardan ararsa ne yapabilirsiniz?</h2>
<p>Tek bir numarayı engellemek, yeni veya gizli numaralardan gelen aramaları otomatik olarak durdurmaz. Tanımadığınız numaralar sıklaşıyorsa iPhone’un bilinmeyen arayanlarla ilgili seçeneklerini değerlendirebilirsiniz. Bunun önemli bir karşılığı vardır: kurye, okul, sağlık kuruluşu, iş görüşmesi veya yeni müşteri gibi rehberinizde kayıtlı olmayan gerçek aramalar da sessize alınabilir. Ayrıntılı karar rehberimiz için <a href="https://kalkanapp.com/iphoneda-bilinmeyen-arayanlari-sessize-alma/">iPhone’da bilinmeyen arayanları sessize alma</a> yazısını okuyun.</p>

<h2>Engellemeden önce kanıt saklamak gerekir mi?</h2>
<p>Aramalar yalnızca istenmeyen iletişim düzeyindeyse doğrudan engellemek yeterli olabilir. Tehdit, şantaj, takip veya ısrarlı taciz söz konusuysa arama kayıtlarını, tarihleri ve mesajları silmeden saklamanız faydalı olabilir. Acil bir risk varsa 112’yi arayın; hukuki destek gerekiyorsa yetkili kurumlara başvurun. Kalkan hukuki danışmanlık sağlamaz ve bir arayanın niyetini kesin olarak doğrulayamaz.</p>

<h2>Kalkan bu süreçte nasıl yardımcı olur?</h2>
<p>Kalkan, bilinen istenmeyen numaralar için arayan kimliği ve engelleme verilerini iPhone’un yerel arama altyapısıyla kullanmanıza yardımcı olur. Kişisel ilişki içindeki belirli bir kişiyi sizin yerinize tanımaz; böyle bir numarayı doğrudan iPhone’un engelleme özelliğiyle yönetmelisiniz. Şüpheli veya bilinmeyen başka aramalarda ise ekranda görünen bilgiyi karar vermeden önce değerlendirebilirsiniz.</p>

<h2>Kısa kontrol listesi</h2>
<ul>
<li>Yanıt vermek istemiyorsanız açıklama yapmak zorunda değilsiniz.</li>
<li>Numarayı Telefon, Mesajlar veya FaceTime geçmişinden engelleyin.</li>
<li>Yeni numaralardan gelen aramaları tek tek değerlendirin.</li>
<li>Tehdit veya taciz varsa kanıtları saklayın ve yetkili desteğe başvurun.</li>
<li>Önemli bilinmeyen aramaları kaçırmamak için cevapsız aramalarınızı düzenli kontrol edin.</li>
</ul>

<p><strong>Sonuç:</strong> iPhone’daki yerleşik engelleme özelliği eski sevgilinizin bilinen numarasından gelen iletişimi durdurmanın en doğrudan yoludur. Kalkan’ı da bilinen spam ve şüpheli aramalar hakkında daha fazla bağlam görmek için güncel tutabilirsiniz.</p>
HTML,
        'en_title' => 'How to Block an Ex-Partner’s Number on iPhone',
        'en_content' => <<<'HTML'
<p>If calls or messages continue after a relationship ends, you can block the known number directly on iPhone without replying or providing an explanation.</p>
<h2>Block the number from Recents</h2>
<ol><li>Open <strong>Phone</strong> and choose <strong>Recents</strong>.</li><li>Tap the information button beside the person or number.</li><li>Scroll down, choose <strong>Block Caller</strong>, and confirm.</li></ol>
<p>You can use the same control from the contact information screen in Messages or FaceTime. Menu wording may vary by iOS version; check <a href="https://support.apple.com/111104" rel="noopener" target="_blank">Apple’s current instructions</a>.</p>
<h2>If calls arrive from new numbers</h2>
<p>Blocking one number does not automatically stop calls from new or hidden numbers. iPhone’s unknown-caller options can reduce interruptions, but legitimate calls from a courier, school, healthcare provider, job recruiter, or new customer may also be silenced. Review missed calls regularly.</p>
<h2>Safety and evidence</h2>
<p>If the contact includes threats, stalking, blackmail, or persistent harassment, consider preserving call records, dates, and messages before deleting anything. Contact emergency services if there is immediate danger and seek qualified local support when necessary.</p>
<h2>How Kalkan fits</h2>
<p>Kalkan helps iPhone use caller-identification and blocking data for known unwanted numbers. It does not identify a private person or personal relationship for you; block a known individual with iPhone’s own controls.</p>
HTML,
    ],
    [
        'slug' => 'eski-patronun-israrli-aramalari-nasil-engellenir',
        'title' => 'Eski Patronun Israrlı Aramalarını Nasıl Engellersiniz?',
        'excerpt' => 'Eski patronunuzun veya eski iş yerinizin ısrarlı aramalarını iPhone’da engelleyin; resmî iş iletişimini kaçırmadan sınır koyun.',
        'seo_title' => 'Eski Patronun Israrlı Aramaları Nasıl Engellenir?',
        'seo_desc' => 'Eski patronunuzun ısrarlı aramalarını iPhone’da engelleyin; farklı numaralar, iş kayıtları ve güvenli iletişim için pratik adımları öğrenin.',
        'target_kw' => 'eski patronun aramalarını engelleme',
        'content' => <<<'HTML'
<p>İş ilişkiniz bittikten sonra eski patronunuzun veya eski iş yerinizin tekrar tekrar araması rahatsız edici olabilir. Ancak engellemeden önce aramanın kişisel ısrar mı, yoksa ücret, belge, referans ya da ekipman teslimi gibi tamamlanmamış resmî bir konu mu olduğunu ayırmak faydalıdır. Bu ayrım, sınır koyarken önemli bir işle ilgili kaydı kaçırmamanıza yardımcı olur.</p>

<h2>Önce iletişim kanalını netleştirin</h2>
<p>Yanıt vermek güvenliyse kısa ve yazılı bir mesajla bundan sonraki iletişimin e-posta üzerinden yapılmasını isteyebilirsiniz. Böylece hem aramalar azalabilir hem de iş ile ilgili talepler kayıt altında kalır. Yanıt vermek istemiyor veya kendinizi güvende hissetmiyorsanız bu adım zorunlu değildir.</p>

<h2>iPhone’da eski patronun numarasını engelleme</h2>
<ol>
<li><strong>Telefon</strong> uygulamasında <strong>Son Aramalar</strong> bölümünü açın.</li>
<li>Numaranın yanındaki bilgi düğmesine dokunun.</li>
<li>Aşağı kaydırıp <strong>Arayanı Engelle</strong> seçeneğini kullanın.</li>
</ol>
<p>Mesajlar veya FaceTime üzerinden iletişim kuruluyorsa ilgili konuşmanın kişi bilgi ekranından da engelleme yapabilirsiniz. Apple’ın menüleri iOS sürümüne göre değişebildiği için gerektiğinde <a href="https://support.apple.com/tr-tr/111104" rel="noopener" target="_blank">güncel Apple destek belgesini</a> kontrol edin.</p>

<h2>Şirketin farklı hatları arıyorsa</h2>
<p>Bir kişiyi engellemek aynı iş yerinin santral, insan kaynakları veya farklı çalışan hatlarını engellemez. İşle ilgili meşru bir konu bekliyorsanız kuruluşun resmî e-posta adresini veya daha önce doğruladığınız santral numarasını kullanın. Beklenmedik bir numara ödeme, parola, doğrulama kodu ya da kişisel bilgi istiyorsa görüşmeyi sonlandırıp kuruma kendiniz geri dönün.</p>

<h2>Rehberde kayıtlı olmayan tüm aramaları sessize almak doğru mu?</h2>
<p>iPhone’un bilinmeyen arayanlarla ilgili seçenekleri dikkatinizin bölünmesini azaltabilir. Fakat yeni iş fırsatları, müşteriler, kuryeler ve resmî kurumlar da rehberinizde kayıtlı olmayabilir. Bu nedenle tüm bilinmeyen aramaları sessize almadan önce avantaj ve riskleri birlikte değerlendirin. Adımları ve olası yan etkileri <a href="https://kalkanapp.com/iphoneda-bilinmeyen-arayanlari-sessize-alma/">ayrıntılı rehberimizde</a> bulabilirsiniz.</p>

<h2>Israrlı aramalarda kayıt tutun</h2>
<p>İletişim tehdit, hakaret, baskı veya taciz içeriyorsa arama günlerini, saatlerini ve yazılı mesajları saklayın. İş hukuku ya da kişisel güvenlikle ilgili bir uyuşmazlıkta yetkili bir uzmandan destek alın. Acil tehlikede 112’yi arayın. Bu yazı genel güvenlik bilgisidir; hukuki danışmanlık değildir.</p>

<h2>Kalkan’ın rolü</h2>
<p>Kalkan, bilinen istenmeyen numaralar için arayan kimliği ve engelleme verilerinin iPhone’da kullanılmasına yardımcı olur. Bir numaranın eski patronunuza ait olduğunu özel rehber verinizden çıkarmaz ve kişisel ilişkinizi sınıflandırmaz. Bilinen kişileri iPhone’un kendi engelleme aracıyla, şüpheli kurumsal veya istenmeyen aramaları ise doğrulama ve dikkat adımlarıyla yönetin.</p>

<p><strong>Sonuç:</strong> Eski patronunuzun bilinen numarasını engelleyebilir, gerekli iş iletişimini yazılı ve doğrulanmış bir kanala taşıyabilir, farklı numaralardan gelen taleplerde acele etmeden kurumun resmî kanalını kullanabilirsiniz.</p>
HTML,
        'en_title' => 'How to Block Persistent Calls from a Former Employer',
        'en_content' => <<<'HTML'
<p>Repeated calls from a former manager or workplace can be disruptive. Before blocking, consider whether the call concerns an unfinished formal matter such as pay, documents, references, or returned equipment. When it is safe to respond, you can request that any necessary communication continue by email.</p>
<h2>Block the known number on iPhone</h2>
<ol><li>Open <strong>Phone</strong> and select <strong>Recents</strong>.</li><li>Tap the information button beside the number.</li><li>Scroll down and choose <strong>Block Caller</strong>.</li></ol>
<p>The same control is available from the person’s information screen in Messages and FaceTime. See <a href="https://support.apple.com/111104" rel="noopener" target="_blank">Apple’s current instructions</a> if menu wording differs.</p>
<h2>Calls from other company numbers</h2>
<p>Blocking one person does not block a company switchboard or other staff numbers. If a legitimate employment matter is pending, use a verified company email address or switchboard. End unexpected calls asking for payment, passwords, verification codes, or personal data and contact the organization yourself.</p>
<h2>Preserve records when necessary</h2>
<p>If contact includes threats, pressure, insults, or harassment, preserve dates, call history, and written messages and seek qualified local support. Contact emergency services if there is immediate danger.</p>
<h2>How Kalkan fits</h2>
<p>Kalkan helps iPhone use identification and blocking data for known unwanted numbers. It does not infer that a private number belongs to a former employer from your contacts or personal relationships.</p>
HTML,
    ],
];

foreach ($posts as $item) {
    $existing = get_page_by_path($item['slug'], OBJECT, 'post');
    $post_id = wp_insert_post([
        'ID' => $existing ? $existing->ID : 0,
        'post_type' => 'post',
        'post_status' => 'publish',
        'post_title' => $item['title'],
        'post_name' => $item['slug'],
        'post_excerpt' => $item['excerpt'],
        'post_content' => $item['content'],
        'post_category' => [$category_id],
    ], true);

    if (is_wp_error($post_id)) {
        WP_CLI::warning($item['slug'] . ': ' . $post_id->get_error_message());
        continue;
    }

    update_post_meta($post_id, '_kalkan_title_en', $item['en_title']);
    update_post_meta($post_id, '_kalkan_content_en', $item['en_content']);
    update_post_meta($post_id, '_seopress_titles_title', $item['seo_title']);
    update_post_meta($post_id, '_seopress_titles_desc', $item['seo_desc']);
    update_post_meta($post_id, '_seopress_analysis_target_kw', $item['target_kw']);
    WP_CLI::success(($existing ? 'Updated ' : 'Published ') . $post_id . ' ' . $item['slug']);
}

$extensions = [
    264 => [
        'marker' => '<!-- kalkan-intent-extension-unknown-family -->',
        'html' => <<<'HTML'
<!-- kalkan-intent-extension-unknown-family -->
<h2>Çocuğunuza veya kardeşinize gelen bilinmeyen aramalar</h2>
<p>Bu ayarı bir çocuğun, kardeşinizin veya başka bir aile üyesinin telefonunda düşünüyorsanız önce önemli kişileri rehbere ekleyin: ebeveynler, okul, servis, doktor ve düzenli iletişim kurulan yakınlar. Yine de okulun farklı bir hattı, yeni bir öğretmen, kurye veya acil durumda kullanılan başka bir telefon rehberde olmayabilir. Bu yüzden sessize alma özelliği açıksa arama listesini birlikte ve düzenli kontrol edin.</p>
<p>Çocuklar için yalnızca teknik bir ayar yeterli değildir. Beklenmedik bir aramada kod, parola, para veya gizlilik isteyen kişiye yanıt vermeden <strong>dur, kapat ve güvendiğin bir yetişkine anlat</strong> kuralını kullanın. Daha kapsamlı öneriler için <a href="https://kalkanapp.com/cocuklar-ve-gencler-icin-telefon-dolandiriciligi-rehberi/">çocuklar ve gençler için telefon dolandırıcılığı rehberini</a> okuyun.</p>
HTML,
    ],
    275 => [
        'marker' => '<!-- kalkan-intent-extension-child-unknown -->',
        'html' => <<<'HTML'
<!-- kalkan-intent-extension-child-unknown -->
<h2>Çocuğuma gelen bilinmeyen numaraları nasıl yönetebilirim?</h2>
<p>Önce çocuğun telefonunda aile, okul, servis ve güvenilir yakınların numaralarını kaydedin. iPhone’un bilinmeyen arayanlarla ilgili sessize alma seçeneği dikkat dağıtan aramaları azaltabilir; ancak rehberde olmayan gerçek bir okul, kurye veya acil iletişim araması da sessize alınabilir. Bu nedenle özelliği açtıysanız cevapsız arama listesini çocukla birlikte kontrol edin ve bilmediği bir numarayı geri aramadan önce size sormasını isteyin.</p>
<p>Ayarın avantajlarını, risklerini ve güncel iPhone adımlarını <a href="https://kalkanapp.com/iphoneda-bilinmeyen-arayanlari-sessize-alma/">iPhone’da bilinmeyen arayanları sessize alma rehberinde</a> bulabilirsiniz.</p>
HTML,
    ],
    239 => [
        'marker' => '<!-- kalkan-intent-extension-relatives -->',
        'html' => <<<'HTML'
<!-- kalkan-intent-extension-relatives -->
<h2>Kardeşinizi ve yakınlarınızı şüpheli aramalardan koruma</h2>
<p>Aile içindeki herkes için aynı kısa kontrol zincirini belirleyin: aramayı sonlandır, mesajdaki bağlantıya dokunma, kurumun numarasını resmî sitesinden kendin bul ve gerekiyorsa başka bir aile üyesine sor. Özellikle “hemen ödeme yap”, “bu görüşmeyi kimseye söyleme” veya “telefonuna gelen kodu oku” gibi baskı cümleleri şüpheli aramayı durdurmak için yeterli bir işarettir.</p>
<p>Bir yakının telefonunda bilinmeyen aramaları sessize alma özelliği kullanılacaksa sağlık, okul, servis ve diğer önemli numaraları önce rehbere ekleyin; cevapsız aramaları da düzenli kontrol edin. Hiçbir arayan kimliği etiketi, ekranda görünen numaranın teknik olarak taklit edilmediğini garanti etmez.</p>
HTML,
    ],
];

foreach ($extensions as $post_id => $extension) {
    $post = get_post($post_id);
    if (!$post) {
        WP_CLI::warning("Post {$post_id} was not found");
        continue;
    }
    if (strpos($post->post_content, $extension['marker']) !== false) {
        WP_CLI::log("Post {$post_id} already contains the extension");
        continue;
    }
    $result = wp_update_post([
        'ID' => $post_id,
        'post_content' => rtrim($post->post_content) . "\n\n" . $extension['html'],
    ], true);
    if (is_wp_error($result)) {
        WP_CLI::warning("Post {$post_id}: " . $result->get_error_message());
    } else {
        WP_CLI::success("Extended post {$post_id}");
    }
}

WP_CLI::success('Relationship-intent content update completed.');
