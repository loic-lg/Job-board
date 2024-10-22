<?php
session_start();
include_once('../__db/connexionDB.php');

if (!$BD) {
    die('Erreur de connexion à la base de données');
}

if (!isset($_SESSION['user_id'])) {
    header('Location: /_Connexion/Connexion.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$isEntreprise = $user_id > 100000 ? true : false;

if (!$isEntreprise) {
    if ($user_id == 1) {
        $req = $BD->prepare("
            SELECT ja.id, a.title, a.short_description, a.wages, a.place, ja.status, ja.application_date, ja.person_id, ja.message
            FROM job_applications ja
            JOIN advertisements a ON ja.advertisement_id = a.id
            ORDER BY FIELD(ja.status, 'Approved', 'Pending', 'Rejected')
        ");
        $req->execute();
    } else {
        // Récupérer uniquement les candidatures de l'utilisateur connecté
        $req = $BD->prepare("
            SELECT ja.id, a.title, a.short_description, a.wages, a.place, ja.status, ja.application_date, ja.message
            FROM job_applications ja
            JOIN advertisements a ON ja.advertisement_id = a.id
            WHERE ja.person_id = ?
            ORDER BY FIELD(ja.status, 'Approved', 'Pending', 'Rejected')
        ");
        $req->execute([$user_id]);
    }

    $applications = $req->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatures</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
</head>
<body>
    <div id="page-container" class="container-fluid p-0" style="background-color:beige;">
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

        <div class="container mt-5">
            <br><br>
            <h1>Vos Candidatures</h1>
            
            <?php if ($isEntreprise): ?>
                <p class="alert alert-warning">Vous êtes une entreprise, pas un candidat.</p>
            <?php else: ?>
                <?php if (!empty($applications)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Titre de l'annonce</th>
                                    <th>Description courte</th>
                                    <th>Salaire</th>
                                    <th>Lieu</th>
                                    <th>Status</th>
                                    <th>Date de candidature</th>
                                    <?php if ($user_id == 1): ?>
                                        <th>ID Utilisateur</th> <!-- important pour admin -->
                                    <?php endif; ?>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($applications as $application): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($application['title']) ?></td>
                                        <td><?= htmlspecialchars($application['short_description']) ?></td>
                                        <td><?= htmlspecialchars($application['wages']) ?> €</td>
                                        <td><?= htmlspecialchars($application['place']) ?></td>
                                        <td><?= htmlspecialchars($application['status']) ?></td>
                                        <td><?= htmlspecialchars($application['application_date']) ?></td>
                                        <?php if ($user_id == 1): ?>
                                            <td><?= htmlspecialchars($application['person_id']) ?></td> 
                                        <?php endif; ?>
                                        <td>
                                            <form method="POST" action="../_Candidature/DELETEapplication.php" style="display: inline;">
                                                <input type="hidden" name="application_id" value="<?= htmlspecialchars($application['id']) ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                            </form>

                                            <!-- Bouton pour afficher le message -->
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" data-bs-message="<?= htmlspecialchars($application['message']) ?>">
                                                Voir le message
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>>
                <?php else: ?>
                    <p>Aucune candidature trouvée.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Offcanvas bootstrap-->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasRightLabel">Message de la candidature</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <!-- Le message sera injecté ici -->
                <p id="offcanvasMessageContent">Le contenu du message sera ici.</p>
            </div>
        </div>

        <footer class="bg-dark text-white py-4 mt-auto">
            <div class="container text-center">
                <p>&copy; Tous droits réservés.</p>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            // Script pour charger dynamiquement le message dans l'offcanvas bootstrap
            var offcanvasRight = document.getElementById('offcanvasRight');
            offcanvasRight.addEventListener('show.bs.offcanvas', function (event) {
                var button = event.relatedTarget; // Le bouton déclencheur
                var message = button.getAttribute('data-bs-message'); // Récupérer le message depuis l'attribut data
                var offcanvasMessageContent = document.getElementById('offcanvasMessageContent');
                
                // Injecter le message dans l'offcanvas
                offcanvasMessageContent.textContent = message;
            });
        </script>

    </div>
</body>
</html>
