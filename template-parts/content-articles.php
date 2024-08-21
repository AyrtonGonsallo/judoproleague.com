<?php


/**


 * Template part pour un article (details)


 *


 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/


 *


 * @package pro-league


 */





?>


<div>


<article id="myarticles post-<?php the_ID(); ?>" <?php post_class(); ?>>





	<div class="thumb-article">


		<img src="<?php the_post_thumbnail_url();?>">


	</div>


	<div class="content-article">


		<header class="entry-header news-content test">


		<?php


			if ( is_singular() ) :


				the_title( '<h1 class="entry-title">', '</h1>' );


			else:


				the_title( '<h3 class="title-news-singular"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
				$date=get_the_date('j F Y', $my_post->ID );

				echo '<span>'.date.'</span>';


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