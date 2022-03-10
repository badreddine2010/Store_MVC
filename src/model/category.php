<?php
// namespace TestUnit;

class Category {
    private $id;
    private $name;

    public  function getId() {return $this->id;}

    public function getNom() {return $this->name;}
    public  function setNom($name) {$this->name = $name;}
}

/**
 * getAllCategories
 *
 * @return array 
 */
function  getAllCategories() {
    $sql = "SELECT * FROM category";
    $rep=[];

    try {
        $bdd = dbConnect();
        $req = $bdd->query($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, 'Category');
        $rep = $req->fetchAll();
    }
    catch (PDOException $ex) {
        var_dump("Erreur GET CATEGORY: {$ex->getMessage()}");
    }
    finally {
        return $rep;
    }
}

function deleteCategoryById($id) {
    $ret = false;

    $sql = "DELETE FROM category";
    $sql .= " WHERE id={$id}";

    try {
        $bdd = dbConnect();
        $req = $bdd->query($sql);
        $ret = $req->execute();
    }
    catch (PDOException $ex) {
        var_dump("Erreur GET CATEGORY: {$ex->getMessage()}");
    }
    finally {
        return $ret;
    }
}

function addCategory($nom) {
    $ret = false;
    $sql = "INSERT INTO category (name) VALUES(:nom)";
    try {
        $bdd = dbConnect();
        $req = $bdd->prepare($sql);
        $req->bindValue(':nom', $nom, PDO::PARAM_STR);
        $ret = $req->execute();
    }
    catch (PDOException $ex) {
        var_dump("Erreur GET CATEGORY: {$ex->getMessage()}");
    }
    finally {
        return $ret;
    }
}

function getCategoryById($id) {
    $sql ="SELECT * FROM category WHERE id = :id";

    $bdd = dbConnect();
    $req = $bdd->prepare($sql);
    $req->BindValue(':id', $id, PDO::PARAM_INT);
    $req->setFetchMode(PDO::FETCH_CLASS, 'Category');
    $req->execute();
    $category = $req->fetch();
    return $category;
}

function updateCategory($categoryId, $categoryNom) {
    $ret = false;
    
    $sql = "UPDATE category SET name = :nom WHERE id = :id";

    $bdd = dbConnect();
    $req = $bdd->prepare($sql);
    $req->bindValue(':id', $categoryId, PDO::PARAM_INT);
    $req->bindValue(':nom', $categoryNom, PDO::PARAM_STR);

    $ret = $req->execute();

    return $ret;
}