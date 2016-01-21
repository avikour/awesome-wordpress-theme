<?php 
    
    /**
    
    url

before executing the query ( main or secondary query ) wordpress executes filter hook called pre_get_posts which allow us to alter the query prior to execution.

main query based on url ( wordpress uses query_posts function to execute this query )

the result of main query is stored in $wp_query which is used by wordpress loop

anytime query_posts is used, it overrides $wp_query global hence it is not adviced to use it in themes/plugins


**/ 


	//include file
	include_once("shortcode.php");
	include_once("my-widget.php");


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


// ====================================== REGISTERING THEME MENU - SIDEBAR ====================================== //


	add_action( 'after_setup_theme', 'register_theme_menu' );

	function register_theme_menu() {
		
	  add_theme_support( 'post-thumbnails' ); 	
		
	  add_image_size('featured_preview', 20, 20, true);
		
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
	  'before_title'  => '<h3 class="widgettitle">',
	  'after_title'   => '</h3>',
			) 
		);
		
		register_sidebar( array(
	  'name' => __( 'Information Sidebar', 'awesome' ),
	  'id' => 'sidebar-information',
	  'description' => __( 'This sidebar is for information displayed on Posts' ),
	  'before_widget' => '<li id="%1$s" class="widget %2$s">',
	  'after_widget'  => '</li>',
	  'before_title'  => '<h4 class="widgettitle">',
	  'after_title'   => '</h4>',
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



// ====================================== CPT - TAXONOMY ====================================== //

    
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
			  'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields',
								  'comments' )
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
			'hierarchical' => true,
			)
		 );
		
		register_post_type( 
			'portfolios',
			array(
			  'labels' => array(
				'name' => __( 'Portfolios' ),
				'singular_name' => __( 'Portfolio' )
			  ),
			  'public' => true,
			  'has_archive' => true,
			  'supports' =>
				array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'comments' )
			)
		);
		
		register_taxonomy( 
			'service',
		  'portfolios',
		  array(
			'label' => __( 'Services', 'taxonomy general name' ),
			'labels' => array(
				'name' => _x( 'Services', 'taxonomy general name'  ),
				'singular_name' => _x( 'Service' , 'taxonomy singular name'  )
			  ),  
			'rewrite' => array( 'slug' => 'Service' ),
			'hierarchical' => true,
			)
		 );
		
   }

// ====================================== METABOX ====================================== //


	add_action('add_meta_boxes', 'awesome_add_meta_boxes');
	
	function awesome_add_meta_boxes() {
		add_meta_box(
			'player_info_id', // ID 
			__('Add Player Details', 'awesome'), // Title
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
			<input type="radio" name="player_type" value="Batsman" <?php checked( get_post_meta( $post->ID, 'player_type', true) == "Batsman"); ?> > <?php _e('Batsman','awesome'); ?><br>
  			<input type="radio" name="player_type" value="bowler" <?php checked( get_post_meta( $post->ID, 'player_type', true) == "Bowler"); ?> > <?php _e('Bowler','Bowler'); ?><br>
  			<input type="radio" name="player_type" value="All-Rounder" <?php checked( get_post_meta( $post->ID, 'player_type', true) == "All-Rounder"); ?> > <?php _e('All-Rounder','awesome'); ?><br>
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

	add_filter( 'template_include', 'contact_page_tpl', 99 );


// ====================================== CUSTOM TEMPLATE ====================================== //


	function contact_page_tpl( $priority ) {
		if ( is_page( 'Contact Us' )  ) {
			$new_priority = locate_template( array( 'tpl_contact-us.php' ) );
			if ( '' != $new_priority ) {
				return $new_priority ;
			}
		}

		return $priority;
	}

	add_filter( 'template_include', 'our_work_page_tpl', 99 );
	
	function our_work_page_tpl( $priority ) {
		if ( is_page( 'Our Work' )  ) {
			$new_priority = locate_template( array( 'tpl_our-work.php' ) );
			if ( '' != $new_priority ) {
				return $new_priority ;
			}
		}					

		return $priority;
	}

	
// ====================================== SETTINGS PAGE ====================================== //


	function more_settings_page(){
		?>
	    <div class="wrap">
	    <h1>More Theme Settings</h1>
	    <form method="post" action="options.php">
	        <?php
				// Output nonce, action, and option_page fields for settings page
	            settings_fields("section"); // The section ID or settings group name
				// Print out all settings sections added to the settings page. 
	            do_settings_sections("more-options"); // Slug name of page  
	            // Echo a submit button
				submit_button(); // 
	        ?>          
	    </form>
		</div>
	<?php
	}

	function awesome_add_theme_menu()
	{
		
		add_menu_page("More Settings", // page title
					  "More Theme Settings", // menu name
					  "manage_options", // capability
					  "more-settings", // menu slug
					  "more_settings_page", // callback function
					  null, // icon url
					  99); // position / priority
	}

	add_action("admin_menu", "awesome_add_theme_menu");

	function display_twitter_element()
	{
		?>
			<input type="text" name="twitter_url" id="twitter_url" 
				   value="<?php echo get_option('twitter_url'); ?>" />
		<?php
	}

	function display_facebook_element()
	{
		?>
			<input type="text" name="facebook_url" id="facebook_url" 
				   value="<?php echo get_option('facebook_url'); ?>" />
		<?php
	}

	function display_layout_option()
	{
		?>
			<input type="checkbox" name="layout_option" 
				   value="1" <?php checked(1, get_option('layout_option'), true); ?> /> 
		<?php
	}

	function display_logo()
	{
		?>
			<input type="file" name="logo" /> 
			<?php echo get_option('logo'); ?>
	   <?php
	}

	function handle_logo_upload()
	{
		if(!empty($_FILES["demo-file"]["tmp_name"]))
		{
			$urls = wp_handle_upload($_FILES["logo"], // file
									 array('test_form' => FALSE) // overrides
									);
			$temp = $urls["url"];
			return $temp;   
		}

		return $option;
	}

	function display_more_settings_fields()
	{
		// Display the section heading and description
		add_settings_section("section", // section ID or option group
							 "Additional Settings", // section name
							  null, // callback function
							 "more-options"); // The menu page on which to display this section.

		
		// Display the HTML code of the fields
		add_settings_field("twitter_url", //option name in Database
						   "Twitter Profile Url", // Title of field
						   "display_twitter_element", //a callback function
						   "more-options", // The menu page on which to display this section.
						   "section");  // section ID
		
		add_settings_field("facebook_url", "Facebook Profile Url", "display_facebook_element", "more-options", "section");

		add_settings_field("layout_option", "Do you want the layout to be responsive?", "display_layout_option", "more-options", "section");
		
		add_settings_field("logo", "Logo", "display_logo", "more-options", "section");  

    
		// Automate saving the values of the fields
		register_setting("section",   // option group
						 "twitter_url"); // option name
		
		register_setting("section", "facebook_url");
		
		register_setting("section", "layout_option");
		
		register_setting("section", "logo", "handle_logo_upload" /** call back function **/ );

		
	}

	add_action("admin_init", "display_more_settings_fields");


// ====================================== ADMIN CUSTOMIZATIONS ====================================== //

	
	// Update meta values
		function player_type_update(){

		// The Query
		$args = array ( 'post_type' => 'players',
					   'posts_per_page' => -1 // -1 means all 
					  );
		$the_query = new WP_Query( $args );

		// The Loop
		while ( $the_query->have_posts() ) :
			$the_query->the_post();

			$value = 'player_type';
			$get_value = get_post_meta( get_the_ID(), $value, true);
			$new_value = str_replace('bowler', 'Bowler', $get_value);
			update_post_meta(get_the_ID(), $value, $new_value);

		endwhile;
	} 
	//add_action('admin_init', 'player_type_update');


	// ADD NEW COLUMN IN POSTS AND PAGES FOR FEATURED IMAGE
	function awesome_new_column($default) {
		
		$default['featured_image'] = 'Featured Image';
		
		return $default;
	}
	add_filter('manage_posts_columns', 'awesome_new_column');
	add_filter('manage_page_posts_columns', 'awesome_new_column', 10);

	// GET FEATURED IMAGE
	function awesome_get_featured_image($post_ID) {
		
		$post_thumbnail_id = get_post_thumbnail_id($post_ID);
		if ($post_thumbnail_id) {
			$post_thumbnail_image = wp_get_attachment_image_src($post_thumbnail_id, 'thumbnail');
			return $post_thumbnail_image[0];
		}
	}

	// SHOW THE FEATURED IMAGE
	function new_column_content($column_name, $post_ID) {
		
		if ($column_name == 'featured_image') {
			$post_featured_image = awesome_get_featured_image($post_ID);
			if ($post_featured_image) {
				echo '<img src="' . $post_featured_image . '" />';
			}
		}
	}
	add_action('manage_posts_custom_column', 'new_column_content', 10, 2);
	add_action('manage_page_posts_custom_column', 'new_column_content', 10, 2);


	// ADD NEW COLUMNS IN PLAYERS POST TYPE
	function awesome_new_column_players($default) {
		$default['total_runs'] = 'Total Runs';
		$default['age'] = 'Age';

		return $default;
	}
	add_filter('manage_players_posts_columns', 'awesome_new_column_players', 10);

	
	// SHOW NEW CONTENT IN PLAYERS
	function new_column_content_players($column_name, $post_ID) {
		
		if ($column_name == 'total_runs') {
			
			$player_total_runs = get_post_meta($post_ID, 'total_runs', true);
			if ($player_total_runs) {
				echo $player_total_runs;
			}
		}
		if ($column_name == 'age') {
			$player_age = get_post_meta($post_ID, 'player_age', true);
			if ($player_age) {
				echo $player_age;
			}
		}
	}
	add_action('manage_players_posts_custom_column', 'new_column_content_players', 10, 2);


	// REMOVE COLUMNS
	function remove_columns($default) {
		
		unset( $default['author'], $default['comments']);
		
		return $default;
	}
	add_filter('manage_players_posts_columns', 'remove_columns');

?>