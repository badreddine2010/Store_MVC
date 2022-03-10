<?php
session_start();
require 'vendor/autoload.php';
// use AppStore\Product;
require "src/model/dbaccess.php";
require "src/controller/product_ctl.php";
require "src/controller/category_ctl.php";
require "src/controller/user_ctl.php";
require "src/controller/panier_ctl.php";
require "src/controller/commande_ctl.php";
require "src/controller/facture_ctl.php";

function home()
{

    $title = "Store MVC: Accueil";
    ob_start();
?>
    <!-- <img src="images/shop-gb033679a8_1280.jpg" alt="image_de_boutique"> -->
    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="10000">
                <img src="images/beverages-g55d553b34_1280.jpg" class="d-block w-70 " alt="...">
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="images/market-g6f3903d65_1280.jpg" class="d-block w-70" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/tangerines-g0a650ccdc_1280.jpg" class="d-block w-70" alt="...">
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
            showAllCategories();
            break;

        case 'dCategory':
            deleteCategory($_GET['id']);
            break;

        case 'cCategory':
        case 'mCategory':
            createCategoryForm();
            break;


        case 'saveCategory':
            createOrUpdateCategory();
            break;

            /* Actions pour PRODUCTS */
            /* ********************* */
        case 'showProducts':
            showAllProducts();
            break;

        case 'dProduct':
            deleteProduct();
            break;

        case 'cProduct':
        case 'mProduct':
            createProductForm();
            break;

        case 'nProduct':
            createOrChangeProduct();
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
            validerCommande();
            break;
            case 'detailsCommande':
                detailsCommande();
                break;
                case 'showCommandes':
                    showCommandes();
                    break;

            /* Actions pour la facture */
            /* ************************ */
        case 'facture':
            facture();
            break;

        default:
            header("location: index.php?action=home");
    }
} else {
    header("location: index.php?action=home");
}
?>