<?php
//Vérification de l'existence de l'Admin
if(!isset($_SESSION['user']) && $_SESSION['statut']!=1){
    header('location:../../../index.php');
}
ob_start();
?>
<!-- Formulaire de création ou de modification des catégories -->
<div class="container">
    <form action="<?= $link ?>" method="post">
        <div class="mb-3">
            <br>
            <label for="nomCategory" class="form-label">Nom de la catégorie</label>
            <input type="text" class="form-control" id="nomCategory" name="nomCategory" value="<?= $nom ?>">
        </div>
        <button type="submit" class="btn btn-primary"><?= $btnText ?></button>
    </form>
</div>
<?php
$content = ob_get_clean();
require "src/view/template.php";
?>