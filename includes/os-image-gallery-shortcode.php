<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Post types
 *
 * DM Page Creation
 *
 * @class 		osImageGalleryShortcode
 * @version		1.3
 * @category	Class
 * @author 		Offshorent Softwares Pvt Ltd | Jinesh.P.V.
 */
 
if ( ! class_exists( 'osImageGalleryShortcode' ) ) :

	class osImageGalleryShortcode { 
	
		/**
		 * Constructor
		 */
		
		public function __construct() { 
			

            // Shortcode Hooks
            add_shortcode( 'os-image-gallery', array( $this, 'os_image_gallery_shortcode' ) );

            //Filter Hook
            add_filter( 'widget_text', 'do_shortcode', 11 );
        }

		/**
		* Core function for shortcode hook
		*
		* @since  1.3
		*/
		 
		public function os_image_gallery_shortcode ( $atts ) {
			
			ob_start();

			// Extract os-image-gallery shortcode

			$atts = shortcode_atts(
									array(
										'id' => '',
										'type' => '',
										'category' => '',
										'column' => ''
									), $atts );

			$gallery_id = $atts['id'];
			$gallery_type = $atts['type'];
			$category_id = $atts['category'];
			$column = absint( $atts['column'] );
			$count = absint( 12 / $column );

			$post_type = new osImageGalleryPostType();
			$osig = $post_type->os_image_gallery_return_custom_meta( $gallery_id );
			$slides = isset( $osig['slides'] ) ? $osig['slides'] : '';

			if( "normal" == $gallery_type ) {
				self::os_get_normal_gallery_html( $slides, $category_id, $column, $count );
			} else if( "lightbox" == $gallery_type ) {
				self::os_get_lightbox_gallery_html( $slides, $category_id, $column, $count );
			} else if( "isotope" == $gallery_type ) {
				self::os_get_isotope_gallery_html( $slides, $category_id, $column, $count );
			} else {
				self::os_get_masonry_gallery_html( $slides, $category_id, $column, $count );
			}

			return ob_get_clean();
		}

		/**
		* Return normal gallery html
		*
		* @since  1.3
		*/

		public function os_get_normal_gallery_html ( $slides, $category_id, $column, $count ) {

			?>
			<div class="os-image-gallery-wrapper normal">
				<div class="row">
					<div class="image-gallery-wrap">
						<input type="hidden" id="gallery_type" value="normal">
						<?php
						$i = $j = 0;
						if( !empty( $slides ) ) {
						    foreach ( $slides as $slideObj ) {
						    	if( $i > 0 && $i % $column == 0 ) {
						    		?>
						    		</div><div class="image-gallery-wrap">
						    		<?php
						    		$i = 1;
						    	} else {
						    		$i++;
						    	}
						        if( count( $slides ) - 1 > $j ) {
						            $attachment_id = isset( $slideObj['attachment_id'] ) ? $slideObj['attachment_id'] : '';
						            $image_url = wp_get_attachment_image_url( $attachment_id, 'large' );
						            $full_image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
						            $link = isset( $slideObj['link'] ) ? $slideObj['link'] : '';
						            $link_target = isset( $slideObj['link_target'] ) ? $slideObj['link_target'] : '';
						            $caption = isset( $slideObj['caption'] ) ? $slideObj['caption'] : '';
						            $title = isset( $slideObj['title'] ) ? $slideObj['title'] : '';
						            $category = isset( $slideObj['category'] ) ? $slideObj['category'] : '';

						            if( !empty( $category_id ) ) {
							            if( @in_array( $category_id, $category ) ) {
							            	?>
							            	<div class="os-image-gallery-box col-md-<?php echo $count; ?>">
							            		<?php if( !empty( $attachment_id ) ) ?>
						            			<img src="<?php echo esc_attr( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="img-responsive img-rounded" />
							            		<?php if( !empty( $title ) ) ?>
							            		<h3><?php echo esc_attr( $title ); ?></h3>
							            		<?php if( !empty( $caption ) ) ?>
							            		<p><?php echo esc_attr( $caption ); ?></p>
							            	</div>	
							            	<?php
							            }
							        } else {
							        	?>
						            	<div class="os-image-gallery-box col-md-<?php echo $count; ?>">
						            		<?php if( !empty( $attachment_id ) ) ?>
				            				<img src="<?php echo esc_attr( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="img-responsive img-rounded" />
						            		<?php if( !empty( $title ) ) ?>
						            		<h3><?php echo esc_attr( $title ); ?></h3>
						            		<?php if( !empty( $caption ) ) ?>
						            		<p><?php echo esc_attr( $caption ); ?></p>
						            	</div>	
						            	<?php
							        }
						        }
						        $j++;
						    }
						}
						?>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		* Return lightbox gallery html
		*
		* @since  1.3
		*/

		public function os_get_lightbox_gallery_html ( $slides, $category_id, $column, $count ) {

			?>
			<div class="os-image-gallery-wrapper lightbox">
				<div class="row">
					<div class="image-gallery-wrap">
						<input type="hidden" id="gallery_type" value="lightbox">
						<?php
						$i = $j = 0;
						if( !empty( $slides ) ) {
						    foreach ( $slides as $slideObj ) {
						    	if( $i > 0 && $i % $column == 0 ) {
						    		?>
						    		</div><div class="image-gallery-wrap">
						    		<?php
						    		$i = 1;
						    	} else {
						    		$i++;
						    	}
						        if( count( $slides ) - 1 > $j ) {
						            $attachment_id = isset( $slideObj['attachment_id'] ) ? $slideObj['attachment_id'] : '';
						            $image_url = wp_get_attachment_image_url( $attachment_id, 'large' );
						            $full_image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
						            $link = isset( $slideObj['link'] ) ? $slideObj['link'] : '';
						            $link_target = isset( $slideObj['link_target'] ) ? $slideObj['link_target'] : '';
						            $caption = isset( $slideObj['caption'] ) ? $slideObj['caption'] : '';
						            $title = isset( $slideObj['title'] ) ? $slideObj['title'] : '';
						            $category = isset( $slideObj['category'] ) ? $slideObj['category'] : '';

						            if( !empty( $category_id ) ) {
							            if( @in_array( $category_id, $category ) ) {
							            	?>
							            	<div class="os-image-gallery-box col-md-<?php echo $count; ?>">
							            		<?php if( !empty( $attachment_id ) ) { ?>
							            		<a class="osig-img"  href="<?php echo esc_attr( $image_url ); ?>" title="<?php echo esc_attr( $caption ); ?>">
							            			<img src="<?php echo esc_attr( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="img-responsive img-rounded" />
							            		</a>
							            		<?php } ?>
							            		<?php if( !empty( $title ) ) ?>
							            		<h3><?php echo esc_attr( $title ); ?></h3>
							            		<?php if( !empty( $caption ) ) ?>
							            		<p><?php echo esc_attr( $caption ); ?></p>
							            	</div>	
							            	<?php
							            }
							        } else {
							        	?>
						            	<div class="os-image-gallery-box col-md-<?php echo $count; ?>">
						            		<?php if( !empty( $attachment_id ) ) { ?>
						            		<a class="osig-img"  href="<?php echo esc_attr( $image_url ); ?>" title="<?php echo esc_attr( $caption ); ?>">
						            			<img src="<?php echo esc_attr( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="img-responsive img-rounded" />
						            		</a>
						            		<?php } ?>
						            		<?php if( !empty( $title ) ) ?>
						            		<h3><?php echo esc_attr( $title ); ?></h3>
						            		<?php if( !empty( $caption ) ) ?>
						            		<p><?php echo esc_attr( $caption ); ?></p>
						            	</div>	
						            	<?php
							        }
						        }
						        $j++;
						    }
						}
						?>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		* Return isotope gallery html
		*
		* @since  1.3
		*/

		public function os_get_isotope_gallery_html ( $slides, $category_id, $column, $count ) {

			?>
			<div class="os-image-gallery-wrapper isotope">
				<div class="row">
					<div class="col-md-12">
					<input type="hidden" id="gallery_type" value="isotope">
					<?php
						$category_arr = array();;
						if( !empty( $slides ) ) {
					    	foreach ( $slides as $slideObj ) {
					    		$categoryObj = isset( $slideObj['category'] ) ? $slideObj['category'] : '';
					    		for ( $i = 0; $i < count( $categoryObj ); $i++ ) {
					    			if( !empty( $categoryObj[$i] ) )
						    			$category_arr[] = $categoryObj[$i];
					    		}
						    }
					    }
					    $category_arr = array_keys( array_flip( $category_arr ) );
					    if( !empty( $category_arr ) ) {
					    	$cat_names = self::os_get_all_image_gallery_categories( $category_arr );
							?>
							<ul class="os-image-gallery-nav">
								<li><a class="filter active" data-filter="<?php echo $cat_names;?>" class="active">All</a></li>
								<?php for ( $i = 0; $i < count( $category_arr ); $i++ ) { ?>
								<?php $category_details = get_term_by( 'term_id', $category_arr[$i], 'osig-category' ); ?>
								<li><a class="filter" data-filter="<?php echo esc_attr( $category_details->slug );?>"><?php echo esc_attr( $category_details->name );?></a></li>
								<?php } ?>
							</ul>	
						<?php } ?>
					</div>
				</div>	
				<div class="row">
					<div class="os-image-gallery-wrap">
					<?php
					$x = 0;
					if( !empty( $slides ) ) {
					    foreach ( $slides as $slideObj ) {
					        if( count( $slides ) - 1 > $x ) {
					            $attachment_id = isset( $slideObj['attachment_id'] ) ? $slideObj['attachment_id'] : '';
					            $image_url = wp_get_attachment_image_url( $attachment_id, 'large' );
					            $link = isset( $slideObj['link'] ) ? $slideObj['link'] : '';
					            $link_target = isset( $slideObj['link_target'] ) ? $slideObj['link_target'] : '';
					            $caption = isset( $slideObj['caption'] ) ? $slideObj['caption'] : '';
					            $title = isset( $slideObj['title'] ) ? $slideObj['title'] : '';
					            $category = isset( $slideObj['category'] ) ? $slideObj['category'] : '';
					            $catnames = "";
					            $catnames = self::os_get_all_image_gallery_categories( $category );
				            	?>
				            	<div class="os-image-gallery-box col-md-<?php echo $count . " " . rtrim( $catnames, ' ' ); ?>"data-cat="<?php echo rtrim( $catnames, ' ' ); ?>">
				            		<?php if( !empty( $attachment_id ) ) ?>
			            			<img src="<?php echo esc_attr( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="img-responsive" />
				            		<?php if( !empty( $title ) ) ?>
				            		<h3><?php echo esc_attr( $title ); ?></h3>
				            		<div class="clearfix"></div>
				            	</div>	
				            	<?php
					        }
					        $x++;
					    }
					}
					?>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		* Return masonry gallery html
		*
		* @since  1.3
		*/

		public function os_get_masonry_gallery_html ( $slides, $category_id, $column, $count ) {

			?>
			<div class="os-image-gallery-wrapper masonry">				
				<div class="row">
					<div class="os-image-gallery-wrap">
					<input type="hidden" id="gallery_type" value="masonry">
					<?php
					$x = 0;
					if( !empty( $slides ) ) {
					    foreach ( $slides as $slideObj ) {
					        if( count( $slides ) - 1 > $x ) {
					            $attachment_id = isset( $slideObj['attachment_id'] ) ? $slideObj['attachment_id'] : '';
					            $image_url = wp_get_attachment_image_url( $attachment_id, 'large' );
					            $link = isset( $slideObj['link'] ) ? $slideObj['link'] : '';
					            $link_target = isset( $slideObj['link_target'] ) ? $slideObj['link_target'] : '';
					            $caption = isset( $slideObj['caption'] ) ? $slideObj['caption'] : '';
					            $title = isset( $slideObj['title'] ) ? $slideObj['title'] : '';
					            $category = isset( $slideObj['category'] ) ? $slideObj['category'] : '';
					            $catnames = "";
					            $catnames = self::os_get_all_image_gallery_categories( $category );
				            	?>
				            	<div class="os-image-gallery-box col-md-<?php echo $count . " " . rtrim( $catnames, ' ' ); ?>"data-cat="<?php echo rtrim( $catnames, ' ' ); ?>">
				            		<?php if( !empty( $attachment_id ) ) ?>
			            			<img src="<?php echo esc_attr( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="img-responsive" />
				            		<?php if( !empty( $title ) ) ?>
				            		<h3><?php echo esc_attr( $title ); ?></h3>
				            		<div class="clearfix"></div>
				            	</div>	
				            	<?php
					        }
					        $x++;
					    }
					}
					?>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		* Return all image gallery category names
		*
		* @since  1.3
		*/

		public function os_get_all_image_gallery_categories ( $category ) {

			for ( $k = 0; $k < count( $category ); $k++ ) {
            	$category_data = get_term_by( 'term_id', $category[$k], 'osig-category' );
            	$catnames .= $category_data->slug . ' ';
            }

            return $catnames;
		}
	}
	
endif;

/**
 * Returns the main instance of osImageGalleryShortcode to prevent the need to use globals.
 *
 * @since  2.0
 * @return osImageGalleryShortcode
 */
 
return new osImageGalleryShortcode();
?>