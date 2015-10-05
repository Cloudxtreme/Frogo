<?php
/*
 * Template Name: Systems - View Page
 * 
 */

get_header();
?>

<div id="primary" <?php generate_content_class(); ?>>
    <main id="main" <?php generate_main_class(); ?> itemprop="mainContentOfPage" role="main">
        <?php while (have_posts()) : the_post(); ?>

          <?php do_action('generate_before_main_content'); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemtype="http://schema.org/CreativeWork" itemscope="itemscope">
              <?php if ($post->post_parent) { ?>
                <div class="system-pages-header-parent-link">  
                    <a href="<?php echo get_permalink($post->post_parent); ?>" >
                        <?php echo get_the_title($post->post_parent); ?>
                    </a>
                </div>
              <?php } ?>

              <div class="system-pages-header">
                  <?php
                  do_action('generate_before_content');
                  if (wp_get_attachment_image(get_post_thumbnail_id(get_the_ID())) != "") {
                    ?>
                    <div class="system-pages-header-image">
                        <?php
                        echo wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()))
                        ?>
                    </div>
                    <div class="system-pages-header-content">
                        <?php
                      }
                      else {
                        ?>
                        <div class="system-pages-header-content no-image">
                            <?php
                          }
                          ?>
                          <div class="system-pages-header-content-inner">
                              <header class="entry-header">
                              <?php the_title('<h1 class="entry-title" itemprop="headline">', '</h1>'); ?>
                              </header><!-- .entry-header -->
                                  <?php do_action('generate_after_entry_header'); ?>
                              <div class="entry-content" itemprop="text">
                                  <?php the_content(); ?>
                                  <?php
                                  wp_link_pages(array(
                                    'before' => '<div class="page-links">' . __('Pages:', 'generate'),
                                    'after' => '</div>',
                                  ));
                                  ?>
                              </div><!-- .entry-content -->
                          </div>
                      </div>
                  </div>
                  <div class="inside-article system-pages">
                      <?php
                      $mypages = get_pages(array('child_of' => $post->ID, 'sort_column' => 'menu_order', 'sort_order' => 'asc'));

                      foreach ($mypages as $page) {
                        if ($page->post_parent == get_the_ID()) {
                          $feat_image = wp_get_attachment_url(get_post_thumbnail_id($page->ID));

                          $content = apply_filters('the_content', $page->post_content);
                          //$content_trim = wp_trim_words($content, 80, " ...");
                          //$content = apply_filters( 'wp_trim_excerpt', $content_trim, $content );
                          $perex = get_field('perex', $page->ID);
                          ?>
                          <h2>
                              <a href="<?php echo get_page_link($page->ID); ?>"><?php echo $page->post_title; ?></a>
                          </h2>
                          <?php
                          $youtube_id = get_field('hlavni_youtube_video', $page->ID);
                          $soubor_id = get_field('hlavni_soubor', $page->ID);
                          if ($feat_image != "" || $youtube_id[0]["youtube_video_id"] != "" || $soubor_id[0]["soubor"] != "") :
                            ?>
                            <div class="entry system-left">
                                <?php
                                if ($feat_image != ""):
                                  ?>
                                  <div class="system-image">
                                      <a href="<?php echo get_page_link($page->ID); ?>">
                                          <img src="<?= $feat_image; ?>">
                                      </a>
                                  </div>
                                  <?php
                                endif;
                                if ($youtube_id[0]["youtube_video_id"] != "" || $soubor_id[0]["soubor"] != "") :
                                  ?>
                                  <div class="system-fields">
                                      <?php
                                      while (have_rows('hlavni_youtube_video', $page->ID)) : the_row();
                                        if (get_sub_field('youtube_video_id', $page->ID)) {
                                          ?>
                                          <div class="youtube-player">
                                              <a href = "http://www.youtube.com/embed/<?= get_sub_field('youtube_video_id', $page->ID) ?>" class = "wp-colorbox-youtube" <?php
                                              if (get_sub_field('popisek_videa', $page->ID)) {
                                                echo 'title="' . get_sub_field('popisek_videa', $page->ID) . '"';
                                              }
                                              ?>>Play</a>
                                          </div>
                                          <?php
                                        }
                                      endwhile;

                                      while (have_rows('hlavni_soubor', $page->ID)) : the_row();
                                        if (get_sub_field('soubor', $page->ID)) {
                                          ?>
                                          <div class="pdf-file">
                                              <?php
                                              if (get_sub_field('jmeno_souboru')) {
                                                $download = 'download="' . get_sub_field('jmeno_souboru') . '" title="' . get_sub_field('jmeno_souboru') . '"';
                                              }
                                              else {
                                                $download = "download";
                                              }
                                              ?>
                                              <a href="<?= get_sub_field('soubor', $page->ID) ?>" <?= $download ?>>PDF</a>
                                          </div>
                                          <?php
                                        }
                                      endwhile;
                                      ?>
                                  </div>
                                  <?php
                                endif;
                                ?>
                            </div>
                            <?php
                          endif;
                          ?>
                          <div class="entry system-content"><?php if($perex != ""): echo $perex; else: echo $content; endif; ?></div>
                          <?php
                        }
                      }
                      ?>

                      <?php do_action('generate_after_content'); ?>
  <?php edit_post_link(__('Edit', 'generate'), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>'); ?>
                  </div><!-- .inside-article -->
          </article><!-- #post-## -->

          <?php
          // If comments are open or we have at least one comment, load up the comment template
          if (comments_open() || '0' != get_comments_number()) :
            ?>
            <div class="comments-area">
            <?php comments_template(); ?>
            </div>
          <?php endif; ?>

        <?php endwhile; // end of the loop.          ?>
<?php do_action('generate_after_main_content'); ?>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
do_action('generate_sidebars');
get_footer();
