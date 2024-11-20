<?php
include '../controller/formC.php';
$error = "";
$form = null;
$formcontroller = new portes();

if (
    isset($_POST["nom"], $_POST["prenom"], $_POST["age"], $_POST["num"]) &&
    !empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["age"]) && !empty($_POST["num"])
) {
    // Password match validation
    
        // Create new inscrit instance
        $form = new form(
            null,
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['age'],
            $_POST['num']
        );

        // Add to the database
        try {
            $formcontroller->addform($form);
            header("Location:dashboard.php");
        } catch (Exception $e) {
            $error = "Error during registration: " . $e->getMessage();
        }
    
}

// Display error if any
if (!empty($error)) {
    echo "<div class='error'>$error</div>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../view/evennement.css">
    <title>Document</title>
</head>
<body>
    <form class="form-container" action="" method="post" >
        <h2>Formulaire de Participation</h2>
        <label for="name">Nom:</label>
        <input type="text" id="nom" name="nom" required>
        <label for="surname">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required>
        <label for="age">Âge:</label>
        <input type="number" id="age" name="age" required>
        <label for="phone">Numéro de Téléphone:</label>
        <input type="tel" id="num" name="num" required>
        <button type="submit">Soumettre</button>
        <button type="button" class="btn-cancel">Annuler</button>
    </form> 
</body>
</html>