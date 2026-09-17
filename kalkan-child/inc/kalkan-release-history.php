<?php
/**
 * Public App Store release history for the version-history pages.
 *
 * Only public, downloadable versions are read from Apple's storefront lookup.
 * An approved version waiting for developer release is deliberately excluded.
 *
 * @package kalkan-child
 */

if (!defined('ABSPATH')) {
    exit;
}

const KALKAN_IOS_APP_ID = 6759873828;
const KALKAN_IOS_BUNDLE_ID = 'com.kalkan.website.kalkan';
const KALKAN_RELEASE_HISTORY_OPTION = 'kalkan_ios_public_releases_v1';

/** Releases already visible on Apple's Turkish storefront before automation. */
function kalkan_ios_release_history_seed() {
    return array(
        '1.0.8' => array(
            'version' => '1.0.8',
            'date' => '2026-09-07',
            'notes_tr' => "Koruma durumunu daha anlaşılır gösteren yenilenmiş ana ekran ve ayarlar.\nDuyurulardaki makalelere güvenli ve ölçülebilir bağlantılar.\nYeni sürüm hazır olduğunda uygulama içi güncelleme hatırlatması.\nPerformans, reklam yerleşimi ve güvenilirlik iyileştirmeleri.",
            'notes_en' => "Refreshed Home and Settings screens with clearer protection status.\nSafe, trackable links to articles in Announcements.\nIn-app update reminders when a newer version is available.\nPerformance, ad placement, and reliability improvements.",
        ),
        '1.0.7' => array(
            'version' => '1.0.7',
            'date' => '2026-09-04',
            'notes_tr' => "Koruma verilerinin güncelliği artık ana ekranda daha net gösterilir.\nGüncelleme işlemi veri kullanımını azaltmak için günde bir kez çalıştırılabilir.\nBir aydan eski koruma verileri için tek seferlik hatırlatma eklendi.\nAna ekran ve Ayarlar ekranına gizlilik izinli reklam alanları eklendi.\nGenel performans ve kararlılık iyileştirildi.",
            'notes_en' => "Protection-data freshness is now clearer on the Home screen.\nTo reduce data use, protection data can be updated once per day.\nA one-time reminder was added for protection data older than one month.\nPrivacy-permitted ad placements were added to Home and Settings.\nGeneral performance and reliability improvements.",
        ),
    );
}

/** Read the public releases recorded after the seed versions. */
function kalkan_ios_release_history_entries() {
    $entries = kalkan_ios_release_history_seed();
    $saved = get_option(KALKAN_RELEASE_HISTORY_OPTION, array());
    if (is_array($saved)) {
        foreach ($saved as $version => $release) {
            if (is_string($version) && preg_match('/^\d+(?:\.\d+){1,3}$/', $version) && is_array($release) && isset($release['date'], $release['notes_tr'])) {
                $entries[$version] = $release;
            }
        }
    }
    uksort($entries, static function ($a, $b) {
        return version_compare($b, $a);
    });
    return $entries;
}

/** Format Apple's public release date without depending on the site's locale. */
function kalkan_ios_release_history_date($date, $language) {
    if (!is_string($date) || !preg_match('/^\d{4}-(\d{2})-(\d{2})$/', $date, $parts)) {
        return '';
    }
    $months_tr = array(1 => 'Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık');
    $months_en = array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $month = (int) $parts[1];
    if (!isset($months_tr[$month]) || !checkdate($month, (int) $parts[2], (int) substr($date, 0, 4))) {
        return '';
    }
    return (int) $parts[2] . ' ' . ('en' === $language ? $months_en[$month] : $months_tr[$month]) . ' ' . substr($date, 0, 4);
}

/** Obtain one locale from Apple's public iTunes lookup (not App Store Connect). */
function kalkan_ios_release_history_lookup($language) {
    $url = add_query_arg(array(
        'id' => KALKAN_IOS_APP_ID,
        'country' => 'tr',
        'lang' => 'en' === $language ? 'en_us' : 'tr_tr',
    ), 'https://itunes.apple.com/lookup');
    $response = wp_remote_get($url, array('timeout' => 10));
    if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
        return null;
    }
    $body = json_decode(wp_remote_retrieve_body($response), true);
    if (!is_array($body) || 1 !== (int) ($body['resultCount'] ?? 0) || !isset($body['results'][0]) || !is_array($body['results'][0])) {
        return null;
    }
    $result = $body['results'][0];
    if (KALKAN_IOS_APP_ID !== (int) ($result['trackId'] ?? 0) || KALKAN_IOS_BUNDLE_ID !== ($result['bundleId'] ?? '')) {
        return null;
    }
    return $result;
}

/** Invalidate only the two version-history pages when their content changes. */
function kalkan_ios_release_history_purge_pages() {
    foreach (array('surum-gecmisi', 'version-history') as $slug) {
        $page = get_page_by_path($slug);
        if ($page) {
            do_action('litespeed_purge_url', get_permalink($page->ID));
        }
    }
}

/** Persist a new version only when both storefront locales show it publicly. */
function kalkan_ios_release_history_sync() {
    $tr = kalkan_ios_release_history_lookup('tr');
    $en = kalkan_ios_release_history_lookup('en');
    if (!$tr || !$en || !isset($tr['version'], $en['version']) || $tr['version'] !== $en['version']) {
        return false;
    }
    $version = (string) $tr['version'];
    if (!preg_match('/^\d+(?:\.\d+){1,3}$/', $version) || version_compare($version, '1.0.8', '<=')) {
        return false;
    }
    $date = isset($tr['currentVersionReleaseDate']) ? strtotime((string) $tr['currentVersionReleaseDate']) : false;
    if (!$date || $date > time() + DAY_IN_SECONDS || $date < strtotime('2026-09-07')) {
        return false;
    }
    $notes_tr = isset($tr['releaseNotes']) ? trim((string) $tr['releaseNotes']) : '';
    $notes_en = isset($en['releaseNotes']) ? trim((string) $en['releaseNotes']) : '';
    if ('' === $notes_tr || '' === $notes_en) {
        return false;
    }
    $saved = get_option(KALKAN_RELEASE_HISTORY_OPTION, array());
    if (!is_array($saved)) {
        $saved = array();
    }
    if (isset($saved[$version])) {
        return true;
    }
    $saved[$version] = array(
        'version' => $version,
        'date' => gmdate('Y-m-d', $date),
        'notes_tr' => sanitize_textarea_field($notes_tr),
        'notes_en' => sanitize_textarea_field($notes_en),
    );
    update_option(KALKAN_RELEASE_HISTORY_OPTION, $saved, false);
    kalkan_ios_release_history_purge_pages();
    return true;
}
add_action('kalkan_ios_release_history_daily_sync', 'kalkan_ios_release_history_sync');

function kalkan_ios_release_history_initial_sync() {
    kalkan_ios_release_history_sync();
    kalkan_ios_release_history_purge_pages();
    update_option('kalkan_ios_release_history_initial_sync_done_v1', true, false);
}
add_action('kalkan_ios_release_history_initial_sync', 'kalkan_ios_release_history_initial_sync');

/** Daily check at 16:59 Türkiye time; WP-Cron may run later if traffic is absent. */
function kalkan_ios_release_history_schedule() {
    if (!wp_next_scheduled('kalkan_ios_release_history_daily_sync')) {
        $timezone = new DateTimeZone('Europe/Istanbul');
        $next = new DateTimeImmutable('today 16:59', $timezone);
        if ($next->getTimestamp() <= time()) {
            $next = $next->modify('+1 day');
        }
        wp_schedule_event($next->getTimestamp(), 'daily', 'kalkan_ios_release_history_daily_sync');
    }
    if (!get_option('kalkan_ios_release_history_initial_sync_done_v1') && !wp_next_scheduled('kalkan_ios_release_history_initial_sync')) {
        wp_schedule_single_event(time() + 60, 'kalkan_ios_release_history_initial_sync');
    }
}
add_action('init', 'kalkan_ios_release_history_schedule');
