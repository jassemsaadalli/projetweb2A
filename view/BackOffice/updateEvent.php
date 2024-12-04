<?php
// Include the necessary files for the controller and event model
require_once('../../config.php');  // Event Controller
require_once('../../controller/EvenementController.php');  // Event Controller

// Create a new instance of the controller
$controller = new EvenementController();

// Check if the ID of the event is passed in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Retrieve the event ID from the URL
    $eventId = $_GET['id'];

    // Get the event details using the controller
    $evenement = $controller->getEventById($eventId);
} else {
    // If no event ID is provided, redirect to the event list
    //header("Location: listeEvenements.php");
    exit;
}

// Check if the form has been submitted to update the event
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve updated data from the form
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $nombre_participants = $_POST['nombre_participants'];
    $description = $_POST['description'];
    $statut = $_POST['statut'];
    
    // Handle image upload
    $imagePath = $evenement['image']; // Retain the current image path by default
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        
        // Check if the file is an image
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $imagePath = $uploadFile; // Update the image path with the uploaded file
            } else {
                $error = "Erreur lors du téléchargement de l'image.";
            }
        } else {
            $error = "Type de fichier non valide. Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
        }
    }

    // Create an updated event instance
    $updatedEvenement = new Evenement(
        $id,
        $titre,
        $description,
        $date_debut,
        $date_fin,
        $statut,
        $nombre_participants,
        $imagePath // Pass the image path
    );

    // Try to update the event in the database
    try {
        $controller->updateEvenement($updatedEvenement);
        header("Location: BackOfficeDashboard.php?section=events");  // Redirect after successful update
        exit;
    } catch (Exception $e) {
        $error = "Erreur lors de la mise à jour : " . $e->getMessage();
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

// Extract the date part (YYYY-MM-DD) from the datetime values
$date_debut = isset($evenement['date_debut']) ? date('Y-m-d', strtotime($evenement['date_debut'])) : '';
$date_fin = isset($evenement['date_fin']) ? date('Y-m-d', strtotime($evenement['date_fin'])) : '';
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'événement</title>
    <link rel="stylesheet" href="form.css"> <!-- Fichier CSS pour le style -->
</head>
<body>


<!-- Display errors if there are any -->
<?php if (isset($error)): ?>
    <div class="error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<!-- Form to update the event -->
<form method="POST" action="" enctype="multipart/form-data"> <!-- Add enctype for file upload -->
    <h2>Modifier l'événement</h2>

    <!-- Hidden input to store the event ID -->
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($evenement['id']); ?>">

    <label for="titre">Titre:</label>
    <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($evenement['titre']); ?>" required>

    <label for="date_debut">Date début:</label>
    <input type="date" id="date_debut" name="date_debut" value="<?php echo htmlspecialchars($date_debut); ?>" required>

    <label for="date_fin">Date fin:</label>
    <input type="date" id="date_fin" name="date_fin" value="<?php echo htmlspecialchars($date_fin); ?>" required>

    <label for="statut">Statut:</label>
    <select id="statut" name="statut" required>
        <option value="actif" <?php echo $evenement['statut'] == 'actif' ? 'selected' : ''; ?>>Actif</option>
        <option value="inactif" <?php echo $evenement['statut'] == 'inactif' ? 'selected' : ''; ?>>Inactif</option>
    </select>

    <label for="nombre_participants">Nombre de participants:</label>
    <input type="number" id="nombre_participants" name="nombre_participants" value="<?php echo htmlspecialchars($evenement['nombreParticipants']); ?>" required>

    <label for="description">Description:</label>
    <textarea name="description" id="description" rows="4" cols="50" required><?php echo htmlspecialchars($evenement['description']); ?></textarea>

    <!-- Image preview and file input -->
    <label for="image">Image:</label>
    <div>
        <?php if (!empty($evenement['image'])): ?>
            <img src="<?php echo htmlspecialchars($evenement['image']); ?>" alt="Image de l'événement" style="width: 100px; height: auto;">
        <?php else: ?>
            <p>Aucune image disponible</p>
        <?php endif; ?>
    </div>
    <input type="file" id="image" name="image" accept="image/*"> <!-- File input for image -->
    <p>Si aucune image n'est sélectionnée, l'image actuelle sera conservée.</p>

    <button type="submit">Mettre à jour</button>
    <button onclick="window.location.href='BackOfficeDashboard.php?section=events'">Retour à la liste des événements</button>
</form>
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

