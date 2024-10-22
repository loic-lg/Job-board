<?php
session_start();
include_once('../__db/connexionDB.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: /_Connexion/Connexion.php');
    exit;
}

$annonce_id = $_GET['id']; // Récupérer l'ID de l'annonce passée en paramètre

// Récupérer la liste des candidats pour l'annonce ciblée
try {
    $req = $BD->prepare("
        SELECT ja.id as application_id, p.id as person_id, p.username, p.lastname, p.email, ja.status, ja.message 
        FROM job_applications ja 
        JOIN people p ON ja.person_id = p.id 
        WHERE ja.advertisement_id = ?
    ");
    $req->execute([$annonce_id]);
    $candidatures = $req->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Erreur lors de la récupération des candidatures : ' . $e->getMessage();
}

// si mise à jour valide
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'], $_POST['application_id'])) {
    $status = $_POST['status'];
    $application_id = $_POST['application_id'];

    try {
        $updateStatus = $BD->prepare("UPDATE job_applications SET status = ? WHERE id = ?");
        $updateStatus->execute([$status, $application_id]);
        $message = "Statut mis à jour avec succès.";
    } catch (PDOException $e) {
        $message = "Erreur lors de la mise à jour du statut : " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les candidatures</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Gérer les candidatures pour l'annonce ID : <?= htmlspecialchars($annonce_id) ?></h1>
        
        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <?php if (!empty($candidatures)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Candidat</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($candidatures as $candidature): ?>
                        <tr>
                            <td><?= htmlspecialchars($candidature['person_id']) ?></td> 
                            <td><?= htmlspecialchars($candidature['username']) ?></td>
                            <td><?= htmlspecialchars($candidature['lastname']) ?></td>
                            <td><?= htmlspecialchars($candidature['email']) ?></td>
                            <td><?= htmlspecialchars($candidature['status']) ?></td>
                            <td>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="application_id" value="<?= htmlspecialchars($candidature['application_id']) ?>">
                                    <select name="status" class="form-select">
                                        <option value="Pending" <?= $candidature['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="Approved" <?= $candidature['status'] === 'Approved' ? 'selected' : '' ?>>Approved</option>
                                        <option value="Rejected" <?= $candidature['status'] === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                    </select>
                                    <button type="submit" class="btn btn-success btn-sm mt-2">Mettre à jour</button>
                                </form>
                                
                                <!-- Bouton pour afficher le message -->
                                <button type="button" class="btn btn-info btn-sm mt-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" data-bs-message="<?= htmlspecialchars($candidature['message']) ?>">
                                    Voir le message
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune candidature trouvée pour cette annonce.</p>
        <?php endif; ?>
        <button onclick="history.back();" class="btn btn-dark">Retour</button>
    </div>

    <!-- Offcanvas -->
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Script pour charger dynamiquement le message dans l'offcanvas
        var offcanvasRight = document.getElementById('offcanvasRight');
        offcanvasRight.addEventListener('show.bs.offcanvas', function (event) {
            var button = event.relatedTarget; // Le bouton qui a déclenché l'événement
            var message = button.getAttribute('data-bs-message'); // Récupérer le message depuis l'attribut data
            var offcanvasMessageContent = document.getElementById('offcanvasMessageContent');
            
            // Injecter le message dans l'offcanvas
            offcanvasMessageContent.textContent = message;
        });
    </script>

</body>
</html>
