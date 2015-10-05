<?php
/*
 * Template Name: Systems - Main Page
 * 
 */

get_header();
?>

<div id="primary" <?php generate_content_class(); ?>>
    <main id="main" <?php generate_main_class(); ?> itemprop="mainContentOfPage" role="main">
        <?php while (have_posts()) : the_post(); ?>

          <?php do_action('generate_before_main_content'); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemtype="http://schema.org/CreativeWork" itemscope="itemscope">
              <div class="inside-article system-pages">
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
                  <?php
                  $mypages = get_pages(array('child_of' => $post->ID, 'sort_column' => 'menu_order', 'sort_order' => 'asc'));

                  foreach ($mypages as $page) {
                    if ($page->post_parent == get_the_ID()) {
                      $feat_image = wp_get_attachment_url(get_post_thumbnail_id($page->ID));
                      $content = $page->post_content;
                      $content = apply_filters('the_content', $content);
                      $perex = get_field('perex', $page->ID);
                      ?>
                      <h2>
                          <a href="<?php echo get_page_link($page->ID); ?>"><?php echo $page->post_title; ?></a>
                      </h2>
                      <?php
                      if ($feat_image != ""):
                        ?>
                        <div class="entry system-image">
                            <a href="<?php echo get_page_link($page->ID); ?>">
                                <img src="<?= $feat_image; ?>">
                            </a>
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

        <?php endwhile; // end of the loop.     ?>
        <?php do_action('generate_after_main_content'); ?>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
do_action('generate_sidebars');
get_footer();
