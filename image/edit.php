<?php
include '../controller/usercontroller.php';

// Vérifiez si l'ID est fourni dans l'URL
if (!isset($_GET['id'])) {
    die("Error: ID is not detected.");
}

$id = $_GET['id'];

// Instanciez le contrôleur
$controller = new UserController();

// Récupérez les données de l'utilisateur
$user = $controller->GET($id);
if (!$user) {
    die("Error: User not found with ID $id.");
}

// Initialisez les variables avec les données existantes
$firstname = $user['firstname'];
$lastname = $user['lastname'];
$email = $user['email'];
$role = $user['role'];
$password = ""; // Ne chargez jamais le mot de passe existant pour des raisons de sécurité

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérez les données du formulaire
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $password = trim($_POST['password']);

    // Validation des champs
    if (empty($firstname)) {
        $errors[] = "Firstname is required and cannot be empty.";
    }

    if (empty($lastname)) {
        $errors[] = "Lastname is required and cannot be empty.";
    }

    if (empty($email)) {
        $errors[] = "Email is required and cannot be empty.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format. An email must contain '@'.";
    }

    if (empty($role)) {
        $errors[] = "Role is required and cannot be empty.";
    }

    if (empty($password)) {
        $errors[] = "Password is required and cannot be empty.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // Si aucune erreur, procédez à la mise à jour
    if (empty($errors)) {
        // Hachez le nouveau mot de passe
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Mettez à jour l'utilisateur
        if ($controller->updateUser($id, $firstname, $lastname, $email, $role, $password)) {
            header("Location: list.php");
            exit();
        } else {
            $errors[] = "Error: Could not update the user.";
        }
    }
}

// Affichez les erreurs, le cas échéant
if (!empty($errors)) {
    echo "<div style='color: red;'><ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul></div>";
}
?>

<!-- Formulaire pour mettre à jour l'utilisateur -->
<h1>Update User</h1>
<form method="POST">
    <input type="text" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>" placeholder="Firstname">
    <input type="text" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" placeholder="Lastname">
    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Email">
    <input type="password" name="password" placeholder="Password (At least 8 characters)">
    
    <select name="role">
        <option value="admin" <?php echo ($role === 'admin') ? 'selected' : ''; ?>>Admin</option>
        <option value="normal" <?php echo ($role === 'normal') ? 'selected' : ''; ?>>Normal</option>
    </select>
    
    <button type="submit">Update</button>
</form>
