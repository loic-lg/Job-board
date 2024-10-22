<?php
session_start();
session_destroy(); // sortir de la session
header('Location: ../_Connexion/Connexion.php'); 
exit();
?>
