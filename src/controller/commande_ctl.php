<?php
require "src/model/commande.php";

function validerCommande(){
 
  //Récupérer le produit du panier
   for($i=0 ;$i < count($_SESSION['panier']['id_produit']) ; $i++) 
   {
     $sql = ("SELECT * FROM products WHERE id_prod=" . $_SESSION['panier']['id_produit'][$i]."");
     $bdd = dbConnect();
     $req = $bdd->query($sql);
     $req->setFetchMode(PDO::FETCH_ASSOC);
     $produit = $req->fetch();
     if($produit['quantity'] < $_SESSION['panier']['qteProduit'][$i])
     {
       echo '<div class="alert alert-warning">Stock Restant:<strong> ' . $produit['quantity'] . '</strong></div>';
       echo '<div class="alert alert-warning">Quantité demandée:<strong> ' . $_SESSION['panier']['qteProduit'][$i] . '</strong></div>';
       if($produit['quantity'] > 0)
       {
         echo '<div class="alert alert-warning">la quantité du produit <strong>' .strtoupper( $_SESSION['panier']['libelleProduit'][$i] ). '</strong> a été réduite car notre stock était insuffisant, veuillez vérifier vos achats.</div>';
         $_SESSION['panier']['qteProduit'][$i] = $produit['quantity'];
       }
       else
       {
         echo '<div class="alert alert-warning">Votre commande a été annulée, vous ne serez pas débités car nous sommes en rupture de stock, veuillez vérifier vos achats.</div>';
         retirerproduitDuPanier($_SESSION['panier']['id_produit'][$i]);
         $i--;
       }
       $erreur = true;
     }else{

      //Mise à jour de la quantité dans la bdd
       $quantity = $produit['quantity'] - $_SESSION['panier']['qteProduit'][$i];
        
       $sql1 = "update products set quantity= $quantity where id_prod=" . $_SESSION['panier']['id_produit'][$i]."";
       $req1 = $bdd->prepare($sql1);
       $req1->execute();
     }

   }
   if(!isset($erreur))
   {
     //Insérer la commande dans la bdd
    $reference = rand(1000000000,9999999999);
     $sql = ("INSERT INTO commande (id_user, montant, date_enregistrement,ref_commande) VALUES (" . $_SESSION['id'] . "," . MontantGlobal() . ", NOW(), $reference)");
     $bdd = dbConnect();
     $req = $bdd->exec($sql);
    //  $req->execute();
     $id_commande = $bdd->lastInsertId();
 
     for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
     {
       //Insérer les détails de la commande dans la bdd
       $montantTotal = htmlspecialchars($_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i]);
       $sql = ("INSERT INTO details_commande (id_commande, id_produit,designation, quantite, prix) VALUES ($id_commande, " . $_SESSION['panier']['id_produit'][$i] . ",'". $_SESSION['panier']['libelleProduit'][$i] . "'," . $_SESSION['panier']['qteProduit'][$i] . "," .$montantTotal.") ");
       $bdd = dbConnect();
       $req = $bdd->exec($sql);
      //  $req->execute();
     }
 
     //Vider le panier
     unset($_SESSION['panier']);
     //mail($_SESSION['membre']['email'], "confirmation de la commande", "Merci votre numéro de suivi est le $id_commande", "From:vendeur@dp_site.com");
     echo "<div class='alert alert-success'>Merci pour votre commande. Votre <strong>Numéro</strong> de suivi est le:<strong><span>$reference</span></strong></div>";

 }
        

  require 'src/view/commande/commande_view.php';
}

function detailsCommande(){

  require 'src/view/commande/commande_view.php';


}
function showCommandes(){
  require 'src/view/commande/commande_view.php';


}

function vCommande(){

  $ret = updateCommande($_GET['id']);
  require 'src/view/commande/commande_view.php';

}

function dCommande(){

  $ret = deleteCommande($_GET['id']);
  require 'src/view/commande/commande_view.php';

}



