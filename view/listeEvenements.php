<?php
// Inclure le fichier du contrôleur pour accéder aux méthodes de gestion des événements
require_once '../controller/EvenementController.php';

// Créer une instance du contrôleur pour obtenir les événements
$controller = new EvenementController();
$evenements = $controller->listevenement(); // Méthode pour récupérer les événements
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Événements</title>
    <link rel="stylesheet" href="../styles.css"> <!-- Fichier CSS pour le style -->
</head>
<body>

<h1>Liste des Événements</h1>

<!-- Tableau pour afficher les événements -->
<table border="1">
    <thead>
        <tr>
            <th>Titre de l'événement</th>
            <th>Date</th>
            <th>Nombre de participants</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Vérifier si des événements sont présents -->
        <?php if (!empty($evenements)): ?>
            <?php foreach ($evenements as $evenement): ?>
                <tr>
                    <td><?php echo htmlspecialchars($evenement['titre']); ?></td>
                    <td><?php echo htmlspecialchars($evenement['date_debut']); ?></td>
                    <td><?php echo htmlspecialchars($evenement['date_fin']); ?></td>

                    <td><?php echo htmlspecialchars($evenement['nombre_participants']); ?></td>
                    <td><?php echo htmlspecialchars($evenement['statut']); ?></td>
                    <td>
                        <a href="updateEvent.php?id=<?php echo $evenement['id']; ?>">Modifier</a> /
                        <a href="supprimer.php?id=<?php echo $evenement['id']; ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Aucun événement trouvé.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Lien pour ajouter un nouvel événement -->
<a href="ajouter.php">Ajouter un nouvel événement</a>

</body>
</html>
