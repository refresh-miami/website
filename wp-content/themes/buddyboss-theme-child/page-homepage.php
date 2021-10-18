<?php
/*
 * Template name: Homepage (Full Width Content)
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BuddyBoss_Theme
 */

get_header('homepage');

/*
?>

<div id="primary" class="content-area bs-bp-container">
	<main id="main" class="site-main">

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

	</main><!-- #main -->
</div><!-- #primary -->

<?php */ ?>



<div id="primary" class="content-area bs-bp-container">
    <main id="main" class="site-main">
        <article id="post-0" class="bp_activity type-bp_activity post-0 page type-page status-publish hentry">
            <header class="entry-header">
                <h1 class="entry-title">News</h1>
            </header>
            <!-- .entry-header -->

            <div class="entry-content featured-entry-content">

                <?php
                
                $latest_posts = new WP_Query( array(
                    'posts_per_page'      => 1, // Displays the latest 10 posts, change 10 to what you require
                    'post_type'           => 'post', // Pulls posts from 'post' post type only
                    'ignore_sticky_posts' => true, // Ignores the sticky posts
                ));

                while ($latest_posts->have_posts()) :
                    $latest_posts->the_post();

					get_template_part( 'template-parts/content-homepage-featured' );

                endwhile;

                $latest_posts = new WP_Query( array(
                    'offset'              => 1,
                    'posts_per_page'      => 10, // Displays the latest 10 posts, change 10 to what you require
                    'post_type'           => 'post', // Pulls posts from 'post' post type only
                    'ignore_sticky_posts' => true, // Ignores the sticky posts
                ));

                ?>

                <div id="homepage-posts" role="complementary" class="widget-area sm-grid-1-1 sidebar-right">

                <div class="bb-sticky-sidebar">

                <?php

// global $_wp_additional_image_sizes; 
// print '<pre>'; 
// print_r( $_wp_additional_image_sizes ); 
// print '</pre>';

                while ($latest_posts->have_posts()) :
                    $latest_posts->the_post();

                    $author = rm_get_user_full_name( $post->post_author );
                    $author_permalink = bp_core_get_user_domain( $post->post_author );
                    $featured_img_url = get_the_post_thumbnail_url( $post->ID, 'medium' ); 

                ?>



                        <aside id="rm-recent-news-<?php echo $post->ID; ?>" class="widget bb_widget_recent_posts">

                            <ul class="rm-recent-posts">
                                <li>
                                    <div class="entry-content left">
                                    
                                        <a href="<?php echo get_permalink( $post->ID ); ?>" title="<?php the_title(); ?>" class="link-img">
                                        <?php if ( has_post_thumbnail() ) { ?>
                                            <figure class="news-thumbnail"><img src="<?php echo $featured_img_url; ?>" /></figure>
                                        <?php } ?>
                                        </a>

                                        
                
                <div class="entry-meta-wrap">
                                            <span class="post-date" ><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo get_the_date(); ?></a></span>
                                            <span class="post-author" >By <a href="<?php echo $author_permalink; ?>"><?php echo $author; ?></a></span>
                                        </div>
            
            

                                    
                                    </div> 

                                    <div class="news-content">
                                        <h2><a href="<?php echo get_permalink( $post->ID ); ?>" class="bb-title"><?php the_title(); ?></a></h2>

                                        <div class="entry-content right">
                                            <?php 
                                            if( empty($post->post_excerpt) ) {
                                                echo( str_replace( 'FacebookTweetPinLinkedInEmail ', '', get_the_excerpt() ) );
                                            } else {
                                                echo bb_get_excerpt($post->post_excerpt, 150);
                                            }
                                            ?>
                                        </div>
                                        <div class="more-block">
                                                <a href="<?php echo get_permalink( $post->ID ); ?>" class="count-more">More<i class="bb-icon-angle-right"></i></a>
                                        </div>
                                    </div>
                                </li>
                            
                            </ul>
                        </aside>

                <?php

                endwhile;

                ?>
                
                </div>
                </div>

                <h2 class="entry-title recent-jobs-title">Recent Jobs</h2>

                <?php

                    $latest_jobs = new WP_Query( array(
                        'posts_per_page'      => 10, // Displays the latest 10 posts, change 10 to what you require
                        'post_type'           => 'job_listing', // Pulls posts from 'post' post type only
                        'ignore_sticky_posts' => true, // Ignores the sticky posts
                    ));

                    ?>

                    <div id="homepage-jobs" role="complementary" class="widget-area sm-grid-1-1 sidebar-right">

                    <div class="bb-sticky-sidebar">

                    <?php

                    // global $_wp_additional_image_sizes; 
                    // print '<pre>'; 
                    // print_r( $_wp_additional_image_sizes ); 
                    // print '</pre>';

                    while ($latest_jobs->have_posts()) :
                        $latest_jobs->the_post();

                            $job_metadata = get_post_meta( $post->ID );
                            $job_company  = esc_html( $job_metadata['_company_name'][0] );
                            $job_location = esc_html( $job_metadata['_job_location'][0] );

                            // print_r( $job_metadata );

                    ?>



                            <aside id="rm-recent-news-<?php echo $post->ID; ?>" class="widget bb_widget_recent_posts">

                                <ul class="rm-recent-posts">
                                    <li>
                                    <?php /* <a href="<?php echo get_permalink( $post->ID ); ?>" title="<?php the_title(); ?>" class="link-img">
                                    <?php if ( has_post_thumbnail() ) { ?>
                                        <figure class="news-thumbnail"></figure>
                                    <?php } ?>
                                    </a> */ ?>
                                        <div class="job-content">
                                            <h2><a href="<?php echo get_permalink( $post->ID ); ?>" class="bb-title"><?php the_title(); ?></a></h2>
                                            <div class="entry-meta">
                                                <div class="bb-user-avatar-wrap">
                                                    <div class="meta-wrap">
                                                        <p><span class="job-company"><?php echo $job_company; ?></span> | <span class="job-location"><?php echo $job_location; ?></span></p>
                                                        <p><span class="post-date">Posted on <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo get_the_date(); ?></a></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="entry-content">
                                                <?php 
                                                // if( empty($post->post_excerpt) ) {
                                                //     the_excerpt();
                                                // } else {
                                                //     echo bb_get_excerpt($post->post_excerpt, 150);
                                                // }
                                                ?>
                                            </div>
                                            <div class="more-block">
                                                    <a href="<?php echo get_permalink( $post->ID ); ?>" class="count-more">More<i class="bb-icon-angle-right"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                
                                </ul>
                            </aside>

                    <?php

                    endwhile;

                    ?>

                    </div>
                    </div>
                
                

                

            </div>
            <!-- .entry-content -->
        </article>
    </main>
    <!-- #main -->
</div>
<!-- #primary -->

<div id="secondary" role="complementary" class="widget-area sm-grid-1-1 sidebar-right">
    <div class="bb-sticky-sidebar">
        <?php

                $homepage_events = homepage_get_events( 5 );
                $homepage_featured_events = homepage_get_featured_events( 1 );

                // print_r( $homepage_events );

                if ( ! empty( $homepage_events ) ) :


        ?>
        <aside id="boss-recent-posts-2" class="widget bb_widget_recent_posts">
            <h2 class="widget-title">Upcoming Events</h2>
            <?php if ( ! empty( $homepage_featured_events ) ) : ?>
             <ul class="featured-events">
                <?php

                    foreach ( $homepage_featured_events as $event ) {

                        // print_r ($event);

                        $permalink = get_permalink( $event->ID );
                        $featured_img_url = get_the_post_thumbnail_url( $event->ID, 'medium' ); 
                        $start_date = get_post_meta( $event->ID, '_EventStartDate', true );
                        $start_date = ( ! empty( $start_date ) ) ? date('F j, Y, g:i a', strtotime( $start_date ) ) : false;
                        $start_date_month = date('M', strtotime( $start_date ) );
                        $start_date_day = date('j', strtotime( $start_date ) );
                        $end_date = get_post_meta( $event->ID, '_EventEndDate', true );
                        $venue_id = get_post_meta( $event->ID, '_EventVenueID', true );
                        $venue_post = get_post( $venue_id );
                        $venue_title = ( ! empty( $venue_post ) ) ? $venue_post->post_title : false;

                ?>
                <li class="featured-event">
                    <a href="<?php echo $permalink; ?>" title="<?php echo $event->post_title; ?>" class="featured-event-link">
                        <img
                            src="<?php echo $featured_img_url; ?>"
                            class="featured-event-image"
                            alt="<?php echo $event->post_title; ?>"
                        />
                    </a>
                    <div class="featured-event-info">
                        <?php if ( $start_date )  { ?>
                        <time class="event-date">
                            <span class="top"><?php echo $start_date_day; ?></span>
                            <span class="bottom"><?php echo $start_date_month; ?></span>
                        </time>
                        <?php } ?>
                        <div>
                            <h4><a href="<?php echo $permalink; ?>" class="bb-title"><?php echo $event->post_title; ?></a></h4>
                            <div><small><?php echo $venue_title; ?></small></div>
                        </div>
                    </div>
                </li>
                <?php } ?>
            </ul>
            <hr/>
            <?php endif; ?>
            <ul class="bb-recent-posts">
                <?php

                    foreach ( $homepage_events as $event ) {

                        $permalink = get_permalink( $event->ID );
                        $featured_img_url = get_the_post_thumbnail_url( $event->ID, 'thumbnail' ); 
                        $start_date = get_post_meta( $event->ID, '_EventStartDate', true );
                        $start_date = ( ! empty( $start_date ) ) ? date('F j, Y, g:i a', strtotime( $start_date ) ) : false;
                        $start_date_month = date('M', strtotime( $start_date ) );
                        $start_date_day = date('j', strtotime( $start_date ) );
                        $end_date = get_post_meta( $event->ID, '_EventEndDate', true );
                        $venue_id = get_post_meta( $event->ID, '_EventVenueID', true );
                        $venue_post = get_post( $venue_id );
                        $venue_title = ( ! empty( $venue_post ) ) ? $venue_post->post_title : false;

                ?>
                <li>
                    <div class="featured-event-info">
                        <?php if ( $start_date )  { ?>
                        <time class="event-date">
                            <span class="top"><?php echo $start_date_day; ?></span>
                            <span class="bottom"><?php echo $start_date_month; ?></span>
                        </time>
                        <?php } ?>
                        <div>
                            <h4><a href="<?php echo $permalink; ?>" class="bb-title"><?php echo $event->post_title; ?></a></h4>
                            <div><small><?php echo $venue_title; ?></small></div>
                        </div>
                    </div>
                </li>
                <?php } ?>
            </ul>
            <div class="more-block">
                    <a href="/events/" class="count-more">More<i class="bb-icon-angle-right"></i></a>
                </div>
        </aside>

        <?php endif; ?>

        <?php

        $featured_startups = rm_get_businesses( 5, null, null, true );

        // print_r ($featured_startups);

        if ( isset( $featured_startups['total'] ) && intval( $featured_startups['total'] ) > 0 ) :

        ?>

        <aside id="boss-recent-posts-2" class="widget bb_widget_recent_posts">
            <h2 class="widget-title">Startups</h2>
            <ul class="bb-recent-posts">
                <?php

                    foreach ( $featured_startups['groups'] as $startup ) {

                        $permalink = bp_get_group_permalink( $startup );
                        $group_metadata = groups_get_groupmeta( $startup->id, 'rm_group_business_metadata' );

                ?>
                <li>
                    <a href="<?php echo $permalink; ?>" title="<?php echo $startup->name; ?>" class="entry-media entry-img">
                    <?php echo bp_core_fetch_avatar( array ( 'item_id' => $startup->id, 'object' => 'group', 'width' => 507, 'class' => 'attachment-post-thumbnail size-post-thumbnail wp-post-image' ) ); ?>
                        <!-- <img
                            src="https://refresh.miami/wp-content/uploads/2020/10/money.jpg"
                            class="attachment-post-thumbnail size-post-thumbnail wp-post-image"
                            alt=""
                            loading="lazy"
                            srcset="https://refresh.miami/wp-content/uploads/2020/10/money.jpg 507w, https://refresh.miami/wp-content/uploads/2020/10/money-300x200.jpg 300w"
                            sizes="(max-width: 507px) 100vw, 507px"
                            width="507"
                            height="338"
                        /> -->
                    </a>
                    <div class="">
                        <h4><a href="<?php echo $permalink; ?>" class="bb-title"><?php echo $startup->name; ?></a></h4>
                        <?php if ( $group_metadata['headquarters_location'] ) { ?>
                            <small><?php echo $group_metadata['headquarters_location']; ?></small>
                        <?php } ?>
                    </div>
                </li>
               
                <?php } ?>
            </ul>
        </aside>

        <?php endif; ?>

        <?php if ( is_active_sidebar( 'home_right_2' ) ) : ?>
    
            <?php dynamic_sidebar( 'home_right_2' ); ?>
    
        <?php endif; ?>

       

    </div>
</div>

<div id="secondary-right" class="widget-area sm-grid-1-1 sidebar-right" role="complementary">
    <div class="bb-sticky-sidebar">

        <?php if ( is_active_sidebar( 'home_right_1' ) ) : ?>
    
            <?php dynamic_sidebar( 'home_right_1' ); ?>
    
        <?php endif; ?>


    </div>
</div>



<?php
get_footer();
