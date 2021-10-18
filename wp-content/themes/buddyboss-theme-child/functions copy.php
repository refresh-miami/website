<?php
/**
 * @package BuddyBoss Child
 * The parent theme functions are located at /buddyboss-theme/inc/theme/functions.php
 * Add your own functions at the bottom of this file.
 */


/****************************** THEME SETUP ******************************/

/**
 * Sets up theme for translation
 *
 * @since BuddyBoss Child 1.0.0
 */
function buddyboss_theme_child_languages()
{
  /**
   * Makes child theme available for translation.
   * Translations can be added into the /languages/ directory.
   */

  // Translate text from the PARENT theme.
  load_theme_textdomain( 'buddyboss-theme', get_stylesheet_directory() . '/languages' );

  // Translate text from the CHILD theme only.
  // Change 'buddyboss-theme' instances in all child theme files to 'buddyboss-theme-child'.
  // load_theme_textdomain( 'buddyboss-theme-child', get_stylesheet_directory() . '/languages' );

}
add_action( 'after_setup_theme', 'buddyboss_theme_child_languages' );

/**
 * Enqueues scripts and styles for child theme front-end.
 *
 * @since Boss Child Theme  1.0.0
 */
function buddyboss_theme_child_scripts_styles()
{
  /**
   * Scripts and Styles loaded by the parent theme can be unloaded if needed
   * using wp_deregister_script or wp_deregister_style.
   *
   * See the WordPress Codex for more information about those functions:
   * http://codex.wordpress.org/Function_Reference/wp_deregister_script
   * http://codex.wordpress.org/Function_Reference/wp_deregister_style
   **/

  // Styles
  wp_enqueue_style( 'buddyboss-child-css', get_stylesheet_directory_uri().'/assets/css/custom.css', '', time() );

  // Javascript
  wp_enqueue_script( 'buddyboss-child-js', get_stylesheet_directory_uri().'/assets/js/custom.js', '', '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'buddyboss_theme_child_scripts_styles', 9999 );


/****************************** CUSTOM FUNCTIONS ******************************/

// Add your own custom functions here.

add_action('wp', 'rm_check_rsp_free_access');
function rm_check_rsp_free_access() {

	global $post;

	// print_R( $post );
	// exit;

	$restricted_urls = array ( 'post-a-job' );

	if ( ! empty( $post ) && in_array( $post->post_name, $restricted_urls ) ) {

		$customer = rcp_get_customer_by_user_id( bp_loggedin_user_id() );
		if ( empty( $customer ) ) {
			return $retval; // Or otherwise exit out of your code.
		}
		// Once you have the customer object, you can get the customers memberships.
		$memberships = $customer->get_memberships();

		/*
		* $memberships will be an array. For now it will only have a maximum of one item in it,
		* but this may change in the future so plan your code accordingly.
		*/

		foreach ( $memberships as $membership ) {
			// $membership will be an RCP_Membership object. You can use it accordingly. Example:
			$status = $membership->get_status();
			$membership_level_id = $membership->get_object_id();
		}

		// print_r( $membership_level_id );
		// echo 'test';

		if ( ! is_user_logged_in() || ! $membership_level_id || intval( $membership_level_id ) === 1 ) { // free membership
		// if ( ! current_user_can( 'administrator' ) ) {
			wp_safe_redirect( home_url('upgrade') );
			exit;
		// }
		}

	}

	// echo bp_current_component() . '-----';
	// echo bp_current_action() . '-----';

}

// return (bool) apply_filters( 'bbp_current_user_can_access_create_reply_form', (bool) $retval );

add_filter( 'bbp_current_user_can_access_create_reply_form', 'rm_bbp_current_user_can_access_create_reply_form', 10, 1 );
add_filter( 'bbp_current_user_can_access_create_topic_form', 'rm_bbp_current_user_can_access_create_reply_form', 10, 1 );
function rm_bbp_current_user_can_access_create_reply_form( $retval ) {
	$customer = rcp_get_customer_by_user_id( bp_loggedin_user_id() );
	if ( empty( $customer ) ) {
		return $retval; // Or otherwise exit out of your code.
	}
	// Once you have the customer object, you can get the customers memberships.
	$memberships = $customer->get_memberships();

	/*
	* $memberships will be an array. For now it will only have a maximum of one item in it,
	* but this may change in the future so plan your code accordingly.
	*/

	foreach ( $memberships as $membership ) {
		// $membership will be an RCP_Membership object. You can use it accordingly. Example:
		$status = $membership->get_status();
		$membership_level_id = $membership->get_object_id();
	}

	if ( empty( $membership_level_id ) || intval( $membership_level_id ) === 1 ) { // free membership
		return 0;
	}

	return $retval;
	// echo 'level:';
	// print_r( $membership_level_id );
	// exit;
}

/* admin bar and backend admin */

if( current_user_can('editor') || current_user_can('administrator') ) {

} else {
	add_filter( 'show_admin_bar', '__return_false', 9999 );
}

function rm_no_admin_access()
{
    if (
        // Don't do this for AJAX calls
        ! defined( 'DOING_AJAX' )
        // Capability check
        && ! current_user_can( 'delete_posts' )
        )
    {
        // Redirect to home/front page
        wp_redirect( site_url( '/' ) );
        // Never ever(!) forget to exit(); or die(); after a redirect
        exit;
    }
}
add_action( 'admin_init', 'rm_no_admin_access' );

/* ----- */

/**
 * Get group directory navigation menu items.
 *
 * @since BuddyPress 3.0.0
 */
function bp_rm_get_groups_directory_nav_items() {
	$nav_items = array();

	$nav_items['all'] = array(
		'component' => 'groups',
		'slug'      => 'all', // slug is used because BP_Core_Nav requires it, but it's the scope
		'li_class'  => array( 'selected' ),
		'link'      => bp_get_groups_directory_permalink(),
		'text'      => __( 'All Groups', 'buddyboss' ),
		'count'     => bp_get_total_group_count(),
		'position'  => 5,
	);

	if ( is_user_logged_in() ) {

		$my_groups_count = bp_get_total_group_count_for_user( bp_loggedin_user_id() );

		// If the user has groups create a nav item
		if ( $my_groups_count ) {
			$nav_items['personal'] = array(
				'component' => 'groups',
				'slug'      => 'personal', // slug is used because BP_Core_Nav requires it, but it's the scope
				'li_class'  => array(),
				'link'      => bp_loggedin_user_domain() . bp_get_groups_slug() . '/my-groups/',
				'text'      => __( 'My Groups', 'buddyboss' ),
				'count'     => $my_groups_count,
				'position'  => 15,
			);
		}

		/* only an admin user or someone with specific permissions can create a group */

		if ( current_user_can('administrator') || current_user_can('create_groups') ) :

			// If the user can create groups, add the create nav
			if ( bp_user_can_create_groups() ) {
				$nav_items['create'] = array(
					'component' => 'groups',
					'slug'      => 'create', // slug is used because BP_Core_Nav requires it, but it's the scope
					'li_class'  => array( 'no-ajax', 'group-create', 'create-button' ),
					'link'      => trailingslashit( bp_get_groups_directory_permalink() . 'create' ),
					'text'      => __( 'Create a Group', 'buddyboss' ),
					'count'     => false,
					'position'  => 999,
				);
			}

		endif;
	}

	// Check for the deprecated hook :
	$extra_nav_items = bp_nouveau_parse_hooked_dir_nav( 'bp_groups_directory_group_filter', 'groups', 20 );

	if ( ! empty( $extra_nav_items ) ) {
		$nav_items = array_merge( $nav_items, $extra_nav_items );
	}

	/**
	 * Use this filter to introduce your custom nav items for the groups directory.
	 *
	 * @since BuddyPress 3.0.0
	 *
	 * @param  array $nav_items The list of the groups directory nav items.
	 */
	return apply_filters( 'bp_nouveau_get_groups_directory_nav_items', $nav_items );
}

add_filter( 'bp_get_active_member_types', 'rm_bp_get_active_member_types', 10, 1 );
function rm_bp_get_active_member_types( $member_types ) {
	foreach ( $member_types as $key => $member_type ) {
		// remove admin if this person isn't an admin.
		if ( $member_type === 125178 && ( ! is_user_logged_in() || ! current_user_can('administrator') ) ) {
			unset( $member_types[$key] );
		}
	}
	return $member_types;
}


/* homepage */

function homepage_widgets_init() {

	register_sidebar( array(
		'name'           => 'Home right sidebar',
		'id'			 => 'home_right_1',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h2 class="widget-title">',
		'after_title'	 => '</h2>'
	) );

	register_sidebar( array(
		'name'           => 'Home middle sidebar',
		'id'			 => 'home_right_2',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h2 class="widget-title">',
		'after_title'	 => '</h2>'
	) );

}

add_action( 'widgets_init', 'homepage_widgets_init' );

function homepage_get_events( $limit = 10 ) {

	$args = array(
		'post_type' => 'tribe_events',
		'orderby' => 'date',
		'order' => 'DESC',
		'posts_per_page' => $limit
		 );
	$query = new WP_Query( $args );

	return $query->posts;

}

function homepage_get_featured_events( $limit = 1 ) {

	$args = array(
		'post_type' => 'tribe_events',
		'orderby' => 'date',
		'order' => 'DESC',
		'meta_key'   => 'rm_featured',
		'meta_compare' => 'LIKE',
		'meta_value' => '"homepage"', // stored as custom post type, therefore it's serialized. example: a:1:{i:0;s:8:"homepage";}
		'posts_per_page' => $limit
		 );
	$query = new WP_Query( $args );

	return $query->posts;

}

/* share buttons */

add_filter( 'shared_counts_display_output', 'rm_shared_counts_display_output', 10, 2 );
function rm_shared_counts_display_output( $html, $location ) {

	global $post;

	if ( empty( $post ) || $post->post_type !== 'post' ) {
		return false;
	}

	if ( ! empty( $post ) && $post->post_status !== 'publish' ) {
		return false;
	}

	return $html;

}

add_filter( 'shared_counts_link', 'rm_shared_counts_link', 10, 3 );
function rm_shared_counts_link( $link, $id, $style ) {
	$link['class'] = str_replace( 'no-scroll', 'rm-no-scroll', $link['class'] );
	return $link;
}

/* restrict access */

add_action('wp', 'rm_check_group_access');
function rm_check_group_access() {
	// if the user is NOT an admin and trying to access groups, kick them back to the homepage.
	// exception: company directory/pages are ok

	if ( 'groups' !== bp_current_component() ) {
		return;
	}

	// echo bp_groups_get_group_type( bp_get_current_group_id() );

	if ( bp_get_current_group_id() && 'company' !== bp_groups_get_group_type( bp_get_current_group_id() ) ) {
		// ok you are on a group page now
		if ( ! current_user_can( 'administrator' ) ) {
			wp_safe_redirect( home_url() );
			exit;
		}
	}

	// echo bp_current_component() . '-----';
	// echo bp_current_action() . '-----';

}

add_action('wp', 'rm_check_member_directory_access');
function rm_check_member_directory_access() {
	// if the user is NOT an admin and trying to access groups, kick them back to the homepage.
	// exception: company directory/pages are ok

	if ( 'members' !== bp_current_component() ) {
		return;
	}

	$bp = buddypress();

	if ( ! empty( $bp->current_item ) || ! empty( $bp->current_action ) ) {
		return;
	}

	// echo bp_groups_get_group_type( bp_get_current_group_id() );

	if (! is_user_logged_in() ) {
		// ok you are on a group page now
		wp_safe_redirect( home_url( 'upgrade' ) );
		exit;
	}

	// echo bp_current_component() . '-----';
	// echo bp_current_action() . '-----';

}

add_action('wp', 'rm_check_discussion_access');
function rm_check_discussion_access() {
	// if the user is NOT an admin and trying to access groups, kick them back to the homepage.
	// exception: company directory/pages are ok

	$bp = BuddyPress();
	// print_r( $bp->unfiltered_uri ); exit;
	if ( $bp->unfiltered_uri[0] !== 'discussions' ) {
		return;
	}

	// echo bp_groups_get_group_type( bp_get_current_group_id() );

	if ( ! is_user_logged_in() ) {
		// ok you are on a group page now
		wp_safe_redirect( home_url( 'upgrade' ) );
		exit;
	}

	// echo bp_current_component() . '-----';
	// echo bp_current_action() . '-----';

}


/* the custom RM settings screen in wp-admin that works with aCF */

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Refresh Miami Settings',
		'menu_title'	=> 'RM Settings',
		'menu_slug' 	=> 'rm-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Homepage Settings',
		'menu_title'	=> 'Homepage Settings',
		'parent_slug'	=> 'rm-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Onboarding Slides',
		'menu_title'	=> 'Onboarding Slides',
		'parent_slug'	=> 'rm-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'News / Media Settings',
		'menu_title'	=> 'News / Media Settings',
		'parent_slug'	=> 'rm-settings',
	));

}

/* register */

add_filter( 'gform_progress_bar', 'rm_change_gf_progress_bar', 10, 3 );
function rm_change_gf_progress_bar( $progress_bar, $form, $confirmation_message ) {

	$file = 'steps_top_1.png';

	if ( isset( $_POST ) && ! empty( $_POST ) ) {
		if ( isset( $_POST['gform_target_page_number_10'] ) && intval( $_POST['gform_target_page_number_10'] ) === 2 ) {
			$file = 'steps_top_2.png';
		}
		if ( isset( $_POST['gform_target_page_number_10'] ) && intval( $_POST['gform_target_page_number_10'] ) === 3 ) {
			$file = 'steps_top_2.png';
		}
		if ( isset( $_POST['gform_target_page_number_10'] ) && intval( $_POST['gform_target_page_number_10'] ) === 4 ) {
			$file = 'steps_top_3.png';
		}
		if ( isset( $_POST['gform_target_page_number_10'] ) && intval( $_POST['gform_target_page_number_10'] ) === 5 ) {
			$file = 'steps_top_3.png';
		}
		if ( isset( $_POST['gform_target_page_number_10'] ) && intval( $_POST['gform_target_page_number_10'] ) === 6 ) {
			$file = 'steps_top_3.png';
		}
		if ( isset( $_POST['gform_target_page_number_10'] ) && intval( $_POST['gform_target_page_number_10'] ) === 7 ) {
			$file = 'steps_top_4.png';
		}
		if ( isset( $_POST['gform_target_page_number_10'] ) && intval( $_POST['gform_target_page_number_10'] ) === 8 ) {
			$file = 'steps_top_4.png';
		}
	}

    $progress_bar = '<div class="steps-top">
			<img src="' . get_stylesheet_directory_uri() . '/assets/images/register/' . $file . '" />
			</div>';

    return $progress_bar;
}
add_filter( 'gform_next_button', 'form_next_button', 10, 2 );
function form_next_button( $button, $form ) {

	// print_r( $_POST );
	// exit;

// isset( $_POST['gform_target_page_number_10'] ) && $_POST['gform_target_page_number_10'] === 2

	if ( empty( $_POST ) ) {
		return "<button class='button gform_next_button' id='gform_next_button_{$form['id']}'><span>Continue</span></button>";
	} else {
		return $button;
	}


}

function rm_register_dots() {

	$file = 'dots_1.png';

	if ( isset( $_POST ) && ! empty( $_POST ) ) {
		if ( isset( $_POST['gform_target_page_number_10'] ) && intval( $_POST['gform_target_page_number_10'] ) === 2 ) {
			$file = 'dots_2.png';
		}
		if ( isset( $_POST['gform_target_page_number_10'] ) && intval( $_POST['gform_target_page_number_10'] ) === 3 ) {
			$file = 'dots_2.png';
		}
		if ( isset( $_POST['gform_target_page_number_10'] ) && intval( $_POST['gform_target_page_number_10'] ) === 4 ) {
			$file = 'dots_3.png';
		}
		if ( isset( $_POST['gform_target_page_number_10'] ) && intval( $_POST['gform_target_page_number_10'] ) === 5 ) {
			$file = 'dots_3.png';
		}
		if ( isset( $_POST['gform_target_page_number_10'] ) && intval( $_POST['gform_target_page_number_10'] ) === 6 ) {
			$file = 'dots_3.png';
		}
		if ( isset( $_POST['gform_target_page_number_10'] ) && intval( $_POST['gform_target_page_number_10'] ) === 7 ) {
			$file = 'dots_4.png';
		}
		if ( isset( $_POST['gform_target_page_number_10'] ) && intval( $_POST['gform_target_page_number_10'] ) === 8 ) {
			$file = 'dots_4.png';
		}
	}

   return get_stylesheet_directory_uri() . '/assets/images/register/' . $file;

}

add_filter( 'gform_confirmation_anchor_10', '__return_false' ); // this removes the anchor linking

/**
 * Enqueues scripts and styles for slider and etc for the register screen.
 *
 * @since Boss Child Theme  1.0.0
 */
function rm_register_screen_scripts_styles() {

  // Styles
  wp_enqueue_style( 'rs-slick-css', get_stylesheet_directory_uri().'/assets/css/slick/slick.css', '', time() );
  wp_enqueue_style( 'rs-slick-theme-css', get_stylesheet_directory_uri().'/assets/css/slick/slick-theme.css', '', time() );

  // Javascript
  wp_enqueue_script( 'rm-slick-js', get_stylesheet_directory_uri().'/assets/js/slick/slick.js', '', '1.0.0' );
  wp_enqueue_script( 'rm-register-js', get_stylesheet_directory_uri().'/assets/js/register.js', '', time() );
  wp_enqueue_script( 'rm-home-js', get_stylesheet_directory_uri().'/assets/js/home.js', '', time() );
//   wp_enqueue_script( 'rm-rangeslider-js', get_stylesheet_directory_uri().'/assets/js/rangeslider.js', array('jquery'), time(), true );
  wp_enqueue_script( 'rm-search-js', get_stylesheet_directory_uri().'/assets/js/search.js', array('jquery'), time(), true );
}
add_action( 'wp_enqueue_scripts', 'rm_register_screen_scripts_styles', 9999 );

// add_filter( 'gform_pre_render_10', 'your_function_name' );

add_action("wp_ajax_fm_ajax_get_slide", "fm_ajax_get_slide");
add_action("wp_ajax_nopriv_fm_ajax_get_slide", "fm_ajax_get_slide");

function fm_ajax_get_slide() {

	$slide_number = isset( $_REQUEST['group'] ) ? intval( $_REQUEST['group'] ) : 1;

	echo rm_output_onboarding_slide( $slide_number );

	exit;

}

function rm_output_onboarding_slide( $slide = 1 ) {

	switch ($slide) {
		case '1':
			$slide_group = get_field('slide_group_section_one', 'option');
			break;
		case '2':
			$slide_group = get_field('slide_group_section_two', 'option');
			break;
		case '3':
			$slide_group = get_field('slide_group_section_three', 'option');
			break;
		case '4':
			$slide_group = get_field('slide_group_section_four', 'option');
			break;
		default:
			$slide_group = get_field('slide_group_section_one', 'option');
			break;
	}

	// $slide_group = get_field('slide_group_section_one', 'option');

	// print_r ($slide_group);

	if ( empty( $slide_group ) ) {
		return;
	}

	?>

	<div class="rm-register-slider">
		<?php

			$counter = 0;

			foreach ( $slide_group['slide'] as $slide ) :

				// print_r ($slide);
		?>
		<div>
			<h1><?php echo $slide['slide_title']; ?></h1>
			<div class="slide-description">
				<?php echo wpautop( $slide['slide_content'] ); ?>
			</div>
		</div>
		<?php

		$counter++;

		endforeach; ?>
	</div>

	<?php
}

add_action("wp_ajax_fm_ajax_get_slide_icon", "fm_ajax_get_slide_icon");
add_action("wp_ajax_nopriv_fm_ajax_get_slide_icon", "fm_ajax_get_slide_icon");

function fm_ajax_get_slide_icon() {

	$slide_number = isset( $_REQUEST['group'] ) ? intval( $_REQUEST['group'] ) : 1;

	switch ($slide_number) {
		case '1':
			$icon = 'icon_people.png';
			break;
		case '2':
			$icon = 'icon_office.png';
			break;
		case '3':
			$icon = 'icon_community.png';
			break;
		case '4':
			$icon = 'icon_done.png';
			break;
		default:
			$icon = 'icon_office.png';
			break;
	}

	echo '<img src="' . get_stylesheet_directory_uri() . '/assets/images/register/' . $icon . '" />';

	exit;

}

// add_filter( 'gform_confirmation', function ( $confirmation, $form, $entry, $ajax ) {
//     GFCommon::log_debug( __METHOD__ . '(): running.' );

//     $forms = array( 8 ); // Target forms with id 3, 6 and 7. Change this to fit your needs.

//     if ( ! in_array( $form['id'], $forms, true ) ) {
//         return $confirmation;
//     }

//     if ( isset( $confirmation['redirect'] ) ) {
//         $url          = home_url('dashboard');
//         GFCommon::log_debug( __METHOD__ . '(): Redirect to URL: ' . $url );
//         $confirmation = 'Thanks for contacting us! We will get in touch with you shortly.';
//         $confirmation .= "<script type=\"text/javascript\">window.open('$url', '_blank');</script>";
//     }

//     return $confirmation;
// }, 10, 4 );

/* dashboard */

function rm_dashboard_first_name() {

	// display first name or nothing after "Welcome".

	if ( ! is_user_logged_in() ) {
		return;
	}

	$first_name = xprofile_get_field_data( 1, bp_loggedin_user_id() );
	$output = ( false === $first_name ) ? false : ', ' . $first_name;

	return $output;


}

/* new image sizes */

add_image_size( 'rm-job-thumbnail', 85, 85 );
add_image_size( 'rm-legacy-size', 970, 728 );
add_image_size( 'rm-legacy-size-2', 376, 300 );
add_image_size( 'rm-legacy-size-3', 380, 300 );
add_image_size( 'rm-legacy-size-4', 364, 300 );
add_image_size( 'rm-legacy-size-5', 470, 291 );

/* search */

add_action('wp', 'rm_no_search_redirect');
function rm_no_search_redirect() {

	if ( is_admin() ) {
		return;
	}

	if ( isset( $_GET['bp_search'] ) ) {
		return;
	}

	if ( ! isset( $_GET['s'] ) ) {
		return;
	}

	if ( '' === trim( $_GET['s'] ) ) {
		wp_safe_redirect( home_url('news') );
		exit;
	}

}

add_action('wp', 'rm_test_search_redirect');
function rm_test_search_redirect() {

	if ( is_admin() || ! isset( $_GET['s'] ) ) {
		return;
	}

	if ( isset( $_GET['bp_search'] ) ) {
		return;
	}

	if ( ! is_array( $_GET['s'] ) ) {
		return;
	}

	// print_r( $_GET['s'] );
	// exit;

	$result = array_filter( $_GET['s'] );
	$search_string = implode( '+', $result );

	$search_url = home_url( '?s=' . $search_string );

	// This would output '/client/?s=word&foo=bar&baz=tiny'
	$arr_params = array( 's' => $search_string, 'keyword' => trim( esc_html( $result[0] ) ) );
	if ( isset( $result[1] ) && $result[1] != '' ) {
		$arr_params['type'] = trim( esc_html( $result[1] ) );
	}
	if ( isset( $result[2] ) && $result[2] != '' ) {
		$arr_params['topic'] = trim( esc_html( $result[2] ) );
	}
	if ( isset( $result[3] ) && $result[3] != '' ) {
		$arr_params['industry'] = trim( esc_html( $result[3] ) );
	}
	$search_url = ( add_query_arg( $arr_params, home_url() ) );

	wp_safe_redirect( $search_url );
	exit;

}

/* search and search results */

function rm_search_posts_per_page( $query ) {

    if ( $query->is_search ) {
        $query->set( 'posts_per_page', '4' );
    }
    return $query;
}
add_filter( 'pre_get_posts','rm_search_posts_per_page', 1 );

/* member sidebar */

function my_custom_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Refresh Miami Profile', 'your-theme-domain' ),
            'id' => 'custom-side-bar',
            'description' => __( 'Custom Sidebar', 'your-theme-domain' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'my_custom_sidebar' );

/* remove groups from member profile */

// add_filter( 'the_content', 'rnwpautop' );

// function rmwpautop( $content ) {

// 	return $content;

// 	$content = str_replace( '<br>', '</p><p>', $content );

// 	return $content;

// }


/* Restrict Content Pro + BuddyPress */

// add_filter( 'bp_get_template_stack', array( $this, 'template_stack' ) );


/* member search and search results */

add_action('wp', 'rm_clear_member_search_cookie');
function rm_clear_member_search_cookie() {

	if ( 'members' !== bp_current_component() ) {
		return;
	}

	global $post;

	if ( ! isset( $post->post_name ) || 'members' !== $post->post_name  ) {
		return;
	}

	if ( isset( $_POST['bps_form'] ) ) {
		return;
	}

	$cookie = apply_filters ('bps_cookie_name', 'bps_request');

	if ( empty( $_COOKIE[$cookie] ) ) {
		return;
	}

	// remove cookie.

	// print_r( $_POST );

	// echo 'remove';
	// exit;

	setcookie ($cookie, '', 0, COOKIEPATH);

}

// return apply_filters( 'bp_get_groups_root_slug', buddypress()->groups->root_slug );


/**
* Gravity Forms Custom Activation Template
* http://gravitywiz.com/customizing-gravity-forms-user-registration-activation-page
*/
add_action( 'wp', 'custom_maybe_activate_user', 9 );
function custom_maybe_activate_user() {

	$template_path    = STYLESHEETPATH . '/gfur-activate-template/activate.php';
	$is_activate_page = isset( $_GET['page'] ) && $_GET['page'] === 'gf_activation';
	$is_activate_page = $is_activate_page || isset( $_GET['gfur_activation'] ); // WP 5.5 Compatibility

	if ( ! file_exists( $template_path ) || ! $is_activate_page ) {
		return;
	}
	// echo $template_path; exit;
	require_once( $template_path );
	//wp_redirect( home_url( 'your-account-is-now-active' ) );
	exit();
}


// $can_access     = apply_filters( 'rcpbp_redirect_can_access_component', in_array( $current_component, $user_components ) );
// $profile_access = apply_filters( 'rcpbp_redirect_can_access_profile', in_array( 'profile', $user_components ) );

function rm_rcpbp_redirect_can_access_component( $in_array ) {
	return true;
}
add_filter( 'rcpbp_redirect_can_access_component','rm_rcpbp_redirect_can_access_component', 1 );

function rm_rcpbp_redirect_can_access_profile( $in_array ) {
	return true;
}
add_filter( 'rcpbp_redirect_can_access_profile','rm_rcpbp_redirect_can_access_profile', 1 );

/* assigning memberships upon register */

add_action( 'gform_activate_user', 'rm_gform_activate_user', 10, 3 );
function rm_gform_activate_user( $user_id, $user_data, $signup_meta ) {
	// let us make sure the meta has the desired membership so we can add it properly when the user is activated.
	$entry = GFAPI::get_entry( $signup_meta['lead_id'] );
	if ( strpos( $entry[57], 'individual_monthly') !== false ) {
		update_user_meta( $user_id, 'rm_membership_level_on_activate', 'individual_monthly' );
		$subscription_name = 'Refresh Miami Contributor (Monthly Plan)';
		$subscription_id = 2;
		$subscription_cost = 10.00;
		$args = array(
			'subscription_id'    => $subscription_id,
			'status'             => 'active',
			'recurring'          => true,
			'expiration'         => date( 'Y-m-d 23:59:59', strtotime( '+1 month', current_time( 'timestamp' ) ) )
		);
	} else if ( strpos( $entry[57], 'individual_annual') !== false ) {
		update_user_meta( $user_id, 'rm_membership_level_on_activate', 'individual_annual' );
		$subscription_name = 'Refresh Miami Contributor (Yearly Plan)';
		$subscription_id = 4;
		$subscription_cost = 100.00;
		$args = array(
			'subscription_id'    => $subscription_id,
			'status'             => 'active',
			'recurring'          => true,
			'expiration'         => date( 'Y-m-d 23:59:59', strtotime( '+1 year', current_time( 'timestamp' ) ) )
		);
	} else if ( strpos( $entry[57], 'business_monthly') !== false ) {
		update_user_meta( $user_id, 'rm_membership_level_on_activate', 'business_monthly' );
		$subscription_name = 'Refresh Miami Partner (Monthly Plan)';
		$subscription_id = 3;
		$subscription_cost = 100.00;
		$args = array(
			'subscription_id'    => $subscription_id,
			'status'             => 'active',
			'recurring'          => true,
			'expiration'         => date( 'Y-m-d 23:59:59', strtotime( '+1 month', current_time( 'timestamp' ) ) )
		);
	} else if ( strpos( $entry[57], 'business_annual') !== false ) {
		update_user_meta( $user_id, 'rm_membership_level_on_activate', 'business_annual' );
		$subscription_name = 'Refresh Miami Partner (Yearly Plan)';
		$subscription_id = 5;
		$subscription_cost = 1000.00;
		$args = array(
			'subscription_id'    => $subscription_id,
			'status'             => 'active',
			'recurring'          => true,
			'expiration'         => date( 'Y-m-d 23:59:59', strtotime( '+1 year', current_time( 'timestamp' ) ) )
		);
	} else { // free
		update_user_meta( $user_id, 'rm_membership_level_on_activate', 'individual_free' );
		$subscription_name = 'Refresh Miami Member';
		$subscription_id = 1;
		$subscription_cost = 0;
		$args = array(
			'subscription_id'    => $subscription_id,
			'status'             => 'free',
			'recurring'          => true,
			'expiration'         => date( 'Y-m-d 23:59:59', strtotime( '+1 month', current_time( 'timestamp' ) ) )
		);
	}

	// assign the subscription
	rcp_add_user_to_subscription( $user_id, $args );

	// add payment so that stripe can attempt an auto renew via restrict content pro?
	if ( $subscription_name !== 'Refresh Miami Member' ) {
		$payments = new RCP_Payments();
		$payments->insert( array(
			'subscription'   => $subscription_name,
			'object_id'      => $subscription_id,
			'object_type'    => 'subscription',
			'amount'         => $subscription_cost,
			'user_id'        => $user_id,
			'payment_type'   => 'New',
			'transaction_id' => $entry['transaction_id'], // it's in the entry table, not meta.
			'status'         => 'complete',
			'gateway'        => 'stripe',
			'subtotal'       => $subscription_cost,
			'credits'        => 0
		) );
	}

	// print_r( $entry );
	// print_r( $user_id );
	// print_r( $signup_meta );
	// exit;
}

/* temp way to get resources iported */

		// // Build the labels for the post type.
		// $labels = apply_filters(
		// 	'refresh_resources_post_type_labels',
		// 	array(
		// 		'name'               => $refresh_whitelabel ? apply_filters( 'refresh_resource_whitelabel_name_plural', false ) : __( 'Refresh Resource', 'refresh-resources' ),
		// 		'name_admin_bar'     => $refresh_whitelabel ? apply_filters( 'refresh_resource_whitelabel_name_plural', false ) : __( 'Refresh Resource', 'refresh-resources' ),
		// 		'singular_name'      => $refresh_whitelabel ? apply_filters( 'refresh_resource_whitelabel_name', false ) : __( 'Refresh Resource', 'refresh-resources' ),
		// 		'add_new'            => __( 'Add New', 'refresh-resources' ),
		// 		'add_new_item'       => $refresh_whitelabel ? __( 'Add New Resource', 'refresh-resources' ) : __( 'Add New Refresh Resource', 'refresh-resources' ),
		// 		'edit_item'          => $refresh_whitelabel ? __( 'Edit Resource', 'refresh-resources' ) : __( 'Edit Refresh Resource', 'refresh-resources' ),
		// 		'new_item'           => $refresh_whitelabel ? __( 'New Resource', 'refresh-resources' ) : __( 'New Refresh Resource', 'refresh-resources' ),
		// 		'view_item'          => $refresh_whitelabel ? __( 'View Resource', 'refresh-resources' ) : __( 'View Refresh Resource', 'refresh-resources' ),
		// 		'search_items'       => $refresh_whitelabel ? __( 'Search Resource', 'refresh-resources' ) : __( 'Search Refresh Resource', 'refresh-resources' ),
		// 		'not_found'          => $refresh_whitelabel ? __( 'No Resource found.', 'refresh-resources' ) : __( 'No Refresh Resource found.', 'refresh-resources' ),
		// 		'not_found_in_trash' => $refresh_whitelabel ? __( 'No Resource found in trash.', 'refresh-resources' ) : __( 'No Refresh Resource found in trash.', 'refresh-resources' ),
		// 		'parent_item_colon'  => '',
		// 		'menu_name'          => __( 'Resources', 'refresh-resources' ),
		// 	)
		// );

		// // Build out the post type arguments.
		// $args = apply_filters(
		// 	'refresh_resources_post_type_args',
		// 	array(
		// 		'labels'              => $labels,
		// 		'public'              => false,
		// 		'exclude_from_search' => false,
		// 		'show_ui'             => true,
		// 		'show_in_admin_bar'   => true,
		// 		'rewrite'             => false,
		// 		'query_var'           => false,
		// 		'supports' 			  => array('title', 'author', 'page-attributes'),
		// 		'hierarchical'        => false
		// 	)
		// );

		// // Register the post type with WordPress.
		// register_post_type( 'resources', $args );

add_shortcode('refresh-miami-upgrade-link', 'rm_upgrade_link');
function rm_upgrade_link() {
		ob_start();

	if ( is_user_logged_in() ) {
		$link = bp_core_get_user_domain( bp_loggedin_user_id() ) . 'settings/account';
		echo '<p>The feature you are attempting to use requires a paid membership account. <a href="'.$link.'">Click here</a> to upgrade your account.</p>';
	} else {
		$link = home_url( 'pricing' );
		echo '<p>The feature you are attempting to use requires a paid membership account. <a href="'.$link.'">Click here</a> to log into your account.</p>';
	}
	$content = ob_get_contents();
    ob_end_clean();
    return $content;
}

add_action('init', 'rm_check_add_event' );

function rm_check_add_event() {

	if ( is_admin() ) {
		return;
	}

	$bp = BuddyPress();
	if ( isset( $bp->unfiltered_uri[1] ) && $bp->unfiltered_uri[2] && $bp->unfiltered_uri[1] == 'community' && $bp->unfiltered_uri[2] == 'add' ) {
		$level_ids   = rcp_get_customer_membership_level_ids();
		$allowed_ids = array( '2', '3', '4', '5' );
		// print_r( $level_ids );
		// print_r( $allowed_ids ); exit;
		if ( ! in_array( $level_ids[0], $allowed_ids ) ) {
			$link = home_url( 'upgrade' );
			wp_redirect( $link );
			exit;
		}
	}

	if ( $bp->unfiltered_uri[0] == 'post-a-job' ) {
		$level_ids   = rcp_get_customer_membership_level_ids();
		$allowed_ids = array( '2', '3', '4', '5' );
		if ( ! in_array( $level_ids[0], $allowed_ids ) ) {
			$link = home_url( 'upgrade' );
			wp_redirect( $link );
			exit;
		}
	}

}

if ( isset( $_GET['test_user_import'] ) ) {

	$filepath = ABSPATH."wp-content/themes/buddyboss-theme-child/csv/paid_members.csv";

	print_r( $filepath );
	echo '<br>';
	// exit;

	$csvdata = file_get_contents( $filepath );

	// print_r( $csvdata );

	$members = json_decode( $csvdata );
	$total = count((array)$members);

	echo 'size: ' . $total;
	echo '-----';

	// print_r( $members );
	// exit;


$counter = 0;

	foreach ( $members as $member ) {

		print_r( $member );

		// does this user exist (check email)
		$member_exists = get_user_by( 'user_email', $member->user_email );



		// echo '---';
		// echo 'user email: ';
		// echo $member->user_email;


		if ( false !== $member_exists ) {
			echo 'member_exists: ';
			print_r( $member_exists );
			continue;
		}

		// echo 'membership id: ';
		// echo $member->membership_id;
		// echo 'made it'; exit;

		$incoming_member_id = ( false !== $member_exists ) ? $member_exists->ID : 0;

		// import user as normal

		$userdata = array(
			'ID'                    => $incoming_member_id,    //(int) User ID. If supplied, the user will be updated.
			'user_pass'             => $member->user_email,   //(string) The plain-text user password.
			'user_login'            => $member->user_login,   //(string) The user's login username.
			'user_nicename'         => $member->user_nicename,   //(string) The URL-friendly user name.
			'user_url'              => $member->user_url,   //(string) The user URL.
			'user_email'            => $member->user_email,   //(string) The user email address.
			'display_name'          => $member->display_name,   //(string) The user's display name. Default is the user's username.
			'nickname'              => $member->meta->nickname[0],   //(string) The user's nickname. Default is the user's username.
			'first_name'            => $member->meta->first_name[0],   //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
			'last_name'             => $member->meta->last_name[0],   //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
			'description'           => $member->meta->description[0],   //(string) The user's biographical description.
			'rich_editing'          => '',   //(string|bool) Whether to enable the rich-editor for the user. False if not empty.
			'syntax_highlighting'   => '',   //(string|bool) Whether to enable the rich code editor for the user. False if not empty.
			'comment_shortcuts'     => '',   //(string|bool) Whether to enable comment moderation keyboard shortcuts for the user. Default false.
			'admin_color'           => '',   //(string) Admin color scheme for the user. Default 'fresh'.
			'use_ssl'               => $member->meta->use_ssl[0],   //(bool) Whether the user should always access the admin over https. Default false.
			'user_registered'       => $member->user_registered,   //(string) Date the user registered. Format is 'Y-m-d H:i:s'.
			'show_admin_bar_front'  => '',   //(string|bool) Whether to display the Admin Bar for the user on the site's front end. Default true.
			'role'                  => '',   //(string) User's role.
			'locale'                => '',   //(string) User's locale. Default empty.

		);

		print_r( $member->membership_id );
		$pmpro_stripe_customerid           = isset( $member->meta->pmpro_stripe_customerid[0] ) && ! empty( $member->meta->pmpro_stripe_customerid[0] ) ? $member->meta->pmpro_stripe_customerid[0] : false;
		$pmpro_payment_transaction_id      = isset( $member->payment_transaction_id ) && ! empty( $member->payment_transaction_id ) ? $member->payment_transaction_id : false;
		$pmpro_subscription_transaction_id = isset( $member->subscription_transaction_id ) && ! empty( $member->subscription_transaction_id ) ? $member->subscription_transaction_id : false;
		print_r( $pmpro_payment_transaction_id );
		// exit;




		$old_member_id = $member->ID;

		echo 'old: ' . $old_member_id . '<br>';

		$new_member_id = $user_id = wp_insert_user( $userdata ) ;


		echo 'old: ' . $old_member_id . '<br>';

		// exit;

		// add metadata
		update_user_meta( $new_member_id, 'rm_old_user_id', $old_member_id );
		update_user_meta( $new_member_id, 'rm_old_meta', $member->meta );
		update_user_meta( $new_member_id, 'rm_old_stripe_customer_id', $pmpro_stripe_customerid );

		// add account stuff

		//  1 	REFRESH GOLD (monthly) 	REFRESH GOLD 	REFRESH GOLD 	15.00000000 	15.00000000 	1 	Month 	0 	0.00000000 	0 	0 	0
		// 	2 	REFRESH GOLD (annual) 	REFRESH GOLD (annual) 	REFRESH GOLD (annual) 	120.00000000 	120.00000000 	1 	Year 	0 	0.00000000 	0 	0 	0
		// 	3 	REFRESH PLATINUM (monthly) 	REFRESH PLATINUM 	REFRESH PLATINUM 	30.00000000 	30.00000000 	1 	Month 	0 	0.00000000 	0 	0 	0
		// 	4 	REFRESH PLATINUM (annual) 	REFRESH PLATINUM (annual) 	REFRESH PLATINUM (annual) 	300.00000000 	300.00000000 	1 	Year 	0 	0.00000000 	0 	0 	0
		// 	8 	REFRESH BRONZE 	REFRESH BRONZE 	REFRESH BRONZE 	0.00000000 	0.00000000 	0 		0 	0.00000000 	0 	0 	0
		// 	9 	REFRESH CORPORATE 	REFRESH CORPORATE (annual) 	REFRESH CORPORATE (annual) 	2000.00000000 	2000.00000000 	1 	Year 	0 	0.00000000 	0 	0 	0
		// 	10 	Founders Circle

		switch ( $member->membership_id ) {
			case 1:
				// gold monthly
				update_user_meta( $user_id, 'rm_membership_level_on_activate', 'individual_monthly' );
				$subscription_name = 'Refresh Miami Contributor (Monthly Plan)';
				$subscription_id = 2;
				$subscription_cost = 10.00;
				$args = array(
					'subscription_id'    => $subscription_id,
					'status'             => 'active',
					'recurring'          => true,
					'expiration'         => date( 'Y-m-d 23:59:59', strtotime( '+1 month', current_time( 'timestamp' ) ) )
				);
				break;
			case 2:
				update_user_meta( $user_id, 'rm_membership_level_on_activate', 'individual_annual' );
				$subscription_name = 'Refresh Miami Contributor (Yearly Plan)';
				$subscription_id = 4;
				$subscription_cost = 100.00;
				$args = array(
					'subscription_id'    => $subscription_id,
					'status'             => 'active',
					'recurring'          => true,
					'expiration'         => date( 'Y-m-d 23:59:59', strtotime( '+1 year', current_time( 'timestamp' ) ) )
				);
				break;
			case 3:
				update_user_meta( $user_id, 'rm_membership_level_on_activate', 'business_monthly' );
				$subscription_name = 'Refresh Miami Partner (Monthly Plan)';
				$subscription_id = 3;
				$subscription_cost = 100.00;
				$args = array(
					'subscription_id'    => $subscription_id,
					'status'             => 'active',
					'recurring'          => true,
					'expiration'         => date( 'Y-m-d 23:59:59', strtotime( '+1 month', current_time( 'timestamp' ) ) )
				);
				break;
			case 4:
				update_user_meta( $user_id, 'rm_membership_level_on_activate', 'business_annual' );
				$subscription_name = 'Refresh Miami Partner (Yearly Plan)';
				$subscription_id = 5;
				$subscription_cost = 1000.00;
				$args = array(
					'subscription_id'    => $subscription_id,
					'status'             => 'active',
					'recurring'          => true,
					'expiration'         => date( 'Y-m-d 23:59:59', strtotime( '+1 year', current_time( 'timestamp' ) ) )
				);
				break;
			default:
				update_user_meta( $user_id, 'rm_membership_level_on_activate', 'individual_free' );
				$subscription_name = 'Refresh Miami Member';
				$subscription_id = 1;
				$subscription_cost = 0;
				$args = array(
					'subscription_id'    => $subscription_id,
					'status'             => 'free',
					'recurring'          => true,
					'expiration'         => date( 'Y-m-d 23:59:59', strtotime( '+1 month', current_time( 'timestamp' ) ) )
				);
				break;
		}

		// assign the subscription
		rcp_add_user_to_subscription( $user_id, $args );

		// add payment so that stripe can attempt an auto renew via restrict content pro?
		if ( $subscription_name !== 'Refresh Miami Member' ) {
			$payments = new RCP_Payments();
			$payments->insert( array(
				'subscription'   => $subscription_name,
				'object_id'      => $subscription_id,
				'object_type'    => 'subscription',
				'amount'         => $subscription_cost,
				'user_id'        => $user_id,
				'payment_type'   => 'New',
				'transaction_id' => $pmpro_subscription_transaction_id, // it's in the entry table, not meta.
				'status'         => 'complete',
				'gateway'        => 'stripe',
				'subtotal'       => $subscription_cost,
				'credits'        => 0,
				'date'			 => $member->user_registered
			) );
			echo 'payment made';
		}

		$counter++;

	}

echo $counter . ' users imported';

exit;

}

?>