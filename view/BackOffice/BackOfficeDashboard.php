<?php
require_once('../../config.php'); 
require_once('../../controller/EvenementController.php');  
require_once('../../controller/participationC.php');
$sectionToShow = isset($_GET['section']) ? $_GET['section'] : ''; 


// Instancier le contrôleur
$evenementController = new EvenementController();
$evenements = $evenementController->listevenement();


$participationController = new ParticipationC();
$pendingParticipations = $participationController->getPendingParticipations();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css?v=1.0">
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
        <a href="#" onclick="showSection('participations')">Participations</a> 
        <a href="#">Articles</a>
        <a href="#">Messages</a>
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

        <div class="dashboard-section" id="participationsSection">
    <h3>Participations en Attente</h3>
    <input type="text" id="participationSearch" class="search-bar" placeholder="Rechercher dans les participations..." onkeyup="filterTable('participationsTable', 'participationSearch')">

    <!-- Sort Button and Dropdown -->
    <button id="sortButton" onclick="toggleSortDropdown()">Sort</button>
    <div id="sortDropdown" class="dropdown-content">
        <h4>Sort By</h4>
        <select id="sortField">
            <option value="event_title">Titre</option>
            <option value="user_email">Email</option>
            <option value="registration_date">Date d'inscription</option>
            <option value="status">Status</option>
        </select>
        <h4>Order</h4>
        <select id="sortOrder">
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select>
        <button onclick="applySort()">Apply Sort</button>
    </div>

    <table id="participationsTable" border="1">
        <thead>
            <tr>
                <th data-field="event_title">Titre d'évènement</th>
                <th data-field="user_email">Email</th>
                <th data-field="registration_date">Date d'inscription</th>
                <th data-field="status">Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($pendingParticipations): ?>
                <?php foreach ($pendingParticipations as $participation): ?>
                    <tr>
                        <td data-field="event_title"><?php echo htmlspecialchars($participation['event_title']); ?></td>
                        <td data-field="user_email"><?php echo htmlspecialchars($participation['user_email']); ?></td>
                        <td data-field="registration_date"><?php echo htmlspecialchars($participation['registration_date']); ?></td>
                        <td data-field="status"><?php echo htmlspecialchars($participation['status']); ?></td>
                        <td>
                            <a href="acceptParticipation.php?id=<?php echo $participation['id']; ?>">Accepter</a>
                            <a href="declineParticipation.php?id=<?php echo $participation['id']; ?>">Refuser</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucune participation en attente</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

        <div class="dashboard-section" id="eventsSection">
            <h3>Liste des événements</h3>
        <input type="text" id="eventSearch" class="search-bar" placeholder="Rechercher dans les événements..." onkeyup="filterTable('eventsTable', 'eventSearch')">
        <!-- Sort Button and Dropdown -->
    <button id="sortButton" onclick="toggleSortDropdown2()">Sort</button>
    <div id="sortDropdown2" class="dropdown-content">
        <h4>Sort By</h4>
        <select id="sortFields">
            <option value="event_title">Titre</option>
            <option value="event_description">Description</option>
            <option value="date_debut">Date de début</option>
            <option value="date_fin">Date de Fin</option>
            <option value="nombre_ps">Nombre de participants</option>
            <option value="statut">Statut</option>

        </select>
        <h4>Order</h4>
        <select id="sortOrders">
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select>
        <button onclick="applySortEvents()">Apply Sort</button>
    </div>
        <table id="eventsTable" border="1">
        <thead>
    <tr>
        <th>Image</th> <!-- New column for image -->
        <th data-fields="event_title">Titre</th>
        <th data-fields="event_description">Description</th>
        <th data-fields="date_debut">Date de début</th>
        <th data-fields="date_fin">Date de Fin</th>
        <th data-fields="nombre_ps">Nombre de participants</th>
        <th data-fields="statut">Statut</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    <?php if ($evenements): ?>
        <?php foreach ($evenements as $evenement): ?>
            <tr>
                <td>
                    <img src="<?php echo htmlspecialchars($evenement['image'] ?: '../../uploads/default-placeholder.png'); ?>" 
                    alt="Image de l'événement" style="width: 100px; height: auto;"> 
                </td>
                <td data-fields="event_title"><?php echo htmlspecialchars($evenement['titre']); ?></td>
                <td data-fields="event_description"><?php echo htmlspecialchars($evenement['description']); ?></td>
                <td data-fields="date_debut"><?php echo htmlspecialchars($evenement['date_debut']); ?></td>
                <td data-fields="date_fin"><?php echo htmlspecialchars($evenement['date_fin']); ?></td>
                <td data-fields="nombre_ps"><?php echo htmlspecialchars($evenement['nombreParticipants']); ?></td>
                <td data-fields="statut"><?php echo htmlspecialchars($evenement['statut']); ?></td>
                <td>
                    <a href="DeleteEvent.php?action=supprimer&id=<?php echo $evenement['id']; ?>">Supprimer</a>
                    <a href="updateEvent.php?action=modifier&id=<?php echo $evenement['id']; ?>">Modifier</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8">Aucun événement trouvé</td> <!-- Updated colspan to match new column count -->
        </tr>
    <?php endif; ?>
</tbody>

            </table>
            <a href="AddEvent.php">Ajouter un nouvel événement</a>
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

        // Show section (Users, Products, or Events)
        function showSection(section) {
            document.getElementById('usersSection').classList.remove('active');
            document.getElementById('productsSection').classList.remove('active');
            document.getElementById('eventsSection').classList.remove('active'); 
            document.getElementById('participationsSection').classList.remove('active'); // Hide participations section

            if (section === 'users') {
                document.getElementById('usersSection').classList.add('active');
            } else if (section === 'products') {
                document.getElementById('productsSection').classList.add('active');
            } else if (section === 'events') {
                document.getElementById('eventsSection').classList.add('active'); // Show events section
            } else if (section === 'participations') {
                document.getElementById('participationsSection').classList.add('active'); // Show participations section
    }
            
        }
        function filterTable(tableId, inputId) {
        const input = document.getElementById(inputId).value.toLowerCase();
        const table = document.getElementById(tableId);
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) { // Skip the header row
            let cells = rows[i].getElementsByTagName('td');
            let match = false;

            for (let cell of cells) {
                if (cell.textContent.toLowerCase().includes(input)) {
                    match = true;
                    break;
                }
            }

            rows[i].style.display = match ? '' : 'none';
        }
        }
      // Toggle the visibility of the dropdown
function toggleSortDropdown() {
    const dropdown = document.getElementById("sortDropdown");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
}
function toggleSortDropdown2() {
    const dropdown = document.getElementById("sortDropdown2");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
}

function applySort() {
    const field = document.getElementById("sortField").value; // Selected field
    const order = document.getElementById("sortOrder").value; // Selected order (asc/desc)
    const table = document.getElementById('participationsTable');
    const rows = Array.from(table.querySelectorAll('tbody > tr')); // Skip header row

    if (!field || !order) {
        console.error("Invalid field or order selected.");
        return;
    }

    // Log for debugging
    console.log(`Sorting by field: ${field}, order: ${order}`);
    console.log("Rows before sorting:", rows);

    // Sort rows
    rows.sort((rowA, rowB) => {
        const cellA = rowA.querySelector(`[data-field="${field}"]`)?.innerText.trim() || "";
        const cellB = rowB.querySelector(`[data-field="${field}"]`)?.innerText.trim() || "";

        console.log(`Comparing "${cellA}" and "${cellB}"`);

        // Handle numeric sorting
        if (!isNaN(cellA) && !isNaN(cellB)) {
            return order === "asc"
                ? parseFloat(cellA) - parseFloat(cellB)
                : parseFloat(cellB) - parseFloat(cellA);
        }

        // Handle string sorting
        return order === "asc"
            ? cellA.localeCompare(cellB)
            : cellB.localeCompare(cellA);
    });

    // Reattach sorted rows to the table
    const tbody = table.querySelector('tbody');
    rows.forEach(row => tbody.appendChild(row));

    // Log for debugging
    console.log("Rows after sorting:", rows);

    // Hide the dropdown after sorting
    document.getElementById("sortDropdown").style.display = "none";
}






function applySortEvents() {
    const field = document.getElementById("sortFields").value; // Selected field
    const order = document.getElementById("sortOrders").value; // Selected order (asc/desc)
    const table = document.getElementById('eventsTable');
    const rows = Array.from(table.querySelectorAll('tbody > tr')); // Skip header row

    if (!field || !order) {
        console.error("Invalid field or order selected.");
        return;
    }

    // Log for debugging
    console.log(`Sorting by field: ${field}, order: ${order}`);
    console.log("Rows before sorting:", rows);

    // Sort rows
    rows.sort((rowA, rowB) => {
        const cellA = rowA.querySelector(`[data-fields="${field}"]`)?.innerText.trim() || "";
        const cellB = rowB.querySelector(`[data-fields="${field}"]`)?.innerText.trim() || "";

        console.log(`Comparing "${cellA}" and "${cellB}"`);

        // Handle numeric sorting
        if (!isNaN(cellA) && !isNaN(cellB)) {
            return order === "asc"
                ? parseFloat(cellA) - parseFloat(cellB)
                : parseFloat(cellB) - parseFloat(cellA);
        }

        // Handle string sorting
        return order === "asc"
            ? cellA.localeCompare(cellB)
            : cellB.localeCompare(cellA);
    });

    // Reattach sorted rows to the table
    const tbody = table.querySelector('tbody');
    rows.forEach(row => tbody.appendChild(row));

    // Log for debugging
    console.log("Rows after sorting:", rows);

    // Hide the dropdown after sorting
    document.getElementById("sortDropdown2").style.display = "none";
}

        <?php if ($sectionToShow == 'events'): ?>
        showSection('events');
        <?php elseif ($sectionToShow == 'participations'): ?>
        showSection('participations');
        <?php endif; ?>

    </script>

</body>
</html>
