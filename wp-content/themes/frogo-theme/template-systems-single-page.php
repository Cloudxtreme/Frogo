<?php
/*
 * Template Name: Systems - Single page
 * 
 */

get_header();
?>

<div id="primary" <?php generate_content_class(); ?>>
    <main id="main" <?php generate_main_class(); ?> itemprop="mainContentOfPage" role="main">
        <?php while (have_posts()) : the_post(); ?>

          <?php do_action('generate_before_main_content'); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemtype="http://schema.org/CreativeWork" itemscope="itemscope">
              <div class="system-pages-header-top-parent-link">
                  <?php
                  $parent = array_reverse(get_post_ancestors($post->ID));
                  $first_parent = get_page($parent[0]);
                  ?>
                  <a href="<?php echo get_permalink($first_parent->ID); ?>" >
                      <?php echo get_the_title($first_parent->ID); ?>
                  </a>
              </div>  
              <?php if ($post->post_parent) { ?>
                <div class="system-pages-header-parent-link">  
                    <a href="<?php echo get_permalink($post->post_parent); ?>" >
                        <?php echo get_the_title($post->post_parent); ?>
                    </a>
                </div>
              <?php } ?>

              <div class="inside-article system-pages">
                  <?php do_action('generate_before_content'); ?>
                  <header class="entry-header">
                      <?php the_title('<h1 class="entry-title" itemprop="headline">', '</h1>'); ?>
                  </header><!-- .entry-header -->
                  <?php do_action('generate_after_entry_header'); ?>
                  <div class="entry-content" itemprop="text">
                      <?php
                      $youtube_id = get_field('hlavni_youtube_video');
                      $soubor_id = get_field('hlavni_soubor');
                      if (wp_get_attachment_image_src(get_post_thumbnail_id($post->ID)) > 0 || $youtube_id[0]["youtube_video_id"] != "" || $soubor_id[0]["soubor"] != "") :
                        ?>
                        <div class="entry system-single-page">
                            <?php
                            if (wp_get_attachment_image_src(get_post_thumbnail_id($post->ID)) > 0) :
                              ?>
                              <div class="system-page-image">
                                  <?php
                                  $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
                                  echo '<a href="' . $image_url[0] . '" class="colorbox">' . wp_get_attachment_image(get_post_thumbnail_id(get_the_ID())) . '</a>';
                                  ?>
                              </div>
                              <?php
                            endif;

                            if ($youtube_id[0]["youtube_video_id"] != "" || $soubor_id[0]["soubor"] != "") :
                              ?>
                              <div class="system-fields">
                                  <?php
                                  while (have_rows('hlavni_youtube_video')) : the_row();
                                    if (get_sub_field('youtube_video_id')) {
                                      ?>
                                      <div class="youtube-player">
                                          <a href = "http://www.youtube.com/embed/<?= get_sub_field('youtube_video_id') ?>" class = "wp-colorbox-youtube" <?php
                                          if (get_sub_field('popisek_videa')) {
                                            echo 'title="' . get_sub_field('popisek_videa') . '"';
                                          }
                                          ?>>Play</a>
                                      </div>
                                      <?php
                                    }
                                  endwhile;

                                  while (have_rows('hlavni_soubor')) : the_row();
                                    if (get_sub_field('soubor')) {
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
                                          <a href="<?= get_sub_field('soubor') ?>" <?= $download ?>>PDF</a>
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
                      the_content();
                      ?>
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
                          if (have_rows('sub_soubory')) {
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
                                    while (have_rows('sub_soubory')) : the_row();
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
                                    ?>
                                </tbody>
                            </table>
                            <?php
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
                  <?php
                  $table_head = "";
                  $table_head_arr = array();
                  $table_body = "";
                  $table_body_arr = array();
                  $table_arr_fields = array(
                    'popisek_radku',
                    'hloubka_jamy',
                    'hloubka_jamy_s-system',
                    'hloubka_jamy_d-system',
                    'hloubka_jamy_vpredu',
                    'hloubka_jamy_vzadu',
                    'hloubka_jamy_s-system-2',
                    'hloubka_jamy_d-system-2',
                    'svetla_vyska',
                    'vyska_pilire',
                    'vyska_auta_v_parkovaci_jame',
                    'vyska_auta_-_vespodu',
                    'vyska_auta_-_na_vjezdu',
                    'vyska_auta_-_stredni',
                    'vyska_auta_-_prostredni_1',
                    'vyska_auta_-_prostredni_2',
                    'vyska_auta_-_v_jame',
                    'vyska_auta_-_na_vjezdu',
                    'vyska_auta_-_navrchu',
                    'sirka_parkovaciho_stani',
                    'delka_parkovaciho_stani'
                  );

                  $table_arr_fields_titles = array(
                    '',
                    'Hloubka jámy',
                    'Hloubka jámy S-systém',
                    'Hloubka jámy D-systém',
                    'Hloubka jámy vpředu',
                    'Hloubka jámy vzadu',
                    'Hloubka jámy S-systém',
                    'Hloubka jámy D-systém',
                    'Světlá výška',
                    'Výška pilíře',
                    'Výška auta v parkovací jámě',
                    'Výška auta - vespodu',
                    'Výška auta - na vjezdu',
                    'Výška auta - střední',
                    'Výška auta - prostřední 1',
                    'Výška auta - prostřední 2',
                    'Výška auta - v jámě',
                    'Výška auta - na vjezdu',
                    'Výška auta - navrchu',
                    'Šířka parkovacího stání',
                    'Délka parkovacího stání'
                  );
                  if(get_locale() == "en_US"):
                  $table_arr_fields_titles = array(
                    '',
                    'Pit depth',
                    'Pit depth single',
                    'Pit depth double',
                    'Pit depth front',
                    'Pit depth rear',
                    'Pit depth S-installation',
                    'Pit depth D-installation',
                    'Clear height',
                    'Column height',
                    'Car height pit level',
                    'Car height bottom level',
                    'Car height entrance level',
                    'Car height middle level',
                    'Car height middle 1 level',
                    'Car height middle 2 level',
                    'Car height in the pit',
                    'Car height in the entrance',
                    'Car height upper level',
                    'Width of space',
                    'Length of space'
                  );
                  endif;
                  // Check not empty fields & add titles
                  while (have_rows('tabulka_parametru')) : the_row();
                    foreach ($table_arr_fields as $key => $value) {
                      if (get_sub_field($value)):
                        $table_body_arr[$key] = true;
                        $table_head_arr[$key] = $table_arr_fields_titles[$key];
                      elseif ($table_body_arr[$key] == true):
                        $table_body_arr[$key] = true;
                        $table_head_arr[$key] = $table_arr_fields_titles[$key];
                      else:
                        $table_body_arr[$key] = false;
                        $table_head_arr[$key] = false;
                      endif;
                    }
                  endwhile;

                  // Add titles to table HEAD
                  foreach ($table_head_arr as $key => $value) {
                    if ($table_body_arr[$key] == true):
                      $table_head .= "<th>" . $table_head_arr[$key] . "</th>";
                    endif;
                  }

                  // Creating TABLE BODY
                  while (have_rows('tabulka_parametru')) : the_row();
                    $table_body .= "<tr>";
                    foreach ($table_arr_fields as $key => $value) {
                      if ($table_body_arr[$key] == true):
                        $table_body .= "<td>" . get_sub_field($value) . "</td>";
                      endif;
                    }
                    $table_body .= "</tr>";
                  endwhile;

                  // Print ALL
                  if ($table_head != ""):
                    print "<table border='0' class='product-detail-table'><tr>" . $table_head . "</tr>" . $table_body . "</table>";
                  endif;
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

        <?php endwhile; // end of the loop.             ?>
        <?php do_action('generate_after_main_content'); ?>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
do_action('generate_sidebars');
get_footer();
