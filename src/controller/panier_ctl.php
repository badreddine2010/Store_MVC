<?php
require_once 'src/model/panier.php';
require_once 'src/model/product.php';


function ajoutPanier(){

        $product = getProductById(intval($_GET['id']));

        ajouterArticle($product->getName(),$q=1,$product->getUnit_price(),$product->getId_prod());

    require 'src/view/panier/panierView.php';


//   header("location:  src/view/panier/panierView.php?action=ajout&l={$product->getName()}&q=1&p={$product->getUnit_price()}'") ;

    // require 'src/view/panier/panier_view.php';
}
function panier(){


    require 'src/view/panier/panierView.php';
}

// function ajoutauPanier(){

//     // var_dump($_GET['id']);
//     $product = getProductById(intval($_GET['id']));
    
//        creationDuPanier();
//            $_SESSION['panier']['name'][]= $product->getName();
//            $_SESSION['panier']['id_produit'][]= $_GET['id'];
//            $_SESSION['panier']['quantite'][]= $quantite = 1;
//            $_SESSION['panier']['prix'][]= $product->getUnit_price();

            // $_SESSION['panier']['name']= $product->getName();
            // $_SESSION['panier']['id_prod']= $_GET['id'];
            // $_SESSION['panier']['quantity']= $quantite = 1;
            // $_SESSION['panier']['unit_price']= $product->getUnit_price();
    

    // require 'src/view/panier/panier_view.php';
// }
function suppression(){
    supprimerArticle($_GET['l']);
    require 'src/view/panier/panierView.php';


}
function diminuer(){

    modifierArticle($_GET['l'],intval($_GET['q']));

    require 'src/view/panier/panierView.php';

}
function augmenter(){

    modifierQteArticle($_GET['l'],intval($_GET['q']));

    require 'src/view/panier/panierView.php';

}
function viderPanier(){

    unset($_SESSION['panier']);


    require 'src/view/panier/panierView.php';
}
function creationDuPanier()
{
   if (!isset($_SESSION['panier']))
   {
      $_SESSION['panier']=array();
      $_SESSION['panier']['titre'] = array();
      $_SESSION['panier']['id_produit'] = array();
      $_SESSION['panier']['quantite'] = array();
      $_SESSION['panier']['prix'] = array();
	  $_SESSION['panier']['photo'] = array();
   }
}

// function ajouterProduitDansPanier($produit['name'],$_GET['id'],$quantite=1,$produit['unit_price'])
// {
// 	creationDuPanier(); 
//     $product = getProductById(intval($_GET['id']));
    
  
//         $_SESSION['panier']['titre'][] = $product->getName();
//         $_SESSION['panier']['id_produit'][] = $id_produit;
//         $_SESSION['panier']['quantite'][] = $quantite;
// 		$_SESSION['panier']['prix'][] = $prix;
// 		$_SESSION['panier']['photo'][] = $photo;
// }