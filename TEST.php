<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=arcadia', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Récupérer les habitats
$habitats = $bdd->query('SELECT habitat_id, nom FROM habitats')->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les espèces et races par habitat
$especes_par_habitat = [];
$races_par_habitat = [];
foreach ($habitats as $habitat) {
    $stmt = $bdd->prepare('
        SELECT DISTINCT races.label
        FROM animaux
        JOIN races ON animaux.race_id = races.race_id
        WHERE animaux.habitat_id = :habitat_id
    ');
    $stmt->execute([':habitat_id' => $habitat['habitat_id']]);
    $especes_par_habitat[$habitat['habitat_id']] = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $stmt = $bdd->prepare('
        SELECT DISTINCT races.label
        FROM animaux
        JOIN races ON animaux.race_id = races.race_id
        WHERE animaux.habitat_id = :habitat_id
    ');
    $stmt->execute([':habitat_id' => $habitat['habitat_id']]);
    $races_par_habitat[$habitat['habitat_id']] = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Zoo</title>
    <link rel="stylesheet" href="path/to/your/css/file.css">
</head>
<body>
    <h1>Bienvenue au Zoo</h1>
    <p class="p-3 fs-6 fw-light">Le zoo est entièrement indépendant au niveau des énergies et respecte les principes de durabilité.</p>
  </section>

  <!-- SERVICES -->
  <div class="container-fluid">
    <div class="row w-75 mx-auto my-5 service-row">
      <div class="col-lg-6 col-md-12 col-sm-12 d-flex justify-content-start my-5 icono-wrap">
       <img class="image-services" src="assets/image-service.jpg" alt="services" width="180" height=160>
       <div>
      <h3 class="fs-5 mt-4 px-4 pb-1 text-success">Services</h3>
      <p class="px-4">Restauration, visite des habitats avec un guide (gratuit), visite du zoo en petit train.</p>
      </div>
      </div>
      <div class="col-lg-6 col-md-12 col-sm-12 d-flex justify-content-start my-5 icono-wrap">
       <img class="image-services" src="assets/animaux-image.jpg" alt="services" width="180" height=160>
       <div>
      <h3 class="fs-5 mt-4 px-4 pb-1 text-success">Animaux</h3>
      <p class="px-4">Faitez la connaisance de nos pensionnaires. Des infos mises à jour chaque matin par nos veterinaires.</p>
      </div>
      </div>
      </div>
      <div class="row w-75 mx-auto my-5 service-row">
        <div class="col-lg-6 col-md-12 col-sm-12 d-flex justify-content-start my-5 icono-wrap">
         <img class="image-services" src="assets/image-habitat.jpg" alt="services" width="180" height=160>
         <div>
        <h3 class="fs-5 mt-4 px-4 pb-1 text-success" href="habitats.html" >Habitats</h3>
        <p class="px-4">Nous comptons trois habitats specialement conçus pour nos animaux. Envie d'en savoir plus ?</p>
        <!-- Liste des espèces et races par habitat -->
        <?php foreach ($habitats as $habitat): ?>
            <h4><?php echo htmlspecialchars($habitat['nom']); ?></h4>
            <h5>Espèces présentes :</h5>
            <ul>
                <?php foreach ($especes_par_habitat[$habitat['habitat_id']] as $espece): ?>
                    <li><?php echo htmlspecialchars($espece); ?></li>
                <?php endforeach; ?>
            </ul>
            <h5>Races présentes :</h5>
            <ul>
                <?php foreach ($races_par_habitat[$habitat['habitat_id']] as $race): ?>
                    <li><?php echo htmlspecialchars($race); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
        <!-- <a class="btn btn-succes" href="habitats.html" role="button">En savoir plus.</a>   -->
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="text-center text-lg-start bg-light text-muted">
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
      <div class="me-5 d-none d-lg-block">
        <span>Rejoignez-nous sur les réseaux sociaux :</span>
      </div>
      <div>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-google"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-linkedin"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-github"></i>
        </a>
      </div>
    </section>

    <section class="">
      <div class="container text-center text-md-start mt-5">
        <div class="row mt-3">
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <h6 class="text-uppercase fw-bold mb-4 text-success">
              Zoo
            </h6>
            <p>
              Bienvenue au Zoo, un endroit où vous pouvez découvrir une grande variété d'animaux et en apprendre davantage sur leur habitat naturel.
            </p>
          </div>

          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
            <h6 class="text-uppercase fw-bold mb-4 text-success">
              Liens utiles
            </h6>
            <p>
              <a href="#!" class="text-reset">Animaux</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Habitats</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Rejoignez-nous</a>
            </p>
          </div>

          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
            <h6 class="text-uppercase fw-bold mb-4 text-success">
              Services
            </h6>
            <p>
              <a href="#!" class="text-reset">Billeterie</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Restauration</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Visite du zoo avec un guide</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Visite du zoo en petit train</a>
            </p>
          </div>

          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <h6 class="text-uppercase fw-bold mb-4 text-success">
              Contact
            </h6>
            <p><i class="fas fa-home me-3 text-success"></i> Paris, France</p>
            <p>
              <i class="fas fa-envelope me-3 text-success"></i>
              info@zoo.com
            </p>
            <p><i class="fas fa-phone me-3 text-success"></i> + 01 234 567 88</p>
            <p><i class="fas fa-print me-3 text-success"></i> + 01 234 567 89</p>
          </div>
        </div>
      </div>
    </section>

    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
      © 2023 Copyright:
      <a class="text-reset fw-bold" href="https://zoo.com/">zoo.com</a>
    </div>
  </footer>
</body>
</html>