<?php 

    include_once('_db/connexionDB.php');

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./Connexion.css">
</head>
<body>
    <div id="page-container">
        <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body fixed-top" data-bs-theme="dark">
            <div class="container-fluid d-flex justify-content-between">
                <ul class="navbar-nav me-auto d-flex flex-row">
                    <img src="../images/iconeP.webp" alt="CSS 3 Logo" class="image">

                    <li class="nav-item m-3"><a class="nav-link text-light" href="../index01.html">Trouver un job</a></li>
                </ul>

                <ul class="navbar-nav ms-auto d-flex flex-row">
                    <li class="nav-item m-3"><a class="nav-link text-light" href="../Candidature/Candidature.html">Candidature</a></li>
                    <li class="nav-item m-3"><a class="nav-link text-light" href="../poster un emploi/Poster un emploi.html">Poster un emploi</a></li>
                    <li class="nav-item m-3"><a class="nav-link text-light" href="./Connexion.php">Connexion</a></li>
                </ul>
            </div>
        </nav>
        <div class="container" style="padding-top: 90px;">
            <div class="row">
                <h1>connexion</h1>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Adresse Mail :</label>
                        <input class="form-control w-50" type="email" name="mail" value="" placeholder="Mail"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe :</label>
                        <input class="form-control w-50" type="password" name="password" value="" placeholder="Mot de passe"/>
                    </div>
                    <div class="mb-3">
                        <button type="submit" nom="connexion" class="btn btn-dark">Se connecter</button>
                    </div>
                </form>
            </div>
            <br>
            <br>
            <br>
                <button><a class="btn btn-dark" href="./inscription.php">S'inscrire</a></button>
        </div>
        </div>
        <footer class="bg-dark text-white py-4 mt-auto">
            <div class="container text-center">
                <p>&copy; Tous droits réservés.</p>
            </div>
        </footer>
    </div>

        
</body>
</html>
    