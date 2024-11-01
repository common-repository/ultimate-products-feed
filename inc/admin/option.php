<script type="text/javascript">
function hideshow(which){
if (!document.getElementById)
return
if (which.style.display=="block")
which.style.display="none"
else
which.style.display="block"
}
</script>

	<div class="wrap">
		<div class="feature-section images-stagger-right">
			
			
			<div id="welcome-panel" class="welcome-panel">
			<div class="welcome-panel-content">
			<h2><?php _e('Ultimate Products Feed','wpshopping_lang'); ?></h2>
			<p class="about-description"><?php _e('Welcome in your products feed control panel','wpshopping_lang'); ?></p>
			<div class="welcome-panel-column-container">
			<div class="welcome-panel-column">
				<h3><?php _e('Start!','wpshopping_lang'); ?></h3>
					<li><?php printf( '<a href="%s" class="button button-primary button-hero load-customize hide-if-no-customize">' . __( 'Configure your feed','wpshopping_lang' ) . '</a>', admin_url( 'admin.php?page=setting-google-shopping' ) ); ?></li>
					
					<p class="hide-if-no-customize"><?php _e('And boost your sales !','wpshopping_lang'); ?></p>
			</div>
			
			<div class="welcome-panel-column">
				<h3><?php _e('Next step','wpshopping_lang'); ?></h3>
				<ul>
					<li><?php printf( '<a href="%s" class="welcome-icon dashicons-admin-generic">' . __( 'Settings Google Shopping','wpshopping_lang' ) . '</a>', admin_url( 'admin.php?page=setting-google-shopping' ) ); ?></li>
					<li><?php printf( '<a href="%s" class="welcome-icon dashicons-rss">' . __( 'Google Merchant XML Feed','wpshopping_lang' ) . '</a>', admin_url( 'admin.php?page=flux-google-merchant' ) ); ?></li>
					<!-- <li><?php printf( '<a href="%s" class="welcome-icon dashicons-facebook">' . __( 'Facebook Product XML Feed','wpshopping_lang' ) . '</a>', admin_url( 'admin.php?page=facebook-product-feed' ) ); ?></li> -->
					<li><a href="https://wp-shopping.com/docs/ultimate-products-feed/" class="welcome-icon welcome-learn-more" taget="_blank"><?php _e('Plugin documentation','wpshopping_lang'); ?></a></li>
				</ul>
			</div>
			
			<div class="welcome-panel-column welcome-panel-last">
				<h3>WP Shopping</h3>
				<ul>
					<?php if ( is_plugin_active( 'ultimate-products-feed-pro/index.php' ) ) { ?>
					<li><?php printf( '<a href="%s" class="welcome-icon dashicons-admin-network">' . __( 'My license','wpshopping_lang' ) . '</a>', admin_url( 'admin.php?page=license' ) ); ?></li>
					<?php } ?>
					
					<li><a href="https://wp-shopping.com/my-account/" class="welcome-icon dashicons-admin-users" taget="_blank"><?php _e('My account','wpshopping_lang'); ?></a></li>
					
				</ul>
			</div>
			
			</div>
			</div>
		</div>
			
		<?php $img_header = plugins_url( 'ultimate-products-feed/inc/img/banner-1544x314.jpg')?>
		<img src="<?php echo $img_header; ?>" width="100%">
			
		<p><?php _e( 'Use Merchant Tools from Google Merchant Center to upload your product data and let millions of shoppers see your online and in-store inventory.', 'wpshopping_lang' ); ?></p>
		
		</div>		
	</div>