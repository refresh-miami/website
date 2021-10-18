<?php
/**
 * BP Nouveau Search & filters bar
 *
 * @since BuddyPress 3.0.0
 * @version 3.1.0
 */
?>

<?php

// echo bp_current_component();

global $post;
// print_r ($post);

?>

<div class="subnav-filters filters no-ajax" id="subnav-filters">

	<?php if ( 'friends' !== bp_current_component() ) : ?>

        <?php if ( 'members' !== bp_current_component() || bp_disable_advanced_profile_search() ) : ?>
            <div class="subnav-search clearfix">

            <?php if ( isset( $post->post_name ) && $post->post_name === 'companies' ) : ?>

                <?php bp_nouveau_search_form(); ?>

            <?php else: ?>

                <?php bp_nouveau_search_form(); ?>

            <?php endif; ?>

            </div>
        <?php endif; ?>

	<?php endif; ?>

    <?php if ( ( 'members' === bp_current_component() || 'groups' === bp_current_component() || 'friends' === bp_current_component() ) && ! bp_is_current_action( 'requests' ) && $post->post_name !== 'companies' ): ?>
        <?php bp_get_template_part( 'common/filters/grid-filters' ); ?>
    <?php endif; ?>

	<?php if ( bp_is_user() && ( ! bp_is_current_action( 'requests' ) && ! bp_is_current_action( 'mutual' ) ) ): ?>
		<?php bp_get_template_part( 'common/filters/directory-filters' ); ?>
	<?php endif; ?>

    <?php if ( 'members' === bp_current_component() || ( 'friends' === bp_current_component() && 'my-friends' === bp_current_action() ) ): ?>
        <?php bp_get_template_part( 'common/filters/member-filters' ); ?>
    <?php endif; ?>

	<?php if ( 'groups' === bp_current_component() && $post->post_name !== 'companies' ): ?>
		<?php bp_get_template_part( 'common/filters/group-filters' ); ?>
	<?php endif; ?>

    <?php if ( $post->post_name === 'companies' && rm_does_user_have_company_access( bp_loggedin_user_id() ) ) { ?>
    <div style="float: right;">
        <a href="<?php echo home_url('create-company'); ?>" class="button">Create A Company</a>
    </div>
    <?php } ?>

</div><!-- search & filters -->
