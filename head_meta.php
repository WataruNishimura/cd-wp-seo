<?php


function cws_meta_ogp($title, $desc, $img = "", $type = "article", $url, $small_card = null)
{
?>
  <!-- This code is generated by CD WP SEO plugin. To know about this plugin. Search it. -->
  <title><?= $title ?></title>
  <meta name="description" content="<?= $desc; ?>">
  <meta property="og:type" content="<?= $type ?>">
  <meta property="og:description" content="<?= $desc; ?>">
  <meta property="og:title" content="<?= $title ?>">
  <meta property="og:image" content="<?= $img ?>">
  <meta property="og:url" content="<?= $url ?>">
  <meta name="twitter:site" content="@sensed_">
  <?php
  if ($small_card) {
  ?>
    <meta name="twitter:card" content="summary">
  <?php
  } else {

  ?>
    <meta name="twitter:card" content="summary_large_image">
  <?php
  }
  ?>

  <meta property="og:site_name" content="<?= get_bloginfo("name"); ?>">
  <!-- END -->
<?php
}

function cws_ogp_header()
{


  $ogp_replace_img = get_template_directory_uri() . "/assets/ogp.png";
  function cws_title_export($name)
  {
    $title = $name . " | " . get_bloginfo("name");
    return $title;
  }

  // フロント/ホームページの場合
  if (is_home()) {
    cws_meta_ogp(get_bloginfo("name"), $common_description, $ogp_replace_img, "website", $url = home_url());
  }

  //アーカイブページの場合
  if (is_archive()) {
    if (is_category()) {
      $url =  get_category_link(get_query_var('cat'));
      $title = cws_title_export(single_cat_title("", false) . " の記事一覧");
      cws_meta_ogp(
        $title,
        single_cat_title("", false) . " の記事一覧ページです。",
        $ogp_replace_img,
        $type = "aricle",
        $url = $url
      );
    } else if (is_tag()) {
      $url =  get_tag_link(get_query_var('tag_id'));
      $title = cws_title_export("タグ：" . single_tag_title("", false) . " の記事一覧");
      cws_meta_ogp(
        $title,
        single_tag_title("",  false)  . " の記事一覧ページです。",
        $ogp_replace_img,
        $type = "article",
        $url = $url
      );
    } else if (is_author()) {
      $id =  get_the_author_meta("ID");
      $url = get_author_posts_url($id);
      $title = cws_title_export(get_the_author_meta("display_name"));
      $desc = "";
      if (function_exists("get_field") && function_exists("the_field")) :
        if (get_field("profile",  "user_" . $id) != "") :
          $content = get_field("profile", 'user_' . $id, false);
          $tmp = preg_replace('/<a .*?>/', "", $content);
          $tmp_a = preg_replace('/<\/a>/', "", $tmp);
          $tmp_span = preg_replace('/<span .*?>/', "", $tmp_a);
          $tmp_br = preg_replace('/<\/span>/', "", $tmp_span);
          $desc = preg_replace("/<br>/", "", $tmp_br);
        else :
          if (get_the_author_meta("description", $id) != "") :
            $desc = get_the_author_meta("description", $id);
          endif;
        endif;
      else :
        if (get_the_author_meta("description", $id) != "") :
          $desc = get_the_author_meta("description", $id);
        endif;
      endif;
      if (empty($desc)) {
        $desc = $common_description;
      }
      $desc = get_the_author_meta("display_name") . " ー " . $desc;
      cws_meta_ogp(
        $title,
        $desc,
        get_avatar_url($id),
        $type = "article",
        $url,
        true
      );
    } else if (!is_post_type_archive("post")) {
      $url =  get_post_type_archive_link(get_query_var("post_type"));
      $title = cws_title_export(get_query_var("post_type") . " の記事一覧");
      cws_meta_ogp(
        $title,
        get_query_var("post_type")  . " の記事一覧ページです。",
        $ogp_replace_img,
        $type = "article",
        $url = $url
      );
    } else {
      $url =  get_term_link(get_query_var('term'));
      $title = cws_title_export(single_term_title("", false) . " の記事一覧");
      cws_meta_ogp(
        $title,
        single_tag_title("",  false)  . " の記事一覧ページです。",
        $ogp_replace_img,
        $type = "article",
        $url = $url
      );
    }
  }

  //Aboutページの場合
  if (is_page("about")) {
    $url = get_the_permalink();
    $desc = "デジタルネイティブ世代のSENSEを加速させる（driveする）ための探究型メディアを目指します。ただの若者メディアではなく、デジタルネイティブとともに彼らの探究テーマに沿ったプロジェクトを立ち上げ記事という形で情報を発信。探究による知見を活かした事業を展開しデジタルネイティブ世代のエコシステムを社会実装することをめざすIRENKA KOTANのプロジェクトです。";
    $title = cws_title_export("SENSE:Dについて");
    cws_meta_ogp(
      $title,
      $desc,
      $ogp_replace_img,
      $type = "article",
      $url
    );
  }

  //固定ページの場合
  if (is_page()) {
    $url = get_the_permalink();
    $desc = get_the_excerpt();
    $title = cws_title_export(get_the_title());
    cws_meta_ogp(
      $title,
      $desc,
      $ogp_replace_img,
      $type = "article",
      $url
    );
  }

  //投稿ページの場合
  if (is_single()) {
    $url = get_the_permalink();
    $desc = get_the_excerpt();
    $title = cws_title_export(get_the_title());
    if (has_post_thumbnail()) {
      $img = get_the_post_thumbnail_url();
    } else {
      $img = $ogp_replace_img;
    }
    cws_meta_ogp(
      $title,
      $desc,
      $img,
      $type = "article",
      $url
    );
  }

  // 404の場合
  if (is_404()) {
    $url = home_url();
    $desc = get_the_excerpt();
    $title = cws_title_export("404 Not Found お探しの記事は見つかりませんでした。");
    $img = $ogp_replace_img;
    cws_meta_ogp(
      $title,
      $desc,
      $img,
      $type = "article",
      $url
    );
  }
}
