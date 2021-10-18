<?php
/**
 * BuddyPress Single Groups Admin Navigation
 *
 * @since BuddyPress 3.0.0
 * @version 3.0.0
 */
?>

<nav class="<?php bp_nouveau_single_item_subnav_classes(); ?>" id="subnav" role="navigation" aria-label="<?php esc_attr_e( 'Group administration menu', 'buddyboss' ); ?>">

	<?php if ( bp_nouveau_has_nav( array( 'object' => 'group_manage' ) ) ) : ?>

		<ul class="subnav">

			<?php
			while ( bp_nouveau_nav_items() ) :
				bp_nouveau_nav_item();
				
				// echo bp_nouveau_get_nav_id();
                
                if (  esc_attr( bp_nouveau_get_nav_id() ) == 'about-groups-li' || 'meetup-groups-li' == esc_attr( bp_nouveau_get_nav_id() ) ) {
                    continue;
                }
			?>
			<?php 

			if (  esc_attr( bp_nouveau_get_nav_id() ) == 'edit-details-groups-li' ) {

				$about_link = str_replace( 'edit-details', 'about', bp_nouveau_get_nav_link() );

	
			?>
				<li id="about-groups-li" class="bp-groups-admin-tab">
					<a href="<?php echo $about_link; ?>" id="about">Details</a>
				</li>
			<?php } else { ?>
				<li id="<?php bp_nouveau_nav_id(); ?>" class="<?php bp_nouveau_nav_classes(); ?>">
					<a href="<?php bp_nouveau_nav_link(); ?>" id="<?php bp_nouveau_nav_link_id(); ?>">
						<?php bp_nouveau_nav_link_text(); ?>
						<?php if ( bp_nouveau_nav_has_count() ) : ?>
							<span class="count"><?php bp_nouveau_nav_count(); ?></span>
						<?php endif; ?>
					</a>
				</li>
			<?php } ?>

			<?php endwhile; ?>

		</ul>

	<?php endif; ?>

</nav><!-- #isubnav -->
