<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
