<?php
include '../controller/usercontroller.php';

// Instancier le contrôleur
$controller = new UserController();

// Récupérer tous les utilisateurs
$users = $controller->listUsers();
?>

<h1>User List</h1>

<!-- Afficher les utilisateurs dans un tableau -->
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th> <!-- Cette colonne est pour les actions (modifier ou supprimer) -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td>
                    <!-- Liens pour modifier ou supprimer l'utilisateur -->
                    <a href="edit.php?id=<?php echo $user['id']; ?>">Edit</a> |
                    <a href="../controller/delete.php?email=<?php echo urlencode($user['email']); ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Lien pour créer un nouvel utilisateur -->
<a href="create.php">Create New User</a>


