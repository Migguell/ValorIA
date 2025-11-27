<?php
/**
 * Template part for displaying posts in loop
 *
 * @package Allianz
 */
?>
<article <?php post_class( 'cms-blog' ); ?>>
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
				'class'     => 'cms-archive-meta mb-10 text-13',
				'gap'				=> 10
			]);
			allianz_entry_title([
				'class' => 'mb-15 text-line-4 font-body font-600 ls-2'
			]);
			allianz_entry_excerpt(['class' => 'text-line-6']);
			allianz_entry_link_pages();
			allianz_entry_readmore();
		?>
	</div>
</article>