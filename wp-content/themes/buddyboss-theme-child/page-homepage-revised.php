

<?php
   /*
    * Template name: Homepage (Revised)
    * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
    *
    * @package BuddyBoss_Theme
    */

   get_header('homepage-revised');

   // get all variables for homepage.

   $primary_headline      = get_field( 'primary_headline', 'option' );
   $primary_tagline       = get_field( 'primary_tagline', 'option' );
   $groups_visibility     = get_field( 'groups_visibility', 'option' );
   $big_three             = get_field( 'big_three', 'option' );
   $why_join_homepage     = get_field( 'why_join_homepage', 'option' );
   $featured_job_openings = get_field( 'featured_job_openings', 'option' );
   $testomonials_homepage = get_field( 'testomonials_homepage', 'option' );
   $testomonials          = ( function_exists('rm_get_homepage_testimonials') ) ? rm_get_homepage_testimonials( 12 ) : false;
   $partners              = ( function_exists('rm_get_homepage_partners') ) ? rm_get_homepage_partners( 99 ) : false;
   $featured_jobs         = ( function_exists('rm_get_featured_jobs') ) ? rm_get_featured_jobs( 2 ) : false;
   $homepage_jobs         = ( function_exists('rm_get_homepage_jobs') ) ? rm_get_homepage_jobs( 10 ) : false;
   $super_featured_jobs   = ( function_exists('rm_get_super_featured_jobs') ) ? rm_get_super_featured_jobs( 10 ) : false;
   $featured_events       = ( function_exists('rm_get_featured_events') ) ? rm_get_featured_events( 2 ) : false;
   $homepage_events       = ( function_exists('rm_get_events') ) ? rm_get_events( 5 ) : false;
   $featured_news         = ( function_exists('rm_get_featured_homepage_news') ) ? rm_get_featured_homepage_news( 1 ) : false;
   $featured_news_ids     = array();

   ?>
<div class="wide white">
   <div class="container">
      <div class="<?php echo apply_filters( 'buddyboss_site_content_grid_class', 'bb-gridx site-content-gridx' ); ?>">
         <?php echo do_shortcode('[smartslider3 slider=2]'); ?>
         <div id="hp-main" class="hp-main">
            <?php
               if ( ! empty( $primary_headline ) ) {
                   echo '<h2 class="hp-title">' . esc_html( $primary_headline ) . '</h2>';
               }
               ?>
            <?php
               if ( ! empty( $primary_tagline ) ) {
                   echo '<h4 class="hp-subtitle">' . esc_html( $primary_tagline ) . '</h2>';
               }
               ?>
            <?php
               // print_r ( $big_three );
               ?>
            <div id="big-sell" class="big-sell bb-grid site-content-grid">
               <?php
                  for( $x=1; $x<=3; $x++ ) {
                      echo '<div class="content-area bs-bp-container">';
                      if ( isset( $big_three['icon_' . $x ] ) && ! empty( isset( $big_three['icon_' . $x ] ) ) ) {
                          echo '<img src="' . esc_html( $big_three['icon_' . $x] ) . '" />';
                      }
                      if ( isset( $big_three['content_' . $x ] ) && ! empty( isset( $big_three['content_' . $x ] ) ) ) {
                          echo wpautop( $big_three['content_' . $x ] );
                      }
                      echo '</div>';
                  }
                  ?>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="container">
   <div id="hp-news-events" class="hp-news-events">
      <div class="hp-news-events-container bb-grid site-content-grid">
         <div id="hp-news-main" class="hp-news-main content-area bs-bp-container">
            <h5>Latest News</h5>
            <?php
               if ( false !== $featured_news ) :
                foreach( $featured_news as $featured_news_item ) {
                     $permalink = get_permalink( $featured_news_item->ID );
                     $date = date('M d, Y', strtotime( $featured_news_item->post_date ) );
                     // $post_author = get_the_author_meta( 'nicename', $featured_news_item->post_author );
                     $featured_image_url = get_the_post_thumbnail_url( $featured_news_item->ID, 'large' );
                     // Assuming $user_id is the id for the desired user
                     $avatar_url = bp_core_fetch_avatar (
                         array(  'item_id' => $featured_news_item->post_author, // id of user for desired avatar
                                 'type'    => 'thumb',
                                 'html'    => FALSE     // FALSE = return url, TRUE (default) = return img html
                         )
                     );
                     $featured_news_ids[] = $featured_news_item->ID;
               ?>
            <article id="post-<?php echo $featured_news_item->ID; ?>" class="post-<?php echo $featured_news_item->ID; ?>">
               <div class="post-inner-wrap">
                  <div class="ratio-wrap">
                     <a href="<?php echo $permalink; ?>" title="Permalink to <?php echo esc_html( $featured_news_item->post_title ); ?>" class="entry-media entry-img">
                     <img src="<?php echo $featured_image_url; ?>" class="attachment-large size-large wp-post-image" alt="" loading="lazy" /></a>
                  </div>
                  <div class="entry-content-wrap featured-entry-content-wrap">
                     <header class="entry-header">
                        <h1 class="entry-title"><a href="<?php echo $permalink; ?>"><?php echo esc_html( $featured_news_item->post_title ); ?></a></h1>
                     </header>
                     <div class="entry-excerpt">
                        <div class="entry-content"><?php echo $news_excerpt; ?></div>
                     </div>
                     <!-- .entry-header -->
                     <div class="entry-meta">
                        <div class="bb-user-avatar-wrap">
                           <div class="meta-wrap">
                              <span class="post-date"><a href="<?php echo $permalink; ?>"><?php echo rm_relative_time( strtotime( $featured_news_item->post_date ) ); ?></a></span>
                              <span class="post-author"><img src="<?php echo $avatar_url; ?>" class="post-author-avatar" alt="" /><small>By <?php echo bp_core_get_userlink( $featured_news_item->post_author ); ?></small></span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!--Close '.post-inner-wrap'-->
            </article>
            <?php
               }
               endif;
               ?>
            <div id="hp-news" class="hp-news content-area bs-bp-container">
               <?php
                  $homepage_news = ( function_exists('rm_get_homepage_news') ) ? rm_get_homepage_news( 8, $featured_news_ids ) : false;
                     if ( false !== $homepage_news ) :
                         foreach ( $homepage_news as $news_item ) {
                             $permalink = get_permalink( $news_item->ID );
                          $date = date('M d, Y', strtotime( $news_item->post_date ) );
                          // $post_author = get_the_author_meta( 'nicename', $featured_news_item->post_author );
                          $featured_image_url = get_the_post_thumbnail_url( $news_item->ID, 'large' );
                     ?>
               <article id="post-<?php echo esc_html( $news_item->ID ); ?>" class="post-<?php echo esc_html( $news_item->ID ); ?>">
                  <div class="post-inner-wrap">
                     <div class="ratio-wrap">
                        <a href="<?php echo $permalink; ?>" title="Permalink to <?php echo esc_html( $news_item->post_title ); ?>" class="entry-media entry-img">
                        <img src="<?php echo $featured_image_url; ?>" class="attachment-large size-large wp-post-image" alt="" loading="lazy"  width="640" height="489"></a>
                     </div>
                     <div class="entry-content-wrap featured-entry-content-wrap">
                        <header class="entry-header">
                           <h2 class="entry-title"><a href="<?php echo $permalink; ?>"><?php echo esc_html( $news_item->post_title ); ?></a></h2>
                        </header>
                        <!-- .entry-header -->
                        <div class="entry-meta">
                           <div class="bb-user-avatar-wrap">
                              <div class="meta-wrap">
                                 <span class="post-date"><a href="<?php echo $permalink; ?>"><?php echo rm_relative_time( strtotime( $news_item->post_date ) ); ?></a></span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--Close '.post-inner-wrap'-->
               </article>
               <?php }
                  endif; ?>
               <div class="see-all"><a href="/news">See All News</a></div>
            </div>
         </div>
         <div class="content-area bs-bp-container">
            <div id="hp-events" class="content-area bs-bp-container border-bottom">
               <h5>Upcoming Events</h5>
               <ul class="bb-recent rm-list rm-events">
                  <?php
                     // echo '----'; print_r ($homepage_jobs);
                           if ( ! empty( $featured_events ) ) :
                           foreach ( $featured_events as $homepage_event ) {
                         $link = get_permalink( $homepage_event->ID );
                         // $date = date('M d, Y', strtotime( $homepage_job->post_date ) );
                         $meta = get_post_meta( $homepage_event->ID );
                         $start_date = $meta['_EventStartDate'][0];
                         $start_day = date('d', strtotime( $start_date ) );
                         $start_month = date('M', strtotime( $start_date ) );
                         $start_time = date('g:i a', strtotime( $start_date ) );
                         $event_cost = $meta['_EventCost'][0];
                         $event_cost = ( ! empty( $event_cost ) ) ? '$' . $event_cost . ' &#183; ' : $event_cost;
                         // print_r( $meta );
                     ?>
                  <li class="featured">
                     <div class="featured-event-info">
                        <time class="event-date">
                        <span class="top"><?php echo $start_day; ?></span>
                        <span class="bottom"><?php echo $start_month; ?></span>
                        </time>
                        <div class="event-info">
                           <h6 class="featured ribbon">Featured</h6>
                           <h4><a href="<?php echo $link; ?>" class="event-title"><?php echo esc_html( $homepage_event->post_title ); ?></a></h4>
                           <p class="details">
                              <small>
                                 <?php echo $event_cost; ?> <?php echo $start_time; ?> <!-- &#183; Coral Gables -->
                              </small>
                           </p>
                        </div>
                     </div>
                  </li>
                  <?php } ?>
                  <?php endif; ?>
                  <?php
                     // echo '----'; print_r ($homepage_jobs);
                           if ( ! empty( $homepage_events ) ) :
                           foreach ( $homepage_events as $homepage_event ) {
                                                       $link = get_permalink( $homepage_event->ID );
                         // $date = date('M d, Y', strtotime( $homepage_job->post_date ) );
                         $meta = get_post_meta( $homepage_event->ID );
                         $start_date = $meta['_EventStartDate'][0];
                         $start_day = date('d', strtotime( $start_date ) );
                         $start_month = date('M', strtotime( $start_date ) );
                         $start_time = date('g:i a', strtotime( $start_date ) );
                         $event_cost = $meta['_EventCost'][0];
                         $event_cost = ( ! empty( $event_cost ) ) ? '$' . $event_cost . ' &#183; ' : $event_cost;
                               // print_r( $meta );
                           ?>
                  <li>
                     <div class="featured-event-info">
                        <time class="event-date">
                        <span class="top"><?php echo $start_day; ?></span>
                        <span class="bottom"><?php echo $start_month; ?></span>
                        </time>
                        <div class="event-info">
                           <h4><a href="<?php echo $link; ?>" class="event-title"><?php echo esc_html( $homepage_event->post_title ); ?></a></h4>
                           <p class="details">
                              <small>
                                 <?php echo $event_cost; ?> <?php echo $start_time; ?> <!-- &#183; Coral Gables -->
                              </small>
                           </p>
                        </div>
                     </div>
                  </li>
                  <?php } ?>
                  <?php endif; ?>
               </ul>
               <div class="see-all"><a href="<?php echo home_url('events'); ?>">See All Events</a></div>
            </div>
            <div id="hp-job-openings" class="hp-content border-bottom">
               <h5>Job Openings</h5>
               <ul class="bb-recent rm-list rm-jobs">
                  <?php
                     if ( ! empty( $featured_jobs ) ) :
                               foreach ( $featured_jobs as $featured_job ) {
                                   $logo = get_the_post_thumbnail_url( $featured_job->ID, 'rm-job-thumbnail' );
                             $logo = ( false === $logo || empty( $logo ) ) ? get_stylesheet_directory_uri() . '/assets/images/homepage/job-icon.png' : $logo;
                             $link = get_permalink( $featured_job->ID );
                             $date = date('M d, Y', strtotime( $featured_job->post_date ) );
                             $meta = get_post_meta( $featured_job->ID );
                             $job_location = ( ! empty( $meta['_job_location'][0] ) ) ? $meta['_job_location'][0] : false;
                             $job_company  = ( ! empty( $meta['_company_name'][0] ) ) ? $meta['_company_name'][0] : false;
                             $job_tageline = ( false !== $job_location && false !== $job_company ) ? $job_location . ' | ' . $job_company : false;
                             $job_tageline = ( false === $job_tageline && false !== $job_location ) ? $job_location : $job_tageline;
                             $job_tageline = ( false === $job_tageline && false !== $job_company ) ? $job_company : $job_tageline;
                                           ?>
                  <li class="featured">
                     <div class="featured-job-info">
                        <div class="job-icon left">
                           <a href="<?php echo $link; ?>"><img src="<?php echo $logo; ?>" alt="<?php echo esc_html( $featured_job->post_title ); ?>" /></a>
                        </div>
                        <div class="job-info">
                           <h6 class="featured ribbon">Featured</h6>
                           <h4><a href="<?php echo $link; ?>" class="event-title"><?php echo esc_html( $featured_job->post_title ); ?></a></h4>
                           <p class="details"><small><?php echo $job_tageline; ?><br/><strong>Posted On</strong> <?php echo $date; ?></small></p>
                        </div>
                     </div>
                  </li>
                  <?php } ?>
                  <?php endif; ?>
                  <?php
                     // echo '----'; print_r ($homepage_jobs);
                           if ( ! empty( $homepage_jobs ) ) :
                           foreach ( $homepage_jobs as $homepage_job ) {
                               $logo = get_the_post_thumbnail_url( $homepage_job->ID, 'rm-job-thumbnail' );
                         $logo = ( false === $logo || empty( $logo ) ) ? get_stylesheet_directory_uri() . '/assets/images/homepage/job-icon.png' : $logo;
                         $link = get_permalink( $homepage_job->ID );
                         $date = date('M d, Y', strtotime( $homepage_job->post_date ) );
                         $meta = get_post_meta( $homepage_job->ID );
                         $job_location = ( ! empty( $meta['_job_location'][0] ) ) ? $meta['_job_location'][0] : false;
                         $job_company  = ( ! empty( $meta['_company_name'][0] ) ) ? $meta['_company_name'][0] : false;
                         $job_tageline = ( false !== $job_location && false !== $job_company ) ? $job_location . ' | ' . $job_company : false;
                         $job_tageline = ( false === $job_tageline && false !== $job_location ) ? $job_location : $job_tageline;
                         $job_tageline = ( false === $job_tageline && false !== $job_company ) ? $job_company : $job_tageline;
                               // print_r( $meta );
                           ?>
                  <li>
                     <div class="featured-job-info">
                        <div class="job-icon left">
                           <a href="<?php echo $link; ?>"><img src="<?php echo $logo; ?>" alt="<?php echo esc_html( $homepage_job->post_title ); ?>" /></a>
                        </div>
                        <div class="job-info">
                           <h4><a href="<?php echo $link; ?>" class="event-title"><?php echo esc_html( $homepage_job->post_title ); ?></a></h4>
                           <p class="details"><small><?php echo $job_tageline; ?><br/><strong>Posted On</strong> <?php echo $date; ?></small></p>
                        </div>
                     </div>
                  </li>
                  <?php } ?>
                  <?php endif; ?>
               </ul>
               <div class="see-all"><a href="<?php echo home_url('jobs'); ?>">See All Jobs</a></div>
            </div>
            <?php
               /* if ( $groups_visibility ) :
               ?>
            <div class="hp-groups">
               <h5>Groups</h5>
               <?php if ( is_active_sidebar( 'home_right_2' ) ) : ?>
               <?php dynamic_sidebar( 'home_right_2' ); ?>
               <?php endif; ?>
            </div>
            <?php endif; */ ?>
            <?php /* <div class="rm-ad 300x250">
               <a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/ads/300x250.png" /></a>
            </div> */ ?>
         </div>
      </div>
      <?php /* <div id="hp-news-jobs" class="hp-news-events">
         <div class="hp-news-jobs-container bb-grid site-content-grid">
            <div id="hp-second-row" class="content-area bs-bp-container">
            </div>
         </div>
         </div> */ ?>
      <?php
         // get_footer();

         ?>
      <?php do_action( THEME_HOOK_PREFIX . 'end_content' ); ?>
   </div>
   <!-- .bb-grid -->
   <?php if ( function_exists('rm_sponsor_carousel') ) {
      // rm_sponsor_carousel();
      } ?>
</div>
<!-- .container -->
</div><!-- #content -->
<div class="full-width why-join">
   <div class="container">
      <?php
         if ( ! empty( $why_join_homepage['title'] ) ) {
             echo '<h2 class="hp-title">' . esc_html( $why_join_homepage['title'] ) . '</h2>';
         }

         ?>
      <?php
         if ( ! empty( $why_join_homepage['subtitle'] ) ) {
             echo '<h4 class="hp-subtitle">' . esc_html( $why_join_homepage['subtitle'] ) . '</h2>';
         }

         ?>
      <div class="content-area">
         <div class="banner-image">
            <?php
               if ( isset( $why_join_homepage['hero_graphic'] ) && ! empty( isset( $why_join_homepage['hero_graphic'] ) ) ) {
                   echo '<img src="' . esc_html( $why_join_homepage['hero_graphic'] ) . '" />';
               }
               ?>
         </div>
         <div class="why-copy">
            <?php echo wpautop( $why_join_homepage['above_bullet_content']  ); ?>
            <ul>
               <?php
                  foreach ( $why_join_homepage['bullet'] as $bullet ) {
                       echo '<li><div class="icon">';
                       echo '<img src="' . $bullet['bullet_icon'] . '" />';
                       echo '</div>';
                       echo '<div class="info">';
                       echo '<h6 class="why-list-title">' . $bullet['bullet_title'] . '</h6>';
                       echo wpautop( $bullet['bullet_text'] );
                       echo '</div></li>';
                  }
                  ?>
            </ul>
         </div>
      </div>
      <div class="see-all btn">
         <a href="<?php echo esc_url( $why_join_homepage['button_url'] ); ?>" class="btn button"><?php echo esc_html( $why_join_homepage['button_text'] ); ?></a>
      </div>
   </div>
</div>
<?php
   if ( ! empty( $super_featured_jobs ) ) :

   ?>
<div class="full-width featured-job-openings">
   <div class="container">
      <?php
         if ( ! empty( $featured_job_openings['title'] ) ) {
             echo '<h2 class="hp-title">' . esc_html( $featured_job_openings['title'] ) . '</h2>';
         }

         ?>
      <?php
         if ( ! empty( $featured_job_openings['subtitle'] ) ) {
             echo '<h4 class="hp-subtitle">' . esc_html( $featured_job_openings['subtitle'] ) . '</h2>';
         }

         ?>
      <?php
         if ( ! empty( $featured_job_openings['subtitle_2'] ) ) {
             echo '<h4 class="hp-subtitle">' . esc_html( $featured_job_openings['subtitle_2'] ) . '</h2>';
         }

         ?>
      <div class="job-openings-listing">
         <ul class="bb-recent rm-list rm-jobs no-shadow">
            <?php
               foreach ( $super_featured_jobs as $featured_job ) {
                   $logo = get_the_post_thumbnail_url( $featured_job->ID );
                   $logo = ( false === $logo || empty( $logo ) ) ? get_stylesheet_directory_uri() . '/assets/images/homepage/job-icon.png' : $logo;
                   $link = get_permalink( $featured_job->ID );
                   $date = date('M d, Y', strtotime( $featured_job->post_date ) );
                   $meta = get_post_meta( $featured_job->ID );
                   $job_location = ( ! empty( $meta['_job_location'][0] ) ) ? $meta['_job_location'][0] : false;
                   $job_company  = ( ! empty( $meta['_company_name'][0] ) ) ? $meta['_company_name'][0] : false;
                   $job_tageline = ( false !== $job_location && false !== $job_company ) ? $job_location . ' | ' . $job_company : false;
                   $job_tageline = ( false === $job_tageline && false !== $job_location ) ? $job_location : $job_tageline;
                   $job_tageline = ( false === $job_tageline && false !== $job_company ) ? $job_company : $job_tageline;
                       ?>
            <li>
               <a href="<?php echo $link; ?>">
                  <div class="interior">
                     <div class="featured-job-info">
                        <div class="job-icon">
                           <img src="<?php echo $logo; ?>" alt="<?php echo esc_html( $featured_job->post_title ); ?>" />
                        </div>
                        <div class="job-info">
                           <h5 class="event-title"><?php echo esc_html( $featured_job->post_title ); ?></h5>
                           <p class="details"><small><?php echo esc_html( $job_location ); ?></small></p>
                        </div>
                     </div>
                  </div>
               </a>
            </li>
            <?php } ?>
         </ul>
         <div class="see-all btn">
            <a href="<?php echo home_url('jobs'); ?>" class="btn button">See All Jobs</a>
         </div>
      </div>
   </div>
</div>
<?php endif; ?>
<?php
   if ( ! empty( $testomonials ) ) :

   ?>
<div class="full-width rm-testimonials">
   <div class="container">
      <?php
         if ( ! empty( $testomonials_homepage['title'] ) ) {
             echo '<h2 class="hp-title">' . esc_html( $testomonials_homepage['title'] ) . '</h2>';
         }

         ?>
      <?php
         if ( ! empty( $testomonials_homepage['subtitle'] ) ) {
             echo '<h4 class="hp-subtitle">' . esc_html( $testomonials_homepage['subtitle'] ) . '</h2>';
         }

         ?>
      <?php
         if ( ! empty( $testomonials_homepage['subtitle_2'] ) ) {
             echo '<h4 class="hp-subtitle">' . esc_html( $testomonials_homepage['subtitle_2'] ) . '</h2>';
         }

         ?>
      <ul class="rm-testimonial-slider">
         <?php
            foreach( $testomonials as $testomonial ) {

                $avatar   = esc_html( get_field( 'photo', $testomonial->ID ) );
                $avatar   = ( false === $avatar ) ? get_stylesheet_directory_uri() . '/assets/images/homepage/testimonial-pic.png' : $avatar;
                $name     = trim( esc_html( get_field( 'first_name', $testomonial->ID ) . ' ' . get_field( 'last_name', $testomonial->ID ) ) );
                $position = esc_html( get_field( 'title_company', $testomonial->ID ) );
                $brief_content = get_field( 'brief_testimonial', $testomonial->ID );
            ?>
         <li>
            <div class="avatar">
               <img src="<?php echo $avatar; ?>" alt="<?php echo $name; ?>" />
            </div>
            <div class="text">
               <?php echo wpautop( $brief_content ); ?>
               <p class="name"><?php echo $name; ?></p>
               <p class="title"><?php echo $position; ?></p>
            </div>
         </li>
         <?php } ?>
      </ul>
   </div>
</div>
<?php endif; ?>
<?php
   if ( ! empty( $partners ) ) :

   ?>
<div class="full-width rm-partners">
   <div class="container">
      <h4 class="hp-subtitle">Founding Supporting Partners</h4>
      <ul class="rm-homepage-partners">
         <?php
            foreach( $partners as $partner ) {
                $logo = esc_url( get_field( 'logo', $partner->ID ) );
                $name = esc_html( $partner->post_title );
                $url  = esc_url( get_field( 'homepage_or_url', $partner->ID ) );
            ?>
         <li>
            <a href="<?php echo $url; ?>" target="_blank">
            <img src="<?php echo $logo; ?>" alt="<?php echo $name; ?>" />
            </a>
         </li>
         <?php } ?>
      </ul>
   </div>
</div>
<?php endif; ?>
<?php get_footer(); ?>

