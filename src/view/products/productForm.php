<?php
if (!isset($_SESSION)) {
    header('location:../../../index.php');
    }
$title = "My Store MVC: Creation/Modification Product";
ob_start();

    
if (!isset($product)) {
    $link = "index.php?action=nProduct";
    $name = "";
    $category_id = "";
    $categories=getAllCategories();
    // var_dump($categories);
    // die;
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
<div class="container">
    <form action=<?= $link ?> method="post">

        <div class="form-group mb-20">
            <br>
            <label for="name">Nom Produit</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="" value="<?= $name ?>">
        </div>
        <div class="form-group mb-20">
            <!-- <label for="category_id">Id Catégorie</label>
            <input type="text" class="form-control" id="category_id" name="category_id" placeholder="" value="<?= $category_id ?>">
            <label for="taille">Catégorie</label><br /> -->
		<select class="form-select" required name="category">
            <option value=""><--------------SELECTIONNER UNE CATEGORIE-----------></option>
            <?php
           
            foreach($categories as $cat){

                echo '<option value="'.$cat->getId().'">'.$cat->getNom().'</option>';
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