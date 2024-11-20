<!--  tab3a qr-
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Événement</title>
    <link rel="stylesheet" href="../view/evennement.css">
</head>
<body>
    <h1>Ajouter un Événement</h1>
    <form action="" method="post">
        <label for="titre">Titre de l'événement :</label>
        <input type="text" id="titre" name="titre" required><br>

        <label for="date">Date :</label>
        <input type="date" id="date" name="date" required><br>

        <label for="nombre_participants">Nombre de participants :</label>
        <input type="number" id="nombre_participants" name="nombre_participants" required><br>

        <label for="statut">Statut :</label>
        <select id="statut" name="statut">
            <option value="Actif">Actif</option>
            <option value="Inactif">Inactif</option>
        </select><br>

        <input type="submit" value="Ajouter l'événement">
    </form>
    <a href="index.php">Retour à la liste des événements</a>
</body>
</html>
