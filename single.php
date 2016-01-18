<?php get_header(); ?>

	<!-- +++++ Welcome Section +++++ -->
	<div id="ww">
	    <div class="container">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2 centered">
					<?php
						
						if ( have_posts() ) {
							while ( have_posts() ) {
								the_post(); 
								the_post_thumbnail('thumbnail');
								the_title( '<h1>', '</h1>' );
								the_content();
								//
								<?php echo get_post_meta( $post->ID, 'total_runs', true); ?>
								//
							} // end while
						} // end if
					?>
					
				</div><!-- /col-lg-8 -->
			</div><!-- /row -->
	    </div> <!-- /container -->
	</div><!-- /ww -->
	
	
	<!-- +++++ Information Section +++++ -->
	
	<div class="container pt">
<?php 
		if ( is_active_sidebar( 'sidebar-information' ) ) : ?>
				<?php dynamic_sidebar( 'sidebar-information' ); ?>
				<?php endif;
?>
	</div><!-- /container -->
	
<?php 
    get_footer();
?>