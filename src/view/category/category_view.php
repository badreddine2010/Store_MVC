<?php
if(!isset($_SESSION['user']) && $_SESSION['statut']!=1){
    header('location:../../../index.php');
}
$title = "mvc-Store: show Categories";
ob_start();

?>

<div class="container">
    <h1>Liste des catégories</h1>
    <table class="table table-primary table-striped">
        <thead>
            <tr>
                <th scope="row">id</th>
                <th scope="row">nom</th>
                <th scope="row">action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $key => $value) {
                # code...
                echo "<tbody>
            <tr>
            <td cope='row'>" .
                    $value->getId() .
                    "</td>
            <td>" .
                    $value->getNom() .
                    "</td>
            <td><a class='btn btn-warning' href='index.php?action=mCategory&id={$value->getId()}'>modifier</a>
            <a class='btn btn-danger' href='index.php?action=dCategory&id={$value->getId()}' OnClick='return(confirm(\"En êtes vous certain ?\"));'>supprimer</a></td>
            </tr>
            </tbody>";
            } ?>
        </tbody>
    </table>
    <a href="index.php?action=cCategory" class="btn btn-primary">Créer une nouvelle catégorie</a>
</div>
<?php
$content = ob_get_clean();
require "src/view/template.php";
?>