<?php
session_start();
include_once('../class/autoload.php');
$data = array();
$mypdo=new mypdo();
array_push($data,$_SESSION['token']); // data[0] -> token

echo 'debut reset_pass ';
if(isset($_POST['id']) && isset($_POST['mp']) && isset($_POST['Newmp']))
{
    if ($mypdo->tokenExist($data[0]))
    {
        echo 'tokenexist ';
        if ($mypdo->isTokenValid($data[0]))
        {
            if ($_POST['mp'] == $_POST['Newmp'])
            {
                echo 'mdp similaires ';
                $idUser = $mypdo->selectID($_POST['id']);
                $donnees = $idUser->fetch(PDO::FETCH_OBJ);

                array_push($data,$donnees->id); // data[1] -> id utilisateur 
                array_push($data,$_POST['id']); // data[2] -> login utilisateur
                array_push($data,$_POST['mp']); // data[3] -> Nouveau mdp

                if ($mypdo->tokenCorrespondID($data[1],$data[0]))
                {
                    if ($mypdo->changePass($data[1], $data[3]))
                    {   
                        echo 'mdp modifié ';
                        $data['success']=true;
                        $data['message']='Mot de passe modifié !';
                    
                    }
                    else
                    {
                        echo 'mdp non modifié ';
                        $data['success']=false;
                        $data['message']='Une erreur est survenue : le mot de passe n a pas pu être modifié';
                    }
                }
                else
                {
                    $data['success']=false;
                    $data['message']='Une erreur est survenue : Le token renvoyé ne correspond pas à l utilisateur';
                }
            }
        }
        else 
        {
            $data['success']=false;
            $data['message']='Une erreur est survenue : Les 2 mots de passes ne correspondent pas !';
        }
    }
    else 
    {
        $data['success']=false;
        $data['message']='Une erreur est survenue : Le token n existe pas !';
    }


}

echo json_encode($data);


?>