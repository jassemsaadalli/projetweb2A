<?php
require_once('C:/xampp/htdocs/PROJETWEB EVENT/config.php');
require_once('../config.php');  // Inclure le fichier de connexion


// Vérifiez si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifiez si toutes les clés sont présentes dans $_POST
    if (isset($_POST['titre'], $_POST['date_debut'], $_POST['date_fin'], $_POST['nombre_participants'], $_POST['statut'])) {
        // Récupérer les données du formulaire
        $titre = $_POST['titre'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];  // Vous n'aviez pas cette variable, mais elle est nécessaire
        $nombre_participants = $_POST['nombre_participants'];
        $statut = $_POST['statut'];

        try {
            // Connexion à la base de données
            $pdo = Config::getConnection();  // Utilisez votre méthode pour obtenir la connexion

            // Préparer la requête SQL pour insérer un nouvel événement
            $query = "INSERT INTO evenements (titre, date_debut, date_fin, nombre_participants, statut) 
                      VALUES (:titre, :date_debut, :date_fin, :nombre_participants, :statut)";
            
            // Préparer la requête
            $stmt = $pdo->prepare($query);

            // Lier les paramètres
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':date_debut', $date_debut);
            $stmt->bindParam(':date_fin', $date_fin);  // Ajoutez cette liaison pour la date de fin
            $stmt->bindParam(':nombre_participants', $nombre_participants);
            $stmt->bindParam(':statut', $statut);

            // Exécuter la requête
            if ($stmt->execute()) {
                echo "Événement ajouté avec succès !";
                header('Location:dash.php');
            } else {
                echo "Erreur lors de l'ajout de l'événement.";
            }
        } catch (PDOException $e) {
            // Gérer les erreurs de connexion à la base de données
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
    } else {
        echo "Tous les champs doivent être remplis.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            background-color: #f4f4f4;
        }

        
        .sidebar {
            height: 100%;
            width: 18vw;
            background-color: #4CAF50;
            position: fixed;
            top: 0;
            left: -250px;
            transition: 0.3s;
            padding-top: 65px;
            display: flex;
            flex-direction: column;
            padding-left: 15px;
        }

        .sidebar.open {
            left: 0;
        }

      

        .sidebar a {
            display: block;
            padding: 15px;
            text-decoration: none;
            color: white;
            font-size: 18px;
            margin-bottom: 10px;
            border-radius: 10px;
            width: 70%;
            text-align: left;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #3e7252;
        }

        
        .main-content {
            margin-left: 0;
            padding: 30px;
            width: 100%;
            transition: margin-left 0.3s;
        }

        .main-content.open {
            margin-left: 250px;
        }

        .main-content h1 {
            color: #4CAF50;
        }

        .dashboard-section {
            display: none;
            margin-top: 30px;
        }

        .dashboard-section ul {
            list-style-type: none;
            padding-left: 0;
        }

        .dashboard-section ul li {
            padding: 10px;
            background-color: #f9f9f9;
            margin-bottom: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-section ul li button {
            padding: 5px 10px;
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .dashboard-section ul li button:hover {
            background-color: #e60000;
        }

        /* Toggle Visibility */
        .dashboard-section.active {
            display: block;
        }

        /* Button to toggle sidebar */
        .open-dashboard-btn {
            padding: 10px 20px;
            cursor: pointer;
            background-color: #386f4d;
            color: white;
            border: none;
            border-radius: 25px;
            transition: background-color 0.3s;
            width: 65px;
            margin: 10px;
            height: 50px;
            z-index: 999;
        }

        .open-dashboard-btn:hover {
            background-color: #5dde59;
        }

        .dashboard-section table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.dashboard-section table thead {
    background-color: #4CAF50; /* Vert pour l'en-tête */
    color: white;
    text-align: left;
}

.dashboard-section table th,
.dashboard-section table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.dashboard-section table tbody tr:hover {
    background-color: #f1f1f1;
}

.dashboard-section table td {
    vertical-align: middle;
}

.dashboard-section table td a {
    display: inline-block;
    margin-right: 10px; /* Espacement entre les boutons */
    padding: 8px 15px;
    text-decoration: none;
    color: white;
    background-color: #ff4d4d; /* Rouge pour les boutons */
    border-radius: 5px;
    transition: background-color 0.3s;
}

.dashboard-section table td a:hover {
    background-color: #e60000;
}

.dashboard-section .add-event-btn {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #007BFF; /* Bleu pour le bouton "Ajouter un événement" */
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s;
}

.dashboard-section .add-event-btn:hover {
    background-color: #0056b3;
}

.dashboard-section h3 {
    margin-bottom: 20px; /* Espacement sous le titre */
    color: #4CAF50; /* Vert pour les titres */
    font-size: 24px;
    font-weight: bold;
}

<style>
    /* Form Styles */
    form {
        background-color: #fff; /* White background */
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Add shadow for a clean look */
        margin-top: 20px;
        width: 60%; /* Center it */
        margin-left: auto;
        margin-right: auto;
    }

    form label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #4CAF50; /* Green for labels */
    }

    form input[type="text"],
    form input[type="date"],
    form input[type="number"],
    form select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
    }

    form button[type="submit"] {
        background-color: #007BFF; /* Blue for the submit button */
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    form button[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>


    </style>
</head>
<body>

    <!-- Button to toggle sidebar -->
    <button onclick="toggleSidebar()" class="open-dashboard-btn">
        ☰
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
       
        <a href="#" onclick="showSection('users')">Users</a>
        <a href="#" onclick="showSection('products')">Products</a>
        <a href="dash.php" onclick="showSection('events')">Événements</a>

        <a href="#" >Articles</a>
        <a href="#" >Messages</a>

        <a href="#">Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <h1>Welcome to Your Dashboard</h1>

        <!-- Display Lists of Users and Products -->
        <div class="dashboard-section" id="usersSection">
            <h3>All Users</h3>
            <ul>
                <li>
                    John Doe
                    <div>
                        <button>Delete</button>
                        <button>Update</button>
                    </div>
                </li>
                <li>
                    Jane Smith
                    <div>
                        <button>Delete</button>
                        <button>Update</button>
                    </div>
                </li>
            </ul>
        </div>
<!-- Formulaire HTML pour l'ajout d'événement -->
<form method="POST" action="">
    <label for="titre">Titre de l'événement :</label>
    <input type="text" name="titre" id="titre" required>

    <label for="date_debut">Date de début :</label>
    <input type="date" name="date_debut" id="date_debut" required>

    <label for="date_fin">Date de fin :</label>
    <input type="date" name="date_fin" id="date_fin" required>

    <label for="nombre_participants">Nombre de participants :</label>
    <input type="number" name="nombre_participants" id="nombre_participants" required>

    <label for="statut">Statut :</label>
    <select name="statut" id="statut" required>
        <option value="actif">Actif</option>
        <option value="inactif">Inactif</option>
    </select>

    <button type="submit">Ajouter l'événement</button>
</form>

        <div class="dashboard-section" id="eventsSection">
    <h3>Liste des événements</h3>
    <?php

    // Connexion à la base de données
    $pdo = config::getConnection();

    // Requête pour récupérer les événements
    $query = "SELECT id, titre, date_debut, date_fin, nombre_participants, statut FROM evenements";
    $stmt = $pdo->query($query);

    // Récupérer les résultats
    $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <table border="1">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Date de début</th>
                <th>Date de Fin </th>
                <th>Nombre de participants</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($evenements): ?>
                <?php foreach ($evenements as $evenement): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($evenement['titre']); ?></td>
                        <td><?php echo htmlspecialchars($evenement['date_debut']); ?></td>
                        <td><?php echo htmlspecialchars($evenement['date_fin']); ?></td>
                        <td><?php echo htmlspecialchars($evenement['nombre_participants']); ?></td>
                        <td><?php echo htmlspecialchars($evenement['statut']); ?></td>
                        <td>
                            <a href="supprimer.php?action=supprimer&id=<?php echo $evenement['id']; ?>">Supprimer</a>
                            <a href="modifier.php?action=modifier&id=<?php echo $evenement['id']; ?>">Modifier</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Aucun événement trouvé</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="ajouter.php" class="add-event-btn">Ajouter un nouvel événement</a>
</div>


        <div class="dashboard-section" id="productsSection">
            <h3>All Products</h3>
            <ul>
                <li>
                    Product A - $50
                    <div>
                        <button>Delete</button>
                        <button>Update</button>
                    </div>
                </li>
                <li>
                    Product B - $80
                    <div>
                        <button>Delete</button>
                        <button>Update</button>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <script>
        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('open');
            mainContent.classList.toggle('open');
        }

        // Show section (Users or Products)
        function showSection(section) {
            document.getElementById('usersSection').classList.remove('active');
            document.getElementById('productsSection').classList.remove('active');
            if (section === 'users') {
                document.getElementById('usersSection').classList.add('active');
            } else if (section === 'products') {
                document.getElementById('productsSection').classList.add('active');
                
            }
         else if (section === 'events') {
        document.getElementById('eventsSection').classList.add('active'); // Ajoutez ceci
    }
        }
    </script>

</body>

</html>


