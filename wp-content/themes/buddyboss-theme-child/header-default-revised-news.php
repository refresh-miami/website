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

				$css_class = false;

				if ( ! bp_is_user_profile() && bp_current_component() !== 'invites' && bp_current_component() !== 'forums' ) :



				$css_class = 'with-masthead';

				$title       = ! empty( $post->post_title ) ? $post->post_title : false;
				$description = false;

				$queried_object  = get_queried_object();
				if ( is_archive() ) {
					if ( $queried_object->name === 'tribe_events') {
						$title = 'Community Events';
					} else if ( is_day() ) {
						$date = get_query_var( 'day' );
						$title = 'Archive for ' . date( 'F jS, Y', strtotime( $date ) );
					} else if ( is_month() ) {
						$date = get_query_var( 'month' ) . single_month_title( ' ', false );
						$title = 'Archive for ' . date( 'F, Y', strtotime( $date ) );
					} else if ( is_year() ) {
						$date = get_query_var( 'year' );
						$title = 'Archive for ' . $date;
					} else if ( is_category() ) {
						$title = 'Archive for ' . $queried_object->name;
					} else {
						$title = ( isset( $queried_object->name ) ) ? $queried_object->name : $title;
					}
				} else {
					$title = ( isset( $queried_object->label ) ) ? $queried_object->label : $title;
				}
				// $title = $queried_object->label;
				// print_r ($queried_object);
				// echo '123'; exit;
				// if ( ( isset( $queried_object->taxonomy ) && $queried_object->taxonomy === 'post_tag' )
				// 	|| ( isset( $queried_object->taxonomy ) && $queried_object->taxonomy === 'category' ) ) {
				// 			// print_r( $queried_object );
				// 			// exit;
				// 			$title       = $queried_object->name;
				// 			$description = $queried_object->description;
				// 	}
				// $current_term_id = $queried_object->term_id;



			?>

<?php

$sponsor_logo = get_field('sponsor_logo', 'option');
$sponsor_banner_text = get_field('sponsor_banner_text', 'option');
$sponsor_link = esc_url( get_field('sponsor_link', 'option') );


?>

            <div class="wide-blue masthead">
                <!-- <div class="container"> -->
                    <div class="interior">
					<h1>Miami Tech & Startup News</h1>
						<?php if ( current_user_can('administrator') && ! empty( $sponsor_link ) ) : ?>
						<div class="sponsor-area news header">
							<?php if ( $sponsor_banner_text ) : ?>
							<p><?php echo $sponsor_banner_text; ?></p>
							<?php endif; ?>
							<?php //print_r ($sponsor_logo); ?>
							<div><a target="_blank" href="<?php echo $sponsor_link; ?>"><img src="<?php echo $sponsor_logo['sizes']['medium']; ?>" /></a></div>
						</div>
						<?php endif; ?>
                    </div>
                <!-- </div> -->
			</div>

			<?php endif; ?>

			<div id="content" class="site-content <?php echo $css_class; ?>">

				<?php do_action( THEME_HOOK_PREFIX . 'begin_content' ); ?>

				<div class="container">



					<div class="<?php echo apply_filters( 'buddyboss_site_content_grid_class', 'bb-grid site-content-grid' ); ?>">