<?php
session_start();

require_once './__db/connexionDB.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: _Connexion/Connexion.php');
    exit();
}

$bdd = new connexionDB();
$db = $bdd->DB();

$advertisementId = $_POST['advertisement_id'];
$personId = $_POST['person_id'];
$message = $_POST['message']; 
$status = "Pending";

// Vérifier si une candidature existe déjà
$sqlCheck = "SELECT COUNT(*) FROM job_applications WHERE advertisement_id = ? AND person_id = ?";
$stmtCheck = $db->prepare($sqlCheck);
$stmtCheck->execute([$advertisementId, $personId]);

if ($stmtCheck->fetchColumn() > 0) {
    header("Location: ./_Candidature/Candidature.php");
    exit();
}

// Si aucune candidature n'existe, insérer les données avec le message
$sql = "INSERT INTO job_applications (advertisement_id, person_id, status, message) VALUES (?, ?, ?, ?)";
$stmt = $db->prepare($sql);
$stmt->execute([$advertisementId, $personId, $status, $message]);

header("Location: ./_Candidature/Candidature.php");
exit();
?>
