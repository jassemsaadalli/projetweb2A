<?php
// Inclure le fichier du contrôleur pour accéder aux méthodes de gestion des événements
require_once '../controller/EvenementController.php';

// Créer une instance du contrôleur pour obtenir les événements
$controller = new EvenementController();

// Vérifier si l'ID de l'événement est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Récupérer l'ID de l'événement à partir de l'URL
    $eventId = $_GET['id'];

    // Récupérer les détails de l'événement à l'aide de l'ID
    $evenement = $controller->getEventById($eventId);
}

// Vérifier si le formulaire a été soumis pour mettre à jour l'événement
if (isset($_POST['id'], $_POST['titre'], $_POST['date_debut'], $_POST['date_fin'], $_POST['statut'])) {
    // Créer une nouvelle instance de l'événement avec les données mises à jour
    $updatedEvenement = new Evenement(
        $_POST['id'], 
        $_POST['titre'], 
        $_POST['date_debut'], 
        $_POST['date_fin'], 
        $_POST['statut'], 
        $_POST['nombre_participants'] // Assuming you have this field for participant count
    );

    // Mettre à jour l'événement dans la base de données
    try {
        $controller->updateEvenement($updatedEvenement);
        header("Location: listeEvenements.php"); // Rediriger après mise à jour
    } catch (Exception $e) {
        $error = "Erreur lors de la mise à jour : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'événement</title>
    <link rel="stylesheet" href="../styles.css"> <!-- Fichier CSS pour le style -->
</head>
<body>

<h1>Modifier l'événement</h1>

<!-- Afficher les erreurs s'il y en a -->
<?php if (isset($error)): ?>
    <div class="error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<!-- Formulaire pour modifier l'événement -->
<form action="" method="post">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($evenement['id']); ?>">

    <label for="titre">Titre:</label>
    <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($evenement['titre']); ?>" required>

    <label for="date_debut">Date début:</label>
    <input type="date" id="date_debut" name="date_debut" value="<?php echo htmlspecialchars($evenement['date_debut']); ?>" required>

    <label for="date_fin">Date fin:</label>
    <input type="date" id="date_fin" name="date_fin" value="<?php echo htmlspecialchars($evenement['date_fin']); ?>" required>

    <label for="statut">Statut:</label>
    <select id="statut" name="statut" required>
        <option value="disponible" <?php echo $evenement['statut'] == 'disponible' ? 'selected' : ''; ?>>Disponible</option>
        <option value="complet" <?php echo $evenement['statut'] == 'complet' ? 'selected' : ''; ?>>Complet</option>
    </select>

    <label for="nombre_participants">Nombre de participants:</label>
    <input type="number" id="nombre_participants" name="nombre_participants" value="<?php echo htmlspecialchars($evenement['nombre_participants']); ?>" required>

    <button type="submit">Mettre à jour</button>
</form>

<!-- Lien pour revenir à la liste des événements -->
<a href="listeEvenements.php">Retour à la liste des événements</a>

</body>
</html>
