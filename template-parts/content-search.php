<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pro-league
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('resultat-recherche display-news-2-col'); ?>>
	<? if(get_the_post_thumbnail_url(get_the_ID(),'thumbnail')){?>	
		<div class="news-img-2-col" style="background-image: url(<?= the_post_thumbnail_url(get_the_ID(),'thumbnail');?>);"></div>
	<?}else{?>
		<div class="news-img-2-col" style="background-color: #000;"><? echo get_the_post_thumbnail_url(get_the_ID(),'thumbnail');?></div>
	<?}?>
	
	<div class="nv-right-content">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php
				pro_league_posted_on();
				pro_league_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</div>
</article>
