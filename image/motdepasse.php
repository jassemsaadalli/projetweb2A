<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Mot de Passe</title>
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
        .password-container {
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
        .password-container:hover {
            box-shadow: 20px 20px 0px 0px rgb(127, 195, 98);
        }
        .password-container h2 {
            margin-bottom: 20px;
        }
        .password-container input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .password-container button {
            width: 70%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 37px;
            cursor: pointer;
        }
        .password-container button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="password-container">
        <h2>Modifier le Mot de Passe</h2>
        <form action="modify_password.php" method="POST">
            <input type="password" name="new_password" placeholder="Nouveau mot de passe" required><br>
            <input type="password" name="confirm_password" placeholder="Confirmer le nouveau mot de passe" required><br>
            <button type="submit" name="submit">Modifier</button>
        </form>
    </div>

    <?php
    // Logique PHP pour la modification du mot de passe (facultatif)
    if (isset($_POST['submit'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Vérifier que les mots de passe correspondent
        if ($new_password === $confirm_password) {
            // Logique pour modifier le mot de passe dans la base de données (par exemple)
            echo "Mot de passe modifié avec succès.";
        } else {
            echo "Les mots de passe ne correspondent pas. Veuillez réessayer.";
        }
    }
    ?>

</body>
</html>
