<?php
/** Minimal standalone checks for the App Store release-history sync. */

define('ABSPATH', __DIR__ . '/');
define('DAY_IN_SECONDS', 86400);
$options = array();
$writes = 0;
$fixtures = array();

function add_action() {}
function add_query_arg($args, $url) { return $url . '?' . http_build_query($args); }
function get_option($key, $default = false) { global $options; return $options[$key] ?? $default; }
function update_option($key, $value, $autoload = null) { global $options, $writes; $options[$key] = $value; ++$writes; return true; }
function is_wp_error($value) { return false; }
function wp_remote_retrieve_response_code($response) { return $response['status']; }
function wp_remote_retrieve_body($response) { return $response['body']; }
function sanitize_textarea_field($value) { return trim(strip_tags($value)); }
function wp_remote_get($url, $args) {
    global $fixtures;
    parse_str((string) parse_url($url, PHP_URL_QUERY), $query);
    $locale = $query['lang'] ?? '';
    return array('status' => 200, 'body' => json_encode(array('resultCount' => 1, 'results' => array($fixtures[$locale] ?? array()))));
}
function wp_next_scheduled() { return false; }
function wp_schedule_event() { return true; }
function wp_schedule_single_event() { return true; }
function get_page_by_path() { return null; }
function get_permalink() { return ''; }
function do_action() {}

require dirname(__DIR__) . '/kalkan-child/inc/kalkan-release-history.php';

function check($condition, $message) {
    if (!$condition) {
        fwrite(STDERR, $message . "\n");
        exit(1);
    }
}

$base = array(
    'trackId' => KALKAN_IOS_APP_ID,
    'bundleId' => KALKAN_IOS_BUNDLE_ID,
    'version' => '1.0.9',
    'currentVersionReleaseDate' => '2026-09-17T09:00:00Z',
);
$fixtures['tr_tr'] = $base + array('releaseNotes' => "• Yeni özellik\n• Hata düzeltmesi");
$fixtures['en_us'] = $base + array('releaseNotes' => "• New feature\n• Bug fix");

check(array_keys(kalkan_ios_release_history_entries()) === array('1.0.8', '1.0.7'), 'Seed order is incorrect');
check(kalkan_ios_release_history_date('2026-09-07', 'tr') === '7 Eylül 2026', 'Turkish date is incorrect');
check(kalkan_ios_release_history_sync(), 'Public release was not recorded');
check(array_keys(kalkan_ios_release_history_entries()) === array('1.0.9', '1.0.8', '1.0.7'), 'New release is not first');
$recorded_writes = $writes;
check(kalkan_ios_release_history_sync() && $writes === $recorded_writes, 'Duplicate sync wrote again');

$fixtures['tr_tr']['version'] = '1.0.10';
check(!kalkan_ios_release_history_sync() && $writes === $recorded_writes, 'Locale mismatch was recorded');
$fixtures['tr_tr']['version'] = '1.0.9';
$fixtures['tr_tr']['bundleId'] = 'wrong.bundle';
check(!kalkan_ios_release_history_sync() && $writes === $recorded_writes, 'Wrong app was recorded');

echo "Release-history checks passed\n";
