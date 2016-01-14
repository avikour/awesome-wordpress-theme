	<!-- +++++ Footer Section +++++ -->
	
	<div id="footer">
		<div class="container">
			<?php if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
				<?php dynamic_sidebar( 'sidebar-footer' ); ?>
				<?php endif; ?>
		</div>
	</div>
	
    <?php wp_footer(); ?>
  </body>
</html>