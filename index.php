<?php
session_start();
define("ACCESS_INDEX", true);

// require 'vendor/autoload.php';
// use AppStore\Product;
require "src/model/dbaccess.php";
require "src/controller/product_ctl.php";
require "src/controller/category_ctl.php";
require "src/controller/user_ctl.php";
require "src/controller/panier_ctl.php";
require "src/controller/commande_ctl.php";
require "src/controller/facture_ctl.php";
require "src/controller/paiement_ctl.php";

function home()
{

    $title = "Store MVC: Accueil";
    ob_start();
?>
    <!-- <img src="images/shop-gb033679a8_1280.jpg" alt="image_de_boutique">
    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="10000">
                <img src="images/beverages-g55d553b34_1280.jpg" class="d-block w-70 " width="1290" height="600" alt="...">
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="images/market-g6f3903d65_1280.jpg" class="d-block w-70" width="1290" height="600" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/tangerines-g0a650ccdc_1280.jpg" class="d-block w-70" width="1290" height="600" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div> -->

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <div class="card">
                <img src="images/tomate.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Tomate</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="images/Orange.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Orange</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="images/pomme de terre.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Pomme de terre</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="images/eau.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Eau</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="images/banane.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Banane</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="images/soda.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">soda</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
                </div>
            </div>
        </div>
    </div>
<?php
    $content = ob_get_clean();
    require "src/view/template.php";
}
?>

<?php
// ROUTER
// ******
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'home':
            home();
            break;


            /* Actions pour CATEGORIES */
            /* *********************** */
        case 'showCategories':
            if(isset($_SESSION['user'])){

                showAllCategories();
            }else{
                home();
            }
            // showAllCategories();
            break;

        case 'dCategory':
            if(isset($_SESSION['user'])){

                deleteCategory($_GET['id']);
            }else{
                home();
            }
            // deleteCategory($_GET['id']);
            break;

        case 'cCategory':
        case 'mCategory':
            if(isset($_SESSION['user'])){

                createCategoryForm();
            }else{
                home();
            }
            // createCategoryForm();
            break;


        case 'saveCategory':
            if(isset($_SESSION['user'])){

                createOrUpdateCategory();
            }else{
                home();
            }
            // createOrUpdateCategory();
            break;

            /* Actions pour PRODUCTS */
            /* ********************* */
        case 'showProducts':
            if(isset($_SESSION['user'])){

                showAllProducts();
            }else{
                home();
            }
            // showAllProducts();
            break;

        case 'dProduct':
            if(isset($_SESSION['user'])){

                deleteProduct();
            }else{
                home();
            }
            // deleteProduct();
            break;

        case 'cProduct':
        case 'mProduct':
            if(isset($_SESSION['user'])){

                createProductForm();
            }else{
                home();
            }
            // createProductForm();
            break;

        case 'nProduct':
            if(isset($_SESSION['user'])){

                createOrChangeProduct();
            }else{
                home();
            }
            // createOrChangeProduct();
            break;

            /* Actions pour users */
            /* ****************** */
        case 'getUser':
            getUser();
            break;
        case 'login':
            login();
            break;
        case 'logout':
            logout();
            break;

            /* Actions pour les clients */
            /* ************************ */
        case 'showProductsCostumers':
            showAllProductsCostumers();
            break;

            /* Actions pour le panier */
            /* ************************ */
        case 'panier':
            panier();
            break;
        case 'ajoutPanier':
            ajoutPanier();
            break;
        case 'viderPanier':
            viderPanier();
            break;
        case 'suppression':
            suppression();
            break;
        case 'diminuer':
            diminuer();
            break;
        case 'augmenter':
            augmenter();
            break;

            /* Actions pour la commande */
            /* ************************ */
        case 'validerCommande':
            if(isset($_SESSION['user'])){

                validerCommande();
            }else{
                home();
            }
            break;
        case 'detailsCommande':
            if(isset($_SESSION['user'])){

                detailsCommande();
            }else{
                home();
            }
            // detailsCommande();
            break;
        case 'showCommandes':
            if(isset($_SESSION['user'])){

                showCommandes();
            }else{
                home();
            }
            // showCommandes();
            break;
        case 'vCommande':
            if(isset($_SESSION['user'])){

                vCommande();
            }else{
                home();
            }
            // vCommande();
            break;
        case 'dCommande':
            if(isset($_SESSION['user'])){

                dCommande();
            }else{
                home();
            }
            // dCommande();
            break;

            /* Actions pour la facture */
            /* ************************ */
        case 'facture':
            if(isset($_SESSION['user'])){

                facture();
            }else{
                home();
            }
            // facture();
            break;
            /* Actions pour le paiement */
            /* ************************ */
        case 'paiement':
            if(isset($_SESSION['user'])){

                paiement();
            }else{
                home();
            }
            // paiement();
            break;

        default:
            header("location: index.php?action=home");
    }
} else {
    header("location: index.php?action=home");
}
?>