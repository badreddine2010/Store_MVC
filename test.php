<?php
require 'src/model/dbaccess.php';
require 'src/model/category.php';
require 'src/model/product.php';

$allCat = getAllCategories();
$addCat = addCategory('cat-test');
$idCat =dbConnect()->lastInsertId();
var_dump($idCat);
$updateCat = updateCategory($idCat,'cat-test');
$delCat = deleteCategoryById($idCat);

var_dump($allCat);
var_dump($addCat);
var_dump($updateCat);
var_dump($delCat);

$allProd = getAllProductsCostumers();
$addProd = addNewProduct('cat-test');
$idProd =dbConnect()->lastInsertId();
var_dump($idProd);
$updateProd = updateProduct($idProd);
$delProd = delProductById($idProd);

var_dump($allProd);
var_dump($addProd);
// var_dump($updateProd);
var_dump($delProd);
