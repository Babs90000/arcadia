<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="./style_page_habitat.css">
<?php include_once '../template/header.php'; ?>
<div class="containerHabitats" style="height: 600px;">
        <h2 class="text-success text-center mb-4">Nos Habitats</h2>
        <div class="row">
            <?php
    

            $sql = "SELECT habitats.*, images.image_data FROM habitats LEFT JOIN images ON habitats.habitat_id = images.habitat_id";
            $habitats = $base_de_donnees->query($sql)->fetchAll(PDO::FETCH_ASSOC);

            if (count($habitats) > 0) {
                foreach ($habitats as $habitat) {
                    echo "<div class='col-md-6 col-lg-4 mb-4'>";
                    echo "<div class='card h-100'>";
                    if ($habitat['image_data']) {
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($habitat['image_data']) . '" alt="Image de l\'habitat" class="card-img-top">';
                    }
                    echo "<div class='card-body d-flex flex-column'>";
                    echo "<h5 class='card-title text-success'>" . htmlspecialchars($habitat['nom']) . "</h5>";
                    echo "<p class='card-text flex-grow-1'>" . htmlspecialchars($habitat['description']) . "</p>";
                    echo '<a href="detail_habitat.php?habitat_id=' . $habitat['habitat_id'] . '" class="btn btn-success mt-auto">Voir en détail</a>';
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-center'>Aucun habitat disponible.</p>";
            }
            ?>
        </div>
    </div>
    
<?php require_once '../template/footer.php'; ?>
