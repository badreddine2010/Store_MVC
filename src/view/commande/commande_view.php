
<?php
// if (!isset($_SESSION)) {

// 	session_start();
// }
error_reporting(0);
if (!isset($_SESSION)) {
	header('location:../../../index.php');
	}

$title = "mvc-Store: show Commandes";
ob_start();
if (isset($_SESSION['user']) && $_SESSION['statut']==1) {

	if(isset($_GET['suivi']))
	{	
		echo '<table table table-bordered>';
		echo '<tr>';
		$sql = ("select * from details_commande inner join commande on details_commande.id_commande=commande.id_commande where details_commande.id_commande=$_GET[suivi]");
		$bdd = dbConnect();
        $req = $bdd->query($sql);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $information_sur_une_commande = $req->fetchAll();
		
		echo '<h1> Voici le détails de la commande N°:<span>' . $information_sur_une_commande[0]['ref_commande'] . '</span></h1>';
		echo "<table class='table table-primary table-striped'> <tr>";
		{    
			
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
				echo '<td>' . number_format(round($details_commande['prix'],2), 2, '.', ''). '€'.'</td>';

			echo '</tr>';
		}
		echo '</table>';
	}

//-------------------------------------------------- Affichage ---------------------------------------------------------//

	echo '<h1> Voici toutes les commandes passées sur notre site </h1>';
	echo '<table border="1"><tr>';
	
	$sql = ("select * from commande left join user  on  user.id = id_user order by date_enregistrement desc");
	$bdd = dbConnect();
	$req = $bdd->query($sql);
	$req->execute();
	$req->setFetchMode(PDO::FETCH_ASSOC);
	$information_sur_les_commandes = $req->fetchAll();
	echo "<strong>Nombre de commande(s) :<span>" .$req->rowCount()."</span></strong>";
	echo "<table class='table table-primary table-striped'> <tr>";
	{    
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
		echo '<td><button class="btn btn-primary"><a href="?action=detailsCommande&suivi=' . $commande['id_commande'] . '">' . $commande['ref_commande'] . '</a></button></td>';	
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
	echo '<div class="alert alert-warning">';
	echo '<strong>Calcul du montant total des revenus</strong>:  <br />';
		print "<strong>le chiffre d'affaires de la sociéte est de : $chiffre_affaire €</strong>"; 
	echo '</div>';

	echo '<br />';
	echo '<br />';
	echo '<br />';
	echo '<br />';
	
}
else{             
	
	if (isset($_SESSION['user']) && $_SESSION['statut']==2) {

		if(isset($_GET['suivi'])){	
			echo '<tr>';
			$sql = ("select * from details_commande inner join commande on details_commande.id_commande=commande.id_commande where details_commande.id_commande=$_GET[suivi]");
			$bdd = dbConnect();
			$req = $bdd->query($sql);
			$req->execute();
			$req->setFetchMode(PDO::FETCH_ASSOC);
			$information_sur_une_commandes = $req->fetchAll();
			echo '<h1> Voici le détails de la commande N°:<span>' . $information_sur_une_commandes[0]['ref_commande'] . '</span></h1>';
			echo "<table class='table table-primary teble-striped'> <tr>";
			
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
			
			foreach($information_sur_une_commandes as $key=>$details_commande)
		
			{
				echo '<tr>';
					echo '<td>' . $details_commande['designation'] . '</td>';
					echo '<td>' . $details_commande['quantite'] . '</td>';
					echo '<td>' . number_format(round($details_commande['prix'],2), 2, '.', '') . '€'. '</td>';
				echo '</tr>';
			}
			echo '</table>';
		}

//-------------------------------------------------- Affichage ---------------------------------------------------------//
$id_membre = $_SESSION['id'];

	echo '<h1> Voici vos commandes passées sur notre site </h1>';
	
	$sql = ("select * from commande where id_user = '$id_membre' order by date_enregistrement desc");
	$bdd = dbConnect();
        $req = $bdd->query($sql);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $information_sur_les_commandes = $req->fetchAll();
	
	echo "<strong>Nombre de commande(s) :<span> " . $req->rowCount()."</span></strong>";

	echo "<table class='table table-primary table-striped'> <tr>";
	{    
		?>
		<thead>
				<tr>
					<th>Référence</th>
					<th>Montant</th>
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
		echo '<td><button class="btn btn-primary"><a href="?action=detailsCommande&suivi=' . $commande['id_commande'] . '">' . $commande['ref_commande'] . '</a></button></td>';	
		echo '<td>' . number_format(round($commande['montant'] ,2), 2, '.', ''). '€'.'</td>';
		echo '<td>' .strftime('%d-%m-%Y',strtotime($commande['date_enregistrement'])).'</td>';
		echo '<td>' . $commande['etat'] . '</td>';
		echo '<td><button class="btn btn-primary"><a class="" target="_blank" href="?action=facture&id_commande='.$commande["id_commande"].'">Facture au format pdf</a></button></td>';
		echo '</tr>	';
		echo '</div>';
	}
	echo '</table><br />';
	
	
	echo '<br />';
	echo '<br />';
	echo '<br />';
	echo '<br />';
	
	

}
}
$content = ob_get_clean();
require "src/view/template.php";
?>
