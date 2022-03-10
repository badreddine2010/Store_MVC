<?php
// namespace AppStore;

// use PDO;
// use PDOException;

class Product {
    private $id_prod;
    private $category_id;
    private $name;
    private $unit_price;
    private $quantity;
    private $nameCat;
    

    public function getId_prod() { return $this->id_prod; }
    
    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function getNameCat() { return $this->nameCat; }
    public function setNameCat($nameCat) { $this->nameCat = $nameCat; }

    public function getCategory_id() { return $this->category_id; }
    public function setCategory_id($category_id) { $this->category_id = $category_id; }

    
    public function getUnit_price() { return $this->unit_price; }
    public function setPrice($unit_price) { $this->unit_price = $unit_price; }

    public function getQuantity() { return $this->quantity; }
    public function setQuantity($quantity) { $this->quantity = $quantity; }
    
   
}

function getAllProducts() {
    $sql = "SELECT id_prod,products.name,unit_price,quantity,category.name as nameCat FROM products INNER JOIN category ON category_id=category.id";

    $rep=[];

    try {
        $bdd = dbConnect();
        $req = $bdd->query($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $rep = $req->fetchAll();
    }
    catch (PDOException $ex) {
        var_dump("Erreur GET PRODUCTS: {$ex->getMessage()}");
    }
    finally {
        return $rep;
    }
}
function getAllProductsCostumers() {
    $sql = "SELECT id_prod,products.name as name_prod,quantity,unit_price,category.name as name_cat FROM products INNER JOIN category ON category_id=category.id";

    $rep=[];

    try {
        $bdd = dbConnect();
        $req = $bdd->query($sql);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $rep = $req->fetchAll();
    }
    catch (PDOException $ex) {
        var_dump("Erreur GET PRODUCTS: {$ex->getMessage()}");
    }
    finally {
        return $rep;
    }
}

function getProductById($id) {
    $sql = "SELECT * FROM products WHERE id_prod= :id";

    $rep=[];

    try {
        $bdd = dbConnect();
        $req = $bdd->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $rep = $req->fetch();
    }
    catch (PDOException $ex) {
        var_dump("Erreur GET PRODUCTS: {$ex->getMessage()}");
    }
    finally {
        return $rep;
    }
}

function delProductById($id) {
    $sql = "DELETE FROM products WHERE id_prod= :id";

    $rep=false;

    try {
        $bdd = dbConnect();
        $req = $bdd->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $rep=$req->execute();
    }
    catch (PDOException $ex) {
        var_dump("Erreur GET PRODUCTS: {$ex->getMessage()}");
    }
    finally {
        return $rep;
    }
}

function addNewProduct() {
    $sql = "INSERT INTO products (name, category_id, quantity, unit_price)";
    $sql .= " VALUES(:name, :category_id, :quantity, :unit_price)";

    $rep=false;

    try {
        $bdd = dbConnect();
        $req = $bdd->prepare($sql);
        $req->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $req->bindValue(':category_id', $_POST['category_id'], PDO::PARAM_INT);
        $req->bindValue(':quantity', $_POST['quantity'], PDO::PARAM_INT);
        $req->bindValue(':unit_price', $_POST['unit_price'], PDO::PARAM_INT);

        $rep=$req->execute();
    }
    catch (PDOException $ex) {
        var_dump("Erreur GET PRODUCTS: {$ex->getMessage()}");
    }
    finally {
        return $rep;
    }
}

function updateProduct($id) {
    $sql = "UPDATE products SET name=:name, category_id=:category_id, quantity=:quantity, unit_price=:unit_price";
    $sql .= " WHERE id_prod=:id";

    $rep=false;

    try {
        $bdd = dbConnect();
        $req = $bdd->prepare($sql);
        $req->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $req->bindValue(':category_id', $_POST['category_id'], PDO::PARAM_INT);
        $req->bindValue(':quantity', $_POST['quantity'], PDO::PARAM_INT);
        $req->bindValue(':unit_price', $_POST['unit_price'], PDO::PARAM_STR);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $rep=$req->execute();
    }
    catch (PDOException $ex) {
        var_dump("Erreur GET PRODUCTS: {$ex->getMessage()}");
    }
    finally {
        return $rep;
    }
}
