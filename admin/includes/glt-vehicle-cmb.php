<?php
add_action( 'admin_init', 'gltv_custom_meta_boxes' );
function gltv_custom_meta_boxes() {
	add_meta_box( 'gltv_id', 'Vehicle Color Variants', 'gltv_custom_meta_box_display', 'gltv', 'normal', 'high' );
}

function gltv_custom_meta_box_display() {
	global $post;
	$meta = get_post_meta( $post->ID, 'gltv_meta_fields', true );
	$meta2 = get_post_meta( $post->ID );
	wp_nonce_field( 'gltv_nonce', 'gltv_nonce' );
	
	$defImage = GLTV_PLUGIN_ADMIN_GET_IMAGE_DEF.'default-car.png';
?>

	<div id="repeatable-fieldset-one">
		<div id="tbody">
			
			<div class="line-row">
				<div class="col-left alignleft">
					<label>Carousel Type</label>
				</div>
				<div class="col-right alignright">
					<select name="carousel_type" id="carousel_type">
						<option value="Default" <?php if ( isset ( $meta2['carousel_type'] ) ) selected( $meta2['carousel_type'][0], 'Default' ); ?>>Default</option>
						<option value="Pop-up" <?php if ( isset ( $meta2['carousel_type'] ) ) selected( $meta2['carousel_type'][0], 'Pop-up' ); ?>>Pop-up</option>
					</select><br>
					<span class="description carousel-options">There are additional options below for Pop-up carousel type.</span>
				</div>
			</div>

			<div class="line-row carousel-options">
				<div class="col-left alignleft">
					<label>Custom Link</label>
				</div>
				<div class="col-right alignright">
					<input type="text" name="custom_link" value="<?php if ( isset ( $meta2['custom_link'] ) ) echo $meta2['custom_link'][0]; ?>" /><br>
					<span class="description">This is where you want to redirect when you click the main / featured image.</span>
				</div>
			</div>

			<div class="line-row carousel-options">
				<div class="col-left alignleft">
					<label>Redirect Option</label>
				</div>
				<div class="col-right alignright">
					<input type="radio" name="redirect_option" value="_self" <?php checked( $meta2['redirect_option'][0], '_self' ); ?> >Same Window<br>
					<input type="radio" name="redirect_option" value="_blank" <?php checked( $meta2['redirect_option'][0], '_blank' ); ?> >New Tab<br>
					<span class="description">Choose whether to open the <b>custom link</b> in the same page or in a new tab.</span>
				</div>
			</div>
			
<?php
	if ( $meta ) :
		foreach ( $meta as $i => $data ) {
?>
			<div class="holder">
				<p>
					<a id="remove" class="button" title="Remove row">x</a>
					<a id="sort" class="button" title="Reposition">|||</a>
				</p>
				<div class="line-row">
					<div class="col-left alignleft">
						<label>Color Name</label>
					</div>
					<div class="col-right alignright">
						<input type="text" name="color_name[]" value="<?php if ( $data['color_name'] != '' ) echo esc_attr( $data['color_name'] ); ?>" />
					</div>
				</div>
				<div class="line-row">
					<div class="col-left alignleft">
						<label>Color Hex</label>
					</div>
					<div class="col-right alignright">
						<input type="text" name="color_hex[]" class="jscolor" value="<?php if ( $data['color_hex'] != '' ) echo esc_attr( $data['color_hex'] ); ?>" />
					</div>
				</div>
				<div class="line-row color-image">
					<div class="col-left alignleft">
						<label>Car Preview</label>
					</div>
					<div class="col-right alignright">
						<img id="color_image_<?php echo $i; ?>" src="<?php if ( isset ( $data['color_url'] ) ) echo $data['color_url']; ?>" />
					</div>
				</div>
				<div class="line-row color-url hidden">
					<div class="col-left alignleft">
						<label>Image URL</label>
					</div>
					<div class="col-right alignright">
						<input type="text" id="color_url_<?php echo $i; ?>" name="color_url[]" value="<?php if ( isset ( $data['color_url'] ) ) echo $data['color_url']; ?>" />
					</div>
				</div>
				<p>
					<input type="button" id="gltv_image_upload" name="button[]" class="button" value="Choose or Upload an Image" />
				</p>
			</div>
<?php
		}
	else :
		// show a blank one
?>
			<div class="holder">
				<p>
					<a id="remove" class="button" title="Remove row">x</a>
					<a id="sort" class="button" title="Reposition">|||</a>
				</p>
				<div class="line-row">
					<div class="col-left alignleft">
						<label>Color Name</label>
					</div>
					<div class="col-right alignright">
						<input type="text" name="color_name[]" />
					</div>
				</div>
				<div class="line-row">
					<div class="col-left alignleft">
						<label>Color Hex</label>
					</div>
					<div class="col-right alignright">
						<input type="text" name="color_hex[]" class="jscolor" value="" />
					</div>
				</div>
				<div class="line-row color-image">
					<div class="col-left alignleft">
						<label>Car Preview</label>
					</div>
					<div class="col-right alignright">
						<img id="color_image_1" src="<?php echo $defImage; ?>" />
					</div>
				</div>
				<div class="line-row color-url hidden">
					<div class="col-left alignleft">
						<label>Image URL</label>
					</div>
					<div class="col-right alignright">
						<input type="text" id="color_url_1" name="color_url[]" value="<?php echo $defImage; ?>" />
					</div>
				</div>
				<p>
					<input type="button" id="gltv_image_upload" name="button[]" class="button" value="Choose or Upload an Image" />
				</p>
			</div>
			
		<?php endif; ?>

			<!-- empty hidden one for jQuery -->
			<div class="holder empty-row screen-reader-text">
				<p>
					<a id="remove" class="button" title="Remove row">x</a>
					<a id="sort" class="button" title="Reposition">|||</a>
				</p>
				<div class="line-row">
					<div class="col-left alignleft">
						<label>Color Name</label>
					</div>
					<div class="col-right alignright">
						<input type="text" name="color_name[]" />
					</div>
				</div>
				<div class="line-row">
					<div class="col-left alignleft">
						<label>Color Hex</label>
					</div>
					<div class="col-right alignright">
						<input type="text" name="color_hex[]" class="jscolor" value="" />
					</div>
				</div>
				<div class="line-row color-image">
					<div class="col-left alignleft">
						<label>Car Preview</label>
					</div>
					<div class="col-right alignright">
						<img id="color_image" src="<?php echo $defImage; ?>" />
					</div>
				</div>
				<div class="line-row color-url hidden">
					<div class="col-left alignleft">
						<label>Image URL</label>
					</div>
					<div class="col-right alignright">
						<input type="text" id="color_url" name="color_url[]" value="<?php echo $defImage; ?>" />
					</div>
				</div>
				<p>
					<input type="button" id="gltv_image_upload" name="button[]" class="button" value="Choose or Upload an Image" />
				</p>
			</div>
		
		</div>
	</div>

	<p>
		<input type="button" id="add_variation" class="button" value="Add More Variations" />
	</p>
	
	<?php
}

add_action( 'save_post', 'gltv_custom_meta_box_save' );
function gltv_custom_meta_box_save( $post_id ) {
	if ( ! isset( $_POST['gltv_nonce'] ) || ! wp_verify_nonce( $_POST['gltv_nonce'], 'gltv_nonce' ) )
		return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
	if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	
	$old = get_post_meta( $post_id, 'gltv_meta_fields', true );
	$new = array();
	$defImage = GLTV_PLUGIN_ADMIN_GET_IMAGE_DEF.'default-car.png';
	
	$custom_link = $_POST['custom_link'];
	$redirect_option = $_POST['redirect_option'];
	$carousel_type = $_POST['carousel_type'];
	
	$color_name = $_POST['color_name'];
	$color_hex = $_POST['color_hex'];
	$color_url = $_POST['color_url'];
	$count = count( $color_name );
	
	for ( $i = 0; $i < $count; $i++ ) {
		if ( $color_name[$i] != '' ):
			$new[$i]['color_name'] = stripslashes( strip_tags( $color_name[$i] ) );
		
		if ( $color_hex[$i] != '' )
			$new[$i]['color_hex'] = stripslashes( $color_hex[$i] );
		
		if ( $color_url[$i] == '' )
			$new[$i]['color_url'] = $defImage;
		else
			$new[$i]['color_url'] = stripslashes( $color_url[$i] ); // and however you want to sanitize
		endif;
	}
	
	if ( isset( $custom_link ) ) { 
    	update_post_meta( $post_id, 'custom_link', sanitize_text_field( $custom_link ) );
	}
	if ( isset( $redirect_option ) ) { 
    	update_post_meta( $post_id, 'redirect_option', sanitize_text_field( $redirect_option ) );
	}
	if ( isset( $carousel_type ) ) { 
    	update_post_meta( $post_id, 'carousel_type', sanitize_text_field( $carousel_type ) );
	}
	
	if ( !empty( $new ) && $new != $old )
		update_post_meta( $post_id, 'gltv_meta_fields', $new );
	elseif ( empty($new) && $old )
		delete_post_meta( $post_id, 'gltv_meta_fields', $old );
	
}