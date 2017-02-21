<?php
require_once SNSHADONA_THEME_DIR . '/framework/class-tgm-plugin-activation.php'; // Plugin for installation and activation plugins.
require_once SNSHADONA_THEME_DIR . '/framework/plugins-need-active.php'; // Active somes plugins.
require_once SNSHADONA_THEME_DIR . '/framework/sns-class.php'; // Theme Class
require_once SNSHADONA_THEME_DIR . '/framework/sns-options.php'; // Theme Options.
require_once SNSHADONA_THEME_DIR . '/framework/sns-metabox.php'; // Metabox
require_once SNSHADONA_THEME_DIR . '/framework/sns-menu.php'; // Mega menu
require_once SNSHADONA_THEME_DIR . '/framework/sns-widgets.php'; // Widgets

if ( class_exists('WooCommerce') ) require_once SNSHADONA_THEME_DIR . '/framework/sns-woocomerce.php'; // Woo function
// Init Theme Options in admin panel
$reduxConfig = new snshadona_Options();
// Get Theme Options's value
$snshadona_opt =  get_option('snshadona_themeoptions');
// 
$snshadona_obj = new snshadona_Class;

require_once SNSHADONA_THEME_DIR . '/framework/sns-functions.php'; // Functions
?>