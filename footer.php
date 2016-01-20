	<!-- +++++ Footer Section +++++ -->
	
	<div id="footer">
		<div class="container">
			<?php if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
				<?php dynamic_sidebar( 'sidebar-footer' ); ?>
				<?php endif; ?>
			<?php
				$layout = get_option('theme_layout');
				$facebook_url = get_option('facebook_url');
				$twitter_url = get_option('twitter_url'); ?>
		</div>
		
	</div>
	
    <?php wp_footer(); ?>
  </body>
</html>