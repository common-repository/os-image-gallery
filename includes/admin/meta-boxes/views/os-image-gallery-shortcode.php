<?php 
$post_type = new osImageGalleryPostType();
$osig = $post_type->os_image_gallery_return_custom_meta( $post_id );
$gallery_type = isset( $osig['settings']['gallery_type'] ) ? $osig['settings']['gallery_type'] : '';
$column = isset( $osig['settings']['column'] ) ? $osig['settings']['column'] : '';
$shortcode = '[os-image-gallery id="' . $post_id . '" type="' . $gallery_type . '" column="' . $column . '"]';
$shortcode_function = '<?php echo do_shortcode( [os-image-gallery id="' . $post_id . '" type="' . $gallery_type . '" column="' . $column . '"] );?>';
?>
<div id="os-image-gallery-type-wrapper">
	<p><b>Shortcode: </b></p>
    <div class="option-box" style="margin: 15px 0 0 0; border-bottom: none;">
        <input type="text" readonly="readonly" id="shortcode_<?php echo $post_id;?>" class="shortcode" value="<?php echo esc_attr( $shortcode ); ?>">         
    </div>
    <em>Copy and paste this shortcode into your post, page or custom post types etc.</em>
	<p><b>Template Code: </b></p>
    <div class="option-box" style="margin: 15px 0 0 0; border-bottom: none;">
        <input type="text" readonly="readonly" id="shortcode_function_<?php echo $post_id;?>" class="shortcode" value="<?php echo esc_attr( $shortcode_function ); ?>">      
    </div>
    <em>Copy and paste this function into your page templates like header.php, front-page.php, etc.</em>    
    <div class="clear"></div>
</div>                                                                                    