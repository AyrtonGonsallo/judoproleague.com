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
	<?php if ( 'video_youtube' === get_post_type() ) : ?>
		<div class="">
			<div class="video-preview news-img-2-col" style="background-image: url(<?php echo str_replace("hq","maxres",get_field('image',get_the_ID()))?>);">
				<div class="button-play-video button-play-video-grande-taille" >
					<?php echo do_shortcode('[video_lightbox_youtube video_id="'.get_field('id',get_the_ID()).'" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
				</div>
				<div class="button-play-video button-play-video-mobile" >
					<?php echo do_shortcode('[video_lightbox_youtube video_id="'.get_field('id',get_the_ID()).'" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
				</div>
			</div>
			<div class="nv-right-content">
				<div ><h2 class="entry-title"><?php echo get_field('titre',get_the_ID());?></h2></div>
			</div>
		</div>
		
	<?php else : ?>
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
	<?php endif; ?>
	
</article>
