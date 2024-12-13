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

        .pagination {
            margin-top: 20px;
        }

        .pagination a {
            padding: 5px 10px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            margin: 0 5px;
            border-radius: 5px;
        }

        .pagination a:hover {
            background-color: #3e7252;
        }

        .pagination a[style="font-weight: bold;"] {
            background-color: #388e3c;
        }

        /* Styles for the chart */
        #userChart {
            max-width: 500px;
            margin: 20px auto;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .search-bar input {
            padding: 8px;
            width: 300px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

    </style>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <a href="#">Articles</a>
        <a href="#">Messages</a>
        <a href="#">Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <h1>Welcome to Your Dashboard</h1>

        <!-- Display Lists of Users and Products -->
        <div class="dashboard-section" id="usersSection">
            <?php
            include '../controller/usercontroller.php';

            // Instancier le contrôleur
            $controller = new UserController();

            // Récupérer tous les utilisateurs
            $users = $controller->listUsers();

            // Tri des utilisateurs par prénom (firstname)
            usort($users, function ($a, $b) {
                return strcmp(strtolower($a['firstname']), strtolower($b['firstname']));
            });

            // Pagination
            $usersPerPage = 5; // Nombre d'utilisateurs par page
            $totalUsers = count($users); // Nombre total d'utilisateurs
            $totalPages = ceil($totalUsers / $usersPerPage); // Nombre total de pages

            // Récupérer la page actuelle depuis l'URL, ou par défaut la page 1
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            if ($currentPage < 1) $currentPage = 1;
            if ($currentPage > $totalPages) $currentPage = $totalPages;

            // Calculer les utilisateurs à afficher pour la page actuelle
            $startIndex = ($currentPage - 1) * $usersPerPage;
            $usersToDisplay = array_slice($users, $startIndex, $usersPerPage);

            // Compter le nombre d'utilisateurs normaux et admin
            $normalCount = 0;
            $adminCount = 0;
            foreach ($users as $user) {
                if ($user['role'] === 'admin') {
                    $adminCount++;
                } else {
                    $normalCount++;
                }
            }
            ?>

            <h1>User List</h1>

            <!-- Search Bar -->
            <div class="search-bar">
                <input type="text" id="searchInput" onkeyup="searchUsers()" placeholder="Search for users..">
            </div>

            <!-- Button to download PDF -->
            <a href="download_pdf.php" target="_blank">
                <button>Download PDF</button>
            </a>

            <!-- Display users in a table -->
            <table border="1" id="userTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usersToDisplay as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                            <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $user['id']; ?>">Edit</a> |
                                <a href="../controller/delete.php?email=<?php echo urlencode($user['email']); ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Link to create a new user -->
            <a href="create.php">Create New User</a>

            <!-- Pagination -->
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" <?php if ($i == $currentPage) echo 'style="font-weight: bold;"'; ?>><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a href="?page=<?php echo $currentPage + 1; ?>">Next</a>
                <?php endif; ?>
            </div>

            <!-- Display statistics as a bar chart -->
            <div id="userChart">
                <canvas id="chart"></canvas>
            </div>
            <script>
                // Chart.js code to display the bar chart
                var ctx = document.getElementById('chart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Normal Accounts', 'Admin Accounts'],
                        datasets: [{
                            label: 'User Accounts',
                            data: [<?php echo $normalCount; ?>, <?php echo $adminCount; ?>],
                            backgroundColor: ['#4CAF50', '#FF5722'],
                            borderColor: ['#388E3C', '#E64A19'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Function to filter users based on search input (only starts with the letter)
                function searchUsers() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById('searchInput');
                    filter = input.value.toUpperCase();
                    table = document.getElementById('userTable');
                    tr = table.getElementsByTagName('tr');

                    for (i = 1; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName('td');
                        if (td) {
                            txtValue = td[1].textContent || td[1].innerText; // Filter by First Name
                            if (txtValue.toUpperCase().startsWith(filter)) { // Check if it starts with the input
                                tr[i].style.display = '';
                            } else {
                                tr[i].style.display = 'none';
                            }
                        }
                    }
                }
            </script>
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
        }
    </script>
</body>

</html>
