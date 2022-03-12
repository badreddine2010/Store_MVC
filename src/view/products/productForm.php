<?php
//Vérifier la connexion de l'Admin
if(!isset($_SESSION['user']) && $_SESSION['statut']!=1){
    header('location:../../../index.php');
}
//titre de la page
$titre = "My Store MVC: Creation Product";

ob_start();

//Vérifier l'action de l'Admin entre Création ou Modification   
if (!isset($product)) {
    $link = "index.php?action=nProduct";
    $name = "";
    $category_id = "";
    $categories=getAllCategories();
    $quantity = "";
    $unit_price = "";

    $btnText = "Créer le produit";
} else {
    $link = "index.php?action=nProduct&id=" . $product->getId_prod();
    $name = $product->getName();
    $category_id = $product->getCategory_id();
    $categories=getAllCategories();
    $quantity = $product->getQuantity();
    $unit_price = $product->getUnit_price();

    $btnText = "Modifier le produit";
}
?>
<!-- Afficher le formulaire de création ou de modification -->
<div class="container">
    <form action=<?= $link ?> method="post">

        <div class="form-group mb-20">
            <label for="name">Nom Produit</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="" value="<?= $name ?>">
        </div>
        <div class="form-group mb-20">
            
		<select class="form-select" required name="category">
            <?php
           echo '<option class="option" value="" selected><strong><---------SELECTIONNER UNE CATEGORIE---------></strong<</option>';
           
            foreach($categories as $cat){

                echo '<option class="form-control" value="'.$cat->getId().'">'.$cat->getNom().'</option>';
            }
            ?>
		</select>

        </div>
        <div class="form-group mb-20">
            <label for="quantity">Quantité</label>
            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="" value="<?= $quantity ?>">
        </div>
        <div class="form-group mb-20">
            <label for="unit_price">Prix Unitaire</label>
            <input type="text" class="form-control" id="unit_price" name="unit_price" placeholder="" value="<?= $unit_price ?>">
        </div>

        <button type="submit" class="btn btn-primary"><?= $btnText ?></button>

    </form>
</div>
<?php
$content = ob_get_clean();
require "src/view/template.php";
?>