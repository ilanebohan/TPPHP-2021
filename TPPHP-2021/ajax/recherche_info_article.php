<?php
session_start();
include_once('../class/autoload.php');
$data = array();
$mypdo=new mypdo();

if(isset($_POST['id_article']))
{
	$_SESSION['id_article']=$_POST['id_article'];

	// exécution de la requête
	$resultat = $mypdo->trouve_article_via_id($_POST['id_article']);
	if(isset($resultat))
	{
		// résultats
		$donnees = $resultat->fetch(PDO::FETCH_OBJ);
		$data["h3"][] = ($donnees->h3);
		$data["corps"][] = ($donnees->corps);
		$data["date_deb"][] = ($donnees->date_deb);
		$data["date_fin"][] = ($donnees->date_fin);
	}
}
// renvoit un tableau dynamique encodé en json
echo json_encode($data);
?>
 
