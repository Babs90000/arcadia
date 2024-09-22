<?php
require_once '../template/header.php';

try {
    $bdd = new PDO('mysql:host=localhost;dbname=arcadia', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

$sql = "SELECT animaux.prenom, alimentation.date, alimentation.type_nourriture, alimentation.quantite_grammes, alimentation.heure 
        FROM alimentation 
        JOIN animaux ON alimentation.animal_id = animaux.animal_id 
        ORDER BY alimentation.date DESC";
$alimentation = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

    <main>
        <div class="container">
            <h1>Suivi de la Nourriture des Animaux</h1>
            <?php if (count($alimentation) > 0): ?>
                <table class="table_alimentation">
                    <thead>
                        <tr>
                            <th>Animal</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Nourriture</th>
                            <th>Quantité (g)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alimentation as $entry): ?>
                            <tr>
                                <td><?php echo $entry['prenom']; ?></td>
                                <td><?php echo $entry['date']; ?></td>
                                <td><?php echo $entry['heure']; ?></td>
                                <td><?php echo $entry['type_nourriture']; ?></td>
                                <td><?php echo $entry['quantite_grammes']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune donnée d'alimentation disponible.</p>
            <?php endif; ?>
        </div>
    </main>

<?php require_once '../template/footer.php'; ?>