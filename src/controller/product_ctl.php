<?php
// namespace AppStore;
    require "src/model/product.php";

    function showAllProducts() {
        $products = getAllProducts();
        require "src/view/products/product_view.php";
    }


    function deleteProduct() {
        $id = htmlspecialchars($_GET['id']);
        $ret = delProductById($id);
        showAllProducts();
    }

    function createProductForm() {
        if(isset($_GET['id'])){
            $product = getProductById(intval($_GET['id']));
        }
        require "src/view/products/productForm.php";
    }

    function createOrChangeProduct() {
      if(isset($_GET['id'])){
        updateProduct(htmlspecialchars($_GET['id']));
      }
      else {
        addNewProduct();
      }
      showAllProducts();
    }
    function showAllProductsCostumers() {
      $products = getAllProductsCostumers();
      require "src/view/products/product_costumer_view.php";
  }