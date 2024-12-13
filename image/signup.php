<?php
// Inclure la logique de création d'utilisateur
include_once './signup.php';
include '../controller/usercontroller.php';

$errors = []; // Tableau pour stocker les erreurs
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');
    $role = $_POST['role'] ?? 'normal'; // Le rôle par défaut est 'normal'

    // Validation des champs
    if (empty($firstname)) {
        $errors[] = "First Name is required.";
    }
    if (empty($lastname)) {
        $errors[] = "Last Name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Vérifier que l'email est valide
        $errors[] = "Invalid email format. Email must contain '@'.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 8) { // Vérifier la longueur du mot de passe
        $errors[] = "Password must be at least 8 characters long.";
    }
    if ($password !== $confirm_password) { // Vérifier si les mots de passe correspondent
        $errors[] = "Passwords do not match.";
    }
    if (empty($role)) {
        $errors[] = "Role is required.";
    }

    // Si aucune erreur, on tente de créer l'utilisateur dans la base de données
    if (empty($errors)) {
        // Créer une instance du contrôleur UserController
        $controller = new UserController();  // Crée une instance du contrôleur
        
        // Appeler la méthode createUser pour créer l'utilisateur
        $result = $controller->createUser($firstname, $lastname, $email, $role, $password);

        if ($result) {
            $success = true;
        } else {
            $errors[] = "Failed to create user. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .notification {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .signup-container {
            padding: 20px;
            width: 350px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.911);
            border-radius: 55px;
            margin: 5%; 
            box-shadow: 11px 11px 0px 0px rgb(4, 4, 4);
            outline: 1px solid rgb(1, 1, 1);
            transition: box-shadow 0.3s ease; 
        }
        .signup-container:hover {
            box-shadow: 20px 20px 0px 0px rgb(127, 195, 98); /* Black box-shadow on hover */
        }
        .signup-container h2 {
            margin-bottom: 20px;
        }
        .signup-container input, .signup-container select {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .signup-container button {
            width: 70%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 37px;
            cursor: pointer;
        }
        .signup-container button:hover {
            background-color: #45a049;
        }
        .signup-container p {
            margin-top: 10px;
        }
        .signup-container p a {
            text-decoration: none;
            color: #4CAF50;
        }
    </style>
</head>
<body>

    <?php if ($success): ?>
        <div class="notification">Félicitations, votre compte a été bien créé.</div>
    <?php endif; ?>

    <div class="signup-container">
        <h2>Sign Up</h2>
        
        <!-- Afficher les erreurs -->
        <?php if (!empty($errors)): ?>
            <div style="color: red;">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Formulaire d'inscription -->
        <form method="POST">
            <!-- Prénom -->
            <input type="text" name="firstname" placeholder="First Name" required><br>

            <!-- Nom de famille -->
            <input type="text" name="lastname" placeholder="Last Name" required><br>

            <!-- Email -->
            <input type="email" name="email" placeholder="Email" required><br>

            <!-- Mot de passe -->
            <input type="password" name="password" placeholder="Password (at least 8 characters)" required><br>

            <!-- Confirmation du mot de passe -->
            <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>

            <!-- Sélection du rôle -->
            <select name="role" required>
                <option value="normal">Normal</option>
                <option value="admin">Admin</option>
            </select><br>

            <!-- Bouton d'inscription -->
            <button type="submit">Sign Up</button>
        </form>

        <p>Already have an account? <a href="/login.html">Login here</a></p>
    </div>

</body>
</html>
