<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Post types
 *
 * Creating metabox for slider type
 *
 * @class 		osImageGalleryMetaboxTypes
 * @version		1.3
 * @category    Class
 * @author 		Offshorent Softwares Pvt Ltd. | Jinesh.P.V
 */
 
if ( ! class_exists( 'osImageGalleryMetaboxTypes' ) ) :

    class osImageGalleryMetaboxTypes { 

        /**
         * Constructor
         */

        public function __construct() { 

            add_action( 'add_meta_boxes_os-image-gallery', array( &$this, 'os_image_gallery_type_meta_box' ), 10, 1 );
        }		

        /**
         * callback function for os_image_gallery_type_meta_boxe.
         */

        public function os_image_gallery_type_meta_box() {
            add_meta_box( 	
                            'display_os_image_gallery_type_meta_box',
                            'Gallery Settings',
                            array( &$this, 'display_os_image_gallery_type_meta_box' ),
                            'os-image-gallery',
                            'side', 
                            'high'
                        );
        }

        /**
         * display function for display_os_image_gallery_type_meta_box.
         */

        public function display_os_image_gallery_type_meta_box() {

            $post_id = get_the_ID();					

            wp_nonce_field( 'os-image-gallery', 'os_image_gallery' );
            include_once( 'views/os-image-gallery-type.php' );
        }
    }
endif;

/**
 * Returns the main instance of osImageGalleryMetaboxTypes to prevent the need to use globals.
 *
 * @since  1.3
 * @return osImageGalleryMetaboxTypes
 */
 
return new osImageGalleryMetaboxTypes();
?>