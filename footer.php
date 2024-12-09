<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pro-league
 */
?>
<?php dynamic_sidebar( 'bandeau_partenaires' ); ?>

    <footer id="colophon" class="site-footer">

		<div class="site-info">

			<div>
                <img src="/wp-content/uploads/2022/11/JPL-LOGO-light.webp">
            </div>

            

            <div class="flx-gap">

                <h4 class="footer-h4">Suivez France Judo sur les réseaux sociaux</h4>

                <div class="footer-rs">

                    <a href="https://www.youtube.com/@francejudo_/playlists" target="_blank"><i class="fa-brands fa-youtube" ></i></a>
                    <a href="https://www.facebook.com/judoproleague" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://twitter.com/proleaguejudo" target="_blank"><i class="fa-brands fa-twitter" ></i></a>
                    <a href="https://www.instagram.com/proleaguejudo/" target="_blank"><i class="fa-brands fa-square-instagram"></i></a>

                </div>

            <div class="footer-parts">
                 <p>Partenaires</p>
                 <a href="https://www.renault.fr/" target="_blank">
                 <img class="img-1" src="/wp-content/uploads/2023/06/R_RENAULT_EMBLEM_RGB_Black_v21.1-1-e1686913222796.webp" ></a>
                 <a href="https://ca-sportecoledevie.fr/" target="_blank">
                 <img class="img-2" src="/wp-content/uploads/2023/08/Credit-Agricole-e1688380056948.webp"></a>
            </div>

                <div>
                <p class="info-footer">Toutes les informations de France Judo sur <a href="https://www.ffjudo.com/" class="link-footer" target="blank">www.ffjudo.com</a></p>

            </div>

            </div>		

		</div><!-- .site-info -->

        <div class="nv-copyright">            

            <div class="copyright">


            <p>droit d'auteur <?php echo date('Y'); ?></p>

                <p><a href="https://www.ffjudo.com/mentions-legales" target="_blank">mentions légales</a></p>

                <p><a href="https://www.ffjudo.com/protection-des-donnees" target="_blank">protection des données</a></p>

            </div>

        </div>

	</footer><!-- #colophon -->

</div><!-- #page -->


<?php wp_footer(); ?>

</body>

</html>



