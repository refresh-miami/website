<?php
bp_nouveau_member_hook( 'before', 'invites_sent_template' );

?>

<?php
$email = trim ( filter_input( INPUT_GET, 'email', FILTER_SANITIZE_STRING ) );
if ( isset( $email ) && '' !== $email ) {
	?>
	<aside class="bp-feedback bp-send-invites bp-template-notice success">
		<span class="bp-icon" aria-hidden="true"></span>
		<p>
			<?php
				$text = __( 'Invitations were sent successfully to the following email addresses:', 'buddyboss' );
				echo trim ($text.' '. $email );
			?>
		</p>
	</aside>
	<?php
}

$failed = trim ( filter_input( INPUT_GET, 'failed', FILTER_SANITIZE_STRING ) );
if ( isset( $failed ) && '' !== $failed ) {
	?>
	<aside class="bp-feedback bp-send-invites bp-template-notice error">
		<span class="bp-icon" aria-hidden="true"></span>
		<p>
			<?php
			$text = __( 'Invitations did not send because these email addresses are invalid:', 'buddyboss' );
			echo trim ($text.' '. $failed );
			?>
		</p>

	</aside>
	<?php
}

$exists = trim ( filter_input( INPUT_GET, 'exists', FILTER_SANITIZE_STRING ) );
if ( isset( $exists ) && '' !== $exists ) {
	?>
    <aside class="bp-feedback bp-send-invites bp-template-notice error">
        <span class="bp-icon" aria-hidden="true"></span>
        <p>
			<?php
			$text = __( 'Invitations did not send to the following email addresses, because they are already members:', 'buddyboss' );
			echo trim ($text.' '. $exists );
			?>
        </p>

    </aside>
	<?php
}
?>
<script>window.history.replaceState(null, null, window.location.pathname);</script>
<h2 class="screen-heading general-settings-screen">
	<?php _e( 'Invite Codes', 'buddyboss' ); ?>
</h2>


<?php

	/* check and see if screen is enabled */

	$enable_invite_codes_screen = get_field( 'enable_invite_codes_screen', 'user_' . bp_loggedin_user_id() );
	$enable_invite_codes_sharing = get_field( 'enable_invite_codes_sharing', 'user_' . bp_loggedin_user_id() );

	if ( ! empty( $enable_invite_codes_screen ) && '' !== $enable_invite_codes_screen ) : 

		$user_codes = rm_get_user_invite_codes( bp_displayed_user_id() );
		if ( empty( $user_codes ) ) {
			$user_codes = rm_assign_initial_codes( bp_displayed_user_id() );
		}

?>

<p class="info invite-info" style="color:black;">
	<?php _e( 'Each user is able to use invite codes are assigned at least two invite codes. This screen shows who has used these codes to register for Refresh Miami.', 'buddyboss' ); ?>
</p>

<?php

if ( empty( $enable_invite_codes_sharing ) || '' === $enable_invite_codes_sharing ) :

?>

<p class="info invite-info" style="color:red">
	<?php _e( 'Note that ability to share new valid invite codes has been disabled for your account. You still may view past results below.', 'buddyboss' ); ?>
</p>

<?php endif; ?>

<?php

	foreach ( $user_codes as $user_invite_code ) { 

		if ( $user_invite_code->visible === 'hidden' ) {
			continue;
		}
		
		
?>

<h4 class="">
	<?php _e( 'Code <strong style="color:green;">' . $user_invite_code->code . '</strong>', 'buddyboss' ); ?>
	<br/><small>Created <?php echo date( 'F j, Y g:i a', strtotime( $user_invite_code->created ) ); ?></small>
	<?php
		if ( rm_is_invite_code_allow_create_group( $user_invite_code->code ) ) :
	?>
	<br/><small>This code allows those invited to create a group.</small>
	<?php 
		endif;
	?>
</h4>

<?php

		if ( intval( $user_invite_code->times_used ) === 0 ) {

?>

		<p class="info invite-info">
			<?php _e( 'This code has not been used yet.', 'buddyboss' ); ?>
		</p>

		<?php } else { ?>

		<p class="info invite-info">
			<?php _e( 'The following are members that have registered with this code <strong style="color:green;">' . $user_invite_code->code . '</strong>:', 'buddyboss' ); ?>
		</p>

		<?php

			// get the actual registers

			// print_r ($user_invite_code);

			$used_invites = rm_get_user_used_invites( bp_displayed_user_id(), $user_invite_code->id );

		?>

		<table class="invite-settings bp-tables-user" id="<?php echo esc_attr( 'member-invite-codes-table' ); ?>">
			<thead>
			<tr>
				<th class="title"><?php esc_html_e( 'Username', 'buddyboss' ); ?></th>
				<th class="title"><?php esc_html_e( 'Name', 'buddyboss' ); ?></th>
				<th class="title"><?php esc_html_e( 'Registered', 'buddyboss' ); ?></th>
			</tr>
			</thead>

			<tbody>

			<?php
			// $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			// $sent_invites_pagination_count = apply_filters( 'sent_invites_pagination_count', 25 );
			// $args = array(
			// 	'posts_per_page' => $sent_invites_pagination_count,
			// 	'post_type'      => bp_get_invite_post_type(),
			// 	'author'         => bp_loggedin_user_id(),
			// 	'paged'          => $paged,
			// );
			// $the_query = new WP_Query( $args );

			if ( $used_invites ) {

				foreach ( $used_invites as $used_invite ) {

					// print_r( $used_invite );

					$invited_user = get_user_by( 'id', $used_invite->registered_user_id );

					$display_name = bp_xprofile_get_member_display_name( $used_invite->registered_user_id );

					?>
					<tr>
						<td class="field-name">
							<span><?php echo bp_core_get_userlink( $used_invite->registered_user_id ); ?></span>
						</td>
						<td class="field-email">
							<span><?php echo $display_name; ?></span>
						</td>
						<td class="field-email">
							<span>
								<?php echo date( 'F j, Y g:i a', strtotime( $used_invite->created ) ); ?>
							</span>
						</td>
						<?php /* <td class="field-email">
							<?php

							$allow_custom_registration = bp_allow_custom_registration();
							if ( $allow_custom_registration && '' !== bp_custom_register_page_url() ) {
								$class       = ( '1' === get_post_meta( get_the_ID(), '_bp_invitee_status', true ) ) ? 'registered' : 'invited';
								$revoke_link = '';
								$title       = ( '1' === get_post_meta( get_the_ID(), '_bp_invitee_status', true ) ) ? __( 'Registered', 'buddyboss' ) : __( 'Invited', 'buddyboss' );
							} else {
								$class       = ( '1' === get_post_meta( get_the_ID(), '_bp_invitee_status', true ) ) ? 'registered' : 'revoked-access';
								$revoke_link = bp_core_get_user_domain( bp_loggedin_user_id() ) . bp_get_invites_slug() . '/revoke-invite';
								$title       = ( '1' === get_post_meta( get_the_ID(), '_bp_invitee_status', true ) ) ? __( 'Registered', 'buddyboss' ) : __( 'Revoke Invite', 'buddyboss' );
							}
							$alert_message = ( '1' === get_post_meta( get_the_ID(), '_bp_invitee_status', true ) ) ? __( 'Registered', 'buddyboss' ) : __( 'Are you sure you want to revoke this invitation?', 'buddyboss' );
							$icon          = ( '1' === get_post_meta( get_the_ID(), '_bp_invitee_status', true ) ) ? 'dashicons-yes' : 'dashicons-dismiss';

							if ( $allow_custom_registration && '' !== bp_custom_register_page_url() ) {
								?>
								<span class="bp-invitee-status">
									<span class="dashicons <?php echo esc_attr( $icon ); ?>"></span>
									<?php echo $title; ?>
								</span>
							<?php
							} else {

								if ( 'registered' === $class ) {
									?>
									<span class="bp-invitee-status">
										<span class="dashicons <?php echo esc_attr( $icon ); ?>"></span><?php echo $title; ?>
									</span>
									<?php
								} else {
									?>
									<span class="bp-invitee-status">
										<a data-revoke-access="<?php echo esc_url( $revoke_link ); ?>"
										data-name="<?php echo esc_attr( $alert_message ); ?>"
										id="<?php echo esc_attr( get_the_ID() ); ?>"
										class="<?php echo esc_attr( $class ); ?>"
										href="javascript:void(0);">
											<span class="dashicons <?php echo esc_attr( $icon ); ?>"></span><?php echo $title; ?>
										</a>
									</span>
									<?php
								}
							}
							?>
						</td> */ ?>
					</tr>
					<?php
				}

			} else {
				?>
				<tr>
					<td colspan="4" class="field-name">
						<span><?php esc_html_e( 'You haven\'t sent any invitations yet.', 'buddyboss' ); ?></span>
					</td>
				</tr>
				<?php
			}

			// $total_pages = $the_query->max_num_pages;

			// if ( $total_pages > 1 ){

			// 	$current_page = max(1, get_query_var('paged'));

			// 	echo paginate_links(array(
			// 		'base' => get_pagenum_link(1) . '%_%',
			// 		'format' => '?paged=%#%',
			// 		'current' => $current_page,
			// 		'total' => $total_pages,
			// 		'prev_text'    => __('« Prev', 'buddyboss'),
			// 		'next_text'    => __('Next »', 'buddyboss'),
			// 	));
			// }

			// wp_reset_postdata();
			?>

			</tbody>
		</table>

		<?php

		}  // if empty

		echo '<hr/>';

	} // end foreach

?>

<?php else : ?>

	<p class="info invite-info">
		<?php _e( 'You currently do not have the ability to use invite codes.', 'buddyboss' ); ?>
	</p>

<?php endif; ?>

<?php
bp_nouveau_member_hook( 'after', 'invites_sent_template' );
