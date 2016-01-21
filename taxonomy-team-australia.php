<?php get_header(); ?>

<!-- +++++ Welcome Section +++++ -->
	<div id="ww">
	    <div class="container">
            <?php
				echo '
							<div class="row">
								<div class="col-lg-8 col-lg-offset-2 centered">
						';
				$team_names = get_the_terms($post->ID, 'team');
				foreach ( $team_names as $team_name ) {
					echo '<h1>'.$team_name->name.'</h1>';
				}
					
				//echo do_shortcode('[say_hi name="Prince"]');
			
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post(); 
						
						the_post_thumbnail('thumbnail');
						echo '
						<h2>
							<a href="'.get_permalink().'">
								'.get_the_title().'
							</a>
						</h2>';
						the_excerpt();
						
					} // end while
				} // end if
				echo '

									</div>
								</div>
							';
				?>
	</div> <!-- /container -->
</div><!-- /ww -->
	
	<!-- +++++ Projects Section +++++ -->
	<?php get_sidebar() ?>
		
<!-- +++++ Footer Section +++++ -->
<?php get_footer(); ?>