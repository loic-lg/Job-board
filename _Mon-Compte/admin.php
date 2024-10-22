<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include_once('../__db/connexionDB.php'); // Connexion à la BDD

if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) {
} else {
    echo "Vous n'avez pas l'autorisation d'accéder à cette page.";
    exit();
}

// Supprimer un utilisateur ou une entreprise
if (isset($_GET['delete']) && isset($_GET['type'])) {
    $id = $_GET['delete'];
    $type = $_GET['type'];
    
    if ($type == 'people') {
        $stmt = $BD->prepare("DELETE FROM people WHERE id = ?");
    } elseif ($type == 'companies') {
        $stmt = $BD->prepare("DELETE FROM companies WHERE id = ?");
    }
    $stmt->execute([$id]);
    header("Location: admin.php");
    exit();
}

// Récupérer les utilisateurs de la table people
$stmtPeople = $BD->query("SELECT *, 'people' AS type FROM people");
$usersPeople = $stmtPeople->fetchAll();

// Récupérer les entreprises de la table companies
$stmtCompanies = $BD->query("SELECT *, 'companies' AS type FROM companies");
$usersCompanies = $stmtCompanies->fetchAll();

// Fusionner les deux résultats
$users = array_merge($usersPeople, $usersCompanies);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./Mon-Compte.css">
</head>
<body>
    <div id="page-container" class="d-flex flex-column min-vh-100" style="background-color:beige;">
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
        <div class="container-fluid mt-5 pt-5">
            <h1 class="mb-4">Gestion des utilisateurs et entreprises</h1>
            <!-- Ajout de table-responsive pour la table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Mot de passe</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['type']) ?></td>
                            <td><?= htmlspecialchars($user['username'] ?? $user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['mdp'] ?? $user['password']) ?></td>
                            <td>
                                <a href="edit_user.php?id=<?= $user['id'] ?>&type=<?= $user['type'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                                <a href="admin.php?delete=<?= $user['id'] ?>&type=<?= $user['type'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ou cette entreprise ?');" class="btn btn-sm btn-danger">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Footer -->
        <footer class="bg-dark text-white py-4 mt-auto">
            <div class="container text-center">
                <p>&copy; Tous droits réservés.</p>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS pour l'interaction avec la navbar -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
