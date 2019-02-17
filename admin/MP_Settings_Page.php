<?php

require_once ( plugin_dir_path( __FILE__ ) . '/MP_Config.php');

class MP_Settings_Page{

    use MP_Config;

    private $page_template;    

    private static $_instance = null;


    private function __construct(){
      
        $this->page_template  = plugin_dir_path( __FILE__ ) . '/page-template/admin-page.html';

        $this->config_init();
        $this->add_inline_data();
                
        $this->register_options();
        $this->create_settings_page();
        $this->register_rest();

    }

    private function add_inline_data(){
        
        add_action( 'admin_enqueue_scripts', function(){
            wp_enqueue_script( 'mp-script', plugins_url( '/js/admin.js', __FILE__ ), array(), false, true );
      
            wp_localize_script(
            'mp-script',
            'mp_options_data',
            array(
               'nonce'   => wp_create_nonce( 'wp_rest' ),
               'siteUrl' => get_site_url(),
               'options' => get_option( $this->options_name, $this->default_options ),
            ));


        });
    }
    
    
    private function add_scripts(){
        
        add_action( 'admin_enqueue_scripts', function(){
            wp_enqueue_script( 'vue', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js', array(), false, true );
            wp_enqueue_script( 'vuex', 'https://cdnjs.cloudflare.com/ajax/libs/vuex/3.1.0/vuex.min.js', array('vue'), false, true );   
            wp_enqueue_script( 'vuetify', 'https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js', array('vue'), false, true );
            wp_enqueue_script( 'mp-admin-script', plugins_url( '/page-template/admin-script.js', __FILE__ ), array('vue', 'vuex', 'vuetify', 'jquery'), false, true );
                  
            wp_enqueue_style( 'vuetify-icons', 'https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons', false );
            wp_enqueue_style( 'vuetify-style', "https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" );
            wp_enqueue_style( 'mp-admin-style', plugins_url( '/page-template/css/admin-style.css', __FILE__ ) );
        });
    }
 

    private function register_options(){
       
        add_action( 'admin_init', function(){
            register_setting( 
                $this->options_name . '_group', 
                $this->options_name, 
                function( $options ){
                    foreach( $options as $name => & $val ){
                        $val = strip_tags( $val );
                    };
                    return $options;
                },
                'intval'
            ); 
        });
   }
  
    private function create_settings_page(){

        add_action( 'admin_menu', function(){
            
            $page_title = "";
            $menu_title = $this->menu_name;
            $capability = "manage_options";
            $menu_slug  = "mp_settings";

            $menu_location = "options-general.php";

            // another locations

            // $menu_location = "tools.php";
            // $menu_location = "edit.php";
            // $menu_location = "edit.php?post_type=page";

            $page = add_submenu_page( 
                $menu_location, 
                $page_title, 
                $menu_title, 
                $capability, 
                $menu_slug, 
                function(){
                    require_once $this->page_template;
                }
            );
    
            // load styles on the settings page only
            add_action('load-'. $page, function(){
                $this->add_scripts();
            });
        });
    }


    /**
     * Add REST 
     */

    private function register_rest(){
        
        add_action( 'rest_api_init', function() {
            register_rest_route(
                'mp/v2',
                '/options',
                array(
                    'methods' => 'POST',
                    'callback' => function() {
                        update_option( $this->options_name, $this->sanitize_options() );
                       die(1);
                    },
                ) 
            );
        } );
    } 
    
    private function sanitize_options(){
        $result = array();
        foreach ( $this->default_options as $key => $value ){
            if ( isset($_POST[$key]) ){
                $result += [ $key => esc_html( $_POST[$key] ) ];
            };
        };
        return $result;
    }

    public static function getInstance()
	{
		if (self::$_instance != null) {
			return self::$_instance;
		}

		return new self;
	}

    private function __clone () {}
	private function __wakeup () {}
}









