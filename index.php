<?php
require './dbh.class.php'  ;


$db = new Dbh();
$conn = $db->connect();
$message = '';

try {
    // Requête SQL améliorée pour récupérer aussi le nom du statut
    $stmt = $conn->prepare("SELECT t.*, s.nom_statut AS statut_nom
                          FROM task t
                          INNER JOIN statut s ON t.id_statut = s.id_statut");
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des tâches : " . $e->getMessage();
    $tasks = [];
}

// Organisation des tâches par statut
$tasks_par_statut = [
    'Toutes' => [],
    'En cours' => [],
    'Terminées' => [],
];

foreach ($tasks as $task) {
    $tasks_par_statut['Toutes'][] = $task;
    $tasks_par_statut[$task['statut_nom']][] = $task;
}

var_dump($e) ;
?> 


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
    <?php if (isset($_SESSION['user_name'])): ?>
        <div class="top-content">
            <p>Bonjour, <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
            <div class="nav-item" id="logout-link">
                <img src="./assets/img/logout.png" alt="Déconnexion">
                <span>Déconnexion</span>
            </div>
        </div>
    <?php else: ?>
         <div class="top-content">
            <img src="./assets/img/logo.png" alt="Logo" class="logo">
            <h1>TaskCollab</h1>
        </div>
        <div class="search-container">
            <input type="search" placeholder="Rechercher..." class="search-input">
            <button class="search-button">
                <img src="#" alt="Rechercher">
            </button>
        </div>
        <div class="user">
            <img src="./assets/img/notification.webp" alt="Notifications" class="notification-icon">
            <img src="./assets/img/user.webp" alt="User" class="user-icon">
        </div>
    <?php endif; ?>
</div>
    
<div class="left-navbar bg-primary px-3 py-5" id="side-bar">
        <div class="nav-item">
            <img src="./assets/img/team.png" alt="Équipe">
            <span>Équipe</span>
        </div>
        <div class="nav-item">
            <a class="mx-1" href="./index.php"><img src="./assets/img/home (2).png" alt="Accueil"></a>
            <span>Accueil</span>
        </div>
        <div class="nav-item">
            <img class="my-2" src="./assets/img/setting.png" alt="Paramètres">
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
        <div class="nav-item" id='logout-link'>
            <img src="./assets/img/logout.png" alt="Déconnexion">
            <span>Déconnexion</span>
        </div>
    </div>



    <section id="today-task">
    <div class="flex">
        <h2>Today's Tasks</h2>
        <a href="./new-task.php"> <div id="plus"> + </div></a>
    </div>
    <div id="statut">
        <div class="statuts active" data-statut="Toutes">Toutes</div>
        <div class="statuts" data-statut="En cours">En cours</div>
        <div class="statuts" data-statut="Terminées">Terminées</div>
    </div>

    <section id="tasks">
        <?php foreach ($tasks_par_statut as $statut => $tasks_du_statut): ?>
            <div class="task-container <?php if ($statut == 'Toutes') echo 'active'; ?>" data-statut="<?= $statut ?>">
                <?php if (empty($tasks_du_statut)): ?>
                    <p>Aucune tâche <?= strtolower($statut) ?> pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($tasks_du_statut as $task): ?>
                        <div class="task mx-19" id="task-<?= htmlspecialchars($task['id_task']) ?>">
                            <h2><?php echo htmlspecialchars($task['title']); ?></h2>
                            <div class="task-contain"><?php echo htmlspecialchars($task['description']); ?></div>
                            <div class="d-flex">
                                <div class="task-time-limit"><?php echo htmlspecialchars($task['statut_nom']); ?></div>
                                <div class="who-do">Sarah</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </section>

   


     

<nav id="bottom-nav" class="navbar fixed-bottom bg-primary">
                <div class="container-fluid justify-content-around">
                <a class="navbar-brand" href="#">
                    <img src="./assets/img/home (2).png" alt="Accueil" class="d-inline-block align-text-top">
                    <span class="d-block text-center text-white">Accueil</span>
                </a>
                <a class="navbar-brand" href="#">
                    <img src="./assets/img/Capture d'écran 2025-01-24 111742.png" alt="Tâches"  class="d-inline-block align-text-top">
                    <span class="d-block text-center text-white">Tâches</span>
                </a>
                <div id="plus-2" class="navbar-brand bg-white text-primary">+</div>
                <a class="navbar-brand" href="#">
                    <img src="./assets/img/team.png" alt="Équipe"   class="d-inline-block align-text-top">
                    <span class="d-block text-center text-white">Équipe</span>
                </a>
                <a class="navbar-brand" href="#">
                    <img src="./assets/img/setting.png" alt="Réglages" class="d-inline-block align-text-top">
                    <span class="d-block text-center text-white">Réglages</span>
                </a>
                </div>
      </nav>


      <footer class="bg-dark text-white py-3 text-center  " id='footer'>
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