<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Board</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./style01.css">
</head>
<body>
    <div id="page-container">
        <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body fixed-top" data-bs-theme="dark">
            <div class="container-fluid d-flex justify-content-between">
                <ul class="navbar-nav me-auto d-flex flex-row">
                    <img src="./images/iconeP.webp" alt="CSS 3 Logo" class="image">

                    <li class="nav-item m-3"><a class="nav-link text-light" href="./index01.php">Trouver un job</a></li>
                </ul>

                <ul class="navbar-nav ms-auto d-flex flex-row">
                    <li class="nav-item m-3"><a class="nav-link text-light" href="./Candidature/Candidature.html">Candidature</a></li>
                    <li class="nav-item m-3"><a class="nav-link text-light" href="./poster un emploi/Poster un emploi.html">Poster un emploi</a></li>
                    <li class="nav-item m-3"><a class="nav-link text-light" href="./Connexion/Connexion.php">Connexion</a></li>
                </ul>
            </div>
        </nav>
        <header class="d-flex align-items-center" style="height: 150px;">
            <div class="container">
                <form class="d-flex align-items-center">
                    <input class="form-control flex-grow-1 me-2" type="search" placeholder="Recherchez un job..." aria-label="Mots-clés" name="keywords">

                    <input class="form-control me-2" style="flex: 1 0 15%;" type="search" placeholder="Ville(s)..." aria-label="Ville" name="city">

                    <select class="form-control me-2" style="flex: 1 0 15%;" aria-label="Type de contrat" name="contract_type">
                        <option value="">Type de contrat</option>
                        <option value="cdi">CDI</option>
                        <option value="cdd">CDD</option>
                        <option value="stage">Stage</option>
                        <option value="alternance">Alternance</option>
                    </select>

                    <button type="button" class="btn btn-secondary btn-sm">Rechercher</button>

                </form>
            </div>
        </header>
        <div class="container my-5">
            <h4>Toutes les offres d'emploi</h4>
        </div>
        <div id="content" class="container my-5">
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="square">
                        <div class="square-content d-flex flex-column">
                            <h1 class="text-center"> Web Développeur </h1>
                            <div class="info mt-auto">
                                <p><i class="bi bi-geo-alt-fill"></i> Localisation</p>
                                <p><i class="bi bi-file-earmark-text-fill"></i> Type de contrat</p>
                                <p><i class="bi bi-building"></i> Entreprise</p>
                                <a href="#" class="text-end float-end mt-2" onclick="openPanel()">
                                    <i class="bi-info-circle"></i>Lean more
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="square">
                        <div class="square-content">Annonce 2</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="square">
                        <div class="square-content">Annonce 3</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="square">
                        <div class="square-content">Annonece 4</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="square">
                        <div class="square-content">Annonce 5</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="square">
                        <div class="square-content">Annonce 6</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="square">
                        <div class="square-content">Annonce 7</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="square">
                        <div class="square-content">Annonce 8</div>
                    </div>
                </div>
            </div>


        </div>
        <div id="sidePanel" class="side-panel">
            <div class="side-panel-content">
                <div class="side-panel-header">
                    <h2>Informations Complètes</h2>
                    <a href="javascript:void(0)" class="close-btn" onclick="closePanel()">&times;</a>
                </div>
                <p>Voici les détails de l'annonce :</p>
                <p>Description : Développement d'applications web...</p>
                <p>Salaire : 45k€ - 50k€ par an</p>
                <p>Temps de travail : 35 heures par semaine</p>
                <p>Lieu : Paris, France</p>
                <button class="btn btn-dark">Postuler</button>
            </div>
        </div>
        <footer class="bg-dark text-white py-4 mt-auto">
            <div class="container text-center">
                <p>&copy; Tous droits réservés.</p>
            </div>
        </footer>
    </div>
    <script>
       
        function openPanel() {
            document.getElementById("sidePanel").style.width = "40%";
        }

        function closePanel() {
            document.getElementById("sidePanel").style.width = "0";
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
