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
		register_post_type( 'players',
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
