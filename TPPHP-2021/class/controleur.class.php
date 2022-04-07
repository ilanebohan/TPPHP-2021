<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
class controleur {
	private string $path='http://localhost/TPPHP-2021';
	private $vpdo;
	private $db;
	private $carousselImgs = array('aiguille-du-Midi.jpg','Bassin-dArcachon.jpg','Bassin-darcachon-dune-du-pilat.jpg','Bec-Hellouin-Tour-Saint-Nicolas.jpg','Bonifacio.jpg','Camargue.jpg','chateau-de-chambord.jpg','chateau-de-chenonceau.jpg','chateau-de-versailles.jpg','Cirque-de-gavarnie-Classic-.jpg','EthniCité-Saint-Rémy-sur-Creuse-Vienne.jpg','etretat.jpg','galerie des glaces.jpg','gargouille-notre-dame.jpg','Gorges-du-Tarn.jpg','Gorges-du-Verdon.jpg','grotte_oselle.jpg','lac-dannecy.jpg','louvre.jpg');
	public function __construct() {
		$this->vpdo = new mypdo ();
		$this->db = $this->vpdo->connexion;
	}
	public function __get($propriete) {
		switch ($propriete) {
			case 'vpdo' :
				{
					return $this->vpdo;
					break;
				}
			case 'db' :
				{
					
					return $this->db;
					break;
				}
		}
	}
	public function retourne_article($title)
	{
		
		$retour='<section><div class="d-flex flex-wrap">';
		$result = $this->vpdo->liste_article($title);
		if ($result != false) {
			while ( $row = $result->fetch ( PDO::FETCH_OBJ ) )
			// parcourir chaque ligne sélectionnée
			{
				$retour = $retour . '<article class="article"><div class="card text-white bg-dark m-2" >
				<div class="card-body">
				
					<h3 class="card-title">'.$row->h3.'</h3>
					<h4 class="card-subtitle">'.$row->nom." ".$row->prenom." ".$row->date_redaction.'</h4>
					<p class="card-text">'.$row->corps.'</p>
				
				</div>
				</div></article>';
			}
		$retour = $retour .'</div></section>';
		return $retour;
		}
	}

	
	public function genererMDP ($longueur = 8){
		// initialiser la variable $mdp
		$mdp = "";
	
		// Définir tout les caractères possibles dans le mot de passe,
		// Il est possible de rajouter des voyelles ou bien des caractères spéciaux
		$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ&#@$*!";
	
		// obtenir le nombre de caractères dans la chaîne précédente
		// cette valeur sera utilisé plus tard
		$longueurMax = strlen($possible);
	
		if ($longueur > $longueurMax) {
			$longueur = $longueurMax;
		}
	
		// initialiser le compteur
		$i = 0;
	
		// ajouter un caractère aléatoire à $mdp jusqu'à ce que $longueur soit atteint
		while ($i < $longueur) {
			// prendre un caractère aléatoire
			$caractere = substr($possible, mt_rand(0, $longueurMax-1), 1);
	
			// vérifier si le caractère est déjà utilisé dans $mdp
			if (!strstr($mdp, $caractere)) {
				// Si non, ajouter le caractère à $mdp et augmenter le compteur
				$mdp .= $caractere;
				$i++;
			}
		}
	
		// retourner le résultat final
		return $mdp;
	}
	public function retourne_formulaire_login() {
		$retour = '
		<div class="modal fade" id="myModal" role="dialog" style="color:#000;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
        				<h4 class="modal-title"><span class="fas fa-lock"></span> Formulaire de connexion</h4>
        				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="hd();">
        				</button>
      				</div>
					<div class="modal-body">
						<form role="form" id="login" method="post">
							<div class="form-group">
								<label for="id"><span class="fas fa-user"></span> Identifiant</label>
								<input type="text" class="form-control" id="id" name="id" placeholder="Identifiant">
							</div>
							<div class="form-group">
								<label for="mp"><span class="fas fa-eye"></span> Mot de passe</label>
								<input type="password" class="form-control" id="mp" name="mp" placeholder="Mot de passe">
							</div>
							<div class="form-group">
								<label class="radio-inline"><input type="radio" name="rblogin" id="rbj" value="rbj">Journaliste</label>
								<label class="radio-inline"><input type="radio" name="rblogin" id="rbr" value="rbr">Rédacteur en chef</label>
								<label class="radio-inline"><input type="radio" name="rblogin" id="rba" value="rba">Administrateur</label>
							</div>
							
							<button type="submit" class="btn btn-success btn-block" class="submit"><span class="fas fa-power-off"></span> Login</button>
						</form>
					</div>
					<a href="'.$this->path.'/perdu">Mot de passe perdu ?</a>
					<div class="modal-footer">
						<button type="button"  class="btn btn-danger btn-default pull-left" data-bs-dismiss="modal" onclick="hd();"><span class="fas fa-times"></span> Cancel</button>
						
					</div>
					
				</div>
			</div>
		</div>';
		return $retour;
		
	}


	public function retourne_modal_lostpass(){
		$retour = '<div class="modal fade" id="modalLost" role="dialog" style="color:#000;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><span class="fas fa-lock"></span> Formulaire de récupération de mot de passe</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="hd();">
					</button>
				  </div>
				<div class="modal-body">
					<form role="form" id="login" method="post">
						<div class="form-group">
							<label for="id"><span class="fas fa-user"></span> Identifiant</label>
							<input type="text" class="form-control" id="id" name="id" placeholder="Identifiant">
						</div>
						
						<button type="submit" class="btn btn-success btn-block" class="submit"><span class="fas fa-power-off"></span>Confirmer</button>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button"  class="btn btn-danger btn-default pull-left" data-bs-dismiss="modal" onclick="hd();"><span class="fas fa-times"></span> Cancel</button>
					
				</div>
				
			</div>
		</div>
	</div>';
		return $retour;
	}


	public function send_mail($vmailaqui, $vmaildequi, $sujet, $message)
	{
		$vretour = false;
		require 'vendor/phpmailer/phpmailer/src/Exception.php';
		/* The main PHPMailer class. */
		require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
		/* SMTP class, needed if you want to use SMTP. */
		require 'vendor/phpmailer/phpmailer/src/SMTP.php';


		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    	                                            //Send using SMTP
    	$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    	$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    	$mail->Username   = $vmaildequi;                     //SMTP username
    	$mail->Password   = 'Emilie44!';                               //SMTP password
    	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    	$mail->Port       = 587;       
		$mail->setFrom($vmaildequi);
		$mail->addAddress($vmailaqui);     //Add a recipient      
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = $sujet;
		$mail->Body    = $message;    

		if (!$mail->send())
		{
			echo 'non envoyé';
			$vretour = false;
		}
		else
		{
			echo 'envoyé';
			$vretour = true;
		}
		
		return $vretour;
		
	}

	public function retourne_formulaire_article()
	{
		$retour=  '
		<form style="display:none;" role="form" id="modifarticle" method="post"><h3>Modification Article</h3>
		<div class="form-group">
		<label for="id"> Titre</label>
		<input type="text" class="form-control" id="h3" name="h3" placeholder="Titre">
		</div>
		<div class="form-group">
		<label for="date_deb"> Date Début</label>
		<input type="text" class="form-control" id="date_deb" name="date_deb" placeholder="Date début">
		</div>
		<div class="form-group">
		<label for="date_fin"> Date Fin</label>
		<input type="text" class="form-control" id="date_fin" name="date_fin" placeholder="Date fin">
		</div>
				<div class="form-group">
		<label for="corps"> Article</label>

				<textarea class="form-control" rows="5" id="corps" name="corps" placeholder="Corps article"></textarea>
		</div>
		<button type="submit" class="btn btn-success btn-default"><span class="fas fa-power-off"></span>Modifier</button>
				<button type="button"" class="btn btn-danger btn-default pull-left" ><span class="fas fa-times"></span> Cancel</button>
				</form>';
		return $retour;
	}



	public function retourne_article_journaliste()
	{
	
		$retour='<script>$(document).ready(function() {$("#tart").dataTable();} )</script>
	<div class="table-responsive">
	<table id="tart" class="table table-striped table-bordered" cellspacing="0" >
    <thead><tr>
        <th>Titre article</th>
        <th>Page</th>
        <th>Date deb</th>
		<th>Date fin</th>
		<th></th>

    </tr></thead><tbody>';
		$result = $this->vpdo->liste_article_journaliste();
		if ($result != false) {
			while ( $row = $result->fetch ( PDO::FETCH_OBJ ) )
			// parcourir chaque ligne sélectionnée
			{
	
				$retour = $retour . '<tr><td>'.$row->h3.'</td><td>'.$row->title.'</td><td>'.$row->date_deb.'</td><td>'.$row->date_fin.
				'</td><td style="text-align: center;"><button type="button"" class="btn btn-primary btn-default pull-center" 
				onclick="modif_article('.$row->id.');">
				<span class=" fas fa-edit "></span>
				</button></td></tr>';
			}
			
		}
		$retour = $retour .'</tbody></table></div>';
		return $retour;
	}

	public function reset_pass()
	{
		$vretour = '<div class="modal fade" id="modalReset" role="dialog" style="color:#000;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
        				<h4 class="modal-title"><span class="fas fa-lock"></span> Formulaire de reinitialisation du mot de passe </h4>
        				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="hd();">
        				</button>
      				</div>
					<div class="modal-body">
						<form role="form" id="login" method="post">
							<div class="form-group">
								<label for="id"><span class="fas fa-user"></span> Identifiant</label>
								<input type="text" class="form-control" id="id" name="id" placeholder="Identifiant">
							</div>
							<div class="form-group">
								<label for="mp"><span class="fas fa-eye"></span> Mot de passe</label>
								<input type="password" class="form-control" id="mp" name="mp" placeholder="Mot de passe">
							</div>
							<div class="form-group">
								<label for="Newmp"><span class="fas fa-eye"></span>Nouveau Mot de passe</label>
								<input type="password" class="form-control" id="Newmp" name="Newmp" placeholder="Nouveau Mot de passe">
							</div>
							<button type="submit" class="btn btn-success btn-block" class="submit"><span class="fas fa-power-off"></span> Login</button>
						</form>
					</div> <div class="modal-footer">
					<button type="button"  class="btn btn-danger btn-default pull-left" data-bs-dismiss="modal" onclick="hd();"><span class="fas fa-times"></span> Cancel</button>
					
				</div>
				
			</div>
		</div>
	</div>';
		return $vretour;
	}
	

	public function retourne_modal_message()
	{
		$retour='
		<div class="modal fade" id="ModalRetour" role="dialog" style="color:#000;">
			<div class="modal-dialog">
				<div class="modal-content">
				<div class="modal-header">
        				<h4 class="modal-title"><span class="fas fa-info-circle"></span> INFORMATIONS</h4>
        				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="hd();">
        				</button>
      				</div>
		       		<div class="modal-body">
						<div class="alert alert-info">
							<p></p>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick="hdModalRetour();">Close</button>
					</div>
				</div>
			</div>
		</div>
		';
		return $retour;
	}	

	public function caroussel()
	{

		$retour='
			<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
				<div class="carousel-indicators">';

		for ($i = 0; $i < count($this->carousselImgs); $i++) {

			if($i==0){
				$retour=$retour.'<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="'.$i.'" class="active" aria-label="Slide '.($i+1).'" aria-current="true"></button>';
			}
			else{
				$retour=$retour.'<button type="button" data-bs-target="#myCarousel" data-bs-slide-to="'.$i.'" aria-label="Slide '.($i+1).'" class=""></button>';
			}
		}

		$retour=$retour.'</div>
				<div class="carousel-inner">';

				for ($i = 0; $i < count($this->carousselImgs); $i++) {

					if($i==0){
						$retour= $retour.'<div class="carousel-item active">
						
						<div class="container_caroussel">
							<img class="bd-placeholder-img image_caroussel" width="100%" height="500px" src="image/france/IMAGES_CAROUSSEL_RES/'.$this->carousselImgs[$i].'"></img>
						</div>
						</div>';
					}
					else{
						$retour= $retour.'<div class="carousel-item">
				
						<div class="container_caroussel">
							<img class="bd-placeholder-img image_caroussel" width="100%" height="500px" src="image/france/IMAGES_CAROUSSEL_RES/'.$this->carousselImgs[$i].'"></img>
						</div>
						</div>';
					}
				}
		

				$retour= $retour.'</div>
				<button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
				</button>
			</div>
		
		';
		return $retour;
	}

	public function retourne_departement()
	{
		$retour='
		<div class="table-responsive">
		<table id="tabDepartement" class="table table-striped table-bordered" cellspacing="0" >
		<thead>
		<tr>
			<th>Code département</th>
			<th>Département</th>
			<th>Région</th>
		</tr>
	</thead>
	<tbody>';
	$result = $this->vpdo->liste_dep();
	if ($result != false) {
		while ( $row = $result->fetch ( PDO::FETCH_OBJ ) )
		// parcourir chaque ligne sélectionnée
		{
			$retour = $retour . 
			'<tr>
			<td>'.$row->departement_code.'</td>
			<td>'.$row->departement_nom.'</td>
			<td>'.$row->libel.'</td> 
			</tr>';
		}
	}
	$retour = $retour . '</tbody> </table> </div>';
		return $retour;
}


	public function affiche_galerie()
	{

        $vretour='
		<style>
		.gal_container {
			position: relative;
		  }
			
		  .gal_overlay {
			position: absolute;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			height: 100%;
			width: 100%;
			opacity: 0;
			transition: .5s ease;
			background-color: #5e5e5eb4;
		  }
		  
		  .gal_container:hover .gal_overlay {
			opacity: 1;
		  }
		  
		  .gal_text {
			color: white;
			font-size: 20px;
			position: absolute;
			top: 50%;
			left: 50%;
			-webkit-transform: translate(-50%, -50%);
			-ms-transform: translate(-50%, -50%);
			transform: translate(-50%, -50%);
			text-align: center;
		  }

		</style>
        <div class="d-flex justify-content m-3 flex-wrap">
        <div class="row">';
		
		$result = $this->vpdo->liste_highlight();
        if ($result != false) {
            while ($row = $result->fetch(PDO::FETCH_OBJ))
            // parcourir chaque ligne sélectionnée
            {
                $vretour.='
                <div class="card col-9 col-sm-6 col-xl-4 gal_container" onclick="appelAjaxImg('.$row->id.')">
                    <img src="image/france/IMAGES/'.$row->image.'"  class="img-thumbnail gal_image" style="margin: auto">
                    <div class="gal_overlay" id="modal">
                        <div class="overlay">
                            <h5 class="card-title">'.$row->titre.'</h5>
                            <!--<p class="card-text">'.$row->texte.'</p>-->
                        </div>
                    </div>
                </div>
                ';
            }
        }
		$vretour.='</div></div>
        ';
        return $vretour;
	}	


	public function retourne_modal_hl($path)
	{
		$retour='
		<div id="ModalHl" class="modal " tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
		<div class="modal-content text-white bg-dark m-2">
		<div class="modal-header">
		<h5 id="ModalHl_titre" class="modal-title"></h5>
		<button type="button" class="btn-close-white" data-bs-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
		</div>
		<div class="modal-body">
		<img id="ModalHl_image" src1="'.$path.'/image/france/IMAGES  RES/" class="img-fluid rounded mx-auto d-block" alt=""/>

				<p></p>
						<div id="map" class="map"></div>
		</div>
		</div>
		</div>
		</div>
		';
		return $retour;
	}	


	public function articles_scienceavenir()
	{
		$xml1=simplexml_load_file("https://www.sciencesetavenir.fr/nature-environnement/rss.xml") or die("Error: Cannot create object");
		$retour ='
		<h1>Sciences et Avenir en temps réel : Nature & environnement</h1>
		<div class="d-flex justify-content flex-row flex-wrap">';
		$compteur = 0;
			foreach ($xml1->channel->item as $item)
			{
				$compteur += 1;
				$retour = $retour . '
				<div class="card text-white bg-dark  col-12 col-sm-6 col-md-4 col-lg-3" >
				<div class="card-body" m-1>
		  		<h3 class="card-title">'.$item->title.'</h3>
				<a href ="'.$item->link.'">LIEN</a>
				<p class="card-text">'.$item->description.'</p>';
				if (isset($item->enclosure['url']))
				{
				$retour = $retour . '<img class="card-img-bottom" src="'.$item->enclosure['url'].'" alt="img1"></img>';
				}
				
				$retour = $retour . '</div></div>';
				if ($compteur == 6)
				{
					break;
				}
			}

		 $retour = $retour .'
		 </div>
	 ';
	return $retour;
	}

	public function articles_lemonde()
	{
		$compteur = 0;
		$xml2=simplexml_load_file("https://www.lemonde.fr/planete/rss_full.xml") or die("Error: Cannot create object");
		$retour ='
		<h1>Planète : Toute l actualité sur LeMonde.fr</h1>
		<div class="d-flex justify-content flex-row flex-wrap">';
		foreach ($xml2->channel->item as $item)
			{
				$compteur += 1;
				$retour = $retour . '
				<div class="card text-white bg-dark  col-12 col-sm-6 col-md-4 col-lg-3" >
				<div class="card-body" m-1>
		  		<h3 class="card-title">'.$item->title.'</h3>
				<a href ="'.$item->link.'">LIEN</a>
				<p class="card-text">'.$item->description.'</p>';


				foreach ($item->children('media', true) as $k => $v) {
					$attributes = $v->attributes();
					if (count($attributes) == 0) {
						continue;
					} else {
						$image = $attributes->url;
					}} 

					$retour = $retour .'<img class="card-img-bottom" src="'.$image.'" alt="img1"></img>';

				$retour = $retour . '</div></div>';
				if ($compteur == 6)
				{
					break;
				}
			}
			$retour = $retour . '</div>';
			return $retour;

	}



}

?>
