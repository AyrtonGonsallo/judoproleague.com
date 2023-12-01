<?php



/**



 * Template part pour la liste des articles



 *



 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/



 *



 * @package pro-league



 */







?>



<div>



<article id="myarticles post-<?php the_ID(); ?>" <?php post_class(); ?>>



	<div class="thumb-article" style="background-image: url('<?php the_post_thumbnail_url();?>')">



		



	</div>



	<div class="content-article">



		<header class="entry-header news-content">



			



			<?php



            $url_externe=get_field('activer_lien_poule', $post->ID);



            //echo $url_externe;exit(-1);



            $video = get_field( "videos_a_la_une", $post->ID );



			if ( is_singular() ) :



				the_title( '<h1 class="entry-title">', '</h1>' );



			elseif($url_externe=='Activer'):



                $url=get_field('lien_classement', $post->ID);



                the_title( '<h3 class="title-news-singular"><a href="' . $url . '" rel="bookmark" target="_blank">', '</a></h3>' );



				echo '<span>'.get_the_date('j F Y', $my_post->ID ).'</span>';



			elseif($video!=null):



				$id = explode('watch?v=', $video)[1];//https://www.youtube.com/watch?v=EBmDX7MNHSI



				echo '<h3 class="title-news-singular video-grande-taille">'.



					do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="640" height="480" anchor="'.get_the_title().'"]').



				'</h3>';



							echo '<h3 class="title-news-singular video-mobile">'.



					do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="300" height="160" anchor="'.get_the_title().'"]').



				'</h3>';



				echo '<span>'.get_the_date('j F Y', $my_post->ID ).'</span>';



            else:



				the_title( '<h3 class="title-news-singular"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );



				echo '<span>'.get_the_date('j F Y', $my_post->ID ).'</span>';



			endif;



			if ( 'post' === get_post_type() ) :



				?>



				<div class="entry-meta">



					<?php



					//pro_league_posted_on();



					//pro_league_posted_by();



					?>



				</div><!-- .entry-meta -->



			<?php endif; ?>



		</header><!-- .entry-header -->


		
		<div class="entry-content">


		
			<?php



			$post_type=get_the_title( get_option('page_for_posts', true) );



			//var_dump($post_type);exit();



			if($post_type=="Actualités" && !is_singular() ){



				$excerpt = get_the_excerpt();



				echo wp_trim_words( $excerpt, 22, '  [...]' ); 



			}



			elseif(is_singular() ){



				the_content(



					sprintf(



						wp_kses(



							/* translators: %s: Name of current post. Only visible to screen readers */



							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'pro-league' ),



							array(



								'span' => array(



									'class' => array(),



								),



							)



						),



						wp_kses_post( get_the_title() )



					)



				);



			}



			



			?>



		</div><!-- .entry-content -->



	</div>



</article><!-- #post-<?php the_ID(); ?> -->



		</div>



