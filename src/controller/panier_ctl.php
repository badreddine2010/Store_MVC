<?php
require_once 'src/model/panier.php';
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

    modifierQteArticle($_GET['l'], intval($_GET['q']));

    require 'src/view/panier/panierView.php';
}
function viderPanier()
{

    unset($_SESSION['panier']);


    require 'src/view/panier/panierView.php';
}
// function creationDuPanier()
// {
//     if (!isset($_SESSION['panier'])) {
//         $_SESSION['panier'] = array();
//         $_SESSION['panier']['titre'] = array();
//         $_SESSION['panier']['id_produit'] = array();
//         $_SESSION['panier']['quantite'] = array();
//         $_SESSION['panier']['prix'] = array();
//         $_SESSION['panier']['photo'] = array();
//     }
// }
