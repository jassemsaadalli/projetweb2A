<?php
require_once '../../config.php'; // Adjust the path to your configuration file
require_once '../../controller/EvenementController.php'; // Include the file containing the controller class

$controller = new EvenementController(); // Replace with your controller class name
$events = $controller->listevenement();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Événements - BioVerte</title>
  <link rel="stylesheet" href="front.css">
</head>
<body>
  <!-- Header -->
  <header>
    <div class="top-bar">
      <p>LIVRAISON OFFERTE À PARTIR DE 75 € D'ACHAT.</p>
    </div>
    <div class="container header-content">
      <h1 class="logo">🌿 BioVerte</h1>
      <nav>
        <ul class="nav-links">
          <li><a href="Front.php">Acceuil</a></li>
          <li><a href="#">Produit</a></li>
          <li><a href="FrontEvent.php">Événement</a></li>
          <li><a href="reclamation.php">Réclamation</a></li>
          <li><a href="#">Formation</a></li>
        </ul>
      </nav>
    </div>
  </header>
  

  <!-- Main Section -->
   
  <section class="events-section">
  <div class="container">
    <h2 class="section-title">Nos Événements</h2>
    <!-- Search Bar -->
    <div class="search-container">
  <input type="text" id="search-input" placeholder="Rechercher un événement..." onkeyup="filterEvents()">
</div>
<p id="no-results" style="display: none;">Aucun résultat trouvé.</p>
    <div class="events-container">
      <?php if (!empty($events)): ?>
        <?php foreach ($events as $event): ?>
          <div class="event-card" 
          data-title="<?php echo htmlspecialchars($event['titre']); ?>" 
          data-description="<?php echo htmlspecialchars($event['description']); ?>" 
          data-date-debut="<?php echo htmlspecialchars($event['date_debut']); ?>" 
          data-date-fin="<?php echo htmlspecialchars($event['date_fin']); ?>" 
          data-participants="<?php echo htmlspecialchars($event['nombreParticipants']); ?>" 
          data-statut="<?php echo htmlspecialchars($event['statut']); ?>">
            <h3 class="event-title"><?php echo htmlspecialchars($event['titre']); ?></h3>
            <div class="event-body">
              <img 
                src="<?php echo htmlspecialchars($event['image'] ? '../BackOffice/' . $event['image'] : '../BackOffice/uploads/default-placeholder.png'); ?>" 
                alt="Image de l'événement" class="event-image">
              <div class="event-details">
                <p class="event-description"><strong>Description: </strong><?php echo htmlspecialchars($event['description']); ?></p>
                <div class="event-meta">
                  <p><strong>Date de début:</strong> <?php echo htmlspecialchars($event['date_debut']); ?></p>
                  <p><strong>Date de fin:</strong> <?php echo htmlspecialchars($event['date_fin']); ?></p>
                  <p><strong>Places disponibles:</strong> <?php echo htmlspecialchars($event['nombreParticipants']); ?></p>
                  <p><strong>Statut:</strong> <?php echo htmlspecialchars($event['statut']); ?></p>
                </div>
                <!-- Participer Button -->
                <form action="participation_form.php" method="GET">
                  <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event['id']); ?>">
                  <button type="submit" class="participer-button">Participer</button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Aucun événement trouvé.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

  <!-- Footer -->
  <footer>
    <div class="footer-links">
      <ul>
        <li><a href="#">Termes et conditions</a></li>
        <li><a href="#">Politique de confidentialité</a></li>
        <li><a href="#">Politique de livraison</a></li>
        <li><a href="#">Politique de remboursement</a></li>
      </ul>
      <ul>
        <li><a href="#">Politique de cookies</a></li>
        <li><a href="#">Mentions légales</a></li>
        <li><a href="#">FAQ</a></li>
        <li><a href="#">Moyens de paiement</a></li>
      </ul>
      <ul>
        <li><strong>Adresse :</strong></li>
        <li>47 rue des Couronnes,</li>
        <li>75020 Paris, France</li>
      </ul>
      <ul>
        <li><strong>Contact :</strong></li>
        <li>info@monsite.fr</li>
        <li>01 23 45 67 89</li>
      </ul>
    </div>
    <div class="social-icons">
      <a href="#"><img src="../../public/img/facebook.jpg" alt="Facebook"></a>
      <a href="#"><img src="../../public/img/instagram.jpg" alt="Instagram"></a>
      <a href="#"><img src="../../public/img/tiktok.jpg" alt="TikTok"></a>
    </div>
    <p>© 2035 par BioVerte.</p>
  </footer>
  <script>
  function filterEvents() {
    const input = document.getElementById('search-input').value.toLowerCase();
    const cards = document.querySelectorAll('.event-card');

    let hasVisibleCards = false;

    cards.forEach(card => {
      const searchableData = [
        card.getAttribute('data-title'),
        card.getAttribute('data-description'),
        card.getAttribute('data-date-debut'),
        card.getAttribute('data-date-fin'),
        card.getAttribute('data-participants'),
        card.getAttribute('data-statut')
      ].join(' ').toLowerCase();

      if (searchableData.includes(input)) {
        card.style.display = ''; 
        hasVisibleCards = true;
      } else {
        card.style.display = 'none'; 
      }
    });

    const noResults = document.getElementById('no-results');
    if (noResults) {
      noResults.style.display = hasVisibleCards ? 'none' : '';
    }
  }
</script>

</body>
</html>
