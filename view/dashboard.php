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
        <a href="dash.php">Evenements</a>

        <a href="#" onclick="showSection('parts')">Participants</a>
        


        <a href="#" >Articles</a>
        <a href="#" >Messages</a>

        <a href="#">Log Out</a>
    </div>
      <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <h1>liste de participants</h1>

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
        <h3>Liste des participants</h3>
<?php
    include '../controller/formC.php';
    $formC= new portes();
    $forms=$formC->listform();
?>

<table border="1">
    <thead>
        <tr>
            <th>Nom et Prénom</th>
            <th>Âge</th>
            <th>Num</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($forms as $form) { ?>
        <tr>
            <td><?php echo htmlspecialchars($form['nom']) . ' ' . htmlspecialchars($form['prenom']); ?></td>
            <td><?php echo htmlspecialchars($form['age']); ?></td>
            <td><?php echo htmlspecialchars($form['num']); ?></td>
            <td>
                
                <a href="delete.php?action=supprimer&id=<?php echo $form['id']; ?>">Supprimer</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
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
        
    else if (section === 'parts') {
        document.getElementById('partsSection').classList.add('active'); // Ajoutez ceci
    }
        }
</script>
</body>


<?php
// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=your_database_name", "username", "password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}

// Récupérer les participants
$stmt = $pdo->query("SELECT id, nom, prenom, age, date_inscription, statut FROM participants");
$participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gérer les actions (Approuver, Refuser, Supprimer)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'approuver') {
        // Approuver l'inscription
        $stmt = $pdo->prepare("UPDATE participants SET statut = 'Approuvé' WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo "Inscription approuvée!";
    } elseif ($action == 'refuser') {
        // Refuser l'inscription
        $stmt = $pdo->prepare("UPDATE participants SET statut = 'Refusé' WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo "Inscription refusée!";
    } elseif ($action == 'supprimer') {
        // Supprimer l'inscription
        $stmt = $pdo->prepare("DELETE FROM participants WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo "Inscription supprimée!";
    }
}

// Vous pouvez rediriger ou recharger la page pour éviter de répéter les actions
header("Location: dashboard.php"); // Exemple de redirection vers le tableau des participants
exit;
?>

