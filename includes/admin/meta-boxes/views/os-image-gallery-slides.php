<?php 
$post_type = new osImageGalleryPostType();
$osig = $post_type->os_image_gallery_return_custom_meta( $post_id );
$slides = isset( $osig['slides'] ) ? $osig['slides'] : '';
?>
<div id="os-image-gallery-slider-wrapper">
<?php 
if( !empty( $slides ) ) {
    $i = 0;
    foreach ( $slides as $slideObj ) {
        if( count( $slides ) - 1 > $i ) {
            $i++;
            $attachment_id = isset( $slideObj['attachment_id'] ) ? $slideObj['attachment_id'] : '';
            $link = isset( $slideObj['link'] ) ? $slideObj['link'] : '';
            $link_target = isset( $slideObj['link_target'] ) ? $slideObj['link_target'] : '';
            $caption = isset( $slideObj['caption'] ) ? $slideObj['caption'] : '';
            $title = isset( $slideObj['title'] ) ? $slideObj['title'] : '';
            $category = isset( $slideObj['category'] ) ? $slideObj['category'] : '';
            ?>            
            <div class="os-image-gallery-box">
                <div class="os-image-gallery-header">
                    <div class="os-image-gallery-caption">
                        <?php echo get_the_title( $attachment_id ) ;?>
                    </div>
                    <div class="os-image-gallery-controls">
                        <span class="toggle up"></span>
                        <span class="delete"></span>                                        
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="os-image-gallery-body show">
                    <div class="os-image-gallery-image"> 
                        <div class="os-image-gallery-image-tag"><?php echo wp_get_attachment_image( $attachment_id, 'medium' ); ?></div> 
                        <input class="os-image-gallery-image-id" type="hidden" value="<?php echo esc_attr( $attachment_id );?>" name="osig[slides][<?php echo $i;?>][attachment_id]">                                      
                        <input type="button" value="Edit Image" name="add-image" id="add-image" class="button button-primary insert-media add_media" />
                    </div>
                    <div class="os-image-gallery-properties">
                        <label>Slide Attributes</label>
                        <div class="attribute-box last">
                            <label class="attribute">Details</label>
                            <div class="attribute-details">
                                <div class="field last">
                                    <label>Title:</label>
                                    <input type="text" name="osig[slides][<?php echo $i;?>][title]" class="widefat" value="<?php echo esc_attr( $title ); ?>" />
                                </div>
                                <div class="field last">                            
                                    <label>Description:</label>
                                    <textarea name="osig[slides][<?php echo $i;?>][caption]" class="widefat"><?php echo esc_attr( $caption ); ?></textarea>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="os-image-gallery-taxonomies">
                        <h3>Categories</h3>
                        <?php
                        $args = array(
                                        'taxonomy'      => 'osig-category',
                                        'parent'        => 0,
                                        'orderby'       => 'name',
                                        'order'         => 'ASC',
                                        'hierarchical'  => 1,
                                        'hide_empty'    => '0'
                                    );

                        $categories = get_categories( $args );
                        ?>
                        <ul>
                        <?php 
                        foreach ( $categories as $categoryObj ) {
                            $checked = ( @in_array( $categoryObj->term_id, $category ) ) ? 'checked="checked"' : '';
                            ?>
                            <li class="cat-item cat-item-<?php echo esc_attr( $categoryObj->term_id );?>">
                                <input type="checkbox" <?php echo $checked;?> name="osig[slides][<?php echo $i;?>][category][]" value="<?php echo esc_attr( $categoryObj->term_id );?>" />
                                <label><?php echo esc_attr( $categoryObj->name );?></label>
                            </li>
                        <?php    
                        }
                        ?>
                        </ul>
                    </div>                      
                </div>    
            </div>           
        <?php
        }
    }
}
?>
</div>                                                                                    
<input type="button" class="button" value="Add Slide" id="add-slide" />

<div class="os-image-gallery-box-wrap hide">
    <div class="os-image-gallery-box">
        <div class="os-image-gallery-header">
            <div class="os-image-gallery-caption">
                Slide
            </div>
            <div class="os-image-gallery-controls">
                <span class="toggle up"></span>
                <span class="delete"></span>                                        
            </div>
            <div class="clear"></div>
        </div>
        <div class="os-image-gallery-body" style="display: block;">
            <div class="os-image-gallery-image"> 
                <div class="os-image-gallery-image-tag"></div>                                       
                <input class="os-image-gallery-image-id" type="hidden" value="" name="osig[slides][{id}][attachment_id]">
                <input type="button" value="Add Image" name="add-image" id="add-image" class="button button-primary insert-media add_media" />
            </div>
            <div class="os-image-gallery-properties">
                <label>Slide Attributes</label>
                <div class="attribute-box last">
                    <label class="attribute">Details</label>
                    <div class="attribute-details">
                        <div class="field last">
                            <label>Title:</label>
                            <input type="text" name="osig[slides][{id}][title]" class="widefat" />
                        </div>
                        <div class="field last">                            
                            <label>Description:</label>
                            <textarea name="osig[slides][{id}][caption]" class="widefat"></textarea>
                        </div>
                    </div>    
                </div>
            </div>
            <div class="clear"></div>
            <div class="os-image-gallery-taxonomies">
                <h3>Categories</h3>
                <?php
                $args = array(
                                'taxonomy'      => 'osig-category',
                                'parent'        => 0,
                                'orderby'       => 'name',
                                'order'         => 'ASC',
                                'hierarchical'  => 1,
                                'hide_empty'    => '0'
                            );

                $categories = get_categories( $args );
                ?>
                <ul>
                <?php 
                foreach ( $categories as $categoryObj ) {
                ?>
                    <li class="cat-item cat-item-<?php echo esc_attr( $categoryObj->term_id );?>">
                        <input type="checkbox" name="osig[slides][{id}][category][]" value="<?php echo esc_attr( $categoryObj->term_id );?>" />
                        <label><?php echo esc_attr( $categoryObj->name );?></label>
                    </li>
                <?php    
                }
                ?>
                </ul>
            </div>
        </div>    
    </div>
</div>