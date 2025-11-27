<?php 
// Banner Content
// Banner Link
$banner_link_page = $widget->get_setting('banner_link_page','');
switch ($settings['banner_link_type']) {
	case 'page':
		$page = !empty($banner_link_page) ? get_page_by_path($banner_link_page, OBJECT) : [];
		$url  = !empty($page) ? get_permalink($page->ID) : '#';
		break;
	
	default:
		$url = $widget->get_setting('banner_link_custom', ['url' => '#'])['url'];
		break;
}
$widget->add_inline_editing_attributes( 'banner_link_text' );
$widget->add_render_attribute( 'banner_link_text', [
	'class' => [
		'btn btn-lg',
		'text-primary',
		'btn-white',
		'text-hover-primary',
		'btn-hover-white',
		'cms-hover-move-icon-up'
	],
	'href'	=> $url
]);
// Content
$widget->add_render_attribute('bc-heading', [
	'class' => [
		'cms-bc-heading d-flex align-items-center',
	],
	'style' => [
		'max-height:'.(!empty($settings['banner_custom_dimension']['height']) ? $settings['banner_custom_dimension']['height'] : 900).'px;'
	]
]);
// Small Heading
$widget->add_render_attribute( 'smallheading_text', [
	'class' => [
		'cms-smallheading',
		'text-'.$widget->get_setting('smallheading_color','accent'),
		'font-600',
		'pb-15 mt-n7',
		'empty-none'
	]
]);
// Large Heading
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
		'cms-desc-bold pt-25 font-600 empty-none',
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
// Email
$widget->add_render_attribute('semail',[
	'class' => [
		'smail',
		'text-accent text-hover-primary',
		'cms-hover-underline-2'
	],
	'href' => $settings['semail']
]);
// Phone
$widget->add_render_attribute('sphone',[
	'class' => [
		'sphone d-block pt-8',
		'cms-hover-underline'
	],
	'href' => $settings['sphone']
]);
// Signature
$widget->add_render_attribute('simage',[
	'class' => [
		'simage',
		'flex-basis'
	]
]);
// Socials
$socials = $widget->get_setting('socials', []);
$widget->add_render_attribute('socials', [
	'class' => [
		'cms-bc-socials',
		'd-flex gap-15 align-items-center',
		'pt-20'
	]
]);
// Experience
$experiences = $widget->get_setting('experiences', []);
$widget->add_render_attribute('experiences-wrap', [
	'class' => [
		'cms-experiences p-50 p-lr-mobile-20 mb-70 mb-tablet-40 bg-grey cms-radius-8 bg-shadow-9',
		'cms-lists cms-lists-3'
	]
]);
$widget->add_render_attribute('experiences-title', [
	'class' => [
		'experience-title text-heading mt-n7',
		'text-26 font-600',
		'pb-15 mb-40 bdr-b-2'
	]
]);
$widget->add_render_attribute('experiences-item',[
	'class' => [
		'cms-list',
		'd-flex gap-30',
		'hover-icon-bounce'
	]
]);
$widget->add_render_attribute('experience-item-title', [
	'class' => [
		'experience-item-title text-heading mt-n7',
		'text-20 font-600',
		'pb-10'
	]
]);
$widget->add_render_attribute('experience-desc', [
	'class' => [
		'experience-desc',
		'text-15 text-primary',
		'pb-10'
	]
]);
$widget->add_render_attribute('experience-time', [
	'class' => [
		'experience-time',
		'text-14 text-accent'
	]
]);
// Education
$educations = $widget->get_setting('cms_education', []);
$widget->add_render_attribute('educations-wrap', [
	'class' => [
		'cms-educations p-50 p-lr-mobile-20 mb-70 mb-tablet-40 bg-grey cms-radius-8 bg-shadow-9',
		'cms-lists-4'
	]
]);
$widget->add_render_attribute('educations-item',[
	'class' => [
		'cms-list',
		'hover-icon-bounce'
	]
]);
$widget->add_render_attribute('education-item-title', [
	'class' => [
		'education-title text-heading',
		'text-20 font-600 mt-n7',
		'pb-15'
	]
]);
$widget->add_render_attribute('education-small-title', [
	'class' => [
		'education-small-title text-heading',
		'text-15 font-600',
		'pb-15 mt-n5'
	]
]);
$widget->add_render_attribute('education-time', [
	'class' => [
		'education-time text-accent',
		'text-14'
	]
]);
$widget->add_render_attribute('education-desc', [
	'class' => [
		'education-desc text-primary',
		'text-15'
	]
]);
// Skill
$progressbar_list = $widget->get_setting('progressbar_list', []);
// wrap
$widget->add_render_attribute('wrap', [
	'class' => [
		'cms-eprogress-bar',
		'cms-eprogress-bar-skill',
		'p-50 p-lr-mobile-20 mb-70 mb-tablet-40 bg-grey cms-radius-8 bg-shadow-9'
	]
]);

// Testimnials
$testimonials = $widget->get_setting('testimonials', []);
// Arrows
$arrows = $widget->get_setting('arrows');
$arrows_type = $widget->get_setting('arrows_type', 'icon');
$arrows_icon_size = ($arrows_type === 'icon') ? 45 : 10; 
// Dots
$dots = $widget->get_setting('dots');
$dots_type = $widget->get_setting('dots_type', 'bullets');
$thumbnail_custom_dimension = [
    'width'  => !empty($settings['image_custom_dimension']['width']) ? $settings['image_custom_dimension']['width'] : 160,
    'height' => !empty($settings['image_custom_dimension']['height']) ? $settings['image_custom_dimension']['height'] : 160
];

// TTMN Wrap
$widget->add_render_attribute('ttmn-wrap', [
    'class' => [
        'cms-bc-ttmn relative',
        'p-50 pb-10 p-lr-mobile-20 mb-110 mb-tablet-40 bg-grey cms-radius-8 bg-shadow-9'
    ]
]);
// TTMN Description 
$widget->add_render_attribute('ttmn-description',[
    'class' => [
       'cms-ttmn-desc',
       'text-'.$widget->get_setting('desc_color','heading'),
       'text-22 lh-13636 font-600 mt-n7'
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
// TTMN Items
$widget->add_render_attribute('ttmn-item',[
    'class' => [
      'cms-ttmn-item',
      'swiper-slide'
    ]
]);
// Call to Action
// CTA Small Heading
$widget->add_render_attribute( 'cta_smallheading_text', [
	'class' => [
		'cms-smallheading',
		'text-'.$widget->get_setting('cta_smallheading_color','accent'),
		'font-600',
		'pb-15 mt-n7',
		'empty-none'
	]
]);
// CTA Large Heading
$widget->add_render_attribute( 'cta_heading_text', [
	'class' => [
		'cms-heading empty-none',
		'text-'.$widget->get_setting('cta_heading_color','heading'),
		'lh-1375'
	]
]);
// CTA Description
$widget->add_inline_editing_attributes( 'cta_description_text' );
$widget->add_render_attribute( 'cta_description_text', [
	'class' => array_filter([
		'cms-desc pt-30 empty-none',
		'text-'.$widget->get_setting('cta_description_color','body'),
		'pb-30'
	])
]);
// CTA Link
$cta_link_page = $widget->get_setting('cta_page_link','');
switch ($settings['cta_link_type']) {
	case 'page':
		$cta_page = !empty($cta_link_page) ? get_page_by_path($cta_link_page, OBJECT) : [];
		$cta_url  = !empty($cta_page) ? get_permalink($cta_page->ID) : '#';
		break;
	
	default:
		$cta_url = $widget->get_setting('cta_custom_link', ['url' => '#'])['url'];
		break;
}
$widget->add_inline_editing_attributes( 'cta_link_text' );
$widget->add_render_attribute( 'cta_link_text', [
	'class' => [
		'cms-link cms-link-circle d-flex align-items-center justify-content-center',
		'text-white',
		'bg-accent',
		'text-hover-white',
		'cms-hover-move-icon-up',
		'text-40'
	],
	'href'	=> $cta_url,
	'data-title' => $settings['cta_link_text']
]);
// Render Content
?>
<div class="cms-bc-wrap d-flex flex-nowrap flex-tablet-wrap gutter">
	<div class="col-xl-56-7073 col-6 col-tablet-12 pb-0">
		<?php ob_start(); 
		// Banner shadow
		allianz_elementor_image_render($settings,[
			'name'        => 'banner_shadow',
			'size'        => 'full',
			'img_class'   => 'absolute bottom-left',		
			'custom_size' => [],
			'before'      => '',
			'after'       => ''
		]); 
		?>
			<h2 class="banner-name absolute text-white"><?php echo nl2br($settings['banner_name']); ?></h2>
			<h2 class="banner-name absolute text-heading"><?php echo nl2br($settings['banner_name']); ?></h2>
			<div class="cms-overlay d-flex align-items-end">
				<div class="cms-banner-content p-tb-90 p-lr-50 p-lr-mobile-20">
					<div class="baner-bio text-white pb-23"><?php echo nl2br($settings['banner_bio']); ?></div>
					<?php if(!empty($settings['banner_link_text'])) { ?>
						<a <?php etc_print_html( $widget->get_render_attribute_string( 'banner_link_text' ) ); ?>><?php 
							// text
							echo esc_html( $settings['banner_link_text'] );
							// icon
							allianz_elementor_button_icon_render();
						?></a>
					<?php } ?>
				</div>
			</div>
		<?php
		$banner_content = ob_get_clean();
		// Banner
		allianz_elementor_image_render($settings,[
			'name'                  => 'banner',
			'custom_size'           => ['width' => 710, 'height' => 900],
			'img_class'             => 'img-cover',
			//'as_background'       => true,
			//'as_background_class' => 'cms-bg-banner cms-sticky bg-top-center',
			'max_height'          => true,
			//'content'             => $banner_content,	
			'before'                => '<div class="cms-bg-banner cms-sticky" style="--cms-sticky-top:0;">',
			'after'                 => $banner_content.'</div>'
		]);
		?>
	</div>
	<div class="col-xl-basic col-6 col-tablet-12">
		<div class="cms-bc-contents p-lr-0 p-lr-tablet-20">
			<div <?php etc_print_html($widget->get_render_attribute_string('bc-heading')); ?>>
				<div class="cms-bg--heading p-tb-40">
					<div <?php etc_print_html( $widget->get_render_attribute_string( 'smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
					<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
					<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_bold_text' ) ); ?>><?php echo nl2br( $settings['description_bold_text'] ); ?></div>
					<div <?php etc_print_html( $widget->get_render_attribute_string( 'description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
					<div class="cms-bc-info d-flex gap-50 gap-tablet-30 align-items-center text-16 pt-25">
						<div class="flex-auto">
							<a <?php etc_print_html($widget->get_render_attribute_string('semail')); ?>><?php echo esc_html($settings['semail']); ?></a>
							<a <?php etc_print_html($widget->get_render_attribute_string('sphone')); ?>><?php echo esc_html($settings['sphone']); ?></a>
						</div>
						<?php 
							// Signature image
							allianz_elementor_image_render($settings,[
								'name'        => 'simage',
								'size'        => 'custom',
								'custom_size' => ['width' => 106, 'height' => 78],
								'before'      => '<div '.$widget->get_render_attribute_string('simage').'>',
								'after'       => '</div>'
							]); 
						?>
					</div>
					<?php // Socials ?>
					<div <?php etc_print_html($widget->get_render_attribute_string('socials')); ?>><?php
						foreach ( $socials as $key => $value ) {			
							$link_key = $widget->get_repeater_setting_key( 'link', 'icons', $key );
							$widget->add_render_attribute( $link_key, [
								'class' => [
									'cms-social-item',
									'text-'.$widget->get_setting('social_color','primary'),
									'text-hover-'.$widget->get_setting('social_color_hover', 'accent')
								],
								'title' => $value['title']
							]);
							$widget->add_link_attributes( $link_key, $value['url'] );
						?>
						<a <?php etc_print_html($widget->get_render_attribute_string( $link_key )); ?>>
							<?php allianz_elementor_icon_render( $value['icon'], [], [ 'aria-hidden' => 'true', 'class' => 'cms-icon text-20' ] ); ?>
						</a>
					<?php } ?></div>
				</div>
			</div>
			<?php // Experience ?>
			<div <?php etc_print_html($widget->get_render_attribute_string('experiences-wrap')); ?>>
				<div <?php etc_print_html($widget->get_render_attribute_string('experiences-title')) ?>><?php 
					etc_print_html($settings['experience_title']);
				?></div>
			<?php 
				foreach ( $experiences as $key => $experience ):		
			?>
			  <div <?php etc_print_html($widget->get_render_attribute_string('experiences-item')); ?>>
			    <?php 
			    	allianz_elementor_icon_render($experience['icon'], [], [ 
							'aria-hidden' => 'true', 
							'class'       => 'cms-icon flex-auto',
							'icon_size'   => 48,
							'icon_color'  => 'primary'
			      ]);
			      ?>
			      <div class="cms-list-content flex-basic">
				    	<div <?php etc_print_html( $widget->get_render_attribute_string('experience-item-title') ); ?>><?php echo esc_html( $experience['title'] ) ?></div>
				    	<div <?php etc_print_html( $widget->get_render_attribute_string('experience-desc') ); ?>><?php
				    		echo nl2br($experience['description']);
				    	?></div>
				    	<div <?php etc_print_html( $widget->get_render_attribute_string('experience-time') ); ?>><?php 
				    		echo esc_html($experience['time'])
				    	?></div>
				    </div>
			  </div>
			<?php 
			endforeach;?></div>
			<?php // Education ?>
			<div <?php etc_print_html($widget->get_render_attribute_string('educations-wrap')); ?>>
				<div <?php etc_print_html($widget->get_render_attribute_string('experiences-title')) ?>><?php 
					etc_print_html($settings['education_title']);
				?></div>
				<?php 
				foreach ( $educations as $key => $education ):		
				?>
			  <div <?php etc_print_html($widget->get_render_attribute_string('educations-item')); ?>>
					<div class="d-flex gutter">
						<div class="col-4 col-smobile-12">
				      <div <?php etc_print_html( $widget->get_render_attribute_string('education-small-title') ); ?>><?php echo nl2br( $education['small_title'] ) ?></div>
				    	<div <?php etc_print_html( $widget->get_render_attribute_string('education-time') ); ?>><?php 
				    		echo esc_html($education['time'])
				    	?></div>
				    </div>
				    <div class="col-8 col-smobile-12">
				    	<div <?php etc_print_html( $widget->get_render_attribute_string('education-item-title') ); ?>><?php echo nl2br( $education['title'] ) ?></div>
				    	<div <?php etc_print_html( $widget->get_render_attribute_string('education-desc') ); ?>><?php
				    		echo nl2br($education['description']);
				    	?></div>
				    </div>
				  </div>
			  </div>
				<?php endforeach; ?>
			</div>
			<?php // Skill ?>
			<div <?php etc_print_html($widget->get_render_attribute_string('wrap')); ?>>
				<div <?php etc_print_html($widget->get_render_attribute_string('experiences-title')) ?>><?php 
					etc_print_html($settings['skill_title']);
				?></div>
				<?php foreach ( $progressbar_list as $key => $progressbar ):
					$max = $progressbar['percent']['size'];
					$duration = $widget->get_setting('duration',['size'=>2000])['size'];

					// Progress Title
					$title_key = $widget->get_repeater_setting_key( 'title', 'progressbar_list', $key );
					$widget->add_inline_editing_attributes( $title_key );
					$widget->add_render_attribute( $title_key, [
						'class'=>[
							'cms-progress-bar',
							'cms-progress-bar-w',
							'cms-progress-bar-title',
							'text-15 font-600 text-'.$widget->get_setting('title_color', 'heading'),
							'text-nowrap',
							'pb-15',
							'd-flex justify-content-between flex-nowrap',
						],
						'data-max'       => $max,
						'data-to-value'  => $max,
						'data-duration'  => $duration,
						'data-delimiter' => '',
						'style'		 => [
							//'width:'.$progressbar['percent']['size'].'%;',
							'transition-duration:'.$duration.'ms;'
						]
					]);
					// Progress Number
					$progressbar_number = $widget->get_repeater_setting_key('number', 'progressbar_list', $key);
					$widget->add_render_attribute($progressbar_number, [
						'class' => [
							'cms-progress-bar-number'
						],
						'data-max'       => $max,
						'data-to-value'  => $max,
						'data-duration'  => $duration,
						'data-delimiter' => '',
					]);
					// Progress Bar Wrap
					$progress_bar_wrap_key = $widget->get_repeater_setting_key( 'wrapper', 'progressbar_list', $key );
					$widget->add_render_attribute( $progress_bar_wrap_key, [
						'class'         => [
							'cms-progress-wrap',
							'bg-'.$widget->get_setting('progress_color','grey'),
						],
						'role'          => 'progressbar',
						'aria-valuemin' => '0',
						'aria-valuemax' => '100',
						'aria-valuenow' => $max,
					] );

					// Progress Bar
					$progress_bar_key = $widget->get_repeater_setting_key( 'progress_bar', 'progressbar_list', $key );
					$widget->add_render_attribute( $progress_bar_key, [
						'class'      => [
							'cms-progress-bar',
							'cms-progress-bar-w',
							'cms-progress--bar',
							'bg-'.$widget->get_setting('progressbar_color','accent')
						],
						'data-max'       => $max,
						'data-to-value'  => $max,
						'data-duration'  => $duration,
						'data-delimiter' => '',
						'data-delimiter' => '',
						'style'					 => [
							'transition-duration:'.$duration.'ms;'
						]
					] );
					?>
					<div class="cms-progress-bar-wrap">
						<?php if ( ! empty( $progressbar['title'] ) ) { ?>
			        <div <?php etc_print_html( $widget->get_render_attribute_string( $title_key ) ); ?>>
			        	<?php echo esc_html( $progressbar['title'] ); ?>
			        	<span class="cms-progress-bar-number-wrap font-700"><span <?php etc_print_html( $widget->get_render_attribute_string( $progressbar_number ) ); ?>></span>%</span>
			        </div>
						<?php } ?>
			      <div <?php etc_print_html( $widget->get_render_attribute_string( $progress_bar_wrap_key ) ); ?>>
			        <div <?php etc_print_html( $widget->get_render_attribute_string( $progress_bar_key ) ); ?>></div>
			      </div>
			    </div>
				<?php endforeach; ?>
			</div>
			<?php // Testimonials ?>
			<div <?php etc_print_html($widget->get_render_attribute_string('ttmn-wrap')); ?>>
				<div <?php etc_print_html($widget->get_render_attribute_string('experiences-title')) ?>><?php 
					etc_print_html($settings['ttmn_title']);
				?></div>
				<div class="cms-carousel swiper">
					<div class="swiper-wrapper">
						<?php foreach ($testimonials as $key => $testimonial) { 
							$testimonial['image_size'] = $settings['image_size'];
							$testimonial['image_custom_dimension'] = $thumbnail_custom_dimension;
						?>
						    <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-item')); ?>>
					        	<div <?php etc_print_html($widget->get_render_attribute_string('ttmn-description')); ?>><?php 
					            	etc_print_html($testimonial['description']); 
					        	?></div>
					        	<?php  if ($dots !== 'yes' || ($dots == 'yes' && $dots_type != 'custom')) { ?>
							    <div class="d-flex gap-30 align-items-center pt-25 pb-25 pl-10">
							      	<?php
							            allianz_elementor_image_render($testimonial,[
							                'name'           => 'image',
							                'image_size_key' => 'image',
							                'img_class'      => 'cms-ttmn--img circle cms-img-stroke',
							                'custom_size'    => $thumbnail_custom_dimension,
							                'before'         => '<div class="cms-ttmn-img relative flex-auto">',
							                'after'          => '</div>'
							            ]);
							        ?>
							        <div class="flex-basic">
								        <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-author')); ?>><?php echo esc_html($testimonial['name']); ?></div>
								        <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-author-pos')); ?>><?php echo esc_html($testimonial['position']); ?></div>
								    </div>
							    </div>
							    <?php } ?>
						    </div>
						<?php } ?>
					</div>
					<div class="d-flex gutter-50 flex-nowrap align-items-center pt-30 pb-30 pl-30">
	          		<?php // Arrows
	          		if ($arrows == 'yes') : ?>
	            		<div class="cms-carousel-buttons flex-auto d-flex justify-content-end gap-30">
	              			<div class="cms-carousel-button-hover-circle cms-carousel-button-prev ">
			                <?php
			                    allianz_elementor_icon_render($settings['arrow_prev_icon'],['library' => 'allianz-icon','value'   => 'allianz-icon-left-arrow'],['aria-hidden' => 'true', 'class' => 'rtl-flip', 'icon_size'=>15]);
			                ?>
	              			</div>
				              <div class="cms-carousel-button-hover-circle cms-carousel-button-next">
				                <?php
				                    allianz_elementor_icon_render($settings['arrow_next_icon'],['library' => 'allianz-icon','value'   => 'allianz-icon-right-arrow'],['aria-hidden' => 'true', 'class' => 'rtl-flip', 'icon_size'=>15]);
				                ?>
				              </div>
	            		</div>
			            <?php endif;
			          	if ($dots == 'yes') : ?>
			          	<div class="flex-basic">
					        <?php if($dots_type == 'custom'){ ?>
								<div class="thumbs-slider swiper">
									<div class="swiper-wrapper cms-carousel-dots-sync-<?php echo esc_attr($settings['element_id']); ?>">
									    <?php foreach ($testimonials as $key => $testimonial) {
									      $testimonial['image_size'] = $settings['image_size'];
									      $testimonial['image_custom_dimension'] = $thumbnail_custom_dimension;
									      ?>
									      <div class="swiper-slide">
									      	<div class="d-flex gap-30 align-items-center p-tb-8 pl-8">
										      	<?php
										            allianz_elementor_image_render($testimonial,[
										                'name'           => 'image',
										                'image_size_key' => 'image',
										                'img_class'      => 'cms-ttmn--img circle cms-img-stroke',
										                'custom_size'    => $thumbnail_custom_dimension,
										                'before'         => '<div class="cms-ttmn-img relative flex-auto">',
										                'after'          => '</div>'
										            ]);
										        ?>
										        <div class="flex-basic">
											        <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-author')); ?>><?php echo esc_html($testimonial['name']); ?></div>
											        <div <?php etc_print_html($widget->get_render_attribute_string('ttmn-author-pos')); ?>><?php echo esc_html($testimonial['position']); ?></div>
											    </div>
										    </div>
									      </div>
									    <?php } ?>
									</div>
								</div>
					        <?php } else { ?>
				      			<div class="cms-carousel-dots cms-carousel-dots-<?php echo esc_attr($settings['dots_type']); ?> cms-carousel-dots-primary-regular cms-carousel-dots-active-accent-regular mt-0"></div>
				          	<?php } ?>
			          	</div>
			 	    	<?php endif ;?>
			        </div>
				</div>
			</div>
			<?php // Call to Action ?>
			<div <?php etc_print_html( $widget->get_render_attribute_string( 'cta_smallheading_text' ) ); ?>><?php echo nl2br( $settings['smallheading_text'] ); ?></div>
			<h2 <?php etc_print_html( $widget->get_render_attribute_string( 'cta_heading_text' ) ); ?>><?php echo nl2br( $settings['heading_text'] ); ?></h2>
			<div <?php etc_print_html( $widget->get_render_attribute_string( 'cta_description_text' ) ); ?>><?php echo nl2br( $settings['description_text'] ); ?></div>
			<a <?php etc_print_html($widget->get_render_attribute_string('cta_link_text')); ?>><?php
				allianz_elementor_svg_hover_icon_render();
			?></a>
			<div class="pb-110 pb-tablet-40"></div>
		</div>
	</div>
</div>