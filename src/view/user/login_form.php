<?php
//titre de la page
$title = "mvc-Store: Login";

ob_start();


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Authentification : Signin Page</title>
</head>
<body>
    
<!-- Afficher le formulaire de connexion -->
<h1>Connexion</h1>
    <form action="index.php?action=getUser" method="post">
        
        <div class="form-group mb-20">
            <label for="email">Votre adresse de messagerie</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre adresse de messagerie"/>
        </div> 
        <div class="form-group mb-20">
            <label for="mdpasse">Votre mot de passe</label>
            <input type="password" class="form-control" id="mdpasse" name="passwd" placeholder="Entrez votre mot de passe"/>
        </div>
        <button type="submit" class="btn btn-primary" name="valider">Me connecter</button>
    </form>
</body>
</html>
<?php 
$content = ob_get_clean();
require 'src/view/template.php';