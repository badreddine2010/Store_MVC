
<?php
if (!isset($_SESSION)) {

	session_start();
}

$title = "mvc-Store: show Commandes";
ob_start();
if (isset($_SESSION['user']) && $_SESSION['statut']==1) {

//-------------------------------------------------- Affichage ---------------------------------------------------------//

//require_once("../inc/menu.inc.php");
	echo '<h2> Voici les commandes passées sur le site </h2>';
	echo '<table border="1"><tr>';
	
	$sql = ("select * from commande left join user  on  user.id = id_user");
	$bdd = dbConnect();
	$req = $bdd->query($sql);
	$req->execute();
	$req->setFetchMode(PDO::FETCH_ASSOC);
	$information_sur_les_commandes = $req->fetchAll();
	echo "Nombre de commande(s) : " .$req->rowCount();
	echo "<table class='table table-bordered'> <tr>";
	//while($colonne = $information_sur_les_commandes->fetch_field())
	{    
		//echo '<th>' . $colonne->name . '</th>';
		?>
		<thead>
				<tr>
					<th>Commande</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Montant</th>
					<th>Date d'achat</th>
					<th>Etat</tthh>
					<th>Adresse mail</th>
					
				</tr>
			</thead> <?php
	}
	echo "</tr>";
	$chiffre_affaire = 0;
	foreach($information_sur_les_commandes as $key=>$commande)
		{
		$chiffre_affaire += $commande['montant'];
		echo '<div>';
		echo '<tr>';
		echo '<td><a href="?action=detailsCommande&suivi=' . $commande['id_commande'] . '">Voir la commande ' . $commande['id_commande'] . '</a></td>';
		echo '<td>' . $commande['nom'] . '</td>';
		echo '<td>' . $commande['prenom'] . '</td>';
		echo '<td>' . $commande['montant'] . '</td>';
		echo '<td>' .strftime('%d-%m-%Y',strtotime($commande['date_enregistrement'])).'</td>';
		echo '<td>' . $commande['etat'] . '</td>';	
		echo '<td>' . $commande['email'] . '</td>';
		echo '</tr>	';
		echo '</div>';
	}
	echo '</table><br />';
	echo 'Calcul du montant total des revenus:  <br />';
		print "le chiffre d'affaires de la sociéte est de : $chiffre_affaire €"; 
	
	echo '<br />';
	echo '<br />';
	echo '<br />';
	echo '<br />';
	if(isset($_GET['suivi']))
	{	
		echo '<h2> Voici le détails pour une commande :</h2>';
		echo '<table table table-bordered>';
		echo '<tr>';
		$sql = ("select * from details_commande where id_commande=$_GET[suivi]");
		$bdd = dbConnect();
        $req = $bdd->query($sql);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $information_sur_une_commande = $req->fetchAll();
		//$nbcol = $information_sur_une_commande->field_count;
		//$nbcol = $information_sur_une_commande->field_count;
		echo "<table class='table table-bordered'> <tr>";
		//for ($i=0; $i < $nbcol; $i++)
		{    
			//$colonne = $information_sur_une_commande->fetch_field(); 
			//echo '<th>' . $colonne->name . '</th>';
			?>
			<thead>
					<tr>
						<th>Id_Détail_Commande</th>
						<th>Numéro de Commande</th>
						<th>Id_Produit</th>
						<th>Désignation</th>
						<th>Quantité</th>
						<th>Montant</th>
						

					</tr>
				</thead> <?php
		}
		echo "</tr>";
		
		foreach($information_sur_une_commande as $key=>$details_commande)

		{
			
			echo '<tr>';
				echo '<td>' . $details_commande['id_details_commande'] . '</td>';
				echo '<td>' . $details_commande['id_commande'] . '</td>';
				echo '<td>' . $details_commande['id_produit'] . '</td>';
				echo '<td>' . $details_commande['designation'] . '</td>';
				echo '<td>' . $details_commande['quantite'] . '</td>';
				echo '<td>' . $details_commande['prix'] . '</td>';

			echo '</tr>';
		}
		echo '</table>';
	}
}
else{             
	
	if (isset($_SESSION['user']) && $_SESSION['statut']==2) {

		// function dbConnect() {
		// 	$connectString = "mysql:host=localhost;dbname=tp_store;charset=utf8";
		// 	try {
		// 	$bdd = new PDO($connectString, "root", "", 
		// 				array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION)
		// 			);
		// 			return $bdd;
		// 	}
		// 	catch (PDOException $ex) {
		// 		var_dump("Erreur GET COURSE: {$ex->getMessage()}");
		// 	}
		// }

//-------------------------------------------------- Affichage ---------------------------------------------------------//
//require_once("../inc/menu.inc.php");
$id_membre = $_SESSION['id'];

	echo '<h2> Voici les commandes passées sur le site </h2>';
	echo '<table border="1"><tr>';
	
	$sql = ("select id_commande,id_user,montant,date_enregistrement,etat from commande where id_user = '$id_membre'");
	$bdd = dbConnect();
        $req = $bdd->query($sql);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $information_sur_les_commandes = $req->fetchAll();
	
	echo "Nombre de commande(s) : " . $req->rowCount();

	echo "<table class='table table-bordered'> <tr>";
	//while($colonne = $information_sur_les_commandes->fetch_field())
	{    
		//echo '<th>' . $colonne->name . '</th>';
		?>
		<thead>
				<tr>
					<th>Commande</th>
					<th>Montant</th>
					<th>Date d'achat</th>
					<th>Etat</th>
					<th>Facture</th>
				</tr>
			</thead> <?php
	}
	echo "</tr>";
	$chiffre_affaire = 0;
	// while ($commande = $req->fetch())
	// var_dump($information_sur_les_commandes);
	// die;
	foreach($information_sur_les_commandes as $key=>$commande){
	
		$chiffre_affaire += $commande['montant'];
		echo '<div>';
		echo '<tr>';
		echo '<td><a href="?action=detailsCommande&suivi=' . $commande['id_commande'] . '">Voir la commande ' . $commande['id_commande'] . '</a></td>';	
		echo '<td>' . $commande['montant'] . '€'.'</td>';
		echo '<td>' .strftime('%d-%m-%Y',strtotime($commande['date_enregistrement'])).'</td>';
		echo '<td>' . $commande['etat'] . '</td>';
		echo '<td><a class="" target="_blank" href="?action=facture&id_commande='.$commande["id_commande"].'">Facture au format pdf</a></td>';
		echo '</tr>	';
		echo '</div>';
	}
	echo '</table><br />';
	
	
	echo '<br />';
	echo '<br />';
	echo '<br />';
	echo '<br />';
	if(isset($_GET['suivi'])){	
		echo '<h2> Voici le détails pour une commande :</h2>';
		echo '<table table table-bordered>';
		echo '<tr>';
		$sql =("select * from details_commande where id_commande=$_GET[suivi]");
		// $sql =("select * from details_commande where id_commande=3");
		$bdd = dbConnect();
        $req = $bdd->query($sql);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $information_sur_une_commandes = $req->fetchAll();
		//$nbcol = $information_sur_une_commande->field_count;
		echo "<table class='table table-bordered'> <tr>";
		//for ($i=0; $i < $nbcol; $i++)
		// {    
			//$colonne = $information_sur_une_commande->fetch_field(); 
			//echo '<th>' . $colonne->name . '</th>';
			?>
			<thead>
					<tr>
						<th>Numéro de Commande</th>
						<th>Désignation</th>
						<th>Quantité</th>
						<th>Montant</th>
					</tr>
				</thead> <?php
		// }
		echo "</tr>";
		
		foreach($information_sur_une_commandes as $key=>$details_commande)
	
		{
			echo '<tr>';
				echo '<td>' . $details_commande['id_commande'] . '</td>';
				echo '<td>' . $details_commande['designation'] . '</td>';
				echo '<td>' . $details_commande['quantite'] . '</td>';
				echo '<td>' . $details_commande['prix'] . '</td>';
			echo '</tr>';
		}
		echo '</table>';
	}
	

}
}
$content = ob_get_clean();
require "src/view/template.php";
?>
