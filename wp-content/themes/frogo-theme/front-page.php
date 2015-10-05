<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package GeneratePress
 */
get_header();
?>

<div id="primary" <?php generate_content_class(); ?>>
    <main id="main" <?php generate_main_class(); ?> itemprop="mainContentOfPage" role="main">
        <?php do_action('generate_before_main_content'); ?>
        <?php while (have_posts()) : the_post(); ?>

          <?php
          if (have_rows('hlaska_nad_obsahem')) {
            ?>
            <div class="main-banner">
                <div class="main-banner-inner">
                    <?php
                    while (have_rows('hlaska_nad_obsahem')) : the_row();
                      if (get_sub_field('obrazek')) {
                        $image = get_sub_field('obrazek');
                        echo "<div class='main-banner-image'>";
                        echo '<img src="' . $image["url"] . '">';
                        echo "</div>";
                      }
                      if (get_sub_field('text')) {
                        echo "<div class='main-banner-text'>";
                        echo get_sub_field('text');
                        echo "</div>";
                      }
                    endwhile;
                    ?>
                </div>
            </div>
            <?php
          }
          ?>
          <?php
          // Posts on Home page
          if (get_category('40')->category_count > 0) {
            ?>
            <div class="our-projects">
                <div class="our-projects-inner">
                    <?php
                    echo "<h3>" . __("Our projects") . "</h3>";
                    $args = array('posts_per_page' => 3, 'orderby' => 'modified', 'order' => 'DESC', 'category' => 40);
                    $countion = 1;
                    $postslist = get_posts($args);
                    foreach ($postslist as $post) :
                      setup_postdata($post);
                      ?> 
                      <div class="our-project our-project-<?= $countion ?>">
                          <div class="our-project-inner">
                              <div class="our-project-image">
                                  <a href="<?= $post->guid ?>">
                                      <?php echo get_the_post_thumbnail($post->ID, 'thumbnail'); ?>
                                  </a>
                              </div>
                              <div class="our-project-content">
                                  <a href="<?= $post->guid ?>" class="our-project-title">
                                      <?php the_title(); ?>
                                  </a>
                                  <?php
                                  $content = the_excerpt();
                                  $content = apply_filters('the_content', $content);
                                  $content = wp_trim_words($content, 10, " ...");
                                  echo $content;
                                  ?>
                              </div>
                              <div class="clear"></div>
                              <div class="our-project-date">
                                  <?php
                                  $date = date_create($post->post_modified);
                                  echo __('Modified') . ": " . date_format($date, 'd. m. Y');
                                  ?>
                              </div>
                              <div class="our-project-more">
                                  <a href="<?= $post->guid ?>">
                                      <?= _e('Show more') . " ..." ?>
                                  </a>
                              </div>
                          </div>
                      </div>
                      <?php
                      $countion++;
                    endforeach;
                    wp_reset_postdata();
                    echo '<div class="archive-post-link">';
                    echo '<a href="' . get_category_link(36) . '">' . __('All our projects') . '</a>';
                    echo '</div>';
                    ?>
                </div>
            </div>
            <?php
          }
          ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemtype="http://schema.org/CreativeWork" itemscope="itemscope">
              <div class="inside-article home">
                  <?php do_action('generate_before_content'); ?>
                  <header class="entry-header">
                      <?php the_title('<h1 class="entry-title hidden" itemprop="headline">', '</h1>'); ?>
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

        <?php endwhile; // end of the loop. ?>
        <?php do_action('generate_after_main_content'); ?>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
do_action('generate_sidebars');
get_footer();
