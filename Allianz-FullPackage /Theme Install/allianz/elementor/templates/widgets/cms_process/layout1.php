<?php
$default_align = 'start';
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-eprocess',
		'cms-eprocess-'.$settings['layout'],
		'text-'.$widget->get_setting('align', $default_align),
		'p-tb-110 p-tb-tablet-40'
	])
]);
// Small Heading
$widget->add_inline_editing_attributes( 'smallheading_text' );
$widget->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-smallheading',
		'text-'.$widget->get_setting('smallheading_color','accent'),
		'pb-10 mt-n7',
		'text-16 font-600',
		'empty-none'
	]
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-heading empty-none',
		'text-'.$widget->get_setting('heading_color','heading'),
		'lh-1375'
	]
]);
// Description Bold
$widget->add_inline_editing_attributes( 'description_bold_text' );
$widget->add_render_attribute( 'description_bold_text', [
	'class' => array_filter([
		'cms-desc-bold empty-none',
		'text-26 font-600 lh-13077',
		'text-'.$widget->get_setting('description_bold_color','heading'),
		'pt-5'
	])
]);
// Description
$widget->add_inline_editing_attributes( 'description_text' );
$widget->add_render_attribute( 'description_text', [
	'class' => array_filter([
		'cms-desc pt-25 empty-none',
		'text-'.$widget->get_setting('description_color','body')
	])
]);
// Process
$process = $widget->get_setting('process_list', []);

?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<div class="d-flex gutter">
		<div class="col-6 col-mobile-extra-12">
			<div class="cms-sticky" style="--cms-sticky-top: 110px; --cms-sticky-top-tablet: 40px;">
				<?php allianz_elementor_icon_image_render($widget, $settings,[
					'class' => 'mb-40',
					//
					'size' => 64,
					// image
					'img_default_size' => 'custom'
				]); ?>
				<div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
				<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
			</div>
		</div>
		<div class="col-6 col-mobile-extra-12">
			<div class="process-sdesc pl-70 pl-mobile-extra-0 d-flex cms-sticky pb-mobile-extra-50">
				<div class="process--sdesc align-self-end">
					<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_bold_text' ) ); ?>><?php echo nl2br( $settings['description_bold_text'] ); ?></div>
					<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
				</div>
			</div>
			<div class="cms-process-slides-wrapper pl-70 pl-mobile-extra-0">
				<?php 
				$count = 0;
				$zindex = '';
				foreach($process as $key => $_process){ 
					$count ++;
					if($count < 10) $count = '0'.$count;
					if($count == count($process)) $zindex = 'relative z-top';
					if($count != count($process)) $zindex .= ' mb-100';
				?>
					<div class="panel bg-white cms-radius-8 p-50 p-lr-tablet-30 pl-mobile-20 cms-hover-show-icon-zoomin <?php etc_print_html($zindex); ?>">
						<div class="panel-content">
							<div class="panel-title d-flex gap-30 bdr-b-1">
								<div class="process-count text-17 font-600 text-primary flex-auto">
									<div class="process--count circle"><?php etc_print_html($count); ?></div>
								</div>
								<div class="process-separator bdr-r-1 relative"><div class="process--separator"></div></div>
								<div class="panel--title text-22 lh-12727 font-600 text-primary flex-basic mt-n3 pb-30"><?php etc_print_html($_process['title']); ?></div>
							</div>
							<div class="panel-banner-icon process-banner-icon text-center d-flex justify-content-center"><?php
								// Icon/ Image
								ob_start();
									allianz_elementor_icon_image_render($widget, $_process, [
										'size'        => 96,
										'color'       => 'white',
										'color_hover' => 'white',
										//
										'class'	 => 'circle absolute center',
										'before' => '<div class="process-icon-img circle bg-accent-09 absolute center cms-hover-show--icon">',
										'after'	 => '</div>'
									]);
								$icon_image = ob_get_clean();
								// Banner
								allianz_elementor_image_render($_process, [
									'name'        => 'banner',
									'size'        => 'custom',
									'custom_size' => ['width' => 330, 'height' => 330],
									'img_class'   => 'circle',
									'before'			=> '<div class="panel-banner relative mt-40">',
									'after'				=> $icon_image.'</div>'
								]);

							?></div>
							<div class="panel-desc text-15 pt-30"><?php etc_print_html($_process['desc']); ?></div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>