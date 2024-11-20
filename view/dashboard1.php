<?php
require_once('../config.php');  // Inclure le fichier de connexion

// Connexion à la base de données
$pdo = config::getConnection();

// Requête pour récupérer les événements
$query = "SELECT id, titre, date_debut, date_fin, nombre_participants, statut FROM evenements";
$stmt = $pdo->query($query);

// Récupérer les résultats
$evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau des événements</title>
</head>
<body>
    <h1>Liste des événements</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Date de début</th>
                <th>Date de Fin </th>
                <th>Nombre de participants</th>
                <th>Statut</th>
                <th>Actions</th>

            </tr>
        </thead>
        <tbody>
            <?php if ($evenements): ?>
                <?php foreach ($evenements as $evenement): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($evenement['titre']); ?></td>
                        <td><?php echo htmlspecialchars($evenement['date_debut']); ?></td>
                        <td><?php echo htmlspecialchars($evenement['date_fin']); ?></td>
                        <td><?php echo htmlspecialchars($evenement['nombre_participants']); ?></td>
                        <td><?php echo htmlspecialchars($evenement['statut']); ?></td>
                        <td><a href="supprimer.php?action=supprimer&id=<?php echo $evenement['id']; ?>">Supprimer</a>
                        <a href="modifier.php?action=modifier&id=<?php echo $evenement['id']; ?>">Modifier</a></td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Aucun événement trouvé</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="ajouter.php">Ajouter un nouvel événement</a>

</body>
</html>
