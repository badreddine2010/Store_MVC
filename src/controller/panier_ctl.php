<?php
require_once 'src/model/product.php';


function ajoutPanier()
{

    $product = getProductById(intval($_GET['id']));

    ajouterArticle($product->getName(), $q = 1, $product->getUnit_price(), $product->getId_prod());

    // require 'src/view/panier/panierView.php';
    showAllProductsCostumers();
}

function panier()
{


    require 'src/view/panier/panierView.php';
}


function suppression()
{
    supprimerArticle($_GET['l']);
    require 'src/view/panier/panierView.php';
}
function diminuer()
{

    modifierArticle($_GET['l'], intval($_GET['q']));

    require 'src/view/panier/panierView.php';
}
function augmenter()
{
    $id = htmlspecialchars($_GET['id']);
    $q = htmlspecialchars($_GET['q']);
    $l = htmlspecialchars($_GET['l']);
    $qte = getProductById($id);
    $cat = $qte->getQuantity();

    if ($cat > intval($_GET['q'])) {

        modifierQteArticle($l, intval($_GET['q']));
    }

    require 'src/view/panier/panierView.php';
}
function viderPanier()
{

    unset($_SESSION['panier']);


    require 'src/view/panier/panierView.php';
}
function creationDuPanier()
{
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
        $_SESSION['panier']['titre'] = array();
        $_SESSION['panier']['id_produit'] = array();
        $_SESSION['panier']['quantite'] = array();
        $_SESSION['panier']['prix'] = array();
        $_SESSION['panier']['photo'] = array();
    }
}

/**
 * Verifie si le panier existe, le crée sinon
 * @return booleen
 */
function creationPanier()
{

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
        $_SESSION['panier']['libelleProduit'] = array();
        $_SESSION['panier']['qteProduit'] = array();
        $_SESSION['panier']['id_produit'] = array();
        $_SESSION['panier']['prixProduit'] = array();
        $_SESSION['panier']['verrou'] = false;
    }
    return true;
}


/**
 * Ajoute un article dans le panier
 * @param string $libelleProduit
 * @param int $qteProduit
 * @param float $prixProduit
 * @return void
 */
function ajouterArticle($libelleProduit, $qteProduit, $prixProduit, $id)
{

    //Si le panier existe
    if (creationPanier() && !isVerrouille()) {
        //Si le produit existe déjà on ajoute seulement la quantité
        $positionProduit = array_search($libelleProduit,  $_SESSION['panier']['libelleProduit']);

        if ($positionProduit !== false) {
            $_SESSION['panier']['qteProduit'][$positionProduit] += $qteProduit;
        } else {
            //Sinon on ajoute le produit
            array_push($_SESSION['panier']['libelleProduit'], $libelleProduit);
            array_push($_SESSION['panier']['qteProduit'], $qteProduit);
            array_push($_SESSION['panier']['id_produit'], $id);
            array_push($_SESSION['panier']['prixProduit'], $prixProduit);
        }
    } else
        echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}



/**
 * Modifie la quantité d'un article
 * @param $libelleProduit
 * @param $qteProduit
 * @return void
 */
function modifierQTeArticle($libelleProduit, $qteProduit)
{
    $qteProduit += 1;

    //Si le panier existe
    if (creationPanier() && !isVerrouille()) {
        //Si la quantité est positive on modifie sinon on supprime l'article
        if ($qteProduit > 0) {
            //Recharche du produit dans le panier
            $positionProduit = array_search($libelleProduit,  $_SESSION['panier']['libelleProduit']);

            if ($positionProduit !== false) {
                $_SESSION['panier']['qteProduit'][$positionProduit] = $qteProduit;
            }
        } else
            supprimerArticle($libelleProduit);
    } else
        echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}
function modifierArticle($libelleProduit, $qteProduit)
{
    $qteProduit -= 1;
    //Si le panier existe
    if (creationPanier() && !isVerrouille()) {
        //Si la quantité est positive on modifie sinon on supprime l'article
        if ($qteProduit > 0) {
            //Recharche du produit dans le panier
            $positionProduit = array_search($libelleProduit,  $_SESSION['panier']['libelleProduit']);

            if ($positionProduit !== false) {
                $_SESSION['panier']['qteProduit'][$positionProduit] = $qteProduit;
            }
        } else
            supprimerArticle($libelleProduit);
    } else
        echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

/**
 * Supprime un article du panier
 * @param $libelleProduit
 * @return unknown_type
 */
function supprimerArticle($libelleProduit)
{
    //Si le panier existe
    if (creationPanier() && !isVerrouille()) {
        //Nous allons passer par un panier temporaire
        $tmp = array();
        $tmp['libelleProduit'] = array();
        $tmp['qteProduit'] = array();
        $tmp['prixProduit'] = array();
        $tmp['verrou'] = $_SESSION['panier']['verrou'];

        for ($i = 0; $i < count($_SESSION['panier']['libelleProduit']); $i++) {
            if ($_SESSION['panier']['libelleProduit'][$i] !== $libelleProduit) {
                array_push($tmp['libelleProduit'], $_SESSION['panier']['libelleProduit'][$i]);
                array_push($tmp['qteProduit'], $_SESSION['panier']['qteProduit'][$i]);
                array_push($tmp['prixProduit'], $_SESSION['panier']['prixProduit'][$i]);
            }
        }
        //On remplace le panier en session par notre panier temporaire à jour
        $_SESSION['panier'] =  $tmp;
        //On efface notre panier temporaire
        unset($tmp);
    } else
        echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}


/**
 * Montant total du panier
 * @return int
 */
function MontantGlobal()
{
    $total = 0;
    for ($i = 0; $i < count($_SESSION['panier']['libelleProduit']); $i++) {
        $total += $_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i];
    }
    return number_format(round($total, 2), 2, '.', '');
}


/**
 * Fonction de suppression du panier
 * @return void
 */
function supprimePanier()
{
    unset($_SESSION['panier']);
}

/**
 * Permet de savoir si le panier est verrouillé
 * @return booleen
 */
function isVerrouille()
{
    if (isset($_SESSION['panier']) && $_SESSION['panier']['verrou'])
        return true;
    else
        return false;
}

/**
 * Compte le nombre d'articles différents dans le panier
 * @return int
 */
function compterArticles()
{
    if (isset($_SESSION['panier']))
        return count($_SESSION['panier']['libelleProduit']);
    else
        return 0;
}
//  function montantTotal()
// {
//    $total=0;
   
//       $total = $_SESSION['panier']['qteProduit'] * $_SESSION['panier']['prixProduit'];
   
//    return round($total,2);
// } 
