<?php get_header(); ?>
<!-- +++++ Welcome Section +++++ -->
	<div id="ww">
	    <div class="container">
            <?php
                $secondary_query = new WP_Query( array('post_type'    =>  'page'));
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
			
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post(); 
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
			
				 $secondary_query = new WP_Query( array('post_type'    =>  'players'));
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
	</div> <!-- /container -->
</div><!-- /ww -->

	
	<!-- +++++ Projects Section +++++ -->
	<?php get_sidebar() ?>
		
<!-- +++++ Footer Section +++++ -->
<?php get_footer(); ?>