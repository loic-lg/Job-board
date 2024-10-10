<?php 
            //******************* */ A faire : hasher le mdp ***********************************



        include_once('../_db/connexionDB.php');


    if(!empty($_POST)){
        extract($_POST);

        $valid = (boolean) true;


        if(isset($_POST['inscription'])){
            $mail = trim($mail);
            $nom = trim($nom);
            $prénom = trim($prénom);
            $password = trim($password);
            $confpassword = trim($confpassword);

            // mail -----------------------------------------
            if(empty($mail)){
                $valid = false;
                $err_mail = "Veuillez entrer une adresse mail";
        

            }else{
                $req = $BD->prepare("SELECT id FROM people WHERE email = ?"); //verifier email et mail 
                $req->execute(array($mail)); // modif fait
                $req = $req->fetch();

                if(isset($req['id'])){
                    $valid = false;
                    $err_mail = "Cet email est déja utilise";
                }
            }

            // Password ----------------------------------------------
            if(empty($password)){
                $err_password = "Veuillez entrer un mot de passe";
                $valid = false;

            }elseif($password !== $confpassword){
                $valid = false; 
                $err_password = "les mots de passe sont différents";
            

            }if ($valid) {
                try {
                    // Ajouter le rôle par défaut (par exemple 'Applicant')
                    $role = 'Applicant';
            
                    // Modifier la requête SQL pour inclure le rôle
                    $req = $BD->prepare("INSERT INTO people(username, lastname, email, mdp, role) VALUES (?, ?, ?, ?, ?)");
                    $success = $req->execute([$prénom, $nom, $mail, $password, $role]);
            
                    if ($success) {
                        echo '<div class="alert alert-success">Inscription réussie !</div>';
                    } else {
                        // Afficher les erreurs SQL s'il y en a
                        $errorInfo = $req->errorInfo();
                        echo '<div class="alert alert-danger">Erreur lors de l\'inscription : ' . $errorInfo[2] . '</div>';
                    }
                } catch (PDOException $e) {
                    echo 'Erreur SQL : ' . $e->getMessage();
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./Connexion.css">
</head>
<body>
    <div id="page-container">
        <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body fixed-top" data-bs-theme="dark">
            <div class="container-fluid d-flex justify-content-between">
                <ul class="navbar-nav me-auto d-flex flex-row">
                    <img src="../images/iconeP.webp" alt="CSS 3 Logo" class="image">

                    <li class="nav-item m-3"><a class="nav-link text-light" href="../index01.html">Trouver un job</a></li>
                </ul>

                <ul class="navbar-nav ms-auto d-flex flex-row">
                    <li class="nav-item m-3"><a class="nav-link text-light" href="../Candidature/Candidature.html">Candidature</a></li>
                    <li class="nav-item m-3"><a class="nav-link text-light" href="../poster un emploi/Poster un emploi.html">Poster un emploi</a></li>
                    <li class="nav-item m-3"><a class="nav-link text-light" href="./Connexion.php">Connexion</a></li>
                </ul>
            </div>
        </nav>
        <div class="container" style="padding-top: 90px;">
            <?php 
                // Si une erreur existe, elle sera affichée ici
                if(isset($err_mail)){
                    echo '<div class="alert alert-danger">' . $err_mail . '</div>';
                }

                // Si l'inscription est réussie
                if(!empty($valid) && $valid){
                    echo '<div class="alert alert-success">Inscription réussie !</div>';
                }
            ?>
            <hr width="650px">
            <div class="row">
                <h1>Insciption</h1>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Adresse Mail :</label>
                        <input class="form-control w-50" type="email" name="mail" value="<?php if(isset($mail)){ echo $mail;} ?>" placeholder="Mail"/>
                        <?php if(isset($err_mail)){echo $err_mail; }?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nom :</label>
                        <input class="form-control w-50" type="text" name="nom" value="<?php if(isset($nom)){ echo $nom;} ?>" placeholder="nom"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prénom :</label>
                        <input class="form-control w-50" type="text" name="prénom" value="<?php if(isset($prénom)){ echo $prénom;} ?>" placeholder="Prénom"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe :</label>
                        <input class="form-control w-50" type="password" name="password" value="<?php if(isset($password)){ echo $password;} ?>" placeholder="Mot de passe"/>
                        <?php if(isset($err_password)){echo $err_password; }?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmation du Mot de passe :</label>
                        <input class="form-control w-50" type="password" name="confpassword" value="" placeholder="Confirmation du mot de passe"/>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="inscription" class="btn btn-dark">S'inscrire</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
        <footer class="bg-dark text-white py-4 mt-auto">
            <div class="container text-center">
                <p>&copy; Tous droits réservés.</p>
            </div>
        </footer>
    </div>

        
</body>
</html>
    