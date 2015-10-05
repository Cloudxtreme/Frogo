<?php
/**
 * @package GeneratePress
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemprop="blogPost" itemtype="http://schema.org/BlogPosting" itemscope="itemscope">
    <div class="single-post-header-link">
        <?php echo '<a href="' . get_category_link(36) . '">' . __('All our projects') . '</a>'; ?>
    </div>
    <div class="inside-article">
        <header class="entry-header">
            <?php the_title('<h1 class="entry-title" itemprop="headline">', '</h1>'); ?>
        </header><!-- .entry-header -->
        <?php do_action('generate_after_entry_header'); ?>
        <div class="entry-content" itemprop="text">
            <?php //do_action('generate_before_content'); ?>
            <?php
            $image_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
            echo '<a href="' . $image_url[0] . '" class="colorbox alignleft">' . wp_get_attachment_image(get_post_thumbnail_id(get_the_ID())) . '</a>';
            ?>
            <?php the_content(); ?>
            <?php
            wp_link_pages(array(
              'before' => '<div class="page-links">' . __('Pages:', 'generate'),
              'after' => '</div>',
            ));
            ?>
        </div><!-- .entry-content -->

        <?php do_action('generate_after_entry_content'); ?>
        <?php
        if (have_rows('galerie')) {
          echo "<h3 class='post-gallery'>";
          _e('Project Gallery');
          echo "</h3>";
          ?>
          <div class="sub-filds">
              <div class="sub-filds-gallery">
                  <?php
                  while (have_rows('galerie')) : the_row();
                    if (get_sub_field('popisek')) {
                      $popisek = "title='" . get_sub_field('popisek') . "'";
                    }
                    if (get_sub_field('id_youtube_videa')) {
                      ?>
                      <a href = "http://www.youtube.com/embed/<?= get_sub_field('id_youtube_videa') ?>" class="wp-colorbox-youtube cboxElement sub-fields-video-gallery" <?= $popisek ?>><?php
                          if (get_sub_field('obrazek')) {
                            $image = get_sub_field('obrazek');
                            ?>
                            <img src="<?= $image["sizes"]["thumbnail"] ?>" class="colorbox-00">
                            <div class="youtube-overlay"></div>
                            <?php
                          }
                          else {
                            ?>
                            <img src="<?= get_template_directory_uri() ?>/images/youtube-overlay-150.png" class="colorbox-00">
                            <?php
                          }
                          ?>
                      </a>
                      <?php
                    }
                    else {
                      $image = get_sub_field('obrazek');
                      ?>
                      <a href="<?= $image["url"] ?>" class="cboxElement" <?= $popisek ?>>
                          <img src="<?= $image["sizes"]["thumbnail"] ?>" class="colorbox-00">
                      </a>
                      <?php
                    }
                  endwhile;
                  ?>
              </div>
          </div>
          <?php
        }
        ?>

        <div class="entry-meta">
            <?php
            $post = get_post(get_the_ID());
            $date = date_create($post->post_modified);
            echo __('Modified') . ": " . date_format($date, 'd. m. Y');
            ?>
        </div><!-- .entry-meta -->
        <footer class="entry-meta">
            <?php //generate_entry_meta();  ?>
            <?php generate_content_nav('nav-below'); ?>
            <?php edit_post_link(__('Edit', 'generate'), '<span class="edit-link">', '</span>'); ?>
        </footer><!-- .entry-meta -->
        <?php do_action('generate_after_content'); ?>
    </div><!-- .inside-article -->
</article><!-- #post-## -->
