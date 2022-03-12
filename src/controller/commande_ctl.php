<?php

require "src/model/commande.php";
function validerCommande()
{

  //    if (!isset($_SESSION)) {
  //        session_start();
  //  }
  //  @$valider=$_POST["valider"];
  //  $date = new DateTime();
  for ($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++) {
    $sql = ("SELECT * FROM products WHERE id_prod=" . $_SESSION['panier']['id_produit'][$i] . "");
    $bdd = dbConnect();
    $req = $bdd->query($sql);
    $req->setFetchMode(PDO::FETCH_ASSOC);
    $produit = $req->fetch();
    if ($produit['quantity'] < $_SESSION['panier']['qteProduit'][$i]) {
        echo '<div class="alert alert-warning">Stock Restant: ' . $produit['quantity'] . '</div>';
        echo '<div class="alert alert-warning">Quantité demandée: ' . $_SESSION['panier']['qteProduit'][$i] . '</div>';
        if ($produit['quantity'] > 0) {
            echo '<div class="alert alert-warning">la quantité du produit <strong>' . strtoupper($_SESSION['panier']['libelleProduit'][$i]) . '</strong> a été réduite car notre stock était insuffisant, veuillez vérifier vos achats.</div>';
            $_SESSION['panier']['qteProduit'][$i] = $produit['quantity'];
          } else {
              echo '<div class="alert alert-warning">Votre commande a été annulée, vous ne serez pas débités car nous sommes en rupture de stock, veuillez vérifier vos achats.</div>';
              retirerproduitDuPanier($_SESSION['panier']['id_produit'][$i]);
              $i--;
            }
            $erreur = true;
          } else {
            $idProduit = $_SESSION['panier']['id_produit'][$i];
            $quantity = $produit['quantity']-$_SESSION['panier']['qteProduit'][$i];
            // var_dump($quantity);
            // die;
    $sql1 = "UPDATE products SET quantity=$quantity";
    $sql1 .= " WHERE id_prod=$idProduit";

    $rep = false;
    $bdd = dbConnect();
    $req1 = $bdd->exec($sql1);

    }
    // $erreur = true;

  }
  if (!isset($erreur)) {
  $reference = rand(1, 10000000);

  $sql = ("INSERT INTO commande (id_user, montant, date_enregistrement,ref_commande) VALUES (" . $_SESSION['id'] . "," . MontantGlobal() . ", NOW()," . $reference . ")");
  $bdd = dbConnect();
  $req = $bdd->prepare($sql);
  $req->execute();
  $id_commande = $bdd->lastInsertId();

  for ($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++) {
    $montantTotal = htmlspecialchars($_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i]);
    $sql = ("INSERT INTO details_commande (id_commande, id_produit,designation, quantite, prix) VALUES ($id_commande, " . $_SESSION['panier']['id_produit'][$i] . ",'" . $_SESSION['panier']['libelleProduit'][$i] . "'," . $_SESSION['panier']['qteProduit'][$i] . "," . $montantTotal . ") ");
    $bdd = dbConnect();
    $req = $bdd->exec($sql);
    //  $req->execute();
  }

  unset($_SESSION['panier']);
  //mail($_SESSION['membre']['email'], "confirmation de la commande", "Merci votre numéro de suivi est le $id_commande", "From:vendeur@dp_site.com");
  // echo "<div class='alert alert-success'><strong>Merci pour votre commande. Votre numéro de suivi est le $id_commande</strong></div>";
  echo "<div class='alert alert-success'><strong>Merci pour votre commande</strong></div>";
  // }
  }


  require 'src/view/commande/commande_view.php';
}

function detailsCommande()
{

  require 'src/view/commande/commande_view.php';
}
function showCommandes()
{
  require 'src/view/commande/commande_view.php';
}

function vCommande()
{

  $ret = updateCommande($_GET['id']);
  require 'src/view/commande/commande_view.php';
}

function dCommande()
{

  $ret = deleteCommande($_GET['id']);
  require 'src/view/commande/commande_view.php';
}
