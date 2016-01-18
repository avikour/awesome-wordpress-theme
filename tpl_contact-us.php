<?php /* Template Name: Contact Us Template */ ?>
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