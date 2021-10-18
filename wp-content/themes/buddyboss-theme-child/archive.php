<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BuddyBoss_Theme
 */

get_header('default-revised');

$featured_job_openings = get_field( 'featured_job_openings', 'option' );

$featured_jobs         = ( function_exists('rm_get_featured_jobs') ) ? rm_get_featured_jobs( 2 ) : false;
   $homepage_jobs         = ( function_exists('rm_get_homepage_jobs') ) ? rm_get_homepage_jobs( 10 ) : false;
   $super_featured_jobs   = ( function_exists('rm_get_super_featured_jobs') ) ? rm_get_super_featured_jobs( 10 ) : false;
   $featured_events       = ( function_exists('rm_get_featured_events') ) ? rm_get_featured_events( 2 ) : false;
   $homepage_events       = ( function_exists('rm_get_events') ) ? rm_get_events( 5 ) : false;

$queried_object  = get_queried_object();
$current_term_id = $queried_object->term_id;

$categories            = ( function_exists('rm_get_featured_categories') ) ? rm_get_featured_categories( 'name', false ) : false;
$tags                  = ( function_exists('rm_get_featured_tags') ) ? rm_get_featured_tags( 'name', false ) : false;

?>

<div class="container">
   <div id="hp-news-events" class="hp-news-events">
      <div class="hp-news-events-container bb-grid site-content-grid">
         <div id="hp-news-main" class="hp-news-main content-area bs-bp-container">

         <?php if ( have_posts() ) : ?>
			<header class="page-header">
				<?php
				// the_archive_title( '<h1 class="page-title">', '</h1>' );
				// the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->


			<div class="post-grid <?php echo esc_attr( $class ); ?>">

				<?php if ( 'masonry' === $blog_type ) { ?>
					<div class="bb-masonry-sizer"></div>
				<?php } ?>

				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', apply_filters( 'bb_blog_content', get_post_format() ) );

				endwhile;
				?>
			</div>

			<?php
			buddyboss_pagination();

		else :
			get_template_part( 'template-parts/content', 'none' );
			?>

		<?php endif; ?>


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
                         $event_cost = isset( $meta['_EventCost'][0] ) ? $meta['_EventCost'][0] : '';
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


<?php get_footer(); ?>

