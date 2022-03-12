<?php

$title = "mvc-Store: show products";
ob_start();
// $products['id'];
// var_dump($products);
// die();
?>

<div class="container">
    <h1>Liste des produits</h1>
    <table class="table table-primary table-striped">
        <thead>
            <tr>
                <th scope="row">Produit</th>
                <th scope="row">Catégorie</th>
                <th scope="row">Prix Unitaire</th>
                <th scope="row">action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $key => $value) {

                if ($value['quantity'] <= 0) {
                    $buttonText = 'Rupture de sctock';
                    $link = "";
                    $class ="class = 'btn btn-danger'";
                } else {
                    $buttonText = 'Ajouter panier';
                    $link = "index.php?action=ajoutPanier&id={$value['id_prod']}";
                    $class ="class = 'btn btn-success'";

                }

                # code...
                echo "<tbody>
            <tr>
            <td>" .
                    $value['name_prod']
                    .
                    "</td>
            <td>" .
                    $value['name_cat']
                    .
                    "</td>
            
            <td>" .
                    $value['unit_price'] . '€' .
                    "</td>
            
            <td><a $class href=$link>$buttonText</a>
            
            </tr>
            </tbody>";
            } ?>
        </tbody>
    </table>
</div>
<?php
$content = ob_get_clean();
require "src/view/template.php";
?>