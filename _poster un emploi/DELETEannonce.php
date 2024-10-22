<?php
session_start();
include_once('../__db/connexionDB.php');

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: /_Connexion/Connexion.php');
    exit;
}

// Vérifier que l'ID de l'annonce à supprimer est présent
if (!isset($_GET['id'])) {
    die('ID de l\'annonce manquant');
}

$annonce_id = $_GET['id'];

// Supprimer l'annonce
try {
    if ($_SESSION['user_id'] == 1) {
        $req = $BD->prepare("DELETE FROM advertisements WHERE id = ?");
        $req->execute([$annonce_id]);
    } else {
        $req = $BD->prepare("DELETE FROM advertisements WHERE id = ? AND company_id = ?");
        $req->execute([$annonce_id, $_SESSION['user_id']]);
    }

    if ($req->rowCount() > 0) {
        // Rediriger avec un message de succès
        header('Location: annonces.php?message=Annonce supprimée avec succès');
    } else {
        echo 'Erreur : Vous ne pouvez pas supprimer cette annonce.';
    }
} catch (PDOException $e) {
    echo 'Erreur SQL : ' . $e->getMessage();
}
