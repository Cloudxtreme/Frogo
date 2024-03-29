<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <main id="main">
 *
 * @package GeneratePress
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <?php if (!function_exists('_wp_render_title_tag')) : ?>
          <title><?php wp_title('|', true, 'right'); ?></title>
        <?php endif; ?>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <?php wp_head(); ?>
        <script src="<?= get_site_url() ?>/wp-content/plugins/wp-colorbox/jquery.colorbox.js"></script>
        <script type="text/javascript">
          /* <![CDATA[ */
          var seznam_retargeting_id = 32815;
          /* ]]> */
        </script>
        <script type="text/javascript" src="//c.imedia.cz/js/retargeting.js"></script>
    </head>

    <body itemtype="http://schema.org/WebPage" itemscope="itemscope" <?php body_class(); ?>>
        <?php do_action('generate_before_header'); ?>
        <header itemtype="http://schema.org/WPHeader" itemscope="itemscope" id="masthead" role="banner" <?php generate_header_class(); ?>>
            <div <?php generate_inside_header_class(); ?>>
                <?php do_action('generate_before_header_content'); ?>
                <?php generate_header_items(); ?>
                <?php do_action('generate_after_header_content'); ?>
            </div><!-- .inside-header -->
        </header><!-- #masthead -->
        <?php do_action('generate_after_header'); ?>

        <div id="page" class="hfeed site grid-container container grid-parent">
            <div id="content" class="site-content">
                <?php do_action('generate_inside_container'); ?>