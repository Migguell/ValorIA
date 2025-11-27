<?php
/**
 * Template part for displaying posts in loop
 *
 * @package Allianz
 */
?>
<div class="cms-single">
	<?php 
		allianz_entry_thumbnail([
			'size'      => 'large',
			'class'     => 'mb-35',
			'img_class' => ''
		]);
	?>
	<div class="cms-post--content">
		<?php 
			allianz_post_meta([
				'opt_prefix' => 'post_',
				'class'		 => 'cms-single-meta mb-10 text-13',
				'gap'		 => 10
			]);
			allianz_entry_single_title([
				'class' => 'mb-25 text-line-4 font-body font-600 ls-2'
			]);
		?>
		<div class="content clearfix"><?php 
			the_content(); 
			allianz_entry_link_pages();
		?></div>
		<div class="tags-share empty-none"><?php 
			allianz_entry_tagged_in(['class' => 'd-flex justify-content-center']);
			allianz_socials_share_default([
				'class' => 'd-flex gap-20 justify-content-center align-items-center pt-20 text-primary text-15',
				'show'	=> (bool)allianz_get_opt('post_social_share_on', false),
				'title' => esc_html__('Share','allianz')
			]); 
		?></div>
	</div>
</div>
<?php
// About Author
if(!empty(get_the_author_meta( 'description' )) && allianz_get_opt('post_author_info_on', false)){
?>
<div class="cms-author-info d-flex align-items-center gap text-mobile-center gap-30 gap-mobile-20">
    <div class="author-avatar flex-auto">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 120, '', '', ['class' => '']); ?>
    </div>
    <div class="author-desc flex-basic flex-mobile-auto">
    	<div class="author-name text-heading text-22 font-600 mt-n5 pb-10"><?php the_author_meta( 'display_name' ); ?></div>
		<div class="text-line-2 text-15"><?php  the_author_meta( 'description' ); ?></div>
		<?php
			// User Social
			allianz_get_user_social(); 
		?>
    </div>
</div>
<?php 
	}
	// Single Post Nav
	allianz_post_nav_default();
?>