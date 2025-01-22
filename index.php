<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task-Manager</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

    <div class="top">
        <h1>TaskCollab</h1>
      <div class="user">
        <img src="./assets/img/notification.webp" alt="Notifications">
        <img src="./assets/img/user.webp" alt="User">
    </div>
    </div>
    
    <div class="left-navbar bg-primary px-3 py-5" id="side-bar">
        <div class="nav-item">
            <img src="./assets/img/team.png" alt="Équipe">
            <span>Équipe</span>
        </div>
        <div class="nav-item">
            <img src="./assets/img/home (2).png" alt="Accueil">
            <span>Accueil</span>
        </div>
        <div class="nav-item">
            <img src="./assets/img/setting.png" alt="Paramètres">
            <span>Paramètres</span>
        </div>
        <div class="nav-item">
            <img src="./assets/img/icons8-ce-que-je-fais-50.png" alt="Tâches">
            <span>Tâches</span>
        </div>
        <div class="nav-item">
            <img src="./assets/img/icons8-message-50.png" alt="Messages">
            <span>Messages</span>
        </div>
        <div class="nav-item">
            <img src="./assets/img/logout.png" alt="Déconnexion">
            <span>Déconnexion</span>
        </div>
</div>



    <section id="today-task">
        <div class="flex">
            <h2>Today's Tasks</h2>
            <div id="plus"> + </div>
        </div>
        <div id="statut">
            <div class="statuts">Toutes</div>
            
            <div class="statuts">En cours</div>
            <div class="statuts">Terminées</div>
        </div>

        <section id="tasks">
            <div class="task">
                <h2>Créer la maquette du projet</h2>
                <div class="task-contain">Concevoir l'interface utilisateur pour l'application de gestion de tâches</div>
                <div class="d-flex">
                    <div class="task-time-limit">2 jours restants</div>
                    <div class="who-do">Sarah Miler</div>
                </div>
            </div>

            <div class="task">
                <h2> Réviser les wireframes</h2>
                <div class="task-contain"> Revoir les wireframes pour le design de l'application mobile et proposer des améliorations.</div>
                <div class="d-flex">
                    <div class="task-time-limit-2">7 jours restants</div>
                    <div class="who-do">John Doe</div>
                </div>
            </div>

            <div class="task">
                <h2> Réviser les wireframes</h2>
                <div class="task-contain"> Revoir les wireframes pour le design de l'application mobile et proposer des améliorations.</div>
                <div class="d-flex">
                    <div class="task-time-limit-2">7 jours restants</div>
                    <div class="who-do">John Doe</div>
                </div>
            </div>

          
             
        </section>
    </section>


    <nav id="bottom-nav" class="navbar fixed-bottom bg-light">
        <div class="container-fluid justify-content-around">
          <a class="navbar-brand" href="#">
            <img src="./assets/img/home.webp" alt="Accueil" class="d-inline-block align-text-top">
            <span class="d-block text-center">Accueil</span>
          </a>
          <a class="navbar-brand" href="#">
            <img src="./assets/img/to-do-list.webp" alt="Tâches"  class="d-inline-block align-text-top">
            <span class="d-block text-center">Tâches</span>
          </a>
          <div id="plus-2" class="navbar-brand">+</div>
          <a class="navbar-brand" href="#">
            <img src="./assets/img/group-chat.webp" alt="Équipe"   class="d-inline-block align-text-top">
            <span class="d-block text-center">Équipe</span>
          </a>
          <a class="navbar-brand" href="#">
            <img src="./assets/img/settings.webp" alt="Réglages" class="d-inline-block align-text-top">
            <span class="d-block text-center ">Réglages</span>
          </a>
        </div>
      </nav>


      <footer class="bg-dark text-white mt-5 p-4 text-center  " id='footer'>
        <p>&copy; 2025 TaskCollab. Tous droits réservés.</p>
        <p><a href="https://www.example.com/privacy" class="text-white">Politique de confidentialité</a> | <a href="https://www.example.com/terms" class="text-white">Termes et conditions</a></p>
        <div class="mt-2">
            <a href="https://www.facebook.com" class="text-white me-2"><img src="" alt="Facebook" width="24"></a>
            <a href="https://www.twitter.com" class="text-white me-2"><img src="" alt="Twitter" width="24"></a>
            <a href="https://www.instagram.com" class="text-white"><img src="" alt="Instagram" width="24"></a>
        </div>
    </footer>

      <script src="./assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>