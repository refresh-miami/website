<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BuddyBoss_Theme
 */
?>

<?php
global $post;

$date               = date('M d, Y', strtotime() );
$featured_image_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
$featured_tags      = get_field('feature_tags', get_the_ID() );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
   <div class="post-inner-wrap">
      <div class="ratio-wrap">
         <a href="<?php echo $permalink; ?>" title="<?php the_title(); ?>" class="entry-media entry-img">
         <img src="<?php echo $featured_image_url; ?>" class="attachment-large size-large wp-post-image" alt="" loading="lazy"  width="640" height="489"></a>
      </div>
      <div class="entry-content-wrap featured-entry-content-wrap">
         <header class="entry-header">
            <h2 class="entry-title"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h2>
         </header>
         <!-- .entry-header -->
         <div class="entry-meta">
            <div class="bb-user-avatar-wrap">
               <div class="meta-wrap">
                  <span class="post-date"><a href="<?php echo $permalink; ?>"><?php echo rm_relative_time( strtotime(  get_the_date() ) ); ?></a>
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

