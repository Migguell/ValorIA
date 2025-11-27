<?php
$default_align = 'start';
// Wrap
$widget->add_render_attribute('wrap', [
	'class' => array_filter([
		'cms-eheading',
		'cms-eheading-'.$widget->get_setting('layout'),
		'text-'.$widget->get_setting('align',$default_align)
	])
]);
// Small Heading
$widget->add_inline_editing_attributes( 'smallheading_text' );
$widget->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-smallheading',
		'text-'.$widget->get_setting('smallheading_color','heading-lighten'),
		'font-700',
		'pb-10',
		'empty-none'
	]
]);
// Large Heading
$widget->add_inline_editing_attributes( 'heading_text', 'none' );
$widget->add_render_attribute( 'heading_text', [
	'class' => [
		'cms-heading empty-none',
		'text-'.$widget->get_setting('heading_color','heading')
	]
]);
// Description Bold
$widget->add_inline_editing_attributes( 'description_bold_text' );
$widget->add_render_attribute( 'description_bold_text', [
	'class' => array_filter([
		'cms-desc-bold pt-20 font-700 empty-none',
		'text-'.$widget->get_setting('description_bold_color','heading')
	])
]);
// Description
$widget->add_inline_editing_attributes( 'description_text' );
$widget->add_render_attribute( 'description_text', [
	'class' => array_filter([
		'cms-desc pt-20 empty-none',
		'text-'.$widget->get_setting('description_color','body')
	])
]);
// Link 1
$link1_page = $widget->get_setting('link1_page','');
switch ($settings['link1_type']) {
	case 'page':
		$page = !empty($link1_page) ? get_page_by_path($link1_page, OBJECT) : [];
		$url  = !empty($page) ? get_permalink($page->ID) : '#';
		break;
	
	default:
		$url = $widget->get_setting('link1_custom', ['url' => '#'])['url'];
		break;
}
$widget->add_inline_editing_attributes( 'link1_text' );
$widget->add_render_attribute( 'link1_text', [
	'class' => [
		'btn',
		'btn-'.$widget->get_setting('link1_color','primary'),
		'btn-hover-'.$widget->get_setting('link1_color_hover', 'accent')
	],
	'href'	=> $url
]);

// Link 2
$link2_page = $widget->get_setting('link2_page','');
switch ($settings['link2_type']) {
	case 'page':
		$page = !empty($link2_page) ? get_page_by_path($link2_page, OBJECT) : [];
		$url  = !empty($page) ? get_permalink($page->ID) : '#';
		break;
	
	default:
		$url = $widget->get_setting('link2_custom', ['url' => '#'])['url'];
		break;
}
$widget->add_inline_editing_attributes( 'link2_text' );
$widget->add_render_attribute( 'link2_text', [
	'class' => [
		'cms-link',
		'text-'.$widget->get_setting('link2_color','default'),
		'text-hover-'.$widget->get_setting('link2_color_hover','default')
	],
	'href'	=> $url
]);
// Buttons
$widget->add_render_attribute('buttons',[
	'class' => [
		'cms-heading-buttons d-flex gap pt-30',
		'justify-content-'.$widget->get_setting('align',$default_align)
	]
]);
// Signature
$widget->add_render_attribute('signature-wrap',[
	'class' => [
		'cms-signature d-flex gap-10 align-items-center',
		'justify-content-'.$widget->get_setting('align', $default_align)
	]
]);
$savatar_class = allianz_nice_class(['savatar', 'circle']);
//
$widget->add_inline_editing_attributes( 'sname' );
$widget->add_render_attribute('sname', [
	'class' => [
		'sname',
		'cms-heading text-17',
	]
]);
//
$widget->add_inline_editing_attributes( 'sposition' );
$widget->add_render_attribute('sposition', [
	'class' => [
		'sposition',
		'text-14 text-secondary-lighten',
	]
]);
// Feature
$features = $widget->get_setting('cms_feature', []);
$widget->add_render_attribute('features-wrap', [
	'class' => [
		'cms-heading-features pt-50 d-flex',
		allianz_elementor_get_grid_columns($widget, $settings, ['prefix_class' => 'flex-col-', 'default' => '2']),
		($settings['col'] != '1') ? 'gutter' : ''
	]
]);
$widget->add_render_attribute('features-item',[
	'class' => [
		'cms-list',
		'text-16',
		'text-'.$widget->get_setting('feature_color','body'),
		'hover-icon-bounce'
	]
]);

// Progress Bar
$progressbar_list = $widget->get_setting('progressbar_list', []);
$widget->add_render_attribute('progressbar-wrap', [
	'class' => [
		'cms-eprogress-bar',
		'cms-eprogress-bar-1',
		'pt-30'
	]
]);
// Rating
$rated = $widget->get_setting('star_rated', 100);
$widget->add_render_attribute('star_color', [
	'class' => [
		'cms-star-rate relative',
		'text-'.$widget->get_setting('star_color','secondary')
	]
]);
$widget->add_render_attribute('star_rated_color', [
	'class' => [
		'cms-star-rated absolute',
		'text-'.$widget->get_setting('star_rated_color','accent'),
	],
	'data-width' => $rated,
	'style' 	 => 'width:'.$rated.'%;'
]);
$widget->add_render_attribute('rate_text_color', [
	'class' => [
		'flex-basic text-15 cms-text',
		'text-'.$widget->get_setting('rate_text_color','body')
	]
]);
$widget->add_render_attribute('percent_text', [
	'class' => [
		'text-underline font-700',
		'text-'.$widget->get_setting('star_rated_color','accent')
	]
]);
// Testimonials 
$testimonials = $widget->get_setting('testimonials', []);
// TTMN Wrap
$widget->add_render_attribute('ttmn-wrap', [
    'class' => [
        'cms-ettmn',
        'cms-ettmn-6',
        'bg-grey',
        'p-tb-40 p-lr-40 p-lr-smobile-20',
        'cms-triangle-bl grey cms-triangle-2',
        'mt-40 mb-20'
    ]
]);
// TTMN Description 
$widget->add_render_attribute('ttmn-description',[
    'class' => [
       'cms-ttmn-desc heading font-600 text-20 text-italic empty-none lh-145 mt-n7',
       'text-'.$widget->get_setting('desc_color','heading')
    ]
]);
// TTMN Author Name
$widget->add_render_attribute('ttmn-author',[
    'class' => [
        'cms-ttmn--name text-16 font-700',
        'text-'.$widget->get_setting('author_color', 'heading')
    ]
]);
// TTMN Author Position
$widget->add_render_attribute('ttmn-author-pos',[
    'class' => [
        'cms-ttmn--pos text-13 font-700',
        'text-'.$widget->get_setting('author_pos_color', 'body')
    ]
]);
// TTMN rated
$widget->add_render_attribute('ttmn-rate',[
    'class' => [
        'cms-star-rate relative',
        'text-'.$widget->get_setting('rate_color', 'body')
    ]
]);
$widget->add_render_attribute('ttmn--rate',[
    'class' => [
        'cms-star-rated absolute',
        'text-'.$widget->get_setting('rate_color', 'secondary')
    ]
]);
// TTMN Items
$widget->add_render_attribute('ttmn-item',[
    'class' => [
        'cms-ttmn-item'
    ]
]);
?>
<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
	<?php
		// Icon
		allianz_elementor_icon_render($settings['heading_icon'], [], [
			'class'		  => ['cms-heading-icon', 'mb-30'],
			'aria-hidden' => 'true',
			'icon_size'	  => 64,
			'icon_color'  => $widget->get_setting('icon_color', 'accent')
		], 'div');
	?>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
	<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_bold_text' ) ); ?>><?php echo nl2br( $settings['description_bold_text'] ); ?></div>
	<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
	<div <?php etc_print_html($widget->get_render_attribute_string('buttons')); ?>>
		<?php if(!empty($settings['link1_text'])) { ?>
			<a <?php etc_print_html( $widget->get_render_attribute_string( 'link1_text' ) ); ?>>
				<?php echo esc_html( $settings['link1_text'] ); ?>
				<i class="cms-btn-icon cmsi-arrow-right rtl-flip text-10"></i>
			</a>
		<?php }
		if(!empty($settings['link2_text'])){ 
			?>
			<a <?php etc_print_html( $widget->get_render_attribute_string( 'link2_text' ) ); ?>>
				<?php echo esc_html( $settings['link2_text'] ); ?>
				<i class="cmsi-arrow-right text-10 rtl-flip"></i>
			</a>
		<?php } ?>
	</div>
	<?php // Signature ?>
	<div <?php etc_print_html($widget->get_render_attribute_string('signature-wrap')); ?>>
		<?php allianz_elementor_image_render($settings, [
			'name'        => 'savatar',
			'size'		  => 'custom',
			'custom_size' => ['width' => 56, 'height' => 56],
			'img_class'   => $savatar_class,
			'before'      => '<div class="savatars circle outline-1">',
			'after'       => '</div>'
		]); ?>
		<div class="stext flex-auto relative">
			<?php 
				allianz_elementor_image_render($settings, [
					'name'        => 'simage',
					'size'        => 'custom',
					'custom_size' => ['width' => 134, 'height'=> 68]
				]);
			?>
			<div class="cms--signature absolute center">
				<div <?php etc_print_html($widget->get_render_attribute_string('sname')); ?>><?php echo nl2br($settings['sname']); ?></div>
				<div <?php etc_print_html($widget->get_render_attribute_string('sposition')); ?>><?php echo nl2br($settings['sposition']); ?></div>
			</div>
		</div>
	</div>
	<?php // Progress Bar ?>
	<div <?php etc_print_html($widget->get_render_attribute_string('progressbar-wrap')); ?>>
		<?php foreach ( $progressbar_list as $key => $progressbar ):
			$title_key = $widget->get_repeater_setting_key( 'title', 'progressbar_list', $key );
			$wrapper_key = $widget->get_repeater_setting_key( 'wrapper', 'progressbar_list', $key );
			$progress_bar_key = $widget->get_repeater_setting_key( 'progress_bar', 'progressbar_list', $key );
			
			$widget->add_inline_editing_attributes( $title_key );
			$widget->add_render_attribute( $title_key, [
				'class'=>[
					'cms-progress-bar-title',
					'text-15 font-700 text-body',
					'd-flex justify-content-between no-wrap'
				],
				'style' => 'width:'.$progressbar['percent']['size'].'%'
			]);

			$widget->add_render_attribute( $wrapper_key, [
				'class'         => 'cms-progress-wrap',
				'role'          => 'progressbar',
				'aria-valuemin' => '0',
				'aria-valuemax' => '100',
				'aria-valuenow' => $progressbar['percent']['size'],
			] );

			if ( ! empty( $progressbar['progress_type'] ) ) {
				$widget->add_render_attribute( $wrapper_key, 'class', 'progress-' . $progressbar['progress_type'] );
			}

			$widget->add_render_attribute( $progress_bar_key, [
				'class'    => 'cms-progress-bar bg-secondary',
				'data-max' => $progressbar['percent']['size'],
			] );
			?>
			<div class="cms-progress-bar-wrap">
				<?php if ( ! empty( $progressbar['title'] ) ) { ?>
		            <div <?php etc_print_html( $widget->get_render_attribute_string( $title_key ) ); ?>>
		            	<?php echo esc_html( $progressbar['title'] ); ?>
		            	<span class="text-14 text-secondary"><span class="cms-progress-bar-number" data-duration="2000" data-delimiter="" data-to-value="<?php echo esc_attr($progressbar['percent']['size']); ?>"></span>%</span>	
		            </div>
				<?php } ?>
		        <div <?php etc_print_html( $widget->get_render_attribute_string( $wrapper_key ) ); ?>>
		            <div <?php etc_print_html( $widget->get_render_attribute_string( $progress_bar_key ) ); ?>>
		            	<span class="cms-progress-bar-number" data-duration="2000" data-delimiter="" data-to-value="<?php echo esc_attr($progressbar['percent']['size']); ?>"></span>%
		            </div>
		        </div>
	        </div>
		<?php endforeach; ?>
	</div>
	<?php if($settings['show_feature'] == 'yes'): ?>
	<div <?php etc_print_html($widget->get_render_attribute_string('features-wrap')); ?>>
		<?php 
		foreach ( $features as $key => $cms_feature ):
			$title_key = $widget->get_repeater_setting_key( 'title', 'cms_list', $key );
			$widget->add_render_attribute($title_key, [
				'class' => [
					'feature-title',
					'cms-heading text-19',
					'text-'.$widget->get_setting('feature_color','heading'),
					'pb-15'
				]
			]);
			$widget->add_inline_editing_attributes( $title_key, 'none' );
		?>
	        <div <?php etc_print_html($widget->get_render_attribute_string('features-item')); ?>>
	            <?php 
	            	//\Elementor\Icons_Manager::render_icon( $cms_feature['icon'], [ 'aria-hidden' => 'true', 'class' => 'cms-icon pb-25 text-64 text-'.$widget->get_setting('feature_color','accent')] ); 
	            	allianz_elementor_icon_render($cms_feature['icon'], [], [ 
						'aria-hidden' => 'true', 
						'class'       => 'cms-icon pb-25',
						'icon_size'   => 64,
						'icon_color'  => $widget->get_setting('feature_color','accent')
	            	]);
	            ?>
            	<div <?php etc_print_html( $widget->get_render_attribute_string( $title_key ) ); ?>><?php echo esc_html( $cms_feature['title'] ) ?></div>
            	<div class="desc"><?php
            		echo nl2br($cms_feature['description']);
            	?></div>
	        </div>
		<?php endforeach;?>
	</div>
	<?php
		endif;
		// Banner title
		ob_start();
	?>
		<div class="cms-heading-banner-title2 absolute bottom-right d-flex gap-30 text-18 text-white bg-accent cms-radius-trb-10 cms-heading font-500 p-40 p-lr-smobile-20">
			<?php
				allianz_elementor_icon_render($settings['banner_icon'], [], ['class' => 'cms-icon flex-auto', 'icon_size' => 64]);
			?>
			<span class="flex-basic mt-n8 mb-n8 flex-smobile-100"><?php
				echo nl2br($settings['banner_title']); 
			?></span>
		</div>
	<?php
		$banner_title = ob_get_clean();
		// Banner Small
		ob_start();
			allianz_elementor_image_render($settings,[
				'name'        => 'banner_small',
				'size'		  => 'custom',
				'img_class'   => 'cms-heading-banner-small absolute top-left',
				'custom_size' => ['width' => 206, 'height' => 137]
			]);
		$banner_small = ob_get_clean();
		// Banner
		allianz_elementor_image_render($settings,[
			'name'        => 'banner',
			'img_class'   => '',
			'custom_size' => ['width' => 660, 'height' => 440],
			'before'	  => '<div class="cms-heading-banner relative pr-40 d-inline-block hover-icon-bounce">',
			'after'		  => $banner_small.$banner_title.'</div>'					
		]);
	// Rate 
	if($rated != 0){
	?>
		<div class="cms-heading-rate d-flex gap pt-30">
			<div class="flex-auto flex-smobile-full">
				<div <?php etc_print_html($widget->get_render_attribute_string('star_color')); ?>>
				    <div <?php etc_print_html($widget->get_render_attribute_string('star_rated_color')); ?>></div>
				</div>
			</div>
			<div <?php etc_print_html($widget->get_render_attribute_string('rate_text_color')); ?>>
				<span <?php etc_print_html($widget->get_render_attribute_string('percent_text')); ?>><?php 
					etc_print_html($widget->get_setting('percent','99.9%').' '.$widget->get_setting('percent_text','Customer Satisfaction'));
				?></span>
				<?php
					etc_print_html($widget->get_setting('percent_text2','based on 750+ reviews of 6,154 Completed Projects, and 2,194 Happy Customers trust us.'));
				?>
			</div>
		</div>
	<?php } 
		// video
		allianz_elementor_button_video_render($widget, $settings, [
			'name'       => 'video_link',
			'icon'       => $widget->get_setting('video_icon'),
			'icon_class' => '',
			'text'       => $widget->get_setting('video_text'),
			'text_class' => '',
			'layout'     => '1',
			'class'      => '',
	    ]);
	?>
	<div <?php etc_print_html($widget->get_render_attribute_string('ttmn-wrap')); ?>>
		<?php foreach ($testimonials as $key => $testimonial) {
            $rated = $testimonial['star_rated'];
        ?>
            <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-item')); ?>>
            	<span class="cms-ttmn-quote-icon cmsi-quote absolute top-right text-30 text-primary-darken lh-0 mt-n15 mr-20"></span>
                <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-description')); ?>><?php 
                    etc_print_html($testimonial['description']); 
                ?></div>
                <div class="cms-ttmn-info d-flex gap-20 align-items-start pt-20 mb-n8">
                    <?php if($rated != 0){ ?>
                        <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-rate')); ?>>
                            <div <?php etc_print_html($widget->get_render_attribute_string('ttmn--rate')); ?> data-width="<?php echo esc_attr($rated);?>" style="width:<?php echo esc_attr($rated.'%');?>"></div>
                        </div>
                    <?php } ?>
                    <div class="cms-ttmn-name mt-n7">
                        <span <?php etc_print_html($widget->get_render_attribute_string('ttmn-author')); ?>><?php echo esc_html($testimonial['name']); ?>,</span>
                        <span <?php etc_print_html($widget->get_render_attribute_string('ttmn-author-pos')); ?>><?php echo esc_html($testimonial['position']); ?></span>
                    </div>
                </div>
            </div>
        <?php } ?>
	</div>
</div>