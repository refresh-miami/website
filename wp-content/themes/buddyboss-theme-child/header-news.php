<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BuddyBoss_Theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

        <?php wp_body_open(); ?>

		<?php if (!is_singular('llms_my_certificate')):

			do_action( THEME_HOOK_PREFIX . 'before_page' );

		endif; ?>

		<div id="page" class="site">

			<?php do_action( THEME_HOOK_PREFIX . 'before_header' ); ?>

			<header id="masthead" class="<?php echo apply_filters( 'buddyboss_site_header_class', 'site-header site-header--bb' ); ?>">
				<?php do_action( THEME_HOOK_PREFIX . 'header' ); ?>
			</header>

			<?php do_action( THEME_HOOK_PREFIX . 'after_header' ); ?>

			<?php do_action( THEME_HOOK_PREFIX . 'before_content' ); ?>

			<?php


				$title       = ! empty( $post->post_title ) ? $post->post_title : false;
				$description = false;

				$queried_object  = get_queried_object();
				// print_r ($queried_object); exit;
				if ( ( isset( $queried_object->taxonomy ) && $queried_object->taxonomy === 'post_tag' )
					|| ( isset( $queried_object->taxonomy ) && $queried_object->taxonomy === 'category' ) ) {
							// print_r( $queried_object );
							// exit;
							$title       = $queried_object->name;
							$description = $queried_object->description;
					}
				$current_term_id = $queried_object->term_id;

			?>

			<?php

				$sponsor_logo = get_field('sponsor_logo', 'option');
				$sponsor_banner_text = get_field('sponsor_banner_text', 'option');
				$sponsor_link = esc_url( get_field('sponsor_link', 'option') );


			?>

            <div class="wide-blue masthead">
                <!-- <div class="container"> -->
                    <div class="interior">
						<?php if ( ! empty( $title ) ) : ?>
						<h1><?php echo esc_html( $title ); ?></h1>
						<?php endif; ?>
						<?php if ( ! empty( $description ) ) : ?>
						<h3><?php echo esc_html( $description ); ?></h3>
						<?php endif; ?>
						<?php if ( current_user_can('administrator') && ! empty( $sponsor_link ) ) : ?>
						<div class="sponsor-area news header">
							<?php if ( $sponsor_banner_text ) : ?>
							<p><?php echo $sponsor_banner_text; ?></p>
							<?php endif; ?>
							<?php //print_r ($sponsor_logo); ?>
							<div><a target="_blank" href="<?php echo $sponsor_link; ?>"><img src="<?php echo $sponsor_logo['sizes']['medium']; ?>" /></a></div>
						</div>
						<?php endif;?>
                    </div>
                <!-- </div> -->
			</div>

			<?php

				$trending_tags = rm_get_featured_tags( 'name', false, array( 'trending' ) );

				if ( ! empty( $trending_tags ) ) :

					$add_news_url = get_field('add_news_url', 'option');

			?>

			<div class="wide white">
   				<div class="container">
					<div class="rm-search-trending-topics">
                        <ul>
						   <li><label class="">Trending Topics:</label></li>
						   <?php foreach ( $trending_tags['trending'] as $tag_id => $tag_info ) : ?>
                            	<li><a href="<?php echo $tag_info['link']; ?>"><?php echo $tag_info['name']; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
					   </div>
					   <?php /* <div class="rm-add-news">
							<a class="but button" href="<?php echo $add_news_url; ?>"> + Submit News</a>
						</div> */ ?>
				</div>
			</div>

			<?php endif; ?>

			<div id="content" class="site-content with-masthead">

				<?php do_action( THEME_HOOK_PREFIX . 'begin_content' ); ?>

