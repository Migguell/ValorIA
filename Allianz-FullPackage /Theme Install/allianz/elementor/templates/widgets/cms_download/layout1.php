<?php 
$download_lists = $widget->get_setting('download_lists', []);
// Wrap
$widget->add_render_attribute('wrap',[
	'class' => array_filter([
		'cms-edownload',
		'p-50 p-lr-tablet-extra-40 p-lr-tablet-30 p-lr-smobile-20',
		'cms-ebg-1'
	])
]);
// Title
$widget->add_inline_editing_attributes('title');
$widget->add_render_attribute('title', [
	'class' => array_filter([
		'cms-title',
		'text-22 font-700 text-heading',
		'pb-25 mt-n5 empty-none'
	])
]);
// Items

?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div <?php etc_print_html($widget->get_render_attribute_string('title')) ?>><?php etc_print_html($settings['title']); ?></div>
	<div class="cms-download-list d-flex gap-20"><?php 
		foreach ($download_lists as $key => $download) {
			$download_key = $widget->get_repeater_setting_key( 'link', 'cms_download_link', $key );
    	$widget->add_link_attributes( $download_key, $download['link'] );
      $widget->add_render_attribute($download_key, [
      	'class' => [
      		'cms-dowload-item',
      		'd-flex align-items-center gap-20',
      		'text-15 font-700',
      		'w-100'
      	]
      ]);
    ?>
    	<a <?php etc_print_html($widget->get_render_attribute_string($download_key)) ?>><i class="cms-icon cmsi-pdf text-32"></i><?php etc_print_html($download['name']); ?></a>
  <?php
		}
	?></div>
</div>