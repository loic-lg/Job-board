<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include_once('../__db/connexionDB.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Vérifier si l'ID est inférieur à 100001 (people) ou supérieur (companies)
    if ($user_id < 100001) {
        // Récupérer les informations de la table `people`
        $query = $BD->prepare("SELECT username, lastname, email FROM people WHERE id = ?");
    } else {
        // Récupérer les informations de la table `companies`
        $query = $BD->prepare("SELECT name, address, email FROM companies WHERE id = ?");
    }

    $query->execute([$user_id]);
    $user = $query->fetch();

    if (!$user) {
        echo "Utilisateur non trouvé.";
        exit;
    }
} else {
    echo "Veuillez vous connecter.";
    exit;
}
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./Mon-Compte.css">
</head>
<body>
    <div id="page-container" style="background-color:beige;">
        <!-- Navbar responsive -->
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
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

        <!-- Contenu principal -->
        <div class="container mt-5 pt-5" style="padding-top: 80px;">
            <h3>Modifier vos informations</h3>
            <form action="updateMAJ.php" method="post" enctype="multipart/form-data">
                <?php if ($user_id < 100001) { // Formulaire pour les utilisateurs (people) ?>
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                    </div>
                <?php } else { // Formulaire pour les entreprises (companies) ?>
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de l'entreprise</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
                    </div>
                <?php } ?>
                <div class="mb-3">
                    <label for="password" class="form-label">Nouveau mot de passe (laissez vide pour ne pas changer)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>

            <div class="mt-4">
                <a href="deconnexion.php" class="btn btn-dark">Se déconnecter</a>
            </div>
            <?php 
                if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) {
                    ?>
                    <div class="mt-4">
                        <a href="admin.php" class="btn btn-dark">Admin</a>
                    </div>
            <?php } ?>
        </div>


        <footer class="bg-dark text-white py-4 mt-auto">
            <div class="container text-center">
                <p>&copy; Tous droits réservés.</p>
            </div>
        </footer>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

