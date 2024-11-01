<?php
	/*
	Plugin Name: Ultimate Products Feed
	Plugin URI: https://wp-shopping.com
	Description: XML woocommerce products Feed for Google merchant, google shopping, google adwords
	Version: 2.11
	Author: Frédéric Galliné
	Author URI: https://profiles.wordpress.org/fredericgalline
	Text Domain: wpshopping_lang
	Domain Path: /languages/
	Requires at least: 4.8.0
	Tested up to: 5.0.3
	*/


	
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// MENU WP-SHOPPING Google et facebook shopping
	function wps_upf_add_pages() {
	   
	       // Add a new top-level menu (ill-advised):
	    add_menu_page(
	    	__('Google et Facebook Shopping','wpshopping_lang'), 
			__('Google Shopping','wpshopping_lang'), 
			'manage_options', 
			'googleshopping-top-level-menu', 
			'wps_upf_top_menu_google_shopping', 
			'dashicons-networking', 
			56 );
	
		 // Add a submenu to the custom top-level menu:
	    add_submenu_page(
	    	'googleshopping-top-level-menu', 
	    	__('Google Merchant','wpshopping_lang'), 
	    	__('Google Merchant','wpshopping_lang'), 
	    	'manage_options', 
	    	'flux-google-merchant', 
	    	'gs_sublevel_page');

			
		// Add a submenu to the custom top-level menu:
	    add_submenu_page(
	    	'googleshopping-top-level-menu', 
	    	__('Setting','wpshopping_lang'), 
	    	__('Setting','wpshopping_lang'), 
	    	'manage_options', 
	    	'setting-google-shopping', 
	    	'settings_sublevel_page');

	    // Add a second submenu to the custom top-level menu:
	    add_submenu_page(
	    	'googleshopping-top-level-menu', 
	    	__('Add-on Pro','wpshopping_lang'), 
	    	__('Add-on Pro','wpshopping_lang'), 
	    	'manage_options', 
	    	'Add-on PRO', 
	    	'addon_sublevel_page');
	    	
	}
	add_action('admin_menu', 'wps_upf_add_pages');


    function wps_upf_enqueue($hook){

	    if ( isset( $_GET['page'] ) && $_GET['page'] == ('setting-google-shopping' || 'flux-google-merchant' || 'upf_license') )  	{
        /** Register */
	    wp_register_style('upf-plugin-page-css', plugins_url('inc/css/admin.css', __FILE__), array(), '1.0.0', 'all');
	    wp_register_style('upf-plugin-tabs-css', plugins_url('inc/css/tabs.scss', __FILE__), array(), '1.0.0', 'all');
	    		 
	    /** Enqueue */ 
	    wp_enqueue_style( 'upf-plugin-page-css');
	    wp_enqueue_style( 'upf-plugin-tabs-css');
	    wp_enqueue_script( 'tabs', plugins_url('inc/js/tabs.js', __FILE__), array( 'jquery'), '1.0.0', true );
	    
	    }
    }
	add_action('admin_enqueue_scripts', 'wps_upf_enqueue');



// Création des colonnnes personnalisées 

	//création colonne
	function set_custom_edit_mycpt_columns( $columns ) {
	  $date = $colunns['date'];
	  unset( $columns['date'] );
	  //$columns['_brand'] = __( 'Brand', 'wpshopping_lang' );
	  $columns['gtin'] = __( 'Bar code', 'wpshopping_lang' );
	  $columns['_mpn'] = __( 'MPN', 'wpshopping_lang' );
	  $columns['date'] = $date;
	
	  return $columns;
	}
	add_filter( 'manage_product_posts_columns', 'set_custom_edit_mycpt_columns' );
	
	
	//affiche les données
	add_action('manage_posts_custom_column', 'misha_populate_both_columns', 10, 2);
	function misha_populate_both_columns( $column_name, $id ) {
		// if you have to populate more that one columns, use switch()
		switch( $column_name ) :
			case 'gtin': {
				echo get_post_meta( $id, '_gtin', true );
				break;
			}
			case '_mpn' : {
		      echo get_post_meta( $postid, '_mpn', true );  
		      break;
			}
		endswitch;
	}
	
	
	//sortable (tri)
	function wps_upf_set_custom_sortable_columns( $columns ) {
	  $columns['gtin'] = '_gtin';
	  //$columns['_brand'] = '_brand';
	  $columns['_mpn'] = '_mpn';
	
	  return $columns;
	}
	add_filter( 'manage_edit-product_sortable_columns', 'wps_upf_set_custom_sortable_columns' );
	
	
	
	//ajouter le champ GTIM dans quick edit
	add_action( 'woocommerce_product_quick_edit_end', function($product){
		    ?>
		    <div class="custom_field_demo">
		        <label class="alignleft">
		        	<span class="title"><?php _e('Bar code', 'wpshopping_lang' ); ?></span>
		        	<span class="input-text-wrap">
						<input type="text" name="_gtin" class="text" placeholder="" value="">
					</span>
		        </label>
		    </div>
		    <?php
	}, 10, 1);
	
	
	add_action('woocommerce_product_quick_edit_save', function($product){
		/*
		Notes: Met à jour
		$_REQUEST['_gtin'] -> the custom field we added above
		Only save custom fields on quick edit option on appropriate product types (simple, etc..)
		Custom fields are just post meta
		*/
		
		if ( $product->is_type('simple') || $product->is_type('external') ) {
		
		    $post_id = $product->id;
		
		    if ( isset( $_REQUEST['_gtin'] ) ) {
		
		        $customFieldDemo = trim(esc_attr( $_REQUEST['_gtin'] ));
		
		        // Do sanitation and Validation here
		
		        update_post_meta( $post_id, '_gtin', wc_clean( $customFieldDemo ) );
		    }
		}
	}, 10, 1);
	
	//Affiche les données dans la case avec le fichier JS
	add_action( 'admin_enqueue_scripts', 'misha_enqueue_quick_edit_population' );
	function misha_enqueue_quick_edit_population( $pagehook ) {
	 
		// do nothing if we are not on the target pages
		if ( 'edit.php' != $pagehook ) {
			return;
		}
	 
		wp_enqueue_script( 'populatequickedit', plugins_url( '/inc/js/populate.js', __FILE__ ), array( 'jquery' ) );
	}

	
	//résultats
	function wps_upf_custom_orderby( $query ) {
	  if ( ! is_admin() )
	    return;
	
	  $orderby = $query->get( 'orderby');
	
	  if ( '_gtin' == $orderby ) {
	    $query->set( 'meta_key', '_gtin' );
	    $query->set( 'orderby', 'meta_value_num' );
	  }
	  
	  if ( '_mpn' == $orderby ) {
	    $query->set( 'meta_key', '_mpn' );
	    $query->set( 'orderby', 'meta_value' );
	  }
	  
	}
	add_action( 'pre_get_posts', 'wps_upf_custom_orderby' );
	
// Recherche admin par custom field
	/*function wps_upf_request_query( $query_vars ) {
	
		global $typenow;
		global $wpdb;
		global $pagenow;
	
		if ( 'product' === $typenow && isset( $_GET['s'] ) && 'edit.php' === $pagenow ) {
			$search_term            = esc_sql( sanitize_text_field( $_GET['s'] ) );
			$meta_key               = '_gtin';
			$post_types             = array( 'product', 'product_variation' );
			$search_results         = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT DISTINCT posts.ID as product_id, posts.post_parent as parent_id FROM {$wpdb->posts} posts LEFT JOIN {$wpdb->postmeta} AS postmeta ON posts.ID = postmeta.post_id WHERE postmeta.meta_key = '{$meta_key}' AND postmeta.meta_value LIKE %s AND posts.post_type IN ('" . implode( "','", $post_types ) . "') ORDER BY posts.post_parent ASC, posts.post_title ASC",
				'%' . $wpdb->esc_like( $search_term ) . '%'
			)
		);
		$product_ids            = wp_parse_id_list( array_merge( wp_list_pluck( $search_results, 'product_id' ), wp_list_pluck( $search_results, 'parent_id' ) ) );
		$query_vars['post__in'] = array_merge( $product_ids, $query_vars['post__in'] );
	}

	return $query_vars;
}

add_filter( 'request', 'wps_upf_request_query', 20 );*/
	
		

// Add our text to the quick edit box
	function wps_upf_on_quick_edit_custom_box($column_name, $post_type)
	{
	    if ('dummy' == $column_name) {
	        echo 'Extra content in the quick edit box';
	    }
	}
	//add_action('quick_edit_product_custom_box', 'wps_upf_on_quick_edit_custom_box', 10, 2);


// Add our text to the bulk edit box
function wps_upf_on_bulk_edit_custom_box($column_name, $post_type)
{
    if ('dummy' == $column_name) {
        echo 'Extra content in the bulk edit box';
    }
}
//add_action('bulk_edit_product_custom_box', 'wps_upf_on_bulk_edit_custom_box', 10, 2);


/***************************
	    MICRO DATA
***************************/

//ajouter des données structurées manquante aux fiches produits
function omai_woocommerce_structured_data_product_offer( $markup, $product ) {
	
	if (is_product()) {
		//condition [etat]
		$condition = get_post_meta(get_the_ID(),'_condition',true);
		if ($condition = "new"){ $itemCondition = 'http://schema.org/NewCondition'; }
		elseif ($condition = "used"){$itemCondition = 'http://schema.org/UsedCondition';}
		elseif ($condition = "refurbished"){$itemCondition = 'http://schema.org/RefurbishedCondition';}
		
		if ( empty( $markup[ 'itemCondition' ] ) ) {
			$markup[ 'itemCondition' ] = $itemCondition;
		}
	}
	return $markup;
}
add_filter( 'woocommerce_structured_data_product_offer', 'omai_woocommerce_structured_data_product_offer', 10, 2 );


//ajouter les micro data
function omai_woocommerce_structured_data_product( $markup, $product ) {
	
	if (is_product()) {
		//condition [etat]
		$brand_term = get_the_terms( get_the_ID(), 'brand' );
		$brand = $brand_term[0]->name;
		if ( empty( $markup[ 'brand' ] ) ) {
			$markup[ 'brand' ] = array(
		      '@type' => 'Thing',
		      'name'  => $brand,
		    );
		}

		//GTIN13
		$gtin  = get_post_meta(get_the_ID(),'_gtin', true );
		$nbr = strlen($gtin);
		
		if ($nbr == 8){ $gtin_format = 'gtin8'; }
		elseif ($nbr == 12){ $gtin_format = 'gtin12'; }
		elseif ($nbr == 13){ $gtin_format = 'gtin13'; }
		elseif ($nbr == 14){ $gtin_format = 'gtin13'; }
		else { $gtin_format = ''; }
		

		if ( empty( $markup[ $gtin_format ] ) ) {
			$markup[ $gtin_format ] = $gtin;
		}
	}
	return $markup;
}
add_filter( 'woocommerce_structured_data_product', 'omai_woocommerce_structured_data_product', 10, 2 );




//langage
	function wps_upf_load_lang() {
		load_plugin_textdomain( 'wpshopping_lang', false, plugin_basename( dirname( __FILE__ ) ) . "/languages" );
	}
	add_action('plugins_loaded', 'wps_upf_load_lang');
	
	
	include('inc/google-shopping/google-category-field.php');

		
//options onglet général
	function wps_upf_register_option(){
		register_setting('wps_upf_options', 'wps_unique_brand');
		register_setting('wps_upf_options', 'wps_global_shipping');
		register_setting('wps_upf_options', 'wps_choix_Apparel');
		register_setting('wps_upf_options', 'wps_choix_energy');
		register_setting('wps_upf_options', 'wps_choix_adult');
		register_setting('wps_upf_options', 'wps_choix_color');
		register_setting('wps_upf_options', 'wps_choix_gender');
		register_setting('wps_upf_options', 'wps_choix_size');
		register_setting('wps_upf_options', 'wps_choix_age');
		register_setting('wps_upf_options', 'wps_mini_price');
		register_setting('wps_upf_options', 'wps_excluded_destination_shopping');
		register_setting('wps_upf_options', 'wps_excluded_destination_shopping_actions');
		register_setting('wps_upf_options', 'wps_excluded_destination_display_ads');
		register_setting('wps_upf_options', 'wps_adwords_id');
		register_setting('wps_upf_options', 'wps_adword_custom_label');
		register_setting('wps_upf_options', 'wps_outofstock');
		register_setting('wps_upf_options', 'wps_choix_variant');
		register_setting('wps_upf_options', 'wps_custom_label_0');
		register_setting('wps_upf_options', 'wps_custom_label_1');
		register_setting('wps_upf_options', 'wps_custom_label_2');
		register_setting('wps_upf_options', 'wps_custom_label_3');
		register_setting('wps_upf_options', 'wps_custom_label_4');
	}
	add_action('admin_init', 'wps_upf_register_option');
	
//options page Google merchant
	function wps_upf_register_googleshopping(){
		register_setting('wps_google_shopping', 'wps_category_general');
		register_setting('wps_google_shopping', 'wps_choix_adword');
		register_setting('wps_google_shopping', 'wps_website_verification');
		register_setting('wps_google_shopping', 'wps_pixel_verification');
	}
	add_action('admin_init', 'wps_upf_register_googleshopping');
		
	
	
	
	$choix_Apparel = get_option('wps_choix_Apparel');
	$choix_energy = get_option('wps_choix_energy');
	$choix_adult = get_option('wps_choix_adult');
	$unique_brand = get_option('wps_unique_brand');
	$global_shipping = get_option('wps_global_shipping');
	$license = get_option('wps_upf_licence_key');
	$valid = get_option('wps_upf_licence_status');
	$error = get_option('wps_upf_licence_error');
	$choix_color = get_option('wps_choix_color');
	$choix_gender = get_option('wps_choix_gender');
	$choix_size = get_option('wps_choix_size');
	$choix_age = get_option('wps_choix_age');
	$mini_price = get_option('wps_mini_price');
	$adwords_id = get_option('wps_adwords_id');
	
	
//balise adwords remarketing
	function wps_upf_adwords_global_tag() {
		$adwords_id = get_option('wps_adwords_id');
    
    echo "\n<!-- Global site tag (gtag.js) - AdWords: ". str_replace( 'AW-', '' ,$adwords_id) ." -->\n"; ?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $adwords_id ?>"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
		
			gtag('config', '<?php echo $adwords_id ?>');
		</script>
    <?php
	}
	//add_action('wp_head', 'wps_upf_adwords_global_tag');
	
	
//Balise suivit event adwords
	function wps_upf_adwords_extrait_event() {

		if (is_home()){ $ecomm_pagetype = 'home'; }
		elseif (is_search()){ $ecomm_pagetype = 'searchresults'; }
		elseif (is_product_category()){ $ecomm_pagetype = 'category'; }
		elseif (is_product()){ $ecomm_pagetype = 'product'; }
		elseif (is_cart()){ $ecomm_pagetype = 'cart'; }
		elseif (is_checkout()){ $ecomm_pagetype = 'purchase'; }
		else { $ecomm_pagetype = 'other'; }
		
		$product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
		$single_cat = array_shift( $product_cats );
		
		$adwords_id = get_option('wps_adwords_id');
    ?>
	<script>
			gtag('event', 'page_view', {
		    'send_to': '<?php echo $adwords_id ?>',
		    'ecomm_pagetype': '<?php echo $ecomm_pagetype ?>',
		    'ecomm_prodid': '<?php echo get_the_id() ?>',
		    'ecomm_category': '<?php echo $single_cat->name ?>',
		    'user_id': '<?php echo get_current_user_id() ?>',
			});
		</script>
    <?php
	}
	//add_action('wp_head', 'wps_upf_adwords_extrait_event');

	
	
//message si woocommerce pas activé
	if( is_admin() ) {
		function wps_upf_woo_active_notice() {
				?>
				<div class="error">
						<p><?php _e( 'It seems that <a href="/wp-admin/plugin.php">Woocommerce</a> is not installed. Please activate it to use WP Shopping', 'wpshopping_lang' ); ?></p>	
				</div>
				<?php
		}
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			add_action( 'admin_notices', 'wps_upf_woo_active_notice' );
		}
	}
	
	
//message si woocommerce n'est pas en version 2.5
	if( is_admin() ) {
		function wps_upf_notice() {
			$plugin_data = get_plugin_data( WP_PLUGIN_DIR .'/woocommerce/woocommerce.php');
			$wooc_version = $plugin_data['Version'];
				?>
				<div class="error">
						<p><?php _e( 'Attention, vous utilisez Woocommerce '.$wooc_version.', Pour utiliser Google Shopping dans le meilleures conditions, votre version de WooCommerce doit être en version 2.5 minimum', 'wpshopping_lang' ); ?></p>	
				</div>
				<?php
		}
		/*if ( $wooc_version*100 >= 2500 ) {
			add_action( 'admin_notices', 'wps_upf_notice' );
		}*/
	}
	
// Register Custom Taxonomy
if ( ! function_exists( 'brand_ultimatefeed' ) ) {

	// Register Custom Taxonomy
	function brand_ultimatefeed() {
	
		$labels = array(
			'name'                       => _x( 'Brands', 'Taxonomy General Name', 'wpshopping_lang' ),
			'singular_name'              => _x( 'Brand', 'Taxonomy Singular Name', 'wpshopping_lang' ),
			'menu_name'                  => __( 'Brands', 'wpshopping_lang' ),
			'all_items'                  => __( 'All Items', 'wpshopping_lang' ),
			'parent_item'                => __( 'Parent Item', 'wpshopping_lang' ),
			'parent_item_colon'          => __( 'Parent Item:', 'wpshopping_lang' ),
			'new_item_name'              => __( 'New Item Name', 'wpshopping_lang' ),
			'add_new_item'               => __( 'Add New Item', 'wpshopping_lang' ),
			'edit_item'                  => __( 'Edit Item', 'wpshopping_lang' ),
			'update_item'                => __( 'Update Item', 'wpshopping_lang' ),
			'view_item'                  => __( 'View Item', 'wpshopping_lang' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'wpshopping_lang' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'wpshopping_lang' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'wpshopping_lang' ),
			'popular_items'              => __( 'Popular Items', 'wpshopping_lang' ),
			'search_items'               => __( 'Search Items', 'wpshopping_lang' ),
			'not_found'                  => __( 'Not Found', 'wpshopping_lang' ),
			'no_terms'                   => __( 'No items', 'wpshopping_lang' ),
			'items_list'                 => __( 'Items list', 'wpshopping_lang' ),
			'items_list_navigation'      => __( 'Items list navigation', 'wpshopping_lang' ),
		);
		$rewrite = array(
			'slug'                       => 'brand',
			'with_front'                 => true,
			'hierarchical'               => false,
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'rewrite'                    => $rewrite,
		);
		register_taxonomy( 'brand', array( 'product' ), $args );
		
	
		// ajoute le term "marque" au produit s'il n'existe pas déjà
		$terms = wp_count_terms( 'brand' );
	
		if( $terms == 0 ) {
			
			// WP_Query arguments
			$args = array(
		            'post_type' => 'product',
		            'posts_per_page' => -1
		            );
					    
			// The Query
			$brand_query = new WP_Query( $args );;
			
			// The Loop
			if($brand_query->have_posts()) : while ($brand_query->have_posts() ) : $brand_query->the_post();
				
					$brand = get_post_meta( get_the_ID(), '_brand', true );
					
					if( !term_exists( $brand, 'brand' ) ) {
						wp_insert_term(
				           $brand,
				           'brand',
				           array(
				             'description' => '',
				             'slug'        => '',
				           )
				        );
					}
		
				//wp_set_post_terms( get_the_ID(), $brand, 'brand' );
				
			endwhile;
			endif;
			// Restore original Post Data
			wp_reset_postdata();
		
		}
	
	}
	add_action( 'init', 'brand_ultimatefeed', 0 );
}




//Balise Meta google verif
	function wps_upf_google_verification() {
		$wps_website_verification = get_option('wps_website_verification');
		echo $wps_website_verification;
	
	}
	add_action('wp_head','wps_upf_google_verification');
	

// wps_upf_top_menu_google_shopping() displays the page content for the custom Google et Facebook Shopping menu
	function wps_upf_top_menu_google_shopping() { include 'inc/admin/option.php'; }

// mt_sublevel_page() displays the page content for the first submenu
// of the custom Google et Facebook Shopping menu
	function settings_sublevel_page() { include 'inc/admin/settings.php'; }
	function gs_sublevel_page() { include 'inc/google-shopping/google-shopping-option.php'; }
	function addon_sublevel_page() { include 'inc/admin/addon.php'; }

	
	function wps_upf_initialize_cmb_meta_boxes() {
		if ( ! class_exists( 'cmb_Meta_Box' ) )
			require_once(plugin_dir_path( __FILE__ ) . 'init.php');
	}


// marketplace ajout pour l'admin fiche produit
	function wps_tools_general_custom() {
		global $woocommerce, $post;
		
		
		echo '<div class="options_group">';
			woocommerce_wp_text_input(
					array(
					'id' => '_gtin',
					'label' => __('GTIN', 'wpshopping_lang'),
					'placeholder' => '',
					'description' => __('Use the \'gtin\' attribute to submit Global Trade Item Numbers (GTINs)', 'wpshopping_lang'),
					'type' => 'number',
					'custom_attributes' => array(
						'step' => 'any',
						'min' => '13'
						)
					)	
			);
			
			/*woocommerce_wp_text_input(
				array(
					'id'			=> '_brand',
					'label'			=> __('Brand', 'wpshopping_lang'),
					'desc_tip'		=>'true',
					'description'	=> __('You must not provide your store name as the brand unless you manufacture the product.', 'wpshopping_lang'),	
					)	
			);*/
			
			woocommerce_wp_text_input(
				array(
					'id'			=> '_mpn',
					'label'			=> __('MPN', 'wpshopping_lang'),
					'desc_tip'		=>'true',
					'description'	=> __('A Manufacturer Part Number is used to reference and identify a product using a manufacturer specific naming other than GTIN.', 'wpshopping_lang'),	
					)	
			);
			
			woocommerce_wp_text_input(
				array(
					'id'			=> '_product_shipping',
					'label'			=> __('Product Shipping', 'wpshopping_lang'),
					'desc_tip'		=>'true',
					'description'	=> __('.', 'wpshopping_lang'),	
					)	
			);
			
			woocommerce_wp_select(
				array(
					'id'			=> '_condition',
					'label'			=> __('Condition', 'wpshopping_lang'),
					'options'		=> array(
						'new'			=> __('New', 'wpshopping_lang'),
						'used'			=> __('Used', 'wpshopping_lang'),
						'refurbished'	=> __('Refurbished', 'wpshopping_lang'),
						)	
					)
			);	
			
		if (get_option('wps_choix_adult') =="1"){
			woocommerce_wp_checkbox(
				array(
					'id'			=> '_adult',
					//'wrapper_class'	=> 'show_if_simple',
					'label'			=> __('Adult', 'wpshopping_lang'),
					'description'	=> __('The adult status assigned to your product listings through the ‘adult’ attribute affects where product listings can show. For example, "adult" or "non-family safe" product listings aren\'t allowed to be shown in certain countries or to a certain audience.', 'wpshopping_lang'),	
					)
			);	
		}
		
		echo '</div>';
		
		if (get_option('wps_choix_energy') =="1"){
		echo '<div class="options_group">';
		woocommerce_wp_select(
			array(
					'id'			=> '_energy',
					'label'			=> __('Energy efficiency class', 'wpshopping_lang'),
					'options'		=> array(
						'none'			=> __('none', 'wpshopping_lang'),
						'A+++'			=> __('A+++', 'wpshopping_lang'),
						'A++'			=> __('A++', 'wpshopping_lang'),
						'A+'			=> __('A+', 'wpshopping_lang'),
						'A'				=> __('A', 'wpshopping_lang'),
						'B'				=> __('B', 'wpshopping_lang'),
						'C'				=> __('C', 'wpshopping_lang'),
						'D'				=> __('D', 'wpshopping_lang'),
						'E'				=> __('E', 'wpshopping_lang'),
						'F'				=> __('F', 'wpshopping_lang'),
						'G'				=> __('G', 'wpshopping_lang'),
						)	
					)
			);
				
		echo '</div>';
		}
		
		
		$category_google_single = get_post_meta(get_the_ID(),'_google_category_single',true);
		$category_google_general = get_option('wps_category_general');
		echo '<div>';
	if (empty($category_google_single) && empty($category_google_category) && !empty($category_google_general)){
		echo __('<i>Current category : '.$category_google_general.'</i> | <small><a href="http://www.google.com/basepages/producttype/taxonomy.en-US.txt" target="_blank">Change Google Taxonomie</A></small>', 'wpshopping_lang');
	} elseif (empty($category_google_single) && !empty($category_google_category)){
		echo __('<i>Current category : '.$category_google_category.'</i> | <small><a href="http://www.google.com/basepages/producttype/taxonomy.en-US.txt" target="_blank">Change Google Taxonomie</A></small>', 'wpshopping_lang');;
	} else {
		echo __('It is strongly recommended that you use the most specific applicable category for all your items from the <a href="http://www.google.com/basepages/producttype/taxonomy.en-US.txt" target="_blank">full Google product taxonomy</A>. ', 'wpshopping_lang');
	}
		
		
		woocommerce_wp_text_input(
				array(
					'id'			=> '_google_category_single',
					'label'			=> __('Google Category', 'wpshopping_lang'),
					'desc_tip'		=>'true',
					'description'	=> __('Any category from Google’s product taxonomy must include the full path. For example, "Apparel & Accessories > Clothing > Jeans" is an acceptable value, but "Jeans" is not.<br />Find the list here <a href="http://www.google.com/basepages/producttype/taxonomy.en-US.txt" target="_blank"> Google Taxonomie</A><br />', 'wpshopping_lang'),	
					)	
			);

		echo '</div>';
		
		echo '<div class="options_group">';
			woocommerce_wp_checkbox(
				array(
					'id'			=> '_hide_product',
					//'wrapper_class'	=> 'show_if_simple',
					'label'			=> __('Hide product', 'wpshopping_lang'),
					'description'	=> __('Hide this product from your products feed', 'wpshopping_lang'),	
					)
			);
				
		echo '</div>';

		
		
	}
	add_action('woocommerce_product_options_general_product_data', 'wps_tools_general_custom');
	
	
	// ajouter si simple produit, si variable c'est pas post ID pour save
	function woo_add_custom_general_fields_save($post_id){
			
		$gtin = sanitize_key($_POST['_gtin']);
		if( !empty( $gtin ) ){
				update_post_meta( $post_id, '_gtin', esc_attr( $gtin ) );
		}
		
		
		update_post_meta( $post_id, '_brand', $_POST['_brand'] );
		
		update_post_meta( $post_id, '_mpn', sanitize_key($_POST['_mpn']) );
		
		update_post_meta( $post_id, '_product_shipping', sanitize_key($_POST['_product_shipping']) );
		
		update_post_meta( $post_id, '_google_category_single', $_POST['_google_category_single'] );
		
		update_post_meta( $post_id, '_gtin', sanitize_key($_POST['_gtin']) );
		

		
		//update_post_meta( $post_id, '_condition', $_POST['_condition'] );
		
		// Select
		$condition = $_POST['_condition'];
		if( !empty( $condition ) )
		update_post_meta( $post_id, '_condition', esc_attr( $condition ) );
		
		$energy = $_POST['_energy'];
		if( !empty( $energy ) )
		update_post_meta( $post_id, '_energy', esc_attr( $energy ) );

		
		$adult = isset( $_POST['_adult'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_adult', $adult );
		
		
		$hide_product = isset( $_POST['_hide_product'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_hide_product', $hide_product );
		
		// ajoute le term "marque" au produit s'il n'existe pas déjà
		/*
		   if( !term_exists( $_POST['_brand'], 'brand' ) ) {
		       wp_insert_term(
		           $_POST['_brand'],
		           'brand',
		           array(
		             'description' => '',
		             'slug'        => '',
		           )
		       );
		   }
		*/
		
		
	}
	add_action('woocommerce_process_product_meta', 'woo_add_custom_general_fields_save');


// custom meta pour les variantes ... (voir http://www.remicorson.com/woocommerce-custom-fields-for-variations/)
	
 
// Add Variation Settings
	add_action( 'woocommerce_product_after_variable_attributes', 'wps_upf_variation_settings_fields', 10, 3 );

// Create new fields for variations
function wps_upf_variation_settings_fields( $loop, $variation_data, $variation ) {
	
	woocommerce_wp_text_input(
					array(
					'id' => '_gtin[' . $variation->ID . ']',
					'label' => __('GTIN', 'wpshopping_lang'),
					'placeholder' => '',
					'description' => __('Use the \'gtin\' attribute to submit Global Trade Item Numbers (GTINs)', 'wpshopping_lang'),
					'type' => 'number',
					'custom_attributes' => array(
						'step' => 'any',
						'min' => '13'
						),
					'value'       => get_post_meta( $variation->ID, '_gtin', true ),
					)	
			);
		
}

// Save Variation Settings
	add_action( 'woocommerce_save_product_variation', 'save_wps_upf_variation_settings_fields', 10, 2 );


// Sauvegarder les nouvelles variation
function save_wps_upf_variation_settings_fields( $post_id ) {
	
	// GTIN
	if (isset($_POST['_gtin']))
	{
	    $text_field = sanitize_text_field($_POST['_gtin'][ $post_id ]);
	}
	if( ! empty( $text_field ) ) {
		update_post_meta( $post_id, '_gtin',  $text_field );
	}
	
	// Text Field color
	if (isset($_POST['_var_color']))
	{
	    $text_field = sanitize_text_field($_POST['_var_color'][ $post_id ]);
	}
	if( ! empty( $text_field ) ) {
		update_post_meta( $post_id, '_var_color',  $text_field );
	}
	
	// Text _var_size
	if (isset($_POST['_var_size']))
	{
	    $text_field = sanitize_text_field($_POST['_var_size'][ $post_id ]);
	}
	if( ! empty( $text_field ) ) {
		update_post_meta( $post_id, '_var_size',  $text_field );
	}
	
	// Number Field
	if (isset($_POST['_number_field']))
	{
	    $number_field = sanitize_text_field($_POST['_number_field'][ $post_id ]);
	}
	
	if( ! empty( $number_field ) ) {
		update_post_meta( $post_id, '_number_field',  $number_field );
	}
	// Textarea
	if (isset($_POST['_textarea']))
	{
	    $textarea = sanitize_text_field($_POST['_textarea'][ $post_id ]);
	}
	if( ! empty( $textarea ) ) {
		update_post_meta( $post_id, '_textarea',  $textarea );
	}
	
	// Select _var_gender
	if (isset($_POST['_var_gender']))
	{
	    $select = sanitize_text_field($_POST['_var_gender'][ $post_id ]);
	}
	if( ! empty( $select ) ) {
		update_post_meta( $post_id, '_var_gender',  $select );
	}
	
	// Select _var_agegroup
	if (isset($_POST['_var_agegroup']))
	{
	    $select = sanitize_text_field($_POST['_var_agegroup'][ $post_id ]);
	}
	if( ! empty( $select ) ) {
		update_post_meta( $post_id, '_var_agegroup',  $select );
	}
	
	// Checkbox
	if (isset($_POST['_checkbox']))
	{
	    $checkbox = isset( $_POST['_checkbox'][ $post_id ] ) ? 'yes' : 'no';
	}
	if( ! empty( $select ) ) {
		update_post_meta( $post_id, '_checkbox',  $select );
	}
	
	// Hidden field
	// Avant d'utiliser $_POST['truc']
	if (isset($_POST['_hidden_field']))
	{
	    $hidden = sanitize_text_field($_POST['_hidden_field'][ $post_id ]);
	}
	if( ! empty( $hidden ) ) {
		update_post_meta( $post_id, '_hidden_field',  $hidden );
	}
}
	
//Créer le flux
	if ( ! is_plugin_active('ultimate-products-feed-pro/index.php') or get_option( 'wps_upf_licence_statut_on' ) != "valid" ) {
		include('inc/google-shopping/google-shopping-feed.php');
	}
	
	
?>