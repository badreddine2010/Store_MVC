<?php
class membre{
    private string $montant;
    private float $date_enregistrement;
    private float $etat;
    private int $id_commande;
    private int $id_membre;



    /**
     * Get the value of montant
     */ 
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set the value of montant
     *
     * @return  self
     */ 
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get the value of date_enregistrement
     */ 
    public function getDate_enregistrement()
    {
        return $this->date_enregistrement;
    }

    /**
     * Set the value of date_enregistrement
     *
     * @return  self
     */ 
    public function setDate_enregistrement($date_enregistrement)
    {
        $this->date_enregistrement = $date_enregistrement;

        return $this;
    }

    /**
     * Get the value of etat
     */ 
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set the value of etat
     *
     * @return  self
     */ 
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get the value of id_commande
     */ 
    public function getId_commande()
    {
        return $this->id_commande;
    }

    /**
     * Set the value of id_commande
     *
     * @return  self
     */ 
    public function setId_commande($id_commande)
    {
        $this->id_commande = $id_commande;

        return $this;
    }

    /**
     * Get the value of id_membre
     */ 
    public function getId_membre()
    {
        return $this->id_membre;
    }

    /**
     * Set the value of id_membre
     *
     * @return  self
     */ 
    public function setId_membre($id_membre)
    {
        $this->id_membre = $id_membre;

        return $this;
    }
}
function updateCommande($id) {
    $ret = false;
    
    $sql = "UPDATE commande SET etat = 'envoyé' WHERE id_commande = :id";

    $bdd = dbConnect();
    $req = $bdd->prepare($sql);
    $req->bindValue(':id', $id, PDO::PARAM_INT);

    $ret = $req->execute();

    return $ret;
}

function deleteCommande($id) {
    $ret = false;

    $sql = "DELETE FROM commande";
    $sql .= " WHERE id_commande={$id}";

    try {
        $bdd = dbConnect();
        $req = $bdd->query($sql);
        $ret = $req->execute();
    }
    catch (PDOException $ex) {
        var_dump("Erreur GET CATEGORY: {$ex->getMessage()}");
    }
    finally {
        return $ret;
    }
}

function executeRequete($req)
{
	global $mysqli; 
	$resultat = $mysqli->query($req); 
	if (!$resultat)
	{
		die("Erreur sur la requete sql.<br />Message : " . $mysqli->error . "<br />Code: " . $req);
	}
	return $resultat;
}

function retirerproduitDuPanier($id_produit_a_supprimer)
{
	$position_produit = array_search($id_produit_a_supprimer,  $_SESSION['panier']['id_produit']);
	if ($position_produit !== false)
    {
		array_splice($_SESSION['panier']['titre'], $position_produit, 1);
		array_splice($_SESSION['panier']['id_produit'], $position_produit, 1);
		array_splice($_SESSION['panier']['quantite'], $position_produit, 1);
		array_splice($_SESSION['panier']['prix'], $position_produit, 1);
	}
}

function valideCommande(){
     
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

?>