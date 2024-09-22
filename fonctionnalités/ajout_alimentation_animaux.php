<?php
require_once '../template/header.php';

// Vérifier si l'utilisateur est connecté et s'il a les droits nécessaires
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 2 && $_SESSION['role'] != 1)) { // Supposons que le rôle 2 est pour les employés
    echo 'Accès refusé. Seuls les employés ou l\'administrateur peuvent accéder à cette page.';
    exit();
}

// Connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=arcadia', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Gestion des requêtes POST pour ajouter une consommation de nourriture
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['animal_id']) && !empty($_POST['date']) && !empty($_POST['heure']) && !empty($_POST['nourriture']) && !empty($_POST['quantite']) && !empty($_POST['username'])) {
        $animal_id = (int)$_POST['animal_id'];
        $date = htmlspecialchars($_POST['date']);
        $heure = htmlspecialchars($_POST['heure']);
        $nourriture = htmlspecialchars($_POST['nourriture']);
        $quantite = (int)$_POST['quantite'];
        $username = htmlspecialchars($_POST['username']); // Récupérer le nom d'utilisateur depuis le formulaire

        // Récupérer le race_id de l'animal sélectionné
        $stmt = $bdd->prepare('SELECT race_id FROM animaux WHERE animal_id = :animal_id');
        $stmt->bindValue(':animal_id', $animal_id, PDO::PARAM_INT);
        $stmt->execute();
        $race = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$race) {
            $_SESSION['message'] = "L'animal sélectionné n'existe pas.";
            header('Location: ajout_alimentation_animaux.php');
            exit();
        }
        $race_id = $race['race_id'];

        // Insertion dans la table alimentation
        $stmt = $bdd->prepare('INSERT INTO alimentation (animal_id, date, heure, type_nourriture, quantite_grammes, race_id, username) VALUES (:animal_id, :date, :heure, :type_nourriture, :quantite_grammes, :race_id, :username)');
        $stmt->bindValue(':animal_id', $animal_id, PDO::PARAM_INT);
        $stmt->bindValue(':date', $date, PDO::PARAM_STR);
        $stmt->bindValue(':heure', $heure, PDO::PARAM_STR);
        $stmt->bindValue(':type_nourriture', $nourriture, PDO::PARAM_STR);
        $stmt->bindValue(':quantite_grammes', $quantite, PDO::PARAM_INT);
        $stmt->bindValue(':race_id', $race_id, PDO::PARAM_INT);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['message'] = "L'ajout de nourriture a été effectué avec succès.";
        } else {
            $_SESSION['message'] = "Une erreur s'est produite lors de l'ajout de la nourriture.";
        }

        header('Location: ajout_alimentation_animaux.php');
        exit();
    } else {
        $_SESSION['message'] = "Veuillez remplir tous les champs.";
    }
}

// Récupération des animaux
$query = 'SELECT animal_id, prenom FROM animaux';
$animaux = $bdd->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../pages/style_formulaire_nourriture.css" />


    <main>
        <div class="block_formulaire">
            <h1>Gestion de l'alimentation</h1>
            <h2>Ajouter une consommation de nourriture</h2>

            <?php if (isset($_SESSION['message'])): ?>
                <p class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
            <?php endif; ?>

            <form method="POST">
                <label for="animal_id">Animal :</label>
                <select name="animal_id" id="animal_id" required>
                    <?php foreach ($animaux as $animal): ?>
                        <option value="<?php echo $animal['animal_id']; ?>"><?php echo $animal['prenom']; ?></option>
                    <?php endforeach; ?>
                </select><br><br>
                <label for="date">Date :</label>
                <input type="date" name="date" id="date" required>
                <label for="heure">Heure :</label>
                <input type="time" name="heure" id="heure" required><br><br>
                <label for="nourriture">Type de Nourriture :</label>
                <input type="text" name="nourriture" id="nourriture" placeholder="Type Nourriture" required><br><br>
                <label for="quantite">Quantité (en grammes) :</label>
                <input type="number" name="quantite" id="quantite" placeholder="Quantité (en grammes)" required><br><br>
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" name="username" id="username" placeholder="Nom d'utilisateur" required><br><br>
                <button type="submit">Ajouter</button>
            </form>
            <br>
            <button onclick="history.back()" class=bouton_retour>Retour en arrière </button>
        </div>
    </main>
</body>
</html>