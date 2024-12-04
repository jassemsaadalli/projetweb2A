<?php
require_once '../../config.php';
require_once '../../controller/userC.php';
require_once '../../controller/participationC.php';

$event_id = isset($_GET['event_id']) ? (int)$_GET['event_id'] : null;

// Check if event_id is valid
if (!$event_id) {
    echo "Invalid event ID.";
    exit;
}

// Initialize errors array
$errors = [
    'user_id' => '',
    'email' => '',
];

$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for empty fields
    if (empty($user_id)) {
        $errors['user_id'] = 'Le champ ID utilisateur est obligatoire.';
    } elseif (!is_numeric($user_id) || $user_id <= 0) {
        // Validate user ID
        $errors['user_id'] = 'L\'ID utilisateur doit être un nombre entier positif.';
    }

    if (empty($email)) {
        $errors['email'] = 'Le champ Email utilisateur est obligatoire.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Validate email format
        $errors['email'] = 'Veuillez entrer un email valide.';
    }

    // If no errors, proceed
    if (empty(array_filter($errors))) {
        $db = config::getConnection();
        $userController = new UserController();
        $user = $userController->getUserByIdAndEmail($db, $user_id, $email);

        if ($user) {
            $participationController = new ParticipationC();
            $participationController->registerForEvent($user_id, $event_id);

            echo "<script>
                    setTimeout(() => {
                        window.location.href = 'FrontEvent.php';
                    }, 2000);
                  </script>";
        } else {
            $errors['email'] = 'Utilisateur non trouvé ou email incorrect.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulaire de Participation</title>
  <link rel="stylesheet" href="front.css">
  <link rel="stylesheet" href="../BackOffice/form.css">
  <style>
    .error-message {
        color: red;
        font-size: 0.9em;
        margin-top: 5px;
    }
    .form-group {
        margin-bottom: 15px;
    }
  </style>
</head>
<body>

  <form method="POST" action="">
    <h2>Formulaire de Participation</h2>

    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>">

    <div class="form-group">
        <label for="user_id">ID Utilisateur:</label>
        <input type="number" name="user_id" id="user_id" value="<?php echo htmlspecialchars($user_id ?? ''); ?>">
        <?php if (!empty($errors['user_id'])): ?>
            <div class="error-message"><?php echo $errors['user_id']; ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="email">Email Utilisateur:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email ?? ''); ?>">
        <?php if (!empty($errors['email'])): ?>
            <div class="error-message"><?php echo $errors['email']; ?></div>
        <?php endif; ?>
    </div>

    <button type="submit">Participer</button>
  </form>

</body>
</html>
