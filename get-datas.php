<?php  
echo "getting data from your file<br/>";

if(file_exists('./my_data.json')){	
	$filename = './my_data.json';	
	$data = file_get_contents($filename); //data read from json file	
	//print_r($data);	
	$results = json_decode($data);
	echo "id :".$results->Id." <br/>";
	echo "Nom compétition :".$results->Nom;
	echo "<br/><br/> <br/><br/>                  ------------------------------------";
	print_r($results); //array format data printing	 
	$message = "<h3 class='text-success'>JSON file data</h3>";}
else{	 
	$message = "<h3 class='text-danger'>JSON file Not found</h3>";
}
?>
