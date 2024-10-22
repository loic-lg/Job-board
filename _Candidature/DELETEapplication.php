<?php
session_start();
include_once('../__db/connexionDB.php');



if (!isset($_SESSION['user_id'])) {
    header('Location: /_Connexion/Connexion.php');
    exit;
}

// Vérifier si l'ID de la candidature est soumis 
if (isset($_POST['application_id'])) {
    $application_id = $_POST['application_id'];

    
    if ($_SESSION['user_id'] == 1) {
        $req = $BD->prepare("DELETE FROM job_applications WHERE id = ?");
        $req->execute([$application_id]);
    } else {
        
        $req = $BD->prepare("DELETE FROM job_applications WHERE id = ? AND person_id = ?");
        $req->execute([$application_id, $_SESSION['user_id']]);
    }

    
    header('Location: ./Candidature.php');
    exit;
} else {
    echo "Aucune candidature spécifiée.";
}