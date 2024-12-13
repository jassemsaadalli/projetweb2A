<?php
include '../controller/usercontroller.php';

// Initialiser le contrôleur
$controller = new UserController();

$errors = []; // Stocker les erreurs de validation
$firstname = $lastname = $email = $role = $password = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validation des champs
    if (empty($firstname)) {
        $errors[] = "Firstname is required.";
    }
    if (empty($lastname)) {
        $errors[] = "Lastname is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($role)) {
        $errors[] = "Role is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // Si aucune erreur, créer l'utilisateur
    if (empty($errors)) {
        // Appeler la méthode createUser du contrôleur
        $result = $controller->createUser($firstname, $lastname, $email, $role, $password);

        if ($result) {
            header("Location: list.php"); // Rediriger vers la liste des utilisateurs
            exit();
        } else {
            $errors[] = "Error: Could not create the user. Please try again.";
        }
    }
}
?>

<h1>Create User</h1>

<!-- Afficher les erreurs -->
<?php if (!empty($errors)) : ?>
    <div style="color: red;">
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Formulaire pour créer un utilisateur -->
<form method="POST">
    <input type="text" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>" placeholder="Firstname">
    <input type="text" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" placeholder="Lastname">
    <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Email">
    <input type="password" name="password" placeholder="Password (min. 8 characters)">
    <select name="role">
        <option value="admin" <?php echo ($role === 'admin') ? 'selected' : ''; ?>>Admin</option>
        <option value="normal" <?php echo ($role === 'normal') ? 'selected' : ''; ?>>Normal</option>
    </select>
    <button type="submit">Create</button>
</form>
