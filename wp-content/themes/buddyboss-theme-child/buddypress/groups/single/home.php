<?php
/**
 * BuddyBoss - Groups Home
 *
 * @since BuddyPress 3.0.0
 * @version 3.0.0
 */

$bp_nouveau_appearance = bp_get_option('bp_nouveau_appearance');
$group_cover_width = buddyboss_theme_get_option( 'buddyboss_group_cover_width' );

$group_type = bp_groups_get_group_type( bp_get_current_group_id() );

if ( bp_has_groups() ) :
	while ( bp_groups() ) :
		bp_the_group();


	?>

		<?php bp_nouveau_group_hook( 'before', 'home_content' ); ?>

		<div id="item-header" role="complementary" data-bp-item-id="<?php bp_group_id(); ?>" data-bp-item-component="groups" class="groups-header single-headers">

			<?php bp_nouveau_group_header_template_part(); ?>

		</div><!-- #item-header -->

		<?php

			if ( 'company' == $group_type ) {
				$approved = groups_get_groupmeta( bp_get_current_group_id(), 'rm_admin_approved');
				if ( $approved == 'not-approved' ) { ?>
			<aside class="bp-feedback bp-messages bp-template-notice warning">
				<span class="bp-icon" aria-hidden="true"></span>
				<p><strong>Your company is under review</strong>. It is not visible in the company directory or to the general public until it is approved by Refresh Miami. In the meantime, please <a href="#">update your logo</a>, <a href="#">invite members</a> so you can add them as employees, and make sure your <a href="#">company information</a> is up to date. Thank you!</p>
			</aside>
			<?php }

			}?>

		<?php if ( ( isset($bp_nouveau_appearance['group_nav_display']) && $bp_nouveau_appearance['group_nav_display'] ) && is_active_sidebar( 'group' ) && $group_cover_width != 'default' ) { ?>
			<div class="bb-grid bb-user-nav-display-wrap">
				<div class="bp-wrap-outer">
		<?php } ?>

		<div class="bp-wrap">

			<?php if ( ! bp_nouveau_is_object_nav_in_sidebar() ) : ?>

				<?php bp_get_template_part( 'groups/single/parts/item-nav' ); ?>

            <?php endif; ?>

			<div class="bb-profile-grid bb-grid">
				<div id="item-body" class="item-body">
                    <?php /* if the user is attempting to view discussions/forums without being logged in and a member of the group, display a mesage */ ?>
                    <?php if ( bp_current_component() === 'groups' && bp_current_action() === 'forum' && ( false === groups_is_user_member( bp_loggedin_user_id(), bp_get_current_group_id() ) ) ) { ?>
                        <div>
                            <p class="warning">You must be logged in and a member of this group to view the discussions.</p>
                        </div>
                    <?php } else { ?>
                    <?php bp_nouveau_group_template_part(); ?>
                    <?php } ?>
				</div>

				<?php if ( ( !isset($bp_nouveau_appearance['group_nav_display']) || !$bp_nouveau_appearance['group_nav_display'] ) && is_active_sidebar( 'group_activity' ) && bp_is_group_activity() ) { ?>
					<div id="group-activity" class="widget-area sm-grid-1-1" role="complementary">
						<div class="bb-sticky-sidebar">
							<?php dynamic_sidebar( 'group_activity' ); ?>
						</div>
					</div>
				<?php } ?>

				<?php if ( ( !isset($bp_nouveau_appearance['group_nav_display']) || !$bp_nouveau_appearance['group_nav_display'] ) && is_active_sidebar( 'group' ) && $group_cover_width == 'full' ) { ?>
					<div id="secondary" class="widget-area sm-grid-1-1 no-padding-top" role="complementary">
						<div class="bb-sticky-sidebar">
							<?php dynamic_sidebar( 'group' ); ?>
						</div>
					</div>
				<?php } ?>
			</div>

		</div><!-- // .bp-wrap -->

		<?php if ( ( isset($bp_nouveau_appearance['group_nav_display']) && $bp_nouveau_appearance['group_nav_display'] ) && is_active_sidebar( 'group' ) && $group_cover_width != 'default' ) { ?>
				</div>
				<div id="secondary" class="widget-area sm-grid-1-1 no-padding-top" role="complementary">
					<div class="bb-sticky-sidebar">
						<?php dynamic_sidebar( 'group' ); ?>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php bp_nouveau_group_hook( 'after', 'home_content' ); ?>

	<?php endwhile; ?>

<?php
endif;
