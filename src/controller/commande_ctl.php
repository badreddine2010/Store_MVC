<?php
require "src/model/commande.php";

function validerCommande(){
valideCommande();
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



