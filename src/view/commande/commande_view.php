
<?php
//Vérifier l'existence du User
if(!isset($_SESSION['user'])){
    header('location:../../../index.php');
}
//titre de la page
$title = "mvc-Store: show Commandes";

ob_start();

//Admin connecté
if (isset($_SESSION['user']) && $_SESSION['statut']==1) {

//-------------------------------------Affichage des commandes Admin---------------------------------------------------------//

	echo '<h2> Voici les commandes passées sur le site </h2>';
	echo '<table border="1"><tr>';
	
	$sql = ("select * from commande left join user  on  user.id = id_user");
	$bdd = dbConnect();
	$req = $bdd->query($sql);
	$req->execute();
	$req->setFetchMode(PDO::FETCH_ASSOC);
	$information_sur_les_commandes = $req->fetchAll();
	echo "<strong>Nombre de commande(s) : " .$req->rowCount()."</strong>";
	echo "<table class='table table-primary'> <tr>";
	{    
		?>
		<thead>
				<tr>
					<th>Référence</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Montant facture</th>
					<th>Date d'achat</th>
					<th>Etat</tthh>
					<th>Adresse mail</th>
					<th>Action</th>
					
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
		echo '<td><a href="?action=detailsCommande&suivi=' . $commande['id_commande'] . '">' . $commande['ref_commande'] . '</a></td>';
		echo '<td>' . $commande['nom'] . '</td>';
		echo '<td>' . $commande['prenom'] . '</td>';
		echo '<td>' . number_format(round($commande['montant'],2), 2, '.', '') . '</td>';
		echo '<td>' .strftime('%d-%m-%Y',strtotime($commande['date_enregistrement'])).'</td>';
		echo '<td>' . $commande['etat'] . '</td>';	
		echo '<td>' . $commande['email'] . '</td>';
		echo "<td><a class='btn btn-success' href='index.php?action=vCommande&id={$commande['id_commande']}'>Valider</a>
		<a class='btn btn-danger' href='index.php?action=dCommande&id={$commande['id_commande']}'  OnClick='return(confirm(\"En êtes vous certain ?\"));'>supprimer</a></td>
</td>";
		echo '</tr>	';
		echo '</div>';
	}
	echo '</table><br />';

	//Afficher le chiffre d'affaires
	echo '<div class="alert alert-success">';
	echo '<strong>Calcul du montant total des revenus</strong>:  <br />';
		print "<strong>le chiffre d'affaires de la sociéte est de : $chiffre_affaire €</strong>"; 
	echo '</div>';

	echo '<br />';
	echo '<br />';
	echo '<br />';
	echo '<br />';
	if(isset($_GET['suivi']))
	{	
		$sql = ("select * from details_commande INNER JOIN commande ON commande.id_commande=details_commande.id_commande where details_commande.id_commande=$_GET[suivi]");
		$bdd = dbConnect();
        $req = $bdd->query($sql);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $information_sur_une_commande = $req->fetchAll();
		echo '<h2> Voici les détails pour la commande numéro :<span>' . $information_sur_une_commande[0]['ref_commande'] . '</span></h2>';
		
		//Afficher le détails des commandes Admin
		echo "<table class='table table-primary'> <tr>";
		{    
			?>
			<thead>
					<tr>
						<th>Désignation</th>
						<th>Quantité</th>
						<th>Montant</th>
						

					</tr>
				</thead> 
				<?php
		}
		echo "</tr>";
		
		foreach($information_sur_une_commande as $key=>$details_commande)

		{
			
			echo '<tr>';
				echo '<td>' . $details_commande['designation'] . '</td>';
				echo '<td>' . $details_commande['quantite'] . '</td>';
				echo '<td>' . number_format(round($details_commande['prix'],2), 2, '.', ''). '€'.'</td>';

			echo '</tr>';
		}
		echo '</table>';
	}
}
else{             
	
	if (isset($_SESSION['user']) && $_SESSION['statut']==2) {

//----------------------------------------Affichage des commandes User---------------------------------------------------------//
$id_membre = $_SESSION['id'];

	echo '<h2> Voici les commandes passées sur le site </h2>';
	
	$sql = ("select * from commande where id_user = '$id_membre'");
	$bdd = dbConnect();
        $req = $bdd->query($sql);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $information_sur_les_commandes = $req->fetchAll();
	
		echo "<strong>Nombre de commande(s) : " .$req->rowCount()."</strong>";

	echo "<table class='table table-primary'> <tr>";
	{    
		?>
		<thead>
				<tr>
					<th>Référence</th>
					<th>Montant facture</th>
					<th>Date d'achat</th>
					<th>Etat</th>
					<th>Facture</th>
				</tr>
			</thead> <?php
	}
	echo "</tr>";
	$chiffre_affaire = 0;
	foreach($information_sur_les_commandes as $key=>$commande){
	
		$chiffre_affaire += $commande['montant'];
		echo '<div>';
		echo '<tr>';
		echo '<td><a href="?action=detailsCommande&suivi=' . $commande['id_commande'] . '">' . $commande['ref_commande'] . '</a></td>';	
		echo '<td>' . number_format(round($commande['montant'] ,2), 2, '.', ''). '€'.'</td>';
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
		$sql =("select * from details_commande INNER JOIN commande ON commande.id_commande=details_commande.id_commande where details_commande.id_commande=$_GET[suivi]");
		$bdd = dbConnect();
        $req = $bdd->query($sql);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $information_sur_une_commande = $req->fetchAll();
		echo '<h2> Voici les détails pour la commande numéro :<span>' . $information_sur_une_commande[0]['ref_commande'] . '</span></h2>';

		//Afficher les détails d'une commande User
		echo "<table class='table table-primary'> <tr>";
		
			?>
			<thead>
					<tr>
						<th>Désignation</th>
						<th>Quantité</th>
						<th>Montant</th>
					</tr>
				</thead> <?php
		// }
		echo "</tr>";
		
		foreach($information_sur_une_commande as $key=>$details_commande)
	
		{
			echo '<tr>';
				echo '<td>' . $details_commande['designation'] . '</td>';
				echo '<td>' . $details_commande['quantite'] . '</td>';
				echo '<td>' . number_format(round($details_commande['prix'],2), 2, '.', '') . '€'. '</td>';
			echo '</tr>';
		}
		echo '</table>';
	}
	

}
}
$content = ob_get_clean();
require "src/view/template.php";
?>
