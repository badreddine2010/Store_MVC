<?php
if (!isset($_SESSION)) {
    header('location:../../../index.php');
    }
ob_start();
?>
<div class="container">
    <form action="<?= $link ?>" method="post">
        <div class="mb-3">
            <br>
            <label for="nomCategory" class="form-label">Nom de la catégorie</label>
            <input type="text" class="form-control" id="nomCategory" name="nomCategory" value="<?= $nom ?>">
        </div>
        <div class="mb-3">
            <input type="submit" class="btn btn-primary" value="<?= $btnText ?>"/>
        </div>
    </form>
</div>
<?php
$content = ob_get_clean();
require "src/view/template.php";
?>