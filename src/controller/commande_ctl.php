<?php
require "src/model/commande.php";

function validerCommande()
{

  validePanier();

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
//Mise à jour du stock
function vCommande()
{
  $id = htmlspecialchars($_GET['id']);
  $ret = updateCommande($id);
  require 'src/view/commande/commande_view.php';
}

function dCommande()
{
  $id = htmlspecialchars($_GET['id']);
  $ret = deleteCommande($id);
  require 'src/view/commande/commande_view.php';
}
