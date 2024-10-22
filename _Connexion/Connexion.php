<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    include_once('../__db/connexionDB.php'); 

    if(isset($_SESSION['id'])){
        header('Location: ../index01.php');
        exit;
    }

    if(!empty($_POST)){
        extract($_POST);
        $valid = true;

        if(isset($_POST['connexion'])){
            $mail = trim($mail);
            $password = trim($password);

            // Vérification de l'email
            if(empty($mail)){
                $valid = false;
                $err_mail = "Veuillez entrer une adresse mail";
            } else {
                $req = $BD->prepare("SELECT id, mdp FROM people WHERE email = ?");
                $req->execute(array($mail)); 
                $user = $req->fetch();

                if(!$user) {
                    $valid = false;
                    $err_mail = "Adresse mail incorrecte";
                }
            }

            // Vérification du mot de passe
            if(empty($password)){
                $valid = false;
                $err_password = "Veuillez entrer un mot de passe";
            } elseif ($valid) {
                if($password !== $user['mdp']) {
                    $valid = false;
                    $err_password = "Mot de passe incorrect";
                }
            }

            // Si tout est ok on arrive ici et on redirige vers la page d'accueil
            if($valid) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: ../index01.php');
                exit();
            }
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // connexion companies --------------------------------------------------------------------------------------------
        if(isset($_POST['connexion_company'])){
            $mail_company = trim($mail_company);
            $password_company = trim($password_company);

            // Vérification de l'email
            if(empty($mail_company)){
                $valid = false;
                $err_mail = "Veuillez entrer une adresse mail";
            } else {
                $req = $BD->prepare("SELECT id, password FROM companies WHERE email = ?");
                $req->execute(array($mail_company)); 
                $user = $req->fetch();

                if(!$user) {
                    $valid = false;
                    $err_mail = "Adresse mail incorrecte";
                }
            }

            // Vérification du mot de passe
            if(empty($password_company)){
                $valid = false;
                $err_password = "Veuillez entrer un mot de passe";
            } elseif ($valid) {
                if($password_company !== $user['password']) {
                    $valid = false;
                    $err_password = "Mot de passe incorrect";
                }
            }

            // Si tout est ok on arrive ici et on redirige vers la page d'accueil
            if($valid) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: ../index01.php');
                exit();
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
    <div id="page-container" style="background-color:beige;">
    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body fixed-top" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index01.php">Job Board</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../index01.php">Trouver un job</a>
        </li>
        <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="../_Candidature/Candidature.php">Candidature</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../_poster un emploi/annonces.php">Poster un emploi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../_Mon-Compte/Mon-Compte.php">Mon Compte</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="../_Connexion/Connexion.php">Connexion</a>
          </li>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="#"><?php echo "ID: ".$_SESSION['user_id']?></a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
        <div class="container" style="padding-top: 90px;">
            <?php 
                // verifier erreur
                if(isset($err_mail)){
                    echo '<div class="alert alert-danger">' . $err_mail . '</div>';
                }
                if(isset($err_password)){
                    echo '<div class="alert alert-danger">' . $err_password . '</div>';
                }
                // Si l'inscription est réussie
                if(!empty($valid) && $valid){
                    echo '<div class="alert alert-success">Connexion réussie !</div>';
                }
            ?>
            <div class="row">
                <h1>Connexion</h1>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Adresse Mail :</label>
                        <input class="form-control w-50" type="email" name="mail" value="<?php if(isset($mail)){ echo $mail;} ?>" placeholder="Mail"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe :</label>
                        <input class="form-control w-50" type="password" name="password" value="<?php if(isset($password)){ echo $password;} ?>" placeholder="Mot de passe"/>
                    </div>
                    <div class="d-flex justify-content-between w-50">
                        <button type="submit" name="connexion" class="btn btn-dark">Se connecter</button>
                        <div class="ms auto">
                            <a href="./inscription.php" class="btn btn-dark">S'inscrire</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="mb-5">
                <h2>Connexion Entreprises</h2>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Adresse Mail :</label>
                        <input class="form-control w-50" type="email" name="mail_company" value="<?= isset($mail_company) ? htmlspecialchars($mail_company) : ''; ?>" placeholder="Mail">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe :</label>
                        <input class="form-control w-50" type="password" name="password_company" placeholder="Mot de passe">
                    </div>
                    <button type="submit" name="connexion_company" class="btn btn-dark">Se connecter</button>
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
    