<?php
function bloc_presentation() {
	$title   = get_sub_field('titre_bloc');
	$presentation   = get_sub_field('description_presentation');
	$lien   = get_sub_field('lien_page_datterrissage');
?>

<section class="section-presentation"  style="background-image: url(/wp-content/uploads/2024/07/jpl-bg.jpg);background-size:cover;background-repeat:no-repeat; background-position:center;">
        <div class="presentation">
                <h2 class="h2-presentation result-h1"><?= $title; ?></h2>
                <?= $presentation; ?>
				<div class="flx-btn">
					<a href="<?= $lien; ?>" class="btn-presenta">En savoir plus</a>
				</div>
        </div>
</section>

<?php
}