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
        <a href="#" onclick="showSection('events')">Événements</a>
        <a href="dashboard.php" onclick="showSection('parts')">Participants</a>


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

        <div class="dashboard-section" id="eventsSection">
    <h3>Liste des événements</h3>
    <?php
    require_once('../config.php');  // Inclure le fichier de connexion

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
    else if (section === 'events') {
        document.getElementById('eventsSection').classList.add('active'); // Ajoutez ceci
    }
        }
    </script>

</body>

</html>
