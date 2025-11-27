<?php 
	// Add default HTML form
	add_action('plugins_loaded', 'allianz_update_newsletter_default_form');
  add_action('activate_newsletter/plugin.php', 'allianz_update_newsletter_default_form');
  add_action('theme_core_ie_after_import', 'allianz_update_newsletter_default_form');
	function allianz_update_newsletter_default_form(){
		$siteurl = site_url('/');
		$default_form = get_option('newsletter_htmlforms', []);
		$default_form['form_1'] = '<form method="post" action="'.$siteurl.'?na=s" class="cms-nlf-1 relative"><input type="hidden" name="nlang" value=""><div class="tnp-field tnp-field-email"><input class="tnp-email" type="email" name="ne" id="tnp-1" value="" required placeholder="Your Email Address"></div><div class="tnp-field tnp-field-button"><button class="tnp-submit" type="submit" value="Subscribe" >Subscribe</button></div></form>';
		$default_form['form_2'] = '<form method="post" action="'.$siteurl.'?na=s" class="cms-nlf-2 relative"><input type="hidden" name="nlang" value=""><div class="tnp-field tnp-field-email"><input class="tnp-email" type="email" name="ne" id="tnp-1" value="" required placeholder="Your Email Address"></div><div class="tnp-field tnp-field-button"><button class="tnp-submit" type="submit" value="Subscribe" >Subscribe</button></div></form>';
		$default_form['form_3'] = '<form method="post" action="'.$siteurl.'?na=s" class="cms-nlf-3 relative"><input type="hidden" name="nlang" value=""><div class="tnp-field tnp-field-email"><input class="tnp-email" type="email" name="ne" id="tnp-1" value="" required placeholder="Your Email Address"></div><div class="tnp-field tnp-field-button"><button class="tnp-submit" type="submit" value="Subscribe" >Subscribe</button></div></form>';
		$default_form['form_4'] = '<form method="post" action="'.$siteurl.'?na=s" class="cms-nlf-4 relative"><input type="hidden" name="nlang" value=""><div class="tnp-field tnp-field-email"><input class="tnp-email" type="email" name="ne" id="tnp-1" value="" required placeholder="Your Email Address"></div><div class="tnp-field tnp-field-button"><button class="tnp-submit" type="submit" value="Subscribe" >Subscribe</button></div></form>';
		update_option( 'newsletter_htmlforms', $default_form );
	}
?>