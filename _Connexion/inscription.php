<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('../__db/connexionDB.php');

// Vérifier si ok de mettre en chaine 
$err_mail = $err_password = $err_company = $message_candidat = $message_entreprise = '';

if (isset($_POST['inscription_candidat'])) {
    $nom = trim($_POST['nom']);
    $prénom = trim($_POST['prénom']);
    $mail = trim($_POST['mail']);
    $password = trim($_POST['password']);
    $confpassword = trim($_POST['confpassword']);
    $valid = true;

    if (empty($mail)) {
        $valid = false;
        $err_mail = "Veuillez entrer une adresse mail.";
    } else {
        $req = $BD->prepare("SELECT id FROM people WHERE email = ?");
        $req->execute([$mail]);
        $req = $req->fetch();
        if (isset($req['id'])) {
            $valid = false;
            $err_mail = "Cet email est déjà utilisé.";
        }
    }

    if (empty($password)) {
        $valid = false;
        $err_password = "Veuillez entrer un mot de passe.";
    } elseif ($password !== $confpassword) {
        $valid = false;
        $err_password = "Les mots de passe ne correspondent pas.";
    }

    if ($valid) {
        try {

            // Insertion dans la table people
            $req = $BD->prepare("INSERT INTO people (username, lastname, email, mdp, role) VALUES (?, ?, ?, ?, ?)");
            $success = $req->execute([$nom, $prénom, $mail, $password, 'Applicant']);
            if ($success) {
                $message_candidat = "Inscription réussie en tant que candidat !";
            }
        } catch (PDOException $e) {
            echo 'Erreur SQL : ' . $e->getMessage();
        }
    }
}

// Gestion de l'inscription entreprise
if (isset($_POST['inscription_entreprise'])) {
    $company_name = trim($_POST['company_name']);
    $company_email = trim($_POST['company_email']);
    $company_address = trim($_POST['company_address']);
    $password = trim($_POST['password']);
    $confpassword = trim($_POST['confpassword']);
    $valid = true;

    // Validation des champs
    if (empty($company_email)) {
        $valid = false;
        $err_mail = "Veuillez entrer une adresse mail.";
    } else {
        // Vérifier si l'email existe déjà dans companies
        $req = $BD->prepare("SELECT id FROM companies WHERE email = ?");
        $req->execute([$company_email]);
        $req = $req->fetch();
        if (isset($req['id'])) {
            $valid = false;
            $err_mail = "Cet email est déjà utilisé.";
        }
    }

    if (empty($password)) {
        $valid = false;
        $err_password = "Veuillez entrer un mot de passe.";
    } elseif ($password !== $confpassword) {
        $valid = false;
        $err_password = "Les mots de passe ne correspondent pas.";
    }

    if ($valid) {
        try {

            // Insertion dans la table companies
            $req = $BD->prepare("INSERT INTO companies (name, address, email, password) VALUES (?, ?, ?, ?)");
            $success = $req->execute([$company_name, $company_address, $company_email,$password]);
            if ($success) {
                $message_entreprise = "Inscription réussie en tant qu'entreprise !";
            }
        } catch (PDOException $e) {
            echo 'Erreur SQL : ' . $e->getMessage();
        }
    }
    // Si tout est ok on arrive ici et on redirige vers la page de connexion
    if($valid) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: ./Connexion.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container" style="padding-top: 50px;">
        
        <h2>S'inscrire comme Candidat</h2>
        <?php if (!empty($message_candidat)) { echo '<div class="alert alert-success">' . $message_candidat . '</div>'; } ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Nom :</label>
                <input class="form-control" type="text" name="nom" placeholder="Nom" required>
            </div>
            <div class="mb-3">
                <label class="form-label">prénom :</label>
                <input class="form-control" type="text" name="prénom" placeholder="prénom" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Adresse Mail :</label>
                <input class="form-control" type="email" name="mail" placeholder="Adresse mail" required>
                <?php if (isset($err_mail)) { echo '<div class="text-danger">' . $err_mail . '</div>'; } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe :</label>
                <input class="form-control" type="password" name="password" placeholder="Mot de passe" required>
                <?php if (isset($err_password)) { echo '<div class="text-danger">' . $err_password . '</div>'; } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirmer le mot de passe :</label>
                <input class="form-control" type="password" name="confpassword" placeholder="Confirmez le mot de passe" required>
            </div>
            <button type="submit" name="inscription_candidat" class="btn btn-primary">S'inscrire comme Candidat</button>
        </form>

        <hr>

        <h2>S'inscrire comme Entreprise</h2>
        <?php if (!empty($message_entreprise)) { echo '<div class="alert alert-success">' . $message_entreprise . '</div>'; } ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Nom de l'entreprise :</label>
                <input class="form-control" type="text" name="company_name" placeholder="Nom de l'entreprise" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Adresse :</label>
                <input class="form-control" type="text" name="company_address" placeholder="Adresse" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Adresse Mail :</label>
                <input class="form-control" type="email" name="company_email" placeholder="Adresse mail" required>
                <?php if (isset($err_mail)) { echo '<div class="text-danger">' . $err_mail . '</div>'; } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe :</label>
                <input class="form-control" type="password" name="password" placeholder="Mot de passe" required>
                <?php if (isset($err_password)) { echo '<div class="text-danger">' . $err_password . '</div>'; } ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirmer le mot de passe :</label>
                <input class="form-control" type="password" name="confpassword" placeholder="Confirmez le mot de passe" required>
            </div>
            <button type="submit" name="inscription_entreprise" class="btn btn-primary">S'inscrire comme Entreprise</button>
        </form>
    </div>
</body>
</html>
