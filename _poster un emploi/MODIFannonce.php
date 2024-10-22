<?php
session_start();
include_once('../__db/connexionDB.php');


if (!isset($_SESSION['user_id'])) {
    header('Location: /_Connexion/Connexion.php');
    exit;
}


if (!isset($_GET['id'])) {
    die('ID de l\'annonce manquant');
}

$annonce_id = $_GET['id'];
$message = '';

if (!empty($_POST)) {
    extract($_POST);

    
    if (empty($title) || empty($short_description) || empty($full_description) || empty($wages) || empty($place) || empty($working_time)) {
        $message = 'Veuillez remplir tous les champs.';
    } else {
        try {
            // Maj de l'annonce
            $req = $BD->prepare("UPDATE advertisements SET title = ?, short_description = ?, full_description = ?, wages = ?, place = ?, working_time = ?, updated_at = NOW() WHERE id = ?");
            $req->execute([
                $title,
                $short_description,
                $full_description,
                $wages,
                $place,
                $working_time,
                $annonce_id
            ]);

            $message = 'Annonce modifiée avec succès !';
        } catch (PDOException $e) {
            echo 'Erreur SQL : ' . $e->getMessage();
        }
    }
}

// Récupérer les informations actuelles de l'annonce
try {
    $req = $BD->prepare("SELECT * FROM advertisements WHERE id = ?");
    $req->execute([$annonce_id]);
    $annonce = $req->fetch();

    if (!$annonce) {
        die('Annonce introuvable');
    }
} catch (PDOException $e) {
    echo 'Erreur SQL : ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'annonce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Modifier l'annonce</h1>

        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?= $message ?></div>
        <?php endif; ?>

        
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Titre de l'annonce</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= $annonce['title'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="short_description" class="form-label">Description courte</label>
                <textarea class="form-control" id="short_description" name="short_description" rows="2" required><?= $annonce['short_description'] ?></textarea>
            </div>

            <div class="mb-3">
                <label for="full_description" class="form-label">Description complète</label>
                <textarea class="form-control" id="full_description" name="full_description" rows="5" required><?= $annonce['full_description'] ?></textarea>
            </div>

            <div class="mb-3">
                <label for="wages" class="form-label">Salaire</label>
                <input type="number" class="form-control" id="wages" name="wages" value="<?= $annonce['wages'] ?>" >
            </div>

            <div class="mb-3">
                <label for="place" class="form-label">Lieu</label>
                <input type="text" class="form-control" id="place" name="place" value="<?= $annonce['place'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="working_time" class="form-label">Type de contrat</label>
                <select class="form-control" id="working_time" name="working_time" required>
                    <option value="CDI" <?= ($annonce['working_time'] == 'CDI') ? 'selected' : '' ?>>CDI</option>
                    <option value="CDD" <?= ($annonce['working_time'] == 'CDD') ? 'selected' : '' ?>>CDD</option>
                    <option value="Stage" <?= ($annonce['working_time'] == 'Stage') ? 'selected' : '' ?>>Stage</option>
                    <option value="Alternance" <?= ($annonce['working_time'] == 'Alternance') ? 'selected' : '' ?>>Alternance</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="annonces.php" class="btn btn-secondary">Retour</a>
        </form>
    </div>
</body>
</html>
