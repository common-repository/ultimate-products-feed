<?php

	if ( get_option('wps_upf_licence_statut_on') != 'valid' || !is_plugin_active( 'ultimate-products-feed-pro/index.php' ) ) {
		$pro = '<p style="color:#FFF;background:#eeeeee;text-align:center;width:51px;float:left;border-radius:20px;margin-top: 0px;padding:0px;"><a style="color:#FFF;" href="'.admin_url( 'admin.php?page=upf_license' ).'">Pro</a></p>';
	} else {
		$pro == '';
	}
?>
	
	<div class="wrap">
		<h2 class="upf"><?php _e( 'Settings Google Shopping' ); ?></h2>

		<div class="feature-section images-stagger-right">		
			<p><?php _e( 'Check the options that correspond to the products you sell. The sections that you check add menus in your product pages. You can change these options at the same time as your business evolves, add or remove at any time.', 'wpshopping_lang' ); ?></p>
		</div>
			
			<form method="post" class="form-horizontal" action="options.php">
			<?php settings_fields('wps_upf_options'); ?>
			
			<article class="tabbed-content tabs-side">
				<nav class="tabs">
					<ul>
						<li><a href="#side_tab1" class="active"><?php _e('Setting','wpshopping_lang'); ?></a></li>
						<li><a href="#side_tab2"><?php _e('Products options','wpshopping_lang'); ?></a></li>
						<li><a href="#side_tab3"><?php _e('Apparel attributes','wpshopping_lang'); ?></a></li>
						<li><a href="#side_tab4"><?php _e('Adwords setting','wpshopping_lang'); ?></a></li>
						<li><a href="#side_tab5"><?php _e('Adwords custom label','wpshopping_lang'); ?></a></li>
					</ul>
				</nav>
				
                <section id="side_tab1" class="item active" data-title="<?php _e('Setting','wpshopping_lang'); ?>">
	                
	                <div class="item-content">
                     
                    <table class="upf-admin-form-table" id="upf">
						<caption>
							<p><?php _e('Setting','wpshopping_lang'); ?></p>
						</caption>
	
						<tr valign="top">
							<th scope="row"><?php _e('Information', 'wpshopping_lang'); ?></th>
							<td>
							    <p class="description"><?php _e('You\'ll be able to optimize your Google Shopping feed for your business. Remember to add an average postage cost in the next tab, otherwise your feed will not be validated.', 'wpshopping_lang'); ?></p>
							</td>
						</tr>
						
                    </table>
                     
                    </div>
				</section>
					
					
					
				<section id="side_tab2" class="item" data-title="<?php _e('Apparel attributes','wpshopping_lang'); ?>">
					<div class="item-content">
						
					
					<table class="upf-admin-form-table" id="upf">
						<caption>
							<p><?php _e('Global options','wpshopping_lang'); ?></p>
						</caption>
	
						<tr valign="top">
							<th scope="row"><?php _e('Unique Brand', 'wpshopping_lang'); ?></th>
							<td><input class="input-block-level" type="text" name="wps_unique_brand" id="wps_unique_brand" style="width:60%" value="<?php echo get_option('wps_unique_brand'); ?>" />
							    <p class="description"><?php _e('If you sell products of different brands, leave it blank. You must not provide your store name as the brand unless you manufacture the product.', 'wpshopping_lang'); ?></p>
							</td>
						</tr>
						
						<tr valign="top">
							<th scope="row"><?php _e('Global Shipping', 'wpshopping_lang'); ?></th>
							<td><input class="input-block-level" type="text" name="wps_global_shipping" id="wps_global_shipping" style="width:60%" value="<?php echo get_option('wps_global_shipping'); ?>" />
							    <p class="description"><?php _e('Add an average shipping cost', 'wpshopping_lang'); ?></p>
							</td>
						</tr>
                    </table>
                    					
					<table class="upf-admin-form-table" id="upf">
						<caption>
							<p><?php _e('Products options','wpshopping_lang'); ?></p>
						</caption>
						
						<tr valign="top">
							<th scope="row"><?php _e('Variants', 'wpshopping_lang'); ?></th>
							<td>
							    <label class="tgl">
									<?php 
								if ($pro != ''){
								    echo $pro;
							    } else { ?>
							    <input type="checkbox" class="checkbox" id="wps_choix_variant" name="wps_choix_variant" value="1" <?php checked('1', get_option('wps_choix_variant')); ?> />
									<span class="tgl_body">
								    <span class="tgl_switch"></span>
								    <span class="tgl_track">
								    	<span class="tgl_bgd"></span>
										<span class="tgl_bgd tgl_bgd-negative"></span>
								    </span>
								  </span>
								  <?php } ?>
								  <p class="label-toggle"><?php _e('Add variants in your products feed','wpshopping_lang'); ?></p>
								</label>
							</td>
						</tr>
						
						<tr valign="top">
							<th scope="row"><?php _e('Energy efficiency', 'wpshopping_lang'); ?></th>
							<td>
							    <label class="tgl">
									<input type="checkbox" class="checkbox" id="wps_choix_energy" name="wps_choix_energy" value="1" <?php checked('1', get_option('wps_choix_energy')); ?> />
									<span class="tgl_body">
								    <span class="tgl_switch"></span>
								    <span class="tgl_track">
								    	<span class="tgl_bgd"></span>
										<span class="tgl_bgd tgl_bgd-negative"></span>
								    </span>
								  </span>
								  <p class="label-toggle"><?php _e('Energy Labels (EU Countries and Switzerland Only)','wpshopping_lang'); ?></p>
								</label>
								<p class="description"><?php _e('This attribute allows you to submit the energy label for your applicable products in feeds targeting European Union countries and Switzerland. The "energy efficiency class" attribute allows you to specify the energy efficiency class for certain product categories as defined in EU directive 2010/30/EU.<br />Recommended if applicable for items in feeds targeting Germany, France, the United Kingdom, Italy, Spain, Switzerland, the Czech Republic, and the Netherlands.<br />Products that might require this attribute include but are not limited to: refrigerators, freezers, combined washer-driers, wine-storage appliances, washing machines, tumble dryers, dishwashers, ovens, water heaters and hot water storage appliances, air conditioners, electrical lamps and luminaires, and televisions.', 'wpshopping_lang'); ?></p>
							</td>
						</tr>
						
						
						        
						<tr valign="top">
							<th scope="row"><?php _e('Adult Products', 'wpshopping_lang'); ?></th>
							<td>
								<label class="tgl">
							    <input type="checkbox" class="checkbox" id="wps_choix_adult" name="wps_choix_adult" value="1" <?php checked('1', get_option('wps_choix_adult')); ?> />
							    
							    <?php 
								if ($pro != ''){
								    echo $pro;
							    } else { ?>
							    <input type="checkbox" class="checkbox" id="wps_choix_energy" name="wps_choix_energy" value="1" <?php checked('1', get_option('wps_choix_energy')); ?> />
									<span class="tgl_body">
								    <span class="tgl_switch"></span>
								    <span class="tgl_track">
								    	<span class="tgl_bgd"></span>
										<span class="tgl_bgd tgl_bgd-negative"></span>
								    </span>
								  </span>
								  <?php } ?>
								  <p class="label-toggle"><?php _e('I sell adult products','wpshopping_lang'); ?></p>
							    </label>
							    <p class="description"><?php _e('Google cares about the family status of the product listings you submit in order to make sure that appropriate content is shown to an appropriate audience. You should use the ‘adult’ attribute to indicate that individual items will be considered “adult” or “non-family safe”.', 'wpshopping_lang'); ?></p>
							</td>
						</tr>
						
					</table>
                </div>
                </section>

					
					
					
					
					
					
					
				<section id="side_tab3" class="item" data-title="<?php _e('Products options','wpshopping_lang'); ?>">
					<div class="item-content">
                    <table class="upf-admin-form-table">
			
						<caption>
							<p><?php _e('Apparel attributes','wpshopping_lang'); ?></p>
						</caption>
						
						
						<tr valign="top">
							<th scope="row"><?php _e('Apparel Products', 'wpshopping_lang'); ?></th>
							<td>
							    <label class="tgl">
							    <input type="checkbox" class="checkbox" id="wps_choix_Apparel" name="wps_choix_Apparel" value="1" <?php checked('1', get_option('wps_choix_Apparel')); ?> />
							    <?php 
								if ($pro != ''){
								    echo $pro;
							    } else { ?>
							    <span class="tgl_body">
								    <span class="tgl_switch"></span>
								    <span class="tgl_track">
								    	<span class="tgl_bgd"></span>
										<span class="tgl_bgd tgl_bgd-negative"></span>
								    </span>
								  </span>
								  <?php } ?>
								  <p class="label-toggle"><?php _e('I sell unique products', 'wpshopping_lang'); ?></p>
							    </label>
							    <p class="description"><?php _e('Clothing, Shoes, Sunglasses, Handbags, Wallets & Cases, Jewelry, Watches ...', 'wpshopping_lang'); ?></p>
							</td>
						</tr> 
						
						<tr valign="top">
							<th scope="row"><?php _e('Attribute Color', 'wpshopping_lang'); ?></th>
							<td>
								<label class="select">
								<select name="wps_choix_color">
								<option value="" <?php if ( get_option('wps_choix_color') == "" ) echo 'selected="selected"'; ?>><?php _e('None', 'wpshopping_lang'); ?></option>
								<?php
								$attribute_taxonomies = wc_get_attribute_taxonomies();
								
								if ( $attribute_taxonomies ){
							        foreach ( $attribute_taxonomies as $tax ){
								        
							            if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ){
							                $attribute_array[ $tax->attribute_name ] = $tax->attribute_name;  
							                 
							                ?><option value="<?php echo $tax->attribute_name; ?>" <?php if ( get_option('wps_choix_color') == $tax->attribute_name ) echo 'selected="selected"'; ?>><?php echo $tax->attribute_label; ?></option><?php                                 
							            }
							        }
							    }
								?>
								</select>
								</label>
								<p class="description"><?php _e('Chose your woocommerce color attribute. This defines the dominant colour(s) for an item. When a single item has multiple colours, you can submit up to two additional values as accent colours, eg: black or black/green', 'wpshopping_lang'); ?></p>
							</td>
						</tr> 
						
						
						
						<tr valign="top">
							<th scope="row"><?php _e('Attribute Size', 'wpshopping_lang'); ?></th>
							<td>
								<label class="select">
								<select name="wps_choix_size">
									<option value="" <?php if ( get_option('wps_choix_size') == "" ) echo 'selected="selected"'; ?>><?php _e('None', 'wpshopping_lang'); ?></option>
								<?php
								$attribute_taxonomies = wc_get_attribute_taxonomies();
								
								if ( $attribute_taxonomies ){
							        foreach ( $attribute_taxonomies as $tax ){
								        
							            if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ){
							                $attribute_array[ $tax->attribute_name ] = $tax->attribute_name;  
							                 
							                ?><option value="<?php echo $tax->attribute_name; ?>" <?php if ( get_option('wps_choix_size') == $tax->attribute_name ) echo 'selected="selected"'; ?>><?php echo $tax->attribute_label; ?></option><?php                                 
							            }
							        }
							    }
								?>
								</select>
								</label>
								<p class="description"><?php _e('Chose your woocommerce size attribute. This indicates the size of a product. For Clothing & Accessories items, you can also submit the size type and size system attributes to provide more details about your sizing.', 'wpshopping_lang'); ?></p>
							</td>
						</tr> 
						
						<tr valign="top">
							<th scope="row"><?php _e('Attribute Gender', 'wpshopping_lang'); ?></th>
							<td>
								<label class="select">
								<select name="wps_choix_gender">
									<option value="" <?php if ( get_option('wps_choix_gender') == "" ) echo 'selected="selected"'; ?>><?php _e('None', 'wpshopping_lang'); ?></option>
								<?php
								$attribute_taxonomies = wc_get_attribute_taxonomies();
								
								if ( $attribute_taxonomies ){
							        foreach ( $attribute_taxonomies as $tax ){
								        
							            if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ){
							                $attribute_array[ $tax->attribute_name ] = $tax->attribute_name;  
							                 
							                ?><option value="<?php echo $tax->attribute_name; ?>" <?php if ( get_option('wps_choix_gender') == $tax->attribute_name ) echo 'selected="selected"'; ?>><?php echo $tax->attribute_label; ?></option><?php                                 
							            }
							        }
							    }
								?>
								</select>
								</label>
								<p class="description"><?php _e('Chose your woocommerce gender attribute. Required for all products in an item group that vary by gender. Required for all clothing items in feeds that target Brazil, France, Germany, Japan, the UK and the US. Recommended for all products for which gender is an important, distinguishing attribute. Taxonomy term slug must be : male, female and unisex', 'wpshopping_lang'); ?></p>
							</td>
						</tr> 
						
						<tr valign="top">
							<th scope="row"><?php _e('Attribute Age group', 'wpshopping_lang'); ?></th>
							<td>
								<label class="select">
								<select name="wps_choix_age">
								<option value="" <?php if ( get_option('wps_choix_age') == "" ) echo 'selected="selected"'; ?>><?php _e('None', 'wpshopping_lang'); ?></option>
								<?php
								$attribute_taxonomies = wc_get_attribute_taxonomies();
								
								if ( $attribute_taxonomies ){
							        foreach ( $attribute_taxonomies as $tax ){
								        
							            if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ){
							                $attribute_array[ $tax->attribute_name ] = $tax->attribute_name;  
							                 
							                ?><option value="<?php echo $tax->attribute_name; ?>" <?php if ( get_option('wps_choix_age') == $tax->attribute_name ) echo 'selected="selected"'; ?>><?php echo $tax->attribute_label; ?></option><?php                                 
							            }
							        }
							    }
								?>
								</select>
								</label>
								<p class="description"><?php _e('Chose your woocommerce age group attribute. Use the age group attribute to indicate the demographic of your item. Taxonomy terms slug must be : newborn, infant, toddler, kids or adult', 'wpshopping_lang'); ?></p>
							</td>
						</tr> 
						
					</table>
                </div>
                </section>
                
                <section id="side_tab4" class="item" data-title="<?php _e('Adwords','wpshopping_lang'); ?>">
	                
	                <div class="item-content">
                    
                    <table class="upf-admin-form-table">
			
						<caption>
							<p><?php _e('Adwords meta','wpshopping_lang'); ?></p>
						</caption>
						
						<tr valign="top">
							<th scope="row"><?php _e('Remarketing Adwords ID', 'wpshopping_lang'); ?></th>
							<td><input class="input-block-level" type="text" name="wps_adwords_id" id="wps_adwords_id" style="width:60%" value="<?php echo get_option('wps_adwords_id'); ?>" />
							<p class="description"><?php _e('To show ads to people who have visited your desktop, mobile website, or app, add the remarketing global site tag and event snippets to your website. The global site tag is a web tagging library for Google\'s site measurement, conversion tracking, and remarketing products. It’s a block of code that adds your website visitors to remarketing lists; you can then target these lists with your ads.', 'wpshopping_lang'); ?></p>
							    <p class="description"><?php _e('Eg: AW-123456789', 'wpshopping_lang'); ?> - <a href="https://support.google.com/adwords/answer/2476688?co=ADWORDS.IsAWNCustomer%3Dtrue&oco=0" target="_blank" ><?php _e('Find your customer ID', 'wpshopping_lang'); ?></a></p>
							</td>
						</tr>
					</table>
                    
                    <table class="upf-admin-form-table">
			
						<caption>
							<p><?php _e('Adwords optimization','wpshopping_lang'); ?></p>
						</caption>
						
						<tr valign="top">
							<th scope="row"><?php _e('Minimum price', 'wpshopping_lang'); ?></th>
							<td><input class="input-block-level" type="text" name="wps_mini_price" id="wps_mini_price" style="width:60%" value="<?php echo get_option('wps_mini_price'); ?>" />
							    <p class="description"><?php _e('Do not send on google shopping products whose price is lower than the indicated amount', 'wpshopping_lang'); ?></p>
							</td>
						</tr>
						
						<tr valign="top">
							<th scope="row"><?php _e('Excluded destination', 'wpshopping_lang'); ?></th>
							<td>
								<label class="tgl">
							    <input type="checkbox" class="checkbox" id="wps_excluded_destination_shopping" name="wps_excluded_destination_shopping" value="1" <?php checked('1', get_option('wps_excluded_destination_shopping')); ?> />
							    <?php 
								if ($pro != ''){
								    echo $pro;
							    } else { ?>
							    <span class="tgl_body">
								    <span class="tgl_switch"></span>
								    <span class="tgl_track">
								    	<span class="tgl_bgd"></span>
										<span class="tgl_bgd tgl_bgd-negative"></span>
								    </span>
								  </span>
								  <?php } ?>
								  <p class="label-toggle"><?php _e('Shopping','wpshopping_lang'); ?></p>
							    </label>
							    <p class="description"><?php _e('Prevent your products under minimum price from showing in Shopping ads.', 'wpshopping_lang'); ?></p>
							</td>
						</tr>
						
						<tr valign="top">
							<th scope="row"><?php _e('Excluded destination', 'wpshopping_lang'); ?></th>
							<td>
								<label class="tgl">
							    <input type="checkbox" class="checkbox" id="wps_excluded_destination_shopping_actions" name="wps_excluded_destination_shopping_actions" value="1" <?php checked('1', get_option('wps_excluded_destination_shopping_actions')); ?> />
							    <?php 
								if ($pro != ''){
								    echo $pro;
							    } else { ?>
							    <span class="tgl_body">
								    <span class="tgl_switch"></span>
								    <span class="tgl_track">
								    	<span class="tgl_bgd"></span>
										<span class="tgl_bgd tgl_bgd-negative"></span>
								    </span>
								  </span>
								  <?php } ?>
								  <p class="label-toggle"><?php _e('Shopping Actions','wpshopping_lang'); ?></p>
							    </label>
							    <p class="description"><?php _e('Prevent your products under minimum price from showing in Shopping Actions.', 'wpshopping_lang'); ?></p>
							</td>
						</tr>
						
						<tr valign="top">
							<th scope="row"><?php _e('Excluded destination', 'wpshopping_lang'); ?></th>
							<td>
								<label class="tgl">
							    <input type="checkbox" class="checkbox" id="wps_excluded_destination_display_ads" name="wps_excluded_destination_display_ads" value="1" <?php checked('1', get_option('wps_excluded_destination_display_ads')); ?> />
							    <?php 
								if ($pro != ''){
								    echo $pro;
							    } else { ?>
							    <span class="tgl_body">
								    <span class="tgl_switch"></span>
								    <span class="tgl_track">
								    	<span class="tgl_bgd"></span>
										<span class="tgl_bgd tgl_bgd-negative"></span>
								    </span>
								  </span>
								  <?php } ?>
								  <p class="label-toggle"><?php _e('Display Ads','wpshopping_lang'); ?></p>
							    </label>
							    <p class="description"><?php _e('Prevent your products under minimum price from showing in dynamic remarketing ads', 'wpshopping_lang'); ?></p>
							</td>
						</tr>
						
						
						<tr valign="top">
							<th scope="row"><?php _e('Hide out of stock product', 'wpshopping_lang'); ?></th>
							<td>
								<label class="tgl">
							    <input type="checkbox" class="checkbox" id="wps_outofstock" name="wps_outofstock" value="1" <?php checked('1', get_option('wps_outofstock')); ?> />
							    <?php 
								if ($pro != ''){
								    echo $pro;
							    } else { ?>
							    <span class="tgl_body">
								    <span class="tgl_switch"></span>
								    <span class="tgl_track">
								    	<span class="tgl_bgd"></span>
										<span class="tgl_bgd tgl_bgd-negative"></span>
								    </span>
								  </span>
								  <?php } ?>
								  <p class="label-toggle"><?php _e('Hide products out of stock','wpshopping_lang'); ?></p>
							    </label>
							    <p class="description"><?php _e('
	hide products out of stock to save money.', 'wpshopping_lang'); ?></p>
							</td>
						</tr>
						
				
						
					</table>
					</div>
                </section>
                
                
                
                <section id="side_tab5" class="item" data-title="<?php _e('Adwords Custom Label','wpshopping_lang'); ?>">
	                
	                <div class="item-content">
                    
                    <table class="upf-admin-form-table">
			
						<caption>
							<p><?php _e('Adwords custom Labels','wpshopping_lang'); ?></p>
						</caption>
						
						<tr valign="top">
							<th scope="row"><?php _e('Custom label', 'wpshopping_lang'); ?></th>
								<td>
							    	<label class="tgl">
							        <input type="checkbox" class="checkbox" id="wps_adword_custom_label" name="wps_adword_custom_label" value="1" <?php checked('1', get_option('wps_adword_custom_label')); ?> />
							        <?php 
									if ($pro != ''){
									    echo $pro;
								    } else { ?>
							        <span class="tgl_body">
									    <span class="tgl_switch"></span>
									    <span class="tgl_track">
									    	<span class="tgl_bgd"></span>
											<span class="tgl_bgd tgl_bgd-negative"></span>
									    </span>
									</span>
									<?php } ?>
									<p class="label-toggle"><?php _e('Active custom label', 'wpshopping_lang'); ?></p>
								
							        </label>
							        <p class="description"><?php _e('Custom labels, custom_label_0 through custom_label_4, allow you to create specific filters to use in your Shopping campaigns. Use these filters for reporting and bidding on groups of products. The information you include in this attribute won’t be shown to users.', 'wpshopping_lang'); ?></p>
								</td>
						</tr>
						
						<tr valign="top">
							<th scope="row"><?php _e('custom_label_0', 'wpshopping_lang'); ?></th>
							<td>
								<label class="select">
								<select name="wps_custom_label_0">
									
									<option value="" <?php if ( get_option('wps_custom_label_0') == "" ) echo 'selected="selected"'; ?>><?php _e('None', 'wpshopping_lang'); ?></option>
									<option value="best_seller" <?php if ( get_option('wps_custom_label_0') == 'best_seller' ) echo 'selected="selected"'; ?>><?php _e('Best sellers', 'wpshopping_lang'); ?></option>
									<option value="is_on_sale" <?php if ( get_option('wps_custom_label_0') == 'is_on_sale' ) echo 'selected="selected"'; ?>><?php _e('Products on sale', 'wpshopping_lang'); ?></option>
									<option value="recent_product" <?php if ( get_option('wps_custom_label_0') == 'recent_product' ) echo 'selected="selected"'; ?>><?php _e('Recent products', 'wpshopping_lang'); ?></option>
									<option value="average_rating" <?php if ( get_option('wps_custom_label_0') == 'average_rating' ) echo 'selected="selected"'; ?>><?php _e('Average rating', 'wpshopping_lang'); ?></option>
									<option value="featured" <?php if ( get_option('wps_custom_label_0') == 'featured' ) echo 'selected="selected"'; ?>><?php _e('Featured products', 'wpshopping_lang'); ?></option>
									<option value="brands" <?php if ( get_option('wps_custom_label_0') == 'brands' ) echo 'selected="selected"'; ?>><?php _e('Brands', 'wpshopping_lang'); ?></option>
									
									
								</select>
								</label>
							</td>
						</tr> 
						
						<tr valign="top">
							<th scope="row"><?php _e('custom_label_1', 'wpshopping_lang'); ?></th>
							<td>
								<label class="select">
								<select name="wps_custom_label_1">
									<option value="" <?php if ( get_option('wps_custom_label_1') == "" ) echo 'selected="selected"'; ?>><?php _e('None', 'wpshopping_lang'); ?></option>
									<option value="best_seller" <?php if ( get_option('wps_custom_label_1') == 'best_seller' ) echo 'selected="selected"'; ?>><?php _e('Best sellers', 'wpshopping_lang'); ?></option>
									<option value="is_on_sale" <?php if ( get_option('wps_custom_label_1') == 'is_on_sale' ) echo 'selected="selected"'; ?>><?php _e('Products on sale', 'wpshopping_lang'); ?></option>
									<option value="recent_product" <?php if ( get_option('wps_custom_label_1') == 'recent_product' ) echo 'selected="selected"'; ?>><?php _e('Recent products', 'wpshopping_lang'); ?></option>
									<option value="average_rating" <?php if ( get_option('wps_custom_label_1') == 'average_rating' ) echo 'selected="selected"'; ?>><?php _e('Average rating', 'wpshopping_lang'); ?></option>
									<option value="featured" <?php if ( get_option('wps_custom_label_1') == 'featured' ) echo 'selected="selected"'; ?>><?php _e('Featured products', 'wpshopping_lang'); ?></option>
									<option value="brands" <?php if ( get_option('wps_custom_label_1') == 'brands' ) echo 'selected="selected"'; ?>><?php _e('Brands', 'wpshopping_lang'); ?></option>
									
								</select>
								</label>
							</td>
						</tr> 
						
						<tr valign="top">
							<th scope="row"><?php _e('custom_label_2', 'wpshopping_lang'); ?></th>
							<td>
								<label class="select">
								<select name="wps_custom_label_2">
									<option value="" <?php if ( get_option('wps_custom_label_2') == "" ) echo 'selected="selected"'; ?>><?php _e('None', 'wpshopping_lang'); ?></option>
									<option value="best_seller" <?php if ( get_option('wps_custom_label_2') == 'best_seller' ) echo 'selected="selected"'; ?>><?php _e('Best sellers', 'wpshopping_lang'); ?></option>
									<option value="is_on_sale" <?php if ( get_option('wps_custom_label_2') == 'is_on_sale' ) echo 'selected="selected"'; ?>><?php _e('Products on sale', 'wpshopping_lang'); ?></option>
									<option value="recent_product" <?php if ( get_option('wps_custom_label_2') == 'recent_product' ) echo 'selected="selected"'; ?>><?php _e('Recent products', 'wpshopping_lang'); ?></option>
									<option value="average_rating" <?php if ( get_option('wps_custom_label_2') == 'average_rating' ) echo 'selected="selected"'; ?>><?php _e('Average rating', 'wpshopping_lang'); ?></option>
									<option value="featured" <?php if ( get_option('wps_custom_label_2') == 'featured' ) echo 'selected="selected"'; ?>><?php _e('Featured products', 'wpshopping_lang'); ?></option>
									<option value="brands" <?php if ( get_option('wps_custom_label_2') == 'brands' ) echo 'selected="selected"'; ?>><?php _e('Brands', 'wpshopping_lang'); ?></option>
									
								</select>
								</label>
							</td>
						</tr> 
						
						<tr valign="top">
							<th scope="row"><?php _e('custom_label_3', 'wpshopping_lang'); ?></th>
							<td>
								<label class="select">
								<select name="wps_custom_label_3">
									<option value="" <?php if ( get_option('wps_custom_label_3') == "" ) echo 'selected="selected"'; ?>><?php _e('None', 'wpshopping_lang'); ?></option>
									<option value="best_seller" <?php if ( get_option('wps_custom_label_3') == 'best_seller' ) echo 'selected="selected"'; ?>><?php _e('Best sellers', 'wpshopping_lang'); ?></option>
									<option value="is_on_sale" <?php if ( get_option('wps_custom_label_3') == 'is_on_sale' ) echo 'selected="selected"'; ?>><?php _e('Products on sale', 'wpshopping_lang'); ?></option>
									<option value="recent_product" <?php if ( get_option('wps_custom_label_3') == 'recent_product' ) echo 'selected="selected"'; ?>><?php _e('Recent products', 'wpshopping_lang'); ?></option>
									<option value="average_rating" <?php if ( get_option('wps_custom_label_3') == 'average_rating' ) echo 'selected="selected"'; ?>><?php _e('Average rating', 'wpshopping_lang'); ?></option>
									<option value="featured" <?php if ( get_option('wps_custom_label_3') == 'featured' ) echo 'selected="selected"'; ?>><?php _e('Featured products', 'wpshopping_lang'); ?></option>
									<option value="brands" <?php if ( get_option('wps_custom_label_3') == 'brands' ) echo 'selected="selected"'; ?>><?php _e('Brands', 'wpshopping_lang'); ?></option>
									
								</select>
								</label>
							</td>
						</tr> 

						<tr valign="top">
							<th scope="row"><?php _e('custom_label_4', 'wpshopping_lang'); ?></th>
							<td>
								<label class="select">
								<select name="wps_custom_label_4">
									<option value="" <?php if ( get_option('wps_custom_label_4') == "" ) echo 'selected="selected"'; ?>><?php _e('None', 'wpshopping_lang'); ?></option>
									<option value="best_seller" <?php if ( get_option('wps_custom_label_4') == 'best_seller' ) echo 'selected="selected"'; ?>><?php _e('Best sellers', 'wpshopping_lang'); ?></option>
									<option value="is_on_sale" <?php if ( get_option('wps_custom_label_4') == 'is_on_sale' ) echo 'selected="selected"'; ?>><?php _e('Products on sale', 'wpshopping_lang'); ?></option>
									<option value="recent_product" <?php if ( get_option('wps_custom_label_4') == 'recent_product' ) echo 'selected="selected"'; ?>><?php _e('Recent products', 'wpshopping_lang'); ?></option>
									<option value="average_rating" <?php if ( get_option('wps_custom_label_4') == 'average_rating' ) echo 'selected="selected"'; ?>><?php _e('Average rating', 'wpshopping_lang'); ?></option>
									<option value="featured" <?php if ( get_option('wps_custom_label_4') == 'featured' ) echo 'selected="selected"'; ?>><?php _e('Featured products', 'wpshopping_lang'); ?></option>
									<option value="brands" <?php if ( get_option('wps_custom_label_4') == 'brands' ) echo 'selected="selected"'; ?>><?php _e('Brands', 'wpshopping_lang'); ?></option>
									
								</select>
								</label>
							</td>
						</tr> 
						 
						
					</table>
					</div>
                </section>
                
                

				<?php if ( ! is_plugin_active( 'ultimate-products-feed-pro/index.php' ) ) { ?>
					
				<div>
	            	<p class="description"><?php _e('Some options need variations to work with Google Shopping. If you use variable products, bundles products or if you need more options for adwords. We invite you to ', 'wpshopping_lang'); ?><a href="https://wp-shopping.com" target="_blank"><?php _e('download the PRO add-on', 'wpshopping_lang'); ?></a></p>						</div>

	        	<?php } ?>
                <p class="fat"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'wpshopping_lang'); ?>"  /></p>
                
            </article>

		</form>
			
		
	</div>