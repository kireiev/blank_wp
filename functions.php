<?php
//custom theme url
function theme(){
    return bloginfo('stylesheet_directory');
}
// add_image_size( 'testimonials_ic', '240', '240', true );

//register menus
register_nav_menus(array(
    'general' => 'General'
));

//register acf_options
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
    acf_add_options_sub_page(array(
        'page_title'    => 'Theme Header Settings',
        'menu_title'    => 'Header',
        'parent_slug'   => 'theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title'    => 'Theme Footer Settings',
        'menu_title'    => 'Footer',
        'parent_slug'   => 'theme-general-settings',
    ));
}

//Deregister Contact Form 7 styles
add_action( 'wp_print_styles', 'voodoo_deregister_styles', 100 );
function voodoo_deregister_styles() {
  wp_deregister_style( 'contact-form-7' );
}
//REMOVE AUTO-TOP
if(defined('WPCF7_VERSION')) {
  function maybe_reset_autop( $form ) {
    $form_instance = WPCF7_ContactForm::get_current();
    $manager = WPCF7_ShortcodeManager::get_instance();
    $form_meta = get_post_meta( $form_instance->id(), '_form', true );
    $form = $manager->do_shortcode( $form_meta );
    $form_instance->set_properties( array(
        'form' => $form
    ) );
    return $form;
  }
  add_filter( 'wpcf7_form_elements', 'maybe_reset_autop' );
}

//Thumbnails theme support
add_theme_support( 'post-thumbnails' );

// Clean wp_head
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head' );
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head' );
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rel_canonical');
// Remove Emoji js/styles
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
// Remove wp version param from any enqueued scripts
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

// Disable Responsive Images
add_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );
// Filters for WP-API version 1.x
add_filter('json_enabled', '__return_false');
add_filter('json_jsonp_enabled', '__return_false');
// Filters for WP-API version 2.x
add_filter('rest_enabled', '__return_false');
add_filter('rest_jsonp_enabled', '__return_false');
remove_action( 'wp_head', 'rest_output_link_wp_head' );
// Remove recent_comments_style in wp_head
add_action('widgets_init', 'my_remove_recent_comments_style');
function my_remove_recent_comments_style() {
    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}

//Custom JS/CSS
function tt_add_jscss() {
    if (!is_admin()) {
        wp_deregister_script( 'jquery' );
    }
    wp_deregister_style( 'contact-form-7' );
    if(defined('QTRANS_INIT')) {
        wp_deregister_style('qtranslate-style');
    }
    //wp_enqueue_script('googlemaps', '//maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false', array(), '', false);
    wp_enqueue_script('jquery', get_template_directory_uri().'/js/jquery-2.2.3.min.js', array(), '', false);
    wp_enqueue_script('libs', get_template_directory_uri().'/js/libs.js', array('jquery'), '', true);
    wp_enqueue_script('init', get_template_directory_uri().'/js/init.js', array('jquery'), '', true);
    wp_enqueue_style('main', get_template_directory_uri() . '/css/main.css');
    wp_enqueue_style('style', get_template_directory_uri() . '/css/style.css');
}
add_action('wp_enqueue_scripts', 'tt_add_jscss');
//remove ID in menu list
add_filter('nav_menu_item_id', 'clear_nav_menu_item_id', 10, 3);
function clear_nav_menu_item_id($id, $item, $args) {
    return "";
}

//custom SEO title
function seo_title(){
    global $post;
    if(!defined('WPSEO_VERSION')) {
        if(is_404()) {
            echo '404 Page not found - ';
        } elseif((is_single() || is_page()) && $post->post_parent) {
            $parent_title = get_the_title($post->post_parent);
            echo wp_title('-', true, 'right') . $parent_title.' - ';
        } elseif(class_exists('Woocommerce') && is_shop()) {
            echo get_the_title(SHOP_ID) . ' - ';
        } else {
            wp_title('-', true, 'right');
        }
        bloginfo('name');
    } else {
        wp_title();
    }
}

function ctl_sanitize_title($title)
{
    global $wpdb;
    $iso9_table = array(
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Ѓ' => 'G',
        'Ґ' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Є' => 'YE',
        'Ж' => 'ZH', 'З' => 'Z', 'Ѕ' => 'Z', 'И' => 'I', 'Й' => 'J',
        'Ј' => 'J', 'І' => 'I', 'Ї' => 'YI', 'К' => 'K', 'Ќ' => 'K',
        'Л' => 'L', 'Љ' => 'L', 'М' => 'M', 'Н' => 'N', 'Њ' => 'N',
        'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
        'У' => 'U', 'Ў' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'TS',
        'Ч' => 'CH', 'Џ' => 'DH', 'Ш' => 'SH', 'Щ' => 'SHH', 'Ъ' => '',
        'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'ѓ' => 'g',
        'ґ' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'є' => 'ye',
        'ж' => 'zh', 'з' => 'z', 'ѕ' => 'z', 'и' => 'i', 'й' => 'j',
        'ј' => 'j', 'і' => 'i', 'ї' => 'yi', 'к' => 'k', 'ќ' => 'k',
        'л' => 'l', 'љ' => 'l', 'м' => 'm', 'н' => 'n', 'њ' => 'n',
        'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
        'у' => 'u', 'ў' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts',
        'ч' => 'ch', 'џ' => 'dh', 'ш' => 'sh', 'щ' => 'shh', 'ъ' => '',
        'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
    );
    $geo2lat = array(
        'ა' => 'a', 'ბ' => 'b', 'გ' => 'g', 'დ' => 'd', 'ე' => 'e', 'ვ' => 'v',
        'ზ' => 'z', 'თ' => 'th', 'ი' => 'i', 'კ' => 'k', 'ლ' => 'l', 'მ' => 'm',
        'ნ' => 'n', 'ო' => 'o', 'პ' => 'p', 'ჟ' => 'zh', 'რ' => 'r', 'ს' => 's',
        'ტ' => 't', 'უ' => 'u', 'ფ' => 'ph', 'ქ' => 'q', 'ღ' => 'gh', 'ყ' => 'qh',
        'შ' => 'sh', 'ჩ' => 'ch', 'ც' => 'ts', 'ძ' => 'dz', 'წ' => 'ts', 'ჭ' => 'tch',
        'ხ' => 'kh', 'ჯ' => 'j', 'ჰ' => 'h',
    );
    $iso9_table = array_merge($iso9_table, $geo2lat);
    $locale = get_locale();
    switch ($locale) {
        case 'bg_BG':
            $iso9_table['Щ'] = 'SHT';
            $iso9_table['щ'] = 'sht';
            $iso9_table['Ъ'] = 'A';
            $iso9_table['ъ'] = 'a';
            break;
        case 'uk':
            $iso9_table['И'] = 'Y';
            $iso9_table['и'] = 'y';
            break;
        case 'uk_ua':
            $iso9_table['И'] = 'Y';
            $iso9_table['и'] = 'y';
            break;
    }
    $is_term = false;
    $backtrace = debug_backtrace();
    foreach ($backtrace as $backtrace_entry) {
        if ($backtrace_entry['function'] == 'wp_insert_term') {
            $is_term = true;
            break;
        }
    }
    $term = $is_term ? $wpdb->get_var("SELECT slug FROM {$wpdb->terms} WHERE name = '$title'") : '';
    if (empty($term)) {
        $title = strtr($title, apply_filters('ctl_table', $iso9_table));
        if (function_exists('iconv')) {
            $title = iconv('UTF-8', 'UTF-8//TRANSLIT//IGNORE', $title);
        }
        $title = preg_replace("/[^A-Za-z0-9'_\-\.]/", '-', $title);
        $title = preg_replace('/\-+/', '-', $title);
        $title = preg_replace('/^-+/', '', $title);
        $title = preg_replace('/-+$/', '', $title);
    } else {
        $title = $term;
    }
    return $title;
}
add_filter('sanitize_title', 'ctl_sanitize_title', 9);
add_filter('sanitize_file_name', 'ctl_sanitize_title');
function ctl_convert_existing_slugs()
{
    global $wpdb;
    $posts = $wpdb->get_results("SELECT ID, post_name FROM {$wpdb->posts} WHERE post_name REGEXP('[^A-Za-z0-9\-]+') AND post_status IN ('publish', 'future', 'private')");
    foreach ((array)$posts as $post) {
        $sanitized_name = ctl_sanitize_title(urldecode($post->post_name));
        if ($post->post_name != $sanitized_name) {
            add_post_meta($post->ID, '_wp_old_slug', $post->post_name);
            $wpdb->update($wpdb->posts, array('post_name' => $sanitized_name), array('ID' => $post->ID));
        }
    }
    $terms = $wpdb->get_results("SELECT term_id, slug FROM {$wpdb->terms} WHERE slug REGEXP('[^A-Za-z0-9\-]+') ");
    foreach ((array)$terms as $term) {
        $sanitized_slug = ctl_sanitize_title(urldecode($term->slug));
        if ($term->slug != $sanitized_slug) {
            $wpdb->update($wpdb->terms, array('slug' => $sanitized_slug), array('term_id' => $term->term_id));
        }
    }
}
function ctl_schedule_conversion()
{
    add_action('shutdown', 'ctl_convert_existing_slugs');
}
register_activation_hook(__FILE__, 'ctl_schedule_conversion');


//simple function for wp_get_attachment_image_src()
function image_src($id, $size = 'full', $background_image = false, $height = false) {
    if ($image = wp_get_attachment_image_src($id, $size, true)) {
        return $background_image ? 'background-image: url('.$image[0].');' . ($height?'height:'.$image[2].'px':'') : $image[0];
    }
}
