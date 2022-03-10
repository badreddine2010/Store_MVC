<?php
require 'src/model/dbaccess.php';
require 'src/model/category.php';

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


