<?php









/**









 * The template for displaying all single posts









 *









 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post









 *









 * @package pro-league









 */



















get_header();









?>



















	<main id="primary" class="site-main">



















		<?php









		while ( have_posts() ) :









			$post_type=get_post_type();









			if($post_type=="equipes"){









				the_post();









				get_template_part( 'template-parts/content-equipes', get_post_type() );









			}









			elseif($post_type=="judo_pro_league"){









				the_post();









				get_template_part( 'template-parts/content-pro-league2', get_post_type() );









			}


			elseif($post_type=="galerie"){









				the_post();









				get_template_part( 'template-parts/content-galerie', get_post_type() );









			}






			elseif($post_type=="judoka"){









				the_post();









				get_template_part( 'template-parts/content-judoka', get_post_type() );









			}





elseif($post_type=="rencontre"){









				the_post();









				get_template_part( 'template-parts/content-rencontre', get_post_type() );









			}



			









			elseif($post_type=="post"){









				the_post();









				get_template_part( 'template-parts/content-articles', get_post_type() );









			}









			else{









				the_post();









				get_template_part( 'template-parts/content', get_post_type() );









			}









			



















			the_post_navigation(









				array(









					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'pro-league' ) . '</span> <span class="nav-title">%title</span>',









					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'pro-league' ) . '</span> <span class="nav-title">%title</span>',









				)









			);



















			// If comments are open or we have at least one comment, load up the comment template.









			if ( comments_open() || get_comments_number() ) :









				comments_template();









			endif;



















		endwhile; // End of the loop.









		?>



















	</main><!-- #main -->



















<?php









get_sidebar();









get_footer();









