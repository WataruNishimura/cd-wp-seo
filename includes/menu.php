<?php 

function cws_admin_menu() {
  add_menu_page("CD WP SEO", "metaタグ設定", "manage_options", "cws_meta_settings", "cws_meta_settings_menu", "", 10);
}

function cws_meta_settings_menu() {
  ?>
  <div id="cws-admin-meta-page"></div>
  <?php
}

?>