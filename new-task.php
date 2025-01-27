<?php
session_start();
include './dbh.class.php';

$db = new Dbh();
$conn = $db->connect();

$message = '';
$task_added = false;
$task_updated = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ajout de tâche
    if (isset($_POST['titre']) && isset($_POST['description'])) {
        $titre = trim($_POST['titre']);
        $description = trim($_POST['description']);

        if (empty($titre) || empty($description)) {
            $message = "Veuillez remplir le titre et la description.";
        } else {
            try {
                $stmt = $conn->prepare("INSERT INTO `task`(`title`, `description`, `id_statut`) VALUES (:titre, :description, 1)");
                $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
                $stmt->bindParam(':description', $description, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $message = "Tâche ajoutée avec succès.";
                    $task_added = true;
                } else {
                    $message = "Erreur lors de l'ajout de la tâche.";
                    error_log(print_r($stmt->errorInfo(), true));
                }
            } catch (PDOException $e) {
                $message = "Erreur : " . $e->getMessage();
                error_log($e->getMessage());
            }
        }
    }

    // Modification de tâche
    elseif (isset($_POST['task_id']) && isset($_POST['new_title']) && isset($_POST['new_description']) && isset($_POST['new_status'])) {
        $task_id = intval($_POST['task_id']);
        $new_title = trim($_POST['new_title']);
        $new_description = trim($_POST['new_description']);
        $new_status = intval($_POST['new_status']);

        if (!empty($new_title) && !empty($new_description)) {
            try {
                $stmt = $conn->prepare("UPDATE `task` SET `title` = :new_title, `description` = :new_description, `id_statut` = :new_status WHERE `id_task` = :task_id");
                $stmt->bindParam(':new_title', $new_title, PDO::PARAM_STR);
                $stmt->bindParam(':new_description', $new_description, PDO::PARAM_STR);
                $stmt->bindParam(':new_status', $new_status, PDO::PARAM_INT);
                $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $message = "Tâche modifiée avec succès.";
                    $task_updated = true;
                } else {
                    $message = "Erreur lors de la modification de la tâche.";
                    error_log(print_r($stmt->errorInfo(), true));
                }
            } catch (PDOException $e) {
                $message = "Erreur : " . $e->getMessage();
                error_log($e->getMessage());
            }
        } else {
            $message = "Veuillez remplir tous les champs pour modifier la tâche.";
        }
    }

    // Suppression de tâche
    if (isset($_POST['delete_task_id'])) {
        $task_id = intval($_POST['delete_task_id']);
        try {
            $stmt = $conn->prepare("DELETE FROM `task` WHERE `id_task` = :task_id");
            $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $message = "Tâche supprimée avec succès.";
            } else {
                $message = "Erreur lors de la suppression de la tâche.";
                error_log(print_r($stmt->errorInfo(), true));
            }
        } catch (PDOException $e) {
            $message = "Erreur : " . $e->getMessage();
            error_log($e->getMessage());
        }
    }
}

// Récupération des tâches
try {
    $stmt = $conn->prepare("SELECT t.*, IFNULL(s.nom_statut, 'Non défini') AS nom_statut FROM task t LEFT JOIN statut s ON t.id_statut = s.id_statut");
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des tâches : " . $e->getMessage();
    error_log($e->getMessage());
    $tasks = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a new task</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

    </style>
</head>

<body id='body'>
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
                <a href="./index.php"><img src="./assets/img/logo.png" alt="Logo" class="logo"></a>
                <h1>TaskCollab</h1>
            </div>
            <div class="search-container">
                <input type="search" placeholder="Rechercher..." class="search-input">
                <button class="search-button">
                    <img src="./assets/img/search_7693724.png" alt="Rechercher">
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
            <a class="mx-1" href="./index.php"><img src="./assets/img/home (2).png" alt="Accueil">
                <span>Accueil</span></a>
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

    <nav id="bottom-nav" class="navbar fixed-bottom bg-primary">
        <div class="container-fluid justify-content-around">
            <a class="navbar-brand" href="./index.php">
                <img src="./assets/img/home (2).png" alt="Accueil" class="d-inline-block align-text-top">
                <span class="d-block text-center text-white">Accueil</span>
            </a>
            <a class="navbar-brand" href="#">
                <img src="./assets/img/Capture d'écran 2025-01-24 111742.png" alt="Tâches" class="d-inline-block align-text-top">
                <span class="d-block text-center text-white">Tâches</span>
            </a>
            <div id="plus-2" class="navbar-brand bg-white text-primary">+</div>
            <a class="navbar-brand" href="#">
                <img src="./assets/img/team.png" alt="Équipe" class="d-inline-block align-text-top">
                <span class="d-block text-center text-white">Équipe</span>
            </a>
            <a class="navbar-brand" href="#">
                <img src="./assets/img/setting.png" alt="Réglages" class="d-inline-block align-text-top">
                <span class="d-block text-center text-white">Réglages</span>
            </a>
        </div>
    </nav>


    <div class="padding">
        <div class="custom-container">
            <div class="container mt-5 mx-10">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Nouvelle tâche</h2>

                        <form action="new-task.php" method="POST" id="new-task">
                            <div class="mb-3">
                                <label for="titre" class="form-label"></label>
                                <input type="text" class="form-control" id="titre" name="titre" placeholder="Task Title" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label"></label>
                                <input type="text" class="form-control" id="description" name="description" placeholder="Task Description" required>
                            </div>
                            <div class="mb-3">
                                <label for="due_date" class="form-label">Date d'échéance :</label>
                                <input type="date" class="form-control" id="due_date" name="due_date">
                            </div>
                            <button type="submit" class="add-task btn btn-primary w-100">Ajouter la tâche</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <section class='' id="tasks">
            <?php if (empty($tasks)): ?>
                <p>Aucune tâche pour le moment.</p>
            <?php else: ?>
                <?php foreach ($tasks as $task): ?>
                    <div class="task mx-19" id="task-<?php echo htmlspecialchars($task['id_task']); ?>">
                        <h2><?php echo htmlspecialchars($task['title']); ?></h2>
                        <div class="task-contain"><?php echo htmlspecialchars($task['description']); ?></div>
                        <div class="d-flex">
                            <div class="task-time-limit">
                                <?php if (isset($task['nom_statut'])): ?>
                                    <?php echo htmlspecialchars($task['nom_statut']); ?>
                                <?php else: ?>
                                    Statut non défini
                                <?php endif; ?>
                            </div>
                            <div class="who-do">John Doe</div>
                        </div>

                        <button onclick="showEditForm(<?php echo htmlspecialchars($task['id_task']); ?>)" class="modifier">Modifier</button>
                        <form id="edit-form-<?php echo htmlspecialchars($task['id_task']); ?>" class="edit-form" method="POST" action="">
                            <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task['id_task']); ?>">
                            <input type="text" name="new_title" placeholder="Nouveau titre" value="<?php echo htmlspecialchars($task['title']); ?>" required><br>
                            <input type="text" name="new_description" placeholder="Nouvelle description" value="<?php echo htmlspecialchars($task['description']); ?>" required><br>

                            <select name="new_status">
                                <option value="1" <?php if (isset($task['id_statut']) && $task['id_statut'] == 1) echo 'selected'; ?>>En cours</option>
                                <option value="2" <?php if (isset($task['id_statut']) && $task['id_statut'] == 2) echo 'selected'; ?>>Terminée</option>
                            </select><br>
                            <div class="d-flex">
                            <button type="submit">Enregistrer les modifications</button>
                            <button type="button" onclick="hideEditForm(<?php echo htmlspecialchars($task['id_task']); ?>)">Annuler</button>
                        </form>

                        <form method="POST" action="">
                            <input type="hidden" name="delete_task_id" value="<?php echo htmlspecialchars($task['id_task']); ?>">
                            <button type="submit" id='supprimer'>Supprimer</button>
                        </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </div>


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
</body>

</html>