<div class="wrap">
	<h2><?php _e( 'Google Merchant Center' ); ?></h2>
		 
		<p><?php _e( 'Increase traffic to your website\'s store with Google Shopping. Submit your products to Google Shopping so shoppers can quickly and easily find your site when they\'re shopping online.', 'wpshopping_lang'); ?></p>
		<p><?php _e( 'Login to your <a href="http://www.google.fr/merchants/" target="_blank">Google Merchants</a>, and add your feed.', 'wpshopping_lang'); ?></p>
			
			
			<form method="post" class="form-horizontal" action="options.php">
			<?php settings_fields('wps_google_shopping'); ?>
				
				<table class="upf-admin-form-table" id="upf">
					<caption>
						<p><?php _e('Google vérification','wpshopping_lang'); ?></p>
					</caption>
					<tr valign="top">
				       	<th scope="row"><?php _e('Verification & Claiming', 'wpshopping_lang'); ?></th>
				        <td>
					    <input class='wps_website_verification' type='text' name='wps_website_verification'	 style="width:100%" value='<?php echo get_option("wps_website_verification") ?>' placeholder='exemple : <meta name="google-site-verification" content="1234567890" />' />		        
				        <p class="description"><?php _e('Copy the "Website Verification" meta tag. Find it on Google merchant dashboard : <br />Setting > Website Verification > Alternative methods > HTML Tag', 'wpshopping_lang'); ?></p>
				        <p><a href="<?php echo 'https://merchants.google.com' ?>" target="blank_"><?php _e('Google Merchants Dashboard', 'wpshopping_lang'); ?></a></p>				        
				    	</td>				       
					</tr>

				</table>
				
				<table class="upf-admin-form-table" id="upf">
					<caption>
						<p><?php _e('Your magic feed','wpshopping_lang'); ?></p>
					</caption>
					<tr valign="top">
				       	<th scope="row"><?php _e('Your Google Shopping Feed', 'wpshopping_lang'); ?></th>
				        <td>
					 
				        
				        <?php 
					        $url = get_bloginfo('url').'/feed/googleshopping';
					        
					        if ( is_plugin_active( 'qtranslate-x/qtranslate.php' ) ) {
						        
								$languages = qtrans_getSortedLanguages();

								foreach($languages as $lang) { 
									
									if($lang == "en"){
										$lang_flag = "uk";
									} else {
										$lang_flag = $lang;
									};
									
									?><p class="description"><img src="<?php echo plugins_url( 'qtranslate-x/flags/'.$lang_flag.'.png', 'qtranslate' ) ?>"> <a style="font-size:20px" href="<?php echo get_bloginfo('url').'/feed/googleshopping' ?>" target="_blank"><?php echo get_bloginfo('url').'/'.$lang.'/feed/googleshopping' ?></a><br/><?php 
								}
								
							} else { ?>
						
							    <p><a style="font-size:20px" href="<?php echo get_bloginfo('url').'/feed/googleshopping' ?>" target="_blank"><?php echo $url ?></a><br/> 
						
						<?php } ?>
				        
				        
				        <p class="description"><?php _e('if your feed google shopping dont work, you should save your permalinks again to activate the new feed: ', 'wpshopping_lang'); ?><a href="<?php echo get_bloginfo('url').'/wp-admin/options-permalink.php' ?>"><?php _e('Permalink', 'wpshopping_lang'); ?></a></p>
				        
				        </p>
				        </td>				       
					</tr>

				</table>
	
				<table class="upf-admin-form-table" id="upf">
					<caption>
						<p><?php _e('Google category','wpshopping_lang'); ?></p>
					</caption>
					<tr valign="top">
				       	<th scope="row"><?php _e('Google catégory', 'wpshopping_lang'); ?></th>
				        <td><input class="input-block-level" type="text" name="wps_category_general" style="width:100%" value="<?php echo get_option('wps_category_general'); ?>" placeholder="exemple : Jeux et jouets > Jeux de plein air > Accessoires pour jeux d'eau" />
						<p class="description"><?php _e('if you sell one type of product, copy the google category that best fits your site. If you sell different products, you will learn each of your categories in the appropriate fields : ', 'wpshopping_lang'); ; ?><a href="'.admin_url().'edit-tags.php?taxonomy=product_cat&post_type=product"><?php _e('Woocommerce catégory', 'wpshopping_lang'); ?></a>. <?php _e('You can also change the "Google category" for each item.', 'wpshopping_lang'); ?><br /><?php _e('The Google list is here : <a href="https://www.google.com/basepages/producttype/taxonomy.en-US.txt" target="_blank"> List</a>', 'wpshopping_lang'); ?><br /><small style="color:red"><?php _e('Please note that the Google list sometimes has problems\'s accents, we must rectify!', 'wpshopping_lang'); ?></small></p>

				        </td>
					</tr>
				</table>
								
				
				
				<?php
				$args = array(
			    //'number'     => $number,
			    'orderby'    => 'des',
			    //'order'      => $order,
			    //'hide_empty' => $hide_empty,
			    //'include'    => $ids
				);
				
				$urlpage = $_SERVER['REQUEST_URI']; //url de la page
				$urlsite = get_bloginfo_rss('url'); //url du site
				$epur = array("/feed/googleshopping", $urlsite);
				$categoryproduct = str_replace($epur, "", $urlpage);
				$urlplugin = plugins_url();
				
				$product_categories = get_terms( 'product_cat', $args );
				
				?>
				<!--
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Category feed', 'wpshopping_lang'); ?></th>
							<?php
							$count = count($product_categories);
							if ( $count > 0 ){
							?>
							<td>
						    	<?php		
								     echo "<ul>";
								     foreach ( $product_categories as $product_category ) {
								     echo '<li>' .$product_category->name . '</li>';
								        
								     }
								     echo "</ul>";
								?>
							</td>
							<td>
								<?php
								    echo "<ul>";
								    foreach ( $product_categories as $product_category ) {
									echo '<li><img src="'.$urlplugin.'/ultimate-products-feed/assets/img/xml-35-20.jpg" alt="XML" height="16" style="vertical-align:bottom"> <a href="' . get_term_link( $product_category ) . 'feed/googleshopping" target="_blank">' . get_term_link( $product_category ) . 'feed/googleshopping</a></li>';
									
								        
								     }
								     echo "</ul>";
								?>
							</td>
							<?php
							}
							?>
					</tr>
				</table>
				-->

				
				
				<?php submit_button(); ?>
			</form>
</div>