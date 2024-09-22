<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=arcadia', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $avis_id = $_POST['avis_id'];
    if (isset($_POST['valider'])) {
        $sql = "UPDATE avis SET isVisible = TRUE WHERE avis_id = :avis_id";
        $stmt = $bdd->prepare($sql);
        if ($stmt->execute([':avis_id' => $avis_id])) {
            echo "Avis validé avec succès.";
        } else {
            echo "Erreur lors de la validation de l'avis.";
        }
    } elseif (isset($_POST['refuser'])) {
        $sql = "DELETE FROM avis WHERE avis_id = :avis_id";
        $stmt = $bdd->prepare($sql);
        if ($stmt->execute([':avis_id' => $avis_id])) {
            echo "Avis refusé et supprimé avec succès.";
        } else {
            echo "Erreur lors du refus de l'avis.";
        }
    }
}

$sql = "SELECT * FROM avis WHERE isVisible = FALSE";
$avis = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valider les avis</title>
</head>
<body>
    <h2>Valider les avis</h2>
    <?php if (count($avis) > 0): ?>
        <?php foreach ($avis as $un_avis): ?>
            <div>
                <p><strong>Pseudo:</strong> <?php echo htmlspecialchars($un_avis['pseudo']); ?></p>
                <p><strong>Commentaire:</strong> <?php echo htmlspecialchars($un_avis['commentaire']); ?></p>
                <form action="" method="post">
                    <input type="hidden" name="avis_id" value="<?php echo $un_avis['avis_id']; ?>">
                    <button type="submit" name="valider">Valider</button>
                    <button type="submit" name="refuser">Refuser</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun avis à valider.</p>
    <?php endif; ?>
    <button class="btn btn-secondary btn-retour" onclick="goBack()">Retour</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>