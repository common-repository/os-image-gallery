<?php
/*
Plugin Name: OS Image Gallery
Plugin URI: http://offshorent.com/blog/extensions/os-image-gallery
Description: Creates a responsive image gallery using OS Image Gallery. WordPress plugin develop by Offshorent Softwares Pvt Ltd.
Version: 1.3
Author: Offshorent Softwares Pvt Ltd | Jinesh.P.V.
Author URI: http://offshorent.com/
License: GPL2
/*  Copyright 2015-2019  OS Image Gallery - Offshorent Softwares Pvt Ltd  ( email: jinesh@offshorent.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'osImageGallery' ) ) :
    
    /**
    * Main osImageGallery Class
    *
    * @class osImageGallery
    * @version	1.3
    */

	    final class osImageGallery {
	    
		/**
		* @var string
		* @since	1.3
		*/
		 
		public $version = '1.3';

		/**
		* @var osImageGallery The single instance of the class
		* @since 1.3
		*/
		 
		protected static $_instance = null;

		/**
		* Main osImageGallery Instance
		*
		* Ensures only one instance of osImageGallery is loaded or can be loaded.
		*
		* @since 1.3
		* @static
		* @see OSBX()
		* @return osImageGallery - Main instance
		*/
		 
		public static function init_instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
		}

		/**
		* Cloning is forbidden.
		*
		* @since 1.3
		*/

		public function __clone() {
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'os-image-gallery' ), '1.3' );
		}

		/**
		* Unserializing instances of this class is forbidden.
		*
		* @since 1.3
		*/
		 
		public function __wakeup() {
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'os-image-gallery' ), '1.3' );
		}
	        
		/**
		* Get the plugin url.
		*
		* @since 1.3
		*/

		public function plugin_url() {
            return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}

		/**
		* Get the plugin path.
		*
		* @since 1.3
		*/

		public function plugin_path() {
            return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		/**
		* Get Ajax URL.
		*
		* @since 1.3
		*/

		public function ajax_url() {
            return admin_url( 'admin-ajax.php', 'relative' );
		}
	        
		/**
		* osImageGallery Constructor.
		* @access public
		* @return osImageGallery
		* @since 1.3
		*/
		 
		public function __construct() {
			
            register_activation_hook( __FILE__, array( &$this, 'os_image_gallery_install' ) );

            // Define constants
            self::os_image_gallery_constants();

            // Include required files
            self::os_image_gallery_admin_includes();

            // Action Hooks
            add_action( 'init', array( $this, 'os_image_gallery_init' ), 0 );
            add_action( 'admin_init', array( $this, 'os_image_gallery_admin_init' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'os_image_gallery_frontend_styles_scrips' ) );
		}
	        
		/**
		* Install osImageGallery
		* @since 1.3
		*/
		 
		public function os_image_gallery_install (){
			
            // Flush rules after install
            flush_rewrite_rules();

            // Redirect to welcome screen
            set_transient( '_osig_activation_redirect', 1, 60 * 60 );
		}
	        
		/**
		* Define osImageGallery Constants
		* @since 1.3
		*/
		 
		private function os_image_gallery_constants() {
			
			define( 'OSIG_PLUGIN_FILE', __FILE__ );
			define( 'OSIG_PLUGIN_BASENAME', plugin_basename( dirname( __FILE__ ) ) );
			define( 'OSIG_PLUGIN_URL', plugins_url() . '/' . OSIG_PLUGIN_BASENAME );
			define( 'OSIG_VERSION', $this->version );
			define( 'OSIG_TEXT_DOMAIN', 'os-image-gallery' );
			define( 'OSIG_PERMALINK_STRUCTURE', get_option( 'permalink_struture' ) ? '&' : '?' );
			
		}
	        
		/**
		* includes admin defaults files
		*
		* @since 1.3
		*/
		 
		private function os_image_gallery_admin_includes() {

            include_once( 'includes/admin/os-image-gallery-post-types.php' );
	        include_once( 'includes/os-image-gallery-shortcode.php' );
		}
	        
		/**
		* Init osImageGallery when WordPress Initialises.
		* @since 1.3
		*/
		 
		public function os_image_gallery_init() {
	            
            self::os_image_gallery_do_output_buffer();
		}
	        
		/**
		* Clean all output buffers
		*
		* @since  1.3
		*/
		 
		public function os_image_gallery_do_output_buffer() {
	            
            ob_start( array( &$this, "os_image_gallery_do_output_buffer_callback" ) );
		}

		/**
		* Callback function
		*
		* @since  1.3
		*/
		 
		public function os_image_gallery_do_output_buffer_callback( $buffer ){
            return $buffer;
		}
		
		/**
		* Clean all output buffers
		*
		* @since  1.3
		*/
		 
		public function os_image_gallery_flush_ob_end(){
            ob_end_flush();
		}
	        
		/**
		* Admin init osImageGallery when WordPress Initialises.
		* @since  1.3
		*/
		 
		public function os_image_gallery_admin_init() {
				
            self::os_image_gallery_admin_styles_scrips();
		}
	        
		/**
		* Admin side style and javascript hook for osImageGallery
		*
		* @since  1.3
		*/
		 
		public function os_image_gallery_admin_styles_scrips() {

            $post_type = isset( $_REQUEST['post_type'] ) ? $_REQUEST['post_type'] : "" ;
            $post_id = isset( $_REQUEST['post'] ) ? $_REQUEST['post'] : "" ;

            if( "os-image-gallery" == $post_type || "os-image-gallery" == get_post_type( $post_id ) ){

				if( function_exists( 'wp_enqueue_media' ) ) {
					wp_enqueue_media();
				} else {
					wp_enqueue_style( 'thickbox' );
					wp_enqueue_script( 'media-upload' );
					wp_enqueue_script( 'thickbox' );
				}
				
            	wp_enqueue_style( 'wp-color-picker' );  
            	wp_enqueue_style( 'os-admin-style', plugins_url( 'css/admin/style-min.css', __FILE__ ) );

            	wp_enqueue_script( 'jquery-ui-sortable' );            
            	wp_enqueue_script( 'os-custom-min', plugins_url( 'js/admin/custom-min.js', __FILE__ ), array(), '1.3', true );
            }

		}

		/**
		* Frontend style and javascript hook for osImageGallery
		*
		* @since  1.3
		*/
		 
		public function os_image_gallery_frontend_styles_scrips() {

           	wp_enqueue_style( 'os-colorbox', plugins_url( 'colorbox/colorbox.css', __FILE__ ) );
            wp_enqueue_style( 'os-frontend-style', plugins_url( 'css/style.css', __FILE__ ) );

			wp_enqueue_script( 'jquery-masonry' ); 
            wp_enqueue_script( 'os-mixitup-min', plugins_url( 'js/jquery.mixitup.min.js', __FILE__ ), array(), '1.4.0', true );
            wp_enqueue_script( 'os-colorbox-min', plugins_url( 'colorbox/jquery.colorbox-min.js', __FILE__ ), array(), '1.6.3', true );
            wp_enqueue_script( 'os-frontend-script', plugins_url( 'js/frontend-min.js', __FILE__ ), array(), '1.3', true ); 
		} 	
	}   
endif;

/**
 * Returns the main instance of osImageGallery to prevent the need to use globals.
 *
 * @since  1.3
 * @return osImageGallery
 */
 
return new osImageGallery;