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

                  <div class="sub-filds">
                      <div class="sub-filds-files">
                          <?php
                          if (have_rows('kategorie')) {
                            while (have_rows('kategorie')) : the_row();
                              if (get_sub_field('jmeno_kategorie')) {
                                echo '<h3>' . get_sub_field('jmeno_kategorie') . '</h3>';
                              }
                              ?>
                              <table width="100%" border="0">
                                  <tbody>
                                      <tr>
                                          <th class="name">
                                              <?php
                                              _e("Name")
                                              ?>
                                          </th>
                                          <th class="type">
                                              <?php
                                              _e("Type")
                                              ?>
                                          </th>
                                          <th class="size">
                                              <?php
                                              _e("Size")
                                              ?>
                                          </th>
                                          <th class="download">
                                              <?php
                                              _e("Download")
                                              ?>
                                          </th>
                                      </tr>
                                      <?php
                                      if (have_rows('soubory')) {
                                        while (have_rows('soubory')) : the_row();
                                          if (get_sub_field('soubor')) {
                                            $file = get_sub_field('soubor');
                                            ?>
                                            <tr>
                                                <td class="name">
                                                    <?php
                                                    if (get_sub_field('jmeno_souboru')) {
                                                      echo get_sub_field('jmeno_souboru');
                                                    }
                                                    else {
                                                      echo $file["title"];
                                                    }
                                                    ?>
                                                </td>
                                                <td class="type">
                                                    <?php
                                                    $type = explode("/", $file["mime_type"]);
                                                    echo $type[1];
                                                    echo mime_content_type($file["mime_type"]);
                                                    ?>
                                                </td>
                                                <td class="size">
                                                    <?php
                                                    echo size_format(filesize(get_attached_file($file["id"])), 2);
                                                    ?>
                                                </td>
                                                <td class="download">
                                                    <?php
                                                    if (get_sub_field('jmeno_souboru')) {
                                                      $download = 'download="' . get_sub_field('jmeno_souboru') . '" title="' . get_sub_field('jmeno_souboru') . '"';
                                                    }
                                                    else {
                                                      $download = "download";
                                                    }
                                                    ?>
                                                    <a href="<?= $file["url"] ?>" <?= $download ?>><?php _e("Download") ?></a>
                                                </td>
                                            </tr>
                                            <?php
                                          }
                                        endwhile;
                                      }
                                      ?>
                                  </tbody>
                              </table>
                              <?php
                            endwhile;
                          }
                          ?>
                      </div>
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

        <?php endwhile; // end of the loop.  ?>
        <?php do_action('generate_after_main_content'); ?>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
do_action('generate_sidebars');
get_footer();
