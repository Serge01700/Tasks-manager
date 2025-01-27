<?php
session_start();
include './dbh.class.php';

// Activer l'affichage des erreurs PHP pour débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = new Dbh();
$conn = $db->connect();
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
        $stmt = $conn->prepare("SELECT * FROM user WHERE email= :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['user_name'] = $user['name'];

            header("Location:index.php");
            exit();
        } else {
            $message = 'Email ou mot de passe incorrect';
        }
    } catch (PDOException $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <a href="./inscription.php"><img src="./assets/img/logo.png" alt="Logo" class="logo"></a>
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




    <div id="background" class='flex-container'>
        <div class="login-container">
            <h2 class="text-center custom-color">Connexion</h2>

            <?php if (!empty($message)): ?>
                <p style="color:red"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Se souvenir de moi</label>
                </div>

                <button type="submit" class="btn-login ">Connexion</button>
            </form>

            <div class="text-center mt-3">
                <a href="inscription.php" class="text-decoration-none text-center">Créer un compte</a>
            </div>
        </div>

    </div>
    <footer class="bg-dark text-white py-3 text-center  " id='footer'>
        <p>&copy; 2025 TaskCollab. Tous droits réservés.</p>
        <p><a href="https://www.example.com/privacy" class="text-white">Politique de confidentialité</a> | <a href="https://www.example.com/terms" class="text-white">Termes et conditions</a></p>
        <div class="mt-2">
            <a href="https://www.facebook.com" class="text-white me-2"><img src="" alt="Facebook" width="24"></a>
            <a href="https://www.twitter.com" class="text-white me-2"><img src="" alt="Twitter" width="24"></a>
            <a href="https://www.instagram.com" class="text-white"><img src="" alt="Instagram" width="24"></a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>