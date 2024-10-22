<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include_once('../__db/connexionDB.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: /_Connexion/Connexion.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if ($user_id > 100000 || $user_id == 1) {
    $isEntreprise = false; 
} else {
    $isEntreprise = true;
}

$message = '';

if (!empty($_POST)) {
    extract($_POST);

    if (empty($title) || empty($short_description) || empty($full_description) || empty($wages) || empty($place) || empty($working_time)) {
        $message = 'Veuillez remplir tous les champs.';
    } else {
        try {
            $req = $BD->prepare("INSERT INTO advertisements (title, short_description, full_description, wages, place, working_time, company_id, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");

            $req->execute([
                $title,
                $short_description,
                $full_description,
                $wages,
                $place,
                $working_time,
                $_SESSION['user_id']
            ]);

            $message = 'Annonce ajoutée avec succès !';
        } catch (PDOException $e) {
            echo 'Erreur de connexion DB : ' . $e->getMessage();
        }
    }
}

// Récupérer les annonces de l'utilisateur connecté
try {
    if ($_SESSION['user_id'] == 1) {
        $annonces = $BD->prepare("SELECT * FROM advertisements");
        $annonces->execute();
    } else {
        $annonces = $BD->prepare("SELECT * FROM advertisements WHERE company_id = ?");
        $annonces->execute([$_SESSION['user_id']]);
    }
} catch (PDOException $e) {
    echo 'Erreur lors de la récupération des annonces : ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poster un emploi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
</head>
<body>
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

    <!-- Contenu principal avec espacement pour éviter la superposition avec la navbar -->
    <div class="container mt-5 pt-5" style="background-color:beige;">
        <br><br>

        <!-- Formulaire pour poster une annonce -->
        <?php if ($isEntreprise): ?>
            <p class="alert alert-warning">Vous êtes un candidat, pas une entreprise.</p>
        <?php else: ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Titre de l'annonce</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>

                <div class="mb-3">
                    <label for="short_description" class="form-label">Description courte</label>
                    <textarea class="form-control" id="short_description" name="short_description" rows="2" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="full_description" class="form-label">Description complète</label>
                    <textarea class="form-control" id="full_description" name="full_description" rows="5" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="wages" class="form-label">Salaire</label>
                    <input type="number" class="form-control" id="wages" name="wages" >
                </div>

                <div class="mb-3">
                    <label for="place" class="form-label">Lieu</label>
                    <input type="text" class="form-control" id="place" name="place" required>
                </div>

                <div class="mb-3">
                    <label for="working_time" class="form-label">Type de contrat</label>
                    <select class="form-control" id="working_time" name="working_time" required>
                        <option value="CDI">CDI</option>
                        <option value="CDD">CDD</option>
                        <option value="Stage">Stage</option>
                        <option value="Alternance">Alternance</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-dark w-100">Poster l'annonce</button>
            </form>

            <?php if (!empty($message)): ?>
                <div class="alert alert-info mt-3"><?= $message ?></div>
            <?php endif; ?>

            <!-- Liste des annonces -->
            <h2 class="mt-5">Vos annonces</h2>

            <?php if ($annonces->rowCount() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Description courte</th>
                                <th>Salaire</th>
                                <th>Lieu</th>
                                <th>Type de contrat</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($annonce = $annonces->fetch()): ?>
                                <tr>
                                    <td><?= $annonce['id'] ?></td>
                                    <td><?= $annonce['title'] ?></td>
                                    <td><?= $annonce['short_description'] ?></td>
                                    <td><?= $annonce['wages'] ?></td>
                                    <td><?= $annonce['place'] ?></td>
                                    <td><?= $annonce['working_time'] ?></td>
                                    <td>
                                        <a href="MODIFannonce.php?id=<?= $annonce['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                        <a href="DELETEannonce.php?id=<?= $annonce['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');">Supprimer</a>
                                        <a href="gererCandidatures.php?id=<?= $annonce['id'] ?>" class="btn btn-success btn-sm mt-2">Gérer les candidatures</a> 
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>Aucune annonce.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS pour l'interaction avec la navbar -->
        <!-- Bootstrap JS pour l'interaction avec la navbar -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
