<?php
    // session_start();

    require "src/model/user.php";


    function getUser() {
        $email = htmlspecialchars($_POST['email']);
        $passwd = htmlspecialchars($_POST['passwd']);
        $rep = getUserByEmail($email,$passwd);
        // var_dump(($rep));
        // die();
        $_SESSION['user'] = $rep->getNom();
        $_SESSION['statut'] = $rep->getStatut();
        $_SESSION['id'] = $rep->getId();
        // $_SESSION['user'] = $rep['nom'];
        home();
    }
    function login(){
        require 'src/view/user/login_form.php';
    }
    function logout(){
        require 'src/view/user/logout.php';
    }