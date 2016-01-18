<?php /* Template Name: Our Work Template */ ?>
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
								// Post Content here
								//
							} // end while
						} // end if
			
					$secondary_query = new WP_Query( array('post_type'    =>  'portfolios'));
					if ( $secondary_query->have_posts() ) {
						while ( $secondary_query->have_posts() ) {
							$secondary_query->the_post(); 
								echo '
									<div class="row">
										<div class="col-lg-8 col-lg-offset-2 centered">
								';
								the_post_thumbnail('thumbnail');
								echo '
								<h1>
									<a href="'.get_permalink().'">
										'.get_the_title().'
									</a>
								</h1>';
								the_excerpt();
								echo '
										</div>
									</div>
								';
							} // end while
						} // end if


				?>
					
					
					
					
				</div><!-- /col-lg-8 -->
			</div><!-- /row -->
	    </div> <!-- /container -->
	</div><!-- /ww -->

	<!-- +++++ Projects Section +++++ -->
<?php 
    get_sidebar();
?>

	<!-- +++++ Footer Section +++++ -->
<?php 
    get_footer();
?>