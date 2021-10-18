<?php
/*
 * Template name: Dashboard Page
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BuddyBoss_Theme
 */

get_header();
?>





	<div class="entry-content">
		<div id="buddypress" class="buddypress-wrap bp-dir-hori-nav">

        <h1>Dashboard</h1>
        <h2>Welcome Back<?php echo rm_dashboard_first_name(); ?>!</h2>


		<div class="bp-wrap">




			<div class="bb-profile-grid bb-grid">
				<div id="item-body" class="item-body">

            <div class="bb-grid site-content-grid">

                <div id="primary" class="content-area bs-bp-container">
                    <main id="main" class="site-main">
                        <div class="bp-profile-content">

                        <div class="screen-content">

                            <h4>Latest News & Activity</h4>

                            <?php bp_nouveau_activity_hook( 'before_directory', 'list' ); ?>

                            <div id="activity-stream" class="activity" data-bp-list="activity">

                                    <div id="bp-ajax-loader"><?php bp_nouveau_user_feedback( 'directory-activity-loading' ); ?></div>

                            </div><!-- .activity -->

                            <?php bp_nouveau_after_activity_directory_content(); ?>

                            </div><!-- // .screen-content -->

                        </div>
                    </main>
                </div>
                <div id="secondary" class="widget-area sm-grid-1-1 sidebar-right">
                    <div class="bb-sticky-sidebar">

                    <aside id="boss-recent-posts-2" class="widsget bb_widget_recent_posts  main_bio">
					<ul class="bb-recent-posts">
												<li><h3>Keep Your Refresh Profile Updated</h3></li>
																		<li>Get recommendations, blah, blah, blah, blah, etc.</li>
											</ul>
                                        <div class="profile-item profile-success"><i class="bb-icon-check"></i> Profile<br><small>(Name, Email, etc.)</small></div>
                                        <div class="profile-item profile-warning"><i class="bb-icon-x"></i> Job Info<br><small>(Job and event recommendations)</small></div>
                                    </aside>

                                    <aside class="widget bb_widget_recent_posts">
                            <h2 class="widget-title">Your Interests: <small><a href="#">Edit</a></small></h2>
                            <p>Add interests to get matched with better events and job offerings.</p>
                            <div>
                                <ul class="skills-list tag-list tags">
                                                                        <li><a href="#">industry_1</a></li>
                                                                        <li><a href="#">industry_2</a></li>
                                                                    </ul>


                            </div>
                        </aside>


                                    <aside id="boss-recent-posts-2" class="widget bb_widget_recent_posts main_bio social_profiles">
					<h2 class="widget-title">Your Upcoming Events:</h2>
						<ul class="bb-recent-posts">
															<li>
									<a href="" title="South Florida WordPress Meetup" class="entry-media entry-img-x">
										<img src="https://refresh.miami/wp-content/uploads/group-avatars/9/5f398b4931ce5-bpfull.jpg" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy" width="35" height="35">
									</a>
									<div class="">
                                        <h4><a href="" class="bb-title">South Florida WordPress Meetup</a></h4>
                                        <span class="auto-info"><a href="">Nov. 11th - 07:00pm ET</a></span>
        							</div>
								</li>
                                                    </ul>

                                                    <h2 class="widget-title extra">Recommended Events:</h2>
						<ul class="bb-recent-posts">
															<li>
									<a href="" title="South Florida WordPress Meetup" class="entry-media entry-img-x">
										<img src="https://refresh.miami/wp-content/uploads/group-avatars/9/5f398b4931ce5-bpfull.jpg" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy" width="35" height="35">
									</a>
									<div class="">
                                        <h4><a href="" class="bb-title">South Florida WordPress Meetup</a></h4>
                                        <span class="auto-info"><a href="">Nov. 11th - 07:00pm ET</a></span>
        							</div>
								</li>
													</ul>

                </aside>





                        <aside id="boss-recent-posts-2" class="widsget bb_widget_recent_posts main_bio business">
                        <h2 class="widget-title">Career Opportunities:</h2>

                            <ul class="bb-recent-posts">

                                                                                                <li>Found 20+ Positions</li>
                                                                <li class="location">5,272 members</li>

                                                                <li>
									<a href="" title="South Florida WordPress Meetup" class="entry-media entry-img-x">
										<img src="https://refresh.miami/wp-content/uploads/group-avatars/10/5f381be2a9200-bpfull.jpg" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy" width="35" height="35">
									</a>
									<div class="">
                                        <h4><a href="" class="bb-title">Senior Web Developer</a></h4>
                                        <span class="auto-info"><a href="">Dimension Media, Inc. | Posted Nov 23, 2020</a></span>
        							</div>
                                </li>
                                <li>
									<a href="" title="South Florida WordPress Meetup" class="entry-media entry-img-x">
										<img src="https://refresh.miami/wp-content/uploads/group-avatars/10/5f381be2a9200-bpfull.jpg" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy" width="35" height="35">
									</a>
									<div class="">
                                        <h4><a href="" class="bb-title">Senior Web Developer</a></h4>
                                        <span class="auto-info"><a href="">Dimension Media, Inc. | Posted Nov 23, 2020</a></span>
        							</div>
                                </li>
                                <li>
									<a href="" title="South Florida WordPress Meetup" class="entry-media entry-img-x">
										<img src="https://refresh.miami/wp-content/uploads/group-avatars/10/5f381be2a9200-bpfull.jpg" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy" width="35" height="35">
									</a>
									<div class="">
                                        <h4><a href="" class="bb-title">Senior Web Developer</a></h4>
                                        <span class="auto-info"><a href="">Dimension Media, Inc. | Posted Nov 23, 2020</a></span>
        							</div>
                                </li>



                                                            </ul>
                        </aside>

<?php /*
                        <aside id="boss-recent-posts-2" class="widget bb_widget_recent_posts main_bio social_profiles">
					<h2 class="widget-title">People Who Share Your Interests:</h2>
						<ul class="bb-recent-posts">
														<li>
								<a href="https://refresh.miami/members/brian1/" title="Brian1 Breslin" class="entry-media entry-img-x">
																		<img src="https://refresh.miami/wp-content/uploads/avatars/15/5f5aaf26a839e-bpthumb.jpg?>" class="" alt="" loading="lazy" width="35" height="35">
								</a>
								<div class="">
									<h4><a href="https://refresh.miami/members/brian1/" class="bb-title">Brian1 Breslin</a></h4>
									<small>Miami/Fort Lauderdale Area</small>
								</div>
							</li>
													</ul>
                </aside>

                <aside id="boss-recent-posts-2" class="widget bb_widget_recent_posts main_bio social_profiles">
					<h2 class="widget-title">Join The Discussion:</h2>
						<ul class="bb-recent-posts">
														<li>

								<div class="">
									<h4><a href="https://refresh.miami/members/brian1/" class="bb-title">Test Topic</a></h4>
									<small>In: <strong>Startup Scene In South Florida</strong></small>
								</div>
							</li>
													</ul>
				</aside> */ ?>



                                                                                                <aside id="boss-recent-posts-2" class="widget bb_widget_recent_posts">
                            <h2 class="widget-title">Recent Posts Of Interest:</h2>
                                <ul class="bb-recent-posts">
                                                                                <li>
                                            <a href="https://refresh.miami/wyncode-launches-new-scholarship-program-with-knight-foundation-and-releases-jobs-report/" title="Wyncode launches new scholarship program with Knight Foundation and releases jobs report" class="entry-media entry-img">

                                                <img src="https://refresh.miami/wp-content/uploads/2020/10/wyncode-remote-150x150.png" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy">
                                            </a>
                                            <div class="">
                                                <h4><a href="https://refresh.miami/wyncode-launches-new-scholarship-program-with-knight-foundation-and-releases-jobs-report/" class="bb-title">Wyncode launches new scholarship program with Knight Foundation and releases jobs report</a></h4>
                                                <small>2020-10-01 09:28:25</small>
                                            </div>
                                        </li>
                                                                            <li>
                                            <a href="https://refresh.miami/sample-blog-post-w-meetup/" title="Sample Blog Post w/ Meetup" class="entry-media entry-img">

                                                <img src="https://refresh.miami/wp-content/uploads/2020/08/07_15_2009_10399877_115429584448_5601374_n9-150x150.jpg" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy">
                                            </a>
                                            <div class="">
                                                <h4><a href="https://refresh.miami/sample-blog-post-w-meetup/" class="bb-title">Sample Blog Post w/ Meetup</a></h4>
                                                <small>2020-09-12 21:54:35</small>
                                            </div>
                                        </li>
                                                                    </ul>
                        </aside>
                                            </div>
                </div>

            </div>

                    				</div>


							</div>

		</div><!-- // .bp-wrap -->




</div><!-- #buddypress -->
	</div><!-- .entry-content -->







<?php
get_footer();