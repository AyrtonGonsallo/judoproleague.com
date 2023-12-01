<?php
function bloc_presentation() {
	$title   = get_sub_field('titre_bloc');
	$presentation   = get_sub_field('description_presentation');
	$lien   = get_sub_field('lien_page_datterrissage');
?>

<section class="section-presentation">
        <div class="presentation">
                <h2 class="h2-presentation"><?= $title; ?></h2>
                <?= $presentation; ?>
				<div class="cl-more">
					<a href="<?= $lien; ?>" class="more">En savoir plus</a>
				</div>
        </div>
</section>

<?php
}