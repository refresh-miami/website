

<?php
   /*
    * Template name: News (Revised)
    * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
    *
    * @package BuddyBoss_Theme
    */

   get_header('news');

   // get all variables for homepage.

   $primary_headline      = get_field( 'primary_headline', 'option' );
   $primary_tagline       = get_field( 'primary_tagline', 'option' );
   $groups_visibility     = get_field( 'groups_visibility', 'option' );
   $big_three             = get_field( 'big_three', 'option' );
   $why_join_homepage     = get_field( 'why_join_homepage', 'option' );
   $download_app_section  = get_field( 'download_app_section', 'option' );
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
   $categories            = ( function_exists('rm_get_featured_categories') ) ? rm_get_featured_categories( 'name', false ) : false;
   $tags                  = ( function_exists('rm_get_featured_tags') ) ? rm_get_featured_tags( 'name', false ) : false;

   add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes() {
  return 'class="styled-button"';
}


// $homepage_jobs         = ( function_exists('rm_get_homepage_jobs') ) ? rm_get_homepage_jobs( 10 ) : false;
// $super_featured_jobs   = ( function_exists('rm_get_super_featured_jobs') ) ? rm_get_super_featured_jobs( 10 ) : false;

// echo '------'; print_r($featured_jobs);
// echo '------'; print_r($featured_events);

// $featured_jobs = $homepage_jobs;




   ?>



   <div class="container">


   <div id="hp-news-events" class="hp-news-events">
      <div class="hp-news-events-container bb-grid site-content-grid">
         <div id="hp-news-main" class="hp-news-main content-area bs-bp-container">

            <div id="hp-news" class="hp-news content-area bs-bp-container">
               <?php

                     // Define custom query parameters
                     $custom_query_args = array( /* Parameters go here */ );

                     $custom_query_args = array(
                        'post_type'      => 'post',
                        'posts_per_page' => $limit,
                        'category'       => array( 1413, 47 ),
                        'exclude'        => $excluded_ids,
                        'order'          => 'DESC',
                        'orderby'        => 'date'
                     );

                     // Get current page and append to custom query parameters array
                     $custom_query_args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

                     // Instantiate custom query
                     $custom_query = new WP_Query( $custom_query_args );

                     // Pagination fix
                     $temp_query = $wp_query;
                     $wp_query   = NULL;
                     $wp_query   = $custom_query;

                     // Output custom query loop
                     if ( $custom_query->have_posts() ) :
                        while ( $custom_query->have_posts() ) :
                           $custom_query->the_post();
                           // Loop output goes here

                           $news_item = get_post( get_the_ID() );

                           $permalink = get_permalink( $news_item->ID );
                           $date = date('M d, Y', strtotime( $news_item->post_date ) );
                           // $post_author = get_the_author_meta( 'nicename', $featured_news_item->post_author );
                           $featured_image_url = get_the_post_thumbnail_url( $news_item->ID, 'large' );
                           $featured_tags = get_field('feature_tags', $news_item->ID );

                           ?>

                           <article id="post-<?php echo $news_item->ID; ?>" class="post-<?php echo $news_item->ID; ?>">
                              <div class="post-inner-wrap">
                                 <div class="ratio-wrap">
                                    <a href="<?php echo $permalink; ?>" title="<?php echo $news_item->post_title; ?>" class="entry-media entry-img">
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
                                             <span class="post-date"><a href="<?php echo $permalink; ?>"><?php echo rm_relative_time( strtotime( $news_item->post_date ) ); ?></a>
                                                <?php
                                                   if ( ! empty( $featured_tags ) ) :
                                                ?>
                                                <small>&nbsp;&nbsp;&nbsp;
                                                   <?php
                                                      $counter = 1;
                                                      foreach( $featured_tags as $featured_tag ) :
                                                         echo '<a href="' . get_term_link( $featured_tag->term_id ) . '">' . $featured_tag->name . '</a>';
                                                         if ( count( $featured_tags ) > $counter ) {
                                                            echo ', ';
                                                         }
                                                         $counter++;
                                                      endforeach;
                                                   ?>
                                                <?php endif; ?>
                                             </small>
                                             </span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!--Close '.post-inner-wrap'-->
                           </article>

                           <?php

                        endwhile;
                     endif;
                     // Reset postdata
                     wp_reset_postdata();

                     echo '<div class="rm-pagination">';
                     // Custom query loop pagination
                     previous_posts_link( 'Newer News »' );
                     next_posts_link( '« Older News', $custom_query->max_num_pages );
                     echo '</div>';

                     // Reset main query object
                     $wp_query = NULL;
                     $wp_query = $temp_query;


                 /*  $homepage_news = ( function_exists('rm_get_homepage_news') ) ? rm_get_homepage_news( 8, $featured_news_ids ) : false;
                     if ( false !== $homepage_news ) :
                         foreach ( $homepage_news as $news_item ) {
                              $permalink = get_permalink( $news_item->ID );
                              $date = date('M d, Y', strtotime( $news_item->post_date ) );
                              // $post_author = get_the_author_meta( 'nicename', $featured_news_item->post_author );
                              $featured_image_url = get_the_post_thumbnail_url( $news_item->ID, 'large' );
                              $featured_tags = get_field('feature_tags', $news_item->ID );
                     ?>
                        <article id="post-<?php echo $news_item->ID; ?>" class="post-<?php echo $news_item->ID; ?>">
                           <div class="post-inner-wrap">
                              <div class="ratio-wrap">
                                 <a href="<?php echo $permalink; ?>" title="<?php echo $news_item->post_title; ?>" class="entry-media entry-img">
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
                                          <span class="post-date"><a href="<?php echo $permalink; ?>"><?php echo rm_relative_time( strtotime( $news_item->post_date ) ); ?></a>
                                             <?php
                                                if ( ! empty( $featured_tags ) ) :
                                             ?>
                                             <small>&nbsp;&nbsp;&nbsp;
                                                <?php
                                                   $counter = 1;
                                                   foreach( $featured_tags as $featured_tag ) :
                                                      echo '<a href="' . get_term_link( $featured_tag->term_id ) . '">' . $featured_tag->name . '</a>';
                                                      if ( count( $featured_tags ) > $counter ) {
                                                         echo ', ';
                                                      }
                                                      $counter++;
                                                   endforeach;
                                                ?>
                                             <?php endif; ?>
                                          </small>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!--Close '.post-inner-wrap'-->
                        </article>
                        <?php *}
                     endif; */ ?>
            </div>
         </div>

         <div class="content-area bs-bp-container sidebar-container">

            <div id="search-news" class="hp-content border-bottom search-news">

                  <!-- s=softbank&bp_search=1&view=content -->

               <?php

               if ( !empty( $categories['sidebars'] ) ) :

               ?>

               <h5>Categories</h5>

               <ul class="categories">
                 <?php foreach ( $categories['sidebars'] as $category_id => $category_info ) : ?>
                     <li><a href="<?php echo $category_info['link']; ?>"><?php echo $category_info['name']; ?></a></li>
                  <?php endforeach; ?>
               </ul>

               <?php endif; ?>

               <h5>Search</h5>

                  <form method="get" action="<?php echo home_url(); ?>" class="rm-news-form">

                     <div class="rm--search">
                        <input type="text" class="input" name="s[]" placeholder="Search News..." />
                        <button type="default"><i class="bb-icon-search"></i></button>
                        <?php /* <input type="hidden" name="view" value="content" />
                        <input type="hidden" name="bp_search" value="1" />
                        <input type="hidden" name="subset" value="posts" /> */ ?>
                     </div>


<?php /*
               <div id="tribe_events_filters_wrapper" class="tribe-events-filters-vertical tribe-clearfix">
                  <div class="tribe-events-filters-content tribe-clearfix">

                        <form id="tribe_events_filters_form" method="post" action="">
                           <?php

                           if ( !empty( $tags['dropdowns']['type'] ) ) :

                           ?>
                           <fieldset>
                              <legend class="collapsible-legend">Type</legend>
                              <div class="collapsible-fieldset closed">
                                 <select name="s[]">
                                    <option value=""></option>
                                    <?php foreach ( $tags['dropdowns']['type'] as $tag_id => $tag_info ) : ?>
                                       <option value="<?php echo $tag_info['slug']; ?>"><?php echo $tag_info['name']; ?></option>
                                    <?php endforeach; ?>
                                 </select>
                              </div>
                           </fieldset>
                           <?php

                           endif;

                           ?>
                           <?php

                              if ( !empty( $tags['dropdowns']['topic'] ) ) :

                           ?>
                           <fieldset>
                              <legend class="collapsible-legend">Topic</legend>
                              <div class="collapsible-fieldset closed">
                                 <select name="s[]">
                                       <option value=""></option>
                                    <?php foreach ( $tags['dropdowns']['topic'] as $tag_id => $tag_info ) : ?>
                                       <option value="<?php echo $tag_info['slug']; ?>"><?php echo $tag_info['name']; ?></option>
                                    <?php endforeach; ?>
                                 </select>
                              </div>
                           </fieldset>
                           <?php

                           endif;

                           ?>
                           <?php

                              if ( !empty( $tags['dropdowns']['industry'] ) ) :

                           ?>
                           <fieldset>
                              <legend class="collapsible-legend">Industry</legend>
                              <div class="collapsible-fieldset closed">
                                 <select name="s[]">
                                    <option value=""></option>
                                    <?php foreach ( $tags['dropdowns']['industry'] as $tag_id => $tag_info ) : ?>
                                       <option value="<?php echo $tag_info['slug']; ?>"><?php echo $tag_info['name']; ?></option>
                                    <?php endforeach; ?>
                                 </select>
                              </div>
                           </fieldset>
                           <?php

                           endif;

                           ?>
                        <?php <input type="submit" value="Submit" class="tribe_events_filters_form_submit" tabindex="-1"> ?>
                        </form>
                  </div>
               </div> */ ?>

               </form>

               <?php /*

                  <hr />

                  <h2>Filters</h2>

                  <div class="filters">

                     <div class="filter">

                        <h3>Categories</h3>

                        <?php

                        // grab categories that are marked by ACF.
                        $terms = get_terms( 'category', array(
                           'hide_empty' => false,
                        ) );

                        $queried_object = get_queried_object();
                        $current_term_id = $queried_object->term_id;

                        echo '<select id="news-category-dd" class="news-category-dd">';
                        $selected = ( empty( $current_term_id ) ) ? 'selected="selected"' : false;
                        echo '<option value="" ' . $selected .' ></option>';

                        foreach ( $terms as $term ) {

                           $show = get_field('show_in_news_search_dropdowns', $term->taxonomy . '_' . $term->term_id);

                           if ( ! empty( $show ) ) {
                              $term_link = get_term_link( $term );
                              $selected  = ( ! empty( $current_term_id ) && $current_term_id === $term->id ) ? 'selected="selected"' : false;
                              echo '<option value="' . $term_link . '" ' . $selected .'>' . $term->name . '</option>';
                           }

                        }
                        echo '</select>';

                        ?>

                     </div>

                     <div class="filter">

                        <h3>Tags</h3>

                        <?php

                        // grab categories that are marked by ACF.
                        $terms = get_terms( 'post_tag', array(
                           'hide_empty' => false,
                        ) );

                        echo '<select id="news-tag-dd" class="news-tag-dd">';
                        echo '<option value=""></option>';

                        foreach ( $terms as $term ) {

                           $show = get_field('show_in_news_search_dropdowns', $term->taxonomy . '_' . $term->term_id);

                           if ( ! empty( $show ) ) {
                              $term_link = get_term_link( $term );
                              echo '<option value="' . $term_link . '">' . $term->name . '</option>';
                           }

                        }
                        echo '</select>';

                        ?>

                     </div>

                     <div class="filter">

                        <h3>Date</h3>

                        <?php

                        // grab categories that are marked by ACF.
                        $terms = get_terms( 'post_tag', array(
                           'hide_empty' => false,
                        ) );

                        echo '<select id="news-tag-dd" class="news-tag-dd">';
                        echo '<option value=""></option>';
                        echo '<option value="1-week">Past 7 Days</option>';
                        echo '<option value="1-month">Past Month</option>';
                        echo '<option value="1-year">Past Year</option>';
                        echo '</select>';

                        ?>

                     </div>

                  </div> */ ?>

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

            <div id="hp-events" class="content-area bs-bp-container">
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
<?php if ( isset( $download_app_section['enable'] ) && $download_app_section['enable'] ) : ?>
<div class="full-width download-app-section">
   <div class="container">
      <div class="content-area">
         <div class="promotional-copy">
            <?php
                if ( ! empty( $download_app_section['title'] ) ) {
                    echo '<h2 class="hp-title">' . esc_html( $download_app_section['title'] ) . '</h2>';
                }

                ?>
            <?php
                if ( ! empty( $download_app_section['subtitle'] ) ) {
                    echo '<h4 class="hp-subtitle">' . esc_html( $download_app_section['subtitle'] ) . '</h2>';
                }

                ?>
            <?php
                if ( ! empty( $download_app_section['promotional_copy'] ) ) {
                  echo '<div class="actual-copy">' . wpautop( $download_app_section['promotional_copy'] ) .'</div>';
                }

                ?>
               <?php /* <div class="app-store">
                  <a href="/"><img src="/wp-content/themes/buddyboss-theme-child/assets/images/footer/app-store-1.gif"></a>
                  <a href="/"><img src="/wp-content/themes/buddyboss-theme-child/assets/images/footer/app-store-2.gif"></a>
               </div> */ ?>
         </div>
         <div class="promotional-image">
            <img src="<?php echo $download_app_section['hero_image']; ?>" alt="<?php echo esc_html( $download_app_section['title'] ); ?>" />
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

