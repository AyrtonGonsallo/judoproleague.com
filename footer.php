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
			<div class="footer-logo">
				<a href="/">
					<img src="/wp-content/uploads/2022/11/JPL-LOGO-light.webp"  alt="Judo Pro League" decoding="async">
				</a>
            
            <div class="flx-gap">
                <div class="footer-rs">

                    <a href="https://www.youtube.com/@francejudo_/playlists" target="_blank"><i class="fa-brands fa-youtube" ></i></a>
                    <a href="https://www.facebook.com/judoproleague" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://twitter.com/proleaguejudo" target="_blank"><i class="fa-brands fa-twitter" ></i></a>
                    <a href="https://www.instagram.com/proleaguejudo/" target="_blank"><i class="fa-brands fa-square-instagram"></i></a>
                </div>
				</div>
				</div>
				
				
				<div class="footer-menu">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'conatiner' => false,
						'menu_class' => 'navbar-nav',
					)
				); ?>
                </div>
				
            <div class="footer-parts">
                 <p>Partenaires</p>
                 <!--<a href="https://www.renault.fr/" target="_blank">
                 <img class="img-1" src="/wp-content/uploads/2023/06/R_RENAULT_EMBLEM_RGB_Black_v21.1-1-e1686913222796.webp" ></a>-->
                 <a href="https://www.adidas.com/fr" target="_blank">
                 <img class="img-2" src="/wp-content/uploads/2026/09/adidas_logo-1.png"></a>
            </div>

            		
		</div> <!-- .site-info -->
        <div class="nv-copyright">            
            <div class="copyright">
                <p>Copyright <?php echo date('Y'); ?></p>
<p class="desktop"> - </p>
                <p><a href="https://www.ffjudo.com/mentions-legales" target="_blank">Mentions Légales</a></p>
<p class="desktop"> - </p>
<p>Judo Pronos Challenge : <a href="/protection-des-donnees-judo-pronos-challenge/" target="_self">Protection des Données & <a href="/reglement-officiel-judo-pronos-challenge/" target="_self">Règlement Officiel</a></a>
                </p>
            </div>
			                <div>
                <p class="info-footer">Toutes les informations de France Judo sur <a href="https://www.ffjudo.com/" class="link-footer" target="blank">www.ffjudo.com</a></p>
            </div>
        </div>
	</footer> <!-- #colophon -->
</div> <!-- #page -->


<?php wp_footer(); ?>
</body>
</html>


