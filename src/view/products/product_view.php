<?php
if (!isset($_SESSION)) {
    header('location:../../../index.php');
}
$title = "mvc-Store: show products";
ob_start();
// $products['id'];
// var_dump($products['name']);
// die();
?>

<div class="container">
    <h1>Liste des produits</h1>
    <table class="table table-primary table-striped">
        <thead>
            <tr>
                <th scope="row">Id Produit</th>
                <th scope="row">Nom Produit</th>
                <th scope="row">Id Catégorie</th>
                <th scope="row">Stock</th>
                <th scope="row">Prix Unitaire</th>
                <th scope="row">action</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($products as $key => $value) {
                if ($value->getQuantity() <= 0) {
                    $quantity = '<button class="btn btn-danger"><strong>Rupture de stock</strong></button>';
                }else{
                    $quantity=$value->getQuantity();
                }

                # code...
                echo "<tbody>
            <tr>
            <td>" .
                    $value->getId_prod()
                    .
                    "</td>
            <td>" .
                    $value->getName()
                    .
                    "</td>
            <td>" .
                    $value->getNameCat() .
                    "</td>
            <td>" .
                    $quantity .                    "</td>
            <td>" .
                    $value->getUnit_price()
                    . '€' .
                    "</td>
            
            <td><a class='btn btn-warning' href='index.php?action=mProduct&id={$value->getId_prod()}'>modifier</a>
            <a class='btn btn-danger' href='index.php?action=dProduct&id={$value->getId_prod()}'  OnClick='return(confirm(\"En êtes vous certain ?\"));'>supprimer</a></td>
            </tr>
            </tbody>";
            } ?>
        </tbody>
    </table>
    <a href="index.php?action=cProduct" class="btn btn-primary">Créer un nouveau produit</a>
</div>
<?php
$content = ob_get_clean();
require "src/view/template.php";
?>