<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include_once('../__db/connexionDB.php'); // Connexion à la BDD

// Vérifier si l'utilisateur est admin (id = 1)
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    echo "Vous n'avez pas l'autorisation d'accéder à cette page.";
    exit();
}

// Vérifier si un utilisateur ou une entreprise est sélectionné
if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];

    // Vérifier si le type est correct ('people' ou 'companies')
    if ($type === 'people') {
        // Requête pour récupérer les informations de la table `people`
        $stmt = $BD->prepare("SELECT * FROM people WHERE id = ?");
    } elseif ($type === 'companies') {
        // Requête pour récupérer les informations de la table `companies`
        $stmt = $BD->prepare("SELECT * FROM companies WHERE id = ?");
    } else {
        echo "Type d'utilisateur invalide.";
        exit();
    }

    $stmt->execute([$id]);
    $user = $stmt->fetch();   

    // Vérifier si l'utilisateur ou l'entreprise existe
    if (!$user) {
        echo "Utilisateur ou entreprise non trouvé(e).";
        exit();
    }
} else {
    echo "Aucun utilisateur ou entreprise sélectionné(e).";
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier <?= $type === 'people' ? 'l\'utilisateur' : 'l\'entreprise' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body {
        background-color: beige;
    }
</style>
<body>
    <div class="container mt-5">
        <h1>Modifier <?= $type === 'people' ? 'l\'utilisateur' : 'l\'entreprise' ?></h1>
        <form action="updateMAJ-Admin.php" method="POST">
            <div class="mb-3">
                <label for="id" class="form-label">ID :</label>
                <input type="text" class="form-control" id="id" name="id" value="<?= htmlspecialchars($user['id']) ?>" readonly>
            </div>

            <?php if ($type === 'people'): ?>
                <!-- Formulaire pour la table 'people' -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username :</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Lastname:</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="mdp" class="form-label">Mot de passe :</label>
                    <input type="text" class="form-control" id="mdp" name="mdp" value="<?= htmlspecialchars($user['mdp']) ?>" required>
                </div>

            <?php elseif ($type === 'companies'): ?>
                <!-- Formulaire pour la table 'companies' -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l'entreprise :</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Adresse:</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($user['address']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe :</label>
                    <input type="text" class="form-control" id="password" name="password" value="<?= htmlspecialchars($user['password']) ?>" required>
                </div>
            <?php endif; ?>

            <!-- Champ caché pour le type -->
            <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">

            <button type="submit" class="btn btn-primary">Valider les modifications</button>
        </form>
        <div class="mt-4">
                <a href="admin.php" class="btn btn-dark">Retour</a>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
