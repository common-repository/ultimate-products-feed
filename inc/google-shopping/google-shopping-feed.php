<?php
		
// Construction du FLUX XML *****************************************************
	// Add permalink structure and flush on plugin activation
	//register_activation_hook( __FILE__, 'wps_upf_googleshopping_activate' );
	function wps_upf_googleshopping_activate() {
	    googleshopping_add_feed();
	    flush_rewrite_rules();
	}
	// Flush on plugin deactivation
	//register_deactivation_hook( __FILE__, 'wps_upf_googleshopping_deactivate' );
	function wps_upf_googleshopping_deactivate() {
	    flush_rewrite_rules();
	}
// Register a feed googleshopping
	function googleshopping_add_feed() {
	    add_feed( 'googleshopping', 'wps_upf_googleshopping_do_feed' );
	}
	add_action( 'init', 'googleshopping_add_feed' );
	
// Le FLux Google Shopping
	function wps_upf_googleshopping_do_feed($in) {
		
		$urlpage = $_SERVER['REQUEST_URI']; //url de la page
		$urlsite = get_bloginfo_rss('url'); //url du site
		$epur = array("/feed/googleshopping", $urlsite);
		$categoryproduct = str_replace($epur, "", $urlpage);
		$license 	= get_option( 'ubeez_wps_license_key' );
		$status 	= get_option( 'wps_upf_licence_statut_on' );
		$error 	= get_option( 'wps_license_error' );
		$post=-1;
		$num_posts = wp_count_posts( 'product' );
		$num_product = number_format_i18n( $num_posts->publish ); //nombre de produits publiés
		$choix_energy = get_option('wps_choix_energy');
		$charset = get_option('blog_charset');
		$choix_Apparel = get_option('wps_choix_Apparel');
		$license 	= get_option( 'ubeez_wps_license_key' );
		$wps_outofstock 	= get_option('wps_outofstock');
		$terms = get_the_terms( $post->ID, 'product_cat' );
		$choix_variant = get_option('wps_choix_variant');
				
// WP_Query arguments
		if (is_product_category()){
		$args = array (
			'post_type'             => 'product',
			'post_status'           => 'publish',
			'posts_per_page'        => $post,
			'tax_query'             => array(
		        array(
		            'taxonomy'      => 'product_cat',
		            'field'         => 'slug',
		            'terms'         => $terms[0]->name,
		            'operator'      => 'IN'
		        )
		    )
		);
		} else {
			$args = array (
			'post_type'             => 'product',
			'post_status'           => 'publish',
			'posts_per_page'        => $post,
		);
		}
		
// The Query
		$query = new WP_Query( $args );
		$plugin_data = get_plugin_data( WP_PLUGIN_DIR .'/woocommerce/woocommerce.php' );
		$wooc_version = $plugin_data['Version'];
		$wc_mini = 2500;
		$wc_version = $wooc_version*1000;
		
// Restore original Post Data
wp_reset_postdata();
		echo '<?xml version="1.0" encoding="'.$charset.'" ?>';
		?>			
<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
	<channel>
		<title><?php bloginfo_rss('name') ?></title>
		<link><?php echo bloginfo_rss('url') ?></link>
		<description><?php bloginfo_rss("description") ?></description>
		<generator>WP Shopping by WP-Shopping (https://wp-shopping.com) - WC<?php echo $wooc_version ?></generator>
		<statut><?php echo $status ?> - <?php echo $num_product ?> products</statut>
		<error><?php echo $error ?></error>
		

<?php
// The Loop
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		
		global $post, $product;

		
		
		
		$hide = get_post_meta(get_the_ID(),'_hide_product',true);
		//$cache_category = 'choix_hide_category_' . $tag->term_id;
		//$hide_category = get_option( $cache_category );

		//print_r($product);
		$id = get_the_ID();
		
		$availability_dislay = get_post_meta($id,'_stock_status',true);
		
		$availability = get_post_meta(get_the_ID(),'_stock_status',true);
			
			if ($wps_outofstock == '1' && $availability_dislay == 'outofstock') {
				$hide_stock = 'yes';
			} else {
				$hide_stock = 'no';
			}

		//$product_type = $product->product_type;

		
//TROUVER LES CATEGORIES MASQUEE POUR REMPLACER '8' juste apres (si $_POST['choix_hide_category'] = 1)
	global $post;
	$terms = get_the_terms( $post->ID, 'product_cat' );
	$count_hide_cat=0;
	foreach ( $terms as $term ){
	    $category_name = $term->term_id;
	    $category_google_category = get_option( 'category_custom_order_'.$category_name);
	    $cache_category = 'choix_hide_category_' . $category_name;
		$hide_category = get_option( $cache_category );
		$count_hide_cat=$count_hide_cat+$hide_category;
	};
	
	if ($wc_mini <= $wc_version){
		//$product = wc_get_product($post->ID);
		//$product = new WC_Product( get_the_ID() );
		}else{
		$product = get_product($post->ID);
		//$product = new WC_Product( get_the_ID() );
		}

	//determine si la variable catégorie est presente (sert à rien pour le moment pour le moment)
	//$hide_cat = array_filter($terms, function($object){return $object->term_id == '8';});
	//print_r($terms);
		
	$id = get_the_ID();
	$wps_mini_price = get_option('wps_mini_price');
	
	if ( $product->is_type( 'simple' ) ){ 
		$product_type = 'simple'; }
	
	
	if ( $product->is_type( 'simple' ) ){
//************************** PRODUIT SIMPLE *******************************

if ( is_plugin_active('wordpress-seo/wp-seo.php') and get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true) !="" ) {
	  $content = get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true);
	} elseif ( !empty(get_the_excerpt())){
			$content = htmlspecialchars (strip_tags (get_the_excerpt()));
	} else {
			$content = htmlspecialchars (strip_tags (get_the_content()));
	}	
	
	
$content = str_replace("\r\n", "", $content);
$content = str_replace("\n", "", $content);
$content = str_replace("&nbsp;", " ", $content);
$content = strip_tags($content); // Supprime les balises HTML et PHP d'une chaîne
//$content = htmlspecialchars ($content); // Convertit les caractères spéciaux en entités HTML
//$content = htmlentities ($content); // Convertit tous les caractères éligibles en entités HTML
//$content = html_entity_decode($content); // Convertit toutes les entités HTML en caractères normaux
//$content = str_replace("&", " et ", $content);
$content = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $content); //enleve les shortcode

if ( is_plugin_active('wordpress-seo/wp-seo.php') and get_post_meta(get_the_ID(), '_yoast_wpseo_title', true) !="" ) {
  	$title = get_post_meta(get_the_ID(), '_yoast_wpseo_title', true);
} else {
	$title = get_the_title();
}

$title = str_replace("&#215;", "x", $title);
$title = str_replace("&rsquo;", "'", $title);
$title = str_replace("&rsquo; ", "'", $title);
$title = str_replace("&#8220;", "'", $title);
$title = str_replace("&#8221;", "'", $title);
$title = str_replace("&laquo;&nbsp;", "", $title);
$title = str_replace("&nbsp;&raquo;", "", $title);
//$title = html_entity_decode($title, ENT_COMPAT, 'UTF-8');
//$title = htmlentities($title, ENT_QUOTES | ENT_IGNORE, "UTF-8");
//$title = htmlentities($title, ENT_QUOTES, $charset);`

$regular_price = wc_get_price_including_tax( $product );
$excluded_destination_shopping = get_option('wps_excluded_destination_shopping');
$excluded_destination_shopping_actions = get_option('wps_excluded_destination_shopping_actions');
$wps_excluded_destination_display_ads = get_option('wps_excluded_destination_display_ads');


//_breadcrumb pour le product_type
$prod_terms = get_the_terms( $post->ID, 'product_cat' );
foreach ($prod_terms as $prod_term) {

    // gets product cat id
    $product_cat_id = $prod_term->term_id;
    $product_cat_name = $prod_term->name;

    // gets an array of all parent category levels
    $ancestors = get_ancestors( $product_cat_id, 'product_cat' );  
    $ancestors = array_reverse($ancestors); //Reverse the array to put the top level ancestor first
}

$g_product_type = array();
foreach ($ancestors as $current_term_id){
	$taxonomy_terms = get_term_by('id', $current_term_id , 'product_cat');
	$g_product_type[] = $taxonomy_terms->name;
}
		
echo "\n<!-- ".$product_type." product : ".get_the_title().' - '.$availability_dislay."  -->\n" ?>
		<item>
			<g:title><?php echo ucfirst(strtolower($title)) ?></g:title>
			<g:description><?php echo $content ?></g:description>
			<g:link><?php the_permalink() ?></g:link>
			<g:id><?php echo $id; ?></g:id>	
		<?php if ( $product->is_type( 'bundle' ) ){ ?>
	<g:is_bundle>yes</g:is_bundle>
		<?php } 
		if($regular_price < $wps_mini_price && $excluded_destination_shopping == "1" || $hide == "yes" || $hide_stock == "yes" ){ ?>
			<g:excluded_destination>Shopping</g:excluded_destination>
		<?php }
		if($regular_price < $wps_mini_price && $excluded_destination_shopping_actions == "1" || $hide == "yes" || $hide_stock == "yes" ){ ?>
		<g:excluded_destination>ShoppingActions</g:excluded_destination>
		<?php }
		if($regular_price < $wps_mini_price && $wps_excluded_destination_display_ads == "1" || $hide == "yes" || $hide_stock == "yes"){ ?>
		<g:excluded_destination>DisplayAds</g:excluded_destination>
		<?php } 
		global $product;
		$condition = get_post_meta(get_the_ID($id),'_condition',true); 
		$devise = get_woocommerce_currency();
		$sale_price = get_post_meta(get_the_ID(),'_sale_price',true);
		if (get_post_meta(get_the_ID(),'_sale_price_dates_from',true) != ''){
		$sale_price_dates_from = date("c",get_post_meta(get_the_ID(),'_sale_price_dates_from',true));
		}
		if (get_post_meta(get_the_ID(),'_sale_price_dates_to',true) != ''){
		$sale_price_dates_to = date("c",get_post_meta(get_the_ID(),'_sale_price_dates_to',true));
		}
		//$debug_simple_product = get_post_meta(get_the_ID());
		//Décommenter pour debuger un produit
		//print_r($debug_simple_product);
		//print_r($flat_rate);
if ($condition !== "") { ?>
	<g:condition><?php echo $condition; ?></g:condition>
<?php } else { ?>
	<g:condition>new</g:condition>
<?php } ?>
			<g:price><?php echo $regular_price." ".$devise ?></g:price>
<?php if ($sale_price != "") { ?>
	<g:sale_price><?php echo $sale_price." ".$devise ?></g:sale_price>
<?php } 
	if ($sale_price_dates_from !="" && $sale_price_dates_to !=""){ ?>
	<g:sale_price_effective_date><?php echo $sale_price_dates_from."/".$sale_price_dates_to ?></g:sale_price_effective_date>
<?php } 
if ($availability == "instock") { $availability = "in stock"; } else {$availability = "out of stock"; } ?>
			<g:availability><?php echo $availability ?></g:availability>
<?php 
$post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
$post_thumbnail_url = wp_get_attachment_image_src($post_thumbnail_id, 'full'); 

$image_link = $post_thumbnail_url[0];
$image_link = str_replace("&ssl=1", "", $image_link);

//$brand = htmlspecialchars (get_post_meta(get_the_ID(),'_brand',true));
$brand = get_the_terms( get_the_ID(), 'brand' );
$unique_brand = htmlspecialchars (get_option('wps_unique_brand'));
//$wps_global_shipping = htmlspecialchars (get_option('wps_global_shipping'));
$gtin  = get_post_meta(get_the_ID(),'_gtin', true );
$adult = get_post_meta(get_the_ID(),'_adult',true);
$energy = get_post_meta(get_the_ID(),'_energy',true);
$category_google_single = get_post_meta(get_the_ID(),'_google_category_single',true);
$category_google_general = get_option('gmc_category_general');
$product_shipping = get_post_meta(get_the_ID(),'_product_shipping',true);
$global_shipping = get_option('wps_global_shipping');
//$defaultcountry = get_option('woocommerce_default_country');
$default = wc_get_base_location();
$default_country = $default['country'];
$defaultcountry = substr($default_country, 0, 2);

$weight_unit = get_option('woocommerce_weight_unit');
$weight  = get_post_meta(get_the_ID(),'_weight', true );
global $post;
$terms = get_the_terms( $post->ID, 'product_cat' );
foreach ( $terms as $term ){
    $category_id = $term->term_id;
    $category_google_category = get_option( 'category_custom_order_'.$category_id);
};
?>
<?php if (!empty($product_shipping)){ ?>
<g:shipping>
				<g:country><?php echo $defaultcountry; ?></g:country>
				<g:service>Standard</g:service>
				<g:price><?php echo $product_shipping." ".$devise; ?></g:price>
			</g:shipping>
<?php } else { ?>
			<g:shipping>
				<g:country><?php echo $defaultcountry; ?></g:country>
				<g:service>Standard</g:service>
				<g:price><?php echo $global_shipping." ".$devise; ?></g:price>
			</g:shipping>
<?php }
if (!empty($weight)){ ?>		
			<g:shipping_weight><?php echo $weight.' '.$weight_unit ?></g:shipping_weight> 
<?php } ?>
			<g:image_link><?php echo $image_link; ?></g:image_link>
<?php if (!empty($sku[0])){ ?>
			<g:mpn><?php echo $sku[0] ?></g:mpn>
<?php } ?>
<?php if (!empty($gtin)){ ?>
			<g:gtin><?php echo $gtin; ?></g:gtin>
<?php } ?>
<?php if (!empty($brand)){ ?>
			<g:brand><?php echo $brand; ?></g:brand>
<?php } ?>
<?php if (empty($brand) && !empty($unique_brand)){ ?>
			<g:brand><?php echo $unique_brand; ?></g:brand>
<?php } ?>
<?php if (!empty($sku[0]) || !empty($gtin)){ ?>	
			<g:identifier_exists>TRUE</g:identifier_exists>
<?php }else{ ?>
			<g:identifier_exists>FALSE</g:identifier_exists>
<?php } ?>
<?php if ($adult == "yes"){ ?>
			<g:adult>TRUE</g:adult>
<?php } ?>
<?php if (!empty($category_google_single)){ ?>
			<g:google_product_category><?php echo htmlspecialchars($category_google_single, ENT_QUOTES); ?></g:google_product_category>
<?php } ?>
<?php if (empty($category_google_single) && !empty($category_google_category)){ 
//foreach ( $terms as $term ){
//$category_name = $term->term_id;
//$category_google_category = get_option( 'category_custom_order_'.$category_name);
?>
			<g:google_product_category><?php echo htmlspecialchars($category_google_category, ENT_QUOTES); ?></g:google_product_category><?php 
//}; ?>
<?php } ?>
<?php if (empty($category_google_single) && empty($category_google_category) && !empty($category_google_general)){ ?>
			<g:google_product_category><?php echo htmlspecialchars($category_google_general, ENT_QUOTES); ?></g:google_product_category>
<?php } ?>	
			<g:product_type><?php echo implode(" > ", $g_product_type) . ' > ' . $product_cat_name; ?></g:product_type>
		</item>
<?php			
			
	} else {
		echo "";
	}
			
		
	} //while have a post
} else {
	echo "aucun produit pour le moment";
}
// Restore original Post Data
wp_reset_postdata();
?>	
	</channel>
</rss><?php } ?>