<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoToCanada - Accueil</title>

    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Navigation dynamique -->
 <!--
<nav>
    <ul>
        <li><a href="immigration.php">Accueil</a></li>
        <?php if (!isset($_SESSION["user_id"])): ?> 
            <li><a href="register.php">Inscription</a></li>
            <li><a href="login.php">Connexion</a></li>
        <?php else: ?>
            <li><a href="dashboard.php">Mon Espace</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        <?php endif; ?>
    </ul>
</nav>

-->
<header>
    <div class="logo">
        <img src="images/logo.png" alt="GoToCanada Logo">
        <h1>GoToCanada</h1>

    </div>
</header>

<nav>
    <ul class="menu">
        <li class="dropdown">
            <a href="#">Notre firme</a>
                <ul class="submenu">
                    <li><a href="quisommesnous.html">Qui sommes-nous?</a></li>
                    <li><a href="notremission.html">Notre mission</a></li>
                    <li><a href="notreequipe.html">Notre équipe</a></li>
                </ul>
        </li>
        <li class="dropdown">
            <a href="#">Nos services</a>
            <ul class="submenu">
                <li><a href="consultation.html">Consultation</a></li>
                <li><a href="accompagnement.html">Accompagnement</a></li>
                <li><a href="formation.html">Formation</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#">Nous choisir</a>
            <ul class="submenu">
                <li><a href="qualiteduservice.html">Qualité du service</a></li>
                <li><a href="rapportinitial.html">Rapport Initial</a></li>
                <li><a href="cout.html">Coût</a></li>
            </ul>
        </li>
        <li><a href="selectiondesimmigrants.html">Sélection des immigrants</a></li>
        <li><a href="votrearrivee.html">Votre arrivée</a></li>

    </ul>
</nav>


<!-- Debut defilante -->
<!-- Début du carrousel d'images -->
<div class="carousel-container" style="margin-left: auto; margin-right: 350px;">
  <div class="carousel-track">

    <a href="voiture.html" target="_blank">
      <div class="carousel-item">
        <div class="carousel-description">
          <h3>Voiture GOTOCANADA</h3>
          <p>Louez un véhicule dès votre arrivée pour faciliter vos déplacements. Offres spéciales pour les nouveaux arrivants.</p>
          <!--<span class="cta-link">→ En savoir plus</span> -->
        </div>
        <img src="images/voiture.png" alt="Voiture GOTOCANADA">
      </div>
    </a>

    <a href="arrima.html" target="_blank">
      <div class="carousel-item">
        <div class="carousel-description">
          <h3>Inscription Arrima</h3>
          <p>Déposez votre déclaration d’intérêt pour immigrer au Québec via la plateforme officielle Arrima.</p>
          <!--<span class="cta-link">→ En savoir plus</span> -->
        </div>
        <img src="images/ARRIMA.jfif" alt="Arrima">
      </div>
    </a>

    <a href="bureaux.html" target="_blank">
      <div class="carousel-item">
        <div class="carousel-description">
          <h3>Nos Bureaux</h3>
          <p>Retrouvez-nous dans plusieurs pays à travers le monde. Un accompagnement de proximité où que vous soyez.</p>
          <!--<span class="cta-link">→ En savoir plus</span>-->
        </div>
        <img src="images/bureauxmonde.jpg" alt="Bureaux dans le monde">
      </div>
    </a>

    <a href="tef-tcf.html" target="_blank">
      <div class="carousel-item">
        <div class="carousel-description">
          <h3>Préparer le TEF/TCF</h3>
          <p>Formations et tests blancs pour réussir votre test de français obligatoire à l’immigration.</p>
          <!--<span class="cta-link">→ En savoir plus</span>-->
        </div>
        <img src="images/download.png" alt="TEF/TCF">
      </div>
    </a>

    <a href="entreeexpress.html" target="_blank">
      <div class="carousel-item">
        <div class="carousel-description">
          <h3>Entrée Express</h3>
          <p>Immigrez rapidement au Canada grâce au programme fédéral Entrée Express.</p>
          <!--<span class="cta-link">→ En savoir plus</span>-->
        </div>
        <img src="images/EntreeExpress.jfif" alt="Entrée Express">
      </div>
    </a>

    <a href="famille.html" target="_blank">
      <div class="carousel-item">
        <div class="carousel-description">
          <h3>Partir en Famille</h3>
          <p>Découvrez les démarches pour venir au Canada avec vos proches et démarrer une nouvelle vie ensemble.</p>
         <!-- <span class="cta-link">→ En savoir plus</span>-->
        </div>
        <img src="images/Familly.jfif" alt="Famille au Canada">
      </div>
    </a>

    <a href="reunion.html" target="_blank">
      <div class="carousel-item">
        <div class="carousel-description">
          <h3>Réunion Familiale</h3>
          <p>Vous avez de la famille au Canada ? Profitez des programmes de parrainage pour les rejoindre légalement.</p>
          <!--<span class="cta-link">→ En savoir plus</span>-->
        </div>
        <img src="images/reunion.jfif" alt="Réunion familiale">
      </div>
    </a>

    <a href="reunite.html" target="_blank">
      <div class="carousel-item">
        <div class="carousel-description">
          <h3>Reunite Your Family</h3>
          <p>Bring your loved ones to Canada through fast and secure family reunification programs.</p>
          <!--<span class="cta-link">→ Learn more</span>-->
        </div>
        <img src="images/reunitefamily.jfif" alt="Reunite your family">
      </div>
    </a>

  </div>
</div>

<!-- Fin du carrousel -->

<!-- fin image defilante -->


<!-- Section Nouvelles et Promotions -->
<div class="news-promo-section">
  <div class="news-column">
    <h2>❯ NOUVELLES</h2>

    <div class="news-item">
      <img src="images/paques.jfif" >
      <div>
        <h4>Joyeuses fêtes de Pâques à Trois-Rivières !</h4>
        <a href="https://ici.radio-canada.ca/nouvelle/2158663/laicite-eveque-trois-rivieres-paques">› Lire la suite</a>
        <p class="news-date">Publiée le 20 avril 2025</p>
      </div>
    </div>

    <div class="news-item">
      <img src="images/graduate.png" alt="Université">
      <div>
        <h4>Les universités canadiennes obtiennent des meilleurs classements dans le monde</h4>
        <a href="https://www.cicnews.com/2025/03/canadian-universities-achieve-top-worldwide-rankings-for-several-subjects-0353395.html">› Lire la suite</a>
        <p class="news-date">Publiée le 30 mars 2025</p>
      </div>
    </div>

    <div class="news-item">
      <img src="images/logo.png" alt="Entrée express">
      <div>
        <h4>Le Canada prend des mesures pour réduire la fraude chez les demandeurs de visa Etudiants</h4>
        <a href="https://ici.radio-canada.ca/info/long-format/2153789/universite-uqac-fraude-reseau-immigration">› Lire la suite</a>
        <p class="news-date">Publiée le 27 mars 2025</p>
      </div>
    </div>

    <div class="news-item">
      <img src="images/arrima-blue.png" alt="Arrima">
      <div>
        <h4>Suspension du programme ARRIMA pour une durée de 6 mois</h4>
        <a href="https://www.quebec.ca/immigration/permanente/travailleurs-qualifies/programme-selection-travailleurs-qualifies/a-propos">› Lire la suite</a>
        <p class="news-date">Publiée le 26 mars 2025</p>
      </div>
    </div>
  </div>

  <div class="promo-column">
    <h2>❯ PROMOTIONS</h2>

    <div class="promo-item">
      <strong>PROMOTION Bureau de CANADA</strong>
      <p>Jusqu’à 15% de Réduction sur les honoraires de Demandes Officielles !</p>
  
    </div>

    <div class="promo-item">
      <strong>PROMOTION Bureau de CÔTE D'IVOIRE</strong>
      <p>Jusqu’à 15% de Réduction sur les honoraires de Demandes Officielles !</p>
  
    </div>

    <div class="promo-item">
      <strong>PROMOTION Bureau du Togo</strong>
      <p>Jusqu’à 15% de Réduction sur les honoraires de Demandes Officielles !</p>
  
    </div>

    <div class="promo-item">
      <strong>PROMOTION Bureau du CAMEROUN</strong>
      <p>Jusqu’à 15% de Réduction sur les honoraires de Demandes Officielles !</p>

    </div>
  </div>
</div>








<div class="container" style="position: relative; top: -1170px; margin-left: 70px; margin-right: 20px;">




    <!-- Espace client -->
    <div class="client-space">
        <h2>Espace Client</h2>
        <p>Connectez-vous pour accéder à votre dossier.</p>
        
        
        
        <form action="login.php" method="post">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" placeholder="Entrez votre email" required>
            
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
            
            <input type="submit" value="Se connecter">
        </form>
        <p>Pas encore inscrit ? <a href="#" id="show-register">Créer un compte</a></p>

 
    <!-- Div Administrateur -->
    <a href="admin_login.php" target="_blank">Administrateur</a>

    </div>

    <!-- Espace inscription -->
    <div class="register-space" style="display:none;">
        <h2>Inscription</h2>
        <p>Créez un compte pour accéder à l’espace client.</p>
        <form action="register.php" method="post">
            <label for="name">Nom et Prenom :</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <!--<label for="new-identification">Code d'identification :</label>-->
            <!--<input type="text" id="new-identification" name="new-identification" required>-->

            <label for="new-password">Mot de passe :</label>
            <input type="password" id="new-password" name="new-password" required>

            <label for="confirm-password">Confirmer le mot de passe :</label>
            <input type="password" id="confirm-password" name="confirm-password" required>

            <input type="submit" value="S'inscrire">
        </form>
        <p>Déjà inscrit ? <a href="#" id="show-login">Se connecter</a></p>
    </div>
</div>

<!-- jQuery pour basculer entre connexion et inscription -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $(".register-space").hide();

        $("#show-register").click(function(event) {
            event.preventDefault();
            $(".client-space").hide();
            $(".register-space").fadeIn();
        });

        $("#show-login").click(function(event) {
            event.preventDefault();
            $(".register-space").hide();
            $(".client-space").fadeIn();
        });
    });
</script>

<!-- Liste des bureaux -->
<div class="sidebar">
        <h3>Nos bureaux</h3>
        <ul>
            <li>
                <a href="#" id="show-canada">Canada</a>
                <div id="canada-info" class="info-box">
                    <button id="close-canada" class="close-btn">&times;</button>
        
                    <div class="header-box">
                        <p>📍 <strong>Bureau de Montréal</strong></p>
                    </div>
                    <p><strong>Adresse :</strong> 304 rue St-Antoine Est, Montréal</p>
                    <p>📅 <strong>Heures d'ouverture :</strong> Sur rendez-vous seulement</p>
                    <p>ℹ️ <strong>Horaire spécial :</strong> Ce bureau est uniquement un centre technique et administratif non ouvert au public.</p>
                    <p>📞 <strong><span style="color:#FF4081;">Téléphone :</span></strong> <a href="tel:15148589276">1 (514) 858-9276</a></p>
                    <p>📧 <strong><span style="color:#FF4081;">Email :</span></strong> <a href="mailto:nkondje@yahoo.fr" class="blue-text">nkondje@yahoo.fr</a></p>
                </div>
            </li>
        
            <li>
                <a href="#" id="show-burkina">Burkina Faso</a>
                <div id="burkina-info" class="info-box">
                    <button id="close-burkina" class="close-btn">&times;</button>
        
                    <div class="header-box">
                        <p>📍 <strong>Bureau de Ouagadougou</strong></p>
                    </div>
                    <p><strong>Adresse :</strong> Avenue Kwamé Nkrumah, Immeuble Faso Plaza, 3ème étage, Ouagadougou</p>
                    <p>📅 <strong>Heures d'ouverture :</strong> Lundi - Vendredi : 08h00 - 17h00</p>
                    <p>ℹ️ <strong>Horaire spécial :</strong> Accueil sur rendez-vous uniquement les samedis.</p>
                    <p>📞 <strong><span style="color:#FF4081;">Téléphone :</span></strong> <a href="tel:+22650505050">+226 50 50 50 50</a></p>
                    <p>📧 <strong><span style="color:#FF4081;">Email :</span></strong> <a href="mailto:contact@burkina-immigration.com" class="blue-text">contact@burkina-immigration.com</a></p>
                </div>
            </li>
            
            <li>
                <a href="#" id="show-douala">Cameroun - Douala</a>
                <div id="douala-info" class="info-box">
                    <button id="close-douala" class="close-btn">&times;</button>
            
                    <div class="header-box">
                        <p>📍 <strong>Bureau de Douala</strong></p>
                    </div>
                    <p><strong>Adresse :</strong> Boulevard de la Liberté, Immeuble Atlantic Plaza, 2ème étage, Douala</p>
                    <p>📅 <strong>Heures d'ouverture :</strong> Lundi - Vendredi : 08h00 - 17h30</p>
                    <p>ℹ️ <strong>Horaire spécial :</strong> Consultation sur rendez-vous les samedis.</p>
                    <p>📞 <strong><span style="color:#FF4081;">Téléphone :</span></strong> <a href="tel:+237233445566">+237 233 44 55 66</a></p>
                    <p>📧 <strong><span style="color:#FF4081;">Email :</span></strong> <a href="mailto:contact@douala-immigration.com" class="blue-text">contact@douala-immigration.com</a></p>
                </div>
            </li>


        
            <li>
                <a href="#" id="show-abidjan">Côte d'Ivoire - Abidjan</a>
                <div id="abidjan-info" class="info-box">
                    <button id="close-abidjan" class="close-btn">&times;</button>
                    <div class="header-box">
                        <p>📍 <strong>Bureau d'Abidjan</strong></p>
                    </div>
                    <p><strong>Adresse :</strong> Plateau, Immeuble Tour Alpha, 5ème étage, Abidjan</p>
                    <p>📅 <strong>Heures d'ouverture :</strong> Lundi - Vendredi : 08h00 - 18h00</p>
                    <p>ℹ️ <strong>Horaire spécial :</strong> Consultations sur rendez-vous le samedi matin.</p>
                    <p>📞 <strong><span style="color:#FF4081;">Téléphone :</span></strong> <a href="tel:+2250102030405">+225 01 02 03 04 05</a></p>
                    <p>📧 <strong><span style="color:#FF4081;">Email :</span></strong> <a href="mailto:contact@abidjan-immigration.com" class="blue-text">contact@abidjan-immigration.com</a></p>
                </div>
            </li>
        
            <li>
                <a href="#" id="show-lome">Togo - Lomé</a>
                <div id="lome-info" class="info-box">
                    <button id="close-lome" class="close-btn">&times;</button>
                    <div class="header-box">
                        <p>📍 <strong>Bureau de Lomé</strong></p>
                    </div>
                    <p><strong>Adresse :</strong> Avenue du Golfe, Immeuble Prestige, 4ème étage, Lomé</p>
                    <p>📅 <strong>Heures d'ouverture :</strong> Lundi - Vendredi : 08h00 - 17h30</p>
                    <p>ℹ️ <strong>Horaire spécial :</strong> Assistance VIP sur rendez-vous le week-end.</p>
                    <p>📞 <strong><span style="color:#FF4081;">Téléphone :</span></strong> <a href="tel:+22890909090">+228 90 90 90 90</a></p>
                    <p>📧 <strong><span style="color:#FF4081;">Email :</span></strong> <a href="mailto:contact@lome-immigration.com" class="blue-text">contact@lome-immigration.com</a></p>
                </div>
            </li>
        
            <li>
                <a href="#" id="show-dakar">Sénégal - Dakar</a>
                <div id="dakar-info" class="info-box">
                    <button id="close-dakar" class="close-btn">&times;</button>
                    <div class="header-box">
                        <p>📍 <strong>Bureau de Dakar</strong></p>
                    </div>
                    <p><strong>Adresse :</strong> Centre Ville, Immeuble Renaissance, 6ème étage, Dakar</p>
                    <p>📅 <strong>Heures d'ouverture :</strong> Lundi - Vendredi : 08h30 - 17h30</p>
                    <p>ℹ️ <strong>Horaire spécial :</strong> Service prioritaire sur rendez-vous en soirée.</p>
                    <p>📞 <strong><span style="color:#FF4081;">Téléphone :</span></strong> <a href="tel:+22130303030">+221 30 30 30 30</a></p>
                    <p>📧 <strong><span style="color:#FF4081;">Email :</span></strong> <a href="mailto:contact@dakar-immigration.com" class="blue-text">contact@dakar-immigration.com</a></p>
                </div>
            </li>
        </ul>
    </div>
    
    <!-- jQuery pour afficher et cacher l'encadré -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function toggleInfo(showButtonId, infoBoxId, closeButtonId) {
                const showButton = document.getElementById(showButtonId);
                const infoBox = document.getElementById(infoBoxId);
                const closeButton = document.getElementById(closeButtonId);
    
                showButton.addEventListener("click", function (event) {
                    event.preventDefault();
                    infoBox.style.display = "block"; // Afficher l'encadré
                });
    
                closeButton.addEventListener("click", function () {
                    infoBox.style.display = "none"; // Masquer l'encadré
                });
            }
    
            // Associer les boutons aux encadrés
            toggleInfo("show-canada", "canada-info", "close-canada");
            toggleInfo("show-burkina", "burkina-info", "close-burkina");
            toggleInfo("show-douala", "douala-info", "close-douala");
            toggleInfo("show-abidjan", "abidjan-info", "close-abidjan");
            toggleInfo("show-lome", "lome-info", "close-lome");
            toggleInfo("show-dakar", "dakar-info", "close-dakar");
        });
    </script>

<footer>
    <p>📩 Besoin d’aide pour votre projet d’immigration ? Contactez nos bureaux dès aujourd’hui ! 🇨🇦🚀</p>
    <p>© 2024 Go To Canada - Tous droits réservés.</p>
</footer>

</body>
</html>
