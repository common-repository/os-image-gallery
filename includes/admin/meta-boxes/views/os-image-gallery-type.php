<?php 
$post_type = new osImageGalleryPostType();
$osig = $post_type->os_image_gallery_return_custom_meta( $post_id );
$gallery_type = isset( $osig['settings']['gallery_type'] ) ? $osig['settings']['gallery_type'] : '';
$column = isset( $osig['settings']['column'] ) ? $osig['settings']['column'] : '4';
?>
<div id="os-image-gallery-type-wrapper">
	<div class="option-box">
		<p><b>Gallery Type</b></p>
		<select id="gallery_type" name="osig[settings][gallery_type]">
			<option value="">---Select Gallery Type---</option>
			<?php 
			$type_array = array( 
									"normal" 	=>	"Normal Gallery",
									"masonry" 	=>	"Masonry Gallery",
									"lightbox" 	=>	"Lightbox Gallery",
									"isotope" 	=>	"Isotope Gallery"
								);
			foreach ( $type_array as $key => $value ) {
			?>
			<option value="<?php echo $key; ?>" <?php selected( $gallery_type, $key );?>><?php echo $value; ?></option>
			<?php } ?>
		</select>
		<em>Number of images to be displayed in a row</em>
    </div>
    <div class="option-box">
	    <p><b>Column</b></p>
	    <input name="osig[settings][column]" type="text" value="<?php echo esc_attr( $column ); ?>" class="widefat" />
	    <em>Number of images to be displayed in a row</em>
    </div>
    <div class="clear"></div>
</div>                                                                                    