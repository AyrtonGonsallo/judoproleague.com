<?php

/**
 * Template Name: Modèle de test
 */

get_header();

?>
    
 <?php

require_once (THEMEDIR.'inc/acf-blocs/bloc-video-en-live.php');

recuperer_video_live();

?>
   
<main id="primary" class="site-main home">
<section class="nv-bg-rencontre" style="background-image:url(/wp-content/uploads/2023/08/bg-rencontre.png)" data-generator="shortcode:fiche_rencontre()" data-post-id="<?php echo $post_id;?>">
    <div class="judo_pro_league mobile">
        <div class="nv-bloc-rencontre">
			<div class="nv-result-eqju">
				<div class="nv-container-iw">
					<div class="nv-title-iw">
						<div></div>
						<div class="nv-iw-1">
							<div> </div>
							<div class="nv-div-span"><span>I</span><span>W</span></div>
						</div>
					</div>
					<div> </div>
				</div>
				<div class="result-jdk-mobile">
					<div class="nv-rslt-mobile">
						<div class="nv-rgt-result-jdk">
							<h3 class="">PIERRE Baptiste</h3>
							<div class="rgt-result-jdk-1">
								<div class="penalite "></div>
								<div class="resut-new">
									<span>0</span>
									<span>1</span>
								</div>
							</div>
						</div>			
						<div class="nv-rgt-result-jdk">
							<h3 class="gagnant">PIERRE Baptiste</h3>
							<div class="rgt-result-jdk-1">
								<div class="penalite "><span><div class="carton-jaune"></div></span></div>
								<div class="resut-new">
									<span>0</span>
									<span>1</span>
								</div>
							</div>
						</div>
					</div>
					<div class="flex-col">
						<span class="nv-cat-jdk">-85kg</span>
						<span class="nv-duree-jdk" style="background-color: #aecd3f;">terminé</span>
					</div>
				</div>
			</div>
		</div>
    </div>
</section>
<?php

get_footer();