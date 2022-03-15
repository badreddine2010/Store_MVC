<?php
if (!isset($_SESSION)) {
    header('location:../../../index.php');
    }
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
    
                    # code...
                    echo "<tbody><tr><td>" .$value['name_prod']."</td>";
                    echo "<td>" .$value['name_cat']."</td>";
                    echo "<td>" .$value['unit_price']."</td>";
                
                        if($value['quantity'] > 0){

                          echo  "<td><a class='btn btn-success' href='index.php?action=ajoutPanier&id={$value['id_prod']}'>Ajouter au panier</a>";
                        }else{
                        
                           echo "<td><div class='btn btn-danger'>Produit indisponible</div>";
                        
                        }
                        ?>
                </tr>
                </tbody>
                
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
$content = ob_get_clean();
require "src/view/template.php";
?>