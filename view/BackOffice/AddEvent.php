<?php
require_once('../../config.php');
require_once('../../controller/EvenementController.php');  // Include the controller file


// Vérifiez si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifiez si toutes les clés sont présentes dans $_POST
    if (isset($_POST['titre'],$_POST['description'], $_POST['date_debut'], $_POST['date_fin'], $_POST['nombre_participants'], $_POST['statut'])) {
        // Récupérer les données du formulaire
        $titre = $_POST['titre'];
        $description= $_POST['description'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];  // Vous n'aviez pas cette variable, mais elle est nécessaire
        $nombre_participants = $_POST['nombre_participants'];
        $statut = $_POST['statut'];

         // Handle image upload
         if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageTmpName = $_FILES['image']['tmp_name'];
            $imageName = basename($_FILES['image']['name']);
            $targetDirectory = "uploads/";
            $targetFile = $targetDirectory . $imageName;

            // Ensure the uploads directory exists
            if (!is_dir($targetDirectory)) {
                mkdir($targetDirectory, 0755, true);
            }

            // Move the uploaded file
            if (move_uploaded_file($imageTmpName, $targetFile)) {
                // File uploaded successfully
                $imagePath = $targetFile;
            } else {
                echo "Erreur lors du téléchargement de l'image.";
                exit;
            }
        } else {
            echo "Veuillez fournir une image.";
            exit;
        }

        try {
            // Créer un objet Evenement
            $evenement = new Evenement();
            $evenement->setTitre($titre);
            $evenement->setDescription($description);
            $evenement->setDate_debut($date_debut);
            $evenement->setDate_fin($date_fin);
            $evenement->setNbparticipants($nombre_participants);
            $evenement->setStatut($statut);
            $evenement->setImage($imagePath); // Set the image path


            // Appeler la méthode addevenement pour insérer l'événement
            $evenementController = new EvenementController();
            $evenementController->addevenement($evenement);

            echo "Événement ajouté avec succès !";
            header("Location: BackOfficeDashboard.php?section=events");  // Redirect after successful update
            exit;

        } catch (Exception $e) {
            echo "Erreur lors de l'ajout de l'événement: " . $e->getMessage();
        }
    } else {
        echo "Tous les champs doivent être remplis.";
    }

    $errors = [];

    // Titre validation
    if (empty($titre)) {
        $errors[] = "Le titre est obligatoire.";
    }

    // Date validation
    if (empty($date_debut) || empty($date_fin)) {
        $errors[] = "Les dates sont obligatoires.";
    } elseif (strtotime($date_fin) < strtotime($date_debut)) {
        $errors[] = "La date de fin doit être postérieure à la date de début.";
    }

    // Nombre de participants validation
    if (empty($nombre_participants) || !filter_var($nombre_participants, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
        $errors[] = "Le nombre de participants doit être un entier positif.";
    }

    // Description validation
    if (strlen($description) < 10) {
        $errors[] = "La description doit contenir au moins 10 caractères.";
    }

    // Image validation
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Une image valide est obligatoire.";
    }

    if (empty($errors)) {
        // Process form
        // Code to save the event...
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>

<!-- Formulaire HTML pour l'ajout d'événement -->
<form method="POST" action="" enctype="multipart/form-data">
    <h2>Ajouter un événement</h2>

    <label for="titre">Titre de l'événement :</label>
    <input type="text" name="titre" id="titre" >

    <label for="date_debut">Date de début :</label>
    <input type="date" name="date_debut" id="date_debut" >

    <label for="date_fin">Date de fin :</label>
    <input type="date" name="date_fin" id="date_fin" >

    <label for="nombre_participants">Nombre de participants :</label>
    <input type="number" name="nombre_participants" id="nombre_participants" >

    <label for="description">Description de l'événement :</label>
    <textarea name="description" id="description" rows="4" cols="50" ></textarea>

    <label for="statut">Statut :</label>
    <select name="statut" id="statut" >
        <option value="actif">Actif</option>
        <option value="inactif">Inactif</option>
    </select>

    <label for="image">Image de l'événement :</label>
    <input type="file" name="image" id="image" accept="image/*" >

    <button type="submit">Ajouter l'événement</button>
</form>


</body>
</html>


</div>
</body>
<!-- Controle de saisie -->
<script>
    document.querySelector('form').addEventListener('submit', function (e) {
        const titre = document.getElementById('titre').value.trim();
        const dateDebut = new Date(document.getElementById('date_debut').value);
        const dateFin = new Date(document.getElementById('date_fin').value);
        const nombreParticipants = parseInt(document.getElementById('nombre_participants').value, 10);
        const description = document.getElementById('description').value.trim();
        const statut = document.getElementById('statut').value;

        let errors = [];

        // Titre validation
        if (titre === '') {
            errors.push("Le titre de l'événement est obligatoire.");
        }

        // Date validation
        if (isNaN(dateDebut) || isNaN(dateFin)) {
            errors.push("Les dates doivent être valides.");
        } else if (dateFin < dateDebut) {
            errors.push("La date de fin doit être postérieure à la date de début.");
        }

        // Participants validation
        if (isNaN(nombreParticipants) || nombreParticipants <= 0) {
            errors.push("Le nombre de participants doit être un entier positif.");
        }

        // Description validation
        if (description.length < 10) {
            errors.push("La description doit contenir au moins 10 caractères.");
        }

        // Display errors
        if (errors.length > 0) {
            e.preventDefault(); // Prevent form submission
            alert(errors.join("\n"));
        }
    });
</script>


</html>

