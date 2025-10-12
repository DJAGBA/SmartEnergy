<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail Client CEET</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo_ceet.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        :root {
            --primary: #F59E0B; /* jaune principal */
            --primary-dark: #D97706; /* jaune foncé */ 
            --secondary: #222222;
            --light: #F8FAFC;
            --dark: #1E293B;
            --gray: #64748B;
            --accent:#FBBF24; /* accent jaune */ 
            --success: #10B981;
            --warning: #F59E0B;
            --error: #EF4444;
            --border: #E2E8F0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background-color: #ffffff;
            color: var(--dark);
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        
        header {
            background-color: white;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        header .container {
            max-width: 1100px;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }
        
        /* Suppression des liens de navigation demandée */
        .nav-links {
            display: none; 
        }

        .header-content img[alt="Logo CEET"] {
            height: 56px !important;
        }
        
        .login-btn, .logout-btn {
            background-color: var(--primary);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .login-btn:hover, .logout-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Styles généraux pour le main et sections */
        main {
            padding: 3rem 0;
        }
        
        .section {
            background-color: white;
            border-radius: 12px;
            padding: 2.5rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            transition: opacity 0.3s ease;
        }

        .section-title {
            font-size: 1.5rem;
            color: #5b3203ff;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        /* Styles de désactivation pour l'avis client */
        .section-disabled {
            position: relative;
            opacity: 0.5;
            pointer-events: none;
        }

        .section-disabled::after {
            content: 'Abonnez-vous aux alertes pour laisser un avis';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.7);
            color: var(--dark);
            font-weight: 600;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            z-index: 50;
            padding: 2.5rem;
            text-align: center;
        }
        .horizontal-scroll {
    display: flex;
    overflow-x: auto;
    gap: 1.5rem;
    padding-bottom: 1rem;
    scroll-behavior: smooth;
}

.horizontal-scroll > * {
    flex-shrink: 0;
    min-width: 280px;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1.5rem;
    background-color: white;
}
        
        /* Styles des formulaires et boutons */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.3);
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background-color: var(--primary);
            color: white;
            padding: 0.875rem 1.75rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        /* Styles du Hero (Image de fond) */
        .hero-about {
            background-image: url('{{ asset('image/image.png') }}');
            background-size: cover;
            background-position: top center;
            background-repeat: no-repeat;
            position: relative;
            margin-bottom: 3rem;
            color: white;
            width: 100vw;
            margin-left: calc(49% - 50vw);
            margin-right: calc(49% - 50vw);
            overflow: hidden;
            min-height: clamp(360px, 60vh, 720px);
        }

        .hero-about .overlay {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 5rem 2rem;
            border-radius: inherit;
            height: 100%;
            min-height: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* --- STYLES DU FOOTER AJOUTÉS/CORRIGÉS --- */
        footer {
            background-color: var(--secondary);
            color: var(--light);
            padding: 3rem 0 1rem 0;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-section h3 {
            font-size: 1.25rem;
            color: var(--primary);
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .hero-about {
    position: relative;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    border-radius: 12px;
    overflow: hidden;
}

.overlay {
    position: absolute;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.4); /* Fond noir semi-transparent */
    display: flex;
    align-items: center;
    justify-content: center;
}

.content {
    text-align: center;
    padding: 5rem 1.5rem;
    max-width: 800px;
    margin: 0 auto;
    color: #ffffff; /* Texte par défaut en blanc */
}

.content h2 {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 1rem;
    line-height: 1.3;
    letter-spacing: 0.5px;
    color: #f4d27a; /* Titre principal en jaune sable */
}

.content .subtitle {
    font-size: 1.125rem;
    font-weight: 500;
    margin-bottom: 2rem;
}

.content h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.content .about-text {
    font-size: 1rem;
    line-height: 1.6;
    max-width: 600px;
    margin: 0 auto;
}

        .footer-contact p,
        .footer-links li {
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links a {
            color: var(--light);
            text-decoration: none;
            transition: color 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        .footer-social {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .footer-social a {
            color: var(--light);
            font-size: 1.5rem;
            transition: color 0.3s, transform 0.3s;
            padding: 0.5rem;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            line-height: 0;
        }

        .footer-social a:hover {
            color: var(--primary);
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        .footer-social .login-btn {
            background-color: #dc2626; /* Rouge pour le bouton de connexion */
            color: white;
            font-size: 1rem;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            line-height: 1;
        }

        .footer-social .login-btn:hover {
            background-color: #b91c1c;
            color: white;
            transform: translateY(-2px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 1rem;
            font-size: 0.85rem;
            color: var(--gray);
        }
        /* ------------------------------------------- */


        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <a href="/">
                    <img src="{{ asset('images/ceet.png') }}" alt="" style="height:50px;">
                </a>
                
                <div class="nav-actions">
                    <div class="nav-links">
                        {{-- Liens masqués --}}
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container">
        <section class="hero-about relative bg-cover bg-center bg-no-repeat" style="background-image: url('/images/3.webp');">
    <div class="overlay absolute inset-0 bg-black bg-opacity-40">
        <div class="content text-[#f4d27a] text-center py-20 px-6 max-w-4xl mx-auto">
            <h2 class="text-4xl font-bold mb-4 leading-tight tracking-wide">
                Votre portail client CEET
            </h2>
            <p class="subtitle text-lg mb-8 font-medium">
                Gérez vos services d'électricité en toute simplicité
            </p>
            <h3 class="text-2xl font-semibold mb-4">
                À propos de la CEET
            </h3>
            <p class="about-text text-base leading-relaxed">
                La Compagnie Énergie Électrique du Togo (CEET) est le principal distributeur d'électricité au Togo.
                À travers ce portail, elle renforce sa communication avec les clients en leur offrant un accès direct
                aux informations sur les coupures programmées, les alertes personnalisées et les retours d'expérience.
            </p>
        </div>
    </div>
</section>
        
      <section class="section bg-yellow-50" id="coupures-programmees">
    <h2 class="section-title">Coupures programmées</h2>

    <div class="horizontal-scroll">
        @forelse($coupures as $coupure)
            @php
                $zoneNom = $coupure->zone->nom ?? 'Zone inconnue';
                $date = \Carbon\Carbon::parse($coupure->date_debut)->format('d/m/Y');
                $heureDebut = \Carbon\Carbon::parse($coupure->date_debut)->format('H\h');
                $heureFin = \Carbon\Carbon::parse($coupure->date_fin)->format('H\h');
                $duree = \Carbon\Carbon::parse($coupure->date_debut)->diffInMinutes($coupure->date_fin);
                $motif = ucfirst($coupure->motif);
            @endphp

            <div>
                <div class="font-semibold text-base mb-2">{{ $zoneNom }}</div>
                <div><strong>Date :</strong> {{ $date }}</div>
                <div><strong>Heure :</strong> {{ $heureDebut }} à {{ $heureFin }}</div>
                <!-- <div><strong>Durée :</strong> {{ $duree }} min</div> -->
                <div><strong>Motif :</strong> {{ $motif }}</div>
            </div>
        @empty
            <p class="text-black text-center">Aucune coupure programmée pour le moment.</p>
        @endforelse
    </div>
</section>
<section class="section" id="services">
            <h2 class="section-title"><i class="fas fa-search"></i> Rechercher une coupure</h2>
            <p>Besoin de vérifier une coupure ? Entrez simplement votre **référence client** ou l’adresse concernée pour obtenir les informations en un clin d’œil.</p>
<form method="GET" action="{{ route('coupures.recherche') }}">
    <div class="form-grid">
        <div class="form-group">
            <label class="form-label">Référence client</label>
            <input type="text" name="reference" class="form-input" placeholder="Ex: 12345678">
        </div>
        <div class="form-group">
            <label class="form-label">Adresse</label>
            <input type="text" name="adresse" class="form-input" placeholder="Ex: Tokoin Gbonvié">
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn"><i class="fas fa-search"></i> Rechercher</button>
    </div>
</form>
        </section>

        <!-- <section class="section" id="alertes">
            <h2 class="section-title"><i class="fas fa-bell"></i> S'abonner aux alertes</h2>
            <p class="text-gray-700 mb-4">Entrez votre **référence client** pour vérifier vos informations et choisir votre canal de communication préféré (SMS ou E-mail).</p>

            <div x-data="{ refClient: '', isDataLoaded: false, phone: '', email: '', preferredMode: 'sms' }">
                <div class="form-group">
                    <label class="form-label" for="alert_ref_client">Référence client</label>
                    <input type="text" id="alert_ref_client" x-model="refClient" class="form-input" placeholder="12345678" required>
                </div>

                <div class="form-actions">
                    {{-- Simule l'action de recherche et charge les données --}}
                    <button type="button" @click="isDataLoaded = true; phone='90 00 00 00'; email='client@exemple.com';" class="btn"><i class="fas fa-user-check"></i> Vérifier</button>
                </div>
                
                {{-- Affichage des informations et du choix après vérification --}}
                <div x-show="isDataLoaded" x-transition:enter.duration.500ms>
                    <div class="alert-info">
                        <i class="fas fa-check-circle text-lg"></i>
                        <div>
                            <p class="font-bold">Informations récupérées :</p>
                            <p>Téléphone : <span x-text="phone"></span></p>
                            <p>E-mail : <span x-text="email"></span></p>
                            <p class="mt-2">Veuillez choisir votre canal d'alerte :</p>
                        </div>
                    </div>

                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" x-model="preferredMode" id="sms-alerts" value="sms">
                            <label for="sms-alerts">Recevoir des alertes par SMS (<span x-text="phone"></span>)</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" x-model="preferredMode" id="email-alerts" value="email">
                            <label for="email-alerts">Recevoir des alertes par E-mail (<span x-text="email"></span>)</label>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn"><i class="fas fa-sync-alt"></i> Mettre à jour l'abonnement</button>
                    </div>
                </div>
            </div>
        </section> -->

        {{-- Définissez cette variable dans votre contrôleur Laravel pour contrôler l'accès --}}
        @php 
            // METTEZ $isAlertSubscriber À TRUE SI LE CLIENT EST ABONNÉ, FALSE SINON.
            $isAlertSubscriber = false; 
        @endphp 

        <!-- <section class="section @if(!$isAlertSubscriber) section-disabled @endif" id="avis">
            <h2 class="section-title"><i class="fas fa-comment-dots"></i> Donner mon avis après une coupure</h2>
            <p class="text-gray-600 mb-4">Votre avis nous aide à améliorer la qualité du service. Merci de nous indiquer les détails de la coupure que vous avez vécue.</p>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Référence client</label>
                    {{-- Le champ est désactivé et pré-rempli si l'utilisateur est connu/authentifié --}}
                    <input type="text" class="form-input" placeholder="12345678" value="12345678" disabled>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Date de la coupure</label>
                    <input type="date" name="outage_date" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Quartier concerné</label>
                    <select class="form-input" required>
                        <option value="">Sélectionnez un quartier</option>
                        {{-- Liste des quartiers chargés dynamiquement --}}
                    </select>
                </div>
            </div>
        
            <div class="form-group">
                <label for="note">Votre satisfaction :</label>
                <select name="note" id="note" class="form-input" required>
                    <option value="5">⭐⭐⭐⭐⭐ Très satisfait</option>
                    <option value="4">⭐⭐⭐⭐ Satisfait</option>
                    <option value="3">⭐⭐⭐ Moyennement satisfait</option>
                    <option value="2">⭐⭐ Peu satisfait</option>
                    <option value="1">⭐ Pas du tout satisfait</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Commentaire</label>
                <textarea class="form-input" rows="4" placeholder="Votre avis..." required></textarea>
            </div>
            
            <div class="form-actions">
                <button class="btn"><i class="fas fa-paper-plane"></i> Envoyer mon avis</button>
            </div>
        </section> -->

    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section" id="contact">
                    <h3>Contact CEET</h3>
                    <div class="footer-contact">
                        <p><i class="fas fa-phone"></i> +228 22 21 27 44 / Fax: +228 22 21 64 98</p>
                        <p><i class="fas fa-phone"></i> Dépannage: +228 22 20 82 20</p>
                        <p><i class="fas fa-envelope"></i> contact@ceet.tg</p>
                        <p><i class="fas fa-map-marker-alt"></i> Lomé, Togo</p>
                    </div>
                </div>
                <div class="footer-section" id="liens-utiles">
                    <h3>Liens utiles</h3>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-question-circle"></i> FAQ</a></li>
                        <li><a href="#"><i class="fas fa-file-alt"></i> Conditions d'utilisation</a></li>
                        <li><a href="#"><i class="fas fa-shield-alt"></i> Politique de confidentialité</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Suivez-nous</h3>
                    <p>Restez connecté avec la CEET sur les réseaux sociaux</p>
                    <div class="footer-social">
                        <a href="https://www.facebook.com/ceettogofficiel" target="_blank" aria-label="Page Facebook de la CEET"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/ceettogoofficiel/" target="_blank" aria-label="Compte Instagram de la CEET"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/@CEETTOGOOFFICIEL" target="_blank" aria-label="Chaîne YouTube de la CEET"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 CEET - Tous droits réservés</p>
            </div>
        </div>
    </footer>
</body>
</html>