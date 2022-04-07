<?php

session_start();

include_once('../class/autoload.php');

$errors         = array();
$data 			= array();
$data['success']=false;




$tab=array();
$mypdo=new mypdo();


$tab['titre']=$_POST['titre'];
$tab['date_deb']=$_POST['date_deb'];
$tab['date_fin']=$_POST['date_fin'];
$tab['corps']=$_POST['corps'];

$data=$mypdo-> modif_article($tab);
echo json_encode($data);
?>
