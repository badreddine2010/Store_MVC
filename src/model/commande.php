<?php
class Commande{
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

function validePanier(){
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
}

?>