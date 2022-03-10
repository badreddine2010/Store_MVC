<?php
   require "src/model/category.php";

   /**
    * showCategories
    * Affiche la liste des categories
    * @return array
    */
   function showAllCategories() {
       // Rechercher la liste des categories
       // Appel du model categories
       $categories = getAllCategories();

       // Demander l'affichage des categories
       // appel de la vue
       require "src/view/category/category_view.php";
   }

   function deleteCategory($id) {
       // Demander au Model de réaliser la requête DELETE
       $ret = deleteCategoryById($id);
       showAllCategories();
   }

   function createCategoryForm(){
        if(isset($_GET['id'])){
            // MODIFICATION
            // ************
            $category = getCategoryById(htmlspecialchars($_GET['id']));
            if($category) {
                $nom = $category->getNom();
                $btnText ="Modifier";
                $link = "index.php?action=saveCategory&id={$category->getId()}";
            }
        }
        else {
            // CREATION
            // ********
            $nom = "";
            $btnText= "Créer";
            $link = "index.php?action=saveCategory";
        }

       require "src/view/category/categoryForm.php";
   }

   function createCategory($nomcategory) {
        if(isset($_POST['nomCategory'])) {
            $nomCategory = htmlspecialchars($_POST['nomCategory']);

            // Demander au model de créer la categorie en BDD
            $ret = addCategory($nomCategory);
            showAllCategories();
        }
        else {
            showAllCategories();
        }
   }

   function createOrUpdateCategory() {
        
    $categoryNom = htmlspecialchars($_POST['nomCategory']);

       if(isset($_GET['id'])){
           // MODIFICATION
           // ************
           $categoryId = htmlspecialchars($_GET['id']);
           updateCategory($categoryId, $categoryNom);
        
       }
       else {
           // CREATION
           // ********
           addCategory($categoryNom);
       }

       showAllCategories();
   }