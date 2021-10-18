<?php
/*
 * Template name: Register
 * @package BuddyBoss_Theme
 */

get_header('register');
?>

    <div id="primary" class="content-area no-gutter bs-bp-container">
        <main id="main" class="register-main">

			<div class="register-left">

                <?php //print_r ($_POST['gform_target_page_number_8']); ?>

                <div class="step-icon" id="step-icon">                   
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/register/icon_people.png" />
                </div>
                <div class="step-text" id="step-text">    

                    <?php echo rm_output_onboarding_slide( 1 ); ?>
            
                </div>
                <?php /* <div class="step-dots">
                        <img src="<?php echo rm_register_dots(); ?>" />
                </div> */ ?>

                <?php /* <div style="max-width: 50%;"><?php print_r ($_POST); ?></div> */ ?>
            </div>
            <div class="register-right">

                <div class="interior">

                <?php if ( have_posts() ) :

                    do_action( THEME_HOOK_PREFIX . '_template_parts_content_top' );

                    while ( have_posts() ) :
                        the_post();

                        do_action( THEME_HOOK_PREFIX . '_single_template_part_content', 'page' );

                    endwhile; // End of the loop.
                else :
                    get_template_part( 'template-parts/content', 'none' );
                    ?>

                <?php endif; ?>

                </div>

            </div>


        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
