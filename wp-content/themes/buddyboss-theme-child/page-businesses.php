<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BuddyBoss_Theme
 */

get_header();

$atts = array (
    'type' => 'business'
)

// this was sourced from buddyboss-platform/bp-templates/bp-nouveau/buddypress/groups/group-loop.php

?>

<!-- test -->

    <div id="primary" class="content-area bb-grid-cell">
        <main id="main" class="site-main">

            <article id="post-0" class="post-0 page type-page status-publish hentry">

            <header class="entry-header">
                <h1 class="entry-title">Businesses</h1>            		
            </header>

            <?php bp_group_type_short_code_callback( $atts ); ?>

                <div id="buddypress" class="buddypress-wrap bp-dir-hori-nav">

                    <div class="entry-content">
		              
                            <div class="subnav-search groups-search">
        
                                <?php /* <div class="dir-search groups-search bp-search" data-bp-search="groups">
                                    <form action="" method="get" class="bp-dir-search-form" id="dir-groups-search-form" autocomplete="off">
                                        <button type="submit" id="dir-groups-search-submit" class="nouveau-search-submit" name="dir_groups_search_submit">
                                            <span class="dashicons dashicons-search" aria-hidden="true"></span>
                                            <span id="button-text" class="bp-screen-reader-text">Search</span>
                                        </button>
                                        <label for="dir-groups-search" class="bp-screen-reader-text">Search Groups…</label>

                                        <input id="dir-groups-search" name="groups_search" type="search" placeholder="Search Groups…">

                                    </form>
                                </div> */ ?>

                            </div>
    
		
                            <?php /* <nav class="groups-type-navs main-navs bp-navs dir-navs  bp-subnavs" role="navigation" aria-label="Directory menu">
                                
                                    <ul class="component-navigation groups-nav">
                                        
                                            <li id="groups-all" class="selected" data-bp-scope="all" data-bp-object="groups">
                                                <a href="https://refresh.miami/groups/">
                                                    All Groups
                                                                                <span class="count">1</span>
                                                                        </a>
                                            </li>
                                        
                                            <li id="groups-personal" class="" data-bp-scope="personal" data-bp-object="groups">
                                                <a href="https://refresh.miami/members/dbisset/groups/my-groups/">
                                                    My Groups
                                                                                <span class="count">1</span>
                                                                        </a>
                                            </li>
                                        
                                            <li id="groups-create" class="no-ajax group-create create-button" data-bp-scope="create" data-bp-object="groups">
                                                <a href="https://refresh.miami/groups/create/">
                                                    Create a Group
                                                                        </a>
                                            </li>
                                        
                                    </ul><!-- .component-navigation -->
                                
                            </nav><!-- .bp-navs --> */?>

	    
                            <?php /* <div class="flex bp-secondary-header align-items-center">
                                <div class="push-right flex">
                                    <div class="bp-group-filter-wrap subnav-filters filters no-ajax">
                                        
                                        <div id="group-type-filters" class="component-filters clearfix">
                                            <div id="group-type-select" class="last filter">
                                                <label class="bp-screen-reader-text" for="group-type-order-by">
                                                    <span>Order By:</span>
                                                </label>
                                                <div class="select-wrap">
                                                    <select id="group-type-order-by" data-bp-group-type-filter="groups">
                                                        <option value="">All Types</option>						<option value="meetup">Meetups</option>						<option value="business">Businesses</option>						<option value="topic-group">Topic Groups</option>				</select>
                                                    <span class="select-arrow" aria-hidden="true"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
			            
                                    <div class="bp-groups-filter-wrap subnav-filters filters no-ajax">
                            
                                        <div id="dir-filters" class="component-filters clearfix">
                                            
                                            <div id="groups-order-select" class="last filter">
                                                <label class="bp-screen-reader-text" for="groups-order-by">
                                                    <span>Order By:</span>
                                                </label>
                                                <div class="select-wrap">
                                                    <select id="groups-order-by" data-bp-filter="groups">

                                                        <option value="active">Recently Active</option>
                                        <option value="popular">Most Members</option>
                                        <option value="newest">Newly Created</option>
                                        <option value="alphabetical">Alphabetical</option>

                                                    </select>
                                                    <span class="select-arrow" aria-hidden="true"></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="grid-filters" data-object="groups">
                                        <a href="#" class="layout-view layout-grid-view bp-tooltip active" data-view="grid" data-bp-tooltip-pos="up" data-bp-tooltip="
                                                                                                Grid View		"> <i class="bb-icon-grid-view-small" aria-hidden="true"></i> </a>

                                        <a href="#" class="layout-view layout-list-view bp-tooltip " data-view="list" data-bp-tooltip-pos="up" data-bp-tooltip="
                                                                                                List View		"> <i class="bb-icon-list-view-small" aria-hidden="true"></i> </a>
                                    </div>

			                    </div>
	                        </div> */ ?>


                    <?php /* if ( bp_get_current_group_directory_type() ) : ?>
                        <div class="bp-feedback info">
                        <span class="bp-icon" aria-hidden="true"></span>
                        <p class="current-group-type"><?php bp_current_group_directory_type_message(); ?></p>
                        </div>
                    <?php endif; */ ?>
                    
                    <?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) ) ) : ?>
                    
                        <?php bp_nouveau_pagination( 'top' ); ?>

                        <div class="screen-content">

                            <div id="groups-dir-list" class="groups dir-list" data-bp-list="businesses" style="display: block;">

                                <?php $cover_class = bp_disable_group_cover_image_uploads() ? 'bb-cover-disabled' : 'bb-cover-enabled'; ?>

                                <ul id="groups-list" class="<?php bp_nouveau_loop_classes(); ?> <?php echo $cover_class; ?>">
                        
                                <?php
                                while ( bp_groups() ) :
                                    bp_the_group();
                                ?>
                    
                                <li <?php bp_group_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php bp_group_id(); ?>" data-bp-item-component="groups">
                                    <div class="list-wrap">

                                        <?php if( !bp_disable_group_cover_image_uploads() ) { ?>
                                            <?php
                                            $group_cover_image_url = bp_attachments_get_attachment( 'url', array(
                                                'object_dir' => 'groups',
                                                'item_id'    => bp_get_group_id(),
                                            ) );
                                            $default_group_cover   = buddyboss_theme_get_option( 'buddyboss_group_cover_default', 'url' );
                                            $group_cover_image_url = $group_cover_image_url ?: $default_group_cover;
                                            ?>
                                            <div class="bs-group-cover only-grid-view"><a href="<?php bp_group_permalink(); ?>"><img src="<?php echo $group_cover_image_url; ?>"></a></div>
                                        <?php } ?>

                                        <?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
                                            <div class="item-avatar">
                                                <a href="<?php bp_group_permalink(); ?>" class="group-avatar-wrap"><?php bp_group_avatar( bp_nouveau_avatar_args() ); ?></a>

                                                <div class="groups-loop-buttons only-grid-view">
                                                    <?php bp_nouveau_groups_loop_buttons(); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="item">
                                            <div class="item-block">

                                                <h2 class="list-title groups-title"><?php bp_group_link(); ?></h2>

                                                <?php if ( bp_nouveau_group_has_meta() ) : ?>

                                                    <p class="item-meta group-details only-list-view"><?php bp_nouveau_group_meta(); ?></p>
                                                    <p class="item-meta group-details only-grid-view"><?php
                                                        $meta = bp_nouveau_get_group_meta();
                                                        echo $meta['status']; ?>
                                                    </p>
                                                <?php endif; ?>

                                                <p class="last-activity item-meta">
                                                    <?php
                                                    printf(
                                                        /* translators: %s = last activity timestamp (e.g. "active 1 hour ago") */
                                                        __( 'active %s', 'buddyboss-theme' ),
                                                        bp_get_group_last_active()
                                                    );
                                                    ?>
                                                </p>

                                            </div>

                                            <div class="item-desc group-item-desc only-list-view"><?php bp_group_description_excerpt( false , 150 ) ?></div>

                                            <?php bp_nouveau_groups_loop_item(); ?>

                                            <div class="groups-loop-buttons footer-button-wrap"><?php bp_nouveau_groups_loop_buttons(); ?></div>

                                            <div class="group-members-wrap only-grid-view">
                                                <?php echo buddyboss_theme()->buddypress_helper()->group_members( bp_get_group_id(), array( 'member', 'mod', 'admin' ) ); ?>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                    
                                <?php endwhile; ?>
                    
                                </ul>

                            </div>

                        </div>
               
                        <?php bp_nouveau_pagination( 'bottom' ); ?>
                    
                    <?php else : ?>
                    
                        <?php bp_nouveau_user_feedback( 'groups-loop-none' ); ?>
                    
                    <?php endif; ?>

                </div>
                    
            <?php
            bp_nouveau_after_loop();
            ?>

            </article>

        </main><!-- #main -->
    </div><!-- #primary -->


<?php
get_footer();
