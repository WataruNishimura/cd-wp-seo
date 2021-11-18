<?php
/**
 * Plugin Name:     Cd Wp Seo
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     cd-wp-seo
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Cd_Wp_Seo
 */

// Your code starts here.
function cws_admin_menu() {
  add_menu_page("CD WP SEO", "metaタグ設定", "manage_options", "cws_meta_settings", "cws_meta_settings_menu", "", 99);
}

function cws_meta_settings_menu() {
  ?>
  <div id="cws-admin-meta-page"></div>
  <?php
}


// Enqueue Scripts
function cws_admin_enqueue_scripts($hook_suffix) {

  $asset_file = include(plugin_dir_path(__FILE__) . "/build/index.asset.php");
  wp_enqueue_media(); 
  wp_enqueue_style("cws_admin_style", plugin_dir_url(__FILE__) . "/build/style-index.css", ["wp-components"]);
  wp_enqueue_script("cws_admin_script", plugin_dir_url(__FILE__) . "/build/index.js", $asset_file["dependencies"], $asset_file["version"], true);
}
add_action("admin_enqueue_scripts", "cws_admin_enqueue_scripts");
add_action("admin_menu", "cws_admin_menu");