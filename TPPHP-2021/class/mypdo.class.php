<?php
class mypdo extends PDO{
	private string $PARAM_hote='localhost'; // le chemin vers le serveur
	private string $PARAM_utilisateur='root'; // nom d'utilisateur pour se connecter
	private string $PARAM_mot_passe=''; // mot de passe de l'utilisateur pour se connecter
	private string $PARAM_nom_bd='tourisme_france';
	private PDO $connexion;
    
    public function __construct() {
    	try {
    		
    		$this->connexion = new PDO('mysql:host='.$this->PARAM_hote.';dbname='.$this->PARAM_nom_bd, $this->PARAM_utilisateur, $this->PARAM_mot_passe,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    		//echo '<script>alert ("ok connex");</script>)';echo $this->PARAM_nom_bd;
    	}
    	catch (PDOException $e)
    	{
    		echo 'hote: '.$this->PARAM_hote.' '.$_SERVER['DOCUMENT_ROOT'].'<br />';
    		echo 'Erreur : '.$e->getMessage().'<br />';
    		echo 'N° : '.$e->getCode();
    		$this->connexion=false;
    		//echo '<script>alert ("pbs acces bdd");</script>)';
    	}
    }
    public function __get($propriete) {
    	switch ($propriete) {
    		case 'connexion' :
    			{
    				return $this->connexion;
    				break;
    			}
    	}
    }
    
    public function liste_article($title)
    {
		
		$requete='select a.h3,s.nom,s.prenom,a.date_redaction,a.corps from article a,page pa,publication pu,salarie s where a.publie = 1 and DATEDIFF(IFNULL(a.date_deb, NOW()), NOW()) <=0 and DATEDIFF(IFNULL(a.date_fin, NOW()), NOW()) >=0 and s.id = a.salarie and pa.id=pu.idPage and pu.idArticle=a.id and pa.title="'.$title.'" order by pu.numordre;';

    	$result=$this->connexion ->query($requete);
    	if ($result)
    
    	{
  		
    			return ($result);
   		}
    	return null;
    }
    public function liste_dep()
    {
    
    	$requete='SELECT departement_code,departement_nom,libel FROM departement,region,departement_region WHERE departement_id= code_dep and code_reg=code order by departement_code;';
    
    	$result=$this->connexion ->query($requete);
    	if ($result)
    
    	{
    
    		return ($result);
    	}
    	return null;
    }

	public function liste_highlight()
	{
		$requete = 'select id, image, titre, texte, latitude, longitude from highlight h';
		$result=$this->connexion ->query($requete);
    	if ($result)
    
    	{
    
    		return ($result);
    	}
    	return null;
	}

	public function highlightbyid($id)
	{
		$requete = 'select * from highlight where highlight.id = '.$id.'';
		$result=$this->connexion ->query($requete);
    	if ($result)
    	{
    		return ($result);
    	}
    	return null;
	}

	public function connect($data)
	{

		$requete = 'select * from salarie where login ="'.$data[0].'" and mp =MD5("'.$data[1].'") and grade ='.$data[2].' ';
		$result=$this->connexion ->query($requete);
    	if ($result)
    	{
			if ($result->rowCount() == 1)
			{
    		return ($result);
			}	
    	}
    	return null;
	}


	public function idExist($data)
	{
		$requete = 'select * from salarie where login = "'.$data[0].'"';
		$result = $this->connexion->query($requete);
		if ($result)
		{
			if ($result->rowCount() == 1)
			{
    			return ($result);
			}	
		}
		return null;
	}



	public function tokenExist($token)
	{
		$requete = 'select * from token where jeton = "'.$token.'"';
		$result = $this->connexion->query($requete);

		if ($result)
		{
			if ($result->rowCount() == 1)
			{
    			return ($result);
			}	
		}
		return null;
	}


	public function tokenCorrespondID($id, $token)
	{		
		$requete = 'select * from token where jeton = "'.$token.'" and id_login = "'.$id.'"';
		$result = $this->connexion->query($requete);


		if ($result)
		{
			if ($result->rowCount() == 1)
			{
    			return ($result);
			}	
		}
		return null;

	}

	public function changePass($id, $newpass)
	{
		$requete = 'update salarie set mp = MD5("'.$newpass.'") where id = "'.$id.'"';
		$result = $this->connexion->prepare($requete);


		$requete2 = 'delete from token where id_login = "'.$id.'"';
		$result2 = $this->connexion->prepare($requete2);

		if ($result->execute() && $result2->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function insertToken($data)
	{
		
		//$requete = 'insert into token (id_login, date, jeton) VALUES (":id",NOW(),":token")'; 
		$requete = 'insert into token (id_login, date, jeton) VALUES ("'.$data[1].'",NOW(),"'.$data[2].'")'; 
		$result = $this->connexion->prepare($requete);
		//$result->bindValue(':id', $data[0]);
		//$result->bindValue(':token', $data[1]);
		$result->execute();
	}


	public function liste_article_journaliste()
    {
		// and a.page=p.id -> Enlevé dans la requête.
    	$requete='select a.id,a.h3,a.date_deb,a.date_fin,p.title from article a,page p,salarie s where a.salarie=s.id  and s.login="'.$_SESSION['id'].'" and s.grade='.$_SESSION['categ'].' order by a.h3;';

    	$result=$this->connexion ->query($requete);
    	if ($result)
    
    	{
    		return ($result);
    	}
    	return null;
    }

	public function modif_article($tab)
    {
        	$errors         = array();
    	$data 			= array();
    $corps=utf8_encode($tab['corps']);
    	$requete='update article '
    	.'set h3='.$this->connexion ->quote($tab['titre']) .','
    	.'date_deb='.$this->connexion ->quote($tab['date_deb']) .','
    	.'date_fin='.$this->connexion ->quote($tab['date_fin']) .','
    	.'corps='.$this->connexion ->quote($corps) 
 		.' where id='.$_SESSION['id_article'] .';';

     $nblignes=$this->connexion -> exec($requete);
    if ($nblignes !=1)
    {
    	$errors['requete']='Pas de modifications d\'article :'.$requete;
    }
    
    
    
    	if ( ! empty($errors)) {
    		$data['success'] = false;
    		$data['errors']  = $errors;
    	} else {
    
    		$data['success'] = true;
    		$data['message'] = 'Modification article ok!';
    	}
    	return $data;
    }

	public function trouve_article_via_id($id)
    {
    
    	$requete='select a.h3,a.date_deb,a.date_fin,a.corps from article a 
    			where a.id='.$id.';';

    	$result=$this->connexion ->query($requete);
    	if ($result)
    
    	{
    
    		return ($result);
    	}
    	return null;
    }



	public function isTokenValid($token)
	{
		$requete = 'select * from token where jeton = "'.$token.'" and DATEADD(day, 1, date) < NOW()';
		$result = $this->connexion->query($requete);
		if ($result)
		{
			if ($result->rowCount() == 1)
			{
    			return ($result);
			}	
		}
		return null;
	}

	public function selectID($userLogin)
	{
		$requete = 'select * from salarie where login = "'.$userLogin.'"';
		$result = $this->connexion->query($requete);
		if ($result)
		{
			if ($result->rowCount() == 1)
			{
    			return ($result);
			}	
		}
		return null;
	}

    
}
?>
