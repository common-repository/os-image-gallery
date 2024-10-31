<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Post types
 *
 * Creating metabox for slides
 *
 * @class 		osImageGalleryMetaboxSlides
 * @version		1.3
 * @category    Class
 * @author 		Offshorent Softwares Pvt Ltd. | Jinesh.P.V
 */
 
if ( ! class_exists( 'osImageGalleryMetaboxSlides' ) ) :

    class osImageGalleryMetaboxSlides { 

        /**
         * Constructor
         */

        public function __construct() { 

            add_action( 'add_meta_boxes_os-image-gallery', array( &$this, 'os_image_gallery_slide_meta_box' ), 10, 1 );
        }		

        /**
         * callback function for os_image_gallery_slide_meta_boxe.
         */

        public function os_image_gallery_slide_meta_box() {
            add_meta_box( 	
                            'display_os_image_gallery_slide_meta_box',
                            'Slides',
                            array( &$this, 'display_os_image_gallery_slide_meta_box' ),
                            'os-image-gallery',
                            'normal', 
                            'high'
                        );
        }

        /**
         * display function for display_os_image_gallery_slide_meta_box.
         */

        public function display_os_image_gallery_slide_meta_box() {

            $post_id = get_the_ID();					

            wp_nonce_field( 'os-image-gallery', 'os_image_gallery' );
            include_once( 'views/os-image-gallery-slides.php' );
        }
    }
endif;

/**
 * Returns the main instance of osImageGalleryMetaboxSlides to prevent the need to use globals.
 *
 * @since  1.3
 * @return osImageGalleryMetaboxSlides
 */
 
return new osImageGalleryMetaboxSlides();
?>