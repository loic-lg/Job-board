<?php 
session_start();

include_once('./__db/connexionDB.php');
if(isset($_SESSION['user_id'])) {
    echo "Utilisateur connecté avec ID : " . $_SESSION['user_id'];
} else {
    echo "Utilisateur non connecté.";
}

?>

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
    <div id="page-container" style="background-color:beige;">
    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body fixed-top" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="./index01.php">Job Board</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./index01.php">Trouver un job</a>
        </li>
        <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="./_Candidature/Candidature.php">Candidature</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./_poster un emploi/annonces.php">Poster un emploi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./_Mon-Compte/Mon-Compte.php">Mon Compte</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="./_Connexion/Connexion.php">Connexion</a>
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

<!-- formulaire fonctionnel -->
        <header class="d-flex align-items-center" style="height: 150px;">
            <div class="container">
                <form class="d-flex align-items-center" method="GET" action="index01.php"> 
                    <input class="form-control flex-grow-1 me-2" type="search" placeholder="Recherchez un job..." aria-label="Mots-clés" name="keywords">

                    <input class="form-control me-2" style="flex: 1 0 15%;" type="search" placeholder="Ville(s)..." aria-label="Ville" name="city">

                    <select class="form-control me-2" style="flex: 1 0 15%;" aria-label="Type de contrat" name="contract_type">
                        <option value="">Type de contrat</option>
                        <option value="cdi">CDI</option>
                        <option value="cdd">CDD</option>
                        <option value="stage">Stage</option>
                        <option value="alternance">Alternance</option>
                    </select>

                    <button type="submit" class="btn btn-secondary btn-sm">Rechercher</button>

                </form>
            </div>
        </header>
<!--  -->

        <div class="container my-5">
    <h4>Toutes les offres d'emploi</h4>
</div>
<div id="content" class="container my-5">
  <div class="row g-4">

    <?php
    // Modification de la requête pour prendre en compte les filtres de recherche
    $searchQuery = "SELECT a.*, c.name AS company_name 
                    FROM advertisements a 
                    INNER JOIN companies c ON a.company_id = c.id
                    WHERE 1=1";  // Utilisation de WHERE 1=1 pour construire la requête dynamiquement

    // Vérification des paramètres de recherche
    if (isset($_GET['keywords']) && !empty($_GET['keywords'])) {
        $keywords = htmlspecialchars($_GET['keywords']); 
        $searchQuery .= " AND (a.title LIKE '%$keywords%')";
    }

    if (isset($_GET['city']) && !empty($_GET['city'])) {
        $city = htmlspecialchars($_GET['city']);
        $searchQuery .= " AND a.place LIKE '%$city%'";
    }

    if (isset($_GET['contract_type']) && !empty($_GET['contract_type'])) {
        $contractType = htmlspecialchars($_GET['contract_type']);
        $searchQuery .= " AND a.working_time = '$contractType'";
    }

    // Exécution de la requête modifiée
    $result = $BDD->DB()->query($searchQuery);
    $data = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $data[] = $row;
      ?>

      <div class="col-12 col-md-6 col-lg-4">
        <div class="card rounded-1 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-center"><?php echo $row["title"]; ?></h5>
            <p class="card-text">
              <i class="bi bi-geo-alt-fill"></i> <?php echo $row["place"]; ?><br>
              <i class="bi bi-file-earmark-text-fill"></i> <?php echo $row["working_time"]; ?><br>
              <i class="bi bi-building"></i> <?php echo $row["company_name"]; ?><br>
              <i class="bi bi-calendar-fill"></i> Created: <?php echo date('d M Y', strtotime($row["created_at"])); ?><br>
              <i class="bi bi-cash-stack"></i> Salary: <?php echo $row["wages"]; ?><br>
              <span class="short-description">
                <?php echo substr($row["full_description"], 0, 140) . '...'; ?>
              </span>
            </p>
            <div class="text-center">
              <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#side-panel" data-advertisement-id="<?php echo $row["id"]; ?>">Learn more</button>
            </div>
          </div>
        </div>
      </div>
      <?php
    }
    ?>
  </div>
  <script>
        // Load data into JavaScript variable
        window.advertisementData = <?php echo json_encode($data); ?>;
    </script>
</div>

<!-- Side panel -->
<div id="side-panel" class="offcanvas offcanvas-end" style="width: 40%; background-color: #f8f9fa;">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Détails de l'annonce</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body" id="side-panel-content">
    <!-- Content will be loaded here dynamically -->
  </div>
</div>

<!-- JavaScript code to load data into side panel -->
<script>
  document.getElementById("side-panel").addEventListener("show.bs.offcanvas", function (event) {
    var button = event.relatedTarget;
    var advertisementId = button.dataset.advertisementId;
    var advertisementData = window.advertisementData.find(function (ad) {
      return ad.id === parseInt(advertisementId);
    });

    if (advertisementData) {
      // Load data into side panel
      var sidePanelContent = document.getElementById("side-panel-content");
      sidePanelContent.innerHTML = `
        <div class="p-3">
          <h2 class="mb-3 text-primary">${advertisementData.title}</h2>
          <h6><i class="bi bi-clock"></i> Temps de travail: ${advertisementData.working_time}</h6>
          <h6><i class="bi bi-geo-alt"></i> Lieu: ${advertisementData.place}</h6>
          <h6><i class="bi bi-cash-stack"></i> Salaire: ${advertisementData.wages} Euros/heure</h6>
          <p class="mt-3">${advertisementData.full_description}</p>
          
          <hr class="my-4">

          <!-- Formulaire pour postuler -->
          <h5 class="mb-3 text-secondary">Postuler à cette offre</h5>
          <form id="apply-form" method="post" action="apply.php">
            <input type="hidden" name="advertisement_id" value="${advertisementId}">
            <input type="hidden" name="person_id" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">

            <!-- Message -->
            <div class="mb-3">
              <label for="message" class="form-label">Message (max 100 caractères)</label>
              <textarea class="form-control" id="message" name="message" rows="3" maxlength="100" placeholder="Entrez un message ici..." required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Postuler</button>
          </form>
        </div>
      `;
    }
  });
</script>

        <footer class="bg-dark text-white py-4 mt-auto">
            <div class="container text-center">
                <p>&copy; Tous droits réservés.</p>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
