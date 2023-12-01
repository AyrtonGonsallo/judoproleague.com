<?php















/**







 * Template Name: Modèle equipe judoka







 */















get_header();







$titlebar   = get_field('header_de_la_page');







$title   = get_field('titre_de_la_page');







$couleur1 = get_field('couleur1'); 







$image=get_field('logo_principal');







$style_couleur1=($couleur1)?'style="background: '.$couleur1.';"':'style="background: #e5332a;"';















$couleur2 = get_field('couleur















$style_couleur2=($couleur2)?'style="background: '.$couleur2.';"':'style="background: #990021;"';







?>















<main id="primary" class="site-main home">







    <section class="nv-header-team" <?php echo $couleur1;?>>







        <div class="container">







            <div class="nv-logo-team">







                <img src="<?php echo $image;?>">







            </div>







        </div>







    </section>















    <section class="nv-header-nav" <?php echo $style_couleur2;?>>







        <div class="container">







            <div class="nv-nav">







                <a href="" class="team-link nvtl-active">Info générales</a>







                <a href="" class="team-link">Actualités</a>







                <a href="" class="team-link">Photo</a>







                <a href="" class="team-link">Vidéos</a>







                <a href="" class="team-link">Calendrier / Résultats</a>







                <a href="" class="team-link">Judokas</a>







            </div>







        </div>







    </section>















    <section class="nv-title-grade">







        <div class="container">







            <div class="nv-title">







                <h2 class="title-grade">AJBD 21-25 - JUDOKAS</h2>







            </div>







        </div>







    </section>















    <section class="nv-liste-judoka">







        <div class="container">







            <div class="nv-judokas">







                <div class="judoka">







                    <img src="/wp-content/uploads/2023/07/judoka.png">







                    <div class="nv-info-judoka">







                        <h3 class="judoka-name">Anne-Cécile Durand de la Barre</h3>







                        <div class="sep_judoka"></div>







                        <div class="nv-cat">







                            <span>Catégorie : +70kg</span>







                            <a href="">Fiche</a>







                        </div>







                    </div>







                </div>







            </div>







        </div>







    </section>















    















    <?php







   







get_footer();







?>