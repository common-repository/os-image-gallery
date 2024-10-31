<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Post types
 *
 * Registers post types and taxonomies
 *
 * @class       osImageGalleryPostType
 * @version     1.3
 * @category    Class
 * @author      Offshorent Softwares Pvt Ltd. | Jinesh.P.V
 */
 
if ( ! class_exists( 'osImageGalleryPostType' ) ) :
    
    class osImageGalleryPostType { 
        
        /**
         * Constructor
         */

        public function __construct() { 

            add_action( 'init', array( &$this, 'register_os_image_gallery_post_types' ) );
            add_action( 'admin_menu' , array( &$this, 'remove_os_image_gallery_category_metabox' ) );

            add_filter( 'manage_edit-os-image-gallery_columns', array( &$this, 'os_image_gallery_edit_columns' ), 10, 2 );
            add_action( 'manage_os-image-gallery_posts_custom_column', array( &$this, 'os_image_gallery_custom_column' ), 10, 2 );
            add_action( 'save_post', array( &$this, 'os_image_gallery_save_slider_values' ) );
        }

        /**
         * Register os_image_gallery post types.
         */

        public static function register_os_image_gallery_post_types() {
            
            self::os_image_gallery_taxonomies();
            self::os_image_gallery_includes();

            if ( post_type_exists( 'os-image-gallery' ) )
                return;

            $label              =   'Image Gallery';
            $labels = array(
                'name'                  =>  _x( $label, 'post type general name' ),
                'singular_name'        =>   _x( $label, 'post type singular name' ),
                'add_new'               =>  _x( 'Add New', OSIG_TEXT_DOMAIN ),
                'add_new_item'          =>  __( 'Add New Image Gallery', OSIG_TEXT_DOMAIN ),
                'edit_item'             =>  __( 'Edit Image Gallery', OSIG_TEXT_DOMAIN),
                'new_item'              =>  __( 'New Image Gallery' , OSIG_TEXT_DOMAIN ),
                'view_item'             =>  __( 'View Image Gallery', OSIG_TEXT_DOMAIN ),
                'search_items'          =>  __( 'Search ' . $label ),
                'not_found'             =>  __( 'Nothing found' ),
                'not_found_in_trash'    =>  __( 'Nothing found in Trash' ),
                'parent_item_colon'     =>  ''
            );

            register_post_type( 'os-image-gallery', 
                apply_filters( 'os_image_gallery_register_post_types',
                    array(
                            'labels'                 => $labels,
                            'public'                 => true,
                            'publicly_queryable'     => true,
                            'show_ui'                => true,
                            'exclude_from_search'    => true,
                            'query_var'              => true,
                            'has_archive'            => false,
                            'hierarchical'           => true,
                            'menu_position'          => 20,
                            'show_in_nav_menus'      => true,
                            'supports'               => array( 'title' ),
                            'menu_icon'              => "dashicons-images-alt2",
                        )
                )
            );                              
        }

        /**
         * Create taxonomies for os image gallery post type.
         */

        public static function os_image_gallery_taxonomies() {

            if ( post_type_exists( 'osig-category' ) )
                return;

            $labels = array(
                'name'              => _x( 'Categories', 'taxonomy general name' ),
                'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
                'search_items'      => __( 'Search Categories' ),
                'all_items'         => __( 'All Categories' ),
                'parent_item'       => __( 'Parent Category' ),
                'parent_item_colon' => __( 'Parent Category:' ),
                'edit_item'         => __( 'Edit Category' ),
                'update_item'       => __( 'Update Category' ),
                'add_new_item'      => __( 'Add New Category' ),
                'new_item_name'     => __( 'New Category Name' ),
                'menu_name'         => __( 'Category' ),
            );

            $args = array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => false,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'osig-category' ),
            );

            register_taxonomy( 'osig-category', array( 'os-image-gallery' ), $args );
        }

        /**
         * Remove os image gallery category metabox
         */

        public static function remove_os_image_gallery_category_metabox () {
            remove_meta_box( 'osig-categorydiv' , 'os-image-gallery' , 'side' ); 
        }

        /**
         * Includes the metabox classes and views
         */
        
        public static function os_image_gallery_includes() {
            
            include_once( 'meta-boxes/class-osig-slides.php' );
            include_once( 'meta-boxes/class-osig-shortcode.php' );
            include_once( 'meta-boxes/class-osig-type.php' );
            include_once( 'meta-boxes/class-osig-settings.php' );
        }
        
        /**
         * os_image_gallery slider edit columns.
         */

        public function os_image_gallery_edit_columns() {

            $columns = array(
                'cb'                            =>    '<input type="checkbox" />',
                'title'                         =>    'Title',
                'slider-type'                   =>    'Gallery Type',
                'slider-shortcode'              =>    'Shortcode',
                'slider-count'                  =>    'Image Count',
                'date'                          =>    'Date'
            );

            return $columns;
        }

        /**
         * display os_image_gallery slider custom columns.
         */

        public function os_image_gallery_custom_column( $column, $post_id ) {

            $osig = self::os_image_gallery_return_custom_meta( $post_id );
            $gallery_type = isset( $osig['settings']['gallery_type'] ) ? $osig['settings']['gallery_type'] : '';
            $column_no = isset( $osig['settings']['column'] ) ? $osig['settings']['column'] : '';
            $slides = isset( $osig['slides'] ) ? $osig['slides'] : '';
            $image_count = absint( count( $slides ) ) - 1;

            switch ( $column ) {
                case 'slider-type':                    
                    if ( ! empty( $gallery_type ) )
                        echo ucwords( $gallery_type ) . " Gallery";
                    break;
                case 'slider-shortcode':
                    if ( !empty( $gallery_type ) )
                        echo self::os_image_gallery_shortcode_creator( $post_id, $gallery_type, $column_no );
                    break;
                case 'slider-count':
                    echo '<span class="slidde_count">' . $image_count . '</span>';
                    break;
            }
        }
        
        /**
        * storing meta fields function for os_image_gallery_save_slider_values.
        */

        public function os_image_gallery_save_slider_values( $post_id ) {

            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
                return;

            if ( ! empty( $_POST['post_type'] ) && 'os-image-gallery' == $_POST['post_type'] ) {
                if ( ! current_user_can( 'edit_page', $post_id ) )
                    return;
            } else {
                if ( ! current_user_can( 'edit_post', $post_id ) )
                return;
            }

            if ( ! empty( $_POST['osig'] ) ) {
                update_post_meta( $post_id, 'osig_slider_custom_meta', $_POST['osig'] );
            }
        }
       
       /**
        * return slider custom meta values.
        */

        public function os_image_gallery_return_custom_meta( $post_id ) {

            return $slider_custom_meta = get_post_meta( $post_id, 'osig_slider_custom_meta', true );
        }

       /**
        * os_image_gallery shortcode creation
        */

        public function os_image_gallery_shortcode_creator( $post_id, $gallery_type, $column ) {
            
            $shortcode = '[os-image-gallery id="' . $post_id . '" type="' . $gallery_type . '" column="' . $column . '"]';
            return '<input type="text" readonly="readonly" id="shortcode_' . $post_id . '" class="shortcode" value="' . esc_attr( $shortcode ) . 
            '">';
        }
    }
endif;

/**
 * Returns the main instance of osImageGalleryPostType to prevent the need to use globals.
 *
 * @since  1.3
 * @return osImageGalleryPostType
 */
 
return new osImageGalleryPostType();
?>