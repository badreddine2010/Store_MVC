<?php
if (!isset($_SESSION)) {
    session_start();
}
error_reporting(0);



$title = "mvc-Store: show panier";



ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

<head>
    <title>Mon panier</title>
</head>

<body>


    <div class="container">
        <h1>Mon panier</h1>
        <table class="table table-dark table-primary table-striped">
            <thead>

                <tr>
                    <th scope="row">Libellé</th>
                    <th scope="row">Quantité</th>
                    <th scope="row">Prix Unitaire</th>
                    <th scope="row">Prix Total</th>
                    <th scope="row">Action</th>
                </tr>
            </thead>
            <tbody>


                <?php
                if (creationPanier()) {
                    $nbArticles = count($_SESSION['panier']['libelleProduit']);
                    if ($nbArticles <= 0)
                        echo "<tr ><th colspan='5'>Votre panier est vide </ th></tr>";
                    else {
                        for ($i = 0; $i < $nbArticles; $i++) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($_SESSION['panier']['libelleProduit'][$i]) . "</ td>";
                            echo "<td><a href='?action=diminuer&q={$_SESSION['panier']['qteProduit'][$i]}&l={$_SESSION['panier']['libelleProduit'][$i]}'><button class='btn btn-primary'>-</button></a>
                                    <input id='input' type=\"text\" size=\"1\" name=\"q[]\" value=\"" . htmlspecialchars($_SESSION['panier']['qteProduit'][$i]) . "\"/>
                                    <input id='input' type=\"hidden\" size=\"1\" name=\"id[]\" value=\"" . htmlspecialchars($_SESSION['panier']['id_produit'][$i]) . "\"/>
                                    <a  href='?action=augmenter&q={$_SESSION['panier']['qteProduit'][$i]}&l={$_SESSION['panier']['libelleProduit'][$i]}'><button id='le_plus' class='btn btn-primary'>+</button></a></td>";
                            echo "<td>" . htmlspecialchars($_SESSION['panier']['prixProduit'][$i]) . '€' . "</td>";
                            echo "<td>" . number_format(round(htmlspecialchars($_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i]),2), 2, '.', '') . '€' . "</td>";
                            echo "<td><a href=\"" . htmlspecialchars("?action=suppression&l=" . rawurlencode($_SESSION['panier']['libelleProduit'][$i])) . "\"><button class='btn btn-danger'>X</button></a></td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "<tfoot>";

                        echo "<tr><th colspan=\"3\"> </th>";
                        echo "<th colspan=\"3\">";
                        echo "Total : " . MontantGlobal() . '€';
                        echo "</th></tr>";

                        echo "<tr><th colspan=\"3\"> </th>";
                        echo "<th colspan=\"3\">";
                        echo "<a href='?action=viderPanier'><button class='btn btn-warning'>Vider le panier</button></a>";
                        if (isset($_SESSION['user'])){
                            // echo "<a href='?action=validerCommande'><button class='btn btn-success'>Valider votre commande</button></a>";
                            echo "<a href='?action=paiement'><button class='btn btn-success'>Valider votre commande</button></a>";

                        }else{
                            echo "<a href='?action=login'><button class='btn btn-primary'>Connectez-vous</button></a>";
                        }
                        echo "</th></tr>";
                        echo "</tfoot>";

                    }
                }
                ?>

        </table>
    </div>
    <?php
    $content = ob_get_clean();
    require_once 'src/view/template.php';
    ?>
</body>

</html>