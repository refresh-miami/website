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

$author = rm_get_user_full_name( $post->post_author );
$author_permalink = bp_core_get_user_domain( $post->post_author );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( !is_single() || is_related_posts() ) { ?>
		<div class="post-inner-wrap">
	<?php } ?>

	<?php 
	if ( ( !is_single() || is_related_posts() ) && function_exists( 'buddyboss_theme_entry_header' ) ) {
		buddyboss_theme_entry_header( $post );
	} 
	?>

	<div class="entry-content-wrap featured-entry-content-wrap">
		<?php 
		$featured_img_style = buddyboss_theme_get_option( 'blog_featured_img' );

		if ( !empty( $featured_img_style ) && $featured_img_style == "full-fi-invert" ) {

			if ( is_single() && ! is_related_posts() ) { ?>
				<?php if ( has_post_thumbnail() ) { ?>
					<figure class="entry-media entry-img bb-vw-container1"><?php the_post_thumbnail( 'large' ); ?></figure>
				<?php } ?>
			<?php } ?>

			<?php
			if ( has_post_format( 'link' ) && ( !is_singular() || is_related_posts() ) ) {
				echo '<span class="post-format-icon"><i class="bb-icon-link-1"></i></span>';
			}

			if ( has_post_format( 'quote' ) && ( !is_singular() || is_related_posts() ) ) {
				echo '<span class="post-format-icon white"><i class="bb-icon-quote"></i></span>';
			}
			?>

            <?php if (!is_singular('lesson') && !is_singular('llms_assignment') ) : ?>

			<header class="entry-header"><?php
				if ( is_singular() && ! is_related_posts() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					$prefix = "";
					if( has_post_format( 'link' ) ){
						$prefix = __( '[Link]', 'buddyboss-theme' );
						$prefix .= " ";//whitespace
					}
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $prefix, '</a></h2>' );
				endif;

				if( has_post_format( 'link' ) && function_exists( 'buddyboss_theme_get_first_url_content' ) && ( $first_url = buddyboss_theme_get_first_url_content( $post->post_content ) ) != "" ) : ?>
					<p class="post-main-link"><?php echo $first_url;?></p>
				<?php endif; ?></header><!-- .entry-header -->

            <?php endif; ?>

            <?php if ( !is_singular() || is_related_posts() ) { ?>
                HELLO RIGHT HERE
				<div class="entry-content">
					<?php 
					if( empty($post->post_excerpt) ) {
						the_excerpt();
					} else {
						echo bb_get_excerpt($post->post_excerpt, 150);
					}
					?>
				</div>
			<?php } ?>

			<?php /* if ( ( isset($post->post_type) && $post->post_type === 'post' ) || ( ! has_post_format( 'quote' ) && is_singular( 'post' ) ) ) : ?>
				<?php get_template_part( 'template-parts/entry-meta' ); ?>
            <?php endif; */ ?>
            
            <div class="entry-meta">
                <div class="bb-user-avatar-wrap">
                    <div class="meta-wrap">
                        <span class="post-date" ><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo get_the_date(); ?></a></span>


                    </div>
                </div>
            </div>

		<?php } else { ?>

			<?php
			if ( has_post_format( 'link' ) && ( !is_singular() || is_related_posts() ) ) {
				echo '<span class="post-format-icon"><i class="bb-icon-link-1"></i></span>';
			}

			if ( has_post_format( 'quote' ) && ( !is_singular() || is_related_posts() ) ) {
				echo '<span class="post-format-icon white"><i class="bb-icon-quote"></i></span>';
			}
			?>

			<header class="entry-header">
                <a href="<?php echo get_permalink( $post->ID ); ?>"<?php
				if ( is_singular() && ! is_related_posts() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					$prefix = "";
					if( has_post_format( 'link' ) ){
						$prefix = __( '[Link]', 'buddyboss-theme' );
						$prefix .= " ";//whitespace
					}
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $prefix, '</a></h2>' );
				endif;
				?></a>

				<?php if( has_post_format( 'link' ) && function_exists( 'buddyboss_theme_get_first_url_content' ) && ( $first_url = buddyboss_theme_get_first_url_content( $post->post_content ) ) != "" ):?>
				<p class="post-main-link"><?php echo $first_url;?></p>
				<?php endif; ?>
			</header><!-- .entry-header -->

			<?php if ( !is_singular() || is_related_posts() ) { ?>
				<div class="entry-content">
					<?php 
					if( empty($post->post_excerpt) ) {
						the_excerpt();
					} else {
						echo bb_get_excerpt($post->post_excerpt, 150);
					}
					?>
				</div>
			<?php } ?>           

			<?php /* if ( ( isset($post->post_type) && $post->post_type === 'post' ) || ( ! has_post_format( 'quote' ) && is_singular( 'post' ) ) ) : ?>
				<?php get_template_part( 'template-parts/entry-meta' ); ?>
            <?php endif; */ ?>
            
            <div class="entry-meta">
                <div class="bb-user-avatar-wrap">
                    <div class="meta-wrap">
                        <span class="post-date" ><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo get_the_date(); ?></a></span>
                        <span><small>By <a href="<?php echo $author_permalink; ?>"><?php echo $author; ?></a></small></span>
                    </div>
                </div>
            </div>

			<?php if ( is_single() && ! is_related_posts() ) { ?>
				<?php if ( has_post_thumbnail() ) { ?>
					<figure class="entry-media entry-img bb-vw-container1">
						<?php the_post_thumbnail( 'large' ); ?>
					</figure>
				<?php } ?>
			<?php } ?>

        <?php } ?>
        
        <div class="entry-content"><?php 
					if( empty($post->post_excerpt) ) {
                        $excerpt = str_replace( '&nbsp; ', '', get_the_excerpt() );
                        echo $excerpt;
					} else {
						echo bb_get_excerpt($post->post_excerpt, 150);
					}
                    ?></div>
                    
        <div class="more-block">
                <a href="<?php echo get_permalink( $post->ID ); ?>" class="count-more">More<i class="bb-icon-angle-right"></i></a>
        </div>
		
	</div>

	<?php if ( !is_single() || is_related_posts() ) { ?>
		</div><!--Close '.post-inner-wrap'-->
	<?php } ?>

</article><!-- #post-<?php the_ID(); ?> -->

<?php if( is_single() && ( has_category() || has_tag() ) ) { ?>
	<div class="post-meta-wrapper">
		<?php if  ( has_category() ) : ?>
			<div class="cat-links">
				<i class="bb-icon-folder"></i>
				<?php _e( 'Categories: ', 'buddyboss-theme' ); ?>
				<span><?php the_category( __( ', ', 'buddyboss-theme' ) ); ?></span>
			</div>
		<?php endif; ?>

		<?php if  ( has_tag() ) : ?>
			<div class="tag-links">
				<i class="bb-icon-tag"></i>
				<?php _e( 'Tagged: ', 'buddyboss-theme' ); ?>
				<?php the_tags( '<span>', __( ', ', 'buddyboss-theme' ),'</span>' ); ?>
			</div>
		<?php endif; ?>
	</div>
<?php } ?>

<?php
// get_template_part( 'template-parts/content-subscribe' );
// get_template_part( 'template-parts/author-box' );
// get_template_part( 'template-parts/related-posts' );