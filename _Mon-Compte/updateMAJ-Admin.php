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

// Vérifier que l'ID et le type sont envoyés
if (isset($_POST['id']) && isset($_POST['type'])) {
    $id = $_POST['id'];
    $type = $_POST['type'];

    if ($type === 'people') {
        // Vérification des données envoyées pour la table `people`
        if (isset($_POST['username'], $_POST['lastname'], $_POST['mdp'])) {
            $username = $_POST['username'];
            $lastname = $_POST['lastname'];
            $mdp = $_POST['mdp'];

            // Requête de mise à jour pour `people`
            $stmt = $BD->prepare("UPDATE people SET username = ?, lastname = ?, mdp = ? WHERE id = ?");
            $stmt->execute([$username, $lastname, $mdp, $id]);
            echo "Utilisateur mis à jour avec succès.";
        } else {
            echo "Données invalides pour l'utilisateur.";
            exit();
        }
    } elseif ($type === 'companies') {
        // Vérification des données envoyées pour la table `companies`
        if (isset($_POST['name'], $_POST['address'], $_POST['password'])) {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $password = $_POST['password'];

            // Requête de mise à jour pour `companies`
            $stmt = $BD->prepare("UPDATE companies SET name = ?, address = ?, password = ? WHERE id = ?");
            $stmt->execute([$name, $address, $password, $id]);
            echo "Entreprise mise à jour avec succès.";
        } else {
            echo "Données invalides pour l'entreprise.";
            exit();
        }
    } else {
        echo "Type invalide.";
        exit();
    }

    // Rediriger après la mise à jour
    header("Location: admin.php");
    exit();
} else {
    echo "Données invalides.";
    exit();
}
