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
            ?>
	    </div> <!-- /container -->
	</div><!-- /ww -->
	
	
	<!-- +++++ Projects Section +++++ -->
	
	<div class="container pt">
		<div class="row mt centered">	
			<div class="col-lg-4">
				<a class="zoom green" href="work01.html"><img class="img-responsive" src="assets/img/portfolio/port01.jpg" alt="" /></a>
				<p>APE</p>
			</div>
			<div class="col-lg-4">
				<a class="zoom green" href="work01.html"><img class="img-responsive" src="assets/img/portfolio/port02.jpg" alt="" /></a>
				<p>RAIDERS</p>
			</div>
			<div class="col-lg-4">
				<a class="zoom green" href="work01.html"><img class="img-responsive" src="assets/img/portfolio/port03.jpg" alt="" /></a>
				<p>VIKINGS</p>
			</div>
		</div><!-- /row -->
		<div class="row mt centered">	
			<div class="col-lg-4">
				<a class="zoom green" href="work01.html"><img class="img-responsive" src="assets/img/portfolio/port04.jpg" alt="" /></a>
				<p>YODA</p>
			</div>
			<div class="col-lg-4">
				<a class="zoom green" href="work01.html"><img class="img-responsive" src="assets/img/portfolio/port05.jpg" alt="" /></a>
				<p>EMPERORS</p>
			</div>
			<div class="col-lg-4">
				<a class="zoom green" href="work01.html"><img class="img-responsive" src="assets/img/portfolio/port06.jpg" alt="" /></a>
				<p>CHIEFS</p>
			</div>
		</div><!-- /row -->
	</div><!-- /container -->
	
<?php get_footer(); ?>