<?php

class User  {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $passwd;
    private $statut;
    

    // CONSTRUCTEUR
    // ************
    // public function __construct($nom, $prenom, $email, $passwd,$statut) {
    //     $this->nom = $nom;
    //     $this->prenom = $prenom;
    //     $this->email = $email;
    //     $this->passwd = $passwd;
    //     $this->passwd = $statut;
        
    // }

    // GETTERS / SETTERS
    // *****************
    public function getId(): int {
        return $this->id;
    }
        public function getNom(): string {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getPrenom(): string{
        return $this->prenom;
    }

    public function setPrenom($prenom){
        $this->prenom = $prenom;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getPasswd(): string{
        return $this->passwd;
    }

    public function setPasswd($passwd){
        $this->passwd = $passwd;
    }
    public function getStatut(): int{
        return $this->statut;
    }

    public function setStatut($statut){
        $this->statut = $statut;
    }

    public function getToString(){
        $data = $this->nom.";";
        $data .= $this->prenom.";";
        $data .= $this->email.";";
        $data .= $this->passwd.";";
        $data .= $this->statut;
        return $data;
    }
}


    function getUserByEmail($email,$passwd) {
        // var_dump($_POST['email']);
        // var_dump($_POST['passwd']);
        // die();
        $sql = "SELECT * FROM user WHERE email=:email AND passwd=:passwd ";
    
        $rep=[];
    
        try {
            $bdd = dbConnect();

            $req = $bdd->prepare($sql);
            $req->bindValue(':email', $email, PDO::PARAM_STR);
            $req->bindValue(':passwd', $passwd, PDO::PARAM_STR);
            $req->execute();
            $req->setFetchMode(PDO::FETCH_CLASS , 'User');
            $rep = $req->fetch();
            // var_dump($rep);
            // die();
        }
        catch (PDOException $ex) {
            var_dump("Erreur GET USER: {$ex->getMessage()}");
        }
        finally {
            return $rep;
        }
    }