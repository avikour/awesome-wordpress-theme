<?php get_header(); ?>

	<!-- +++++ Welcome Section +++++ -->
	<div id="ww">
	    <div class="container">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2 centered">
					
					<table>
						<tr>
							<td> <?php _e('Player Name', 'awesome') ?> </td>
							<td> <?php _e('Player Age', 'awesome') ?> </td> 
							<td> <?php _e('Total Matches', 'awesome') ?> </td>
							<td> <?php _e('Total Runs', 'awesome') ?> </td>
							<td> <?php _e('Best Score', 'awesome') ?> </td>
							<td> <?php _e('Player Type', 'awesome') ?> </td>
						</tr>
					
					<?php
						
						if ( have_posts() ) {
							while ( have_posts() ) {
								the_post(); 
								the_post_thumbnail('thumbnail');
								the_title( '<h1>', '</h1>' );
								the_content(); ?>
					
						
						<tr> 
							<td> <?php the_title(); ?> </td>
							<td> <?php echo get_post_meta($post->ID, 'player_age', true) ?> </td> 
							<td> <?php echo get_post_meta($post->ID, 'total_matches', true) ?> </td>
							<td> <?php echo get_post_meta($post->ID, 'total_runs', true) ?> </td>
							<td> <?php echo get_post_meta($post->ID, 'best_score', true) ?> </td>
							<td> <?php echo get_post_meta($post->ID, 'player_type', true) ?> </td>
						</tr>
					</table>
					
					<?php
							} // end while
						} // end if
					?>
					
				</div><!-- /col-lg-8 -->
			</div><!-- /row -->
	    </div> <!-- /container -->
	</div><!-- /ww -->
	
	
	<!-- +++++ Information Section +++++ -->
	
	
	
<?php 
    get_footer();
?>