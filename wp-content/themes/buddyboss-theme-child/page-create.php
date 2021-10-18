<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BuddyBoss_Theme
 */

get_header();

$atts = array (
    'type' => 'meetup'
)
?>

<!-- test -->

    <div id="primary" class="content-area bb-grid-cell">
        <main id="main" class="site-main">

            <article id="post-0" class="post-0 page type-page status-publish hentry">

            <header class="entry-header">
                <h1 class="entry-title">Create A Meetup</h1>            		
            </header>

            <?php // bp_group_type_short_code_callback( $atts ); ?>

                <div id="buddypress" class="buddypress-wrap bp-dir-hori-nav">

                    <div class="entry-content">

                        <?php gravity_form( 4, false, false, false ); ?>
		              
                    </div>

                </div>
                    
            </article>

        </main><!-- #main -->
    </div><!-- #primary -->


<?php
get_footer();
