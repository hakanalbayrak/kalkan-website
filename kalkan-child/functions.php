<?php
/**
 * Kalkan Child Theme functions.
 *
 * Extend this file conservatively and keep logic simple.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue child stylesheet.
 *
 * We load after parent styles and keep dependency handling minimal.
 */
function kalkan_child_enqueue_styles() {
    $dependencies = array();

    // If Blocksy registered its main stylesheet, load child CSS after it.
    if (wp_style_is('blocksy-style', 'registered') || wp_style_is('blocksy-style', 'enqueued')) {
        $dependencies[] = 'blocksy-style';
    }

    wp_enqueue_style(
        'kalkan-child-style',
        get_stylesheet_uri(),
        $dependencies,
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'kalkan_child_enqueue_styles', 20);

/**
 * Register lightweight theme settings used by code-rendered homepage.
 */
function kalkan_child_customize_register($wp_customize) {
    $wp_customize->add_setting(
        'kalkan_app_store_url',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'kalkan_app_store_url',
        array(
            'type'        => 'url',
            'section'     => 'title_tagline',
            'label'       => __('Kalkan App Store URL', 'kalkan-child'),
            'description' => __('Used for homepage App Store CTA buttons.', 'kalkan-child'),
        )
    );
}
add_action('customize_register', 'kalkan_child_customize_register');

/**
 * App Store URL override for homepage template.
 */
function kalkan_child_filter_app_store_url($url) {
    $customizer_value = get_theme_mod('kalkan_app_store_url', '');

    if (!empty($customizer_value)) {
        return $customizer_value;
    }

    return $url;
}
add_filter('kalkan_app_store_url', 'kalkan_child_filter_app_store_url');

/**
 * Map menu item labels to a normalized key used for ordering.
 */
function kalkan_child_get_menu_item_key($menu_item) {
    $title = isset($menu_item->title) ? wp_strip_all_tags((string) $menu_item->title) : '';
    $title = strtolower(trim((string) preg_replace('/\s+/', ' ', $title)));

    if ('home' === $title) {
        return 'home';
    }

    if (false !== strpos($title, 'number lookup')) {
        return 'number lookup';
    }

    if (false !== strpos($title, 'blog')) {
        return 'blog';
    }

    if (false !== strpos($title, 'privacy')) {
        return 'privacy policy';
    }

    if (false !== strpos($title, 'term')) {
        return 'terms';
    }

    if (false !== strpos($title, 'contact') || false !== strpos($title, 'support')) {
        return 'contact';
    }

    return '';
}

/**
 * Resolve root parent menu item ID for consistent top-level sorting.
 */
function kalkan_child_get_root_menu_item_id($item_id, $parent_map) {
    $root   = (int) $item_id;
    $safety = 0;

    while (isset($parent_map[$root]) && (int) $parent_map[$root] > 0 && $safety < 25) {
        $root = (int) $parent_map[$root];
        $safety++;
    }

    return $root;
}

/**
 * Enforce top menu order for Kalkan marketing navigation.
 */
function kalkan_child_reorder_menu_items($items, $args) {
    if (empty($items) || !is_array($items)) {
        return $items;
    }

    // Skip footer-like locations to avoid unintended reordering.
    if (isset($args->theme_location) && false !== strpos((string) $args->theme_location, 'footer')) {
        return $items;
    }

    $target_order = array(
        'home',
        'number lookup',
        'blog',
        'privacy policy',
        'terms',
        'contact',
    );

    $top_level_items = array();
    foreach ($items as $item) {
        if ((int) $item->menu_item_parent === 0) {
            $top_level_items[] = $item;
        }
    }

    if (empty($top_level_items)) {
        return $items;
    }

    $ordered_root_ids = array();
    $matched_count     = 0;

    foreach ($target_order as $target_key) {
        foreach ($top_level_items as $top_level_item) {
            if (in_array((int) $top_level_item->ID, $ordered_root_ids, true)) {
                continue;
            }

            if (kalkan_child_get_menu_item_key($top_level_item) === $target_key) {
                $ordered_root_ids[] = (int) $top_level_item->ID;
                $matched_count++;
                break;
            }
        }
    }

    // If this does not look like the main site menu, leave it untouched.
    if ($matched_count < 3) {
        return $items;
    }

    foreach ($top_level_items as $top_level_item) {
        if (!in_array((int) $top_level_item->ID, $ordered_root_ids, true)) {
            $ordered_root_ids[] = (int) $top_level_item->ID;
        }
    }

    $root_rank      = array();
    $parent_map     = array();
    $original_index = array();

    foreach ($ordered_root_ids as $index => $root_id) {
        $root_rank[(int) $root_id] = (int) $index;
    }

    foreach ($items as $index => $item) {
        $parent_map[(int) $item->ID]     = (int) $item->menu_item_parent;
        $original_index[(int) $item->ID] = (int) $index;
    }

    usort(
        $items,
        function ($a, $b) use ($root_rank, $parent_map, $original_index) {
            $a_id   = (int) $a->ID;
            $b_id   = (int) $b->ID;
            $a_root = kalkan_child_get_root_menu_item_id($a_id, $parent_map);
            $b_root = kalkan_child_get_root_menu_item_id($b_id, $parent_map);

            $a_rank = $root_rank[$a_root] ?? 9999;
            $b_rank = $root_rank[$b_root] ?? 9999;

            if ($a_rank === $b_rank) {
                $a_original = $original_index[$a_id] ?? 0;
                $b_original = $original_index[$b_id] ?? 0;

                return $a_original <=> $b_original;
            }

            return $a_rank <=> $b_rank;
        }
    );

    return $items;
}
add_filter('wp_nav_menu_objects', 'kalkan_child_reorder_menu_items', 20, 2);

/**
 * Theme setup: title-tag, thumbnails, navigation.
 */
function kalkan_child_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menus(
        array(
            'kalkan-header' => __('Kalkan Header Menu', 'kalkan-child'),
            'kalkan-footer' => __('Kalkan Footer Menu', 'kalkan-child'),
        )
    );
}
add_action('after_setup_theme', 'kalkan_child_theme_setup');

/**
 * Enqueue Google Fonts: Plus Jakarta Sans + Inter.
 */
function kalkan_child_enqueue_google_fonts() {
    wp_enqueue_style(
        'kalkan-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'kalkan_child_enqueue_google_fonts', 5);

/**
 * Shortcode: [kalkan_subscribe] — placeholder for FluentCRM form.
 * Replace the inner HTML with the actual FluentCRM shortcode when ready.
 *
 * @return string HTML output.
 */
function kalkan_subscribe_shortcode() {
    return '<div class="kalkan-subscribe-placeholder" style="padding:1.5rem;border:1px dashed rgba(139,92,246,0.35);border-radius:0.75rem;text-align:center;color:#c4b5fd;font-size:0.95rem;">'
        . esc_html__('Email subscription form — connect FluentCRM here.', 'kalkan-child')
        . '</div>';
}
add_shortcode('kalkan_subscribe', 'kalkan_subscribe_shortcode');

/**
 * Add favicon and apple-touch-icon using the Kalkan app icon.
 */
function kalkan_child_favicon() {
    $icon_url = esc_url( get_stylesheet_directory_uri() . '/assets/images/KalkanAppIcon.png' );
    echo '<link rel="icon" type="image/png" href="' . $icon_url . '">' . "\n";
    echo '<link rel="apple-touch-icon" href="' . $icon_url . '">' . "\n";
}
add_action('wp_head', 'kalkan_child_favicon', 1);
