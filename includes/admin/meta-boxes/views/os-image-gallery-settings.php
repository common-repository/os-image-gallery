<?php 
$post_type = new osImageGalleryPostType();
$osig = $post_type->os_image_gallery_return_custom_meta( $post_id );
$gallery_type = isset( $osig['design']['gallery_type'] ) ? $osig['design']['gallery_type'] : '';
$column = isset( $osig['design']['column'] ) ? $osig['design']['column'] : '4';
?>
<div id="os-image-gallery-design-wrapper">
	<h3><?php _e( 'Font Size Settings', OSPT_TEXT_DOMAIN ); ?></h3>
	<div class="ospt-row-box">
        <label for="package-name-font"><?php _e( 'Package Name', OSPT_TEXT_DOMAIN ); ?></label>
        <input type="text" name="ospt[settings][package-name-font]" value="" placeholder="eg: 24px" />
    </div>
    <div class="clear"></div>
    <h3><?php _e( 'Color Settings', OSPT_TEXT_DOMAIN ); ?></h3>
	<div class="ospt-row">
        <label for="button-color"><?php _e( 'Button Color', OSPT_TEXT_DOMAIN ); ?></label>
    	<input type="text" name="ospt[settings][button-color]" class="button-color" value="" />
    	<div class="clear"></div>
    </div>
    <div class="ospt-row">
        <label for="font-color"><?php _e( 'Button Font Color', OSPT_TEXT_DOMAIN ); ?></label>
    	<input type="text" name="ospt[settings][font-color]" class="button-color" value="" />
    	<div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>                                                                                    