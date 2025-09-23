<?php











function prettyPrint($array) {





	echo '<pre>'.print_r($array, true).'</pre>';





}





$steps=array("FINAL FOUR","QUARTS DE FINALE C & D","QUARTS DE FINALE A & B","Poule A","Poule B","Poule C","Poule D");





$results=array();





function array_msort($array, $cols)





	{





		$colarr = array();





		foreach ($cols as $col => $order) {





			$colarr[$col] = array();





			foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }





		}





		$eval = 'array_multisort(';





		foreach ($cols as $col => $order) {





			$eval .= '$colarr[\''.$col.'\'],'.$order.',';





		}





		$eval = substr($eval,0,-1).');';





		eval($eval);





		$ret = array();





		foreach ($colarr as $col => $arr) {





			foreach ($arr as $k => $v) {





				$k = substr($k,1);





				if (!isset($ret[$k])) $ret[$k] = $array[$k];





				$ret[$k][$col] = $array[$k][$col];





			}





		}





		return $ret;


	}



?>



<?php  function get_classement( $saison_value){

	$args = array(

		'post_type'=> 'rencontre',

		'posts_per_page' => -1,

		'meta_key' => 'date_de_debut',

		'orderby' => 'meta_value_num',

		'order' => 'DESC',
		'meta_query'     => 
		array(  
			'relation' => 'AND', // Ajout de la relation pour combiner les conditions
			array(
				'key'     => 'saisons',
				'compare' => 'LIKE',
				'value'   => $saison_value,
			),
			array(
				'key'     => 'niveau',
				'compare' => 'LIKE',
				'value'   => 'Phase de poules',
			),
		),	
	);

	$rencontres = get_posts( $args );
$resultats_trouves=false;
	//prettyPrint($rencontres);exit(-1);

	foreach($rencontres as $rencontre){

		$phase=get_field("phase",$rencontre->ID)[0];
		
		$equipe1=get_field( 'equipe_1',$rencontre->ID)[0];
		$equipe2=get_field( 'equipe_2',$rencontre->ID)[0];
		
			
			
			$results["total"][$equipe1->post_title]=[array("nom"=>$equipe1->post_title)];
			$results["total"][$equipe2->post_title]=[array("nom"=>$equipe2->post_title)];

			$results["total"][$equipe1->post_title][0]["classement"]=1;
			$results["total"][$equipe2->post_title][0]["classement"]=1;
			$results["total"][$equipe1->post_title][0]["points"]=0;
			$results["total"][$equipe2->post_title][0]["points"]=0;
			$results["total"][$equipe1->post_title][0]["points_marqués"]=0;
			$results["total"][$equipe2->post_title][0]["points_marqués"]=0;
			$results["total"][$equipe1->post_title][0]["ippons_marqués"]=0;
			$results["total"][$equipe2->post_title][0]["ippons_marqués"]=0;

		

	}

	foreach($rencontres as $rencontre){
		$equipe1=get_field( 'equipe_1',$rencontre->ID)[0];
		$equipe2=get_field( 'equipe_2',$rencontre->ID)[0];
		$phase=get_field("phase",$rencontre->ID)[0];
		$mode_de_calcul_classement=get_field("mode_de_calcul_classement",$rencontre->ID);
		$matchs_liste=get_field('les_combat',$rencontre->ID);
		
		
		if($matchs_liste[0]['combats'][0]){
			$resultats_trouves=true;
			//prettyPrint(get_field('les_combat')[0]['combats'][0]);exit(-1); 

			//echo sizeof($matchs_liste).' combats<br>';

			$results["total"][$equipe1->post_title][0]["points_marqués"]+=intval($matchs_liste[0]['points_equipe_1']);
			$results["total"][$equipe2->post_title][0]["points_marqués"]+=intval($matchs_liste[0]['points_equipe_2']);
			
			foreach($matchs_liste as $matchs){

				$ippons_equ1=0;

				$ippons_equ2=0;

				$i=0;

				$winner= $matchs['equipe_gagnante'];
				if ($winner=='équipe 1'){

					$results["total"][$equipe1->post_title][0]["victoires"]+=1;
					$results["total"][$equipe2->post_title][0]["defaites"]+=1;
					$results["total"][$equipe1->post_title][0]["points"]+=3;
					$results["total"][$equipe2->post_title][0]["points"]+=0;
				}
				if ($winner=='inconnue'){
					$results["total"][$equipe1->post_title][0]["nuls"]+=1;
					$results["total"][$equipe2->post_title][0]["nuls"]+=1;
					$results["total"][$equipe1->post_title][0]["points"]+=1;
					$results["total"][$equipe2->post_title][0]["points"]+=1;
				}
				if ($winner=='équipe 2'){
					$results["total"][$equipe1->post_title][0]["defaites"]+=1;
					$results["total"][$equipe2->post_title][0]["victoires"]+=1;
					$results["total"][$equipe1->post_title][0]["points"]+=0;
					$results["total"][$equipe2->post_title][0]["points"]+=3;
				}
				foreach($matchs['combats'] as $match){

					//prettyPrint($match);exit(-1);

					$judoka1=$match['judoka_equipe_1'][0];

					$judoka2=$match['judoka_equipe_2'][0];

					$equipes_par_saisons_1 =get_field('equipes_par_saisons',$judoka1->ID);
					$equipes_par_saisons_2 =get_field('equipes_par_saisons',$judoka2->ID);
					
					//var_dump($equipes_par_saisons);
					if ($equipes_par_saisons_1) {
						foreach ($equipes_par_saisons_1 as $eq1) {
							// Obtenir et afficher le titre de l'équipe
							if (isset($eq1['equipe_judoka']) && isset($eq1['saisons']) ) {
								//var_dump($eq1['saisons'][0]);
									
									if( $eq1['saisons']== $saison_value){
										$equipej1 = $eq1['equipe_judoka'][0];
									}
									
								
							}
							

						}
					}

					//var_dump($equipes_par_saisons);
					if ($equipes_par_saisons_2) {
						foreach ($equipes_par_saisons_2 as $eq2) {
							// Obtenir et afficher le titre de l'équipe
							if (isset($eq2['equipe_judoka']) && isset($eq2['saisons']) ) {
								//var_dump($equipe1['saisons'][0]);
									
									if( $eq2['saisons']== $saison_value){
										$equipej2 = $eq2['equipe_judoka'][0];
									}
									
								
							}
							

						}
					}
					$judoka_gagnant = $match['judoka_gagnant'];
					if($judoka_gagnant!=null && $judoka_gagnant==1){
						$results["total"][$equipej1->post_title][0]["matchs_v"]+=1;
						$results["total"][$equipej2->post_title][0]["matchs_d"]+=1;
						
					}else if($judoka_gagnant!=null && $judoka_gagnant==2){
						$results["total"][$equipej1->post_title][0]["matchs_d"]+=1;
						$results["total"][$equipej2->post_title][0]["matchs_v"]+=1;
					}else{
						$results["total"][$equipej1->post_title][0]["matchs_nuls"]+=1;
						$results["total"][$equipej2->post_title][0]["matchs_nuls"]+=1;
					}

					if($i==0){

						$results["total"][$equipej1->post_title][0]["nombre_de_rencontres"]+=1;

						$results["total"][$equipej2->post_title][0]["nombre_de_rencontres"]+=1;

					}
					
					if($mode_de_calcul_classement=="auto"){
							//lire les ippons(ippon1,ippon2) du fichier pour le classement
							$ippons_equ1+=$match['valeur_ippons_comptés_judoka_1'];
							$ippons_equ2+=$match['valeur_ippons_comptés_judoka_2'];
						$results["total"][$equipej1->post_title][0]["ippons_marqués"]+=$match['valeur_ippons_comptés_judoka_1'];
						$results["total"][$equipej2->post_title][0]["ippons_concédés"]+=$match['valeur_ippons_comptés_judoka_1'];
						$results["total"][$equipej2->post_title][0]["ippons_marqués"]+=$match['valeur_ippons_comptés_judoka_2'];
						$results["total"][$equipej1->post_title][0]["ippons_concédés"]+=$match['valeur_ippons_comptés_judoka_2'];
					
					}else if($mode_de_calcul_classement=="manual"){//manual : par analyse dans le code
						if (($match['valeur_ippon_judoka_1']>=1)){
							if((is_numeric($match['valeurs_shidos_judoka_2']['value']))){
								//si il y 0,1,2 shidos en face
								$ippons_equ1+=$match['valeur_ippon_judoka_1'];
								$results["total"][$equipej1->post_title][0]["ippons_marqués"]+=$match['valeur_ippon_judoka_1'];
								$results["total"][$equipej2->post_title][0]["ippons_concédés"]+=$match['valeur_ippon_judoka_1'];
							}else if(!(is_numeric($match['valeurs_shidos_judoka_2']['value']))){
								//si il y a penalité H,X,A,F,M en face
								$results["total"][$equipej1->post_title][0]["ippons_marqués"]+=($match['valeur_ippon_judoka_1']-1);
								$results["total"][$equipej2->post_title][0]["ippons_concédés"]+=($match['valeur_ippon_judoka_1']-1);
							}
							
						}
						if (($match['valeur_ippon_judoka_2']>=1)){
							if((is_numeric($match['valeurs_shidos_judoka_1']['value']))){
								//si il y 0,1,2 shidos en face
								$ippons_equ2+=$match['valeur_ippon_judoka_2'];

								$results["total"][$equipej2->post_title][0]["ippons_marqués"]+=$match['valeur_ippon_judoka_2'];
								$results["total"][$equipej1->post_title][0]["ippons_concédés"]+=$match['valeur_ippon_judoka_2'];
							}else if(!(is_numeric($match['valeurs_shidos_judoka_1']['value']))){
								//si il y a penalité H,X,A,F,M en face
								$results["total"][$equipej2->post_title][0]["ippons_marqués"]+=($match['valeur_ippon_judoka_2']-1);
								$results["total"][$equipej1->post_title][0]["ippons_concédés"]+=($match['valeur_ippon_judoka_2']-1);
							}
						}
					}
					
					/*
					*/
					if ($match['valeur_wazari__judoka_1']>=1){

						$results["total"][$equipej1->post_title][0]["wazaris_marqués"]+=$match['valeur_wazari__judoka_1'];


						$results["total"][$equipej2->post_title][0]["wazaris_concédés"]+=$match['valeur_wazari__judoka_1'];

					}

					if ($match['valeur_wazari__judoka_2']>=1){

						$results["total"][$equipej2->post_title][0]["wazaris_marqués"]+=$match['valeur_wazari__judoka_2'];

						$results["total"][$equipej1->post_title][0]["wazaris_concédés"]+=$match['valeur_wazari__judoka_2'];

					}

					$i++;

					$results["total"][$equipe1->post_title][0]["step"]=$phase->post_title;

					$results["total"][$equipe2->post_title][0]["step"]=$phase->post_title;

					$results["total"][$equipej1->post_title][0]["equipe_id"]=$equipe1->ID;

					$results["total"][$equipej2->post_title][0]["equipe_id"]=$equipe2->ID;

				}

				if($ippons_equ1>=5){

					$results["total"][$equipej1->post_title][0]["bonus"]=1;

				}

				if($ippons_equ2>=5){
					$results["total"][$equipej2->post_title][0]["bonus"]=1;
				}

				
			}

		}

		



	}



	$sorted_result_ids=array();
	foreach($results['total'] as $result_by_equipe){
		
		foreach($result_by_equipe as $result_by_equipe_data){
			//prettyPrint($result_by_equipe_data);
			
			array_push($sorted_result_ids,array("id"=>$result_by_equipe_data["nom"],"matchs_v"=>$result_by_equipe_data["matchs_v"],"points_totaux"=>$result_by_equipe_data["points"]+$result_by_equipe_data["bonus"],"bonus"=>$result_by_equipe_data["bonus"],"points"=>$result_by_equipe_data["points"],"points_marqués"=>$result_by_equipe_data["points_marqués"],"ippons_marqués"=>$result_by_equipe_data["ippons_marqués"]));
		}
	}
	$sorted_result_ids2=array_msort($sorted_result_ids,array('points_totaux'=>SORT_DESC,'matchs_v'=>SORT_DESC,'points_marqués'=>SORT_DESC,'ippons_marqués'=>SORT_DESC));
	
	//prettyPrint($sorted_result_ids);
	//prettyPrint($sorted_result_ids2);
	//exit(-1);
	if($resultats_trouves){
		$i=1;
		foreach($sorted_result_ids2 as $s2){
			
				$results['total'][$s2["id"]][0]["classement"]=$i;
				$sorted_results['total'][$s2["id"]]=$results['total'][$s2["id"]];
				
					$i+=1;
				
			
		}
	}
	
	//prettyPrint($sorted_results);
	//exit(-1);





	
	





	return $results;





}











	?>





						