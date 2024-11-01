<?php

$taxonomy = "product_cat";


/** Add Custom Field To Category Form */
add_action( "{$taxonomy}_add_form_fields", 'google_form_custom_field_add', 10 );
add_action( "{$taxonomy}_edit_form_fields", 'google_form_custom_field_edit', 10, 2 );

function google_form_custom_field_add( $taxonomy ) {
?>
<div class="form-field">
  <label for="category_custom_order">Category Google Shopping</label>
  <input name="category_custom_order" id="category_custom_order" type="text" value="" size="40" aria-required="true" />
  <p class="description"><?php _e('Copy the google category that best fits your this woocommerce catégory.', 'wpshopping_lang'); ?><?php _e('The Google list is here : <a href="https://www.google.com/basepages/producttype/taxonomy.en-US.txt" target="_blank"> List</a>', 'wpshopping_lang'); ?><br /><small style="color:red"><?php _e('Please note that the Google list sometimes has problems\'s accents, we must rectify!', 'wpshopping_lang'); ?></small></p>
</div>
<div class="form-field">
<tr valign="top">
<input type="checkbox" class="checkbox" id="hide_category" name="hide_category" value="1" <?php checked('1', get_option('hide_category')); ?> />
<?php _e('I want to hide this category for Google Shopping', 'wpshopping_lang'); ?>

</tr> 
</div>
<?php
}

function google_form_custom_field_edit( $tag, $taxonomy ) {

	$option_name = 'category_custom_order_' . $tag->term_id;
	$category_custom_order = get_option( $option_name );

	$cache_category = 'choix_hide_category_' . $tag->term_id;
	$hide_category = get_option( $cache_category );

?>
<tr class="form-field">
  <th scope="row" valign="top"><label for="category_custom_order">Category Google Shopping</label></th>
  <td>
    <input type="text" name="category_custom_order" id="category_custom_order" value="<?php echo esc_attr( $category_custom_order ) ? esc_attr( $category_custom_order ) : ''; ?>" size="40" aria-required="true" />
    <p class="description"><?php _e('Copy the google category that best fits your product category.<br /> Example: <b> Sports equipment > Water Sports > Surfing > Surfboards</b><br />Google list is here <a href="http://www.google.com/basepages/producttype/taxonomy.en-US.txt" target="_blank"> List</A><br /><small style="color:red">Please note that the Google list sometimes has problems\'s accents, we must rectify!</small>'); ?></p>
  </td>
</tr>
<tr valign="top">
	<th scope="row"><?php _e('Hide category', 'wpshopping_lang'); ?></th>
	<td>
		<input type="checkbox" class="checkbox" id="choix_hide_category" name="choix_hide_category" value="1" <?php checked('1', $hide_category); ?> />
		<?php _e('I want to hide this category for Google Shopping ', 'wpshopping_lang'); ?>
	</td>
</tr> 
<?php
}

/** Save Custom Field Of Category Form */
add_action( "created_{$taxonomy}", 'category_form_custom_field_save', 10, 2 );	
add_action( "edited_{$taxonomy}", 'category_form_custom_field_save', 10, 2 );



function category_form_custom_field_save( $term_id, $tt_id ) {

	if ( isset( $_POST['category_custom_order'] ) ) {			
		$option_name = 'category_custom_order_' . $term_id;
		update_option( $option_name, $_POST['category_custom_order'] );
	}
	
	if ( isset( $_POST['choix_hide_category'] ) ) {			
		$cache_category = 'choix_hide_category_' . $term_id;
		update_option( $cache_category, $_POST['choix_hide_category'] );
	} else {
		$cache_category = 'choix_hide_category_' . $term_id;
		update_option( $cache_category, "0" );
	}
}


function wps_googleshopping_metaboxes( $meta_boxes ) {
		$prefix = 'wps_'; // Prefix for all fields
		$list = __('http://www.google.com/basepages/producttype/taxonomy.en-US.txt', 'wpshopping_lang');

		$verification_google_shopping = get_option('wps_website_verification');
		$category_google_shopping = get_option('product_category_add_form_fields');
		
		$category_google_general = get_option('wps_category_general');
		$idcategorygoogle =  wp_get_post_terms( $post->ID, 'product_category', array("fields" => "ids"));
		$option_name = 'category_custom_order_'.$idcategorygoogle[0];
		$category_google_category = get_option( $option_name );
		
		//$category = get_option('wps_category_general');
		
		
		$category = $mainCategory;

	
		$meta_boxes[] = array(
			'id' => 'shopping_metabox',
			'title' => __('Google Product Category', 'wpshopping_lang'),
			'pages' => array('product'), // post type
			'context' => 'normal',
			'priority' => 'core',
			'show_names' => true, // Show field names on the left
			'fields' => array(
				array(
					'name' => __('Category', 'wpshopping_lang'),
					'desc' => __('Copy the google category that best fits this <br /><small>Example: Apparel & Accessories > Clothing Accessories > Sunglasses</small><br />Google list is here: <a href = "'.$list.' "target =" _blank "> The list </a>', 'wpshopping_lang'),
					'id' => $prefix . 'googlecategorysingle',
					'type' => 'text'
				),
			),
		);
		return $meta_boxes;
		
	}
add_filter( 'cmb_meta_boxes', 'wps_googleshopping_metaboxes' );
