<?php
/**
 * BuddyBoss - Members Profile Loop
 *
 * @since BuddyPress 3.0.0
 * @version 3.1.0
 */

$edit_profile_link = trailingslashit( bp_displayed_user_domain() . bp_get_profile_slug() . '/edit' );

$title        = esc_html( xprofile_get_field_data( 'Title' ) );
$personal_url = ( xprofile_get_field_data( 'Personal Website' ) );
$location     = xprofile_get_field_data( 'Location' );
$bio          = xprofile_get_field_data( 'Bio' );
$first_name   = xprofile_get_field_data( 'First Name' );

$company_title    = xprofile_get_field_data( 'Company', bp_displayed_user_id() );
$company_link     = esc_html( xprofile_get_field_data( 'Company Website', bp_displayed_user_id() ) );
$company_position = xprofile_get_field_data( 'Role/Title', bp_displayed_user_id() );

// echo bp_displayed_user_id();
// echo $company_title;
// echo $company_link;
// echo $company_position;

$social = xprofile_get_field_data( 'Social Profiles' );
$community_help = xprofile_get_field_data( 'How can the community help you?' );

$social_twitter   = ! empty( $social[2] ) ? esc_url( $social[2] ) : false;
$social_facebook  = ! empty( $social[1] ) ? esc_url( $social[1] ) : false;
$social_instagram = ! empty( $social[3] ) ? esc_url( $social[3] ) : false;
$social_linkedin  = ! empty( $social[0] ) ? esc_url( $social[0] ) : false;
$social_profiles  = ( $social_facebook || $social_instagram || $social_twitter || $social_linkedin ) ? true : false;

$interests     = rm_get_user_interests( bp_displayed_user_id(), 'array' );
$interest_html = false;
if ( ! empty( $interests ) ) {
	foreach ( $interests as $interest ) {
		$interest_html .= $interest;
	}
}

$roles_html = rm_get_user_interests_field( bp_displayed_user_id(), 'Roles', 'string' );
$expertise_html = rm_get_user_interests_field( bp_displayed_user_id(), 'Expertise/Professional Interests', 'string' );
$interests_html = rm_get_user_interests_field( bp_displayed_user_id(), 'Personal Interests', 'string' );

// $meetups = rm_bp_get_joined_meetups( bp_displayed_user_id() );

$looking_for_work = xprofile_get_field_data( 'Looking For Work' );
$work_relocation  = xprofile_get_field_data( 'Open To Relocation' );
$work_remote      = xprofile_get_field_data( 'Open To Remote Work' );

$suggested_user_ids = bp_friends_suggestions_pro_get_suggested_user_ids( bp_displayed_user_id(), 138, 5 ); // 5 = limit

// echo '-'; print_r( $suggested_user_ids );

?>



<?php bp_nouveau_xprofile_hook( 'before', 'loop_content' ); ?>

<?php if ( bp_has_profile() ) : ?>

	<div class="bb-grid site-content-grid">

		<div id="primary" class="content-area bs-bp-container">
			<main id="main" class="site-main">
				<div class="bp-profile-content">
					<h1 class="entry-title">About <?php echo $first_name; ?></h1>
					<article class="bio-long-description">
						<?php echo wpautop( $bio ); ?>
					</article>
					<?php

						/* work experience */
						$experience = rm_get_work_experience_from_user( bp_displayed_user_id() );

						// print_r( $experience );

						if ( ! empty( $experience ) ) :


					?>
					<h2 style="margin-top: 30px;">Work Experience</h2>
					<article class="bio-long-description">
						<ul class="timeline-list work-list">
						<?php
							foreach ( $experience as $item ) {
						?>
							<li>
								<?php

								?>
								<?php if ( $item['bprms_pos'] ) { ?>
									<h4><?php echo esc_html( $item['bprms_pos'][0] ); ?></h4>
								<?php } ?>
								<div class="media-body">
									<?php if ( $item['bprms_empoy'] ) { ?>
										<h5><a href="#"><?php echo esc_html( $item['bprms_empoy'][0] ); ?></a></h5>
									<?php } ?>
									<ul class="list-unstyled education-bullets">

										<?php if ( ! empty( $item['bprms_posfrom'][0] ) && ! empty( $item['bprms_posto'][0] ) && intval( $item['bprms_posfrom'][0] ) === intval( $item['bprms_posto'][0] ) ) { ?>
											<li><?php echo esc_html( $item['bprms_posfrom'][0] ); ?></li>
										<?php } else if ( $item['bprms_posfrom'][0] && $item['bprms_posto'] ) { ?>
											<li><?php echo esc_html( $item['bprms_start'][0] ); ?>-<?php echo esc_html( $item['bprms_posto'][0] ); ?></li>
										<?php } else if ( $item['bprms_posfrom'][0] ) { ?>
											<li><?php echo esc_html( $item['bprms_posfrom'][0] ); ?>-</li>
										<?php } else if ( $item['bprms_yoc'][0] ) { ?>
											<li>??? -<?php echo esc_html( $item['bprms_posto'][0] ); ?></li>
										<?php } ?>

										<?php if ( $item['bprms_work_place'][0] ) { ?>
											<li><?php echo esc_html( $item['bprms_work_place'][0] ); ?></li>
										<?php } ?>
										<?php if ( $item['bprms_poswork'][0] ) { ?>
											<li><?php echo esc_html( $item['bprms_poswork'][0] ); ?></li>
										<?php } ?>
									</ul>
								</div>
							</li>
						<?php } ?>
					</article>
					<?php endif; ?>
					<?php

						/* work experience */
						$education = rm_get_education_from_user( bp_displayed_user_id() );

						if ( ! empty( $education ) ) :


					?>
					<h2 style="margin-top: 30px;">Education</h2>
					<article class="bio-long-description">
						<ul class="timeline-list education-list">
						<?php
							foreach ( $education as $item ) {

								// print_r ($item); exit;
						?>
							<li>
								<span class="icon">House</span>
								<div class="media-body">
								<?php if ( $item['bprms_degree'] ) { ?>
									<h4><?php echo esc_html( $item['bprms_degree'][0] ); ?></h4>
								<?php } ?>
									<ul class="list-unstyled education-bullets">
										<?php if ( $item['bprms_inst'] ) { ?>
											<li><?php echo esc_html( $item['bprms_inst'][0] ); ?></li>
										<?php } ?>
										<?php if ( intval( $item['bprms_start'][0] ) === intval( $item['bprms_yoc'][0] ) ) { ?>
											<li><?php echo esc_html( $item['bprms_start'][0] ); ?></li>
										<?php } else if ( $item['bprms_start'][0] && $item['bprms_yoc'] ) { ?>
											<li><?php echo esc_html( $item['bprms_start'][0] ); ?>-<?php echo esc_html( $item['bprms_yoc'][0] ); ?></li>
										<?php } else if ( $item['bprms_start'][0] ) { ?>
											<li><?php echo esc_html( $item['bprms_start'][0] ); ?>-</li>
										<?php } else if ( $item['bprms_yoc'][0] ) { ?>
											<li>??? -<?php echo esc_html( $item['bprms_yoc'][0] ); ?></li>
										<?php } ?>
										<?php if ( $item['bprms_inst_place'][0] ) { ?>
											<li><?php echo esc_html( $item['bprms_inst_place'][0] ); ?></li>
										<?php } ?>
									</ul>
								</div>
							</li>
							<?php } ?>
						</ul>
					</article>
					<?php endif; ?>

					<?php /* <h2>Portfolio</h2>
					<article>
						<ul class="media-list item-list bp-list bb-photo-list grid">
							<li class="lg-grid-1-5 md-grid-1-3 sm-grid-1-3" data-id="1" data-date-created="2020-08-13 14:32:22">
								<div class="bb-photo-thumb">
									<a class="bb-open-media-theatre bb-photo-cover-wrap" data-id="1" data-attachment-full="http://refresh.miami/wp-content/uploads/2020/08/neonbrand-y_6rqStQBYQ-unsplash-scaled.jpg" data-activity-id="3" data-privacy="public" data-parent-activity-id="3" data-album-id="0" data-group-id="0" data-attachment-id="47" href="#">
									<img src="http://refresh.miami/wp-content/uploads/2020/08/neonbrand-y_6rqStQBYQ-unsplash-400x267.jpg" alt="neonbrand-y_6rqStQBYQ-unsplash" class="">
									</a>
								</div>
							</li>
							<li class="lg-grid-1-5 md-grid-1-3 sm-grid-1-3" data-id="1" data-date-created="2020-08-13 14:32:22">
								<div class="bb-photo-thumb">
									<a class="bb-open-media-theatre bb-photo-cover-wrap" data-id="1" data-attachment-full="http://refresh.miami/wp-content/uploads/2020/08/neonbrand-y_6rqStQBYQ-unsplash-scaled.jpg" data-activity-id="3" data-privacy="public" data-parent-activity-id="3" data-album-id="0" data-group-id="0" data-attachment-id="47" href="#">
									<img src="http://refresh.miami/wp-content/uploads/2020/08/neonbrand-y_6rqStQBYQ-unsplash-400x267.jpg" alt="neonbrand-y_6rqStQBYQ-unsplash" class="">
									</a>
								</div>
							</li>
							<li class="lg-grid-1-5 md-grid-1-3 sm-grid-1-3" data-id="1" data-date-created="2020-08-13 14:32:22">
								<div class="bb-photo-thumb">
									<a class="bb-open-media-theatre bb-photo-cover-wrap" data-id="1" data-attachment-full="http://refresh.miami/wp-content/uploads/2020/08/neonbrand-y_6rqStQBYQ-unsplash-scaled.jpg" data-activity-id="3" data-privacy="public" data-parent-activity-id="3" data-album-id="0" data-group-id="0" data-attachment-id="47" href="#">
									<img src="http://refresh.miami/wp-content/uploads/2020/08/neonbrand-y_6rqStQBYQ-unsplash-400x267.jpg" alt="neonbrand-y_6rqStQBYQ-unsplash" class="">
									</a>
								</div>
							</li>
						</ul>
					</article> */ ?>
				</div>
			</main>
		</div>
		<div id="secondary" class="widget-area sm-grid-1-1 sidebar-right">
			<div class="bb-sticky-sidebar">
				<?php if( bp_is_my_profile() ) { ?>
				<header class="flex align-items-center edit-my-profile">
					<?php /* <h1 class="entry-title bb-profile-title"><?php esc_attr_e( 'View Profile', 'buddyboss-theme' ); ?></h1> */ ?>
						<a href="<?php echo $edit_profile_link; ?>" class="push-right button outline small"><?php esc_attr_e( 'Edit My Profile', 'buddyboss-theme' ); ?></a>
				</header>
				<?php if ( is_active_sidebar( 'custom-side-bar' ) ) : ?>
					<?php dynamic_sidebar( 'custom-side-bar' ); ?>
				<?php endif; ?>
				<?php } ?>
				<?php if ( strtolower( $looking_for_work ) !== 'no' && ( $title || $location || $personal_url ) ) { ?>
				<aside id="boss-recent-posts-2" class="widsget bb_widget_recent_posts main_bio">
					<?php if ( $title || $location || $personal_url ) { ?>
						<ul class="bb-recent-posts">
							<?php if ( $title ) { ?>
							<li><h3><?php echo $title; ?></h3></li>
							<?php } ?>
							<?php if ( $location ) { ?>
							<li><?php echo $location; ?></li>
							<?php } ?>
							<?php if ( $personal_url ) { ?>
							<li><small><?php echo $personal_url; ?></small></li>
							<?php } ?>
						</ul>
					<?php } ?>
					<?php if ( strtolower( $looking_for_work ) === 'yes' ) { ?>
					<?php
						if ( $looking_for_work || $work_relocation || $work_remote ) {
							$willing = array();
							if ( $work_remote ) {
								$willing[] = 'Remote';
							}
							if ( $work_relocation ) {
								$willing[] = 'Willing To Relocate';
							}
							$text = implode( ', ', $willing );
							if ( !empty( $text ) ) {
								$text = '('.$text.')';
							}

							print_r( $looking_for_work );
							echo '-';
							print_r( $work_relocation );
							echo '-';
							print_r( $work_remote );
							echo '-';

					?>
					<div class="looking-work"><i class="bb-icon-check"></i> Looking For Work
					<?php if ( $text ) { ?><br/><small><?php echo $text; ?></small><?php } ?></div>
					<?php } ?>
					<?php } ?>
				</aside>
				<?php } ?>
				<?php

				// echo '----';
				// echo $company_position;

if ( ! empty( $company_position ) ) :

	?>
	<aside id="boss-recent-posts-2" class="widget bb_widget_recent_posts business_connections">
		<h2 class="widget-title">Current Positions:</h2>
			<ul class="bb-recent-posts">
					<li>
						<div class="">
							<?php if ( $company_title ) { ?>
								<h4>
									<?php if ( $company_link ) { ?>
									<a href="<?php echo $company_link; ?>" class="bb-title">
									<?php } ?>
									<?php echo $company_title; ?>
									<?php if ( $company_link ) { ?>
									</a>
									<?php } ?>
								</h4>
							<?php } ?>
							<?php if ( $company_position ) { ?>
								<em><?php echo $company_position; ?></em>
							<?php } ?>
						</div>
					</li>
			</ul>
	</aside>
			<?php endif;

						/* current positions */

						$positions = rm_get_positions_from_user( bp_displayed_user_id() );

						if ( ! empty( $positions ) ) :

				?>
				<aside id="boss-recent-posts-2" class="widget bb_widget_recent_posts business_connections">
					<h2 class="widget-title">Current Positions:</h2>
						<ul class="bb-recent-posts">
						<?php
							foreach ( $positions as $item ) {

								$image_attributes = array();
								if ( $item['1600284175'][0] ) {
									$image_attributes = wp_get_attachment_image_src( $item['1600284175'][0] );
								}

								if ( ! empty( $image_attributes[0] ) ) {
									$image_url = esc_url( $image_attributes[0] );
								}

						?>
								<li>
									<?php if ( $image_url ) { ?>
									<a href="#" title="" class="entry-media entry-img-x">
										<img src="<?php echo $image_url; ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy" width="45" height="45">
									</a>
									<?php } ?>
									<div class="">
										<?php if ( $item['1600284140'][0] ) { ?>
											<small><?php echo esc_html( $item['1600284140'][0] ); ?>:</small>
										<?php } ?>
										<?php if ( $item['1600284162'][0] ) { ?>
											<h4><a href="https://refresh.miami/hello-world/" class="bb-title"><?php echo $item['1600284162'][0]; ?></a></h4>
										<?php } ?>
										<?php if ( $item['1600284214'][0] ) { ?>
											<small>(<?php echo $item['1600284214'][0]; ?>)</small>
										<?php } ?>
									</div>
								</li>
							<?php } ?>
						</ul>
				</aside>
						<?php endif; ?>
				<?php if ( ! empty( $roles_html ) ) : ?>
				<aside class="widget bb_widget_recent_posts">
					<h2 class="widget-title">Roles:</h2>
					<div>
						<ul class="skills-list tag-list tags">
							<?php echo $roles_html; ?>
						</ul>
					</div>
				</aside>
				<?php endif; ?>
				<?php if ( ! empty( $expertise_html ) ) : ?>
				<aside class="widget bb_widget_recent_posts">
					<h2 class="widget-title">Expertise:</h2>
					<div>
						<ul class="skills-list tag-list tags">
							<?php echo $expertise_html; ?>
						</ul>
					</div>
				</aside>
				<?php endif; ?>
				<?php if ( ! empty( $community_help ) ) : ?>
				<aside class="widget bb_widget_recent_posts">
					<?php if( $first_name ) { ?>
						<h2 class="widget-title">What <?php echo $first_name; ?> Is Looking For:</h2>
					<?php } else { ?>
						<h2 class="widget-title">What I'm Looking For:</h2>
					<?php } ?>
					<div>
						<ul class="skills-list tag-list tags">
							<?php
									$looking_for = implode( ', ' , $community_help );
							?>
							<?php echo $looking_for; ?>
						</ul>
					</div>
				</aside>
				<?php endif; ?>
				<?php if ( ! empty( $interests_html ) ) : ?>
				<aside class="widget bb_widget_recent_posts">
					<h2 class="widget-title">Interests:</h2>
					<div>
						<ul class="skills-list tag-list tags">
							<?php echo $interests_html; ?>
						</ul>
					</div>
				</aside>
				<?php endif; ?>
				<?php
					if ( $social_profiles ) :
				?>
				<aside id="boss-recent-posts-2" class="widget bb_widget_recent_posts social_profiles">
					<h2 class="widget-title">Social Profiles:</h2>
						<ul class="bb-recent-posts">
							<?php if ( $social_linkedin ) : ?>
							<li>
								<a href="<?php echo $social_linkedin; ?>" title="LinkedIn" class="entry-media entry-img-x">
									<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/social/linkedin.png" class="" alt="" loading="lazy" width="35" height="35">
								</a>
								<div class="">
									<h4><a href="<?php echo $social_linkedin; ?>" class="bb-title">LinkedIn</a></h4>
									<small><a href="<?php echo $social_linkedin; ?>" target="_blank"><?php echo $social_linkedin; ?></a></small>
								</div>
							</li>
							<?php endif; ?>
							<?php if ( $social_twitter ) : ?>
								<li>
								<a href="<?php echo $social_twitter; ?>" title="Twitter" class="entry-media entry-img-x">
									<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/social/twitter.png" class="" alt="" loading="lazy" width="35" height="35">
								</a>
								<div class="">
									<h4><a href="<?php echo $social_twitter; ?>" class="bb-title">Twitter</a></h4>
									<small><a href="<?php echo $social_twitter; ?>" target="_blank"><?php echo $social_twitter; ?></a></small>
								</div>
							</li>
							<?php endif; ?>
							<?php if ( $social_facebook ) : ?>
								<li>
								<a href="<?php echo $social_facebook; ?>" title="Facebook" class="entry-media entry-img-x">
									<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/social/facebook.png" class="" alt="" loading="lazy" width="35" height="35">
								</a>
								<div class="">
									<h4><a href="<?php echo $social_facebook; ?>" class="bb-title">Facebook</a></h4>
									<small><a href="<?php echo $social_facebook; ?>" target="_blank"><?php echo $social_facebook; ?></a></small>
								</div>
							</li>
							<?php endif; ?>
							<?php if ( $social_instagram ) : ?>
								<li>
								<a href="<?php echo $social_instagram; ?>" title="Instagram" class="entry-media entry-img-x">
									<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/social/instagram.png" class="" alt="" loading="lazy" width="35" height="35">
								</a>
								<div class="">
									<h4><a href="<?php echo $social_instagram; ?>" class="bb-title">Instagram</a></h4>
									<small><a href="<?php echo $social_instagram; ?>" target="_blank"><?php echo $social_instagram; ?></a></small>
								</div>
							</li>
							<?php endif; ?>
						</ul>
				</aside>
				<?php endif; ?>
				<?php
					/* if ( !empty( $meetups ) ) :
				?>
				<aside id="boss-recent-posts-2" class="widget bb_widget_recent_posts social_profiles">
					<h2 class="widget-title">Meetups:</h2>
						<ul class="bb-recent-posts">
							<?php
								foreach ( $meetups as $meetup ) {

									$location = get_meetup_location( $meetup->id );

									?>
								<li>
									<a href="<?php echo $permalink ?>" title="<?php echo esc_html( $meetup->name ); ?>" class="entry-media entry-img-x">
										<img src="https://refresh.miami/wp-content/uploads/group-avatars/9/5f398b4931ce5-bpfull.jpg" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy" width="35" height="35">
									</a>
									<div class="">
										<h4><a href="<?php echo $permalink ?>" class="bb-title"><?php echo esc_html( $meetup->name ); ?></a></h4>
										<?php if ( $location ) { ?>
										<small>(<?php echo $location ; ?>)</small>
										<?php } ?>
									</div>
								</li>
							<?php } ?>
						</ul>
				</aside>
				<?php
					endif; */
				?>
				<?php /*
				<aside id="boss-recent-posts-2" class="widget bb_widget_recent_posts">
					<h2 class="widget-title">David Has Shared:</h2>
						<ul class="bb-recent-posts">
								<li>
									<a href="https://refresh.miami/hello-world/" title="Permalink to Hello world!" class="entry-media entry-img">
										<img src="https://refresh.miami/wp-content/uploads/2020/08/roman-mager-5mZ_M06Fc9g-unsplash-624x468.jpg" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy" srcset="https://refresh.miami/wp-content/uploads/2020/08/roman-mager-5mZ_M06Fc9g-unsplash-624x468.jpg 624w, https://refresh.miami/wp-content/uploads/2020/08/roman-mager-5mZ_M06Fc9g-unsplash-300x225.jpg 300w, https://refresh.miami/wp-content/uploads/2020/08/roman-mager-5mZ_M06Fc9g-unsplash-1024x768.jpg 1024w, https://refresh.miami/wp-content/uploads/2020/08/roman-mager-5mZ_M06Fc9g-unsplash-768x576.jpg 768w, https://refresh.miami/wp-content/uploads/2020/08/roman-mager-5mZ_M06Fc9g-unsplash-1536x1152.jpg 1536w, https://refresh.miami/wp-content/uploads/2020/08/roman-mager-5mZ_M06Fc9g-unsplash-2048x1536.jpg 2048w" sizes="(max-width: 624px) 100vw, 624px" width="624" height="468">
									</a>
									<div class="">
										<h4><a href="https://refresh.miami/hello-world/" class="bb-title">How Miami Benfits From WordPress</a></h4>
										<small>www.davidbisset.com</small>
									</div>
								</li>
						</ul>
				</aside> */ ?>
				<?php
					if ( ! empty( $suggested_user_ids ) )  { ?>
				<aside id="boss-recent-posts-2" class="widget bb_widget_recent_posts social_profiles">
					<h2 class="widget-title">People Also Viewed:</h2>
						<ul class="bb-recent-posts">
							<?php

								$args = array (
									'type' => 'active',
									'include' => $suggested_user_ids
								);

								$users = bp_core_get_users( $args );

							// print_r ($users);

							foreach ( $users['users'] as $user ) { ?>
							<li>
								<a href="<?php echo bp_core_get_user_domain( $user->ID ); ?>" title="<?php echo rm_get_user_full_name( $user->ID ); ?>" class="entry-media entry-img-x">
									<?php //bp_activity_avatar(array('user_id' => $user->ID)); ?>
									<img src="<?php echo rm_get_user_avatar( $user->ID, $user, 35, 35 ); ?>?>" class="" alt="" loading="lazy" width="35" height="35">
								</a>
								<div class="">
									<h4><a href="<?php echo bp_core_get_user_domain( $user->ID ); ?>" class="bb-title"><?php echo rm_get_user_full_name( $user->ID ); ?></a></h4>
									<small><?php echo rm_get_user_generic_title( $user->ID ); ?></small>
								</div>
							</li>
							<?php } ?>
						</ul>
				</aside>
				<?php } ?>
			</div>
		</div>

</div>

	<?php /*

	<?php
	while ( bp_profile_groups() ) :
		bp_the_profile_group();
	?>

		<?php if ( bp_profile_group_has_fields() ) : ?>

			<?php bp_nouveau_xprofile_hook( 'before', 'field_content' ); ?>

			<div class="bp-widget <?php bp_the_profile_group_slug(); ?>">

				<h3 class="screen-heading profile-group-title">
					<?php bp_the_profile_group_name(); ?>
				</h3>

				<table class="profile-fields bp-tables-user">

					<?php
					while ( bp_profile_fields() ) :
						bp_the_profile_field();


						// Get the current display settings from BuddyBoss > Settings > Profiles > Display Name Format.
						$current_value = bp_get_option( 'bp-display-name-format' );

						// If First Name selected then do not add last name field.
						if ( 'first_name' === $current_value && bp_get_the_profile_field_id() === bp_xprofile_lastname_field_id() ) {
							if ( function_exists( 'bp_hide_last_name') && false === bp_hide_last_name() ) {
								continue;
							}
							// If Nick Name selected then do not add first & last name field.
						} elseif ( 'nickname' === $current_value && bp_get_the_profile_field_id() === bp_xprofile_lastname_field_id() ) {
							if ( function_exists( 'bp_hide_nickname_last_name') && false === bp_hide_nickname_last_name() ) {
								continue;
							}
						} elseif ( 'nickname' === $current_value && bp_get_the_profile_field_id() === bp_xprofile_firstname_field_id() ) {
							if ( function_exists( 'bp_hide_nickname_first_name') && false === bp_hide_nickname_first_name() ) {
								continue;
							}
						}

						if ( function_exists('bp_member_type_enable_disable' ) && false === bp_member_type_enable_disable() ) {
							if ( function_exists( 'bp_get_xprofile_member_type_field_id') && bp_get_the_profile_field_id() === bp_get_xprofile_member_type_field_id() ) {
								continue;
							}
						}

					    ?>

                        <?php bp_nouveau_xprofile_hook( 'before', 'field_item' ); ?>

						<?php if ( bp_field_has_data() ) : ?>

							<tr<?php bp_field_css_class(); ?>>

								<td class="label"><?php bp_the_profile_field_name(); ?></td>

								<td class="data"><?php bp_the_profile_field_value(); ?></td>

							</tr>

						<?php endif; ?>

						<?php bp_nouveau_xprofile_hook( '', 'field_item' ); ?>

					<?php endwhile; ?>

                    <?php bp_nouveau_xprofile_hook( 'after', 'field_items' ); ?>

				</table>
			</div>

			<?php bp_nouveau_xprofile_hook( 'after', 'field_content' ); ?>

		<?php endif; ?>

	<?php endwhile; ?>

	<?php bp_nouveau_xprofile_hook( '', 'field_buttons' ); ?>

	<?php */ ?>

<?php else: ?>

	<div class="info bp-feedback">
		<span class="bp-icon" aria-hidden="true"></span>
		<p>
			<?php
			if ( bp_is_my_profile() ) {
				esc_html_e( 'You have not yet added details to your profile.', 'buddyboss-theme' );
			} else {
				esc_html_e( 'This member has not yet added details to their profile.', 'buddyboss-theme' );
			}
			?>
		</p>
	</div>

<?php endif; ?>

<?php
// bp_nouveau_xprofile_hook( 'after', 'loop_content' );
