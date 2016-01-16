<?php
    
    /**
    
    url

before executing the query ( main or secondary query ) wordpress executes filter hook called pre_get_posts which allow us to alter the query prior to execution.

main query based on url ( wordpress uses query_posts function to execute this query )

the result of main query is stored in $wp_query which is used by wordpress loop

anytime query_posts is used, it overrides $wp_query global hence it is not adviced to use it in themes/plugins


**/ 


    // Register style sheet.
    add_action( 'wp_enqueue_scripts', 'register_plugin_styles' );

    /**
     * Register style sheet.
     */
    function register_plugin_styles() {
        
        wp_enqueue_style( 'bootstrap-file', get_stylesheet_directory_uri().'/assets/css/bootstrap.css' );
        
        /** 1st step - register a css file to wp_styles global object **/
        wp_register_style( 'style-css', get_stylesheet_uri() );
        /** enquue a registered css file **/
        wp_enqueue_style( 'style-css' );

        wp_enqueue_script( 'jquery' );
        
        wp_enqueue_script( 'hover-zoom', get_stylesheet_directory_uri().'/assets/js/hover.zoom.js') ;
        
        wp_enqueue_script( 'hover-zoom-conf', get_stylesheet_directory_uri().'/assets/js/hover.zoom.conf.js') ;
        
        wp_enqueue_script( 'footer-bootstrap_file', get_stylesheet_directory_uri().'/assets/js/bootstrap.min.js',NULL,NULL,true);
        
    }

	add_action( 'after_setup_theme', 'register_theme_menu' );

	function register_theme_menu() {
		
	  add_theme_support( 'post-thumbnails' ); 	
		
	  register_nav_menu( 'main-menu', __( 'Awesome Primary Menu', 'awesome' ) );
		
 	  register_sidebar( array(
        'name' => __( 'Projects Sidebar', 'awesome' ),
        'id' => 'sidebar-projects',
        'description' => __( 'This sidebar is for projects on the home page' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
			) 
  		);
		
	  register_sidebar( array(
	  'name' => __( 'Footer Sidebar', 'awesome' ),
	  'id' => 'sidebar-footer',
	  'description' => __( 'This sidebar is for footer on the home page' ),
	  'before_widget' => '<li id="%1$s" class="widget %2$s">',
	  'after_widget'  => '</li>',
	  'before_title'  => '<h2 class="widgettitle">',
	  'after_title'   => '</h2>',
			) 
		);
	}

    function say_hello_world($default) {
        return " Hello Avneet ";
    }
    add_filter('before_navigation_uls','say_hello_world');

    
    add_action('menu_displayed', 'show_status');    
    function show_status(){
        echo "Menu Displayed !!";
    }

    
    function awesome_show_message($def_mess){
        return $def_mess." What's up World !!";
    }
    add_filter('afer_menu_tagline', 'awesome_show_message');

    function alter_home_page_posts($query) {
        if( is_home() && $query->is_main_query() ) {
            $query->set('post_type','page');
            $query->set('posts_per_page',1);
        }
        return $query;
    }
    //add_filter('pre_get_posts','alter_home_page_posts');
    
	add_action( 'init', 'create_post_type');

	function create_post_type() {
		register_post_type( 
			'players',
			array(
			  'labels' => array(
				'name' => __( 'Players' ),
				'singular_name' => __( 'Player' )
			  ),
			  'public' => true,
			  'has_archive' => true,
			)
		);
		
		register_taxonomy( 
			'team',
		  'players',
		  array(
			'label' => __( 'Teams', 'taxonomy general name' ),
			'labels' => array(
				'name' => _x( 'Teams', 'taxonomy general name'  ),
				'singular_name' => _x( 'Team' , 'taxonomy singular name'  )
			  ),  
			'rewrite' => array( 'slug' => 'Team' ),
			'hierarchical' => true
			)
		 );
   }

	add_action('add_meta_boxes', 'awesome_add_meta_boxes');
	
	function awesome_add_meta_boxes() {
		add_meta_box(
			'player_info_id', // ID 
			__('Add Player Info', 'awesome'), // Title
			'player_info', // callback function
			'players', // post - type (default/custom)
			'normal', // context
			'high' // priority
		);
	}

	function player_info($post) {
		
		global $post;
		
		wp_nonce_field( basename( __FILE__ ), 'player_info_nonce' ); ?>

		<p>
			<label for="player_age">
				<?php _e('Player Age','awesome'); ?>
			</label>
			<input type="text" name="player_age" id="player_age" value="<?php echo get_post_meta( $post->ID, 'player_age', true) ; ?>" /><br>
			
			<label for="total_matches">
				<?php _e('Total Matches','awesome'); ?>
			</label>
			<input type="text" name="total_matches" id="total_matches" value="<?php echo get_post_meta( $post->ID, 'total_matches', true); ?>" /><br>
			
			<label for="player_name">
				<?php _e('Total Runs','awesome'); ?>
			</label>
			<input type="text" name="total_runs" id="total_runs" value="<?php echo get_post_meta( $post->ID, 'total_runs', true); ?>" /><br>
			
			<label for="best_score">
				<?php _e('Best Score','awesome'); ?>
			</label>
			<input type="text" name="best_score" id="best_score" value="<?php echo get_post_meta( $post->ID, 'best_score', true); ?>" /><br>
			
			<label for="player_type">
				<?php _e('Player Type','awesome'); ?>
			</label>
			<input type="radio" name="player_type" value="batsman" <?php checked( get_post_meta( $post->ID, 'player_type', true) == "batsman"); ?> > <?php _e('Batsman','awesome'); ?><br>
  			<input type="radio" name="player_type" value="bowler" <?php checked( get_post_meta( $post->ID, 'player_type', true) == "bowler"); ?> > <?php _e('Bowler','awesome'); ?><br>
  			<input type="radio" name="player_type" value="all_rounder" <?php checked( get_post_meta( $post->ID, 'player_type', true) == "all_rounder"); ?> > <?php _e('All-Rounder','awesome'); ?><br>
		</p> <?php 
	}

	function save_player_info($post_id) {
		
		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.         
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['player_info_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['player_info_nonce'], basename( __FILE__ ) ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'players' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

		}

		/* OK, it's safe for us to save the data now. */

		// Make sure that it is set.
		if ( ! isset( $_POST ) ) {
			return;
		}
		
		$player_info['player_age'] = $_POST['player_age'];
		$player_info['total_matches'] = $_POST['total_matches'];
		$player_info['total_runs'] = $_POST['total_runs'];
	    $player_info['best_score'] = $_POST['best_score'];
		$player_info['player_type'] = $_POST['player_type'];
		
		foreach($player_info as $key => $value){	
			
			// Sanitize user input.
			$value = sanitize_text_field( $value );
			   
			// Update the meta field in the database.
			update_post_meta( $post_id, $key, $value);
		}
	
	}
	add_action('save_post','save_player_info');

?>