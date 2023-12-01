<?php

function prettyPrint($array) {
	echo '<pre>'.print_r($array, true).'</pre>';
}
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


<?php  function get_classement($rencontres){
	foreach($rencontres as $rencontre){
		//prettyPrint(get_field('les_combat')[0]['combats'][0]);exit(-1); 
		$matchs_liste=get_field('les_combat',$rencontre->ID);
		//echo sizeof($matchs_liste).' combats<br>';
		foreach($matchs_liste as $matchs){
			
			//echo sizeof($matchs['combats']).' matchs<br>';
			//prettyPrint($matchs['combats']);exit(-1);
			foreach($matchs['combats'] as $match){
				$judoka1=$match['judoka_equipe_1'][0];
				$judoka2=$match['judoka_equipe_2'][0];
				$equipe1=($judoka1)?get_field( 'equipe_judoka',$judoka1->ID )[0]:get_field( 'equipe_1')[0];
				$equipe2=($judoka2)?get_field( 'equipe_judoka',$judoka2->ID )[0]:get_field( 'equipe_2')[0];
				$results[$equipe1->post_title]=[array("nom"=>$equipe1->post_title)];
				$results[$equipe2->post_title]=[array("nom"=>$equipe2->post_title)];
			}
		}
	}
	//prettyPrint($results);exit(-1); 
	foreach($rencontres as $rencontre){
		$matchs_liste=get_field('les_combat',$rencontre->ID);
		foreach($matchs_liste as $matchs){
			$ippons_equ1=0;
			$ippons_equ2=0;
			
			$winner= $matchs['equipe_gagnante'];
			foreach($matchs['combats'] as $match){
				//prettyPrint($match);exit(-1);
				$judoka1=$match['judoka_equipe_1'][0];
				$judoka2=$match['judoka_equipe_2'][0];
				$equipe1=get_field( 'equipe_judoka',$judoka1->ID )[0];
				$equipe2=get_field( 'equipe_judoka',$judoka2->ID )[0];
				
				$judoka_gagnant = $match['judoka_gagnant'];
				
				if ($match['valeur_ippon_judoka_1']==1){
					$ippons_equ1+=1;
					$results[$equipe1->post_title][0]["ippons_marqués"]+=1;
					$results[$equipe2->post_title][0]["ippons_concédés"]+=1;
				}
				if ($match['valeur_ippon_judoka_2']==1){
					$ippons_equ2+=1;
					$results[$equipe2->post_title][0]["ippons_marqués"]+=1;
					$results[$equipe1->post_title][0]["ippons_concédés"]+=1;
				}
				if ($match['valeur_wazari__judoka_1']==1){
					$results[$equipe1->post_title][0]["wazaris_marqués"]+=1;
					$results[$equipe2->post_title][0]["wazaris_concédés"]+=1;
				}
				if ($match['valeur_wazari__judoka_2']==1){
					$results[$equipe2->post_title][0]["wazaris_marqués"]+=1;
					$results[$equipe1->post_title][0]["wazaris_concédés"]+=1;
				}
				
			}
			if($results[$equipe1->post_title][0]["ippons_marqués"]>=6){
				$results[$equipe1->post_title][0]["bonus"]=1;
			}
			if($results[$equipe2->post_title][0]["ippons_marqués"]>=6){
				$results[$equipe2->post_title][0]["bonus"]=1;
			}
			$results[$equipe1->post_title][0]["nombre_de_rencontres"]+=1;
			$results[$equipe2->post_title][0]["nombre_de_rencontres"]+=1;
			if ($winner=='équipe 1'){
				$results[$equipe1->post_title][0]["victoires"]+=1;
				$results[$equipe2->post_title][0]["defaites"]+=1;
				$results[$equipe1->post_title][0]["points"]+=3;
				$results[$equipe2->post_title][0]["points"]+=0;
			}
			if ($winner=='inconnue'){
				$results[$equipe1->post_title][0]["nuls"]+=1;
				$results[$equipe2->post_title][0]["nuls"]+=1;
				$results[$equipe1->post_title][0]["points"]+=1;
				$results[$equipe2->post_title][0]["points"]+=1;
			}
			if ($winner=='équipe 2'){
				$results[$equipe1->post_title][0]["defaites"]+=1;
				$results[$equipe2->post_title][0]["victoires"]+=1;
				$results[$equipe1->post_title][0]["points"]+=0;
				$results[$equipe2->post_title][0]["points"]+=3;
			}
		}
	}
	//prettyPrint($results);
	//exit(-1);
	$sorted_results=array();
	$sorted_result_ids=array();
	
	foreach($results as $result){
		array_push($sorted_result_ids,array("id"=>$result[0]["nom"],"points"=>$result[0]["points"]));
	}
	
	$sorted_result_ids2=array_msort($sorted_result_ids,array('points'=>SORT_DESC));
	$i=0;
	foreach($sorted_result_ids2 as $s2){
		if($i<2){
			$results[$s2["id"]][0]["qualifié"]=1;
		}else{
			$results[$s2["id"]][0]["qualifié"]=0;
		}
		$i++;
		$sorted_results[$s2["id"]]=$results[$s2["id"]];
	}

	return $sorted_results;
}

	?>
						